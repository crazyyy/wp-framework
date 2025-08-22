<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Files_Commands_Trait')) return;

trait AIOWPSecurity_Files_Commands_Trait {

	/**
	 * This function performs file permission fixing
	 *
	 * @param array $data - the request data contains the files items
	 *
	 * @return array
	 */
	public function perform_fix_permissions($data) {
		global $aio_wp_security;

		$files_dirs_to_check = AIOWPSecurity_Utility_File::get_files_and_dirs_to_check();

		$success = true;
		$message = '';

		if (isset($data['aiowps_permission_chg_file'])) {
			$file_found = false;
			$folder_or_file = sanitize_text_field($data['aiowps_permission_chg_file']);
			$rec_perm_oct_string = '';
			foreach ($files_dirs_to_check as $file_or_dir) {
				if ($folder_or_file == $file_or_dir['path']) {
					$file_found = true;
					$rec_perm_oct_string = $file_or_dir['permissions'];
				}
			}
			if ($file_found && !empty($rec_perm_oct_string)) {
				$rec_perm_dec = octdec($rec_perm_oct_string); // Convert the octal string to dec so the chmod func will accept it
				$perm_result = @chmod($folder_or_file, $rec_perm_dec);
				if (true === $perm_result) {
					$message = sprintf(__('The permissions for %s were successfully changed to %s', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file), htmlspecialchars($rec_perm_oct_string));
				} elseif (false === $perm_result) {
					$message = sprintf(__('Unable to change permissions for %s', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file));
					$success = false;
				}
			} else {
				$message = sprintf(__('Unable to change permissions for %s : not in list of valid files', 'all-in-one-wp-security-and-firewall'), htmlspecialchars($folder_or_file));
				$success = false;
			}
		}

		$badges = array("filesystem-file-permissions");
		$content = array('aios_file_permissions_table' => $aio_wp_security->include_template('wp-admin/filesystem-security/partials/file-permissions-table.php', true, array('files_dirs_to_check' => $files_dirs_to_check, 'file_utility' => new AIOWPSecurity_Utility_File())));
		$args = array(
			'content' => $content,
			'badges' => $badges,
		);

		return $this->handle_response($success, $message, $args);
	}

	/**
	 * This function performs file protection settings
	 *
	 * @param array $data - the request data contains the settings
	 *
	 * @return array
	 */
	public function perform_file_protection_settings($data) {
		global $aio_wp_security;

		$success = true;
		$message = '';

		$options = array();
		// Update settings for delete readme.html and wp-config-sample.php.
		$options['aiowps_auto_delete_default_wp_files'] = isset($data['aiowps_auto_delete_default_wp_files']) ? '1' : '';

		// Update settings for prevent hotlinking.
		$options['aiowps_prevent_hotlinking'] = isset($data['aiowps_prevent_hotlinking']) ? '1' : '';

		// Update settings for php file editing
		$disable_file_editing = isset($data["aiowps_disable_file_editing"]) ? '1' : '';
		$disable_file_editing_status = $disable_file_editing ? AIOWPSecurity_Utility::disable_file_edits() : AIOWPSecurity_Utility::enable_file_edits();
		if ($disable_file_editing_status) {
			// Save settings if no errors
			$options['aiowps_disable_file_editing'] = $disable_file_editing;
		} else {
			$message = __('Disable PHP file editing failed: unable to modify or make a backup of the wp-config.php file.', 'all-in-one-wp-security-and-firewall');
			return $this->handle_response(false, $message);
		}

		$this->save_settings($options);


		if (AIOWPSecurity_Utility_Htaccess::write_to_htaccess() && '' !== $options['aiowps_prevent_hotlinking']) {

			// Now let's write the applicable rules to the .htaccess file
			$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

			if ($res) {
				$message = __('The settings have been successfully updated', 'all-in-one-wp-security-and-firewall');
			} else {
				$success = false;
				$message = __('Could not write to the .htaccess file.', 'all-in-one-wp-security-and-firewall');

				// revert options affected by .htaccess write fail
				$options['aiowps_prevent_hotlinking'] = $aio_wp_security->configs->get_value('aiowps_prevent_hotlinking');
				$this->save_settings($options);
			}
		}

		$features = array(
			"auto-delete-wp-files",
			"prevent-hotlinking",
			"filesystem-file-editing",
		);

		return $this->handle_response($success, $message, array('badges' => $features));
	}

