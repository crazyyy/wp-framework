<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Settings_Commands_Trait')) return;

trait AIOWPSecurity_Settings_Commands_Trait {

	/**
	 * Performs the action to disable all security features.
	 *
	 * This method disables all security features provided by the AIOWPSecurity_Settings_Tasks class.
	 *
	 * @return array An associative array containing the status and messages of the operation.
	 *               - 'status'   : (string) The status of the operation, either 'success' or 'error'.
	 *               - 'messages' : (array) An array of messages generated during the operation.
	 *                              Each message is represented as a string.
	 */
	public function perform_disable_all_features() {

		$msg = AIOWPSecurity_Settings_Tasks::disable_all_security_features();
		$success = true;
		$info = array();
		$message = '';

		if (isset($msg['updated'])) {
			$message = $msg['updated'];
		}
		if (isset($msg['error'])) {
			$message = __('Some of the security features could not be disabled.', 'all-in-one-wp-security-and-firewall');
			$success = false;
			foreach ($msg['error'] as $error_message) {
				$info[] = $error_message;
			}
		}

		return $this->handle_response($success, $message, array('info' => $info));
	}

	/**
	 * Performs the action to disable all firewall rules.
	 *
	 * This method disables all firewall rules provided by the AIOWPSecurity_Settings_Tasks class.
	 *
	 * @return array An associative array containing the status and message of the operation.
	 *               - 'status'  : (string) The status of the operation, either 'success' or 'error'.
	 *               - 'message' : (string) A message indicating the outcome of the operation.
	 *                              If the operation is successful, it contains an update message.
	 *                              If there is an error, it contains an error message.
	 */
	public function perform_disable_all_firewall_rules() {
		$msg = AIOWPSecurity_Settings_Tasks::disable_all_firewall_rules();
		$success = true;
		$message = '';

		if (isset($msg['updated'])) {
			$message = $msg['updated'];
		} elseif (isset($msg['error'])) {
			$message = $msg['error'];
			$success = false;
		}

		return $this->handle_response($success, $message);
	}

	/**
	 * Performs the action to reset all settings.
	 *
	 * This method resets all settings provided by the AIOWPSecurity_Settings_Tasks class to their default values.
	 *
	 * @return array An associative array containing the status and message of the operation.
	 *               - 'status'  : (string) The status of the operation, either 'success' or 'error'.
	 *               - 'message' : (string) A message indicating the outcome of the operation.
	 *                              If the operation is successful, it contains an update message.
	 *                              If there is an error, it contains an error message.
	 */
	public function perform_reset_all_settings() {
		$msg = AIOWPSecurity_Settings_Tasks::reset_all_settings();

		$success = true;
		$message = '';

		if (isset($msg['updated'])) {
			$message = $msg['updated'];
		} elseif (isset($msg['error'])) {
			$message = $msg['error'];
			$success = false;
		}

		return $this->handle_response($success, $message);
	}

	/**
	 * Performs the action to save debug settings.
	 *
	 * This method updates the debug settings in the AIOWPSecurity_Configs instance based on the provided data.
	 *
	 * @param array $data An associative array containing the data to update the debug settings.
	 *                    - 'aiowps_enable_debug': (bool) Indicates whether debug mode should be enabled.
	 * @return array An associative array containing the status and message of the operation.
	 *               - 'status'  : (string) The status of the operation, which is always 'success'.
	 *               - 'message' : (string) A message indicating that the settings have been updated successfully.
	 */
	public function perform_save_debug_settings($data) {
		global $aio_wp_security;

		$aio_wp_security->configs->set_value('aiowps_enable_debug', '1' === $data["aiowps_enable_debug"] ? '1' : '', true);

		return $this->handle_response(true);
	}

