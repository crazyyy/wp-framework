<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * AIOWPSecurity_Brute_Force_Menu class for brute force prevention.
 *
 * @access public
 */
class AIOWPSecurity_Brute_Force_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Blacklist menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_BRUTE_FORCE_MENU_SLUG;

	/**
	 * Constructor adds menu for Brute force
	 */
	public function __construct() {
		parent::__construct(__('Brute force', 'all-in-one-wp-security-and-firewall'));
	}
	
	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'rename-login' => array(
				'title' => __('Rename login page', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_rename_login'),
			),
			'cookie-based-brute-force-prevention' => array(
				'title' => __('Cookie based brute force prevention', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_cookie_based_brute_force_prevention'),
				'display_condition_callback' => 'is_main_site',
			),
			'captcha-settings' => array(
				'title' => __('CAPTCHA settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_captcha_settings'),
			),
			'login-whitelist' => array(
				'title' => __('Login whitelist', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_login_whitelist'),
			),
			'404-detection' => array(
				'title' => __('404 detection', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_404_detection'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'honeypot' => array(
				'title' => __('Honeypot', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_honeypot'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}
	
	/**
	 * Rename login page tab.
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 */
	protected function render_rename_login() {
		global $aio_wp_security, $aiowps_feature_mgr;
		$aiowps_login_page_slug = '';

		if (get_option('permalink_structure')) {
			$home_url = trailingslashit(home_url());
		} else {
			$home_url = trailingslashit(home_url()) . '?';
		}

		if (isset($_POST['aiowps_save_rename_login_page_settings'])) { // Do form submission tasks
			$error = '';
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-rename-login-page-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for rename login page save.", 4);
				die("Nonce check failed for rename login page save.");
			}

			if (empty($_POST['aiowps_login_page_slug']) && isset($_POST["aiowps_enable_rename_login_page"])) {
				$error .= '<br />' . __('Please enter a value for your login page slug.', 'all-in-one-wp-security-and-firewall');
			} elseif (!empty($_POST['aiowps_login_page_slug'])) {
				$aiowps_login_page_slug = sanitize_text_field($_POST['aiowps_login_page_slug']);
				if ('wp-admin' == $aiowps_login_page_slug) {
					$error .= '<br />' . __('You cannot use the value "wp-admin" for your login page slug.', 'all-in-one-wp-security-and-firewall');
				} elseif (preg_match('/[^a-z_\-0-9]/i', $aiowps_login_page_slug)) {
					$error .= '<br />' . __('You must use alpha numeric characters for your login page slug.', 'all-in-one-wp-security-and-firewall');
				}
			}

			if ($error) {
				$this->show_msg_error(__('Attention:', 'all-in-one-wp-security-and-firewall') . ' ' . $error);
			} else {
				$htaccess_res = '';
				// Save all the form values to the options
				if (isset($_POST["aiowps_enable_rename_login_page"])) {
					$aio_wp_security->configs->set_value('aiowps_enable_rename_login_page', '1');
				} else {
					$aio_wp_security->configs->set_value('aiowps_enable_rename_login_page', '');
				}
				$aio_wp_security->configs->set_value('aiowps_login_page_slug', $aiowps_login_page_slug);
				$aio_wp_security->configs->save_config();


				// Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
				if (false === $htaccess_res) {
					$this->show_msg_error(__('Could not delete the cookie-based directives from the .htaccess file, please check the file permissions.', 'all-in-one-wp-security-and-firewall'));
				} else {
					$this->show_msg_settings_updated();
				}

				/**
				 * The following is a fix/workaround for the following issue:
				 * https://wordpress.org/support/topic/applying-brute-force-rename-login-page-not-working/
				 * ie, when saving the rename login config, the logout link does not update on the first page load after the $_POST submit to reflect the new rename login setting.
				 * Added a page refresh to fix this for now until I figure out a better solution.
				 */
				$cur_url = "admin.php?page=".AIOWPSEC_BRUTE_FORCE_MENU_SLUG."&tab=rename-login";
				AIOWPSecurity_Utility::redirect_to_url($cur_url);

			}
		}

		$aio_wp_security->include_template('wp-admin/brute-force/rename-login.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'home_url' => $home_url));
	}

	/**
	 * Cookie based brute force prevention tab.
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 *
	 * @return void
	 */
	protected function render_cookie_based_brute_force_prevention() {
		global $aio_wp_security;
		global $aiowps_feature_mgr;
		$error = false;
		$msg = '';

		// Save settings for brute force cookie method
		if (isset($_POST['aiowps_apply_cookie_based_bruteforce_firewall'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-enable-cookie-based-brute-force-prevention')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed on enable cookie based brute force prevention feature.', 4);
				die('Nonce check failed on enable cookie based brute force prevention feature.');
			}

			if (isset($_POST['aiowps_enable_brute_force_attack_prevention'])) {
				$brute_force_feature_secret_word = sanitize_text_field($_POST['aiowps_brute_force_secret_word']);
				if (empty($brute_force_feature_secret_word)) {
					$brute_force_feature_secret_word = AIOS_DEFAULT_BRUTE_FORCE_FEATURE_SECRET_WORD;
				} elseif (!ctype_alnum($brute_force_feature_secret_word)) {
					$msg = '<p>' . __('Settings have not been saved - your secret word must consist only of alphanumeric characters, i.e., letters and/or numbers only.', 'all-in-one-wp-security-and-firewall') . '</p>';
					$error = true;
				}

				if (filter_var($_POST['aiowps_cookie_based_brute_force_redirect_url'], FILTER_VALIDATE_URL)) {
					$aio_wp_security->configs->set_value('aiowps_cookie_based_brute_force_redirect_url', esc_url_raw($_POST['aiowps_cookie_based_brute_force_redirect_url']));
				} else {
					$aio_wp_security->configs->set_value('aiowps_cookie_based_brute_force_redirect_url', 'http://127.0.0.1');
				}

				if (!$error) {
					$aio_wp_security->configs->set_value('aiowps_enable_brute_force_attack_prevention', '1');
					$aio_wp_security->configs->set_value('aiowps_brute_force_secret_word', $brute_force_feature_secret_word);

					$msg = '<p>' . __('You have successfully enabled the cookie based brute force prevention feature', 'all-in-one-wp-security-and-firewall') . '</p>';
					$msg .= '<p>' . __('From now on you will need to log into your WP Admin using the following URL:', 'all-in-one-wp-security-and-firewall') . '</p>';
					$msg .= '<p><strong>'.AIOWPSEC_WP_URL.'/?'.esc_html($brute_force_feature_secret_word).'=1</strong></p>';
					$msg .= '<p>' . __('It is important that you save this URL value somewhere in case you forget it, OR,', 'all-in-one-wp-security-and-firewall') . '</p>';
					$msg .= '<p>' . sprintf(__('simply remember to add a "?%s=1" to your current site URL address.', 'all-in-one-wp-security-and-firewall'), esc_html($brute_force_feature_secret_word)) . '</p>';
				}
			} else {
				$aio_wp_security->configs->set_value('aiowps_enable_brute_force_attack_prevention', '');
				$msg = __('You have successfully saved cookie based brute force prevention feature settings.', 'all-in-one-wp-security-and-firewall');
			}

			if (isset($_POST['aiowps_brute_force_attack_prevention_pw_protected_exception'])) {
				$aio_wp_security->configs->set_value('aiowps_brute_force_attack_prevention_pw_protected_exception', '1');
			} else {
				$aio_wp_security->configs->set_value('aiowps_brute_force_attack_prevention_pw_protected_exception', '');
			}

			if (isset($_POST['aiowps_brute_force_attack_prevention_ajax_exception'])) {
				$aio_wp_security->configs->set_value('aiowps_brute_force_attack_prevention_ajax_exception', '1');
			} else {
				$aio_wp_security->configs->set_value('aiowps_brute_force_attack_prevention_ajax_exception', '');
			}

			if (!$error) {
				AIOWPSecurity_Configure_Settings::set_cookie_based_bruteforce_firewall_configs();
				$aio_wp_security->configs->save_config();//save the value

				// Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
				if ('' != $msg) {
					echo '<div id="message" class="updated fade"><p>';
					echo $msg;
					echo '</p></div>';
				}
			} else {
				$this->show_msg_error($msg);
			}
		}

		$aiowps_cookie_test = isset($_POST['aiowps_cookie_test']) ? $_POST['aiowps_cookie_test'] : '';

		$aio_wp_security->include_template('wp-admin/brute-force/cookie-based-brute-force-prevention.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'aiowps_cookie_test' => $aiowps_cookie_test));
	}

	/**
	 * Login captcha tab.
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 *
	 * @return void
	 */
	protected function render_captcha_settings() {
		global $aio_wp_security, $aiowps_feature_mgr;

		$supported_captchas = $aio_wp_security->captcha_obj->get_supported_captchas();
		$captcha_themes = $aio_wp_security->captcha_obj->get_captcha_themes();

		if (isset($_POST['aiowpsec_save_captcha_settings'])) { // Do form submission tasks
			if (!wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-captcha-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed on CAPTCHA settings save.', 4);
				die('Nonce check failed on CAPTCHA settings save.');
			}

			$default_captcha = isset($_POST['aiowps_default_captcha']) ? sanitize_text_field($_POST['aiowps_default_captcha']) : '';

			$default_captcha = array_key_exists($default_captcha, $supported_captchas) ? $default_captcha : 'none';

			$aio_wp_security->configs->set_value('aiowps_default_captcha', $default_captcha);

			// Save all the form values to the options
			$random_20_digit_string = AIOWPSecurity_Utility::generate_alpha_numeric_random_string(20); // Generate random 20 char string for use during CAPTCHA encode/decode
			$aio_wp_security->configs->set_value('aiowps_captcha_secret_key', $random_20_digit_string);
			$aio_wp_security->configs->set_value('aiowps_enable_login_captcha', isset($_POST["aiowps_enable_login_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_registration_page_captcha', isset($_POST["aiowps_enable_registration_page_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_comment_captcha', isset($_POST["aiowps_enable_comment_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_bp_register_captcha', isset($_POST["aiowps_enable_bp_register_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_bbp_new_topic_captcha', isset($_POST["aiowps_enable_bbp_new_topic_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_woo_login_captcha', isset($_POST["aiowps_enable_woo_login_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_woo_register_captcha', isset($_POST["aiowps_enable_woo_register_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_woo_checkout_captcha', isset($_POST["aiowps_enable_woo_checkout_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_woo_lostpassword_captcha', isset($_POST["aiowps_enable_woo_lostpassword_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_custom_login_captcha', isset($_POST["aiowps_enable_custom_login_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_password_protected_captcha', isset($_POST["aiowps_enable_password_protected_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_lost_password_captcha', isset($_POST["aiowps_enable_lost_password_captcha"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_contact_form_7_captcha', isset($_POST["aiowps_enable_contact_form_7_captcha"]) ? '1' : '');

			$aio_wp_security->configs->set_value('aiowps_turnstile_site_key', stripslashes($_POST['aiowps_turnstile_site_key']));
			$aio_wp_security->configs->set_value('aiowps_recaptcha_site_key', stripslashes($_POST['aiowps_recaptcha_site_key']));

			$turnstile_theme = isset($_POST['aiowps_turnstile_theme']) ? sanitize_text_field($_POST['aiowps_turnstile_theme']) : '';
			$turnstile_theme = array_key_exists($turnstile_theme, $captcha_themes) ? $turnstile_theme : 'auto';
			$aio_wp_security->configs->set_value('aiowps_turnstile_theme', $turnstile_theme);

			// If secret key is masked then don't resave it
			$turnstile_secret_key = sanitize_text_field($_POST['aiowps_turnstile_secret_key']);
			if (strpos($turnstile_secret_key, '********') === false) {
				$aio_wp_security->configs->set_value('aiowps_turnstile_secret_key', $turnstile_secret_key);
			}

			// If secret key is masked then don't resave it
			$recaptcha_secret_key = sanitize_text_field($_POST['aiowps_recaptcha_secret_key']);
			if (strpos($recaptcha_secret_key, '********') === false) {
				$aio_wp_security->configs->set_value('aiowps_recaptcha_secret_key', $recaptcha_secret_key);
			}

			if ('google-recaptcha-v2' == $aio_wp_security->configs->get_value('aiowps_default_captcha') && false === $aio_wp_security->captcha_obj->google_recaptcha_verify_configuration($aio_wp_security->configs->get_value('aiowps_recaptcha_site_key'), $aio_wp_security->configs->get_value('aiowps_recaptcha_secret_key'))) {
				$aio_wp_security->configs->set_value('aios_google_recaptcha_invalid_configuration', '1');
			} elseif ('1' == $aio_wp_security->configs->get_value('aios_google_recaptcha_invalid_configuration')) {
				$aio_wp_security->configs->delete_value('aios_google_recaptcha_invalid_configuration');
			}

			$aio_wp_security->configs->save_config();

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}

		$captcha_theme = 'auto';
		if ('cloudflare-turnstile' == $aio_wp_security->configs->get_value('aiowps_default_captcha')) $captcha_theme = $aio_wp_security->configs->get_value('aiowps_turnstile_theme');

		if ('cloudflare-turnstile' == $aio_wp_security->configs->get_value('aiowps_default_captcha') && false === $aio_wp_security->captcha_obj->cloudflare_turnstile_verify_configuration($aio_wp_security->configs->get_value('aiowps_turnstile_site_key'), $aio_wp_security->configs->get_value('aiowps_turnstile_secret_key'))) {
			echo '<div class="notice notice-warning aio_red_box"><p>'.__('Your Cloudflare Turnstile configuration is invalid.', 'all-in-one-wp-security-and-firewall').' '.__('Please enter the correct Cloudflare Turnstile keys below to use the Turnstile feature.', 'all-in-one-wp-security-and-firewall').'</p></div>';
		}

		if ('1' == $aio_wp_security->configs->get_value('aios_google_recaptcha_invalid_configuration')) {
			echo '<div class="notice notice-warning aio_red_box"><p>'.__('Your Google reCAPTCHA configuration is invalid.', 'all-in-one-wp-security-and-firewall').' '.__('Please enter the correct reCAPTCHA keys below to use the reCAPTCHA feature.', 'all-in-one-wp-security-and-firewall').'</p></div>';
		}

		$default_captcha = $aio_wp_security->configs->get_value('aiowps_default_captcha');
		$aio_wp_security->include_template('wp-admin/brute-force/captcha-settings.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'supported_captchas' => $supported_captchas, 'default_captcha' => $default_captcha, 'captcha_themes' => $captcha_themes, 'captcha_theme' => $captcha_theme));
	}

	/**
	 * Login whitelist tab.
	 *
	 * @return void
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 */
	protected function render_login_whitelist() {
		global $aio_wp_security, $aiowps_feature_mgr;
		$result = 0;
		$ip_v4 = false;
		$your_ip_address = AIOWPSecurity_Utility_IP::get_user_ip_address();
		if (filter_var($your_ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) $ip_v4 = true;
		if (isset($_POST['aiowps_save_whitelist_settings'])) {
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-whitelist-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed for save whitelist settings.', 4);
				die('Nonce check failed for save whitelist settings.');
			}

			if (!empty($_POST['aiowps_allowed_ip_addresses'])) {
				$ip_addresses = $_POST['aiowps_allowed_ip_addresses'];
				$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
				$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'whitelist');
				if (is_wp_error($validated_ip_list_array)) {
					$result = -1;
					$this->show_msg_error(nl2br($validated_ip_list_array->get_error_message()));
				} else {
					$result = 1;
					$whitelist_ip_data = implode("\n", $validated_ip_list_array);
					$aio_wp_security->configs->set_value('aiowps_allowed_ip_addresses', $whitelist_ip_data);
					$_POST['aiowps_allowed_ip_addresses'] = ''; // Clear the post variable for the banned address list.
				}
			} else {
				$result = 1;
				$aio_wp_security->configs->set_value('aiowps_allowed_ip_addresses', ''); // Clear the IP address config value
			}

			if (1 == $result) {
				$aio_wp_security->configs->set_value('aiowps_enable_whitelisting', isset($_POST["aiowps_enable_whitelisting"]) ? '1' : '');
				if ('1' == $aio_wp_security->configs->get_value('aiowps_is_login_whitelist_disabled_on_upgrade')) {
					$aio_wp_security->configs->delete_value('aiowps_is_login_whitelist_disabled_on_upgrade');
				}
				$aio_wp_security->configs->save_config(); //Save the configuration

				// Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

				$this->show_msg_settings_updated();
			}
		}

		$aiowps_allowed_ip_addresses = isset($_POST['aiowps_allowed_ip_addresses']) ? wp_unslash($_POST['aiowps_allowed_ip_addresses']) : '';
		$aiowps_allowed_ip_addresses = -1 == $result ? $aiowps_allowed_ip_addresses : $aio_wp_security->configs->get_value('aiowps_allowed_ip_addresses');

		$aio_wp_security->include_template('wp-admin/brute-force/login-whitelist.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'your_ip_address' => $your_ip_address, 'ip_v4' => $ip_v4, 'aiowps_allowed_ip_addresses' => $aiowps_allowed_ip_addresses));
	}

	/**
	 * Renders the 404 Detection tab
	 *
	 * @return void
	 */
	protected function render_404_detection() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowps_delete_404_event_records'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-delete-404-event-records-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for delete all 404 event logs operation", 4);
				die(__('Nonce check failed for delete all 404 event logs operation', 'all-in-one-wp-security-and-firewall'));
			}
			global $wpdb;
			$events_table_name = AIOWPSEC_TBL_EVENTS;
			//Delete all 404 records from the events table
			$where = array('event_type' => '404');
			$result = $wpdb->delete($events_table_name, $where);

			if (false === $result) {
				$aio_wp_security->debug_logger->log_debug("404 Detection Feature - Delete all 404 event logs operation failed", 4);
				$this->show_msg_error(__('404 Detection Feature - The operation to delete all the 404 event logs failed', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->show_msg_updated(__('All 404 event logs were deleted from the database successfully.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		include_once 'wp-security-list-404.php'; // For rendering the AIOWPSecurity_List_Table in basic-firewall tab
		$event_list_404 = new AIOWPSecurity_List_404(); // For rendering the AIOWPSecurity_List_Table in basic-firewall tab

		if (isset($_POST['aiowps_save_404_detect_options'])) { // Do form submission tasks
			$error = '';
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-404-detection-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on 404 detection options save", 4);
				die("Nonce check failed on 404 detection options save");
			}

			$aio_wp_security->configs->set_value('aiowps_enable_404_logging', isset($_POST["aiowps_enable_404_IP_lockout"]) ? '1' : ''); //the "aiowps_enable_404_IP_lockout" checkbox currently controls both the 404 lockout and 404 logging
			$aio_wp_security->configs->set_value('aiowps_enable_404_IP_lockout', isset($_POST["aiowps_enable_404_IP_lockout"]) ? '1' : '');

			$lockout_time_length = isset($_POST['aiowps_404_lockout_time_length']) ? sanitize_text_field($_POST['aiowps_404_lockout_time_length']) : '';
			if (!is_numeric($lockout_time_length)) {
				$error .= '<br />'.__('You entered a non numeric value for the lockout time length field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$lockout_time_length = '60';//Set it to the default value for this field
			}

			$redirect_url = isset($_POST['aiowps_404_lock_redirect_url']) ? trim($_POST['aiowps_404_lock_redirect_url']) : '';
			if ('' == $redirect_url || '' == esc_url($redirect_url, array('http', 'https'))) {
				$error .= '<br />'.__('You entered an incorrect format for the "Redirect URL" field.', 'all-in-one-wp-security-and-firewall') . ' ' . __('It has been set to the default value.', 'all-in-one-wp-security-and-firewall');
				$redirect_url = 'http://127.0.0.1';
			}

			if ($error) {
				$this->show_msg_error(__('Attention:', 'all-in-one-wp-security-and-firewall').' '.$error);
			}

			$aio_wp_security->configs->set_value('aiowps_404_lockout_time_length', absint($lockout_time_length));
			$aio_wp_security->configs->set_value('aiowps_404_lock_redirect_url', $redirect_url);
			$aio_wp_security->configs->save_config();

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}


		if (isset($_GET['action'])) { // Do list table form row action tasks
			$nonce = isset($_GET['aiowps_nonce']) ? $_GET['aiowps_nonce'] : '';
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, '404_log_item_action');
			
			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			if ('temp_block' == $_GET['action']) { // Temp Block link was clicked for a row in list table
				$event_list_404->block_ip(strip_tags($_GET['ip_address']));
			}

			if ('blacklist_ip' == $_GET['action']) { //Blacklist IP link was clicked for a row in list table
				$event_list_404->blacklist_ip_address(strip_tags($_GET['ip_address']));
			}

			if ('delete_event_log' == $_GET['action']) { //Unlock link was clicked for a row in list table
				$event_list_404->delete_404_event_records(strip_tags($_GET['id']));
			}
		}

		$page = $_REQUEST['page'];
		$tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : '';
		$aio_wp_security->include_template('wp-admin/firewall/404-detection.php', false, array('event_list_404' => $event_list_404, 'page' => $page, 'tab' => $tab));
	}

	/**
	 * Honeypot tab.
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 *
	 * @return void
	 */
	protected function render_honeypot() {
		global $aio_wp_security, $aiowps_feature_mgr;

		if (isset($_POST['aiowpsec_save_honeypot_settings'])) { // Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-honeypot-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on honeypot settings save.", 4);
				die("Nonce check failed on honeypot settings save.");
			}

			// Save all the form values to the options
			$aio_wp_security->configs->set_value('aiowps_enable_login_honeypot', isset($_POST["aiowps_enable_login_honeypot"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_enable_registration_honeypot', isset($_POST["aiowps_enable_registration_honeypot"]) ? '1' : '');
			$aio_wp_security->configs->save_config(); // Save the configuration

			// Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			$this->show_msg_settings_updated();
		}

		$aio_wp_security->include_template('wp-admin/brute-force/honeypot.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

}
