<?php

if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed');

if (!class_exists('Updraft_Notices_1_2')) require_once(AIO_WP_SECURITY_PATH.'/vendor/team-updraft/common-libs/src/updraft-notices/updraft-notices.php');

class AIOWPSecurity_Notices extends Updraft_Notices_1_2 {

	private $initialized = false;

	protected $notices_content = array();

	// protected $self_affiliate_id = null;

	/**
	 * Safely formats translatable strings to prevent errors due to mis-translations.
	 *
	 * @param string $text    Translatable text with placeholders.
	 * @param mixed  ...$args Arguments to fill placeholders.
	 *
	 * @return string The formatted text or an error fallback.
	 */
	private function safe_sprintf($text, ...$args) {
		global $aio_wp_security;
		try {
			return sprintf($text, ...$args);
		} catch (Throwable $e) {
			// Log the error for debugging purposes
			$aio_wp_security->debug_logger->log_debug('Notice rendering error: ' . $e->getMessage(), 4);
			return esc_html__('An error occurred while rendering this notice, please enable and check your debug log.', 'all-in-one-wp-security-and-firewall');
		}
	}


	/**
	 * Returns array_merge of notices from parent and notices in $child_notice_content.
	 *
	 * @return Array
	 */
	protected function populate_notices_content() {
		global $aio_wp_security;
		$parent_notice_content = parent::populate_notices_content();

		/* translators: 1. HTML text. 2. HTML text, 3. HTML text. */
		$sale_description = $this->safe_sprintf(__('Get %1$s with %2$s. %3$s, downtime, and response time issues.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('added protection', 'all-in-one-wp-security-and-firewall') . '</strong>', '<strong>' . __('Premium', 'all-in-one-wp-security-and-firewall') . '</strong>', '<strong>' . __('Scan your site for malware', 'all-in-one-wp-security-and-firewall') . '</strong>');

		/* translators: %s: HTML text. */
		$sale_description .= ' ' . $this->safe_sprintf(__('Block traffic by country of origin, get advanced two-factor authentication, %s, and more.', 'all-in-one-wp-security-and-firewall'), '<strong>' . __('added protection', 'all-in-one-wp-security-and-firewall') . '</strong>', '<strong>' . __('Premium', 'all-in-one-wp-security-and-firewall') . '</strong>', '<strong>' . __('Scan your site for malware', 'all-in-one-wp-security-and-firewall') . '</strong>');

		// Build text for firewall rules that have been upgraded
		$firewall_upgrade_text = '<p>' .
		esc_html__('The All in One Security plugin has deactivated some of the firewall settings that you had activated.', 'all-in-one-wp-security-and-firewall') .
		'</p>';
		$firewall_upgrade_text .= '<p>' .
		esc_html__('We have upgraded the following settings so that they are now part of the PHP firewall instead of .htaccess directives:', 'all-in-one-wp-security-and-firewall') .
		'</p>';
		$firewall_upgrade_text .= '<ul style="list-style: inside;">';

		$active_settings = $aio_wp_security->configs->get_value('aiowps_firewall_active_upgrade');

		if (!empty($active_settings)) {
			$active_settings = json_decode($active_settings);
			if (!empty($active_settings)) {

				foreach ($active_settings as $setting) {
					switch ($setting) {
						case 'aiowps_enable_pingback_firewall':
							$firewall_upgrade_text .= '<li>' . esc_html__('Completely block xmlrpc.php', 'all-in-one-wp-security-and-firewall').'</li>';
							break;
						case 'aiowps_forbid_proxy_comments':
							$firewall_upgrade_text .= '<li>' . esc_html__('Forbid proxy comment posting', 'all-in-one-wp-security-and-firewall').'</li>';
							break;
						case 'aiowps_deny_bad_query_strings':
							$firewall_upgrade_text .= '<li>' . esc_html__('Deny bad query strings', 'all-in-one-wp-security-and-firewall').'</li>';
							break;
						case 'aiowps_advanced_char_string_filter':
							$firewall_upgrade_text .= '<li>' . esc_html__('Advanced character filter', 'all-in-one-wp-security-and-firewall').'</li>';
							break;
						default:
							continue 2;
					}
				}
			}
		} else {
			$firewall_upgrade_text .= '<p><strong>' . esc_html__('None of the settings that have been upgraded were active.', 'all-in-one-wp-security-and-firewall').'</strong></p>';
		}

		$firewall_upgrade_text .= '</ul>';
		$firewall_upgrade_text .= '<p>' . esc_html__('What would you like to do?', 'all-in-one-wp-security-and-firewall') .'</p>';

		$login_whitelist_notice_text = '<p>' .
		esc_html__('The All in One Security plugin has disabled the login whitelist setting that you have enabled in the past.', 'all-in-one-wp-security-and-firewall') .
		'</p>' .
		'<p>';
		if (AIOWPSecurity_Utility::is_apache_server()) {
			$login_whitelist_notice_text .= esc_html__('Your website is running on an Apache webserver, the login whitelisting might not be functional until the recent update of AIOS (because it relied upon Apache-specific module features).', 'all-in-one-wp-security-and-firewall');
		} else {
			$login_whitelist_notice_text .= esc_html__('Your website is running on a non-Apache webserver, so the login whitelisting was not functional until the recent update of AIOS (because it relied upon Apache-specific features).', 'all-in-one-wp-security-and-firewall');
		}
		$login_whitelist_notice_text .= ' ' . esc_html__('It began working with AIOS version 5.0.8.', 'all-in-one-wp-security-and-firewall') . '   ' . esc_html__('We have disabled it so that your login page will not be blocked unexpectedly.', 'all-in-one-wp-security-and-firewall') .
		'</p>';

		$allowed_ip_addresses = explode("\n", $aio_wp_security->configs->get_value('aiowps_allowed_ip_addresses'));
		$allowed_ip_addresses = array_map('trim', $allowed_ip_addresses);
		$login_whitelist_notice_text .= '<p>' .
			esc_html__('Whitelisted login IP address(es):', 'all-in-one-wp-security-and-firewall') . ' ' . htmlspecialchars(implode(', ', $allowed_ip_addresses)) .
		'</p>' .
		'<p>' .
			esc_html__('Would you like to re-enable login whitelisting?', 'all-in-one-wp-security-and-firewall') .
		'</p>';

		$child_notice_content = array(
			// Upgrade AIOS backup to UDP backup in the 5.0.0 version
			'automated-database-backup' => array(
				'title'		  => esc_html__('Removed database backup feature from the All-In-One Security plugin', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => '<p>' .
									esc_html__('Beginning with version 5.0.0, AIOS has replaced the AIOS backup method with the superior UpdraftPlus method.', 'all-in-one-wp-security-and-firewall') . '  '.
									esc_html__('It remains free and is fully supported by the UpdraftPlus team.', 'all-in-one-wp-security-and-firewall') .
								'</p>' .
								'<p>' .
									esc_html__('You are seeing this notice because you have previously set up automated database backups in AIOS.', 'all-in-one-wp-security-and-firewall') . '   ' .
									esc_html__('Would you like to set up scheduled backups with UpdraftPlus?', 'all-in-one-wp-security-and-firewall') .
								'</p>',
				'button_link' => add_query_arg(array(
					'page' => 'aiowpsec_database',
					'tab'  => 'database-backup',
				), admin_url('admin.php')) . '#automated-scheduled-backups-heading',
				'button_meta' => esc_html__('Setup UpdraftPlus backup plugin', 'all-in-one-wp-security-and-firewall'),
				'dismiss_time' => 'dismiss_automated_database_backup_notice',
				'supported_positions' => array('automated-database-backup'),
				'validity_function' => 'should_show_automated_database_backup_notice',
			),
			'ip-retrieval-settings' => array(
				'title'		  => esc_html__('Important: set up your IP address detection settings', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => '<p>' .
					esc_html__("The All in One Security plugin couldn't be certain about the correct method to detect the IP address for your site visitors with your currently-configured IP address detection settings.", 'all-in-one-wp-security-and-firewall') . '  '.
					esc_html__('It is important for your security to set the IP address detection settings properly.', 'all-in-one-wp-security-and-firewall') .
					'</p>' .
					'<p>' .
					esc_html__('Please go to the settings and set them now.', 'all-in-one-wp-security-and-firewall') .
					'</p>',
				'button_link' => add_query_arg(array(
					'page' => 'aiowpsec_settings',
					'tab'  => 'advanced-settings',
				), admin_url('admin.php')) . '#automated-scheduled-backups-heading',
				'button_meta' => esc_html__('Setup IP address detection settings', 'all-in-one-wp-security-and-firewall'),
				'dismiss_time' => 'dismiss_ip_retrieval_settings_notice',
				'supported_positions' => array('ip-retrieval-settings'),
				'validity_function' => 'should_show_ip_retrieval_settings_notice',
			),
			'load-firewall-resources-failed' => array(
				'title'		  => '',
				'text' 		  => '<p>' .
					esc_html__('Failed to load the firewall resources.', 'all-in-one-wp-security-and-firewall') . ' ' .
					esc_html__('The firewall won\'t operate correctly.', 'all-in-one-wp-security-and-firewall') .
				'</p>',
				'dismiss_time' => '',
				'supported_positions' => array('load-firewall-resources-failed'),
				'validity_function' => 'should_show_load_firewall_resources_failed_notice',
			),
			'end-of-support-php-56' => array(
				'title'		  => esc_html__('AIOS PHP 5.6 support will end soon', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => $this->get_end_of_support_php_56_text(),
				'dismiss_time' => 'php_56_eol_dismiss_forever',
				'supported_positions' => array('end-of-support-php-56'),
				'validity_function' => 'should_show_end_of_support_php_56',
			),
			'upgrade-firewall-tab-rules' => array(
				'title'		  => esc_html__('Important: Disabled firewall settings', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => $firewall_upgrade_text,
				'button_link' => add_query_arg(array(
					'page' => esc_html(AIOWPSEC_FIREWALL_MENU_SLUG),
					'tab'  => 'basic-firewall',
				), admin_url('admin.php')),
				'action_button_text' => esc_html__('Reactivate', 'all-in-one-wp-security-and-firewall'),
				'button_meta' => esc_html__('Configure manually', 'all-in-one-wp-security-and-firewall'),
				'dismiss_time' => 'dismiss_firewall_settings_disabled_on_upgrade_notice',
				'supported_positions' => array('upgrade-firewall-tab-rules'),
				'dismiss_text' => esc_html__('Keep deactivated', 'all-in-one-wp-security-and-firewall'),
				'validity_function' => 'should_show_upgrade_firewall_settings_notice',
			),
			'ip-blacklist-settings-on-upgrade' => array(
				'title'		  => esc_html__('Important: Blacklist manager disabled', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => '<p>' .
					esc_html__("The blacklist manager feature has been disabled to prevent any unexpected site lockouts.", 'all-in-one-wp-security-and-firewall') .
					'</p>' .
					'<p>' .
					esc_html__("This feature will block any IP address or range listed in its settings, please double check your own details are not included before turning it back on.", 'all-in-one-wp-security-and-firewall') .
					'</p>' ,
				'button_link' => add_query_arg(array(
					'page' => esc_html(AIOWPSEC_FIREWALL_MENU_SLUG),
					'tab'  => 'blacklist'
				), admin_url('admin.php')) . '#poststuff',
				'action_button_text' => 'Turn it on',
				'button_meta' => esc_html__('Edit the settings', 'all-in-one-wp-security-and-firewall'),
				'dismiss_time' => 'dismiss_ip_blacklist_notice',
				'dismiss_text' => 'Keep it off',
				'supported_positions' => array('ip-blacklist-settings-on-upgrade'),
				'validity_function' => 'should_show_ip_blacklist_settings_on_upgrade',
			),
			'login-whitelist-disabled-on-upgrade' => array(
				'title'		  => esc_html__('Important: Disabled login whitelist setting', 'all-in-one-wp-security-and-firewall'),
				'text' 		  => $login_whitelist_notice_text,
				'button_link' => add_query_arg(array(
					'page' => esc_html(AIOWPSEC_BRUTE_FORCE_MENU_SLUG),
					'tab'  => 'login-whitelist',
				), admin_url('admin.php')) . '#poststuff',
				'action_button_text' => esc_html__('Turn it back on', 'all-in-one-wp-security-and-firewall'),
				'button_meta' => esc_html__('Edit the settings', 'all-in-one-wp-security-and-firewall'),
				'dismiss_time' => 'dismiss_login_whitelist_disabled_on_upgrade_notice',
				'supported_positions' => array('login-whitelist-disabled-on-upgrade'),
				'dismiss_text' => esc_html__('Keep it off', 'all-in-one-wp-security-and-firewall'),
				'validity_function' => 'should_show_login_whitelist_disabled_on_upgrade_notice',
			),
			'rate_plugin' => array(
				'text' => $this->safe_sprintf(esc_html__('We noticed AIOS has kept your site safe for a while.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('If you like us, please consider leaving a positive review.', 'all-in-one-wp-security-and-firewall'). ' ' . esc_html__('If you have any issues or questions, please contact %s.', 'all-in-one-wp-security-and-firewall'), '<a href="https://wordpress.org/support/plugin/all-in-one-wp-security-and-firewall/" target="_blank">' . esc_html__('support', 'all-in-one-wp-security-and-firewall').'</a>') . '<br>' . esc_html__('Thank you so much!', 'all-in-one-wp-security-and-firewall') . '<br><br>- <b>' . esc_html__('All-In-One Security (AIOS)', 'all-in-one-wp-security-and-firewall').'</b>',
				'image' => 'plugin-logos/aios-icon.png',
				'button_link' => 'https://wordpress.org/support/plugin/all-in-one-wp-security-and-firewall/reviews/?rate=5#new-post',
				'button_meta' => 'review',
				'dismiss_time' => 'dismiss_review_notice',
				'supported_positions' => $this->dashboard_top,
				'validity_function' => 'show_rate_notice'
			),
			'updraftplus' => array(
				'prefix' => '',
				'title' => esc_html__('Enhance your security even more by backing up your site', 'all-in-one-wp-security-and-firewall'),
				'text' => esc_html__('UpdraftPlus is the world\'s most trusted backup plugin.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('From the owners of All-In-One Security (AIOS).', 'all-in-one-wp-security-and-firewall'),
				'image' => 'plugin-logos/updraftplus-icon.png',
				'button_link' => 'https://wordpress.org/plugins/updraftplus/',
				'button_meta' => 'updraftplus',
				'dismiss_time' => 'dismiss_page_notice_until',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'updraftplus_not_installed',
			),
			'wp-optimize' => array(
				'prefix' => '',
				'title' => esc_html__('Speed up your site', 'all-in-one-wp-security-and-firewall'),
				'text' => esc_html__("After you've secured your site, we recommend you install our WP-Optimize plugin to streamline it for better website performance.", 'all-in-one-wp-security-and-firewall'),
				'image' => 'plugin-logos/wp-optimize-icon.png',
				'button_link' => 'https://wordpress.org/plugins/wp-optimize/',
				'button_meta' => 'wp-optimize',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
				'validity_function' => 'wp_optimize_not_installed',
			),

			// The sale adverts content starts here
			'blackfriday' => array(
				'prefix' => '',
				'title' => esc_html__('20% off - Black Friday Sale', 'all-in-one-wp-security-and-firewall'),
				'text' => $sale_description,
				'text2' => esc_html__('at checkout.', 'all-in-one-wp-security-and-firewall') . ' <strong>' . esc_html__('Hurry, offer ends 2 December.', 'all-in-one-wp-security-and-firewall') . '</strong>',
				'image' => 'notices/sale_20.png',
				'button_text' => sprintf(__('Save 20%% with code %s', 'all-in-one-wp-security-and-firewall'), 'blackfridaysale2025'),
				'button_link' => add_query_arg(
					array(
						'utm_source' => 'aios-plugin',
						'utm_medium' => 'referral',
						'utm_campaign' => 'bf25-aios-plugin-banner',
						'utm_content' => 'bf-sale',
						'utm_creative_format' => 'advert',
					),
				'https://teamupdraft.com/all-in-one-security/blackfriday'),
				'campaign' => 'blackfriday',
				'button_meta' => 'inline',
				'dismiss_time' => 'dismiss_season',
				// 'discount_code' => '‘bf22aiosupgrade’',
				'valid_from' => '2025-11-14 00:00:00',
				'valid_to' => '2025-12-02 23:59:59',
				'supported_positions' => $this->dashboard_top_or_report,
			)
		);

		return array_merge($parent_notice_content, $child_notice_content);
	}

	/**
	 * Decides whether to show the automated database backup notice.
	 *
	 * @return Boolean True if the automated database notice should be shown, otherwise false.
	 */
	protected function should_show_automated_database_backup_notice() {
		if ($this->is_database_backup_admin_page_tab()) {
			return false;
		}

		if (defined('AIOS_FORCE_AUTOMATED_DATABASE_BACKUP_NOTICE') && AIOS_FORCE_AUTOMATED_DATABASE_BACKUP_NOTICE) {
			return true;
		}

		if ($this->is_updraftplus_plugin_active() && $this->is_schedule_database_backup_set_in_updraftplus()) {
			return false;
		}

		global $aio_wp_security;
		if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_automated_backups')) {
			return true;
		}

		return false;
	}

	/**
	 * Determines whether to show the PHP 5.6 end of support notice
	 *
	 * @return boolean
	 */
	protected function should_show_end_of_support_php_56() {
		return version_compare(PHP_VERSION, '7.0.0', '<');
	}

	/**
	 * Gets the text to display with the PHP 5.6 end of support notice
	 *
	 * @return string
	 */
	protected function get_end_of_support_php_56_text() {
		$text = '<p>' . esc_html__('AIOS will end support for PHP 5.6 on the 1st September 2025.', 'all-in-one-wp-security-and-firewall') . '</p>';

		$text .= '<p>' . esc_html__('PHP 5.6 is outdated and no longer receives security updates.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('To keep things secure and compatible with modern WordPress standards, AIOS will move to a minimum requirement of PHP 7.0.', 'all-in-one-wp-security-and-firewall') . '</p>';

		$text .= '<p>' . esc_html__('After the 1st September 2025, AIOS may not operate correctly on PHP versions below 7.0.', 'all-in-one-wp-security-and-firewall') . '</p>';

		$text .= '<p>' . esc_html__('If you require help upgrading your PHP version, please contact your hosting provider.', 'all-in-one-wp-security-and-firewall') . '</p>';

		return $text;
	}

	/**
	 * Decides whether to show the load firewall resources failed notice.
	 *
	 * @return boolean
	 */
	protected function should_show_load_firewall_resources_failed_notice() {
		return !AIOS_Firewall_Resource::all_loaded();
	}

	/**
	 * Determines whether to show the notice which handles the firewall settings notice
	 *
	 * @return boolean
	 */
	protected function should_show_upgrade_firewall_settings_notice() {
		if (!is_main_site()) {
			return false;
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		$is_firewall_page = ('admin.php' == $GLOBALS['pagenow'] && isset($_GET['page']) && AIOWPSEC_FIREWALL_MENU_SLUG == $_GET['page']);
		if ($is_firewall_page) return false;

		global $aio_wp_security;

		$active_settings = $aio_wp_security->configs->get_value('aiowps_firewall_active_upgrade');

		if (empty($active_settings)) return false;

		$active_settings = json_decode($active_settings);

		if (empty($active_settings)) return false;

		return true;
	}

	/**
	 * Whether the current page is the AIOS database backup admin page
	 *
	 * @return Boolean True if the current page is the AIOS database backup admin page, otherwise false.
	 */
	private function is_database_backup_admin_page_tab() {
		return $this->is_database_security_admin_page() && $this->is_database_backup_tab();
	}

	/**
	 * Whether the current page is the database security admin page.
	 *
	 * @return Boolean True if the current page is the database security admin page, otherwise false.
	 */
	private function is_database_security_admin_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return ('admin.php' == $GLOBALS['pagenow'] && isset($_GET['page']) && 'aiowpsec_database' == $_GET['page']);
	}

	/**
	 * Whether the current tab is the database backup tab.
	 *
	 * @return Boolean True if the current tab is the database backup tab, otherwise false.
	 */
	private function is_database_backup_tab() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return (isset($_GET['tab']) && 'database-backup' == $_GET['tab']);
	}

	/**
	 * Decides whether to show the IP address detection settings notice.
	 *
	 * @return Boolean True if the IP address detection settings notice should be shown, otherwise false.
	 */
	protected function should_show_ip_retrieval_settings_notice() {
		if (!is_main_site()) {
			return false;
		}

		if ($this->is_ip_settings_admin_page_tab()) {
			return false;
		}

		if (defined('AIOS_FORCE_IP_RETRIEVAL_SETTINGS_NOTICE') && AIOS_FORCE_IP_RETRIEVAL_SETTINGS_NOTICE) {
			return true;
		}

		global $aio_wp_security;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		// Is notice dismissed.
		if ('1' == $aio_wp_security->configs->get_value('dismiss_ip_retrieval_settings_notice')) {
			return false;
		}

		$configured_ip_method_id = $aio_wp_security->configs->get_value('aiowps_ip_retrieve_method');

		if (AIOWPSecurity_Utility_IP::is_server_suitable_ip_methods_give_same_ip_address()) {
			if ('' === $configured_ip_method_id) {
				$server_suitable_ip_methods = AIOWPSecurity_Utility_IP::get_server_suitable_ip_methods();
				$most_suitable_ip_method = reset($server_suitable_ip_methods);
				if (!empty($most_suitable_ip_method)) {
					$most_suitable_ip_method_id = array_search($most_suitable_ip_method, AIOS_Abstracted_Ids::get_ip_retrieve_methods());
					$aio_wp_security->configs->set_value('aiowps_ip_retrieve_method', $most_suitable_ip_method_id);
					$aiowps_firewall_config->set_value('aios_ip_retrieve_method', $most_suitable_ip_method_id, true);
				}
			}

			return false;
		}

		// If the IP retrieval method is not set.
		$configured_ip_method_id = $aio_wp_security->configs->get_value('aiowps_ip_retrieve_method');
		if ('' === $configured_ip_method_id) {
			return true;
		}

		$server_user_ip_address = AIOS_Helper::get_server_detected_user_ip_address();
		return empty($server_user_ip_address);
	}

	/**
	 * Whether the current page is the AIOS IP retrieval admin page
	 *
	 * @return Boolean True if the current page is the AIOS database backup admin page, otherwise false.
	 */
	private function is_ip_settings_admin_page_tab() {
		return $this->is_settings_admin_page() && $this->is_advanced_settings_tab();
	}

	/**
	 * Whether the current page is the AIOS settings admin page
	 *
	 * @return Boolean True if the current page is the AIOS settings admin page, otherwise false.
	 */
	private function is_settings_admin_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return ('admin.php' == $GLOBALS['pagenow'] && isset($_GET['page']) && 'aiowpsec_settings' == $_GET['page']);
	}

	/**
	 * Whether the current tab is the advanced settings tab.
	 *
	 * @return Boolean True if the current tab is the advanced settings tab, otherwise false.
	 */
	private function is_advanced_settings_tab() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return (isset($_GET['tab']) && 'advanced-settings' == $_GET['tab']);
	}

	/**
	 * Check whether the UpdraftPlus plugin is active or not.
	 *
	 * @return bool True if the UpdraftPlus plugin is active, otherwise false.
	 */
	private function is_updraftplus_plugin_active() {
		return class_exists('UpdraftPlus');
	}

	/**
	 * Check whether the database backup scheduled in the UpdraftPlus plugin.
	 *
	 * @return bool
	 */
	private function is_schedule_database_backup_set_in_updraftplus() {
		$updraft_interval_database_option_val = get_option('updraft_interval_database', '');
		if (empty($updraft_interval_database_option_val) || 'manual' == $updraft_interval_database_option_val) {
			return false;
		}

		return true;
	}

	/**
	 * Decides whether to show the IP Blacklist settings notice.
	 *
	 * @return Boolean True if the IP Blacklist settings notice should be shown, otherwise false.
	 */
	protected function should_show_ip_blacklist_settings_on_upgrade() {
		if (!is_main_site()) {
			return false;
		}

		if ($this->is_blacklist_admin_page()) {
			return false;
		}

		global $aio_wp_security;

		if ('1' == $aio_wp_security->configs->get_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade')) {
			return true;
		}

		return false;
	}

	/**
	 * Whether the current page is the AIOS blacklist admin page
	 *
	 * @return Boolean True if the current page is the AIOS blacklist admin page, otherwise false.
	 */
	private function is_blacklist_admin_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return ('admin.php' == $GLOBALS['pagenow'] && isset($_GET['page']) && AIOWPSEC_FIREWALL_MENU_SLUG == $_GET['page'] && isset($_GET['tab']) && 'blacklist' == $_GET['tab']);
	}

	/**
	 * Decides whether to show the IP address detection settings notice.
	 *
	 * @return Boolean True if the IP address detection settings notice should be shown, otherwise false.
	 */
	protected function should_show_login_whitelist_disabled_on_upgrade_notice() {
		if (!is_main_site()) {
			return false;
		}

		if ($this->is_login_whitelist_admin_page_tab()) {
			return false;
		}

		if (defined('AIOS_FORCE_LOGIN_WHITELIST_DISABLED_ON_UPGRADE_NOTICE') && AIOS_FORCE_LOGIN_WHITELIST_DISABLED_ON_UPGRADE_NOTICE) {
			return true;
		}

		global $aio_wp_security;

		if ('1' == $aio_wp_security->configs->get_value('aiowps_is_login_whitelist_disabled_on_upgrade') && '1' != $aio_wp_security->configs->get_value('aiowps_enable_whitelisting')) {
			return true;
		}

		return false;
	}

	/**
	 * Whether the current page is the AIOS IP retrieval admin page
	 *
	 * @return Boolean True if the current page is the AIOS database backup admin page, otherwise false.
	 */
	private function is_login_whitelist_admin_page_tab() {
		return $this->is_brute_force_admin_page() && $this->is_login_whitelist_tab();
	}

	/**
	 * Whether the current page is the AIOS settings admin page
	 *
	 * @return Boolean True if the current page is the AIOS settings admin page, otherwise false.
	 */
	private function is_brute_force_admin_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return ('admin.php' == $GLOBALS['pagenow'] && isset($_GET['page']) && AIOWPSEC_BRUTE_FORCE_MENU_SLUG == $_GET['page']);
	}

	/**
	 * Whether the current tab is the advanced settings tab.
	 *
	 * @return Boolean True if the current tab is the advanced settings tab, otherwise false.
	 */
	private function is_login_whitelist_tab() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- No nonce to check.
		return (isset($_GET['tab']) && 'login-whitelist' == $_GET['tab']);
	}

	/**
	 * Call this method to setup the notices
	 */
	public function notices_init() {
		if ($this->initialized) return;
		$this->initialized = true;
		$this->notices_content = $this->populate_notices_content();

		$enqueue_version = (defined('WP_DEBUG') && WP_DEBUG) ? AIO_WP_SECURITY_VERSION.'.'.time() : AIO_WP_SECURITY_VERSION;
		wp_enqueue_style('aiowpsec-admin-notices-css',  AIO_WP_SECURITY_URL.'/css/wp-security-notices.css', array(), $enqueue_version);
	}

	/**
	 * Get AIOS Plugin installation timestamp.
	 *
	 * @return integer AIOS Plugin installation timestamp.
	 */
	public function get_aiowps_plugin_installed_timestamp() {
		$installed_at = @filemtime(AIO_WP_SECURITY_PATH.'/index.html'); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- ignore warning as we handle it below
		if (false === $installed_at) {
			global $aio_wp_security;
			$installed_at = (int) $aio_wp_security->configs->get_value('installed-at');
		}
		$installed_at = apply_filters('aiowps_plugin_installed_timestamp', $installed_at);
		return $installed_at;
	}

	/**
	 * This function will check if we should display the rate notice or not
	 *
	 * @return boolean - to indicate if we should show the notice or not
	 */
	protected function show_rate_notice() {
		$installed_at = $this->get_aiowps_plugin_installed_timestamp();
		$time_now = $this->get_time_now();
		$installed_for = $time_now - $installed_at;

		if ($installed_at && $installed_for > 28*86400) {
			return true;
		}

		return false;
	}

	/**
	 * Checks if UpdraftPlus is installed(returns false) or not(returns true).
	 *
	 * @return Boolean
	 */
	protected function updraftplus_not_installed() {
		if (!function_exists('get_plugins')) include_once(ABSPATH.'wp-admin/includes/plugin.php');
		$plugins = get_plugins();

		foreach ($plugins as $value) {
			if ('updraftplus' == $value['TextDomain']) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Checks if WP-Optimize is installed(returns false) or not(returns true).
	 *
	 * @return Boolean
	 */
	protected function wp_optimize_not_installed() {
		if (!function_exists('get_plugins')) include_once(ABSPATH.'wp-admin/includes/plugin.php');
		$plugins = get_plugins();

		foreach ($plugins as $value) {
			if ('wp-optimize' == $value['TextDomain']) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Determines whether to prepare a seasonal notice(returns true) or not(returns false).
	 *
	 * @param Array $notice_data - all data for the notice
	 *
	 * @return Boolean
	 */
	protected function skip_seasonal_notices($notice_data) {
		$time_now = $this->get_time_now();
		$valid_from = strtotime($notice_data['valid_from']);
		$valid_to = strtotime($notice_data['valid_to']);
		$dismiss = $this->check_notice_dismissed($notice_data['dismiss_time']);
		if (($time_now >= $valid_from && $time_now <= $valid_to) && !$dismiss) {
			// return true so that we return this notice to be displayed
			return true;
		}

		return false;
	}

	/**
	 * Get timestamp that is considered as current timestamp for notice.
	 *
	 * @return integer timestamp that should be consider as a current time.
	 */
	public function get_time_now() {
		$time_now = defined('AIOWPSECURITY_NOTICES_FORCE_TIME') ? AIOWPSECURITY_NOTICES_FORCE_TIME : time();
		return $time_now;
	}

	/**
	 * Checks whether a notice is dismissed(returns true) or not(returns false).
	 *
	 * @param String $dismiss_time - dismiss time id for the notice
	 *
	 * @return boolean
	 */
	protected function check_notice_dismissed($dismiss_time) {
		$time_now = $this->get_time_now();

		global $aio_wp_security;
		$dismiss = ($time_now < (int) $aio_wp_security->configs->get_value($dismiss_time));

		return $dismiss;
	}

	/**
	 * Renders or returns a notice.
	 *
	 * @param Boolean|String $advert_information     - all data for the notice
	 * @param Boolean        $return_instead_of_echo - whether to return the notice(true) or render it to the page(false)
	 * @param String         $position               - notice position
	 *
	 * @return Void|String
	 */
	protected function render_specified_notice($advert_information, $return_instead_of_echo = false, $position = 'top') {

		if ('bottom' == $position) {
			$template_file = 'bottom-notice.php';
		} elseif ('report' == $position) {
			$template_file = 'report.php';
		} elseif ('report-plain' == $position) {
			$template_file = 'report-plain.php';
		} elseif (in_array($position, AIOS_Abstracted_Ids::custom_admin_notice_ids())) {
			$template_file = 'custom-notice.php';
		} elseif (in_array($position, AIOS_Abstracted_Ids::htaccess_to_php_feature_notice_ids())) {
			$template_file = 'htaccess-to-php-feature-notice.php';
		} else {
			$template_file = 'horizontal-notice.php';
		}

		global $aio_wp_security;
		return $aio_wp_security->include_template('notices/'.$template_file, $return_instead_of_echo, $advert_information);
	}
}
