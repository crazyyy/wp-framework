<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_Utility {

	/**
	 * Returned when we can't detect the user's server software
	 *
	 * @var int
	 */
	const UNSUPPORTED_SERVER_TYPE = -1;

	/**
	 * Class constructor
	 */
	public function __construct() {
		//NOP
	}

	/**
	 * Explode $string with $delimiter, trim all lines and filter out empty ones.
	 *
	 * @param string $string
	 * @param string $delimiter
	 * @return array
	 */
	public static function explode_trim_filter_empty($string, $delimiter = PHP_EOL) {
		return array_filter(array_map('trim', explode($delimiter, $string)), 'strlen');
	}
	
	/**
	 * Split $string with newline, trim all lines and filter out empty ones.
	 * This method to be used on historical settings where the separator may have depended on PHP_EOL
	 *
	 * @param string $string
	 * @return array
	 */
	public static function splitby_newline_trim_filter_empty($string) {
		return array_filter(array_map('trim', preg_split('/\R/', $string)), 'strlen'); //\R line break: matches \n, \r and \r\n
	}

	/**
	 * Returns the current URL
	 *
	 * @return string
	 */
	public static function get_current_page_url() {
		if ((defined('WP_CLI') && WP_CLI) || (defined('DOING_CRON') && DOING_CRON)) return '';

		if (defined('DOING_AJAX') && DOING_AJAX) {
			// Return the referer URL instead of the AJAX URL
			return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		}

		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && "on" == $_SERVER["HTTPS"]) {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ("80" != $_SERVER["SERVER_PORT"]) {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	/**
	 * Redirects to specified URL
	 *
	 * @param type $url
	 * @param type $delay
	 * @param type $exit
	 */
	public static function redirect_to_url($url, $delay = '0', $exit = '1') {
		if (empty($url)) {
			echo "<br /><strong>Error! The URL value is empty. Please specify a correct URL value to redirect to!</strong>";
			exit;
		}
		if (!headers_sent()) {
			header('Location: ' . $url);
		} else {
			echo '<meta http-equiv="refresh" content="' . $delay . ';url=' . $url . '" />';
		}
		if ('1' == $exit) {
			exit;
		}
	}

	/**
	 * Checks if a particular username exists in the WP Users table
	 *
	 * @global type $wpdb
	 * @param type $username
	 * @return boolean
	 */
	public static function check_user_exists($username) {
		global $wpdb;

		//if username is empty just return false
		if ('' == $username) {
			return false;
		}

		//If multisite
		if (is_multisite()) {
			$blog_id = get_current_blog_id();
			$admin_users = get_users('blog_id=' . $blog_id . '&orderby=login&role=administrator');
			foreach ($admin_users as $user) {
				if ($user->user_login == $username) {
					return true;
				}
			}
			return false;
		}

		//check users table
		$sanitized_username = sanitize_text_field($username);
		$sql_1 = $wpdb->prepare("SELECT user_login FROM $wpdb->users WHERE user_login=%s", $sanitized_username);
		$user_login = $wpdb->get_var($sql_1);
		if ($user_login == $sanitized_username) {
			return true;
		} else {
			//make sure that the sanitized username is an integer before comparing it to the users table's ID column
			$sanitized_username_is_an_integer = (1 === preg_match('/^\d+$/', $sanitized_username));
			if ($sanitized_username_is_an_integer) {
				$sql_2 = $wpdb->prepare("SELECT ID FROM $wpdb->users WHERE ID=%d", intval($sanitized_username));
				$userid = $wpdb->get_var($sql_2);
				return ($userid == $sanitized_username);
			} else {
				return false;
			}
		}
	}

	/**
	 * This function will return a list of user accounts which have login and nick names which are identical
	 *
	 * @global type $wpdb
	 * @return type
	 */
	public static function check_identical_login_and_nick_names() {
		global $wpdb;
		$accounts_found = $wpdb->get_results("SELECT ID,user_login FROM `" . $wpdb->users . "` WHERE user_login<=>display_name;", ARRAY_A);
		return $accounts_found;
	}


	public static function add_query_data_to_url($url, $name, $value) {
		if (strpos($url, '?') === false) {
			$url .= '?';
		} else {
			$url .= '&';
		}
		$url .= $name . '=' . urlencode($value);
		return $url;
	}


	/**
	 * Generates a random alpha-numeric number
	 *
	 * @param type $string_length
	 * @return string
	 */
	public static function generate_alpha_numeric_random_string($string_length) {
		//Characters present in table prefix
		$allowed_chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$string = '';
		//Generate random string
		for ($i = 0; $i < $string_length; $i++) {
			$string .= $allowed_chars[rand(0, strlen($allowed_chars) - 1)];
		}
		return $string;
	}


	/**
	 * Generates a random string using a-z characters
	 *
	 * @param type $string_length
	 * @return string
	 */
	public static function generate_alpha_random_string($string_length) {
		//Characters present in table prefix
		$allowed_chars = 'abcdefghijklmnopqrstuvwxyz';
		$string = '';
		//Generate random string
		for ($i = 0; $i < $string_length; $i++) {
			$string .= $allowed_chars[rand(0, strlen($allowed_chars) - 1)];
		}
		return $string;
	}

	/**
	 * Sets cookie
	 *
	 * @param type   $cookie_name
	 * @param type   $cookie_value
	 * @param type   $expiry_seconds
	 * @param type   $path
	 * @param string $cookie_domain
	 */
	public static function set_cookie_value($cookie_name, $cookie_value, $expiry_seconds = 86400, $path = '/', $cookie_domain = '') {
		$expiry_time = time() + intval($expiry_seconds);
		if (empty($cookie_domain)) {
			$cookie_domain = COOKIE_DOMAIN;
		}
		setcookie($cookie_name, $cookie_value, $expiry_time, $path, $cookie_domain, is_ssl(), true);
	}

	/**
	 * Get brute force secret cookie name.
	 *
	 * @return String Brute force secret cookie name.
	 */
	public static function get_brute_force_secret_cookie_name() {
		return 'aios_brute_force_secret_' . COOKIEHASH;
	}
	
	/**
	 * Gets cookie
	 *
	 * @param type $cookie_name
	 * @return string
	 */
	public static function get_cookie_value($cookie_name) {
		if (isset($_COOKIE[$cookie_name])) {
			return $_COOKIE[$cookie_name];
		}
		return "";
	}

	/**
	 * Checks if installation is multisite or not.
	 *
	 * @return Boolean True if the site is network multisite, false otherwise.
	 */
	public static function is_multisite_install() {
		return function_exists('is_multisite') && is_multisite();
	}

	/**
	 * This is a general yellow box message for when we want to suppress a feature's config items on multisite because current user is not super admin.
	 *
	 * @return void
	 */
	public static function display_multisite_super_admin_message() {
		echo '<div class="aio_yellow_box">';
		echo '<p>' . __('The plugin has detected that you are using a Multi-Site WordPress installation.', 'all-in-one-wp-security-and-firewall') . '</p>
			  <p>' . __('Some features on this page can only be configured by the "superadmin".', 'all-in-one-wp-security-and-firewall') . '</p>';
		echo '</div>';
	}

	/**
	 * Modifies the wp-config.php file to disable PHP file editing from the admin panel
	 * This function will add the following code:
	 * define('DISALLOW_FILE_EDIT', false);
	 *
	 * NOTE: This function will firstly check if the above code already exists
	 * and it will modify the bool value, otherwise it will insert the code mentioned above
	 *
	 * @global type $aio_wp_security
	 * @return boolean
	 */
	public static function disable_file_edits() {
		global $aio_wp_security;
		$edit_file_config_entry_exists = false;

		//Config file path
		$config_file = AIOWPSecurity_Utility_File::get_wp_config_file_path();

		//Get wp-config.php file contents so we can check if the "DISALLOW_FILE_EDIT" variable already exists
		$config_contents = file($config_file);

		foreach ($config_contents as $line_num => $line) {
			if (strpos($line, "'DISALLOW_FILE_EDIT', false")) {
				$config_contents[$line_num] = str_replace('false', 'true', $line);
				$edit_file_config_entry_exists = true;
				//$this->show_msg_updated(__('Settings Saved - The ability to edit PHP files via the admin the panel has been DISABLED.', 'all-in-one-wp-security-and-firewall'));
			} elseif (strpos($line, "'DISALLOW_FILE_EDIT', true")) {
				$edit_file_config_entry_exists = true;
				//$this->show_msg_updated(__('Your system config file is already configured to disallow PHP file editing.', 'all-in-one-wp-security-and-firewall'));
				return true;

			}

			//For wp-config.php files originating from early WP versions we will remove the closing php tag
			if (strpos($line, "?>") !== false) {
				$config_contents[$line_num] = str_replace("?>", "", $line);
			}
		}

		if (!$edit_file_config_entry_exists) {
			//Construct the config code which we will insert into wp-config.php
			$new_snippet = '//Disable File Edits' . PHP_EOL;
			$new_snippet .= 'if (!defined(\'DISALLOW_FILE_EDIT\')) { define(\'DISALLOW_FILE_EDIT\', true); }';
			$config_contents[] = $new_snippet; //Append the new snippet to the end of the array
		}

		//Make a backup of the config file
		if (!AIOWPSecurity_Utility_File::backup_and_rename_wp_config($config_file)) {
			AIOWPSecurity_Admin_Menu::show_msg_error_st(__('Failed to make a backup of the wp-config.php file.', 'all-in-one-wp-security-and-firewall') . ' ' . __('This operation will not go ahead.', 'all-in-one-wp-security-and-firewall'));
			//$aio_wp_security->debug_logger->log_debug("Disable PHP File Edit - Failed to make a backup of the wp-config.php file.",4);
			return false;
		} else {
			//$this->show_msg_updated(__('A backup copy of your wp-config.php file was created successfully....', 'all-in-one-wp-security-and-firewall'));
		}

		//Now let's modify the wp-config.php file
		if (AIOWPSecurity_Utility_File::write_content_to_file($config_file, $config_contents)) {
			//$this->show_msg_updated(__('Settings Saved - Your system is now configured to not allow PHP file editing.', 'all-in-one-wp-security-and-firewall'));
			return true;
		} else {
			//$this->show_msg_error(__('Operation failed! Unable to modify wp-config.php file!', 'all-in-one-wp-security-and-firewall'));
			$aio_wp_security->debug_logger->log_debug("Disable PHP File Edit - Unable to modify wp-config.php", 4);
			return false;
		}
	}

	/**
	 * Modifies the wp-config.php file to allow PHP file editing from the admin panel
	 * This func will modify the following code by replacing "true" with "false":
	 * define('DISALLOW_FILE_EDIT', true);
	 *
	 * @global type $aio_wp_security
	 * @return boolean
	 */
	public static function enable_file_edits() {
		$edit_file_config_entry_exists = false;

		//Config file path
		$config_file = AIOWPSecurity_Utility_File::get_wp_config_file_path();

		//Get wp-config.php file contents
		$config_contents = file($config_file);
		foreach ($config_contents as $line_num => $line) {
			if (strpos($line, "'DISALLOW_FILE_EDIT', true")) {
				$config_contents[$line_num] = str_replace('true', 'false', $line);
				$edit_file_config_entry_exists = true;
			} elseif (strpos($line, "'DISALLOW_FILE_EDIT', false")) {
				$edit_file_config_entry_exists = true;
				//$this->show_msg_updated(__('Your system config file is already configured to allow PHP file editing.', 'all-in-one-wp-security-and-firewall'));
				return true;
			}
		}

		if (!$edit_file_config_entry_exists) {
			//if the DISALLOW_FILE_EDIT settings don't exist in wp-config.php then we don't need to do anything
			//$this->show_msg_updated(__('Your system config file is already configured to allow PHP file editing.', 'all-in-one-wp-security-and-firewall'));
			return true;
		} else {
			//Now let's modify the wp-config.php file
			if (AIOWPSecurity_Utility_File::write_content_to_file($config_file, $config_contents)) {
				//$this->show_msg_updated(__('Settings Saved - Your system is now configured to allow PHP file editing.', 'all-in-one-wp-security-and-firewall'));
				return true;
			} else {
				//$this->show_msg_error(__('Operation failed! Unable to modify wp-config.php file!', 'all-in-one-wp-security-and-firewall'));
				//$aio_wp_security->debug_logger->log_debug("Disable PHP File Edit - Unable to modify wp-config.php",4);
				return false;
			}
		}
	}


	/**
	 * Inserts event logs to the database
	 * For now we are using for 404 events but in future will expand for other events
	 * Event types: 404 (...add more as we expand this)
	 *
	 * @param string $event_type :Event type, eg, 404 (see below for list of event types)
	 * @param string $username   (optional): username
	 * @return bool
	 */
	public static function event_logger($event_type, $username = '') {
		global $wpdb, $aio_wp_security;

		//Some initialising
		$url = '';
		$referer_info = '';

		$events_table_name = AIOWPSEC_TBL_EVENTS;

		$ip_or_host = AIOWPSecurity_Utility_IP::get_user_ip_address(); //Get the IP address of user
		$username = sanitize_user($username);
		$user = get_user_by('login', $username); //Returns WP_User object if exists
		if ($user) {
			//If valid user set variables for DB storage later on
			$user_id = (absint($user->ID) > 0) ? $user->ID : 0;
		} else {
			//If the login attempt was made using a non-existent user then let's set user_id to blank and record the attempted user login name for DB storage later on
			$user_id = 0;
		}

		if ('404' == $event_type || 'spam_discard' == $event_type) {
			//if 404 event get some relevant data
			$url = isset($_SERVER['REQUEST_URI']) ? esc_attr($_SERVER['REQUEST_URI']) : '';
			$referer_info = isset($_SERVER['HTTP_REFERER']) ? esc_attr($_SERVER['HTTP_REFERER']) : '';
		}

		$current_time = current_time('mysql', true);
		$data = array(
			'event_type' => $event_type,
			'username' => $username,
			'user_id' => $user_id,
			'event_date' => $current_time,
			'ip_or_host' => $ip_or_host,
			'referer_info' => $referer_info,
			'url' => $url,
			'event_data' => '',
		);

		$data = apply_filters('aiowps_filter_event_logger_data', $data);
		//log to database
		$country_code = isset($data['country_code']) ? $data['country_code'] : '';
		$sql = $wpdb->prepare("INSERT INTO ".$events_table_name." (event_type, username, user_id, event_date, ip_or_host, referer_info, url, event_data, country_code, created) VALUES (%s, %s, %d, %s, %s, %s, %s, %s, %s, UNIX_TIMESTAMP())", $data['event_type'], $data['username'], $data['user_id'], $data['event_date'], $data['ip_or_host'], $data['referer_info'], $data['url'], $data['event_data'], $country_code);

		$result = $wpdb->query($sql);
		if (false === $result) {
			$aio_wp_security->debug_logger->log_debug("event_logger: Error inserting record into " . $events_table_name, 4);//Log the highly unlikely event of DB error
			return false;
		}
		return true;
	}

	/**
	 * Checks if an IP address is locked.
	 *
	 * @param string $ip          The IP address to be checked.
	 * @param string $lock_reason Optional. Defaults to any lockout reason if not provided.
	 *
	 * @return bool True if locked, false otherwise.
	 **/
	public static function check_locked_ip($ip, $lock_reason = null) {
		global $wpdb;
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;

		if (null === $lock_reason) {
			$locked_ip = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$login_lockdown_table` WHERE released > UNIX_TIMESTAMP() AND failed_login_ip = %s", $ip), ARRAY_A);
		} else {
			$locked_ip = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$login_lockdown_table` WHERE released > UNIX_TIMESTAMP() AND failed_login_ip = %s AND lock_reason = %s", $ip, $lock_reason), ARRAY_A);
		}

		return null != $locked_ip;
	}

	/**
	 * Check if an IP address is blacklisted.
	 *
	 * @param string $ip The IP address to check.
	 * @return bool True if the IP address is blacklisted, false otherwise.
	 */
	public static function check_blacklist_ip($ip) {
		global $aio_wp_security;
		$blacklisted_ips = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses');
		$blacklisted_ips_array = explode("\n", $blacklisted_ips);
		if (in_array($ip, $blacklisted_ips_array)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns list of IP addresses locked out
	 *
	 * @global type $wpdb
	 * @return array of addresses found or false otherwise
	 */
	public static function get_locked_ips() {
		global $wpdb;
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$locked_ips = $wpdb->get_results("SELECT * FROM $login_lockdown_table WHERE released > UNIX_TIMESTAMP()", ARRAY_A);
		if (empty($locked_ips)) {
			return false;
		} else {
			return $locked_ips;
		}
	}


	/**
	 * Locks an IP address - Adds an entry to the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @global wpdb            $wpdb
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @param String $ip
	 * @param String $lock_reason
	 * @param String $username
	 *
	 * @return Void
	 */
	public static function lock_ip($ip, $lock_reason, $username = '') {
		global $wpdb, $aio_wp_security;
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;

		if ('404' == $lock_reason) {

			// Query for existing lockouts record with that ip and 404 reason.
			$existing_lock_query = $wpdb->prepare(
				"SELECT * FROM {$login_lockdown_table} WHERE failed_login_IP = %s AND lock_reason = %s AND released > UNIX_TIMESTAMP() LIMIT 1",
				$ip,
				$lock_reason
			);

			$existing_lock_count = $wpdb->get_var($existing_lock_query);

			if ($existing_lock_count) return; // IP is already blocked for '404', return.

			$lock_minutes = $aio_wp_security->configs->get_value('aiowps_404_lockout_time_length');
		} elseif ('audit-log' == $lock_reason) {
			$lock_minutes = 24 * 60;
		} else {
			$lock_minutes = $aio_wp_security->user_login_obj->get_dynamic_lockout_time_length();
		}

		$username = sanitize_user($username);
		$user = get_user_by('login', $username); //Returns WP_User object if exists

		if (false == $user) {
			// Not logged in.
			$username = '';
			$user_id = 0;
		} else {
			// Logged in.
			$username = sanitize_user($user->user_login);
			$user_id = $user->ID;
		}

		$ip = esc_sql($ip);

		$lock_seconds = $lock_minutes * MINUTE_IN_SECONDS;
		$lock_time = current_time('mysql', true);
		$ip_lookup_result = AIOS_Helper::get_ip_reverse_lookup($ip);
		$ip_lookup_result = json_encode($ip_lookup_result);
		if (false === $ip_lookup_result) $ip_lookup_result = null;

		$release_time = date('Y-m-d H:i:s', time() + ($lock_seconds));
		$data = array(
			'user_id' => $user_id,
			'user_login' => $username,
			'lockdown_date' => $lock_time,
			'release_date' => $release_time,
			'failed_login_IP' => $ip,
			'lock_reason' => $lock_reason,
			'lock_seconds' => $lock_seconds,
			'ip_lookup_result' => $ip_lookup_result
		);
		
		$result = AIOWPSecurity_Utility::add_lockout($data);

		if (false === $result) {
			$error_msg = empty($wpdb->last_error) ? "lock_ip: Error inserting record into " . $login_lockdown_table : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug($error_msg, 4);//Log the highly unlikely event of DB error
		}
	}
	
	/**
	 * Adds an entry to the AIOWPSEC_TBL_LOGIN_LOCKOUT table.
	 *
	 * @global wpdb $wpdb
	 *
	 * @param Array $data
	 *
	 * @return Boolean
	 */
	public static function add_lockout($data) {
		global $wpdb;
		if (!isset($data['is_lockout_email_sent'])) $data['is_lockout_email_sent'] = 0;
		if (!isset($data['backtrace_log'])) $data['backtrace_log'] = '';
		if (!isset($data['ip_lookup_result'])) $data['ip_lookup_result'] = '';
		$login_lockdown_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;
		$sql = $wpdb->prepare("INSERT INTO ".$login_lockdown_table." (user_id, user_login, lockdown_date, created, release_date, released,  failed_login_IP, lock_reason, is_lockout_email_sent, backtrace_log, ip_lookup_result) VALUES ('%d', '%s', '%s', UNIX_TIMESTAMP(), '%s', UNIX_TIMESTAMP()+%d, '%s', '%s', '%d', '%s', '%s')", $data['user_id'], $data['user_login'], $data['lockdown_date'], $data['release_date'], $data['lock_seconds'], $data['failed_login_IP'], $data['lock_reason'], $data['is_lockout_email_sent'], $data['backtrace_log'], $data['ip_lookup_result']);
		$result = $wpdb->query($sql);
		return $result;
	}

	/**
	 * Returns an array of blog_ids for a multisite install
	 *
	 * @global type $wpdb
	 * @global type $wpdb
	 * @return array or empty array if not multisite
	 */
	public static function get_blog_ids() {
		global $wpdb;
		if (is_multisite()) {
			global $wpdb;
			$blog_ids = $wpdb->get_col("SELECT blog_id FROM " . $wpdb->prefix . "blogs");
		} else {
			$blog_ids = array();
		}
		return $blog_ids;
	}

	/**
	 * Purges old records of table
	 *
	 * @global type $wpdb            WP Database object
	 * @global type $aio_wp_security AIO WP Security object
	 * @param type $table_name               Table name
	 * @param type $purge_records_after_days Records after days to be deleted
	 * @param type $date_field               Date field of table
	 * @return void
	 */
	public static function purge_table_records($table_name, $purge_records_after_days, $date_field) {
		global $wpdb, $aio_wp_security;

		$older_than_date_time = strtotime('-' . $purge_records_after_days . ' days', time());
		if ('created' != $date_field) $older_than_date_time = date('Y-m-d H:i:s', $older_than_date_time);
		$sql = $wpdb->prepare('DELETE FROM ' . $table_name . ' WHERE '.$date_field.' < %s', $older_than_date_time);
		$ret_deleted = $wpdb->query($sql);
		if (false === $ret_deleted) {
			$err_db = !empty($wpdb->last_error) ? ' ('.$wpdb->last_error.' - '.$wpdb->last_query.')' : '';
			// Status level 4 indicates failure status.
			$aio_wp_security->debug_logger->log_debug_cron('Purge records error - failed to purge older records for ' . $table_name . '.' . $err_db, 4);
		} else {
			$aio_wp_security->debug_logger->log_debug_cron(sprintf('Purge records - %d records were deleted for ' . $table_name . '.', $ret_deleted));
		}
	}

	/**
	 * This function will delete the oldest rows from a table which are over the max amount of rows specified
	 *
	 * @global type $wpdb            WP Database object
	 * @global type $aio_wp_security AIO WP Security object
	 * @param type $table_name Table name
	 * @param type $max_rows   More than max to be deleted
	 * @param type $id_field   Primary field of table
	 * @return bool
	 */
	public static function cleanup_table($table_name, $max_rows = '10000', $id_field = 'id') {
		global $wpdb, $aio_wp_security;

		$num_rows = $wpdb->get_var("select count(*) from $table_name");
		$result = true;
		if ($num_rows > $max_rows) {
			//if the table has more than max entries delete oldest rows
			
			$del_sql = "DELETE FROM $table_name
						WHERE ".$id_field." <= (
						  SELECT ".$id_field."
						  FROM (
							SELECT ".$id_field." 
							FROM $table_name
							ORDER BY ".$id_field." DESC
							LIMIT 1 OFFSET $max_rows
						 ) foo_tmp
						)";

			$result = $wpdb->query($del_sql);
			if (false === $result) {
				$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility::cleanup_table failed for table name: " . $table_name, 4);
			}
		}
		return (false === $result) ? false : true;
	}

	/**
	 * Add backquotes to tables and db-names in SQL queries. Taken from phpMyAdmin.
	 *
	 * @param  string $a_name - the table name
	 * @return string - the quoted table name
	 */
	public static function backquote($a_name) {
		if (!empty($a_name) && '*' != $a_name) {
			if (is_array($a_name)) {
				$result = array();
				foreach ($a_name as $key => $val) {
					$result[$key] = '`'.$val.'`';
				}
				return $result;
			} else {
				return '`'.$a_name.'`';
			}
		} else {
			return $a_name;
		}
	}
	
	/**
	 * Replace the first, and only the first, instance within a string
	 *
	 * @param String $needle   - the search term
	 * @param String $replace  - the replacement term
	 * @param String $haystack - the string to replace within
	 *
	 * @return String - the filtered string
	 */
	public static function str_replace_once($needle, $replace, $haystack) {
		$pos = strpos($haystack, $needle);
		return (false !== $pos) ? substr_replace($haystack, $replace, $pos, strlen($needle)) : $haystack;
	}

	/**
	 * Delete expired CAPTCHA info option
	 *
	 * Note: A unique instance these option is created everytime the login page is loaded with CAPTCHA enabled
	 * This function will help prune the options table of old expired entries.
	 *
	 * @global wpdb $wpdb
	 */
	public static function delete_expired_captcha_options() {
		global $wpdb;
		$current_unix_time = current_time('timestamp', true);
		$previous_hour = $current_unix_time - 3600;
		$tbl = is_multisite() ? $wpdb->sitemeta : $wpdb->prefix . 'options';
		$key_name = is_multisite() ? 'meta_key' : 'option_name';
		$key_val = is_multisite() ? 'meta_value' : 'option_value';
		$query = $wpdb->prepare("SELECT * FROM {$tbl} WHERE {$key_name} LIKE 'aiowps_captcha_string_info_time_%' AND {$key_val} < %s", $previous_hour);
		$res = $wpdb->get_results($query, ARRAY_A);
		if (!empty($res)) {
			foreach ($res as $item) {
				$option_name = $item[$key_name];
				if (is_multisite()) {
					delete_site_option($option_name);
					delete_site_option(str_replace('time_', '', $option_name));
				} else {
					delete_option($option_name);
					delete_option(str_replace('time_', '', $option_name));
				}
			}
		}
	}

	/**
	 * Get server type.
	 *
	 * @return string|integer Server type or -1 if server is not supported
	 */
	public static function get_server_type() {
		if (!isset($_SERVER['SERVER_SOFTWARE'])) {
			return apply_filters('aios_server_type', -1);
		}

		// Figure out what server they're using.
		$server_software = strtolower(sanitize_text_field(wp_unslash(($_SERVER['SERVER_SOFTWARE']))));

		if (strstr($server_software, 'apache')) {
			$server_type = 'apache';
		} elseif (strstr($server_software, 'nginx')) {
			$server_type = 'nginx';
		} elseif (strstr($server_software, 'litespeed')) {
			$server_type = 'litespeed';
		} elseif (strstr($server_software, 'iis')) {
			$server_type = 'iis';
		} elseif (strstr($server_software, 'lighttpd')) {
			$server_type = 'lighttpd';
		} else { // Unsupported server
			$server_type = -1;
		}

		return apply_filters('aios_server_type', $server_type);
	}

	/**
	 * Checks if the string exists in the array key value of the provided array.
	 * If it doesn't exist, it returns the first key element from the valid values.
	 *
	 * @param type $to_check
	 * @param type $valid_values
	 * @return type
	 */
	public static function sanitize_value_by_array($to_check, $valid_values) {
		$keys = array_keys($valid_values);
		$keys = array_map('strtolower', $keys);
		if (in_array(strtolower($to_check), $keys)) {
			return $to_check;
		}
		return reset($keys); //Return the first element from the valid values
	}

	/**
	 * Get textarea string from array or string.
	 *
	 * @param String|Array $vals value to render as textarea val
	 * @return String value to render in textarea.
	 */
	public static function get_textarea_str_val($vals) {
		if (empty($vals)) {
			return '';
		}

		if (is_array($vals)) {
			return implode("\n", array_filter(array_map('trim', $vals)));
		}

		return $vals;
	}

	/**
	 * Get array from textarea val.
	 *
	 * @param String|Array $vals value from textarea val
	 * @return Array value to from textarea value.
	 */
	public static function get_array_from_textarea_val($vals) {
		if (empty($vals)) {
			return array();
		}

		if (is_array($vals)) {
			return $vals;
		}

		return array_filter(array_map('trim', explode("\n", $vals)));
	}
	
	/**
	 * Partially or fully masks a string using '*' to replace original characters
	 *
	 * @param type string $str
	 * @param type int    $chars_unmasked
	 * @return type string
	 */
	public static function mask_string($str, $chars_unmasked = 0) {
	$str_length = strlen($str);
		$chars_unmasked = absint($chars_unmasked);

		if (0 == $chars_unmasked) {
			if (8 < $str_length) {
				// mask all but last 4 characters
				return preg_replace("/(.{4}$)(*SKIP)(*F)|(.)/u", "*", $str);
			} elseif (3 < $str_length) {
				// mask all but last 2 characters
				return preg_replace("/(.{2}$)(*SKIP)(*F)|(.)/u", "*", $str);
			} else {
				// return whole string masked
				return str_pad("", $str_length, "*", STR_PAD_LEFT);
			}
		}
		if ($chars_unmasked >= $str_length) return $str;
		return preg_replace("/(.{".$chars_unmasked."}$)(*SKIP)(*F)|(.)/u", "*", $str);
	}
	
	/**
	 * Create a php backtrace log file for login lockdown email
	 *
	 * @param Array $logs
	 * @global AIO_WP_Security $aio_wp_security
	 * @return string
	 */
	public static function login_lockdown_email_backtrace_log_file($logs = array()) {
		global $aio_wp_security;
		$temp_dir = get_temp_dir();
		$backtrace_filename = wp_unique_filename($temp_dir, 'log_backtrace_' . time() . '.txt');
		$backtrace_filepath = $temp_dir.$backtrace_filename;
		if (count($logs) > 0) {
			$dbg = "";
			foreach ($logs as $log) {
				$dbg.= "############ BACKTRACE STARTS  ########\n";
				$dbg.= $log['backtrace_log'];
				$dbg.= "############ BACKTRACE ENDS  ########\n\n";
			}
		} else {
			$dbg = debug_backtrace();
		}
		$is_log_file_written = file_put_contents($backtrace_filepath, print_r($dbg, true));
		if ($is_log_file_written) {
			return $backtrace_filepath;
		} else {
			$aio_wp_security->debug_logger->log_debug("Error in writing php backtrace file " . $backtrace_filepath . " to attach in email.", 4);
			return '';
		}
	}

	/**
	 * Normalise call stacks by clearing out unnecessary objects from their arguments list, leaving only the first arguments as a string. The call stacks should be one that is generated by debug_backtrace() function.
	 *
	 * @param array $backtrace The output of the debug_backtrace() function
	 * @return array An array of associative arrays after being normalised
	 */
	public static function normalise_call_stack_args($backtrace) {
		foreach ($backtrace as $index => $element) {
			if (!isset($element['args']) || !is_array($element['args']) || !isset($element['args'][0])) $backtrace[$index]['args'] = array('');
			foreach ($backtrace[$index]['args'] as $key => $arg) {
				if (is_object($arg)) {
					$backtrace[$index]['args'][$key] = array(get_class($backtrace[$index]['args'][$key]));
				} elseif (!is_string($arg)) {
					$backtrace[$index]['args'][$key] = array('');
				}
			}
			
			if ('apply_filters' == $backtrace[$index]['function'] && 'authenticate' == $backtrace[$index]['args'][0]) {
				$backtrace[$index]['args'] = array('authenticate');
			}

			if ('do_action' == $backtrace[$index]['function'] && 'password_reset' == $backtrace[$index]['args'][0]) {
				$backtrace[$index]['args'] = array('password_reset');
			}
			
			$keys_to_filter = array('wp_create_user', 'wpmu_create_user', 'wp_authenticate', 'post_authenticate', 'reset_password');
			if (in_array($backtrace[$index]['function'], $keys_to_filter)) {
				$backtrace[$index]['args'] = array();
			}
		}
		return $backtrace;
	}

	/**
	 * Check whether the WooCommerce plugin is active.
	 *
	 * @return Boolean True if the WooCommerce plugin is active, otherwise false.
	 */
	public static function is_woocommerce_plugin_active() {
		return is_plugin_active('woocommerce/woocommerce.php');
	}

	/**
	 * Check whether incompatible TFA premium plugin version active.
	 *
	 * @return boolean True if the incompatible TFA premium plugin version active, otherwise false.
	 */
	public static function is_incompatible_tfa_premium_version_active() {
		if (!function_exists('get_plugin_data')) {
			require_once(ABSPATH . '/wp-admin/includes/plugin.php');
		}

		$active_plugins = wp_get_active_and_valid_plugins();

		foreach ($active_plugins as $plugin_file) {
			if ('two-factor-login.php' == basename($plugin_file) && is_dir(dirname($plugin_file) . '/simba-tfa/premium') && version_compare(get_plugin_data($plugin_file)['Version'], AIOS_TFA_PREMIUM_LATEST_INCOMPATIBLE_VERSION, '<=')) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check whether TFA plugin activating.
	 *
	 * @return boolean True if the TFA plugin activating, otherwise false.
	 */
	public static function is_tfa_or_self_plugin_activating() {
		// The $GLOBALS['pagenow'] doesn't set in the network admin plugins page and it throws the warning "Notice: Undefined index: pagenow in ..." so we can't use it.
		// https://core.trac.wordpress.org/ticket/42656
		return is_admin() &&
			preg_match('#/wp-admin/plugins.php$#i', $_SERVER['PHP_SELF']) && isset($_GET['plugin']) && (preg_match("/\/two-factor-login.php/", $_GET['plugin']) || preg_match("/all-in-one-wp-security-and-firewall/", $_GET['plugin']));
	}

	/**
	 * Check whether the site is running on localhost or not.
	 *
	 * @return Boolean True if the site is on localhost, otherwise false.
	 */
	public static function is_localhost() {
		if (defined('AIOS_IS_LOCALHOST')) {
			return AIOS_IS_LOCALHOST;
		}

		if (empty($_SERVER['REMOTE_ADDR'])) {
			return false;
		}
		return in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')) ? true : false;
	}

	/**
	 * Get server software.
	 *
	 * @return string Server software or empty.
	 */
	public static function get_server_software() {
		static $server_software;
		if (!isset($server_software)) {
			$server_software = (isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '');
		}
		return $server_software;
	}

	/**
	 * Check whether the server is apache or not.
	 *
	 * @return Boolean True the server is apache, otherwise false.
	 */
	public static function is_apache_server() {
		return (false !== strpos(self::get_server_software(), 'Apache'));
	}

	/**
	 * Change salt postfixes.
	 *
	 * @return boolean True if the salt postfixes are changed otherwise false.
	 */
	public static function change_salt_postfixes() {
		global $aio_wp_security;

		$salt_postfixes = array(
			'auth' => wp_generate_password(64, true, true),
			'secure_auth' => wp_generate_password(64, true, true),
			'logged_in' => wp_generate_password(64, true, true),
			'nonce' => wp_generate_password(64, true, true),
		);

		return $aio_wp_security->configs->set_value('aiowps_salt_postfixes', $salt_postfixes, true);
	}

	/**
	 * This function checks to see if there is a display condition for the item and if so runs it otherwise it returns true to display the item
	 *
	 * @param array $item_info - the item information array
	 *
	 * @return boolean - true if the item should be displayed or false to hide it
	 */
	public static function should_display_item($item_info) {
		if (!empty($item_info['display_condition_callback']) && is_callable($item_info['display_condition_callback'])) {
			return call_user_func($item_info['display_condition_callback']);
		} elseif (!empty($item_info['display_condition_callback']) && !is_callable($item_info['display_condition_callback'])) {
			$item = isset($item_info['page_title']) ? $item_info['page_title'] : '';
			error_log("Callback function set but not callable (coding error). Item: " . $item);
			return false;
		}
		return true;
	}

	/**
	 * Verify the username is valid based on logged_in cookie information
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_validate_auth_cookie/
	 * @param  string $info  - Cookie info
	 * @param  int    $grace - A grace period for the expiration in seconds
	 * @return string       - Username if valid; blank string otherwise
	 */
	public static function verify_username($info, $grace = 3600) {
		
		if (!is_string($info)) return '';

		$elements = wp_parse_auth_cookie($info, 'logged_in');

		if (empty($elements)) return '';

		$username   = $elements['username'];
		$expiration = $elements['expiration'];
		$token      = $elements['token'];
		$hmac       = $elements['hmac'];
		$scheme     = $elements['scheme'];

		// Add a grace period to the expiration check since there may be a delay in processing the user data
		if (!empty($grace) && ($expiration + absint($grace)) < time()) return '';

		$user = get_user_by('login', $username);

		if (false === $user) return '';

		$pass_frag = substr($user->user_pass, 8, 4);

		$key = wp_hash($username . '|' . $pass_frag . '|' . $expiration . '|' . $token, $scheme);

		// Use sha1, if sha256 is not available
		$algo = function_exists('hash') ? 'sha256' : 'sha1';
		$hash = hash_hmac($algo, $username . '|' . $expiration . '|' . $token, $key);

		if (hash_equals($hash, $hmac)) {
			return $username;
		}

		return '';
	}

	/**
	 * Get the blog ID from the provided request
	 *
	 * @param array $request
	 * @return int - returns the blog_id or 0 if it cannot be found
	 */
	public static function get_blog_id_from_request($request) {

		if (!is_multisite()) return get_current_blog_id();

		$can_get_blog_id = isset($request['REQUEST_SCHEME']) && isset($request['HTTP_HOST']) && isset($request['REQUEST_URI']);
		if (!$can_get_blog_id) return 0;

		$site_url   = $request['REQUEST_SCHEME'].'://'.$request['HTTP_HOST'].$request['REQUEST_URI'];
		$components = parse_url(trailingslashit($site_url));

		$can_get_blog_id = isset($components['host']) && isset($components['path']);
		if (!$can_get_blog_id) return 0;

		$default_path = defined('PATH_CURRENT_SITE') ? constant('PATH_CURRENT_SITE') : '/';

		$domain = $components['host'];
		$path   = SUBDOMAIN_INSTALL ? $default_path : ($default_path === $components['path'] ? $components['path'] : '/'.explode('/', $components['path'])[1].'/');

		$blog_id = get_blog_id_from_url($domain, $path);
		
		// On a subdirectory installation, if the blog_id cannot be found for the subdirectory given, we assume it's a path belonging to the main site
		// So use the main site's blog_id.
		if (0 === $blog_id && !SUBDOMAIN_INSTALL) $blog_id = get_blog_id_from_url($domain, $default_path);

		return $blog_id;
	}

	/**
	 * Checks if the bbPress plugin is active.
	 *
	 * @return Boolean True if the bbPress plugin is active, otherwise false.
	 */
	public static function is_bbpress_plugin_active() {
		return is_plugin_active('bbpress/bbpress.php');
	}

	/**
	 * Checks if the Buddypress plugin is active.
	 *
	 * @return Boolean True if the Buddypress plugin is active, otherwise false.
	 */
	public static function is_buddypress_plugin_active() {
		return is_plugin_active('buddypress/bp-loader.php');
	}

	/**
	 * Checks if the Contact Form 7 plugin is active.
	 *
	 * @return Boolean - True if the Contact Form 7 plugin is active, otherwise false.
	 */
	public static function is_contact_form_7_plugin_active() {
		return is_plugin_active('contact-form-7/wp-contact-form-7.php');
	}

	/**
	 * Checks if the Memberpress plugin is active.
	 *
	 * @return Boolean - True if the Memberpress plugin is active, otherwise false.
	 */
	public static function is_memberpress_plugin_active() {
		return is_plugin_active('memberpress/memberpress.php');
	}
	 
	/**
	 * Retrieves and returns current WP general settings date time format.
	 *
	 * @return string
	 */
	public static function get_wp_datetime_format() {
		return get_option('date_format') . ' ' . get_option('time_format');
	}

	/**
	 * This function gets the timezone of the site as a DateTimeZone object
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_timezone/
	 *
	 * @return DateTimeZone - the timezone of the site as a DateTimeZone object
	 */
	public static function get_wp_timezone() {
		return new DateTimeZone(self::get_wp_timezone_string());
	}

	/**
	 * This function gets the timezone of the site as a string
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_timezone_string/
	 *
	 * @return string - PHP timezone name or a ±HH:MM offset
	 */
	public static function get_wp_timezone_string() {
		$timezone_string = get_option('timezone_string');
		
		if ($timezone_string) return $timezone_string;
		
		$offset  = (float) get_option('gmt_offset');
		$hours   = (int) $offset;
		$minutes = ($offset - $hours);
		$sign    = ($offset < 0) ? '-' : '+';
		$abs_hour = abs($hours);
		$abs_mins = abs($minutes * 60);
		$tz_offset = sprintf('%s%02d:%02d', $sign, $abs_hour, $abs_mins);
		
		return $tz_offset;
	}

	/**
	 * Converts a Unix timestamp to WP general settings timezone and format. It will also translate with wp_date if available.
	 *
	 * @param string $timestamp Optional. Will default to time() if not provided.
	 * @param string $format    Optional. Will default to WP general settings format if not provided.
	 *
	 * @return string
	 */
	public static function convert_timestamp($timestamp = null, $format = null) {

		if (!$format) $format = self::get_wp_datetime_format();

		if (!$timestamp) $timestamp = time();

		return function_exists('wp_date') ? wp_date($format, $timestamp) : get_date_from_gmt(gmdate('Y-m-d H:i:s', $timestamp), $format);
	}

	/**
	 * Deletes unneeded default WP files.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @param bool $echo_results
	 *
	 * @return array
	 */
	public static function delete_unneeded_default_files($echo_results = false) {
		global $aio_wp_security;

		$files = array('readme.html', 'wp-config-sample.php', 'license.txt');
		$info = array();
		$error = array();
		foreach ($files as $file_name) {
			$file_path = ABSPATH . $file_name;

			if (file_exists($file_path)) {
				if (@unlink($file_path)) {
					$success_message = sprintf(__('Successfully deleted the %s file.', 'all-in-one-wp-security-and-firewall'), $file_name);
					$aio_wp_security->debug_logger->log_debug($success_message, 0);

					if ($echo_results) {
						AIOWPSecurity_Admin_Menu::show_msg_updated_st($success_message);
					}
				} else {
					$failure_message = sprintf(__('Failed to delete the %s file.', 'all-in-one-wp-security-and-firewall'), $file_name) . ' ' . sprintf(__('Check the file/directory permissions at: %s', 'all-in-one-wp-security-and-firewall'), $file_path);
					$error[] = $file_name;
					$aio_wp_security->debug_logger->log_debug($failure_message, 4);

					if ($echo_results) {
						AIOWPSecurity_Admin_Menu::show_msg_error_st($failure_message);
					}
				}
			} else {
				$message = sprintf(__('The %s file has already been deleted.', 'all-in-one-wp-security-and-firewall'), $file_name);
				$info[] = $message;
				$aio_wp_security->debug_logger->log_debug($message, 0);

				if ($echo_results) {
					AIOWPSecurity_Admin_Menu::show_msg_updated_st($message);
				}
			}
		}


		return array(
			'info' => $info,
			'error' => empty($error) ? '' : implode(', ', $error)
		);
	}

	/**
	 * Convert a number of bytes into a suitable textual string
	 *
	 * @param Integer $size - the number of bytes
	 *
	 * @return String - the resulting textual string
	 */
	public static function convert_numeric_size_to_text($size) {
		if ($size > 1073741824) {
			return round($size / 1073741824, 1).' GB';
		} elseif ($size > 1048576) {
			return round($size / 1048576, 1).' MB';
		} elseif ($size > 1024) {
			return round($size / 1024, 1).' KB';
		} else {
			return round($size, 1).' B';
		}
	}

	/**
	 * Updates the Googlebot IP ranges config.
	 *
	 * @global AIOWPS\Firewall\Config $aiowps_firewall_config
	 *
	 * @return array|WP_Error
	 */
	public static function get_googlebot_ip_ranges() {
		$response = wp_safe_remote_get('https://developers.google.com/static/search/apis/ipranges/googlebot.json');

		$body = wp_remote_retrieve_body($response);
		$json_array = json_decode($body, true);

		$ip_list_array = array();

		foreach ($json_array['prefixes'] as $prefix) {
			$ip_list_array[] = array_key_exists('ipv4Prefix', $prefix) ? $prefix['ipv4Prefix'] : $prefix['ipv6Prefix'];
		}

		return AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'whitelist');
	}

	/**
	 * Check if a user is a member of the current blog ID in a multisite environment.
	 *
	 * @param int $user_id - User ID to check.
	 *
	 * @return bool Whether the user is a member of the current blog ID.
	 */
	public static function is_user_member_of_blog($user_id) {
		$current_user_id = get_current_user_id();

		if (is_multisite() && !is_super_admin($current_user_id)) {
			$blog_id = get_current_blog_id();
			return is_user_member_of_blog($user_id, $blog_id);
		}

		// Non-multisite or super admin, consider the user a member
		return true;
	}

	/**
	 * Blacklists an IP address.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPS\Firewall\Config $aiowps_firewall_config
	 *
	 * @param string $ip The IP address to be blacklisted.
	 *
	 * @return void|WP_Error
	 */
	public static function blacklist_ip($ip) {
		global $aio_wp_security, $aiowps_firewall_config;

		$blacklisted_ip_addresses = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses');

		$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($blacklisted_ip_addresses);
		$ip_list_array[] = $ip;

		$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'blacklist');

		if (is_wp_error($validated_ip_list_array)) {
			return $validated_ip_list_array;
		} else {
			$banned_ip_data = implode("\n", $validated_ip_list_array);

			$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', '1'); // Force blacklist feature to be enabled.
			$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', $banned_ip_data);
			$aio_wp_security->configs->save_config();

			$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $validated_ip_list_array);
		}
	}

	/**
	 * Unlocks an IP address.
	 *
	 * @global wpdb $wpdb
	 *
	 * @param string $ip The IP address to be blacklisted.
	 *
	 * @return boolean
	 */
	public static function unlock_ip($ip) {
		global $wpdb;

		$lockout_table = AIOWPSEC_TBL_LOGIN_LOCKOUT;

		// Unlock single record.
		$result = $wpdb->query($wpdb->prepare("UPDATE $lockout_table SET `released` = UNIX_TIMESTAMP() WHERE `failed_login_ip` = %s", $ip));

		return null != $result;
	}

	/**
	 * Unblacklists an IP address.
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 * @global AIOWPS\Firewall\Config $aiowps_firewall_config
	 *
	 * @param string $ip The IP address to be unblacklisted.
	 *
	 * @return boolean
	 */
	public static function unblacklist_ip($ip) {
		global $aio_wp_security, $aiowps_firewall_config;

		$blacklisted_ip_addresses = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses');

		$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($blacklisted_ip_addresses);

		if (!in_array($ip, $ip_list_array)) {
			return false;
		}

		$ip_list_array = array_diff($ip_list_array, array($ip));

		$banned_ip_data = implode("\n", $ip_list_array);

		$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', $banned_ip_data);
		$aio_wp_security->configs->save_config();

		$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $ip_list_array);

		return true;
	}

	/**
	 * Determines if the .htaccess file can be written to.
	 *
	 * This function checks if the current user has the necessary permissions
	 * (is the main site and super admin) and whether the server type is supported
	 * for writing to the .htaccess file. It prevents modifications on unsupported
	 * server types such as Nginx and IIS.
	 *
	 * @return bool True if .htaccess can be written to, false otherwise.
	 */
	public static function allow_to_write_to_htaccess() {
		if (!AIOWPSecurity_Utility_Permissions::is_main_site_and_super_admin()) return false;
		$serverType = self::get_server_type();

		return !in_array($serverType, array('-1', 'nginx', 'iis'));
	}
}
