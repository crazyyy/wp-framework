<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * AIOWPSecurity_User_Login_Menu class for user login lockout options, login logs.
 *
 * @access public
 */
class AIOWPSecurity_User_Login_Menu extends AIOWPSecurity_Admin_Menu {
	
	/**
	 * Blacklist menu slug
	 *
	 * @var string 
	 */
	protected $menu_page_slug = AIOWPSEC_USER_LOGIN_MENU_SLUG;
	
	/**
	 * Constructor adds menu for User login
	 */
	public function __construct()  {
		parent::__construct(__('User login', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'login-lockout' => array(
				'title' => __('Login lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_login_lockout'),
			),
			'failed-login-records' => array(
				'title' => __('Failed login records', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_failed_login_records'),
			),
			'force-logout' => array(
				'title' => __('Force logout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_force_logout'),
			),
			'account-activity-logs' => array(
				'title' => __('Account activity logs', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_account_activity_logs'),
			),
			'logged-in-users' => array(
				'title' => __('Logged in users', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_logged_in_users'),
			),
			'additional' => array(
				'title' => __('Additional settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_additional'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
		
	}

	/**
	 * Login Lockout configuration to set.
	 * 
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 *
	 * @return Void
	 */
	protected function render_login_lockout() {
		global $aio_wp_security, $aiowps_feature_mgr;

		include_once 'wp-security-list-locked-ip.php'; // For rendering the AIOWPSecurity_List_Table in tab1
		$locked_ip_list = new AIOWPSecurity_List_Locked_IP(); // For rendering the AIOWPSecurity_List_Table in tab1

		if (isset($_POST['aiowps_login_lockdown'])) { // Do form submission tasks
			$error = '';
			if (!isset($_POST['_wpnonce']) ||  !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-login-lockdown-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on login lockout options save.", 4);
				die("Nonce check failed on login lockout options save.");
			}

			$max_login_attempt_val = sanitize_text_field($_POST['aiowps_max_login_attempts']);
			if (!is_numeric($max_login_attempt_val)) {
				$error .= '<br />' . __('You entered a non-numeric value for the max login attempts field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$max_login_attempt_val = '3'; // Set it to the default value for this field
			}
			
			$login_retry_time_period = sanitize_text_field($_POST['aiowps_retry_time_period']);
			if (!is_numeric($login_retry_time_period)) {
				$error .= '<br />' . __('You entered a non numeric value for the login retry time period field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$login_retry_time_period = '5'; // Set it to the default value for this field
			}

			$lockout_time_length = sanitize_text_field($_POST['aiowps_lockout_time_length']);
			if (!is_numeric($lockout_time_length)) {
				$error .= '<br />'.__('You entered a non numeric value for the lockout time length field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$lockout_time_length = '5'; // Set it to the default value for this field
			}

			$max_lockout_time_length = sanitize_text_field($_POST['aiowps_max_lockout_time_length']);
			if (!is_numeric($max_lockout_time_length)) {
				$error .= '<br />'.__('You entered a non numeric value for the maximim lockout time length field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$max_lockout_time_length = '60'; // Set it to the default value for this field
			}
			
			if ($lockout_time_length >= $max_lockout_time_length) {
				$error .= '<br />'.__('You entered an invalid minimum lockout time length, it must be less than the maximum lockout time length value.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Both have been set to the default values.','all-in-one-wp-security-and-firewall');
				$lockout_time_length = '5'; // Set it to the default value for this field
				$max_lockout_time_length = '60'; // Set it to the default value for this field
			}
			
			$email_addresses = isset($_POST['aiowps_email_address']) ? stripslashes($_POST['aiowps_email_address']) : get_bloginfo('admin_email');
			$email_addresses_trimmed =  AIOWPSecurity_Utility::explode_trim_filter_empty($email_addresses, "\n");
			// Read into array, sanitize, filter empty and keep only unique usernames.
			$email_address_list
				= array_unique(
					array_filter(
						array_map(
							'sanitize_email',
							$email_addresses_trimmed
						),
						'is_email'
					)
				);
			if (isset($_POST['aiowps_enable_email_notify']) && 1 == $_POST['aiowps_enable_email_notify'] && 0 == count($email_addresses_trimmed)) {
				$error .= '<br />' . __('Please fill in one or more email addresses to notify.', 'all-in-one-wp-security-and-firewall');
			} else if (isset($_POST['aiowps_enable_email_notify']) && 1 == $_POST['aiowps_enable_email_notify'] && (0 == count($email_address_list) || count($email_address_list) != count($email_addresses_trimmed))) {
				$error .= '<br />' . __('You have entered one or more invalid email addresses.', 'all-in-one-wp-security-and-firewall');
			}
			if (0 == count($email_address_list)) {
				$error .= ' ' . __('It has been set to your WordPress admin email as default.', 'all-in-one-wp-security-and-firewall');
				$email_address_list[] = get_bloginfo('admin_email');
			}

			// Instantly lockout specific usernames
			$instantly_lockout_specific_usernames = isset($_POST['aiowps_instantly_lockout_specific_usernames']) ? $_POST['aiowps_instantly_lockout_specific_usernames'] : '';
			// Read into array, sanitize, filter empty and keep only unique usernames.
			$instantly_lockout_specific_usernames
				= array_unique(
					array_filter(
						array_map(
							'sanitize_user',
							AIOWPSecurity_Utility::explode_trim_filter_empty($instantly_lockout_specific_usernames)
						),
						'strlen'
					)
				);

			if ($error) {
				$this->show_msg_error(__('Attention:', 'all-in-one-wp-security-and-firewall') . ' ' . $error);
			}

			// Save all the form values to the options
			$random_20_digit_string = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(20); // Generate random 20 char string for use during CAPTCHA encode/decode
			$aio_wp_security->configs->set_value('aiowps_unlock_request_secret_key', $random_20_digit_string);
			
			$aio_wp_security->configs->set_value('aiowps_enable_login_lockdown', isset($_POST["aiowps_enable_login_lockdown"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_allow_unlock_requests', isset($_POST["aiowps_allow_unlock_requests"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_max_login_attempts', absint($max_login_attempt_val));
			$aio_wp_security->configs->set_value('aiowps_retry_time_period', absint($login_retry_time_period));
			$aio_wp_security->configs->set_value('aiowps_lockout_time_length', absint($lockout_time_length));
			$aio_wp_security->configs->set_value('aiowps_max_lockout_time_length', absint($max_lockout_time_length));
			$aio_wp_security->configs->set_value('aiowps_set_generic_login_msg', isset($_POST["aiowps_set_generic_login_msg"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_invalid_username_lockdown', isset($_POST["aiowps_enable_invalid_username_lockdown"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_instantly_lockout_specific_usernames', $instantly_lockout_specific_usernames);
			$aio_wp_security->configs->set_value('aiowps_enable_email_notify', isset($_POST["aiowps_enable_email_notify"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_php_backtrace_in_email', isset($_POST['aiowps_enable_php_backtrace_in_email']) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_email_address', $email_address_list);
			$aio_wp_security->configs->save_config();
			
			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			
			$this->show_msg_settings_updated();
		}

		// login lockdown whitelist settings
		$result = 1;
		if (isset($_POST['aiowps_save_lockdown_whitelist_settings'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-lockdown-whitelist-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for save lockout whitelist settings.", 4);
				die('Nonce check failed for save lockout whitelist settings.');
			}

			if (isset($_POST["aiowps_lockdown_enable_whitelisting"]) && empty($_POST['aiowps_lockdown_allowed_ip_addresses'])) {
				$this->show_msg_error('You must submit at least one IP address.', 'all-in-one-wp-security-and-firewall');
			} else {
				if (!empty($_POST['aiowps_lockdown_allowed_ip_addresses'])) {
					$ip_addresses = stripslashes($_POST['aiowps_lockdown_allowed_ip_addresses']);
					$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
					$payload = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'whitelist');
					if (1 == $payload[0]) {
						// success case
						$list = $payload[1];
						$allowed_ip_data = implode("\n", $list);
						$aio_wp_security->configs->set_value('aiowps_lockdown_allowed_ip_addresses', $allowed_ip_data);
						$_POST['aiowps_lockdown_allowed_ip_addresses'] = ''; // Clear the post variable for the allowed address list
					} else {
						$result = -1;
						$error_msg = $payload[1][0];
						$this->show_msg_error($error_msg);
					}
				} else {
					$aio_wp_security->configs->set_value('aiowps_lockdown_allowed_ip_addresses', ''); //Clear the IP address config value
				}

				if (1 == $result) {
					$aio_wp_security->configs->set_value('aiowps_lockdown_enable_whitelisting', isset($_POST["aiowps_lockdown_enable_whitelisting"]) ? '1' : '', true);

					$this->show_msg_settings_updated();
				}
			}
		}

		$aio_wp_security->include_template('wp-admin/user-login/login-lockout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'locked_ip_list' => $locked_ip_list, 'result' => $result));
	}

	/**
	 * Display failed login records.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global wpdb $wpdb
	 * @return void
	 */
	protected function render_failed_login_records() {
		global $aio_wp_security, $wpdb;
		if (isset($_POST['aiowps_delete_failed_login_records'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-delete-failed-login-records-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for delete all failed login records operation.", 4);
				die('Nonce check failed for delete all failed login records operation.');
			}
			$failed_logins_table = AIOWPSEC_TBL_FAILED_LOGINS;
			// Delete all records from the failed logins table
			$result = $wpdb->query("truncate $failed_logins_table");
					
			if (false === $result) {
				$aio_wp_security->debug_logger->log_debug("User login feature - Delete all failed login records operation failed.", 4);
				$this->show_msg_error(__('User login feature - Delete all failed login records operation failed.', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->show_msg_updated(__('All records from the failed logins table were deleted successfully.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		include_once 'wp-security-list-login-fails.php'; // For rendering the AIOWPSecurity_List_Table in tab2
		$failed_login_list = new AIOWPSecurity_List_Login_Failed_Attempts(); // For rendering the AIOWPSecurity_List_Table in tab2
		
		if (isset($_REQUEST['action'])) { // Do row action tasks for list table form for failed logins
			if ($_REQUEST['action'] == 'delete_failed_login_rec') { // Delete link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
				if (!isset($nonce) || !wp_verify_nonce($nonce, 'delete_failed_login_rec')) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for delete failed login record operation!", 4);
					die(__('Nonce check failed for delete failed login record operation!','all-in-one-wp-security-and-firewall'));
				}
				$failed_login_list->delete_login_failed_records(strip_tags($_REQUEST['failed_login_id']));
			}
		}

		$aio_wp_security->include_template('wp-admin/user-login/login-records.php', false, array('failed_login_list' => $failed_login_list));
	}

	/**
	 * Force logged user to logout afte x mins.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 * @return void
	 */
	protected function render_force_logout() {
		global $aio_wp_security, $aiowps_feature_mgr;
		
		if (isset($_POST['aiowpsec_save_force_logout_settings'])) { //Do form submission tasks
			$error = '';
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-force-logout-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on force logout options save.", 4);
				die("Nonce check failed on force logout options save.");
			}

			$logout_time_period = sanitize_text_field($_POST['aiowps_logout_time_period']);
			if (!is_numeric($logout_time_period)) {
				$error .= '<br />'.__('You entered a non numeric value for the logout time period field. It has been set to the default value.','all-in-one-wp-security-and-firewall');
				$logout_time_period = '1'; // Set it to the default value for this field
			} else {
				if ($logout_time_period < 1) {
					$logout_time_period = '1';
				}
			}

			if ($error) {
				$this->show_msg_error(__('Attention:', 'all-in-one-wp-security-and-firewall') . ' ' . $error);
			}

			// Save all the form values to the options
			$aio_wp_security->configs->set_value('aiowps_logout_time_period', absint($logout_time_period));
			$aio_wp_security->configs->set_value('aiowps_enable_forced_logout', isset($_POST["aiowps_enable_forced_logout"]) ? '1' : '');
			$aio_wp_security->configs->save_config();
			
			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			
			$this->show_msg_settings_updated();
		}
		
		$aio_wp_security->include_template('wp-admin/user-login/force-logout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Displays account activity logs.
	 *
	 * @return void
	 */
	protected function render_account_activity_logs() {
		global $aio_wp_security;
		
		include_once 'wp-security-list-acct-activity.php'; // For rendering the AIOWPSecurity_List_Table in tab4
		$acct_activity_list = new AIOWPSecurity_List_Account_Activity(); // For rendering the AIOWPSecurity_List_Table in tab2
		
		if (isset($_REQUEST['action'])) { // Do row action tasks for list table form for login activity display
			if ($_REQUEST['action'] == 'delete_acct_activity_rec') { // Delete link was clicked for a row in list table
				$acct_activity_list->delete_login_activity_records(strip_tags($_REQUEST['activity_login_rec']));
			}
		}

		$aio_wp_security->include_template('wp-admin/user-login/account-activity-logs.php', false, array('acct_activity_list' => $acct_activity_list));
	}

	/**
	 * Logged in users list.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @return void
	 */
	protected function render_logged_in_users() {
		global $aio_wp_security;
		
		$logged_in_users = (is_multisite() ? get_site_transient('users_online') : get_transient('users_online'));
		
		include_once 'wp-security-list-logged-in-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Logged_In_Users();
		if (isset($_REQUEST['action'])) { // Do row action tasks for list table form for login activity display
			if ('force_user_logout' == $_REQUEST['action']) { // Force Logout link was clicked for a row in list table
				$user_list->force_user_logout(strip_tags($_REQUEST['logged_in_id']), strip_tags($_REQUEST['ip_address']));
			}
		}
		
		if (isset($_POST['aiowps_refresh_logged_in_user_list'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-logged-in-users-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for users logged in list.", 4);
				die('Nonce check failed for users logged in list.');
			}
			
			$user_list->prepare_items();
		}

		$aio_wp_security->include_template('wp-admin/user-login/logged-in-users.php', false, array('user_list' => $user_list));
	}
	
	/**
	 * Shows additional tab and field for the disable application password and saves on submit.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPSecurity_Feature_Item_Manager $aiowps_feature_mgr
	 * @return void
	 */
	protected function render_additional() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowpsec_save_additonal_settings'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-additonal-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on additonal settings save.", 4);
				die("Nonce check failed on additonal settings save.");
			}

			// Save all the form values to the options
			$aio_wp_security->configs->set_value('aiowps_disable_application_password', isset($_POST['aiowps_disable_application_password']) ? '1' : '', true);

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}

		$aio_wp_security->include_template('wp-admin/user-login/additional.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

} //end class