	/**
	 * Performs the action to backup the .htaccess file.
	 *
	 * This method creates a backup of the .htaccess file and renames it with a random prefix.
	 * It also provides a message indicating the outcome of the backup operation.
	 *
	 * @global object $aio_wp_security The global instance of the All-in-One WP Security & Firewall plugin.
	 * @return array An associative array containing the status and message of the backup operation.
	 *               - 'status'  : (string) The status of the operation, which can be 'success' or 'error'.
	 *               - 'message' : (string) A message indicating the outcome of the backup operation.
	 */
	public function perform_backup_htaccess_file() {
		global $aio_wp_security;

		$home_path = AIOWPSecurity_Utility_File::get_home_path();
		$htaccess_path = $home_path . '.htaccess';

		$result = AIOWPSecurity_Utility_File::backup_and_rename_htaccess($htaccess_path); //Backup the htaccess file
		$extra_args = array();

		if ($result) {
			$aiowps_backup_dir = WP_CONTENT_DIR.'/'.AIO_WP_SECURITY_BACKUPS_DIR_NAME;
			$success = true;
			$message = __('Your .htaccess file was successfully backed up.', 'all-in-one-wp-security-and-firewall');
			$extra_args['data'] = file_get_contents($aiowps_backup_dir.'/'. $result .'.txt');
			$extra_args['title'] = $result;
		} else {
			$aio_wp_security->debug_logger->log_debug("htaccess - Backup operation failed!", 4);
			$success = false;
			$message = __('htaccess backup failed.', 'all-in-one-wp-security-and-firewall');
		}

		return $this->handle_response($success, $message, array('extra_args' => $extra_args));
	}

	/**
	 * Performs the action to restore the .htaccess file.
	 *
	 * This method restores the .htaccess file using the provided data, which includes the contents of the .htaccess file.
	 * It also verifies that the file chosen has valid contents relevant to the .htaccess file.
	 *
	 * @global object $aio_wp_security The global instance of the All-in-One WP Security & Firewall plugin.
	 * @param array $data An associative array containing the data needed to restore the .htaccess file.
	 *                    - 'aiowps_htaccess_file'           : (string) The name of the .htaccess file to restore from.
	 *                    - 'aiowps_htaccess_file_contents' : (string) The contents of the .htaccess file to restore.
	 * @return array An associative array containing the status and message of the restore operation.
	 *               - 'status'  : (string) The status of the operation, which can be 'success' or 'error'.
	 *               - 'message' : (string) A message indicating the outcome of the restore operation.
	 */
	public function perform_restore_htaccess_file($data) {
		global $aio_wp_security;

		$success = true;

		$home_path = AIOWPSecurity_Utility_File::get_home_path();
		$htaccess_path = $home_path . '.htaccess';

		if (empty($data['aiowps_htaccess_file']) && empty($data['aiowps_htaccess_file_contents'])) {
			$message = __('Please choose a valid .htaccess to restore from.', 'all-in-one-wp-security-and-firewall');
			$success = false;
		} else {
			$htaccess_file_contents = trim(stripslashes($data['aiowps_htaccess_file_contents']));
			//Verify that file chosen has contents which are relevant to .htaccess file
			$is_htaccess = AIOWPSecurity_Utility_Htaccess::check_if_htaccess_contents($htaccess_file_contents);
			if (1 == $is_htaccess) {
				if (!file_put_contents($htaccess_path, $htaccess_file_contents)) {
					//Failed to make a backup copy
					$aio_wp_security->debug_logger->log_debug("htaccess - Restore from .htaccess operation failed.", 4);
					$message = __('The restoration of the .htaccess file failed; please attempt to restore the .htaccess file manually using FTP.', 'all-in-one-wp-security-and-firewall');
					$success = false;
				} else {
					$message = __('Your .htaccess file has successfully been restored.', 'all-in-one-wp-security-and-firewall');
				}
			} else {
				$aio_wp_security->debug_logger->log_debug("htaccess restore failed - Contents of restore file appear invalid.", 4);
				$success = false;
				$message = __('The restoration .htaccess file has failed, please check the contents of the file you are trying to restore from.', 'all-in-one-wp-security-and-firewall');
			}
		}

		return $this->handle_response($success, $message);
	}

