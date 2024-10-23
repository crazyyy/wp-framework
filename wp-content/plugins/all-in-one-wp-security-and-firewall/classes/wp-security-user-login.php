<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_User_Login {
	
	public $key_login_msg;// This will store a URI query string key for passing messages to the login form

	public function __construct() {
		global $aio_wp_security;
		$this->key_login_msg = 'aiowps_login_msg_id';
		// As a first authentication step, check if user's IP is locked.
		add_filter('authenticate', array($this, 'block_ip_if_locked'), 1, 1);
		// Check whether user needs to be manually approved after default WordPress authenticate hooks (with priority 20).
		add_filter('authenticate', array($this, 'check_manual_registration_approval'), 30, 1);
		// Check login CAPTCHA
		if ($aio_wp_security->configs->get_value('aiowps_enable_login_captcha')) {
			add_filter('authenticate', array($this, 'check_captcha'), 20, 1);
		}
		// As a last authentication step, perform post authentication steps
		add_filter('authenticate', array($this, 'post_authenticate'), 100, 3);
		add_action('aiowps_force_logout_check', array($this, 'aiowps_force_logout_action_handler'));
		add_action('wp_logout', array($this, 'wp_logout_action_handler'), 10, 1);
		add_filter('login_message', array($this, 'aiowps_login_message')); //WP filter to add or modify messages on the login page

		// Display disable lockdown message
		if (is_admin() && AIOWPSecurity_Utility_Permissions::has_manage_cap() && $aio_wp_security->is_login_lockdown_by_const() && $this->is_admin_page_to_display_disable_login_lockdown_by_const_notice()) {
			add_action('all_admin_notices', array($this, 'disable_login_lockdown_by_const_notice'));
		}

		add_action('set_auth_cookie', array($this, 'handle_logged_in_user'), 10, 4);

		//cron job to remove expired users from logged_in table
		add_action('delete_expired_logged_in_users_event', array($this, 'delete_expired_logged_in_users'));

		add_filter('retrieve_password_message', array($this, 'aiowps_retrieve_password_message'), 10, 1);
	}

	/**
	 * Check whether the admin page is to display disable login lockdown by const notice.
	 *
	 * @return boolean True if the notice will be displayed, Otherwise false.
	 */
	private function is_admin_page_to_display_disable_login_lockdown_by_const_notice() {
		global $pagenow;
		if (in_array($pagenow, array('index.php', 'plugins.php'))) {
			return true;
		} elseif (('admin.php' == $pagenow && isset($_GET['page']) && false !== strpos($_GET['page'], AIOWPSEC_MENU_SLUG_PREFIX)) && !$this->is_locked_ip_addresses_tab_admin_page()) {
			return true;
		}
		return false;
	}

	/**
	 * Check whether the admin page is Locked IP Addresses Tab page.
	 *
	 * @return boolean True if is Locked IP Addresses Tab page, Otherwise false.
	 */
	private function is_locked_ip_addresses_tab_admin_page() {
		global $pagenow;
		return ('admin.php' == $pagenow && isset($_GET['page']) && 'aiowpsec' == $_GET['page'] && isset($_GET['tab']) && 'locked-ip' == $_GET['tab']);
	}

	/**
	 * Displays admin to disable lockdown message.
	 *
	 * @return Void
	 */
	public function disable_login_lockdown_by_const_notice() {

		if (!AIOWPSecurity_Utility_Permissions::has_manage_cap()) {
			return;
		}

		echo '<div class="notice notice-error">
					<p>'.
						__('You have disabled login lockout by defining the AIOS_DISABLE_LOGIN_LOCKOUT constant value as true, and the login lockout setting has enabled it.', 'all-in-one-wp-security-and-firewall') . ' ' .
						/* translators: 1: Locked IP Addresses admin page link */
						sprintf(__('Delete your login lockout IP from %s and define the AIOS_DISABLE_LOGIN_LOCKOUT constant value as false.', 'all-in-one-wp-security-and-firewall'),
							'<a href="'.admin_url('admin.php?page=aiowpsec&tab=locked-ip').'">' . __('Locked IP addresses', 'all-in-one-wp-security-and-firewall') . '</a>'
						).
					'</p>
				</div>';
	}

	/**
	 * Terminate the execution via wp_die with 503 status code, if current
	 * user's IP is currently locked.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @param WP_Error|WP_User $user
	 * @return WP_User
	 */
	public function block_ip_if_locked($user) {
		global $aio_wp_security;

		// Allow users to login when disable AIOWPS_DISABLE_LOCK_DOWN defined true
		if ($aio_wp_security->is_login_lockdown_by_const()) {
			return $user;
		}

		$user_locked = $this->check_locked_user();
		if (null != $user_locked) {
			$aio_wp_security->debug_logger->log_debug("Login attempt from blocked IP range - ".$user_locked['failed_login_ip'], 2);
			// Allow the error message to be filtered.
			$error_msg = apply_filters('aiowps_ip_blocked_error_msg', sprintf(__('%s: Access from your IP address has been blocked for security reasons.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('ERROR', 'all-in-one-wp-security-and-firewall') . '</strong>') . ' ' . __('Please contact the administrator.', 'all-in-one-wp-security-and-firewall'));
			// If unlock requests are allowed, add the "Request Unlock" button to the message.
			$unlock_form = '';
			if ($aio_wp_security->configs->get_value('aiowps_allow_unlock_requests') == '1') {
				$unlock_form = $this->get_unlock_request_form();
				$error_msg .= $unlock_form;
			}
			$error_msg = apply_filters('aiowps_ip_blocked_output_page', $error_msg, $unlock_form); //filter the complete output of the locked page
			wp_die($error_msg, __('Service temporarily unavailable', 'all-in-one-wp-security-and-firewall'), 503);
		} else {
			return $user;
		}
	}

	/**
	 * Check login CAPTCHA (if enabled).
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @param WP_Error|WP_User $user
	 * @return WP_Error|WP_User
	 */
	public function check_captcha($user) {
		global $aio_wp_security;
		if (is_wp_error($user) || $aio_wp_security->is_login_lockdown_by_const()) {
			// Authentication has failed already at some earlier step.
			return $user;
		}

		if (! (isset($_POST['log']) && isset($_POST['pwd']))) {
			// XML-RPC authentication (not via wp-login.php), nothing to do here.
			return $user;
		}

		if ($aio_wp_security->configs->get_value('aiowps_enable_login_captcha') != '1') {
			// CAPTCHA not enabled, nothing to do here.
			return $user;
		}
		$captcha_error = new WP_Error('authentication_failed', sprintf(__('%s: Your answer was incorrect - please try again.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('ERROR', 'all-in-one-wp-security-and-firewall') . '</strong>'));
		$verify_captcha = $aio_wp_security->captcha_obj->verify_captcha_submit();
		if (false === $verify_captcha) {
			return $captcha_error;
		}
		return $user;
	}

	/**
	 * Check, whether $user needs to be manually approved by site admin yet.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @param WP_Error|WP_User $user
	 * @return WP_Error|WP_User
	 */
	public function check_manual_registration_approval($user) {
		global $aio_wp_security;
		if (!($user instanceof WP_User)) {
			// Not a WP_User - nothing to do here.
			return $user;
		}
		//Check if auto pending new account status feature is enabled
		if ($aio_wp_security->configs->get_value('aiowps_enable_manual_registration_approval') == '1') {
			$aiowps_account_status = get_user_meta($user->ID, 'aiowps_account_status', true);
			if ('pending' == $aiowps_account_status) {
				// Account needs to be activated yet
				return new WP_Error('account_pending', sprintf(__('%s: Your account is currently not active.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('ACCOUNT PENDING', 'all-in-one-wp-security-and-firewall') . '</strong>') . ' '. __('An administrator needs to activate your account before you can login.', 'all-in-one-wp-security-and-firewall'));
			}
		}
		return $user;
	}

	/**
	 * Handle post authentication steps (in case of failed login):
	 * - increment number of failed logins for $username
	 * - (optionally) lock the user
	 * - (optionally) display a generic error message
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @param WP_Error|WP_User $user
	 * @param string           $username
	 * @param string           $password
	 * @return WP_Error|WP_User
	 */
	public function post_authenticate($user, $username, $password) {
		global $aio_wp_security;
		if (!is_wp_error($user)) {
			// Authentication has been successful, there's nothing to do here.
			return $user;
		}
		if (empty($username) || empty($password)) {
			// Neither log nor block login attempts with empty username or password.
			return $user;
		}
		if ($user->get_error_code() === 'account_pending') {
			// Neither log nor block users attempting to log in before their registration is approved.
			return $user;
		}
		// Login failed for non-trivial reason
		AIOWPSecurity_Audit_Events::event_failed_login($username);
		if ($aio_wp_security->configs->get_value('aiowps_enable_login_lockdown') == '1') {
			$is_whitelisted = false;
			//check if lockout whitelist enabled
			if ($aio_wp_security->configs->get_value('aiowps_lockdown_enable_whitelisting') == '1') {
				$whitelisted_ips = $aio_wp_security->configs->get_value('aiowps_lockdown_allowed_ip_addresses');
				$is_whitelisted = AIOWPSecurity_Utility_IP::is_userip_whitelisted($whitelisted_ips);
			}

			if (false === $is_whitelisted) {
				// Too many failed logins from user's IP?
				$login_attempts_permitted = absint($aio_wp_security->configs->get_value('aiowps_max_login_attempts'));
				$too_many_failed_logins = $login_attempts_permitted <= $this->get_login_fail_count();

				// Is an invalid username or email the reason for login error?
				$invalid_username = ($user->get_error_code() === 'invalid_username' || $user->get_error_code() == 'invalid_email');
				// Should an invalid username be immediately locked?
				$invalid_username_lockdown = $aio_wp_security->configs->get_value('aiowps_enable_invalid_username_lockdown') == '1';
				$lock_invalid_username = $invalid_username && $invalid_username_lockdown;

				// Should an invalid username be blocked as per blacklist?
				$instant_lockout_users_list = $aio_wp_security->configs->get_value('aiowps_instantly_lockout_specific_usernames');
				if (!is_array($instant_lockout_users_list)) {
					$instant_lockout_users_list = array();
				}
				$username_blacklisted = $invalid_username && in_array($username, $instant_lockout_users_list);

				$lock_reasons = array();
				if ($too_many_failed_logins) {
					$lock_reasons[] = 'too_many_failed_logins';
				}
				if ($lock_invalid_username) {
					$lock_reasons[] = 'invalid_username';
				}
				if ($username_blacklisted) {
					$lock_reasons[] = 'username_blacklisted';
				}
				if ($lock_reasons) {
					$this->lock_the_user($username, implode(',', $lock_reasons));
				}
			}
		}

		if ($aio_wp_security->configs->get_value('aiowps_set_generic_login_msg') == '1') {
			// Return generic error message if configured
			return new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid login credentials.', 'all-in-one-wp-security-and-firewall'));
		}
		return $user;
	}
	/**
	 * This function queries the aiowps_login_lockdown table.
	 * If the release_date has not expired AND the current visitor IP addr matches
	 * it will return a record
	 */
	public function check_locked_user() {
		global $wpdb;
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$ip = AIOWPSecurity_Utility_IP::get_user_ip_address(); //Get the IP address of user
		if (empty($ip)) return false;
		$locked_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $login_lockdown_table WHERE `released` > UNIX_TIMESTAMP() AND `failed_login_ip` = %s", $ip), ARRAY_A);
		return $locked_user;
	}
	/**
	 * This function queries the aiowps_audit_log table and returns the number of failures for current IP range within allowed failure period
	 */
	public function get_login_fail_count() {

		global $wpdb, $aio_wp_security;
		
		$audit_log_table = AIOWPSEC_TBL_AUDIT_LOG;
		$login_retry_interval = $aio_wp_security->configs->get_value('aiowps_retry_time_period') * 60;
		$now = time();
		$ip = AIOWPSecurity_Utility_IP::get_user_ip_address(); // Get the users IP address

		if (empty($ip)) return false;

		$login_failures = $wpdb->get_var("SELECT COUNT(ID) FROM $audit_log_table " . "WHERE created + " . esc_sql($login_retry_interval) . " > '" . esc_sql($now) . "' AND " . "ip = '" . esc_sql($ip) . "' AND event_type = 'failed_login'");
		return $login_failures;
	}

	/**
	 * Get lockout time dynamically multiplied with default lockout time
	 *
	 * @return Integer get lockout time length.
	 */
	public function get_dynamic_lockout_time_length() {
		global $aio_wp_security;

		$login_fail_count = $this->get_login_fail_count();
		$lockout_time_default = $aio_wp_security->configs->get_value('aiowps_lockout_time_length');
		if (!is_numeric($lockout_time_default)) {
			$lockout_time_default = 5;
		}
		$lockout_time_max = $aio_wp_security->configs->get_value('aiowps_max_lockout_time_length');
		if (!is_numeric($lockout_time_max)) {
			$lockout_time_max = 60;
		}
		$lockout_time_length = (int) ($login_fail_count > 0 ? (3 * $lockout_time_default * ($login_fail_count + 1)) : $lockout_time_default);

		return $lockout_time_length >= $lockout_time_max ? $lockout_time_max : $lockout_time_length;
	}

	/**
	 * Adds an entry to the `aiowps_login_lockdown` table.
	 *
	 * @param string $username              User's username or email
	 * @param string $lock_reason
	 * @param bool   $is_lockout_email_sent flag for lockout email send
	 */
	public function lock_the_user($username, $lock_reason = 'login_fail', $is_lockout_email_sent = 0) {
		global $aio_wp_security;
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$lock_minutes = $this->get_dynamic_lockout_time_length();
		$ip = AIOWPSecurity_Utility_IP::get_user_ip_address(); //Get the IP address of user
		if (empty($ip)) return;
		$ip_range = AIOWPSecurity_Utility_IP::get_sanitized_ip_range($ip); //Get the IP range of the current user
		$user = is_email($username) ? get_user_by('email', $username) : get_user_by('login', $username); //Returns WP_User object if exists
		$ip_range = apply_filters('aiowps_before_lockdown', $ip_range);
		if ($user) {
			//If the login attempt was made using a valid user set variables for DB storage later on
			$user_id = $user->ID;
		} else {
			//If the login attempt was made using a non-existent user then let's set user_id to blank and record the attempted user login name for DB storage later on
			$user_id = 0;
		}

		$lock_time = current_time('mysql', true);
		$date = new DateTime($lock_time);
		$add_interval = 'PT'.absint($lock_minutes).'M';
		$date->add(new DateInterval($add_interval));
		$release_time = $date->format('Y-m-d H:i:s');
		$backtrace_log = '';
		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_php_backtrace_in_email')) {
			$backtrace_log = AIOWPSecurity_Utility::normalise_call_stack_args(debug_backtrace());
			$backtrace_log = print_r($backtrace_log, true);
		}
		$is_lockout_email_sent = (1 == $aio_wp_security->configs->get_value('aiowps_enable_email_notify') ? 0 : -1);
		$ip_lookup_result = AIOS_Helper::get_ip_reverse_lookup($ip);
		$ip_lookup_result = json_encode($ip_lookup_result);
		if (false === $ip_lookup_result) $ip_lookup_result = null;

		$lock_seconds = $lock_minutes * MINUTE_IN_SECONDS;
		
		$data = array(
			'user_id' => $user_id,
			'user_login' => $username,
			'lockdown_date' => $lock_time,
			'release_date' => $release_time,
			'failed_login_IP' => $ip,
			'lock_reason' => $lock_reason,
			'is_lockout_email_sent' => $is_lockout_email_sent,
			'backtrace_log' => $backtrace_log,
			'ip_lookup_result' => $ip_lookup_result,
			'lock_seconds' => $lock_seconds
		);
		
		$result = AIOWPSecurity_Utility::add_lockout($data);

		if (false === $result) {
			$aio_wp_security->debug_logger->log_debug("Error inserting record into ".$login_lockdown_table, 4);
		} else {
			do_action('aiowps_lockdown_event', $ip_range, $username);
			$aio_wp_security->debug_logger->log_debug("The following IP address range has been locked out for exceeding the maximum login attempts: ".$ip_range, 2);
		}
	}

	/**
	 * Send IP Lock notification.
	 *
	 * @param Array  $lockout_ips_list   have username, ip_range, ip
	 * @param String $backtrace_filepath
	 *
	 * @return Boolean True if mail sent otherwise false.
	 */
	private function send_ip_lock_notification_email($lockout_ips_list = array(), $backtrace_filepath = '') {
		global $aio_wp_security;
		$send_mail = false;
		if (0 != count($lockout_ips_list)) {
			$email_notification_enabled = $aio_wp_security->configs->get_value('aiowps_enable_email_notify');
			if (1 == $email_notification_enabled) {
				$to_email_address = AIOWPSecurity_Utility::get_array_from_textarea_val($aio_wp_security->configs->get_value('aiowps_email_address'));
				if (empty($to_email_address)) {
					$to_email_address = array(get_site_option('admin_email'));
				}
				$subject = '['.get_option('home').'] '. __('Site Lockout Notification', 'all-in-one-wp-security-and-firewall');
				$email_msg = __('User login lockout events had occurred due to too many failed login attempts or invalid username:', 'all-in-one-wp-security-and-firewall')."\n\n";
			
				foreach ($lockout_ips_list as $lockout_ip) {
					$email_msg .= sprintf(__('Username: %s', 'all-in-one-wp-security-and-firewall'), $lockout_ip['username']) . "\n";
					$email_msg .= sprintf(__('IP address: %s', 'all-in-one-wp-security-and-firewall'), $lockout_ip['ip']) . "\n";
					if ('' != $lockout_ip['ip_range']) {
						$email_msg .= sprintf(__('IP range: %s', 'all-in-one-wp-security-and-firewall'), $lockout_ip['ip_range']) . '.*' . "\n";
					}
					if (!empty($lockout_ip['ip_lookup_result'])) {
						$ip_lookup_result = json_decode($lockout_ip['ip_lookup_result'], true);

						$org = empty($ip_lookup_result['org']) ? __('Not Found', 'all-in-one-wp-security-and-firewall') : $ip_lookup_result['org'];
						$as = empty($ip_lookup_result['as']) ? __('Not Found', 'all-in-one-wp-security-and-firewall') : $ip_lookup_result['as'];

						$email_msg .= sprintf(__('Org: %s', 'all-in-one-wp-security-and-firewall'), $org) . "\n";
						$email_msg .= sprintf(__('AS: %s', 'all-in-one-wp-security-and-firewall'), $as) . "\n";

						$email_msg = apply_filters('aiowps_login_lockdown_email_message', $email_msg, $ip_lookup_result);
					}
					$email_msg .= "\n";
				}
			
				$email_msg .= __("Log into your site WordPress administration panel to see the duration of the lockout or to unlock the user.", 'all-in-one-wp-security-and-firewall') . "\n";

				$email_header = '';
				$send_mail = wp_mail($to_email_address, $subject, $email_msg, $email_header, $backtrace_filepath);
			
				if (false === $send_mail) {
					$ips_list = implode(', ', wp_list_pluck($lockout_ips_list, 'ip'));
					$aio_wp_security->debug_logger->log_debug("Lockout notification email failed to send to " . implode(', ', $to_email_address) . " for IPs ".$ips_list, 4);
				}
			}
		}
		return $send_mail;
	}

	/**
	 * Generates and returns an unlock request link which will be used to send to the user.
	 *
	 * @global type $wpdb
	 * @global AIO_WP_Security $aio_wp_security
	 * @param type $ip_range
	 * @return string or false on failure
	 */
	public static function generate_unlock_request_link($ip_range) {
		//Get the locked user row from locout table
		global $wpdb, $aio_wp_security;
		$unlock_link = '';
		$lockout_table_name = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$secret_rand_key = (md5(uniqid(rand(), true)));
		$res = $wpdb->query($wpdb->prepare("UPDATE $lockout_table_name SET unlock_key = %s WHERE released > UNIX_TIMESTAMP() AND failed_login_ip LIKE %s", $secret_rand_key,  "%" . esc_sql($ip_range) . "%"));
		if (null == $res) {
			$aio_wp_security->debug_logger->log_debug("No locked user found with IP range ".$ip_range, 4);
			return false;
		} else {
			// Check if unlock request or submitted from a WooCommerce account login page
			if (isset($_POST['aiowps-woo-login'])) {
				$date_time = current_time('mysql');
				$data = array('date_time' => $date_time, 'meta_key1' => 'woo_unlock_request_key', 'meta_value1' => $secret_rand_key);
				$aiowps_global_meta_tbl_name = AIOWPSEC_TBL_GLOBAL_META_DATA;
				$sql = $wpdb->prepare("INSERT INTO ".$aiowps_global_meta_tbl_name." (date_time, meta_key1, meta_value1, created) VALUES ('%s', '%s', '%s', UNIX_TIMESTAMP())", $data['date_time'], $data['meta_key1'], $data['meta_value1']);
				$result = $wpdb->query($sql);
				if (false === $result) {
					$aio_wp_security->debug_logger->log_debug("generate_unlock_request_link() - Error inserting woo_unlock_request_key to AIOWPSEC_TBL_GLOBAL_META_DATA table for secret key ".$secret_rand_key, 4);
				}
			}
			$query_param = array('aiowps_auth_key' => $secret_rand_key);
			$wp_site_url = AIOWPSEC_WP_URL;
			$unlock_link = esc_url(add_query_arg($query_param, $wp_site_url));
		}
		return $unlock_link;
	}

	/**
	 * This function will process an unlock request when someone clicks on the special URL
	 * It will check if the special random code matches that in lockdown table for the relevant user
	 * If so, it will unlock the user
	 *
	 * @param string $unlock_key
	 * @return void
	 */
	public static function process_unlock_request($unlock_key) {
		global $wpdb, $aio_wp_security;
		$lockout_table_name = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$unlock_command = $wpdb->prepare("UPDATE ".$lockout_table_name." SET released = UNIX_TIMESTAMP() WHERE unlock_key = %s", $unlock_key);
		$result = $wpdb->query($unlock_command);
		if (false === $result) {
			$aio_wp_security->debug_logger->log_debug("Error unlocking user with unlock_key ".$unlock_key, 4);
		} else {
			// Now check if this unlock operation is for a WooCommerce login
			$aiowps_global_meta_tbl_name = AIOWPSEC_TBL_GLOBAL_META_DATA;
			$sql = $wpdb->prepare("SELECT * FROM $aiowps_global_meta_tbl_name WHERE meta_key1=%s AND meta_value1=%s", 'woo_unlock_request_key', $unlock_key);
			$woo_result = $wpdb->get_row($sql, OBJECT);
			if (empty($woo_result)) {
				$woo_unlock = false;
			} else {
				$woo_unlock = true;
			}
			if ($aio_wp_security->configs->get_value('aiowps_enable_rename_login_page')=='1') {
				if (get_option('permalink_structure')) {
					$home_url = trailingslashit(home_url());
				} else {
					$home_url = trailingslashit(home_url()) . '?';
				}
				if ($woo_unlock) {
					$login_url = wc_get_page_permalink('myaccount'); //redirect to woo login page if applicable
					//Now let's cleanup after ourselves and delete the woo-related row in the AIOWPSEC_TBL_GLOBAL_META_DATA table
					$delete = $wpdb->delete($aiowps_global_meta_tbl_name, array('meta_key1' => 'woo_unlock_request_key', 'meta_value1' => $unlock_key));
					if (false === $delete) {
						$aio_wp_security->debug_logger->log_debug("process_unlock_request(): Error deleting row from AIOWPSEC_TBL_GLOBAL_META_DATA for meta_key1=woo_unlock_request_key and meta_value1=".$unlock_key, 4);
					}
				} else {
					$login_url = $home_url.$aio_wp_security->configs->get_value('aiowps_login_page_slug');
				}

				AIOWPSecurity_Utility::redirect_to_url($login_url);
			} else {
				AIOWPSecurity_Utility::redirect_to_url(wp_login_url());
			}
		}
	}

	/**
	 * This function sends an unlock request email to a locked out user
	 *
	 * @param string $email
	 * @param string $unlock_link
	 * @return void
	 */
	public static function send_unlock_request_email($email, $unlock_link) {
		global $aio_wp_security;
		$subject = '['.network_site_url().'] '. __('Unlock request notification', 'all-in-one-wp-security-and-firewall');
		$email_msg = sprintf(__('You have requested for the account with email address %s to be unlocked.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Please press the link below to unlock your account:', 'all-in-one-wp-security-and-firewall'), $email) . "\n" . sprintf(__('Unlock link: %s', 'all-in-one-wp-security-and-firewall'), $unlock_link) . "\n\n" . __('After pressing the above link you will be able to login to the WordPress administration panel.', 'all-in-one-wp-security-and-firewall') . "\n";
		
		$sendMail = wp_mail($email, $subject, $email_msg);
		if (false === $sendMail) {
			$aio_wp_security->debug_logger->log_debug("Unlock Request Notification email failed to send to " . $email, 4);
		}
	}

	/**
	 * Check the settings and log the user after the configured time period
	 *
	 * @param bool $return_url Optional. If true, the function returns the logout URL with a nonce.
	 *                         Otherwise, it redirects to the logout URL. Default is false.
	 *
	 * @return void|string
	 */
	public function aiowps_force_logout_action_handler($return_url = false) {
		global $aio_wp_security;
		//$aio_wp_security->debug_logger->log_debug("Force Logout - Checking if any user need to be logged out...");
		//if this feature is enabled then do something
		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_forced_logout')) {
			if (is_user_logged_in()) {
				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;
				$current_time = current_time('mysql', true);
				$login_time = $this->get_wp_user_aiowps_last_login_time($user_id);
				if (empty($login_time)) {
					return;
				}
				$diff = strtotime($current_time) - strtotime($login_time);
				$logout_time_interval_value = $aio_wp_security->configs->get_value('aiowps_logout_time_period');
				$logout_time_interval_val_seconds = $logout_time_interval_value * 60;
				if ($diff > $logout_time_interval_val_seconds) {
					$aio_wp_security->debug_logger->log_debug("Force Logout - This user logged in more than (".$logout_time_interval_value.") minutes ago. Doing a force log out for the user with username: ".$current_user->user_login);
					$this->wp_logout_action_handler($user_id); //this will register the logout time/date in the logout_date column


					$curr_page_url = AIOWPSecurity_Utility::get_current_page_url();
					$after_logout_payload = array('redirect_to' => $curr_page_url, 'msg' => $this->key_login_msg.'=session_expired');
					//Save some of the logout redirect data to a transient
					is_multisite() ? set_site_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60) : set_transient('aiowps_logout_payload', $after_logout_payload, 30 * 60);
					$logout_url = AIOWPSEC_WP_URL.'?aiowpsec_do_log_out=1';
					$logout_url = AIOWPSecurity_Utility::add_query_data_to_url($logout_url, 'al_additional_data', '1');
					$logout_url_with_nonce = html_entity_decode(wp_nonce_url($logout_url, 'aio_logout'));
					if ($return_url) {
						return $logout_url_with_nonce;
					}
					AIOWPSecurity_Utility::redirect_to_url($logout_url_with_nonce);
				}
			}
		}
	}

	/**
	 * Get last logged in time of given user id.
	 *
	 * @param integer $user_id
	 * @return mixed Last login time. False for an invalid $user_id (non-numeric, zero, or negative value). An empty string if a valid but non-existing user ID is passed.
	 */
	public function get_wp_user_aiowps_last_login_time($user_id) {
		$last_login = apply_filters('aiowps_get_last_login_time', get_user_meta($user_id, 'aiowps_last_login_time', true), $user_id);
		return $last_login;
	}

	/**
	 * Updates the last login time in user meta, the login activity table.
	 *
	 * @global wpdb $wpdb
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @param string  $user_login
	 * @param WP_User $user
	 *
	 * @return void
	 */
	private static function update_login_activity($user_login, $user) {
		AIOWPSecurity_Audit_Events::event_successful_login($user_login);
		$login_date_time = current_time('mysql', true);

		update_user_meta($user->ID, 'aiowps_last_login_time', $login_date_time); //store last login time in meta table
	}
	
	/**
	 * Remove the last login time for all users from meta table on deactivation.
	 *
	 * @return void
	 */
	public static function remove_login_activity() {
		delete_metadata('user', '0', 'aiowps_last_login_time', '', true); //remove from meta table for all users last login time
	}

	public static function wp_login_action_handler($user_login, $user = '') {
		global $aio_wp_security;

		if ('' == $user) {
			//Try and get user object
			$user = get_user_by('login', $user_login); //This should return WP_User obj
			if (!$user) {
				$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_User_Login::wp_login_action_handler: Unable to get WP_User object for login ".$user_login, 4);
				return;
			}
		}

		if (is_super_admin($user->ID)) {
			$logging_into_correct_site = true;
		} else {
			$user_sites = get_blogs_of_user($user->ID);

			$current_site_id = get_current_blog_id();

			$logging_into_correct_site = false;

			foreach ($user_sites as $site) {
				if ($site->userblog_id == $current_site_id) {
					$logging_into_correct_site = true;
					break;
				}
			}
		}

		if ($logging_into_correct_site) {
			self::update_login_activity($user_login, $user);
		} else {
			$user_primary_site = get_active_blog_for_user($user->ID);
			switch_to_blog($user_primary_site->blog_id);
			self::update_login_activity($user_login, $user);

			restore_current_blog();
		}
	}

	/**
	 * Handles logout events and modifies the login activity record for the current user.
	 *
	 * @param int     $user_id      - ID of user logging out
	 * @param boolean $force_logout - if user is force logged out
	 *
	 * @return void
	 */
	public function wp_logout_action_handler($user_id, $force_logout = false) {
		global $aio_wp_security;
		$user = get_userdata($user_id);

		if (false === $user) {
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_User_Login::wp_logout_action_handler: Unable to get WP_User object", 4);
			return;
		}

		$this->delete_logged_in_user($user->ID);

		if (is_super_admin($user->ID)) {
			$logging_out_of_correct_site = true;
		} else {
			$user_sites = get_blogs_of_user($user->ID);

			$current_site_id = get_current_blog_id();

			$logging_out_of_correct_site = false;

			foreach ($user_sites as $site) {
				if ($site->userblog_id == $current_site_id) {
					$logging_out_of_correct_site = true;
					break;
				}
			}
		}

		if ($logging_out_of_correct_site) {
			AIOWPSecurity_Audit_Events::event_successful_logout($user->user_login, $force_logout);
		} else {
			$user_primary_site = get_active_blog_for_user($user->ID);
			switch_to_blog($user_primary_site->blog_id);
			AIOWPSecurity_Audit_Events::event_successful_logout($user->user_login, $force_logout);

			restore_current_blog();
		}
	}

	/**
	 * The handler for the WP "login_message" filter
	 * Adds custom messages to the other messages that appear above the login form.
	 *
	 * NOTE: This method is automatically called by WordPress for displaying
	 * text above the login form.
	 *
	 * @param string $message the output from earlier login_message filters
	 * @return string
	 */
	public function aiowps_login_message($message = '') {
		global $aio_wp_security;
		$msg = '';
		if (isset($_GET[$this->key_login_msg]) && !empty($_GET[$this->key_login_msg])) {
			$logout_msg = strip_tags($_GET[$this->key_login_msg]);
		}
		if (!empty($logout_msg)) {
			switch ($logout_msg) {
				case 'session_expired':
					$msg = sprintf(__('Your session has expired because it has been over %d minutes since your last login.', 'all-in-one-wp-security-and-firewall'), $aio_wp_security->configs->get_value('aiowps_logout_time_period'));
					$msg .= ' ' . __('Please log back in to continue.', 'all-in-one-wp-security-and-firewall');
					break;
				case 'admin_user_changed':
					$msg = __('You were logged out because you just changed the "admin" username.', 'all-in-one-wp-security-and-firewall');
					$msg .= ' ' . __('Please log back in to continue.', 'all-in-one-wp-security-and-firewall');
					break;
				default:
			}
		}
		if (!empty($msg)) {
			$msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
			$message .= '<p class="login message">'. $msg . '</p>';
		}
		return $message;
	}
	/**
	 * This function will generate an unlock request form to be inserted inside
	 * error message when user gets locked out.
	 *
	 * @return string
	 */
	public function get_unlock_request_form() {
		global $aio_wp_security;
		$unlock_request_form = '';
		//Let's encode some hidden data and make a form
		$unlock_secret_string = $aio_wp_security->configs->get_value('aiowps_unlock_request_secret_key');
		$current_time = time();
		$enc_result = base64_encode($current_time.$unlock_secret_string);
		$unlock_request_form .= '<form method="post" action=""><div style="padding-bottom:10px;"><input type="hidden" name="aiowps-unlock-string-info" id="aiowps-unlock-string-info" value="'.$enc_result.'" />';
		$unlock_request_form .= '<input type="hidden" name="aiowps-unlock-temp-string" id="aiowps-unlock-temp-string" value="'.$current_time.'" />';
		if (isset($_POST['woocommerce-login-nonce'])) {
			$unlock_request_form .= '<input type="hidden" name="aiowps-woo-login" id="aiowps-woo-login" value="1" />';
		}
		$unlock_request_form .= '<button type="submit" name="aiowps_unlock_request" id="aiowps_unlock_request" class="button">'.__('Request unlock', 'all-in-one-wp-security-and-firewall').'</button></div></form>';
		return $unlock_request_form;
	}

	/**
	 * Returns all logged in users for specific subsite of multisite installation.
	 *
	 * @param bool $sitewide - checks if logged in users should be fetched sitewide
	 *
	 * @return array
	 */
	public static function get_logged_in_users($sitewide = true) {
		global $wpdb;

		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;
		if ($sitewide) {
			$users_online = $wpdb->get_results("SELECT * FROM `{$logged_in_users_table}`", 'ARRAY_A');
		} else {
			$current_blog_id = get_current_blog_id();
			$users_online = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$logged_in_users_table}` WHERE site_id = %d", $current_blog_id), 'ARRAY_A');
		}

		if (empty($users_online)) return array();

		return $users_online;
	}

	/**
	 * Send email notification to an user that has flag is_lockout_email_sent is 0.
	 *
	 * @return Void
	 */
	public function send_login_lockout_emails() {
		global $wpdb, $aio_wp_security;
		// if user enabled notification email then only have to send
		$email_notification_enabled = $aio_wp_security->configs->get_value('aiowps_enable_email_notify');
		if (0 == $email_notification_enabled) {
			return;
		}
		// get recent lockout records on top to notify
		$sql = $wpdb->prepare('SELECT id, user_login, failed_login_ip, backtrace_log, ip_lookup_result FROM ' .AIOWPSEC_TBL_LOGIN_LOCKOUT. ' WHERE is_lockout_email_sent = %d ORDER BY id DESC', 0);
		$result = $wpdb->get_results($sql);
		if (empty($result)) {
			return;
		}
		$login_lockout_ids_send_emails = array();
		$lockout_ips_backtrace_log = array();
		$lockout_ips_list = array();
		$backtrace_filepath = '';
		foreach ($result as $row) {
			$ip_range = AIOWPSecurity_Utility_IP::get_sanitized_ip_range($row->failed_login_ip);
			$lockout_ips_list[] = array('username' => $row->user_login, 'ip' => $row->failed_login_ip, 'ip_range' => $ip_range, 'ip_lookup_result' => $row->ip_lookup_result);
			$login_lockout_ids_send_emails[] = $row->id;
			if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_php_backtrace_in_email') && '' != $row->backtrace_log) {
				$lockout_ips_backtrace_log[] = array('backtrace_log' => $row->backtrace_log);
			}
		}
		
		if (0 != count($lockout_ips_backtrace_log)) {
			$backtrace_filepath = AIOWPSecurity_Utility::login_lockdown_email_backtrace_log_file($lockout_ips_backtrace_log);
		}
		
		$this->send_ip_lock_notification_email($lockout_ips_list, $backtrace_filepath);
		
		if ('' != $backtrace_filepath) {
			unlink($backtrace_filepath);
		}
		
		if (!empty($login_lockout_ids_send_emails)) {
			$aio_wp_security->debug_logger->log_debug(sprintf('The IP lock notification emails of login lockout ids [%s] are sent.', implode(', ', $login_lockout_ids_send_emails)), 4);
			// update all email to as sent.
			$sql = $wpdb->prepare('UPDATE '.AIOWPSEC_TBL_LOGIN_LOCKOUT.' SET is_lockout_email_sent = %d WHERE is_lockout_email_sent = %d', 1, 0);
			//$sql = $wpdb->prepare('UPDATE '.AIOWPSEC_TBL_LOGIN_LOCKOUT.' SET is_lockout_email_sent = %d WHERE id IN (%1s)', 1, implode(', ', $login_lockout_ids_send_emails));
			$update_result = $wpdb->query($sql);
			if (false === $update_result) {
				$error_msg = empty($wpdb->last_error) ? 'Could not receive the reason for the failure' : $wpdb->last_error;
				$aio_wp_security->debug_logger->log_debug_cron("Lockout email flag is not updated in database due to error: {$error_msg}", 4);
			}
		}
	}

	/**
	 * Stores logged-in user in the logged_in_user table
	 *
	 * @param int $user_id    - id of user logging in
	 * @param int $expiration - expiration timestamp of cookie
	 *
	 * @return void
	 */
	public function store_logged_in_user($user_id, $expiration) {
		global $wpdb, $aio_wp_security;

		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;
		$ip_address = AIOWPSecurity_Utility_IP::get_user_ip_address();
		$userdata = get_userdata($user_id);
		$username = $userdata->user_login;
		$login_time = time();

		// Check if a record with the given user_id already exists
		$existing_record = $wpdb->get_row(
			$wpdb->prepare("SELECT * FROM " . $logged_in_users_table . " WHERE user_id = %d", $user_id)
		);

		if ($existing_record) {
			// Update the existing record
			$result = $wpdb->update(
				$logged_in_users_table,
				array(
					'ip_address' => $ip_address,
					'site_id' => get_current_blog_id(),
					'username' => $username,
					'expires' => $expiration
				),
				array('user_id' => $user_id)
			);
		} else {
			// Create a new record
			$result = $wpdb->insert(
				$logged_in_users_table,
				array(
					'user_id' => $user_id,
					'ip_address' => $ip_address,
					'expires' => $expiration,
					'site_id' => get_current_blog_id(),
					'username' => $username,
					'created' => $login_time
				)
			);
		}

		if (false === $result) {
			$generic_error_message = $existing_record ? "Error updating record in " . $logged_in_users_table : "Error inserting record into ".$logged_in_users_table;
			$error_message = empty($wpdb->last_error) ? $generic_error_message : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug($error_message, 4);
		}
	}

	/**
	 * Handles the data coming from the 'set_auth_cookie' hook
	 *
	 * @param string $auth_cookie - the generated auth_cookie
	 * @param int    $expire      - expiration timestamp of cookie if remember is marked
	 * @param int    $expiration  - expiration timestamp of cookie
	 * @param int    $user_id     - id of user logging in
	 *
	 * @return void
	 */
	public function handle_logged_in_user($auth_cookie, $expire, $expiration, $user_id) {

		if (empty($auth_cookie)) return; //check if auth cookie is empty, meaning login was not successful
		$expiration = $expire > 0 ? $expire : $expiration;

		if (is_multisite() && !is_super_admin()) {
			$user_blog = get_active_blog_for_user($user_id);
			switch_to_blog($user_blog->blog_id); // switch to user blog incase they try to log in from wrong subsite

			$this->store_logged_in_user($user_id, $expiration);
			restore_current_blog();
		} else {
			$this->store_logged_in_user($user_id, $expiration);
		}
	}

	/**
	 * Deletes logged-in user from the logged_in_user table
	 *
	 * @param int $user_id
	 * @return bool
	 */
	public function delete_logged_in_user($user_id) {
		global $wpdb, $aio_wp_security;

		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;

		if (empty($user_id)) return true;

		$result = $wpdb->delete(
			$logged_in_users_table,
			array('user_id' => $user_id)
		);


		if (false === $result) {
			$error_message = empty($wpdb->last_error) ? "Error deleting record from " . $logged_in_users_table : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug($error_message, 4);
		}

		return $result;
	}

	/**
	 * Cron job function for removing data with expired session from the logged-in user table
	 *
	 * @return void
	 */
	public function delete_expired_logged_in_users() {
		global $wpdb, $aio_wp_security;
		$logged_in_users_table = AIOWSPEC_TBL_LOGGED_IN_USERS;

		// Delete data with expired cookie
		$result = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM " . $logged_in_users_table . " WHERE expires < %d",
				time()
			)
		);

		if (false === $result) {
			$error_message = empty($wpdb->last_error) ? "Error deleting records from ".$logged_in_users_table : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug($error_message, 4);
		}
	}

	/**
	 * This function rewrites the password reset message
	 *
	 * @param string $message - The password reset email message to be edited
	 *
	 * @return string - Email message to be sent for password reset
	 */
	public function aiowps_retrieve_password_message($message) {
		$ip = AIOWPSecurity_Utility_IP::get_user_ip_address(); //Get the IP address of user

		// Find the position of the IP Address string in the message
		$ip_string = $_SERVER['REMOTE_ADDR'];
		$ip_pos = strpos($message, $ip_string);

		// If the IP Address string is found in the message and not the same as AIOWPS ip, replace it with the replacement string
		if (false !== $ip_pos && $ip !== $ip_string) {
			$replacement = "$ip.\r\n\r\n";
			$message = substr_replace($message, $replacement, $ip_pos);
		}

		return $message;
	}
}
