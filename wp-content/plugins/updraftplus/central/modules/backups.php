<?php

if (!defined('UPDRAFTCENTRAL_CLIENT_DIR')) die('No access.');

/**
 * Handles Backups Commands
 */
class UpdraftCentral_Backups_Commands extends UpdraftCentral_Commands {

	private $switched = false;

	/**
	 * Function that gets called before every action
	 *
	 * @param string $command    a string that corresponds to UDC command to call a certain method for this class.
	 * @param array  $data       an array of data post or get fields
	 * @param array  $extra_info extrainfo use in the udrpc_action, e.g. user_id
	 *
	 * link to udrpc_action main function in class UpdraftCentral_Listener
	 */
	public function _pre_action($command, $data, $extra_info) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- This function is called from listener.php and $extra_info is being sent.
		// Here we assign the current blog_id to a variable $blog_id
		$blog_id = get_current_blog_id();
		if (!empty($data['site_id'])) $blog_id = $data['site_id'];
	
		if (function_exists('switch_to_blog') && is_multisite() && $blog_id) {
			$this->switched = switch_to_blog($blog_id);
		}
	}
	
	/**
	 * Function that gets called after every action
	 *
	 * @param string $command    a string that corresponds to UDC command to call a certain method for this class.
	 * @param array  $data       an array of data post or get fields
	 * @param array  $extra_info extrainfo use in the udrpc_action, e.g. user_id
	 *
	 * link to udrpc_action main function in class UpdraftCentral_Listener
	 */
	public function _post_action($command, $data, $extra_info) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- Unused parameter is present because the caller from UpdraftCentral_Listener class uses 3 arguments.
		// Here, we're restoring to the current (default) blog before we switched
		if ($this->switched) restore_current_blog();
	}

	/**
	 * Retrieves the UpdraftPlus plugin status, UpdraftVault storage usage status, Next backup
	 * schedule, etc. Used primarily by UpdraftCentral background process.
	 *
	 * @return array
	 */
	public function get_status() {

		if (!current_user_can('manage_options')) {
			$response = array(
				'status' => 'error',
				'error_code' => 'insufficient_permission',
			);
		} else {

			if (!function_exists('get_mu_plugins')) include_once(ABSPATH.'wp-admin/includes/plugin.php');
			$mu_plugins = get_mu_plugins();

			$is_premium = false;
			if (defined('UPDRAFTPLUS_DIR') && file_exists(UPDRAFTPLUS_DIR.'/udaddons')) $is_premium = true;

			// Set default response
			$response = array(
				'updraftplus_version' => '',
				'is_premium' => $is_premium,
				'installed' => false,
				'active' => false,
				'backup_count' => 0,
				'has_mu_plugins' => !empty($mu_plugins) ? true : false,
				'last_backup' => array(
					'backup_nonce' => '',
					'has_errors' => false,
					'has_warnings' => false,
					'has_succeeded' => false,
				),
				'updraftvault' => array(
					'site_connected' => false,
					'storage' => array('quota_used' => '0 MB', 'quota' => '0 MB', 'percentage_usage' => '0.0%'),
				),
				'meta' => array(),
			);

			if (class_exists('UpdraftPlus')) {
				global $updraftplus;

				$response['updraftplus_version'] = $updraftplus->version;
				$response['updraftvault'] = $this->get_updraftvault_status();
				$response['installed'] = true;
				$response['active'] = true;
				$response['meta'] = $this->get_filesystem_credentials_info();

				$schedule = $this->get_next_backup_schedule();
				if ($schedule) {
					$response['next_backup_schedule'] = $schedule;
				}

				$backup_history = UpdraftPlus_Backup_History::add_jobdata(UpdraftPlus_Backup_History::get_history());

				$response['backup_count'] = count($backup_history);

				$updraft_last_backup = UpdraftPlus_Options::get_updraft_option('updraft_last_backup');
				if ($updraft_last_backup) {
					$response['last_backup']['backup_nonce'] = $updraft_last_backup['backup_nonce'];
					if (isset($updraft_last_backup['backup_time'])) {
						$response['last_backup']['backup_date'] = gmdate('n/j/Y', $updraft_last_backup['backup_time']);
					}
				
					$errors = 0;
					$warnings = 0;
					
					if (is_array($updraft_last_backup['errors'])) {
						foreach ($updraft_last_backup['errors'] as $err) {
							$level = (is_array($err)) ? $err['level'] : 'error';
							if ('warning' == $level) {
								$warnings++;
							} elseif ('error' == $level) {
								$errors++;
							}
						}
					}

					if ($errors > 0) $response['last_backup']['has_errors'] = true;
					if ($warnings > 0) $response['last_backup']['has_warnings'] = true;
					if (isset($updraft_last_backup['success']) && $updraft_last_backup['success']) $response['last_backup']['has_succeeded'] = true;
				}

			} else {
				if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
				$plugins = get_plugins();
				$key = 'updraftplus/updraftplus.php';

				if (array_key_exists($key, $plugins)) {
					$response['installed'] = true;
					if (is_plugin_active($key)) $response['active'] = true;
				}
			}
		}

		return $this->_response($response);
	}

	/**
	 * Retrieves the next backup schedule for Files and Database backups
	 *
	 * @return string
	 */
	private function get_next_backup_schedule() {

		// Get the next (nearest) scheduled backups
		$files = wp_next_scheduled('updraft_backup');
		$db = wp_next_scheduled('updraft_backup_database');

		if ($files && $db) {
			$timestamp = min($files, $db); // Get the nearest schedule among the two schedules
		} elseif ($files && !$db) {
			$timestamp = $files;
		} elseif (!$files && $db) {
			$timestamp = $db;
		} else {
			$timestamp = null;
		}

		if (!empty($timestamp)) {
			return gmdate('g:i A - D', $timestamp);
		}

		return false;
	}

	/**
	 * Retrieves the UpdrafVault storage usage status
	 *
	 * @return array
	 */
	private function get_updraftvault_status() {

		if (!class_exists('UpdraftCentral_UpdraftVault_Commands')) {
			include_once(UPDRAFTPLUS_DIR.'/includes/updraftvault.php');
		}

		$updraftvault = new UpdraftCentral_UpdraftVault_Commands($this->rc);
		$creds = $updraftvault->get_credentials();

		$site_connected = false;
		$storage = array('quota_used' => '0 MB', 'quota' => '0 MB', 'percentage_usage' => '0.0%');
		$remote_service = false;
		
		if (isset($creds['data'])) {
			if (!isset($creds['data']['error']) && isset($creds['data']['accesskey'])) {
				$site_connected = true;

				$storage_objects_and_ids = UpdraftPlus_Storage_Methods_Interface::get_storage_objects_and_ids(array('updraftvault'));

				if (isset($storage_objects_and_ids['updraftvault']['instance_settings'])) {
					$instance_settings = $storage_objects_and_ids['updraftvault']['instance_settings'];
					$instance_id = key($instance_settings);
					$opts = $instance_settings[$instance_id];

					if (!class_exists('UpdraftPlus_BackupModule_updraftvault')) {
						include_once(UPDRAFTPLUS_DIR.'/methods/updraftvault.php');
					}

					$vault = new UpdraftPlus_BackupModule_updraftvault();
					$vault->set_options($opts, false, $instance_id);

					$quota_root = $opts['quota_root'];
					$quota = $opts['quota'];

					if (empty($quota_root)) {
						// This next line is wrong: it lists the files *in this site's sub-folder*, rather than the whole Vault
						$current_files = $vault->listfiles('');
					} else {
						$current_files = $vault->listfiles_with_path($quota_root, '', true);
					}

					if (!is_wp_error($current_files) && is_array($current_files)) {
						$quota_used = 0;
						foreach ($current_files as $file) {
							$quota_used += $file['size'];
						}

						$storage = array(
							'quota_used' => round($quota_used / 1048576, 1).' MB',
							'quota' => round($quota / 1048576, 1).' MB',
							'percentage_usage' => sprintf('%.1f', 100*$quota_used / $quota).'%',
						);

						$remote_service = array(
							'name' => 'updraft_include_remote_service_updraftvault',
							'value' => $instance_id,
						);
					}
				}
			}
		}

		return array(
			'site_connected' => $site_connected,
			'storage' => $storage,
			'remote_service' => $remote_service,
		);
	}

	/**
	 * Retrieves information whether filesystem credentials (e.g. FTP/SSH) are required
	 * when updating plugins
	 *
	 * @return array
	 */
	private function get_filesystem_credentials_info() {

		if (!function_exists('get_filesystem_method')) {
			include_once(ABSPATH.'/wp-admin/includes/file.php');
		}
		
		$filesystem_method = get_filesystem_method(array(), WP_PLUGIN_DIR);
		
		ob_start();
		$filesystem_credentials_are_stored = request_filesystem_credentials(site_url());
		$filesystem_form = strip_tags(ob_get_contents(), '<div><h2><p><input><label><fieldset><legend><span><em>');
		ob_end_clean();

		$request_filesystem_credentials = ('direct' != $filesystem_method && !$filesystem_credentials_are_stored);

		return array(
			'request_filesystem_credentials' => $request_filesystem_credentials,
			'filesystem_form' => base64_encode($filesystem_form),
		);
	}

	/**
	 * Retrieves the backup progress in terms of entities completed. Used primarily by UpdraftCentral
	 * for polling backup progress in the background.
	 *
	 * @param array $params Submitted arguments for the current request
	 * @return array
	 */
	public function get_backup_progress($params) {

		$nonce = isset($params['nonce']) ? $params['nonce'] : false;
		$response = array('nonce' => $params['nonce']);

		if (!current_user_can('manage_options')) {
			$response['status'] = 'error';
			$response['error_code'] = 'insufficient_permission';
		} else {
			global $updraftplus;

			if ($nonce && $updraftplus && is_a($updraftplus, 'UpdraftPlus')) {

				// Check the job is not still running.
				$jobdata = $updraftplus->jobdata_getarray($nonce);
			
				$response['status'] = 'idle'; // It's very rare to receive this in the UI as status. If it happens then that would mean that no backup has been done for the given nonce even if we initially received it from the "backupnow" request. Possible cause would be, is that the server is too busy or something happened in between calls.

				if (!empty($jobdata)) {
					$response['status'] = 'in-progress';

					$file_entities = 0;
					$db_entities = 0;
					$processed = 0;

					if (isset($jobdata['backup_database']) && 'no' != $jobdata['backup_database']) {
						$backup_database = $jobdata['backup_database'];
						$db_entities += count($backup_database);

						foreach ($backup_database as $whichdb => $info) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- In this check we only need the status contained in the $info for now.
							$status = $info; // For default: 'wp'
							if (is_array($info)) {
								$status = $info['status'];
							}

							if ('finished' == $status) {
								$processed++;
							}
						}
					}

					if (isset($jobdata['backup_files']) && 'no' != $jobdata['backup_files']) {
						$file_entities = count($jobdata['job_file_entities']);

						$backup_files = $jobdata['backup_files'];
						if ('finished' == $backup_files) {
							$processed += $file_entities;
						} elseif (isset($jobdata['filecreating_substatus'])) {
							$substatus = $jobdata['filecreating_substatus'];
							$processed += max(0, intval($substatus['i']) - 1);
						}
					}

					$response['progress'] = array(
						'file_entities' => $file_entities,
						'db_entities' => $db_entities,
						'total_entities' => $file_entities+$db_entities,
						'processed' => $processed,
						'percentage' => floor(($processed/($file_entities+$db_entities))*100),
						'nonce' => $nonce,
					);

					UpdraftPlus_Options::update_updraft_option('updraft_last_backup_progress', $response['progress'], false);
				} else {
					$last_backup = UpdraftPlus_Options::get_updraft_option('updraft_last_backup');
					if ($nonce == $last_backup['backup_nonce']) {
						$response['status'] = 'finished';
						$response['progress'] = array('percentage' => 100);
						$response['progress']['errors'] = $last_backup['errors'];

						$errors = 0;
						$warnings = 0;
						
						if (!empty($last_backup['errors']) && is_array($last_backup['errors'])) {
							foreach ($last_backup['errors'] as $err) {
								$level = (is_array($err)) ? $err['level'] : 'error';
								if ('warning' == $level) {
									$warnings++;
								} elseif ('error' == $level) {
									$errors++;
								}
							}
						}

						$response['progress']['has_errors'] = ($errors > 0) ? true : false;
						$response['progress']['has_warnings'] = ($warnings > 0) ? true : false;
					} else {
						// We might be too early to check the `updraft_last_backup` thus, we'll
						// give it a few rounds to check by setting the status to "in-progress"
						// and returning the last backup progress.
						$last_progress = UpdraftPlus_Options::get_updraft_option('updraft_last_backup_progress');
						if ($nonce == $last_progress['nonce']) {
							$response['status'] = 'in-progress';
							$response['progress'] = $last_progress;
						}
					}
				}
			}
		}

		return $this->_response($response);
	}
}
