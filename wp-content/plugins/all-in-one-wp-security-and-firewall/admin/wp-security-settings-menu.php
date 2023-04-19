<?php

if (!defined('ABSPATH')) die('No direct access.');

/**
 * AIOWPSecurity_Settings_Menu class for setting configs.
 *
 * @access public
 */
class AIOWPSecurity_Settings_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Settings menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_SETTINGS_MENU_SLUG;

	/**
	 * Constructor adds menu for Settings
	 */
	public function __construct() {
		parent::__construct(__('Settings', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	public function setup_menu_tabs() {
		$menu_tabs = array(
			'general-settings' => array(
				'title' => __('General settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_general_settings'),
			),
			'htaccess-file-operations' => array(
				'title' => '.htaccess '.__('file', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_htaccess_file_operations'),
			),
			'wp-config-file-operations' =>  array(
				'title' => 'wp-config.php '.__('file', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_config_file_operations'),
			),
			'delete-plugin-settings' =>  array(
				'title' => __('Delete plugin settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_delete_plugin_settings_tab'),
			),
			'wp-version-info' =>  array(
				'title' => __('WP version info', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_version_info'),
			),
			'settings-file-operations' =>  array(
				'title' => __('Import/Export', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_settings_file_operations'),
			),
			'advanced-settings' => array(
				'title' => __('Advanced settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_advanced_settings'),
				'display_condition_callback' => 'is_main_site',
			),
		);

		$menu_tabs = apply_filters('aiowpsecurity_setting_tabs', $menu_tabs);
		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders the submenu's general settings tab.
	 *
	 * @return void
	 */
	protected function render_general_settings() {
		global $aio_wp_security;
		if (isset($_POST['aiowpsec_disable_all_features'])) { //Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-disable-all-features')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on disable all security features.", 4);
				die("Nonce check failed on disable all security features.");
			}

			$msg = AIOWPSecurity_Settings_Tasks::disable_all_security_features();
			if (isset($msg['updated'])) {
				$this->show_msg_updated($msg['updated']);
			}
			if (isset($msg['error'])) {
				foreach($msg['error'] as $key => $error_message) {
					$this->show_msg_error($error_message);
				}
			}
		}
		
		if (isset($_POST['aiowpsec_disable_all_firewall_rules'])) { //Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-disable-all-firewall-rules')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on disable all firewall rules.", 4);
				die("Nonce check failed on disable all firewall rules.");
			}
			
			$msg = AIOWPSecurity_Settings_Tasks::disable_all_firewall_rules();
			if (isset($msg['updated'])) {
				$this->show_msg_updated($msg['updated']);
			} elseif (isset($msg['error'])) {
				$this->show_msg_error($msg['error']);
			}
		}
		
		if (isset($_POST['aiowps_reset_settings'])) { // Do form submission tasks
			if (!wp_verify_nonce($_POST['_wpnonce'], 'aiowps-reset-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for reset settings.", 4);
				die("Nonce check failed for reset settings.");
			}
			$msg = AIOWPSecurity_Settings_Tasks::reset_all_settings();
			if (isset($msg['updated'])) {
				$this->show_msg_updated($msg['updated']);
			} elseif (isset($msg['error'])) {
				$this->show_msg_error($msg['error']);
			}
		}

		if (isset($_POST['aiowps_save_debug_settings'])) { //Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-save-debug-settings')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on save debug settings.", 4);
				die("Nonce check failed on save debug settings.");
			}

			$aio_wp_security->configs->set_value('aiowps_enable_debug', isset($_POST["aiowps_enable_debug"]) ? '1' : '', true);
			$this->show_msg_settings_updated();
		}
		$aio_wp_security->include_template('wp-admin/settings/general-settings.php', false, array());
	}

	/**
	 * Renders the submenu's htaccess file operations tab.
	 *
	 * @return void
	 */
	protected function render_htaccess_file_operations() {
		global $aio_wp_security;

		$home_path = AIOWPSecurity_Utility_File::get_home_path();
		$htaccess_path = $home_path . '.htaccess';

		if (isset($_POST['aiowps_save_htaccess'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-save-htaccess-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on htaccess file save.",4);
				die("Nonce check failed on htaccess file save.");
			}

			$result = AIOWPSecurity_Utility_File::backup_and_rename_htaccess($htaccess_path); //Backup the htaccess file

			if ($result) {
				$random_prefix = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(10);
				$aiowps_backup_dir = WP_CONTENT_DIR.'/'.AIO_WP_SECURITY_BACKUPS_DIR_NAME;
				if (rename($aiowps_backup_dir.'/'.'.htaccess.backup', $aiowps_backup_dir.'/'.$random_prefix.'_htaccess_backup.txt')) {
					echo '<div id="message" class="updated fade"><p>';
					_e('Your .htaccess file was successfully backed up! Using an FTP program go to the "/wp-content/aiowps_backups" directory to save a copy of the file to your computer.','all-in-one-wp-security-and-firewall');
					echo '</p></div>';
				} else {
					$aio_wp_security->debug_logger->log_debug("htaccess file rename failed during backup!",4);
					$this->show_msg_error(__('htaccess file rename failed during backup. Please check your root directory for the backup file using FTP.','all-in-one-wp-security-and-firewall'));
				}
			} else {
				$aio_wp_security->debug_logger->log_debug("htaccess - Backup operation failed!",4);
				$this->show_msg_error(__('htaccess backup failed.','all-in-one-wp-security-and-firewall'));
			}
		}

		if (isset($_POST['aiowps_restore_htaccess'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-restore-htaccess-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on htaccess file restore.",4);
				die("Nonce check failed on htaccess file restore.");
			}

			if (empty($_POST['aiowps_htaccess_file']) || empty($_POST['aiowps_htaccess_file_contents'])) {
				$this->show_msg_error(__('Please choose a valid .htaccess to restore from.', 'all-in-one-wp-security-and-firewall'));
			} else {
				$htaccess_file_contents = trim(stripslashes($_POST['aiowps_htaccess_file_contents']));
				//TODO
				//Verify that file chosen has contents which are relevant to .htaccess file
				$is_htaccess = AIOWPSecurity_Utility_Htaccess::check_if_htaccess_contents($htaccess_file_contents);
				if ($is_htaccess == 1) {
					if (!file_put_contents($htaccess_path, $htaccess_file_contents)) {
						//Failed to make a backup copy
						$aio_wp_security->debug_logger->log_debug("htaccess - Restore from .htaccess operation failed.",4);
						$this->show_msg_error(__('htaccess file restore failed. Please attempt to restore the .htaccess manually using FTP.','all-in-one-wp-security-and-firewall'));
					} else {
						$this->show_msg_updated(__('Your .htaccess file has successfully been restored.', 'all-in-one-wp-security-and-firewall'));
					}
				} else {
					$aio_wp_security->debug_logger->log_debug("htaccess restore failed - Contents of restore file appear invalid.",4);
					$this->show_msg_error(__('htaccess Restore operation failed. Please check the contents of the file you are trying to restore from.','all-in-one-wp-security-and-firewall'));
				}
			}
		}

		$aio_wp_security->include_template('wp-admin/settings/htaccess-file-operations.php', false, array());
	}

	/**
	 * Renders the submenu's wp config file operations tab.
	 *
	 * @return void
	 */
	protected function render_wp_config_file_operations() {
		global $aio_wp_security;

		if (isset($_POST['aiowps_restore_wp_config'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-restore-wp-config-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on wp-config file restore.",4);
				die('Nonce check failed on wp-config file restore.');
			}

			if (empty($_POST['aiowps_wp_config_file']) || empty($_POST['aiowps_wp_config_file_contents'])) {
				$this->show_msg_error(__('Please choose a wp-config.php file to restore from.', 'all-in-one-wp-security-and-firewall'));
			} else {
				$wp_config_file_contents = trim(stripslashes($_POST['aiowps_wp_config_file_contents']));

				//Verify that file chosen is a wp-config.file
				$is_wp_config = $this->check_if_wp_config_contents($wp_config_file_contents);
				if ($is_wp_config == 1) {
					$active_root_wp_config = AIOWPSecurity_Utility_File::get_wp_config_file_path();
					if (!file_put_contents($active_root_wp_config, $wp_config_file_contents)) {
						//Failed to make a backup copy
						$aio_wp_security->debug_logger->log_debug("wp-config.php - Restore from backed up wp-config operation failed.",4);
						$this->show_msg_error(__('wp-config.php file restore failed. Please attempt to restore this file manually using FTP.','all-in-one-wp-security-and-firewall'));
					} else {
						$this->show_msg_updated(__('Your wp-config.php file has successfully been restored.', 'all-in-one-wp-security-and-firewall'));
					}
				} else {
					$aio_wp_security->debug_logger->log_debug("wp-config.php restore failed - Contents of restore file appear invalid.",4);
					$this->show_msg_error(__('wp-config.php Restore operation failed. Please check the contents of the file you are trying to restore from.','all-in-one-wp-security-and-firewall'));
				}
			}
		}

		$aio_wp_security->include_template('wp-admin/settings/wp-config-file-operations.php', false, array());
	}

	/**
	 * Renders the submenu's delete plugin settings tab.
	 *
	 * @return void
	 */
	protected function render_delete_plugin_settings_tab() {
		global $aio_wp_security;

		if (isset($_POST['aiowpsec_save_delete_plugin_settings'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-delete-plugin-settings')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on manage delete plugin settings save.", 4);
				die("Nonce check failed on manage delete plugin settings save.");
			}

			//Save settings
			$aio_wp_security->configs->set_value('aiowps_on_uninstall_delete_db_tables', isset($_POST['aiowps_on_uninstall_delete_db_tables']) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_on_uninstall_delete_configs', isset($_POST['aiowps_on_uninstall_delete_configs']) ? '1' : '');
			$aio_wp_security->configs->save_config();

			$this->show_msg_updated(__('Manage delete plugin settings saved.', 'all-in-one-wp-security-and-firewall'));

		}

		$aio_wp_security->include_template('wp-admin/settings/delete-plugin-settings.php', false, array());
	}

	/**
	 * Renders the submenu's wp version info tab.
	 *
	 * @return void
	 */
	protected function render_wp_version_info() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_save_remove_wp_meta_info'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-remove-wp-meta-info-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on remove wp meta info options save!",4);
				die("Nonce check failed on remove wp meta info options save!");
			}
			$aio_wp_security->configs->set_value('aiowps_remove_wp_generator_meta_info', isset($_POST["aiowps_remove_wp_generator_meta_info"]) ? '1' : '', true);

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}

		$aio_wp_security->include_template('wp-admin/settings/wp-version-info.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Renders the submenu's settings file operations tab.
	 *
	 * @return void
	 */
	protected function render_settings_file_operations() {
		global $aio_wp_security, $aiowps_firewall_config, $simba_two_factor_authentication;
		global $wpdb;

		$events_table_name = AIOWPSEC_TBL_EVENTS;
		
		$msg_updated = __('Your AIOS settings were successfully imported.', 'all-in-one-wp-security-and-firewall');
		$msg_error = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'.htaccess') . ' ' . __('Please check the file permissions.', 'all-in-one-wp-security-and-firewall');
		
		AIOWPSecurity_Utility::cleanup_table($events_table_name, 500);
		if (isset($_POST['aiowps_import_settings'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-import-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed on import AIOS settings.', 4);
				die('Nonce check failed on import AIOS settings.');
			}

			if (empty($_POST['aiowps_import_settings_file']) && empty($_POST['aiowps_import_settings_file_contents'])) {
				$this->show_msg_error(__('Please choose a file to import your settings from.', 'all-in-one-wp-security-and-firewall'));
			} else {
				// Let's get the uploaded import file contents
				$import_file_contents = trim(stripslashes($_POST['aiowps_import_settings_file_contents']));

				// Verify that file chosen has valid AIOS settings contents
				$aiowps_settings_file_contents = $this->check_if_valid_aiowps_settings_content($import_file_contents);

				if ($aiowps_settings_file_contents != -1) {
					$is_enabled_cookie_bruteforce_before_import = $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention');
					// Apply the settings
					$settings_array = json_decode($aiowps_settings_file_contents, true);
					if (array_key_exists('general', $settings_array)) {
						$aiowps_settings_applied = update_option('aio_wp_security_configs', $settings_array['general']);

						if (!$aiowps_settings_applied && get_option('aio_wp_security_configs') === $settings_array['general']) {
							$aiowps_settings_applied = true;
						}

						if (is_main_site() && is_super_admin()) {
							if (array_key_exists('tfa', $settings_array) && !empty($simba_two_factor_authentication->is_tfa_integrated)) {
								$tfa_settings_applied = $simba_two_factor_authentication->set_configs($settings_array['tfa']);

								if (!$tfa_settings_applied && $simba_two_factor_authentication->get_configs() !== $settings_array['tfa']) {
									$aiowps_settings_applied = false;
								}
							}

							if (array_key_exists('firewall', $settings_array)) {
								$aiowps_settings_applied = $aiowps_firewall_config->set_contents($settings_array['firewall']) && $aiowps_settings_applied;
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
						$this->show_msg_error(__('Import AIOS settings operation failed.', 'all-in-one-wp-security-and-firewall'));
					} else {
						$aio_wp_security->configs->load_config(); // Refresh the configs global variable

						//Just in case user submits partial config settings
						//Run add_option_values to make sure any missing config items are at least set to default
						AIOWPSecurity_Configure_Settings::add_option_values();
						
						$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

						// Now let's refresh the .htaccess file with any modified rules if applicable
						
						$is_enabled_cookie_bruteforce = $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention');
						if ($is_enabled_cookie_bruteforce_before_import != $is_enabled_cookie_bruteforce && 1 == $is_enabled_cookie_bruteforce) {
							$url = 'admin.php?page='.AIOWPSEC_SETTINGS_MENU_SLUG."&tab=settings-file-operations&success=import_settings";
						 	$url.=  (!empty($aio_wp_security->configs->get_value('aiowps_brute_force_secret_word'))) ? '&'.$aio_wp_security->configs->get_value('aiowps_brute_force_secret_word').'=1' : '';
							$url.= (!$res) ? '&error=write_htaccess' : '';
							AIOWPSecurity_Utility::redirect_to_url(admin_url(sanitize_url($url)));			
						}
							
						$this->show_msg_updated($msg_updated);
						if (!$res) {
							$this->show_msg_error($msg_error);
						}
					}
				} else {
					// Invalid settings file
					$aio_wp_security->debug_logger->log_debug("The contents of your settings file are invalid.",4);
					$this->show_msg_error(__('The contents of your settings file are invalid. Please check the contents of the file you are trying to import settings from.','all-in-one-wp-security-and-firewall'));
				}
			}
		}
		
		if (isset($_GET["success"]) && "import_settings" == $_GET["success"]) {
			$this->show_msg_updated($msg_updated);
		}
		if (isset($_GET["error"]) && "write_htaccess" == $_GET["error"]) {
			$this->show_msg_error($msg_error);
		}

		$aio_wp_security->include_template('wp-admin/settings/settings-file-operations.php', false, array());
	}

	/**
	 * Renders advanced settings tab.
	 *
	 * @return void
	 */
	protected function render_advanced_settings() {
		if (!is_main_site()) {
			return;
		}

		global $aio_wp_security, $aiowps_firewall_config;

		if (isset($_POST['aiowps_save_advanced_settings'])) {
			if (empty($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-ip-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed for save advanced settings.', 4);
				die('Nonce check failed for save advanced settings.');
			}

			$ip_retrieve_method_id = sanitize_text_field($_POST["aiowps_ip_retrieve_method"]);

			if (in_array($ip_retrieve_method_id, array_keys(AIOS_Abstracted_Ids::get_ip_retrieve_methods()))) {
				$aio_wp_security->configs->set_value('aiowps_ip_retrieve_method', $ip_retrieve_method_id, true);
				$aiowps_firewall_config->set_value('aios_ip_retrieve_method', $ip_retrieve_method_id);

				//Clear logged in list because it might be showing wrong addresses
				if (AIOWPSecurity_Utility::is_multisite_install()) {
					delete_site_transient('users_online');
				} else {
					delete_transient('users_online');
				}

				$this->show_msg_settings_updated();
			}
		}

		$ip_retrieve_methods_postfixes = array(
				'REMOTE_ADDR' =>  __('Default - if correct, then this is the best option', 'all-in-one-wp-security-and-firewall'),
				'HTTP_CF_CONNECTING_IP' => __("Only use if you're using Cloudflare.", 'all-in-one-wp-security-and-firewall'),
		);

		$ip_retrieve_methods = array();
		foreach (AIOS_Abstracted_Ids::get_ip_retrieve_methods() as $id => $ip_method) {
			$ip_retrieve_methods[$id]['ip_method'] = $ip_method;

			if (isset($_SERVER[$ip_method])) {
				$ip_retrieve_methods[$id]['ip_method'] .= ' '.sprintf(__('(current value: %s)', 'all-in-one-wp-security-and-firewall'), $_SERVER[$ip_method]);
				$ip_retrieve_methods[$id]['is_enabled'] = true;
			} else {
				$ip_retrieve_methods[$id]['ip_method'] .= '  (' . __('no value (i.e. empty) on your server', 'all-in-one-wp-security-and-firewall') . ')';
				$ip_retrieve_methods[$id]['is_enabled'] = false;
			}

			if (!empty($ip_retrieve_methods_postfixes[$ip_method])) {
				$ip_retrieve_methods[$id]['ip_method'] .= ' (' . $ip_retrieve_methods_postfixes[$ip_method] . ')';
			}
		}

		$aio_wp_security->include_template('wp-admin/settings/advanced-settings.php', false, array(
			'is_localhost' => AIOWPSecurity_Utility::is_localhost(),
			'ip_retrieve_methods' => $ip_retrieve_methods,
			'server_suitable_ip_methods' => AIOWPSecurity_Utility_IP::get_server_suitable_ip_methods(),
		));
	}

	/**
	 * Check if wp config file.
	 *
	 * @param string $file_contents File contents
	 *
	 * @return int
	 */
	private function check_if_wp_config_contents($file_contents) {
		$is_wp_config = false;

		if ($file_contents == '' || $file_contents == NULL || $file_contents == false) {
			return -1;
		}

		if (preg_match("/define\(\s*['\"]DB_NAME['\"]/", $file_contents)) {
			$is_wp_config = true; // It appears that we have some sort of wp-config.php file
		} else {
			//see if we're at the end of the section
			$is_wp_config = false;
		}

		return $is_wp_config ? 1 : -1;
	}

	/**
	 * Check if valid aios settings text
	 *
	 * @param string $text Settings text
	 *
	 * @return boolean
	 */
	private function check_is_aiowps_settings($text) {
		return (false !== strpos($text, 'aiowps_enable_login_lockdown'));
	}

	/**
	 * Checks if valid AIOS settings file contents and returns contents as string
	 *
	 * @param string $file_contents File contents
	 *
	 * @return string|boolean|int
	 */
	private function check_if_valid_aiowps_settings_content($file_contents) {
		if ($file_contents == '' || $file_contents == NULL || $file_contents == false) {
			return -1;
		}

		// Check a known AIOS config strings to see if it is contained within this file
		$is_aiowps_settings = $this->check_is_aiowps_settings($file_contents);

		if ($is_aiowps_settings) {
			return $file_contents;
		} else {
			return -1;
		}
	}

} //end class
