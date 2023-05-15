<?php
/* 
 * Inits the admin dashboard side of things.
 * Main admin file which loads all settings panels and sets up admin menus. 
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Admin_Init {

	/**
	 * Whether the page is admin dashboard page.
	 *
	 * @var boolean
	 */
	private $is_admin_dashboard_page;

	/**
	 * Whether the page is admin AIOS page.
	 *
	 * @var boolean
	 */
	private $is_aiowps_admin_page;

	/**
	 * An array of submenu items
	 *
	 * @var array
	 */
	private $menu_items = array();

	/**
	 * Used in the premium plugin to add submenus
	 *
	 * @var string
	 */
	public $main_menu_page;

	/**
	 * Includes admin dependencies and hook admin actions.
	 *
	 * @return void
	 */
	public function __construct() {
		// This class is only initialized if is_admin() is true
		
		if (AIOWPSecurity_Utility_Permissions::has_manage_cap()) {
			$this->admin_includes();
			$this->setup_menu_items();
			add_action('admin_menu', array($this, 'create_admin_menus'));
			add_action('admin_menu', array($this, 'premium_upgrade_submenu'), 40);
			add_action('admin_init', array($this, 'aiowps_csv_download'));
		}

		add_action('admin_init', array($this, 'hook_admin_notices'));

		// Make sure we are on our plugin's menu pages
		if ($this->is_aiowps_admin_page()) {
			add_action('admin_print_scripts', array($this, 'admin_menu_page_scripts'));
			add_action('admin_print_styles', array($this, 'admin_menu_page_styles'));
			add_action('init', array($this, 'init_hook_handler_for_admin_side'));

			if (class_exists('AIOWPS_PREMIUM')) {
				add_filter('admin_footer_text', array($this, 'display_footer_review_message'));
			}
		}
	}

	/**
	 * Sets up the menu items array which is used to build admin menus
	 *
	 * @return void
	 */
	private function setup_menu_items() {
		$menu_items = array(
			array(
				'page_title' => __('Dashboard', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Dashboard', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_MAIN_MENU_SLUG,
				'render_callback' => array($this, 'handle_dashboard_menu_rendering'),
				'icon' => 'dashboard',
				'order' => 20,
			),
			array(
				'page_title' => __('Settings', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Settings', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_SETTINGS_MENU_SLUG,
				'render_callback' => array($this, 'handle_settings_menu_rendering'),
				'icon' => 'settings',
				'order' => 30,
			),
			array(
				'page_title' => __('User Accounts', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('User Accounts', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_USER_ACCOUNTS_MENU_SLUG,
				'render_callback' => array($this, 'handle_user_accounts_menu_rendering'),
				'icon' => 'user_accounts',
				'order' => 40,
			),
			array(
				'page_title' => __('User Login', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('User Login', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_USER_LOGIN_MENU_SLUG,
				'render_callback' => array($this, 'handle_user_login_menu_rendering'),
				'icon' => 'user_login',
				'order' => 50,
			),
			array(
				'page_title' => __('User Registration', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('User Registration', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_USER_REGISTRATION_MENU_SLUG,
				'render_callback' => array($this, 'handle_user_registration_menu_rendering'),
				'icon' => 'user_registration',
				'order' => 60,
			),
			array(
				'page_title' => __('Database Security', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Database Security', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_DB_SEC_MENU_SLUG,
				'render_callback' => array($this, 'handle_database_menu_rendering'),
				'icon' => 'database_security',
				'order' => 70,
			),
			array(
				'page_title' => __('Filesystem Security', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Filesystem Security', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_FILESYSTEM_MENU_SLUG,
				'render_callback' => array($this, 'handle_filesystem_menu_rendering'),
				'icon' => 'filesystem_security',
				'display_condition_callback' => 'is_main_site',
				'order' => 80,
			),
			array(
				'page_title' => __('Blacklist Manager', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Blacklist Manager', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_BLACKLIST_MENU_SLUG,
				'render_callback' => array($this, 'handle_blacklist_menu_rendering'),
				'icon' => 'blacklist_manager',
				'display_condition_callback' => 'is_main_site',
				'order' => 90,
			),
			array(
				'page_title' => __('Firewall', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Firewall', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_FIREWALL_MENU_SLUG,
				'render_callback' => array($this, 'handle_firewall_menu_rendering'),
				'icon' => 'firewall',
				'display_condition_callback' => 'is_main_site',
				'order' => 100,
			),
			array(
				'page_title' => __('Brute Force', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Brute Force', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG,
				'render_callback' => array($this, 'handle_brute_force_menu_rendering'),
				'icon' => 'brute_force',
				'order' => 110,
			),
			array(
				'page_title' => __('Spam Prevention', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Spam Prevention', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_SPAM_MENU_SLUG,
				'render_callback' => array($this, 'handle_spam_menu_rendering'),
				'icon' => 'spam_prevention',
				'order' => 120,
			),
			array(
				'page_title' => __('Scanner', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Scanner', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_FILESCAN_MENU_SLUG,
				'render_callback' => array($this, 'handle_filescan_menu_rendering'),
				'icon' => 'scanner',
				'display_condition_callback' => 'is_main_site',
				'order' => 130,
			),
			array(
				'page_title' => __('Maintenance', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Maintenance', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_MAINTENANCE_MENU_SLUG,
				'render_callback' => array($this, 'handle_maintenance_menu_rendering'),
				'icon' => 'maintenance',
				'order' => 140,
			),
			array(
				'page_title' => __('Miscellaneous', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Miscellaneous', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_MISC_MENU_SLUG,
				'render_callback' => array($this, 'handle_misc_menu_rendering'),
				'icon' => 'miscellaneous',
				'order' => 140,
			),
			array(
				'page_title' => __('Tools', 'all-in-one-wp-security-and-firewall'),
				'menu_title' => __('Tools', 'all-in-one-wp-security-and-firewall'),
				'menu_slug' => AIOWPSEC_TOOLS_MENU_SLUG,
				'render_callback' => array($this, 'handle_tools_menu_rendering'),
				'icon' => 'tools',
				'order' => 150,
			),
		);
		$menu_items = apply_filters('aiowpsecurity_menu_items', $menu_items);
		$this->menu_items = array_filter($menu_items, 'AIOWPSecurity_Utility::should_display_item');
	}

	/**
	 * Function to get the menu items array
	 *
	 * @return void
	 */
	public function get_menu_items() {
		return $this->menu_items;
	}

	/**
	 * This function creates and outputs the csv file for download
	 *
	 * @param array  $items       - the content
	 * @param array  $export_keys - the keys for the content
	 * @param string $filename    - the filename
	 *
	 * @return void
	 */
	private function aiowps_output_csv($items, $export_keys, $filename='data.csv') {
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$filename);
		header("Pragma: no-cache");
		header("Expires: 0");
		$output = fopen('php://output', 'w'); //open output stream

		fputcsv($output, $export_keys); //let's put column names first

		foreach ($items as $item) {
			unset($csv_line);
			foreach ($export_keys as $key => $value) {
				if (isset($item[$key])) {
					$csv_line[] = $item[$key];
				}
			}
			fputcsv($output, $csv_line);
		}
	}

	/**
	 * This function will get the content that we want to export as CSV and send it to the download function
	 *
	 * @return void
	 */
	public function aiowps_csv_download() {
		global $aio_wp_security;
		if (isset($_POST['aiowpsec_export_acct_activity_logs_to_csv'])) { //Export account activity logs
			$nonce = $_REQUEST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-export-acct-activity-logs-to-csv-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}
			include_once 'wp-security-list-acct-activity.php';
			$acct_activity_list = new AIOWPSecurity_List_Account_Activity();
			$acct_activity_list->prepare_items(true);
			//Let's build a list of items we want to export and give them readable names
			$export_keys = array(
				'user_id' => 'User ID',
				'user_login' => 'Username',
				'login_date' => 'Login Date',
				'logout_date' => 'Logout Date',
				'login_ip' => 'IP'
			);
			$this->aiowps_output_csv($acct_activity_list->items, $export_keys, 'account_activity_logs.csv');
			exit();
		}
		if (isset($_POST['aiowps_export_audit_event_logs_to_csv'])) {
			$nonce = $_REQUEST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'bulk-items');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}
			include_once 'wp-security-list-audit.php';
			$audit_log_list = new AIOWPSecurity_List_Audit_Log();
			$audit_log_list->prepare_items(true);
			$export_keys = array(
				'id' => 'ID',
				'created' => __('Date and time', 'all-in-one-wp-security-and-firewall'),
				'level' => __('Level', 'all-in-one-wp-security-and-firewall'),
				'network_id' => __('Network ID', 'all-in-one-wp-security-and-firewall'),
				'site_id' => __('Site ID', 'all-in-one-wp-security-and-firewall'),
				'username' => __('Username', 'all-in-one-wp-security-and-firewall'),
				'ip' => __('IP', 'all-in-one-wp-security-and-firewall'),
				'event_type' => __('Event', 'all-in-one-wp-security-and-firewall'),
				'details' => __('Details', 'all-in-one-wp-security-and-firewall'),
				'stacktrace' => __('Stack trace', 'all-in-one-wp-security-and-firewall')
			);
			$this->aiowps_output_csv($audit_log_list->items, $export_keys, 'audit_event_logs.csv');
			exit();
		}
		if (isset($_POST['aiowps_export_404_event_logs_to_csv'])) {//Export 404 event logs
			$nonce = $_REQUEST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-export-404-event-logs-to-csv-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}
			include_once 'wp-security-list-404.php'; //For rendering the AIOWPSecurity_List_Table in tab1
			$event_list_404 = new AIOWPSecurity_List_404(); //For rendering the AIOWPSecurity_List_Table in tab1
			$event_list_404->prepare_items(true);
			$export_keys = array(
				'id' => 'Id',
				'event_type' => 'Event Type',
				'ip_or_host' => 'IP Address',
				'url' => 'Attempted URL',
				'referer_info' => 'Referer',
				'event_date' => 'Date',
				'status' => 'Lock Status',
			);
			$this->aiowps_output_csv($event_list_404->items, $export_keys, '404_event_logs.csv');
			exit();
		}
	}

	/**
	 * Check whether current admin page is All In One WP Security admin page or not.
	 *
	 * @return boolean True if All In One WP Security admin page, Otherwise false.
	 */
	private function is_aiowps_admin_page() {
		if (isset($this->is_aiowps_admin_page)) {
			return $this->is_aiowps_admin_page;
		}
		global $pagenow;
		$this->is_aiowps_admin_page = (AIOWPSecurity_Utility_Permissions::has_manage_cap() && 'admin.php' == $pagenow && isset($_GET['page']) && false !== strpos($_GET['page'], AIOWPSEC_MENU_SLUG_PREFIX));
		return $this->is_aiowps_admin_page;
	}

	/**
	 * Hook admin notices on admin dashboard page and admin AIOS pages.
	 *
	 * @return void
	 */
	public function hook_admin_notices() {
		if (!current_user_can('update_plugins')) {
			return;
		}

		// If none of the admin dashboard page or the AIOS page, Then bail
		if (!$this->is_admin_dashboard_page() && !$this->is_aiowps_admin_page()) {
			return;
		}

		add_action('all_admin_notices', array($this, 'render_admin_notices'));
	}

	/**
	 * Check whether current admin page is Admin Dashboard page or not.
	 *
	 * @return boolean True if Admin Dashboard page, Otherwise false.
	 */
	private function is_admin_dashboard_page() {
		if (isset($this->is_admin_dashboard_page)) {
			return $this->is_admin_dashboard_page;
		}
		global $pagenow;
		$this->is_admin_dashboard_page = 'index.php' == $pagenow;
		return $this->is_admin_dashboard_page;
	}

	/**
	 * Render admin notices.
	 *
	 * @return void
	 */
	public function render_admin_notices() {
		global $aio_wp_security;

		$custom_notice_ids = array_merge(AIOS_Abstracted_Ids::custom_admin_notice_ids(), AIOS_Abstracted_Ids::htaccess_to_php_feature_notice_ids());
		foreach ($custom_notice_ids as $custom_admin_notice_id) {
			$aio_wp_security->notices->do_notice($custom_admin_notice_id, $custom_admin_notice_id);
		}

		// Bail if the premium plugin is active and does not show ads.
		if (AIOWPSecurity_Utility_Permissions::is_premium_installed()) return;

		$installed_at = $aio_wp_security->notices->get_aiowps_plugin_installed_timestamp();
		$time_now = $aio_wp_security->notices->get_time_now();
		$installed_for = $time_now - $installed_at;

		$dismissed_dash_notice_until = (int) $aio_wp_security->configs->get_value('dismissdashnotice');

		if ($this->is_admin_dashboard_page() && ($installed_at && $time_now > $dismissed_dash_notice_until && $installed_for > (14 * 86400)) || (defined('AIOWPSECURITY_FORCE_DASHNOTICE') && AIOWPSECURITY_FORCE_DASHNOTICE)) {
			$aio_wp_security->include_template('notices/thanks-for-using-main-dash.php');
		} elseif ($this->is_aiowps_admin_page() && $installed_at && $installed_for > 14*86400) {
			$aio_wp_security->notices->do_notice(false, 'top');
		}
	}

	/**
	 * This function will include any files needed for the admin dashboard
	 *
	 * @return void
	 */
	private function admin_includes() {
		include_once('wp-security-admin-menu.php');
	}

	/**
	 * Enqueue admin JavaScripts.
	 *
	 * @return Void
	 */
	public function admin_menu_page_scripts() {
		if (!AIOWPSecurity_Utility_Permissions::has_manage_cap()) {
			return;
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('postbox');
		wp_enqueue_script('dashboard');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_register_script('aiowpsec-admin-js', AIO_WP_SECURITY_URL. '/js/wp-security-admin-script.js', array('jquery'), AIO_WP_SECURITY_VERSION, true);
		wp_enqueue_script('aiowpsec-admin-js');
		wp_localize_script('aiowpsec-admin-js', 'aios_data',
			array(
				'ajax_nonce' => wp_create_nonce('aios-ajax-nonce'),
			)
		);
		wp_localize_script('aiowpsec-admin-js', 'aios_trans',
			array(
				'unexpected_response' => __('Unexpected response:', 'all-in-one-wp-security-and-firewall'),
				'copied' => __('Copied', 'all-in-one-wp-security-and-firewall'),
				'no_import_file' => __('You have not yet selected a file to import.', 'all-in-one-wp-security-and-firewall')
			)
		);
		wp_register_script('aiowpsec-pw-tool-js', AIO_WP_SECURITY_URL. '/js/password-strength-tool.js', array('jquery')); // We will enqueue this in the user acct menu class
	}
	
	/**
	 * Enqueue admin styles.
	 *
	 * @return Void
	 */
	public function admin_menu_page_styles() {
		wp_enqueue_style('dashboard');
		wp_enqueue_style('thickbox');
		wp_enqueue_style('global');
		wp_enqueue_style('wp-admin');
		$admin_css_version = (defined('WP_DEBUG') && WP_DEBUG) ? time() : filemtime(AIO_WP_SECURITY_PATH. '/css/wp-security-admin-styles.css');
		wp_enqueue_style('aiowpsec-admin-css', AIO_WP_SECURITY_URL. '/css/wp-security-admin-styles.css', array(), $admin_css_version);
	}
	
	/**
	 * Sets up various class and tasks needed for the admin dashboard
	 *
	 * @return void
	 */
	public function init_hook_handler_for_admin_side() {
		$this->initialize_feature_manager();
		$this->do_other_admin_side_init_tasks();
	}

	/**
	 * Show footer review message and link.
	 *
	 * @return string
	 */
	public function display_footer_review_message() {
		/* translators: 1: All In One WP Security & Firewall 2: G2 review link */
		$message = sprintf(
			__('Enjoyed %1$s? Please leave us a %2$s rating. We really appreciate your support!', 'all-in-one-wp-security-and-firewall'),
			'<b>' . htmlspecialchars('All In One WP Security & Firewall') . '</b>',
			'<a href="https://www.g2.com/products/all-in-one-wp-security-firewall/reviews" target="_blank">&starf;&starf;&starf;&starf;&starf;</a>'
		);
		return $message;
	}

	/**
	 * This function sets up our feature item manager class and adds it to GLOBALS
	 *
	 * @return void
	 */
	private function initialize_feature_manager() {
		$aiowps_feature_mgr  = new AIOWPSecurity_Feature_Item_Manager();
		$aiowps_feature_mgr->initialize_features();
		$aiowps_feature_mgr->check_and_set_feature_status();
		$aiowps_feature_mgr->calculate_total_points();
		$GLOBALS['aiowps_feature_mgr'] = $aiowps_feature_mgr;
	}

	/**
	 * Other admin side init tasks.
	 *
	 * @return Void
	 */
	private function do_other_admin_side_init_tasks() {
		global $aio_wp_security, $aiowps_firewall_config, $simba_two_factor_authentication;

		//***New Feature improvement for Cookie Based Brute Force Protection***//
		// The old "test cookie" used to be too easy to guess because someone could just read the code and get the value.
		//So now we will drop a more secure test cookie using a 10 digit random string

		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention')) {
			// This code is for users who had this feature saved using an older release. This will drop the new more secure test cookie to the browser
			$test_cookie_name_saved = $aio_wp_security->configs->get_value('aiowps_cookie_brute_test');
			if (empty($test_cookie_name_saved)) {
				$random_suffix = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(10);
				$test_cookie_name = 'aiowps_cookie_test_'.$random_suffix;
				$aio_wp_security->configs->set_value('aiowps_cookie_brute_test', $test_cookie_name, true);
				AIOWPSecurity_Utility::set_cookie_value($test_cookie_name, '1');
			}
		}
		// For cookie test form submission case
		if (isset($_GET['page']) && AIOWPSEC_BRUTE_FORCE_MENU_SLUG == $_GET['page'] && isset($_GET['tab']) && 'cookie-based-brute-force-prevention' == $_GET['tab']) {
			if (isset($_POST['aiowps_do_cookie_test_for_bfla'])) {
				$random_suffix = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(10);
				$test_cookie_name = 'aiowps_cookie_test_'.$random_suffix;
				$aio_wp_security->configs->set_value('aiowps_cookie_brute_test', $test_cookie_name, true);
				AIOWPSecurity_Utility::set_cookie_value($test_cookie_name, '1');
				$cur_url = "admin.php?page=".AIOWPSEC_BRUTE_FORCE_MENU_SLUG."&tab=cookie-based-brute-force-prevention";
				$redirect_url = AIOWPSecurity_Utility::add_query_data_to_url($cur_url, 'aiowps_cookie_test', "1");
				AIOWPSecurity_Utility::redirect_to_url($redirect_url);
			}

			if (isset($_POST['aiowps_enable_brute_force_attack_prevention'])) { // Enabling the BFLA feature so drop the cookie again
				$brute_force_feature_secret_word = sanitize_text_field($_POST['aiowps_brute_force_secret_word']);
				if(empty($brute_force_feature_secret_word)){
					$brute_force_feature_secret_word = AIOS_DEFAULT_BRUTE_FORCE_FEATURE_SECRET_WORD;
				}
				AIOWPSecurity_Utility::set_cookie_value(AIOWPSecurity_Utility::get_brute_force_secret_cookie_name(), wp_hash($brute_force_feature_secret_word));
			}

			if (isset($_REQUEST['aiowps_cookie_test'])) {
				$test_cookie = $aio_wp_security->configs->get_value('aiowps_cookie_brute_test');
				$cookie_val = AIOWPSecurity_Utility::get_cookie_value($test_cookie);
				if (empty($cookie_val)) {
					$aio_wp_security->configs->set_value('aiowps_cookie_test_success','');
				} else {
					$aio_wp_security->configs->set_value('aiowps_cookie_test_success','1');
				}
				$aio_wp_security->configs->save_config();//save the value
			}
		}

		if (isset($_POST['aiowps_save_wp_config'])) { // the wp-config backup operation
			$nonce = $_REQUEST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-save-wp-config-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}
			$wp_config_path = AIOWPSecurity_Utility_File::get_wp_config_file_path();
			$result = AIOWPSecurity_Utility_File::backup_and_rename_wp_config($wp_config_path); //Backup the wp_config.php file
			AIOWPSecurity_Utility_File::download_a_file_option1($wp_config_path, "wp-config-backup.txt");
		}

		// Handle export settings
		if (isset($_POST['aiowps_export_settings'])) { // Do form submission tasks
			$nonce = $_REQUEST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-export-settings-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}

			$config_data = array();
			$config_data['general'] = get_option('aio_wp_security_configs');

			if (is_main_site() && is_super_admin()) {
				$config_data['firewall'] = $aiowps_firewall_config->get_contents();

				if (!empty($simba_two_factor_authentication->is_tfa_integrated)) {
					$config_data['tfa'] = $simba_two_factor_authentication->get_configs();
				}
			}

			$output = json_encode($config_data);
			AIOWPSecurity_Utility_File::download_content_to_a_file($output);
		}
	}

	/**
	 * Adds admin menu page and all submenus to the WordPress dashboard
	 *
	 * @return void
	 */
	public function create_admin_menus() {
		$menu_icon_url = AIO_WP_SECURITY_URL.'/images/plugin-icon.png';
		$this->main_menu_page = add_menu_page(__('WP Security', 'all-in-one-wp-security-and-firewall'), __('WP Security', 'all-in-one-wp-security-and-firewall'), apply_filters('aios_management_permission', 'manage_options'), AIOWPSEC_MAIN_MENU_SLUG , array($this, 'handle_dashboard_menu_rendering'), $menu_icon_url);

		foreach ($this->menu_items as $menu_item) {
			add_submenu_page(AIOWPSEC_MAIN_MENU_SLUG, $menu_item['page_title'],  $menu_item['menu_title'] , apply_filters('aios_management_permission', 'manage_options'), $menu_item['menu_slug'], $menu_item['render_callback'], $menu_item['order']);
		}

		do_action('aiowpsecurity_admin_menu_created');
	}

	/**
	 * Adds submenu link for premium upgrade tab.
	 *
	 * @return Void
	 */
	public function premium_upgrade_submenu() {
		if (!AIOWPSecurity_Utility_Permissions::is_premium_installed()) {
			global $submenu;
			$submenu[AIOWPSEC_MAIN_MENU_SLUG][] = array(__('Premium Upgrade', 'all-in-one-wp-security-and-firewall'), apply_filters('aios_management_permission', 'manage_options'), 'admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=premium-upgrade');
		}
	}

	/**
	 * Renders 'Dashboard' submenu page.
	 *
	 * @return Void
	 */
	public function handle_dashboard_menu_rendering() {
		include_once('wp-security-dashboard-menu.php');
		new AIOWPSecurity_Dashboard_Menu();
	}

	/**
	 * Renders 'Settings' submenu page.
	 *
	 * @return Void
	 */
	public function handle_settings_menu_rendering() {
		include_once('wp-security-settings-menu.php');
		new AIOWPSecurity_Settings_Menu();
		
	}
	
	/**
	 * Renders 'User Accounts' submenu page.
	 *
	 * @return Void
	 */
	public function handle_user_accounts_menu_rendering() {
		include_once('wp-security-user-accounts-menu.php');
		new AIOWPSecurity_User_Accounts_Menu();
	}
	
	/**
	 * Renders 'User Login' submenu page.
	 *
	 * @return Void
	 */
	public function handle_user_login_menu_rendering() {
		include_once('wp-security-user-login-menu.php');
		new AIOWPSecurity_User_Login_Menu();
	}
	
	/**
	 * Renders 'User Registration' submenu page.
	 *
	 * @return Void
	 */
	public function handle_user_registration_menu_rendering() {
		include_once('wp-security-user-registration-menu.php');
		new AIOWPSecurity_User_Registration_Menu();
	}

	/**
	 * Renders 'Database Security' submenu page.
	 *
	 * @return Void
	 */
	public function handle_database_menu_rendering() {
		include_once('wp-security-database-menu.php');
		new AIOWPSecurity_Database_Menu();
	}

	/**
	 * Renders 'Filesystem Security' submenu page.
	 *
	 * @return Void
	 */
	public function handle_filesystem_menu_rendering() {
		include_once('wp-security-filesystem-menu.php');
		new AIOWPSecurity_Filesystem_Menu();
	}

	/**
	 * Renders 'Blacklist Manager' submenu page.
	 *
	 * @return Void
	 */
	public function handle_blacklist_menu_rendering() {
		include_once('wp-security-blacklist-menu.php');
		new AIOWPSecurity_Blacklist_Menu();
	}

	/**
	 * Renders 'Firewall' submenu page.
	 *
	 * @return Void
	 */
	public function handle_firewall_menu_rendering() {
		include_once('wp-security-firewall-menu.php');
		new AIOWPSecurity_Firewall_Menu();
	}
	
	/**
	 * Renders 'Brute Force' submenu page.
	 *
	 * @return Void
	 */
	public function handle_brute_force_menu_rendering() {
		include_once('wp-security-brute-force-menu.php');
		new AIOWPSecurity_Brute_Force_Menu();
	}

	/**
	 * Renders 'Maintenance' submenu page.
	 *
	 * @return Void
	 */
	public function handle_maintenance_menu_rendering() {
		include_once('wp-security-maintenance-menu.php');
		new AIOWPSecurity_Maintenance_Menu();
	}
	
	/**
	 * Renders 'Spam Prevention' submenu page.
	 *
	 * @return Void
	 */
	public function handle_spam_menu_rendering() {
		include_once('wp-security-spam-menu.php');
		new AIOWPSecurity_Spam_Menu();
	}
	
	/**
	 * Renders 'Scanner' submenu page.
	 *
	 * @return Void
	 */
	public function handle_filescan_menu_rendering() {
		include_once('wp-security-filescan-menu.php');
		new AIOWPSecurity_Filescan_Menu();
	}
	
	/**
	 * Renders 'Miscellaneous' submenu page.
	 *
	 * @return Void
	 */
	public function handle_misc_menu_rendering() {
		include_once('wp-security-misc-options-menu.php');
		new AIOWPSecurity_Misc_Options_Menu();
	}

	/**
	 * Renders 'Tools' submenu page.
	 *
	 * @return Void
	 */
	public function handle_tools_menu_rendering() {
		include_once('wp-security-tools-menu.php');
		new AIOWPSecurity_Tools_Menu();
	}

} // End of class
