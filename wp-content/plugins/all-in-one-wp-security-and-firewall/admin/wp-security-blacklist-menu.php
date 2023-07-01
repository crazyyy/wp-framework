<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

/**
 * AIOWPSecurity_Blacklist_Menu class for banning ips and user agents.
 *
 * @access public
 */
class AIOWPSecurity_Blacklist_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Blacklist menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_BLACKLIST_MENU_SLUG;
	
	/**
	 * Constructor adds menu for Blacklist manager
	 */
	public function __construct() {
		parent::__construct(__('Blacklist manager', 'all-in-one-wp-security-and-firewall'));
	}

	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'ban-users' => array(
				'title' => __('Ban users', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_ban_users'),
			),
		);

		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Renders ban user tab for blacklist IPs and user agents
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_feature_mgr
	 * @global $aiowps_firewall_config
	 */
	protected function render_ban_users() {
		global $aio_wp_security, $aiowps_feature_mgr, $aiowps_firewall_config;
		$result = 1;
		if (isset($_POST['aiowps_save_blacklist_settings'])) {
			if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'aiowpsec-blacklist-settings-nonce')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for save blacklist settings.", 4);
				die('Nonce check failed for save blacklist settings.');
			}
			$aiowps_enable_blacklisting = isset($_POST["aiowps_enable_blacklisting"]) ? '1' : '';
			$aiowps_banned_ip_addresses = $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses');
			$aiowps_banned_user_agents = $aio_wp_security->configs->get_value('aiowps_banned_user_agents');
			if ('' == $aiowps_enable_blacklisting && empty($aiowps_banned_ip_addresses) && empty($aiowps_banned_user_agents) && (!empty($_POST['aiowps_banned_ip_addresses']) || !empty($_POST['aiowps_banned_user_agents']))) {
				$result = -1;
				$this->show_msg_error('You must check the enable IP or user agent blacklisting.', 'all-in-one-wp-security-and-firewall');
			} else if ('1' == $aiowps_enable_blacklisting && empty($_POST['aiowps_banned_ip_addresses']) && empty($_POST['aiowps_banned_user_agents'])) {
				$this->show_msg_error('You must submit at least one IP address or one user agent value.', 'all-in-one-wp-security-and-firewall');
			} else {
				if ('1' == $aiowps_enable_blacklisting && !empty($_POST['aiowps_banned_ip_addresses'])) {
					$ip_addresses = stripslashes($_POST['aiowps_banned_ip_addresses']);
					$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
					$payload = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'blacklist');
					if (1 == $payload[0]) {
						//success case
						$list = $payload[1];
						$banned_ip_data = implode("\n", $list);
						$banned_ip_addresses_list = preg_split('/\R/', $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses')); // historical settings where the separator may have depended on PHP_EOL
						if ($banned_ip_addresses_list !== $list) {
							$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', $banned_ip_data);
							$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $list);
						}
						$_POST['aiowps_banned_ip_addresses'] = ''; // Clear the post variable for the banned address list
					} else {
						$result = -1;
						$error_msg = $payload[1][0];
						$this->show_msg_error($error_msg);
					}
				} else {
					$aio_wp_security->configs->set_value('aiowps_banned_ip_addresses', ''); // Clear the IP address config value
					$aiowps_firewall_config->set_value('aiowps_blacklist_ips', array());
				}

				if ('1' == $aiowps_enable_blacklisting && !empty($_POST['aiowps_banned_user_agents'])) {
					$result = $result * $this->validate_user_agent_list(stripslashes($_POST['aiowps_banned_user_agents']));
				} else {
					// Clear the user agent list
					$aio_wp_security->configs->set_value('aiowps_banned_user_agents', '');
					$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', array());
				}

				if (1 == $result) {
					$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', $aiowps_enable_blacklisting, true);
					if ('1' == $aio_wp_security->configs->get_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade')) {
						$aio_wp_security->configs->delete_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade');
					}

					// Recalculate points after the feature status/options have been altered
					$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
					$this->show_msg_settings_updated();
				}
			}
		}

		$aio_wp_security->include_template('wp-admin/blacklist/ban-users.php', false, array('result' => $result, 'aiowps_feature_mgr' => $aiowps_feature_mgr));
	}

	/**
	 * Validates posted user agent list and set, save as config.
	 *
	 * @param string $banned_user_agents
	 *
	 * @global $aio_wp_security
	 * @global $aiowps_firewall_config
	 */
	private function validate_user_agent_list($banned_user_agents) {
		global $aio_wp_security, $aiowps_firewall_config;
		@ini_set('auto_detect_line_endings', true);
		$submitted_agents = explode("\n", $banned_user_agents);
		$agents = array();
		if (!empty($submitted_agents)) {
			foreach ($submitted_agents as $agent) {
				if (!empty($agent)) {
					$text = sanitize_text_field($agent);
					$agents[] = $text;
				}
			}
		}

		if (sizeof($agents) > 1) {
			sort( $agents );
			$agents = array_unique($agents, SORT_STRING);
		}

		$banned_user_agent_data = implode("\n", $agents);
		$aio_wp_security->configs->set_value('aiowps_banned_user_agents', $banned_user_agent_data);
		$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', $agents);
		$_POST['aiowps_banned_user_agents'] = ''; // Clear the post variable for the banned address list
		return 1;
	}
} //end class