	/**
	 * Performs the action to restore the wp-config.php file.
	 *
	 * This method restores the wp-config.php file using the provided data, which includes the contents of the wp-config.php file.
	 * It also verifies that the file chosen is a valid wp-config.php file.
	 *
	 * @global object $aio_wp_security The global instance of the All-in-One WP Security & Firewall plugin.
	 * @param array $data An associative array containing the data needed to restore the wp-config.php file.
	 *                    - 'aiowps_wp_config_file'           : (string) The name of the wp-config.php file to restore from.
	 *                    - 'aiowps_wp_config_file_contents' : (string) The contents of the wp-config.php file to restore.
	 * @return array An associative array containing the status and message of the restore operation.
	 *               - 'status'  : (string) The status of the operation, which can be 'success' or 'error'.
	 *               - 'message' : (string) A message indicating the outcome of the restore operation.
	 */
	public function perform_restore_wp_config_file($data) {
		global $aio_wp_security;

		$success = true;

		if (empty($data['aiowps_wp_config_file']) && empty($data['aiowps_wp_config_file_contents'])) {
			$message = __('Please choose a wp-config.php file to restore from.', 'all-in-one-wp-security-and-firewall');
			$success = false;
		} else {
			$wp_config_file_contents = trim(stripslashes($data['aiowps_wp_config_file_contents']));

			//Verify that file chosen is a wp-config.file
			$is_wp_config = AIOWPSecurity_Utility_File::check_if_wp_config_contents($wp_config_file_contents);
			if ($is_wp_config) {
				$active_root_wp_config = AIOWPSecurity_Utility_File::get_wp_config_file_path();
				if (!file_put_contents($active_root_wp_config, $wp_config_file_contents)) {
					//Failed to make a backup copy
					$aio_wp_security->debug_logger->log_debug("wp-config.php - Restore from backed up wp-config operation failed.", 4);
					$message = __('The restoration of the wp-config.php file failed, please attempt to restore this file manually using FTP.', 'all-in-one-wp-security-and-firewall');
					$success = false;
				} else {
					$message =__('Your wp-config.php file has successfully been restored.', 'all-in-one-wp-security-and-firewall');
				}
			} else {
				$aio_wp_security->debug_logger->log_debug("wp-config.php restore failed - Contents of restore file appear invalid.", 4);
				$message = __('The restoration of the wp-config.php file failed, please check the contents of the file you are trying to restore from.', 'all-in-one-wp-security-and-firewall');
				$success = false;
			}
		}

		return $this->handle_response($success, $message);
	}

	/**
	 * Performs the action to delete plugin settings.
	 *
	 * This method deletes specific plugin settings based on the provided data.
	 *
	 * @param array $data An associative array containing the data needed to delete plugin settings.
	 *                    - 'aiowps_on_uninstall_delete_db_tables' : (string) Indicates whether to delete plugin database tables on uninstallation.
	 *                    - 'aiowps_on_uninstall_delete_configs'   : (string) Indicates whether to delete plugin configuration settings on uninstallation.
	 * @return array An associative array containing the status and message of the delete operation.
	 *               - 'status'  : (string) The status of the operation, which can be 'success'.
	 *               - 'message' : (string) A message indicating that the plugin settings have been successfully deleted.
	 */
	public function perform_delete_plugin_settings($data) {

		$options = array();
		//Save settings
		$options['aiowps_on_uninstall_delete_db_tables'] = isset($data['aiowps_on_uninstall_delete_db_tables']) ? '1' : '';
		$options['aiowps_on_uninstall_delete_configs'] = isset($data['aiowps_on_uninstall_delete_configs']) ? '1' : '';
		$this->save_settings($options);

		return $this->handle_response(true);
	}

	/**
	 * Performs the action to remove WordPress version information settings.
	 *
	 * This method sets the option to remove WordPress version information meta tags based on the provided data.
	 *
	 * @param array $data An associative array containing the data needed to configure the removal of WordPress version information.
	 *                    - 'aiowps_remove_wp_generator_meta_info' : (string) Indicates whether to remove WordPress version information meta tags.
	 * @return array An associative array containing the status, message, and additional badges related to the removal of WordPress version information.
	 *               - 'status'                                  : (string) The status of the operation, which can be 'success'.
	 *               - 'message'                                 : (string) A message indicating that the settings have been successfully updated.
	 *               - 'badges'                                  : (array) An array containing feature IDs and HTML for additional badges.
	 */
	public function perform_remove_wp_version_info_settings($data) {
		global $aio_wp_security;

		$aio_wp_security->configs->set_value('aiowps_remove_wp_generator_meta_info', '1' === $data["aiowps_remove_wp_generator_meta_info"] ? '1' : '', true);

		return $this->handle_response(true, '', array('badges' => array('wp-generator-meta-tag')));
	}