	/**
	 * This function performs deleting default wp files
	 *
	 * @return array
	 */
	public function perform_delete_default_wp_files() {
		$success = true;
		$message = __('The files have been deleted successfully.', 'all-in-one-wp-security-and-firewall');

		$result = AIOWPSecurity_Utility::delete_unneeded_default_files();

		if (!empty($result['error'])) {
			$success = false;
			$message = sprintf(__('Failed to delete the %s file(s).', 'all-in-one-wp-security-and-firewall'), $result['error']) . '<br>' . __('Please try to delete them manually.', 'all-in-one-wp-security-and-firewall');
		}

		return $this->handle_response($success, $message, array('info' => $result['info']));
	}

	/**
	 * This function performs save copy protection settings
	 *
	 * @param array $data - the request data
	 *
	 * @return array
	 */
	public function perform_save_copy_protection($data) {
		$this->save_settings(array('aiowps_copy_protection' => isset($data["aiowps_copy_protection"]) ? '1' : ''));

		return $this->handle_response(true, '', array('badges' => array('enable-copy-protection')));
	}

	/**
	 * This function performs save frame display prevent setting
	 *
	 * @param array $data - the request data
	 *
	 * @return array
	 */
	public function perform_save_frame_display_prevent($data) {
		$this->save_settings(array('aiowps_prevent_site_display_inside_frame' => isset($data["aiowps_prevent_site_display_inside_frame"]) ? '1' : ''));

		return $this->handle_response(true, '', array('badges' => array('enable-frame-protection')));
	}

	/**
	 * This function performs host system logs
	 *
	 * @param array $data - the request data contains the lgos settings
	 *
	 * @return array
	 */
	public function perform_host_system_logs($data) {

		$content = array();
		$success = true;
		$message = false;

		if (isset($data['aiowps_system_log_file'])) {
			if ('' != $data['aiowps_system_log_file']) {
				$sys_log_file = basename(sanitize_text_field($data['aiowps_system_log_file']));
			} else {
				$sys_log_file = 'error_log';
			}
			$this->save_settings(array('aiowps_system_log_file' => $sys_log_file));
		}

		$logResults = AIOWPSecurity_Utility_File::recursive_file_search($sys_log_file, 0, ABSPATH);

		if (empty($logResults) || '' == $logResults) {
			$success = false;
			$message = __('No system logs were found.', 'all-in-one-wp-security-and-firewall');
		} else {
			$content['aios-host-system-logs-results'] = '';
			foreach ($logResults as $file) {
				$content['aios-host-system-logs-results'] .= $this->display_system_logs_in_table($file);
			}
		}

		$values = array('aiowps_system_log_file' => $sys_log_file);

		$args = array(
			'content' => $content,
			'values' => $values
		);

		return $this->handle_response($success, $message, $args);
	}

	/**
	 * Displays the last 50 entries of a system log file in a table format.
	 *
	 * This function reads the contents of the specified file and returns a
	 * rendered template displaying the last 50 entries of the log file.
	 *
	 * @param string $filepath The path to the log file to be read.
	 *
	 * @return string The rendered HTML template displaying the log entries.
	 */
	private function display_system_logs_in_table($filepath) {
		global $aio_wp_security;
		// Get contents of the error_log file
		$last_50_entries = AIOWPSecurity_Utility_File::read_file_lines($filepath, -1, 50, true);
		return $aio_wp_security->include_template('wp-admin/filesystem-security/filesystem-log-result.php', true, array('filepath' => $filepath, 'last_50_entries' => $last_50_entries));
	}
}
