<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Firewall_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Firewall menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_FIREWALL_MENU_SLUG;

	/**
	 * Constructor adds menu for Firewall
	 */
	public function __construct() {
		parent::__construct(__('Firewall', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'php-rules' => array(
				'title' => __('PHP rules', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_php_rules'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'htaccess-rules' => array(
				'title' => __('.htaccess rules', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_htaccess_rules'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'6g-firewall' => array(
				'title' => __('6G firewall rules', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_6g_firewall'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'internet-bots' => array(
				'title' => __('Internet bots', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_internet_bots'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'blacklist' => array(
				'title' => __('Blacklist', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_blacklist'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'wp-rest-api' => array(
				'title' => __('WP REST API', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_wp_rest_api'),
			),
			'advanced-settings' => array(
				'title' => __('Advanced settings', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_advanced_settings'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			)
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders the PHP Firewall settings tab
	 *
	 * @return void
	 */
	protected function render_php_rules() {
		global $aiowps_feature_mgr;
		global $aio_wp_security;
		global $aiowps_firewall_config;

		if (isset($_POST['aiowps_apply_php_firewall_settings'])) { // Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-php-firewall-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die("Nonce check failed on enable PHP firewall settings");
			}

			//Save settings
			$aiowps_firewall_config->set_value('aiowps_enable_pingback_firewall', isset($_POST["aiowps_enable_pingback_firewall"]));
			$aio_wp_security->configs->set_value('aiowps_disable_xmlrpc_pingback_methods', isset($_POST["aiowps_disable_xmlrpc_pingback_methods"]) ? '1' : ''); //this disables only pingback methods of xmlrpc but leaves other methods so that Jetpack and other apps will still work
			$aio_wp_security->configs->set_value('aiowps_disable_rss_and_atom_feeds', isset($_POST['aiowps_disable_rss_and_atom_feeds']) ? '1' : '');
			$aiowps_firewall_config->set_value('aiowps_forbid_proxy_comments', isset($_POST['aiowps_forbid_proxy_comments']));
			$aiowps_firewall_config->set_value('aiowps_deny_bad_query_strings', isset($_POST['aiowps_deny_bad_query_strings']));
			$aiowps_firewall_config->set_value('aiowps_advanced_char_string_filter', isset($_POST['aiowps_advanced_char_string_filter']));

			//Commit the config settings
			$aio_wp_security->configs->save_config();

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			$this->show_msg_updated(__('Settings were successfully saved', 'all-in-one-wp-security-and-firewall'));
		}

		$aio_wp_security->include_template('wp-admin/firewall/php-firewall-rules.php');
	}

	/**
	 * Renders the Htaccess Firewall tab
	 *
	 * @return void
	 */
	protected function render_htaccess_rules() {
		global $aiowps_feature_mgr;
		global $aio_wp_security;

		if (isset($_POST['aiowps_apply_htaccess_firewall_settings'])) { // Do form submission tasks
			$nonce = $_POST['_wpnonce'];
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-htaccess-firewall-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die("Nonce check failed on enable htaccess firewall settings");
			}

			// Max file upload size in basic rules
			$upload_size = absint($_POST['aiowps_max_file_upload_size']);

			$upload_size = apply_filters('aiowps_max_allowed_upload_config', $upload_size); // Set a filterable limit
			
			if (empty($upload_size)) {
				$upload_size = AIOS_FIREWALL_MAX_FILE_UPLOAD_LIMIT_MB;
			}

			//Save settings
			$aio_wp_security->configs->set_value('aiowps_enable_basic_firewall', isset($_POST["aiowps_enable_basic_firewall"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_max_file_upload_size', $upload_size);
			$aio_wp_security->configs->set_value('aiowps_block_debug_log_file_access', isset($_POST["aiowps_block_debug_log_file_access"]) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_disable_index_views', isset($_POST['aiowps_disable_index_views']) ? '1' : '');
			$aio_wp_security->configs->set_value('aiowps_disable_trace_and_track', isset($_POST['aiowps_disable_trace_and_track']) ? '1' : '');

			//Commit the config settings
			$aio_wp_security->configs->save_config();

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			//Now let's write the applicable rules to the .htaccess file
			$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

			if ($res) {
				$this->show_msg_updated(__('You have successfully saved the .htaccess rules', 'all-in-one-wp-security-and-firewall'));
			} else {
				$this->show_msg_error(__('Could not write to the .htaccess file, please check the file permissions.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		$aio_wp_security->include_template('wp-admin/firewall/htaccess-firewall-rules.php');
	}
	
	/**
	 * Renders the 6G Blacklist Firewall Rules tab
	 *
	 * @return void
	 */
	protected function render_6g_firewall() {
		global $aio_wp_security, $aiowps_feature_mgr, $aiowps_firewall_config;

		$block_request_methods = array_map('strtolower', AIOS_Abstracted_Ids::get_firewall_block_request_methods());

		$current_request_methods_settings = $aiowps_firewall_config->get_value('aiowps_6g_block_request_methods');
		$current_other_settings = array(
			$aiowps_firewall_config->get_value('aiowps_6g_block_query'),
			$aiowps_firewall_config->get_value('aiowps_6g_block_request'),
			$aiowps_firewall_config->get_value('aiowps_6g_block_referrers'),
			$aiowps_firewall_config->get_value('aiowps_6g_block_agents'),
		);

		$are_methods_set = !empty($current_request_methods_settings);
		$are_others_set = array_reduce($current_other_settings, function($carry, $item) {
			return $carry || $item;
		});

		if (($are_methods_set || $are_others_set) && '1' != $aio_wp_security->configs->get_value('aiowps_enable_6g_firewall')) {
			$aio_wp_security->configs->set_value('aiowps_enable_6g_firewall', '1');
			$aio_wp_security->configs->save_config();
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		}

		//Save 6G/5G
		if (isset($_POST['aiowps_apply_5g_6g_firewall_settings'])) {

			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-enable-5g-6g-firewall-nonce');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die($result->get_error_message());
			}
			
			// If the user has changed the 5G firewall checkbox settings, then there is a need yo write htaccess rules again.
			$is_5G_firewall_option_changed = ((isset($_POST['aiowps_enable_5g_firewall']) && '1' != $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')) || (!isset($_POST['aiowps_enable_5g_firewall']) && '1' == $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')));

			//Save settings
			if (isset($_POST['aiowps_enable_5g_firewall'])) {
				$aio_wp_security->configs->set_value('aiowps_enable_5g_firewall', '1');
			} else {
				$aio_wp_security->configs->set_value('aiowps_enable_5g_firewall', '');
			}

			if ($is_5G_firewall_option_changed) {
				$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess(); // let's write the applicable rules to the .htaccess file
			}

			if (isset($_POST['aiowps_enable_6g_firewall'])) {
				$aiowps_6g_block_request_methods = array_filter(AIOS_Abstracted_Ids::get_firewall_block_request_methods(), function($block_request_method) {
					return ('PUT' != $block_request_method);
				});

				if (false === $are_methods_set && false === $are_others_set) {
					$aiowps_firewall_config->set_value('aiowps_6g_block_request_methods', $aiowps_6g_block_request_methods);
					$aiowps_firewall_config->set_value('aiowps_6g_block_query', true);
					$aiowps_firewall_config->set_value('aiowps_6g_block_request', true);
					$aiowps_firewall_config->set_value('aiowps_6g_block_referrers', true);
					$aiowps_firewall_config->set_value('aiowps_6g_block_agents', true);
				} else {
					$methods = array();

					foreach ($block_request_methods as $block_request_method) {
						if (isset($_POST['aiowps_block_request_method_'.$block_request_method])) {
							$methods[] = strtoupper($block_request_method);
						}
					}

					$aiowps_firewall_config->set_value('aiowps_6g_block_request_methods', $methods);
					$aiowps_firewall_config->set_value('aiowps_6g_block_query', isset($_POST['aiowps_block_query']));
					$aiowps_firewall_config->set_value('aiowps_6g_block_request', isset($_POST['aiowps_block_request']));
					$aiowps_firewall_config->set_value('aiowps_6g_block_referrers', isset($_POST['aiowps_block_refs']));
					$aiowps_firewall_config->set_value('aiowps_6g_block_agents', isset($_POST['aiowps_block_agents']));
				}

				$aio_wp_security->configs->set_value('aiowps_enable_6g_firewall', '1');

				$res = true; //shows the success notice
			} else {
				AIOWPSecurity_Configure_Settings::turn_off_all_6g_firewall_configs();
				$aio_wp_security->configs->set_value('aiowps_enable_6g_firewall', '');
				$res = true;
			}

			//Commit the config settings
			$aio_wp_security->configs->save_config();

			if ($res) {
				$this->show_msg_updated(__('You have successfully saved the 5G/6G Firewall Protection configuration', 'all-in-one-wp-security-and-firewall'));
				// Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			} else {
				$this->show_msg_error(__('Could not write to the .htaccess file, please check the file permissions.', 'all-in-one-wp-security-and-firewall'));
			}
		}

		 //Load required data from config
		if (!empty($aiowps_firewall_config)) {
			// firewall config is available
			$methods = $aiowps_firewall_config->get_value('aiowps_6g_block_request_methods');
			if (empty($methods)) {
				$methods = array();
			}

			$blocked_query     = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_query');
			$blocked_request   = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_request');
			$blocked_referrers = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_referrers');
			$blocked_agents    = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_agents');

			if (empty($methods) && (!$blocked_query && !$blocked_request && !$blocked_referrers && !$blocked_agents) && '1' == $aio_wp_security->configs->get_value('aiowps_enable_6g_firewall')) {
				$aio_wp_security->configs->set_value('aiowps_enable_6g_firewall', '');
				$aio_wp_security->configs->save_config();
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
			}

		} else {
			// firewall config is unavailable
			?>
				<div class="notice notice-error">
					<p><strong><?php _e('All in One WP Security and Firewall', 'all-in-one-wp-security-and-firewall'); ?></strong></p>
					<p><?php _e('We were unable to access the firewall\'s configuration file:', 'all-in-one-wp-security-and-firewall');?></p>
					<pre style="max-width: 100%;background-color: #f0f0f0;border: #ccc solid 1px;padding: 10px;white-space: pre-wrap;"><?php echo esc_html(AIOWPSecurity_Utility_Firewall::get_firewall_rules_path() . 'settings.php'); ?></pre>
					<p><?php _e('As a result, the firewall will be unavailable.', 'all-in-one-wp-security-and-firewall');?></p>
					<p><?php _e('Please check your PHP error log for further information.', 'all-in-one-wp-security-and-firewall');?></p>
					<p><?php _e('If you\'re unable to locate your PHP log file, please contact your web hosting company to ask them where it can be found on their setup.', 'all-in-one-wp-security-and-firewall');?></p>
				</div>
			<?php

			//set default variables
			$methods           = array();
			$blocked_query     = false;
			$blocked_request   = false;
			$blocked_referrers = false;
			$blocked_agents    = false;
		}

		$advanced_options_disabled = '1' != $aio_wp_security->configs->get_value('aiowps_enable_6g_firewall');
		$settings = array_merge(array('methods' => $methods), compact('blocked_query', 'blocked_request', 'blocked_referrers', 'blocked_agents', 'block_request_methods', 'aiowps_firewall_config', 'advanced_options_disabled'));
		$aio_wp_security->include_template('wp-admin/firewall/6g.php', false, $settings);
	}

	/**
	 * Renders the Internet Bots tab
	 *
	 * @return void
	 */
	protected function render_internet_bots() {
		global $aiowps_feature_mgr;
		global $aio_wp_security;
		global $aiowps_firewall_config;

		if (isset($_POST['aiowps_save_internet_bot_settings'])) { // Do form submission tasks.
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-save-internet-bot-settings-nonce');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			$error = false;

			if (isset($_POST['aiowps_block_fake_googlebots'])) {
				$validated_ip_list_array = AIOWPSecurity_Utility::get_googlebot_ip_ranges();

				if (is_wp_error($validated_ip_list_array)) {
					$this->show_msg_error(__('The attempt to save the \'Block fake Googlebots\' settings failed, because it was not possible to validate the Googlebot IP addresses:', 'all-in-one-wp-security-and-firewall') . ' ' . $validated_ip_list_array->get_error_message());
					$error = true;
				} else {
					$aiowps_firewall_config->set_value('aiowps_block_fake_googlebots', true);
				}
			} else {
				$aiowps_firewall_config->set_value('aiowps_block_fake_googlebots', false);
			}

			$aiowps_firewall_config->set_value('aiowps_ban_post_blank_headers', isset($_POST['aiowps_ban_post_blank_headers']));

			// Recalculate points after the feature status/options have been altered.
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();

			if (!$error) {
				$this->show_msg_settings_updated();
			}
		}

		$aio_wp_security->include_template('wp-admin/firewall/internet-bots.php');
	}

	/**
	 * Renders the Advanced settings tab.
	 *
	 * @return void
	 */
	protected function render_advanced_settings() {
		global $aio_wp_security;

		$allowlist = \AIOWPS\Firewall\Allow_List::get_ips();

		if (isset($_POST['aios_firewall_allowlist'])) {

			if (is_wp_error(AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aios-firewall-allowlist-nonce'))) {
					$aio_wp_security->debug_logger->log_debug("Nonce check failed for save firewall's allow list.", 4);
					die('Nonce check failed for firewall\'s allow list.');
			}

			$allowlist = $_POST['aios_firewall_allowlist'];
			$ips      = stripslashes($allowlist);
			$ips      = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ips);
			$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ips, 'firewall_allowlist');

			if (is_wp_error($validated_ip_list_array)) {
				$this->show_msg_error(nl2br($validated_ip_list_array->get_error_message()));
			} else {
				\AIOWPS\Firewall\Allow_List::add_ips($validated_ip_list_array);
				$this->show_msg_settings_updated();
			}
		}

		$aio_wp_security->include_template('wp-admin/firewall/advanced-settings.php', false, compact('allowlist'));
	}

	/**
	 * Renders ban user tab for blacklist IPs and user agents
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 * @global $aiowps_firewall_config
	 *
	 * @return void
	 */
	protected function render_blacklist() {
		global $aio_wp_security, $aiowps_feature_mgr, $aiowps_firewall_config;
		$result = 1;
		if (isset($_POST['aiowps_save_blacklist_settings'])) {
			$nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';
			$nonce_user_cap_result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($nonce, 'aiowpsec-blacklist-settings-nonce');

			if (is_wp_error($nonce_user_cap_result)) {
				$aio_wp_security->debug_logger->log_debug($nonce_user_cap_result->get_error_message(), 4);
				die($nonce_user_cap_result->get_error_message());
			}

			if (!empty($_POST['aiowps_banned_ip_addresses'])) {
				$ip_addresses = stripslashes($_POST['aiowps_banned_ip_addresses']);
				$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
				$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'blacklist');
				if (is_wp_error($validated_ip_list_array)) {
					$result = -1;
					$this->show_msg_error(nl2br($validated_ip_list_array->get_error_message()));
				} else {
					$banned_ip_addresses_list = preg_split('/\R/', $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses')); // Historical settings where the separator may have depended on PHP_EOL.
					if ($banned_ip_addresses_list !== $validated_ip_list_array) {
						$banned_ip_data = implode("\n", $validated_ip_list_array);
						$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', $banned_ip_data);
						$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $validated_ip_list_array);
					}
					$_POST['aiowps_banned_ip_addresses'] = ''; // Clear the post variable for the banned address list.
				}
			} else {
				$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', ''); // Clear the IP address config value
				$aiowps_firewall_config->set_value('aiowps_blacklist_ips', array());
			}

			if (!empty($_POST['aiowps_banned_user_agents'])) {
				$result = $result * $this->validate_user_agent_list(stripslashes($_POST['aiowps_banned_user_agents']));
			} else {
				// Clear the user agent list
				$aio_wp_security->configs->set_value('aiowps_banned_user_agents', '');
				$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', array());
			}

			if (1 == $result) {
				$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', isset($_POST["aiowps_enable_blacklisting"]) ? '1' : '');
				if ('1' == $aio_wp_security->configs->get_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade')) {
					$aio_wp_security->configs->delete_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade');
				}

				$aio_wp_security->configs->save_config();

				// Recalculate points after the feature status/options have been altered
				$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
				$this->show_msg_settings_updated();
			}
		}

		$aiowps_banned_user_agents = isset($_POST['aiowps_banned_user_agents']) ? wp_unslash($_POST['aiowps_banned_user_agents']) : '';
		$aiowps_banned_ip_addresses = isset($_POST['aiowps_banned_ip_addresses']) ? wp_unslash($_POST['aiowps_banned_ip_addresses']) : '';

		$aio_wp_security->include_template('wp-admin/firewall/blacklist.php', false, array('result' => $result, 'aiowps_feature_mgr' => $aiowps_feature_mgr, 'aiowps_banned_user_agents' => $aiowps_banned_user_agents, 'aiowps_banned_ip_addresses' => $aiowps_banned_ip_addresses));
	}

	/**
	 * Validates posted user agent list and set, save as config.
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_firewall_config
	 *
	 * @param string $banned_user_agents
	 *
	 * @return int
	 */
	private function validate_user_agent_list($banned_user_agents) {
		global $aio_wp_security, $aiowps_firewall_config;
		$submitted_agents = AIOWPSecurity_Utility::splitby_newline_trim_filter_empty($banned_user_agents);
		$agents = array_unique(array_filter(array_map('sanitize_text_field', $submitted_agents), 'strlen'));
		$aio_wp_security->configs->set_value('aiowps_banned_user_agents', implode("\n", $agents));
		$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', $agents);
		$_POST['aiowps_banned_user_agents'] = ''; // Clear the post variable for the banned address list
		return 1;
	}

	/**
	 * Renders the submenu's WP REST API tab
	 *
	 * @return Void
	 */
	protected function render_wp_rest_api() {
		global $aio_wp_security, $aiowps_feature_mgr;
		if (isset($_POST['aiowpsec_save_rest_settings'])) {
			$result = AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_REQUEST['_wpnonce'], 'aiowpsec-rest-settings');
			if (is_wp_error($result)) {
				$aio_wp_security->debug_logger->log_debug($result->get_error_message(), 4);
				die("Nonce check failed on REST API security feature settings save.");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_disallow_unauthorized_rest_requests', isset($_POST["aiowps_disallow_unauthorized_rest_requests"]) ? '1' : '', true);

			$this->show_msg_updated(__('WP REST API Security feature settings saved!', 'all-in-one-wp-security-and-firewall'));

			//Recalculate points after the feature status/options have been altered
			$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		}

		$aio_wp_security->include_template('wp-admin/firewall/wp-rest-api.php', false, array());
	}
}