	/**
	 * Performs the action to restore AIOWPS settings from an imported file.
	 *
	 * This method restores AIOWPS settings from the provided data representing an imported file.
	 *
	 * @param array $data An associative array containing the data needed to restore AIOWPS settings.
	 *                    - 'aiowps_import_settings_file'         : (string) The name of the file containing the AIOWPS settings.
	 *                    - 'aiowps_import_settings_file_contents': (string) The contents of the file containing the AIOWPS settings.
	 * @return array An associative array containing the status and messages related to the restoration of AIOWPS settings.
	 *               - 'status'                                  : (string) The status of the operation, which can be 'success' or 'error'.
	 *               - 'messages'                                : (array) An array of messages indicating the outcome of the restoration process.
	 *               - 'redirect_url'                            : (string|null) The URL to redirect to after the restoration process, if applicable.
	 */
	public function perform_restore_aiowps_settings($data) {
		global $aio_wp_security, $simba_two_factor_authentication;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		$success = true;
		$info = array();
		$extra_args = array();

		$msg_updated = __('Your AIOS settings were successfully imported.', 'all-in-one-wp-security-and-firewall');
		$msg_error = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'.htaccess') . ' ' . __('Please check the file permissions.', 'all-in-one-wp-security-and-firewall');

		if (empty($data['aiowps_import_settings_file']) && empty($data['aiowps_import_settings_file_contents'])) {
			$success = false;
			$message = __('Please choose a file to import your settings from.', 'all-in-one-wp-security-and-firewall');
		} else {
			// Let's get the uploaded import file contents
			$import_file_contents = trim($data['aiowps_import_settings_file_contents']); // stripslashes not required wp_unslash applied already AIOWPSecurity_Ajax::set_data

			// Verify that file chosen has valid AIOS settings contents
			$aiowps_settings_file_contents = AIOWPSecurity_Utility_File::check_if_valid_aiowps_settings_content($import_file_contents);

			if ($aiowps_settings_file_contents) {
				$is_enabled_cookie_bruteforce_before_import = $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention');
				// Apply the settings
				$settings_array = json_decode($import_file_contents, true);
				if (array_key_exists('general', $settings_array)) {
					$aiowps_settings_applied = update_option('aio_wp_security_configs', $settings_array['general']);

					if (!$aiowps_settings_applied && get_option('aio_wp_security_configs') === $settings_array['general']) {
						$aiowps_settings_applied = true;
					}

					if (is_main_site() && is_super_admin()) {
						if (array_key_exists('tfa', $settings_array) && true == $simba_two_factor_authentication->is_tfa_integrated) {
							$tfa_settings_applied = $simba_two_factor_authentication->set_configs($settings_array['tfa']);

							if (!$tfa_settings_applied && $simba_two_factor_authentication->get_configs() !== $settings_array['tfa']) {
								$aiowps_settings_applied = false;
							}
						}

						if (array_key_exists('firewall', $settings_array)) {
							$aiowps_settings_applied = $aiowps_settings_applied && $aiowps_firewall_config->set_contents($settings_array['firewall']);
						}
					}
				} else {
					$aiowps_settings_applied = update_option('aio_wp_security_configs', $settings_array);

					if (!$aiowps_settings_applied && get_option('aio_wp_security_configs') === $settings_array) {
						$aiowps_settings_applied = true;
					}
				}

				if (!$aiowps_settings_applied) {
					// Failed to import settings
					$aio_wp_security->debug_logger->log_debug('Import AIOS settings operation failed.', 4);
					$success = false;
					$message = __('Import AIOS settings operation failed.', 'all-in-one-wp-security-and-firewall');
				} else {
					$aio_wp_security->configs->load_config(); // Refresh the configs global variable

					//Just in case user submits partial config settings
					//Run add_option_values to make sure any missing config items are at least set to default
					AIOWPSecurity_Configure_Settings::add_option_values();

					$res = true;

					if (AIOWPSecurity_Utility::allow_to_write_to_htaccess()) $res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

					// Now let's refresh the .htaccess file with any modified rules if applicable

					$is_enabled_cookie_bruteforce = $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention');

					if ($is_enabled_cookie_bruteforce_before_import != $is_enabled_cookie_bruteforce && 1 == $is_enabled_cookie_bruteforce) {
						$url = 'admin.php?page='.AIOWPSEC_SETTINGS_MENU_SLUG."&tab=settings-file-operations&success=import_settings";
						$url .= empty($aio_wp_security->configs->get_value('aiowps_brute_force_secret_word')) ? '' : '&'.$aio_wp_security->configs->get_value('aiowps_brute_force_secret_word').'=1';
						$url .= $res ? '' : '&error=write_htaccess';
						$extra_args['redirect_url'] = admin_url(sanitize_url($url));
					}

					$message = $msg_updated;
					if (!$res) {
						$info[] = $msg_error;
					}
				}
			} else {
				// Invalid settings file
				$aio_wp_security->debug_logger->log_debug("The contents of your settings file are invalid.", 4);
				$success = false;
				$message = __('The contents of your settings file are invalid, please check the contents of the file you are trying to import settings from.', 'all-in-one-wp-security-and-firewall');
			}
		}

