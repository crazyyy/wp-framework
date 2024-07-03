<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_User_Security_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * User Security menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_USER_SECURITY_MENU_SLUG;

	/**
	 * Constructor adds menu for User Security
	 */
	public function __construct() {
		parent::__construct(__('User Security', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * Populates $menu_tabs array.
	 *
	 * @return Void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'wp-user_accounts' => array(
				'title' => __('User accounts', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_user_account'),
			),
			'login-lockout' => array(
				'title' => __('Login lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_login_lockout'),
			),
			'force-logout' => array(
				'title' => __('Force logout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_force_logout'),
			),
			'logged-in-users' => array(
				'title' => __('Logged in users', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_logged_in_users'),
			),
			'manual-approval' => array(
				'title' => __('Manual approval', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_manual_approval'),
			),
			'salt' => array(
				'title' => __('Salt', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_salt_tab'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'additional' => array(
				'title' => __('Additional settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_additional'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Renders the submenu's WP User Account tab
	 *
	 * @return Void
	 */
	protected function render_wp_user_account() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_change_admin_username'])) { // Do form submission tasks
			echo $this->validate_change_username_form();
		}
		
		$user_accounts = '';
		
		if (is_multisite()) { // Multi-site: get admin accounts for current site
			$blog_id = get_current_blog_id();
			$user_accounts = $this->get_all_admin_accounts($blog_id);
		} else {
			$user_accounts = $this->get_all_admin_accounts();
		}

		if (isset($_POST['aiowpsec_save_users_enumeration'])) {
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'aiowpsec-users-enumeration');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die("Nonce check failed on prevent user enumeration feature settings save.");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_prevent_users_enumeration', isset($_POST["aiowps_prevent_users_enumeration"]) ? '1' : '', true);

			$this->show_msg_updated(__('User Enumeration Prevention feature settings saved!', 'all-in-one-wp-security-and-firewall'));

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		}
		
		$aio_wp_security->include_template('wp-admin/user-security/wp-username.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'user_accounts' => $user_accounts, 'AIOWPSecurity_User_Security_Menu' => $this));
		
		$aio_wp_security->include_template('wp-admin/user-security/display-name.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));

		$aio_wp_security->include_template('wp-admin/user-security/user-enumeration.php', false, array());
	}

	/**
	 * This function will validate the new username before changing it
	 *
	 * @return string - the html result
	 */
	private function validate_change_username_form() {
		global $wpdb;
		global $aio_wp_security;
		$errors = '';
		$nonce=$_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($nonce, 'aiowpsec-change-admin-nonce')) {
			$aio_wp_security->debug_logger->log_debug("Nonce check failed on admin username change operation.", 4);
			die('Nonce check failed on admin username change operation.');
		}
		if (!empty($_POST['aiowps_new_user_name'])) {
			$new_username = sanitize_text_field($_POST['aiowps_new_user_name']);
			if (validate_username($new_username)) {
				if (AIOWPSecurity_Utility::check_user_exists($new_username)) {
					$errors .= sprintf(__('Username: %s already exists, please enter another value.', 'all-in-one-wp-security-and-firewall'), $new_username);
				} else {
					// let's check if currently logged in username is 'admin'
					$user = wp_get_current_user();
					$user_login = $user->user_login;
					if (strtolower($user_login) == 'admin') {
						$username_is_admin = true;
					} else {
						$username_is_admin = false;
					}
					// Now let's change the username
					$sql = $wpdb->prepare("UPDATE `" . $wpdb->users . "` SET user_login = '" . esc_sql($new_username) . "' WHERE user_login=%s", "admin");
					$result = $wpdb->query($sql);
					if (!$result) {
						// There was an error updating the users table
						$user_update_error = __('The database update operation of the user account failed.', 'all-in-one-wp-security-and-firewall');
						// TODO## - add error logging here
						$return_msg = '<div id="message" class="updated fade"><p>'.$user_update_error.'</p></div>';
						return $return_msg;
					}

					// multisite considerations
					if (is_multisite()) { // process sitemeta if we're in a multi-site situation
						$oldAdmins = $wpdb->get_var("SELECT meta_value FROM `" . $wpdb->sitemeta . "` WHERE meta_key = 'site_admins'");
						$newAdmins = str_replace('5:"admin"', strlen($new_username) . ':"' . esc_sql($new_username) . '"', $oldAdmins);
						$wpdb->query("UPDATE `" . $wpdb->sitemeta . "` SET meta_value = '" . esc_sql($newAdmins) . "' WHERE meta_key = 'site_admins'");
					}

					// If user is logged in with username "admin" then log user out and send to login page so they can login again
					if ($username_is_admin) {
						// Lets logout the user
						$aio_wp_security->debug_logger->log_debug("Logging user out with login ".$user_login. " because they changed their username.");
						$after_logout_url = AIOWPSecurity_Utility::get_current_page_url();
						$after_logout_payload = array('redirect_to' => $after_logout_url, 'msg' => $aio_wp_security->user_login_obj->key_login_msg.'=admin_user_changed');
						//Save some of the logout redirect data to a transient
						is_multisite() ? set_site_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60) : set_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60);
						
						$logout_url = AIOWPSEC_WP_URL.'?aiowpsec_do_log_out=1';
						$logout_url = AIOWPSecurity_Utility::add_query_data_to_url($logout_url, 'al_additional_data', '1');
						AIOWPSecurity_Utility::redirect_to_url($logout_url);
					}
				}
			} else { // An invalid username was entered
				$errors .= __('You entered an invalid username, please enter another value.', 'all-in-one-wp-security-and-firewall');
			}
		} else { // No username value was entered
			$errors .= __('Please enter a value for your username. ', 'all-in-one-wp-security-and-firewall');
		}

		if (strlen($errors) > 0) { // We have some validation or other error
			$return_msg = '<div id="message" class="error"><p>' . $errors . '</p></div>';
		} else {
			$return_msg = '<div id="message" class="updated fade"><p>'.__('The username has been successfully changed.', 'all-in-one-wp-security-and-firewall').'</p></div>';
		}
		return $return_msg;
	}
	
	/**
	 * This function will retrieve all user accounts which have 'administrator' role and will return html code with results in a table
	 *
	 * @param string $blog_id - the blog we want to get the user account information from
	 *
	 * @return string - the html from the result
	 */
	private function get_all_admin_accounts($blog_id = '') {
		// TODO: Have included the "blog_id" variable for future use for cases where people want to search particular blog (eg, multi-site)
		if ($blog_id) {
			$admin_users = get_users('blog_id='.$blog_id.'&orderby=login&role=administrator');
		} else {
			$admin_users = get_users('orderby=login&role=administrator');
		}
		// now let's put the results in an HTML table
		$account_output = "";
		if (!empty($admin_users)) {
			$account_output .= '<table>';
			$account_output .= '<tr><th>'.esc_html(__('Account login name', 'all-in-one-wp-security-and-firewall')).'</th></tr>';
			foreach ($admin_users as $entry) {
				$account_output .= '<tr>';
				if (strtolower($entry->user_login) == 'admin') {
					$account_output .= '<td style="color:red; font-weight: bold;">'.esc_html($entry->user_login).'</td>';
				} else {
					$account_output .= '<td>'.esc_html($entry->user_login).'</td>';
				}
				$user_acct_edit_link = admin_url('user-edit.php?user_id=' . $entry->ID);
				$account_output .= '<td><a href="'.esc_url($user_acct_edit_link).'" target="_blank">'.esc_html(__('Edit user', 'all-in-one-wp-security-and-firewall')).'</a></td>';
				$account_output .= '</tr>';
			}
			$account_output .= '</table>';
		}
		return $account_output;
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
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-login-lockdown-nonce')) {
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
				$error .= '<br />'.__('You entered a non numeric value for the maximum lockout time length field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$max_lockout_time_length = '60'; // Set it to the default value for this field
			}
			
			if ($lockout_time_length >= $max_lockout_time_length) {
				$error .= '<br />'.__('You entered an invalid minimum lockout time length, it must be less than the maximum lockout time length value.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Both have been set to the default values.', 'all-in-one-wp-security-and-firewall');
				$lockout_time_length = '5'; // Set it to the default value for this field
				$max_lockout_time_length = '60'; // Set it to the default value for this field
			}
			
			$email_addresses = isset($_POST['aiowps_email_address']) ? stripslashes($_POST['aiowps_email_address']) : get_bloginfo('admin_email');
			$email_addresses_trimmed = AIOWPSecurity_Utility::explode_trim_filter_empty($email_addresses, "\n");
			// Read into array, sanitize, filter empty and keep only unique usernames.
			$email_address_list = array_unique(
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
			} elseif (isset($_POST['aiowps_enable_email_notify']) && 1 == $_POST['aiowps_enable_email_notify'] && (0 == count($email_address_list) || count($email_address_list) != count($email_addresses_trimmed))) {
				$error .= '<br />' . __('You have entered one or more invalid email addresses.', 'all-in-one-wp-security-and-firewall');
			}
			if (0 == count($email_address_list)) {
				$error .= ' ' . __('It has been set to your WordPress admin email as default.', 'all-in-one-wp-security-and-firewall');
				$email_address_list[] = get_bloginfo('admin_email');
			}

			// Instantly lockout specific usernames
			$instantly_lockout_specific_usernames = isset($_POST['aiowps_instantly_lockout_specific_usernames']) ? $_POST['aiowps_instantly_lockout_specific_usernames'] : '';
			// Read into array, sanitize, filter empty and keep only unique usernames.
			$instantly_lockout_specific_usernames = array_unique(
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

			if (!empty($_POST['aiowps_lockdown_allowed_ip_addresses'])) {
				$ip_addresses = stripslashes($_POST['aiowps_lockdown_allowed_ip_addresses']);
				$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
				$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'whitelist');
				if (is_wp_error($validated_ip_list_array)) {
					$result = -1;
					$this->show_msg_error(nl2br($validated_ip_list_array->get_error_message()));
				} else {
					$allowed_ip_data = implode("\n", $validated_ip_list_array);
					$aio_wp_security->configs->set_value('aiowps_lockdown_allowed_ip_addresses', $allowed_ip_data);
					$_POST['aiowps_lockdown_allowed_ip_addresses'] = ''; // Clear the post variable for the allowed address list.
				}
			} else {
				$aio_wp_security->configs->set_value('aiowps_lockdown_allowed_ip_addresses', ''); //Clear the IP address config value
			}

			if (1 == $result) {
				$aio_wp_security->configs->set_value('aiowps_lockdown_enable_whitelisting', isset($_POST["aiowps_lockdown_enable_whitelisting"]) ? '1' : '', true);

				$this->show_msg_settings_updated();
				//Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			}
		}

		$aiowps_lockdown_allowed_ip_addresses = isset($_POST['aiowps_lockdown_allowed_ip_addresses']) ? wp_unslash($_POST['aiowps_lockdown_allowed_ip_addresses']) : '';
		$aiowps_lockdown_allowed_ip_addresses = -1 == $result ? stripslashes($aiowps_lockdown_allowed_ip_addresses) : $aio_wp_security->configs->get_value('aiowps_lockdown_allowed_ip_addresses');

		$aio_wp_security->include_template('wp-admin/user-security/login-lockout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'locked_ip_list' => $locked_ip_list, "aiowps_lockdown_allowed_ip_addresses" => $aiowps_lockdown_allowed_ip_addresses));
	}

	/**
	 * Force logged user to logout afte x mins.
	 *
	 * @global AIO_WP_Security                    $aio_wp_security
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
				$error .= '<br />'.__('You entered a non numeric value for the logout time period field, it has been set to the default value.', 'all-in-one-wp-security-and-firewall');
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
		
		$aio_wp_security->include_template('wp-admin/user-security/force-logout.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Logged in users list.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @return void
	 */
	protected function render_logged_in_users() {
		global $aio_wp_security;

		include_once 'wp-security-list-logged-in-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Logged_In_Users();
		if (isset($_REQUEST['action'])) { // Do row action tasks for list table form for login activity display
			if ('force_user_logout' == $_REQUEST['action']) { // Force Logout link was clicked for a row in list table
				$nonce = isset($_REQUEST['aiowps_nonce']) ? $_REQUEST['aiowps_nonce'] : '';
				$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'force_user_logout');
				if (is_wp_error($result)) {
					$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
					die($result->get_error_message());
				}
				$user_list->force_user_logout(strip_tags($_REQUEST['logged_in_id']));
			}
		}
		
		if (isset($_POST['aiowps_refresh_logged_in_user_list'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-logged-in-users-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for users logged in list.", 4);
				die('Nonce check failed for users logged in list.');
			}
			
			$user_list->prepare_items();
		}

		$page = $_REQUEST['page'];
		$tab = $_REQUEST["tab"];

		$aio_wp_security->include_template('wp-admin/user-security/logged-in-users.php', false, array('user_list' => $user_list, 'page' => $page, 'tab' => $tab));
	}

	/**
	 * Renders the submenu's manual approval tab
	 *
	 * @return Void
	 */
	protected function render_manual_approval() {
		global $aio_wp_security, $aiowps_feature_mgr;

		include_once 'wp-security-list-registered-users.php'; // For rendering the AIOWPSecurity_List_Table
		$user_list = new AIOWPSecurity_List_Registered_Users();

		if (isset($_POST['aiowps_save_user_registration_settings'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-user-registration-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on save user registration settings.", 4);
				die("Nonce check failed on save user registration settings.");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_enable_manual_registration_approval', isset($_POST["aiowps_enable_manual_registration_approval"]) ? '1' : '', true);

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_updated(__('Settings were successfully saved', 'all-in-one-wp-security-and-firewall'));
		}

		if (isset($_GET['action'])) { // Do list table form row action tasks
			$nonce = isset($_GET['aiowps_nonce']) ? $_GET['aiowps_nonce'] : '';
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'registered_user_item_action');
			
			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			if ('approve_acct' == $_GET['action']) { // Approve link was clicked for a row in list table
				$user_list->approve_selected_accounts(strip_tags($_GET['user_id']));
			}

			if ('delete_acct' == $_GET['action']) { // Delete link was clicked for a row in list table
				$user_list->delete_selected_accounts(strip_tags($_GET['user_id']));
			}

			if ('block_ip' == $_GET['action']) { // Block IP link was clicked for a row in list table
				$user_list->block_selected_ips(strip_tags($_GET['ip_address']));
			}
		}

		$page = $_REQUEST['page'];
		$tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : '';

		$aio_wp_security->include_template('wp-admin/user-security/manual-approval.php', false, array('user_list' => $user_list, 'aiowps_feature_mgr' => $aiowps_feature_mgr, 'page' => $page, 'tab' => $tab));
	}

	/**
	 * Renders the submenu's salt tab
	 *
	 * @return Void
	 */
	protected function render_salt_tab() {
		global $aio_wp_security, $aiowps_feature_mgr;
		if (isset($_POST['aios_save_salt_postfix_settings'])) {
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aios-salt-postfix-settings');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}
			//Save settings
			$aiowps_enable_salt_postfix = isset($_POST['aiowps_enable_salt_postfix']) ? '1' : '';
			if ($aiowps_enable_salt_postfix == $aio_wp_security->configs->get_value('aiowps_enable_salt_postfix')) {
				$is_setting_changed = true;
			} else {
				$is_setting_changed = false;
			}

			$aio_wp_security->configs->set_value('aiowps_enable_salt_postfix', $aiowps_enable_salt_postfix, true);
			$ret_schedule = $this->schedule_change_auth_keys_and_salt();

			if (is_wp_error($ret_schedule)) {
				$aio_wp_security->debug_logger->log_debug($ret_schedule->get_error_message(), 4);
			}

			if ('1' == $aiowps_enable_salt_postfix && $is_setting_changed) {
				AIOWPSecurity_Utility::change_salt_postfixes();
			}

			$this->show_msg_updated(__('Salt postfix feature settings saved.', 'all-in-one-wp-security-and-firewall'));
			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		}

		$aio_wp_security->include_template('wp-admin/miscellaneous/salt.php');
	}

	/**
	 * Schedule weekly aios_change_auth_keys_and_salt cron event.
	 *
	 * @return Boolean|WP_Error  True if event successfully scheduled. False or WP_Error on failure.
	 */
	private function schedule_change_auth_keys_and_salt() {
		$previous_time = wp_next_scheduled('aios_change_auth_keys_and_salt');

		if (false !== $previous_time) {
			// Clear schedule so that we don't stack up scheduled backups
			wp_clear_scheduled_hook('aios_change_auth_keys_and_salt');
		}
		$gmt_offset_in_seconds = floatval(get_option('gmt_offset')) * 3600;
		$first_time = strtotime('next Sunday '.apply_filters('aios_salt_change_schedule_time', '3:00 am')) + $gmt_offset_in_seconds;
		return wp_schedule_event($first_time, 'weekly', 'aios_change_auth_keys_and_salt');
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
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on additional settings save.", 4);
				die("Nonce check failed on additional settings save.");
			}

			// Save all the form values to the options
			$aio_wp_security->configs->set_value('aiowps_disable_application_password', isset($_POST['aiowps_disable_application_password']) ? '1' : '', true);

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}

		$aio_wp_security->include_template('wp-admin/user-security/additional.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}
}
