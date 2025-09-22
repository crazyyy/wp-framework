<?php
if (!defined('ABSPATH')) {
	exit; //Exit if accessed directly
}

class AIOWPSecurity_Debug {

	// Some of the contents of this file doesn't need to be translated as it is for developers

	/**
	 * List of sections to include in the debug report
	 *
	 * @var array
	 */
	private static $sections = array(
		'AIOS plugin information' => 'get_aios_info',
		'Server information' => 'get_server_info',
		'WordPress information' => 'get_wordpress_info',
		'PHP information' => 'get_php_info',
		'Database information' => 'get_database_info',
		'Plugin information' => 'get_plugins_list',
		'Must-use plugin information' => 'get_mu_plugins_list',
		'Drop-in information' => 'get_dropin_plugins_list',
		'Theme information' => 'get_themes_list',
		'IP detection methods' => 'get_ip_detection_methods',
		'Cron information' => 'get_cron_jobs_list',
	);

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action('aiowp_security_additional_report_actions', array($this, 'add_sender_report_actions'));
	}

	/**
	 * Get AIOS Information
	 *
	 * @return array AIOS information
	 */
	private static function get_aios_info() {

		$aios_info = array(
			'AIOS plugin version' => AIO_WP_SECURITY_VERSION,
			'AIOS DB version' => AIO_WP_SECURITY_DB_VERSION,
			'AIOS firewall version' => AIO_WP_SECURITY_FIREWALL_VERSION,
			'AIOS Premium installed' => AIOWPSecurity_Utility_Permissions::is_premium_installed() ? 'Yes' : 'No',
		);

		if (AIOWPSecurity_Utility_Permissions::is_premium_installed()) {
			$aios_info['AIOS Premium version'] = AIOWPS_PREMIUM_VERSION;
		}

		return apply_filters('aiowp_security_get_aios_info', $aios_info);
	}

	/**
	 * Get Server Information
	 *
	 * @return array Server information
	 */
	private static function get_server_info() {

		$server_info = array(
			'Operating system' => php_uname('s') . ' ' . php_uname('r'),
			'Server' => $_SERVER['SERVER_SOFTWARE'],
			'Memory usage' => AIOWPSecurity_Utility::convert_numeric_size_to_text(memory_get_peak_usage(true)),
		);

		if (function_exists('disk_total_space')) {
			$server_info = array_merge($server_info, array(
				'Total space' => AIOWPSecurity_Utility::convert_numeric_size_to_text(disk_total_space('/')),
				'Used space' => AIOWPSecurity_Utility::convert_numeric_size_to_text(disk_total_space('/') - disk_free_space('/')),
			));
		}
		return apply_filters('aiowp_security_get_server_info', $server_info);
	}

	/**
	 * Get PHP Information
	 *
	 * @return array PHP information
	 */
	private static function get_php_info() {

		$php_info = array(
			'PHP version' => phpversion(),
			'PHP expose php' => ini_get('expose_php') ? 'Active' : 'Inactive',
			'PHP allow url fopen' => ini_get('allow_url_fopen') ? 'Active' : 'Inactive',
			'PHP memory limit' => ini_get('memory_limit'),
			'PHP upload max filesize' => ini_get('upload_max_filesize'),
			'PHP post max size' => ini_get('post_max_size'),
			'PHP max execution time' => ini_get('max_execution_time'),
			'PHP max input time' => ini_get('max_input_time'),
			'Process owner' => (function_exists('posix_geteuid') && function_exists('posix_getpwuid')) ? posix_getpwuid(posix_geteuid())['name'] : 'Unknown',
			'OpenSSL support' => extension_loaded('openssl') ? 'OK' : 'Not Installed',
			'OpenSSL version' => extension_loaded('openssl') ? OPENSSL_VERSION_TEXT : 'Unknown',
			'cURL support' => function_exists('curl_init') ? 'OK' : 'Not Installed',
			'cURL features code' => function_exists('curl_version') ? curl_version()['features'] : 'Unknown',
			'cURL host' => function_exists('curl_version') ? curl_version()['host'] : 'Unknown',
			'cURL support protocols' => function_exists('curl_version') ? implode(', ', curl_version()['protocols']) : 'Unknown',
			'cURL SSL version' => function_exists('curl_version') ? curl_version()['ssl_version'] : 'Unknown',
			'cURL libz version' => function_exists('curl_version') ? curl_version()['libz_version'] : 'Unknown',
			'Checking display_errors' => ini_get('display_errors') ? 'Enabled' : 'Disabled',
		);

		return apply_filters('aiowp_security_get_php_info', $php_info);
	}

	/**
	 * Retrieves detailed information about the WordPress configuration.
	 *
	 * @return array WordPress configuration information
	 */
	private static function get_wordpress_info() {

		// Include version.php to retrieve the actual WordPress version
		require_once ABSPATH . WPINC . '/version.php';

		global $wp_version;

		$wp_info = array(
			'WordPress version' => $wp_version,
			'Multisite' => is_multisite() ? 'Yes' : 'No', // Checking if the site is multisite
			'ABSPATH' => ABSPATH,
			'WP_DEBUG' => (defined('WP_DEBUG') && WP_DEBUG) ? 'On' : 'Off',
			'WP_DEBUG_LOG' => (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) ? 'Enabled' : 'Disabled',
			'WP_DEBUG_DISPLAY' => (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) ? 'Enabled' : 'Disabled',
			'SCRIPT_DEBUG' => (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? 'On' : 'Off',
			'SAVEQUERIES' => (defined('SAVEQUERIES') && SAVEQUERIES) ? 'On' : 'Off',
			'DB_CHARSET' => defined('DB_CHARSET') ? DB_CHARSET : '(not set)',
			'DB_COLLATE' => defined('DB_COLLATE') ? DB_COLLATE : '(not set)',
			'WP_SITEURL' => defined('WP_SITEURL') ? WP_SITEURL : '(not set)',
			'WP_HOME' => defined('WP_HOME') ? WP_HOME : '(not set)',
			'WP_CONTENT_DIR' => defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR : '(not set)',
			'WP_CONTENT_URL' => defined('WP_CONTENT_URL') ? WP_CONTENT_URL : '(not set)',
			'WP_PLUGIN_DIR' => defined('WP_PLUGIN_DIR') ? WP_PLUGIN_DIR : '(not set)',
			'WP_LANG_DIR' => defined('WP_LANG_DIR') ? WP_LANG_DIR : '(not set)',
			'WPLANG' => defined('WPLANG') ? WPLANG : '(not set)',
			'UPLOADS' => defined('UPLOADS') ? UPLOADS : '(not set)',
			'TEMPLATEPATH' => defined('TEMPLATEPATH') ? TEMPLATEPATH : '(not set)',
			'STYLESHEETPATH' => defined('STYLESHEETPATH') ? STYLESHEETPATH : '(not set)',
			'AUTOSAVE_INTERVAL' => defined('AUTOSAVE_INTERVAL') ? AUTOSAVE_INTERVAL : '',
			'WP_POST_REVISIONS' => defined('WP_POST_REVISIONS') ? WP_POST_REVISIONS : 'Unlimited',
			'COOKIE_DOMAIN' => defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '(not set)',
			'COOKIEPATH' => defined('COOKIEPATH') ? COOKIEPATH : '/',
			'SITECOOKIEPATH' => defined('SITECOOKIEPATH') ? SITECOOKIEPATH : '/',
			'ADMIN_COOKIE_PATH' => defined('ADMIN_COOKIE_PATH') ? ADMIN_COOKIE_PATH : '/',
			'PLUGINS_COOKIE_PATH' => defined('PLUGINS_COOKIE_PATH') ? PLUGINS_COOKIE_PATH : '/wp-content/plugins',
			'NOBLOGREDIRECT' => defined('NOBLOGREDIRECT') ? NOBLOGREDIRECT : '(not set)',
			'CONCATENATE_SCRIPTS' => defined('CONCATENATE_SCRIPTS') ? (CONCATENATE_SCRIPTS ? 'Yes' : 'No') : 'No', // Checking if CONCATENATE_SCRIPTS is defined
			'WP_MEMORY_LIMIT' => defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : '',
			'WP_MAX_MEMORY_LIMIT' => defined('WP_MAX_MEMORY_LIMIT') ? WP_MAX_MEMORY_LIMIT : '',
			'WP_CACHE' => defined('WP_CACHE') ? (WP_CACHE ? 'Enabled' : 'Disabled') : 'Disabled',
			'CUSTOM_USER_TABLE' => defined('CUSTOM_USER_TABLE') ? CUSTOM_USER_TABLE : '(not set)',
			'CUSTOM_USER_META_TABLE' => defined('CUSTOM_USER_META_TABLE') ? CUSTOM_USER_META_TABLE : '(not set)',
			'FS_CHMOD_DIR' => defined('FS_CHMOD_DIR') ? FS_CHMOD_DIR : '(not set)',
			'FS_CHMOD_FILE' => defined('FS_CHMOD_FILE') ? FS_CHMOD_FILE : '(not set)',
			'ALTERNATE_WP_CRON' => defined('ALTERNATE_WP_CRON') ? (ALTERNATE_WP_CRON ? 'Enabled' : 'Disabled') : 'Disabled',
			'DISABLE_WP_CRON' => defined('DISABLE_WP_CRON') ? (DISABLE_WP_CRON ? 'Cron is disabled' : 'Cron is enabled') : 'Cron is enabled',
			'WP_CRON_LOCK_TIMEOUT' => defined('WP_CRON_LOCK_TIMEOUT') ? WP_CRON_LOCK_TIMEOUT : '',
			'EMPTY_TRASH_DAYS' => defined('EMPTY_TRASH_DAYS') ? EMPTY_TRASH_DAYS : '',
			'WP_ALLOW_REPAIR' => defined('WP_ALLOW_REPAIR') ? (WP_ALLOW_REPAIR ? 'Enabled' : 'Disabled') : 'Disabled',
			'DO_NOT_UPGRADE_GLOBAL_TABLES' => defined('DO_NOT_UPGRADE_GLOBAL_TABLES') ? (DO_NOT_UPGRADE_GLOBAL_TABLES ? 'Yes' : 'No') : 'No', // Checking if DO_NOT_UPGRADE_GLOBAL_TABLES is defined
			'DISALLOW_FILE_EDIT' => defined('DISALLOW_FILE_EDIT') ? (DISALLOW_FILE_EDIT ? 'Yes' : 'No') : 'No', // Checking if DISALLOW_FILE_EDIT is defined
			'DISALLOW_FILE_MODS' => defined('DISALLOW_FILE_MODS') ? (DISALLOW_FILE_MODS ? 'Yes' : 'No') : 'No', // Checking if DISALLOW_FILE_MODS is defined
			'IMAGE_EDIT_OVERWRITE' => defined('IMAGE_EDIT_OVERWRITE') ? (IMAGE_EDIT_OVERWRITE ? 'Yes' : 'No') : 'No', // Checking if IMAGE_EDIT_OVERWRITE is defined
			'FORCE_SSL_ADMIN' => defined('FORCE_SSL_ADMIN') ? (FORCE_SSL_ADMIN ? 'Yes' : 'No') : 'No', // Checking if FORCE_SSL_ADMIN is defined
			'WP_HTTP_BLOCK_EXTERNAL' => defined('WP_HTTP_BLOCK_EXTERNAL') ? (WP_HTTP_BLOCK_EXTERNAL ? 'Yes' : 'No') : 'No', // Checking if WP_HTTP_BLOCK_EXTERNAL is defined
			'WP_ACCESSIBLE_HOSTS' => defined('WP_ACCESSIBLE_HOSTS') ? WP_ACCESSIBLE_HOSTS : '(not set)',
			'WP_AUTO_UPDATE_CORE' => defined('WP_AUTO_UPDATE_CORE') ? WP_AUTO_UPDATE_CORE : 'Default',
			'WP_PROXY_HOST' => defined('WP_PROXY_HOST') ? WP_PROXY_HOST : '(not set)',
			'WP_PROXY_PORT' => defined('WP_PROXY_PORT') ? WP_PROXY_PORT : '(not set)',
			'MULTISITE' => defined('MULTISITE') ? (MULTISITE ? 'Yes' : 'No') : 'No', // Checking if MULTISITE is defined
			'WP_ALLOW_MULTISITE' => defined('WP_ALLOW_MULTISITE') ? (WP_ALLOW_MULTISITE ? 'Yes' : 'No') : 'No', // Checking if WP_ALLOW_MULTISITE is defined
			'SUNRISE' => defined('SUNRISE') ? (SUNRISE ? 'Yes' : 'No') : 'No', // Checking if SUNRISE is defined
			'SUBDOMAIN_INSTALL' => defined('SUBDOMAIN_INSTALL') ? (SUBDOMAIN_INSTALL ? 'Yes' : 'No') : 'No', // Checking if SUBDOMAIN_INSTALL is defined
			'VHOST' => defined('VHOST') ? (VHOST ? 'Yes' : 'No') : 'No', // Checking if VHOST is defined
			'DOMAIN_CURRENT_SITE' => defined('DOMAIN_CURRENT_SITE') ? DOMAIN_CURRENT_SITE : '(not set)',
			'PATH_CURRENT_SITE' => defined('PATH_CURRENT_SITE') ? PATH_CURRENT_SITE : '(not set)',
			'BLOG_ID_CURRENT_SITE' => defined('BLOG_ID_CURRENT_SITE') ? BLOG_ID_CURRENT_SITE : '(not set)',
			'WP_DISABLE_FATAL_ERROR_HANDLER' => defined('WP_DISABLE_FATAL_ERROR_HANDLER') ? (WP_DISABLE_FATAL_ERROR_HANDLER ? 'Yes' : 'No') : 'No', // Checking if WP_DISABLE_FATAL_ERROR_HANDLER is defined
			'AUTOMATIC_UPDATER_DISABLED' => defined('AUTOMATIC_UPDATER_DISABLED') ? (AUTOMATIC_UPDATER_DISABLED ? 'Yes' : 'No') : 'No' // Checking if AUTOMATIC_UPDATER_DISABLED is defined
		);
	
		return apply_filters('aiowp_security_get_wordpress_info', $wp_info);
	}

	/**
	 * Get a list of active and inactive plugins.
	 *
	 * @return array List of plugins with their status (active/inactive).
	 */
	private static function get_plugins_list() {
		$plugins = get_plugins();
		$active_plugins = get_option('active_plugins', array());
	
		$plugins_list = array();

		if (empty($plugins)) {
			return array('No plugins found' => '-');
		}
	
		foreach ($plugins as $plugin_path => $plugin_info) {
			$plugin_slug = strtolower(basename($plugin_path, '.php'));
			$plugin_status = in_array($plugin_path, $active_plugins) ? 'Active' : 'Inactive';
			$plugin_version = $plugin_info['Version'];
			$plugin_name = $plugin_info['Name'];
	
			$plugin_key = "$plugin_name ($plugin_slug) [$plugin_version]";
			
			$plugins_list[$plugin_key] = $plugin_status;
		}
	
		return apply_filters('aiowp_security_get_plugins_info', $plugins_list);
	}

	/**
	 * Get a list of themes with their status (active/inactive), version, and slug.
	 *
	 * @return array List of themes.
	 */
	private static function get_themes_list() {
		$themes = wp_get_themes();
		$active_theme = wp_get_theme();
		$themes_list = array();

		if (empty($themes)) {
			return array('No themes found' => '-');
		}

		foreach ($themes as $theme_slug => $theme_info) {
			$theme_name = $theme_info->get('Name');
			$theme_version = $theme_info->get('Version');
			$theme_status = $theme_info->get_stylesheet() === $active_theme->get_stylesheet() ? 'Active' : 'Inactive';

			$theme_key = "$theme_name ($theme_slug) [$theme_version]";
			$themes_list[$theme_key] = $theme_status;
		}

		return apply_filters('aiowp_security_get_themes_info', $themes_list);
	}

	/**
	 * Get database information
	 *
	 * @return array Database information
	 */
	private static function get_database_info() {
		global $wpdb;
	
		$database_info = array(
			'Database version' => $wpdb->db_version(),
			'DELETE' => self::check_mysql_privilege('DELETE'),
			'INSERT' => self::check_mysql_privilege('INSERT'),
			'UPDATE' => self::check_mysql_privilege('UPDATE'),
			'SELECT' => self::check_mysql_privilege('SELECT'),
			'CREATE TABLE' => self::check_mysql_privilege('CREATE TABLE'),
			'ALTER TABLE' => self::check_mysql_privilege('ALTER TABLE'),
			'DROP' => self::check_mysql_privilege('DROP'),
			'TRUNCATE' => self::check_mysql_privilege('TRUNCATE')
		);
	
		return apply_filters('aiowp_security_get_database_info', $database_info);
	}

	/**
	 * Get a list of Must Use (MU) plugins.
	 *
	 * @return array List of MU plugins.
	 */
	private static function get_mu_plugins_list() {
		$mu_plugins = get_mu_plugins();
		$mu_plugins_list = array();

		if (empty($mu_plugins)) {
			return array('No Must-use plugins found' => '-');
		}
	
		foreach ($mu_plugins as $mu_plugin_path => $mu_plugin_info) {
			$mu_plugin_slug = basename($mu_plugin_path, '.php');
			$mu_plugin_version = $mu_plugin_info['Version'];
			$mu_plugin_name = $mu_plugin_info['Name'];
	
			$mu_plugin_key = "$mu_plugin_name ($mu_plugin_slug) [$mu_plugin_version]";
	
			$mu_plugins_list[$mu_plugin_key] = 'Active';
		}
	
		return apply_filters('aiowp_security_get_mu_plugins_info', $mu_plugins_list);
	}

	/**
	 * Get a list of drop-in plugins.
	 *
	 * @return array List of drop-in plugins.
	 */
	private static function get_dropin_plugins_list() {
		$dropins = _get_dropins();
		$dropins_list = array();

		if ('' === $dropins) {
			return array('No drop-in plugins found' => '-');
		}
	
		foreach ($dropins as $dropin_file => $dropin_info) {
			$dropin_status = true === $dropin_info[1] ? 'Active' : 'Inactive';
			$dropin_description = $dropin_info[0];

			$dropin_key = "$dropin_file [$dropin_description]";
			$dropins_list[$dropin_key] = $dropin_status;
		}
	
		return apply_filters('aiowp_security_get_dropin_plugins_info', $dropins_list);
	}

	/**
	 * Get a list of cron jobs scheduled in WordPress.
	 *
	 * @return array List of cron jobs.
	 */
	public static function get_cron_jobs_list() {
		$cron_jobs = _get_cron_array();
		$cron_jobs_list = array();

		$failed_jobs = 0;

		if (empty($cron_jobs)) {
			return array(); // Return an empty array if no cron jobs are found.
		}
	
		$current_timestamp = time();
		$cron_jobs_list['Failed cron jobs'] = $failed_jobs;
		foreach ($cron_jobs as $timestamp => $cron_events) {
			foreach ($cron_events as $event_hook => $event_data) {
				foreach ($event_data as $schedule => $callback) {
					if ($timestamp < $current_timestamp) {
					$failed_jobs++;
					}
					$schedule = $callback['schedule'];
					$cron_jobs_list[$event_hook] = $schedule;
				}
			}
		}
	
		return apply_filters('aiowp_security_get_cron_jobs_info', $cron_jobs_list);
	}

	/**
	 * Get debug log
	 *
	 * @param bool $html Whether to return the debug log as HTML
	 *
	 * @return string Debug log
	 */
	private static function get_debug_log($html = false) {
		global $wpdb, $aio_wp_security;

		if ('1' === $aio_wp_security->configs->get_value('aiowps_enable_debug')) {

			$debug_log_tbl = AIOWPSEC_TBL_DEBUG_LOG;

			$where_sql = is_super_admin() ? '' : 'WHERE site_id = %d';
			$query = "SELECT * FROM {$debug_log_tbl} {$where_sql} ORDER BY id DESC LIMIT 100";

			$debug_logs = is_super_admin() ? $wpdb->get_results($query, ARRAY_A) : $wpdb->get_results($wpdb->prepare($query, get_current_blog_id()), ARRAY_A);

			if ($html) {
				$debug_log = "<br><h3>Debug log</h3>";
			} else {
				$debug_log = "\n --- Debug log --- \n\n";
			}

			foreach ($debug_logs as $log) {
				$date_time = esc_html($log['created']);
				$level = esc_html($log['level']);
				$message = esc_html($log['message']);
				$type = esc_html($log['type']);
				
				if ($html) {
					$debug_log .= "<strong>Only the most recent 100 logs are displayed</strong><br>";
					$debug_log .= "<strong>Date and time:</strong> $date_time<br>";
					$debug_log .= "<strong>Level:</strong> $level<br>";
					$debug_log .= "<strong>Message:</strong> $message<br>";
					$debug_log .= "<strong>Type:</strong> $type<br><br>";
				} else {
					$debug_log .= "Only the most recent 100 logs are displayed.\n";
					$debug_log .= "Date and time: $date_time\n";
					$debug_log .= "Level: $level\n";
					$debug_log .= "Message: $message\n";
					$debug_log .= "Type: $type\n\n";
				}
			}
			
			return apply_filters('aiowp_security_get_debug_log_info', $debug_log);
		}
	}

	/**
	 * Get the IP address detection methods and their status
	 *
	 * @return array IP detection methods and their status
	 */
	private static function get_ip_detection_methods() {
		global $aio_wp_security;
		$ip_detection_methods = AIOS_Abstracted_Ids::get_ip_retrieve_methods();
	
		$active_method = $aio_wp_security->configs->get_site_value('aiowps_ip_retrieve_method');  // In a multisite network, this setting is available for the main site only.
		$active_method = empty($active_method) ? 0 : (int) $active_method;
	
		$ip_detection_list = array();
	
		foreach ($ip_detection_methods as $method => $variable) {
			$status = ($method === $active_method) ? ' - ' . __('status', 'all-in-one-wp-security-and-firewall') . ': ' . __('On', 'all-in-one-wp-security-and-firewall') : '';
			$ip_address = (!empty($_SERVER[$variable])) ? $_SERVER[$variable] : '';
			$ip_detection_list[$variable] = __('IP', 'all-in-one-wp-security-and-firewall') . ': ' . $ip_address . $status;
		}
	
		return $ip_detection_list;
	}

	/**
	 * Check if the current MySQL user has the specified privilege
	 *
	 * @param string $privilege Privilege to check
	 *
	 * @return string 'OK' if the user has the privilege, 'Not OK' otherwise
	 */
	private static function check_mysql_privilege($privilege) {
		global $wpdb;
		$grants = $wpdb->get_results("SHOW GRANTS FOR CURRENT_USER", ARRAY_N);
		foreach ($grants as $grant) {
			foreach ($grant as $grant_string) {
				if (strpos(strtoupper($grant_string), 'ALL PRIVILEGES') !== false || strpos(strtoupper($grant_string), strtoupper($privilege)) !== false) {
					return 'OK';
				}
			}
		}
		return 'Not OK';
	}

	/**
	 * Generate the debug report
	 *
	 * @return string Debug report
	 */
	public static function generate_report() {

		$data = '';
		$section_content = array();

		foreach (self::$sections as $title => $method) {
			$section_title = esc_html($title);
			$section_content = self::$method();

			// Check if the section content is empty, and handle accordingly.
			if (empty($section_content)) {
				$section_content = array('No data available');
			}

			$data .= AIOWPSecurity_Reporting::generate_report_sections('table', $section_content, $section_title);
		}

		return $data;
	}

	/**
	 * Generate a report for the diagnostics page
	 *
	 * @param string $title The title of the report
	 *
	 * @return string Report textarea
	 */
	public static function generate_report_textarea($title) {
		$main_content = '';

		$report_content = $title . "\n\n===================================\n";

		foreach (self::$sections as $title => $method) {
			$section_title = esc_html($title);
			$section_content = self::$method();
			$main_content .= AIOWPSecurity_Reporting::generate_report_sections('text', $section_content, $section_title);
		}

		$main_content .= self::get_debug_log();

		$report_content = apply_filters('aiowp_security_generate_report_content', $report_content . $main_content);

		$escaped_content = esc_textarea($report_content);

		return '<textarea id="report-textarea" rows="25" cols="100">' . $escaped_content . '</textarea>';
	}

	/**
	 * Generate sender action button and field
	 *
	 * @return string sender action button and email field
	 */
	public static function add_sender_report_actions() {
		$report_sections = '';
		foreach (self::$sections as $title => $method) {
			$section_title = esc_html($title);
			$section_content = self::$method();
			$report_sections .= AIOWPSecurity_Reporting::generate_report_sections('table', $section_content, $section_title);
		}
		$encoded_report_sections = htmlentities($report_sections);

		$data = '<div><form action="' . esc_url(admin_url('admin-post.php')) . '" method="POST"><br>';
		$data .= '<input type="email" id="report_email" placeholder="' . esc_attr__('Enter your email address', 'all-in-one-wp-security-and-firewall') . '" value="' . esc_attr(self::get_current_user_email()) . '" required><br><br>';
		$data .= '<input type="hidden" id="report_sections" value="'.$encoded_report_sections.'">';
		$data .= '<button class="button" id="send-report">' . esc_html__('Send report', 'all-in-one-wp-security-and-firewall') . '</button>';
		$data .= '</form><div id="report-response"></div></div>';

		// Allow only safe HTML in the response
		echo wp_kses($data, array(
			'div' => array(),
			'form' => array(
				'action' => true,
				'method' => true,
			),
			'input' => array(
				'type' => true,
				'id' => true,
				'placeholder' => true,
				'value' => true,
				'required' => true,
			),
			'button' => array(
				'class' => true,
				'id' => true,
			),
			'br' => array(),
		));
	}

	/**
	 * Get the current user email if admin or the site admin email
	 *
	 * @return string The email address
	 */
	private static function get_current_user_email() {
		$user = wp_get_current_user();
		if ($user && in_array('administrator', (array) $user->roles, true)) {
			return $user->user_email;
		} else {
			return get_option('admin_email');
		}
	}

	/**
	 * Send the report email
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @param string $email    The email address to send the report to.
	 * @param string $sections The report sections html.
	 *
	 * @return boolean True if the email was sent successfully, false otherwise
	 */
	public static function send_report($email, $sections) {
		global $aio_wp_security;

		$report = '<html><head><style>table{border-collapse:collapse;width:100%}th,td{border:1px solid #ddd;padding:8px}tr:nth-child(2n){background-color:#f2f2f2}tr:hover{background-color:#ddd}h3{margin-top:20px;}</style><head>';
		$report .= '<body><h2>' . esc_html('All-In-One Security diagnostics report') . '</h2>';

		$site_name = esc_html(get_bloginfo('name'));
		$report .= '<p>' . 'Site name' . ': ' . $site_name . "</p>";

		$site_url = esc_url(get_bloginfo('url'));
		$report .= '<p>' . 'Site URL' . ': ' . '<a href="' . esc_url($site_url) . '">' . $site_url . '</a></p>';

		$current_datetime = date_i18n(get_option('date_format') . ' ' . get_option('time_format'));
		$report .= '<p>' . 'Date and time' . ': ' . $current_datetime . "</p>";

		$report .= $sections;

		$report .= self::get_debug_log(true);

		$report .= '<br><br><p>' . esc_html('This report was generated by the All-In-One Security plugin.') . '</p></body></html>';
		$subject = esc_html('All-In-One Security - diagnostic report');

		$result = $aio_wp_security->sender_obj->send_email($email, $subject, $report);

		return $result;
	}
}