		$args = array(
			'info' => $info,
			'extra_args' => $extra_args
		);

		return $this->handle_response($success, $message, $args);
	}

	/**
	 * Performs the action to save IP settings.
	 *
	 * This method saves the IP settings based on the provided data.
	 *
	 * @param array $data An associative array containing the data needed to save IP settings.
	 *                    - 'aiowps_ip_retrieve_method': (string) The ID of the IP retrieval method.
	 * @return array An associative array containing the status and message related to saving IP settings.
	 *               - 'status': (string) The status of the operation, which can be 'success' or 'error'.
	 *               - 'message': (string|null) A message indicating the outcome of saving IP settings, or null if no message is provided.
	 */
	public function perform_save_ip_settings($data) {
		global $wpdb, $aio_wp_security;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		$ip_retrieve_method_id = sanitize_text_field($data["aiowps_ip_retrieve_method"]);

		$message = false;

		if (in_array($ip_retrieve_method_id, array_keys(AIOS_Abstracted_Ids::get_ip_retrieve_methods()))) {
			$aio_wp_security->configs->set_value('aiowps_ip_retrieve_method', $ip_retrieve_method_id, true);
			$aiowps_firewall_config->set_value('aios_ip_retrieve_method', $ip_retrieve_method_id);
			$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;

			//Clear logged in list because it might be showing wrong addresses
			if (AIOWPSecurity_Utility::is_multisite_install()) {
				$current_blog_id = get_current_blog_id();
				$wpdb->query($wpdb->prepare("DELETE FROM `{$logged_in_users_table}` WHERE site_id = %d", $current_blog_id));
			}
			$wpdb->query("DELETE FROM `{$logged_in_users_table}`");

			$message = '';
		}

		return $this->handle_response(true, $message);
	}

	/**
	 * Perform saving the wp-config.php file.
	 *
	 * This method backs up the wp-config.php file and retrieves its content.
	 * It returns the status of the operation, the file content, and the backup title.
	 *
	 * @return array An array containing the status, file content, and backup title.
	 */
	public function perform_save_wp_config() {
		$wp_config_path = AIOWPSecurity_Utility_File::get_wp_config_file_path();
		AIOWPSecurity_Utility_File::backup_and_rename_wp_config($wp_config_path); // Backup the wp_config.php file
		$title = "wp-config-backup.txt";
		$file_content = file_get_contents($wp_config_path);

		$extra_args = array(
			'data' => $file_content,
			'title' => $title
		);

		return $this->handle_response(true, false, array('extra_args' => $extra_args));
	}

	/**
	 * Perform exporting All In One WP Security & Firewall settings.
	 *
	 * This method exports general settings, firewall settings, and two-factor authentication settings
	 * if applicable. It then returns the exported data in JSON format along with a title for the export.
	 *
	 * @return array An array containing the status, exported data in JSON format, and a title for the export.
	 */
	public function perform_export_aios_settings() {
		global $simba_two_factor_authentication;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		$config_data = array();
		$config_data['general'] = get_option('aio_wp_security_configs');

		if (is_main_site() && is_super_admin()) {
			$config_data['firewall'] = $aiowps_firewall_config->get_contents();

			if (true == $simba_two_factor_authentication->is_tfa_integrated) {
				$config_data['tfa'] = $simba_two_factor_authentication->get_configs();
			}
		}

		$output = json_encode($config_data);

		$extra_args = array(
			'data' => $output,
			'title' => 'aiowps_' . current_time('Y-m-d_H-i') . '.txt'
		);

		return $this->handle_response(true, false, array('extra_args' => $extra_args));
	}
}
