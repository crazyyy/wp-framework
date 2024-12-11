<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Feature_Item_Manager {

	private $feature_list = array();

	public $feature_items = array();

	private $total_points = 0;

	private $total_achievable_points = 0;

	private $feature_point_1 = "5";

	private $feature_point_2 = "10";

	private $feature_point_3 = "15";

	private $feature_point_4 = "20";

	private $sec_level_basic = "1";

	private $sec_level_inter = "2";

	private $sec_level_advanced = "3";

	private $feature_active = "active";

	private $feature_inactive = "inactive";

	private $feature_partial = "partial";

	/**
	 * Constructor sets up the feature item manager
	 */
	public function __construct() {
		$this->setup_feature_list();
		$this->initialize_features();
	}

	/**
	 * This function sets up the feature list
	 *
	 * @return void
	 */
	private function setup_feature_list() {
		$feature_list = array(
			// Settings menu features
			'wp-generator-meta-tag' => array(
				'name' => __('Remove WP generator meta tag', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_remove_wp_generator_meta_info'
				)
			),
			// User Accounts menu features
			'user-accounts-change-admin-user' => array(
				'name' => __('Change admin username', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_basic,
				'options' => array(
					''
				),
				'callback' => array($this, 'check_user_accounts_change_admin_user_feature')
			),
			'user-accounts-display-name' => array(
				'name' => __('Change display name', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					''
				),
				'callback' => array($this, 'check_user_accounts_display_name_feature')
			),
			// User Login menu features
			'user-login-login-lockdown' => array(
				'name' => __('Login lockout', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_login_lockdown'
				)
			),
			'user-login-force-logout' => array(
				'name' => __('Force logout', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_forced_logout'
				)
			),
			'disable-application-password' => array(
				'name' => __('Disable application password', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_disable_application_password'
				)
			),
			'user-login-lockout-ip-whitelisting' => array(
				'name' => __('Login Lockout IP whitelisting', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_lockdown_enable_whitelisting'
				)
			),
			// User Registration menu features
			'manually-approve-registrations' => array(
				'name' => __('Registration approval', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_manual_registration_approval'
				)
			),
			'user-registration-captcha' => array(
				'name' => __('Registration CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_registration_page_captcha'
				)
			),
			'registration-honeypot' => array(
				'name' => __('Enable registration honeypot', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_registration_honeypot'
				)
			),
			'http-authentication-admin-frontend' => array(
				'name' => __('HTTP authentication for admin and frontend', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_http_authentication_admin',
					'aiowps_http_authentication_frontend',
				)
			),
			// Database Security menu features
			'db-security-db-prefix' => array(
				'name' => __('Database prefix', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					''
				),
				'callback' => array($this, 'check_db_security_db_prefix_feature')
			),
			// Filesystem Security menu features
			'filesystem-file-permissions' => array(
				'name' => __('File permissions', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					''
				),
				'callback' => array($this, 'check_filesystem_permissions_feature')
			),
			'filesystem-file-editing' => array(
				'name' => __('File editing', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_disable_file_editing'
				)
			),
			'auto-delete-wp-files' => array(
				'name' => __('WordPress files access', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_auto_delete_default_wp_files'
				)
			),
			// Blacklist Manager menu features
			'blacklist-manager-ip-user-agent-blacklisting' => array(
				'name' => __('IP and user agent blacklisting', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_enable_blacklisting'
				)
			),
			// Firewall menu features
			'firewall-basic-rules' => array(
				'name' => __('Enable basic firewall', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_basic_firewall'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess')
			),
			'firewall-pingback-rules' => array(
				'name' => __('Enable pingback vulnerability protection', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_pingback_firewall'
				)
			),
			'firewall-block-debug-file-access' => array(
				'name' => __('Block access to debug log file', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_block_debug_log_file_access'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess')
			),
			'firewall-disable-index-views' => array(
				'name' => __('Disable index views', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_disable_index_views'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess')
			),
			'firewall-disable-trace-track' => array(
				'name' => __('Disable trace and track', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_disable_trace_and_track'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'allow_to_write_to_htaccess')
			),
			'firewall-forbid-proxy-comments' => array(
				'name' => __('Forbid proxy comments', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_forbid_proxy_comments'
				)
			),
			'firewall-deny-bad-queries' => array(
				'name' => __('Deny bad queries', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_deny_bad_query_strings'
				)
			),
			'firewall-advanced-character-string-filter' => array(
				'name' => __('Advanced character string filter', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_advanced_char_string_filter'
				)
			),
			'firewall-enable-6g' => array(
				'name' => __('6G firewall', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_enable_6g_firewall',
				)
			),
			'firewall-block-fake-googlebots' => array(
				'name' => __('Block fake Googlebots', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_block_fake_googlebots'
				)
			),
			'prevent-hotlinking' => array(
				'name' => __('Prevent image hotlinking', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_prevent_hotlinking'
				)
			),
			'firewall-enable-404-blocking' => array(
				'name' => __('Enable IP blocking for 404 detection', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_404_IP_lockout'
				)
			),
			'firewall-disable-rss-and-atom' => array(
				'name' => __('Disable RSS and ATOM feeds', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_disable_rss_and_atom_feeds'
				)
			),
			// Brute Force menu features
			'bf-rename-login-page' => array(
				'name' => __('Enable rename login page', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_rename_login_page'
				)
			),
			'firewall-enable-brute-force-attack-prevention' => array(
				'name' => __('Enable brute force attack prevention', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_enable_brute_force_attack_prevention'
				)
			),
			'user-login-captcha' => array(
				'name' => __('Login CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_login_captcha'
				)
			),
			'lost-password-captcha' => array(
				'name' => __('Lost password CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_lost_password_captcha'
				)
			),
			'custom-login-captcha' => array(
				'name' => __('Custom login CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_custom_login_captcha'
				)
			),
			'password_protected-captcha' => array(
				'name' => __('Password-protected CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_password_protected_captcha'
				)
			),
			'whitelist-manager-ip-login-whitelisting' => array(
				'name' => __('Login IP whitelisting', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_whitelisting'
				)
			),
			'login-honeypot' => array(
				'name' => __('Enable login honeypot', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_login_honeypot'
				)
			),
			// Spam Prevention menu features
			'comment-form-captcha' => array(
				'name' => __('Comment CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_comment_captcha'
				)
			),
			'detect-spambots' => array(
				'name' => __('Detect spambots', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_spambot_detecting'
				)
			),
			'auto-block-spam-ips' => array(
				'name' => __('Auto block spam ips', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_autoblock_spam_ip'
				)
			),
			// Scanner menu features
			'scan-file-change-detection' => array(
				'name' => __('File change detection', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_4,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_enable_automated_fcd_scan'
				)
			),
			// Miscellaneous menu features
			'enable-copy-protection' => array(
				'name' => __('Enable Copy Protection', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_copy_protection'
				)
			),
			'enable-frame-protection' => array(
				'name' => __('Enable iFrame protection', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_prevent_site_display_inside_frame'
				)
			),
			'disable-users-enumeration' => array(
				'name' => __('Disable users enumeration', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_prevent_users_enumeration'
				)
			),
			'disallow-unauthorised-requests' => array(
				'name' => __('Disallow unauthorized REST requests', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_disallow_unauthorized_rest_requests'
				)
			),
			'enable-salt-postfix' => array(
				'name' => __('Enable salt postfix', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_3,
				'level' => $this->sec_level_advanced,
				'options' => array(
					'aiowps_enable_salt_postfix'
				)
			),
			// conditional features
			'bp-register-captcha' => array(
				'name' => __('BuddyPress registration CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_bp_register_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_buddypress_plugin_active'),
			),
			'bbp-new-topic-captcha' => array(
				'name' => __('bbPress new topic CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_bbp_new_topic_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_bbpress_plugin_active'),
			),
			'woo-login-captcha' => array(
				'name' => __('Woo login CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_woo_login_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_woocommerce_plugin_active'),
			),
			'woo-lostpassword-captcha' => array(
				'name' => __('Woo lost password CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_woo_lostpassword_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_woocommerce_plugin_active'),
			),
			'woo-register-captcha' => array(
				'name' => __('Woo register CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_woo_register_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_woocommerce_plugin_active'),
			),
			'woo-checkout-captcha' => array(
				'name' => __('Woo Checkout CAPTCHA', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_woo_checkout_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_woocommerce_plugin_active'),
			),
			// Ban POST requests with blank user-agent and referer
			'firewall-ban-post-blank-headers' => array(
				'name' => __('Ban POST requests that have blank user-agent and referer headers', 'all-in-one-wp-security-and-firewall'),
				'points' => $this->feature_point_2,
				'level' => $this->sec_level_inter,
				'options' => array(
					'aiowps_ban_post_blank_headers'
				)
			),
			'contact-form-7-captcha' => array(
				'name' => sprintf(__('%s CAPTCHA', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'),
				'points' => $this->feature_point_1,
				'level' => $this->sec_level_basic,
				'options' => array(
					'aiowps_enable_contact_form_7_captcha'
				),
				'feature_condition_callback' => array('AIOWPSecurity_Utility', 'is_contact_form_7_plugin_active'),
			)
		);

		$feature_list = apply_filters('aiowpsecurity_feature_list', $feature_list);
		$this->feature_list = array_filter($feature_list, array($this, 'should_add_item'));
	}

	/**
	 * This function will create a feature item object for each feature in the feature list
	 *
	 * @return void
	 */
	private function initialize_features() {
		foreach ($this->feature_list as $id => $data) {
			$callback = isset($data['callback']) ? $data['callback'] : array($this, 'is_feature_enabled');
			$this->feature_items[$id] = new AIOWPSecurity_Feature_Item($id, $data['name'], $data['points'], $data['level'], $data['options'], $callback);
		}
	}

	/**
	 * This function will return the feature item for the passed in ID
	 *
	 * @param string $feature_id - the id of the feature item we want to return
	 *
	 * @return boolean|AIOWPSecurity_Feature_Item - returns a feature item or false on coding error
	 */
	public function get_feature_item_by_id($feature_id) {
		if (isset($this->feature_items[$feature_id])) return $this->feature_items[$feature_id];
		error_log("Feature ID not found (coding error)");
		return false;
	}

	/**
	 * Call the callback function associated with the feature item.
	 *
	 * @param mixed $feature_item The feature item object.
	 */
	private function call_feature_callback($feature_item) {
		call_user_func($feature_item->callback, $feature_item);
	}

	/**
	 * This function will output the feature details badge HTML
	 *
	 * @param string $feature_id             - the id of the feature we want to get the badge for
	 * @param bool   $return_instead_of_echo - whether to return the HTML or echo it
	 *
	 * @return string|void
	 */
	public function output_feature_details_badge($feature_id, $return_instead_of_echo = false) {
		// Retrieve the feature item by ID
		$feature_item = $this->get_feature_item_by_id($feature_id);

		if (!$feature_item) return;

		$this->call_feature_callback($feature_item);

		// Prepare HTML for the feature badge
		$max_security_points = $feature_item->item_points;
		$current_security_points = $feature_item->is_active() ? $max_security_points : 0;
		$security_level = $feature_item->get_security_level_string();
		$protection_level = (0 == $current_security_points) ? 'none' : 'full';
		$status_icon = (0 == $current_security_points) ? 'dashicons-unlock' : 'dashicons-lock';
	
		$badge_html = '<div class="aiowps_feature_details_badge">';
		$badge_html .= '<span class="aiowps_feature_details_badge_difficulty aiowps_feature_protection_'.$protection_level.'" title="'.__('Feature difficulty', 'all-in-one-wp-security-and-firewall').'">';
		$badge_html .= '<span class="dashicons '.$status_icon.'"></span>'.$security_level.'</span>';
		$badge_html .= '<span class="aiowps_feature_details_badge_points" title="'.__('Security points', 'all-in-one-wp-security-and-firewall').'">';
		$badge_html .= $current_security_points.'/'.$max_security_points.'</span>';
		$badge_html .= '</div>';
	
		if ($return_instead_of_echo) {
			return $badge_html;
		} else {
			echo $badge_html;
		}
	}

	/**
	 * This function will calculate the total points for the AJAX save function
	 *
	 * @return void
	 */
	public function calculate_total_feature_points() {
		$this->calculate_total_points();
	}
	
	/**
	 * This function will setup the feature status and calculate the total points
	 *
	 * @return void
	 */
	public function check_feature_status_and_recalculate_points() {
		$this->check_and_set_feature_status();
		$this->calculate_total_points();
	}

	/**
	 * This function will calculate the total points for the site
	 *
	 * @return void
	 */
	private function calculate_total_points() {
		foreach ($this->feature_items as $item) {
			if ($item->is_active()) $this->total_points = $this->total_points + intval($item->item_points);
		}
	}

	/**
	 * This function will calculate the total achievable points
	 *
	 * @return void
	 */
	private function calculate_total_achievable_points() {
		foreach ($this->feature_items as $item) {
			$this->total_achievable_points = $this->total_achievable_points + intval($item->item_points);
		}
	}

	/**
	 * This function will return the total points for the site
	 *
	 * @return int - the total points for the site
	 */
	public function get_total_site_points() {
		if (empty($this->total_points)) $this->calculate_total_points();
		return $this->total_points;
	}

	/**
	 * This function will return the total achievable points
	 *
	 * @return int - the total achievable points
	 */
	public function get_total_achievable_points() {
		if (empty($this->total_achievable_points)) $this->calculate_total_achievable_points();
		return $this->total_achievable_points;
	}

	/**
	 * This function will loop over each feature item, checking if it's enabled and setting it's feature status
	 *
	 * @return void
	 */
	private function check_and_set_feature_status() {
		foreach ($this->feature_items as $item) {
			call_user_func($item->callback, $item);
		}
	}

	/**
	 * This function will check if the feature database value is active and set the feature status
	 *
	 * @param AIOWPSecurity_Feature_Item $item - the item we want to check is active
	 *
	 * @return void
	 */
	private function is_feature_enabled($item) {
		global $aio_wp_security;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		$enabled = false;
		foreach ($item->feature_options as $option) {
			if ('1' == $aiowps_firewall_config->get_value($option) || '1' == $aio_wp_security->configs->get_value($option)) $enabled = true;
		}

		if ($enabled) {
			$item->set_feature_status($this->feature_active);
		} else {
			$item->set_feature_status($this->feature_inactive);
		}
	}

	/**
	 * This function will check if the default admin user exists and set the feature status
	 *
	 * @param AIOWPSecurity_Feature_Item $item - the item we want to check is active
	 *
	 * @return void
	 */
	private function check_user_accounts_change_admin_user_feature($item) {
		if (AIOWPSecurity_Utility::check_user_exists('admin')) {
			 $item->set_feature_status($this->feature_inactive);
		} else {
			$item->set_feature_status($this->feature_active);
		}
	}

	/**
	 * This function will check if the username and nicknames are identical and set the feature status
	 *
	 * @param AIOWPSecurity_Feature_Item $item - the item we want to check is active
	 *
	 * @return void
	 */
	private function check_user_accounts_display_name_feature($item) {
		if (AIOWPSecurity_Utility::check_identical_login_and_nick_names()) {
			 $item->set_feature_status($this->feature_inactive);
		} else {
			$item->set_feature_status($this->feature_active);
		}
	}

	/**
	 * This function will check if the default database prefix is in use and set the feature status
	 *
	 * @param AIOWPSecurity_Feature_Item $item - the item we want to check is active
	 *
	 * @return void
	 */
	private function check_db_security_db_prefix_feature($item) {
		global $wpdb;
		$site_id = get_current_blog_id();
		$default_prefix = (1 === $site_id) ? 'wp_' : "wp_{$site_id}_";
		if ($default_prefix === $wpdb->prefix) {
			 $item->set_feature_status($this->feature_inactive);
		} else {
			$item->set_feature_status($this->feature_active);
		}
	}

	/**
	 * This function will check the filesystem permissions and set the feature status
	 *
	 * @param AIOWPSecurity_Feature_Item $item - the item we want to check is active
	 *
	 * @return void
	 */
	private function check_filesystem_permissions_feature($item) {
		//TODO
		$is_secure = 1;
		$files_dirs_to_check = AIOWPSecurity_Utility_File::get_files_and_dirs_to_check();

		foreach ($files_dirs_to_check as $file_or_dir) {
			$actual_perm = AIOWPSecurity_Utility_File::get_file_permission($file_or_dir['path']);
			$is_secure = $is_secure*AIOWPSecurity_Utility_File::is_file_permission_secure($file_or_dir['permissions'], $actual_perm);
		}

		//Only if all of the files' permissions are deemed secure give this a thumbs up
		if (1 == $is_secure) {
			$item->set_feature_status($this->feature_active);
		} else {
			$item->set_feature_status($this->feature_inactive);
		}
	}

	/**
	 * This function will check if an item should be added to the feature list
	 *
	 * @param  array $item - the item we want to check if it should be added
	 * @return bool
	 */
	public static function should_add_item($item) {
		if (empty($item['feature_condition_callback'])) {
			return true;
		} elseif (is_callable($item['feature_condition_callback'])) {
			return call_user_func($item['feature_condition_callback']);
		} else {
			error_log("Callback function set but not callable (coding error). Feature: " . $item['name']);
			return false;
		}
	}
}
