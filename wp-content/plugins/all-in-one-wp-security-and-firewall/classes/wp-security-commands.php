<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (class_exists('AIOWPSecurity_Commands')) return;

if (!trait_exists('AIOWPSecurity_Log_Commands_Trait')) require_once(AIO_WP_SECURITY_PATH.'/classes/commands/wp-security-log-commands.php');
if (!trait_exists('AIOWPSecurity_Ip_Commands_Trait')) require_once(AIO_WP_SECURITY_PATH.'/classes/commands/wp-security-ip-commands.php');
class AIOWPSecurity_Commands {

	use AIOWPSecurity_Log_Commands_Trait;
	use AIOWPSecurity_Ip_Commands_Trait;
	/**
	 * Get IP address of given method.
	 *
	 * @param array $data - the request data
	 *
	 * @return array|WP_Error - an array response or a WP_Error if there was an error
	 */
	public function get_ip_address_of_given_method($data) {
		$ip_method_id = $data['ip_retrieve_method'];
		$ip_retrieve_methods = AIOS_Abstracted_Ids::get_ip_retrieve_methods();
		if (isset($ip_retrieve_methods[$ip_method_id])) {
			return array(
				'ip_address' => isset($_SERVER[$ip_retrieve_methods[$ip_method_id]]) ? $_SERVER[$ip_retrieve_methods[$ip_method_id]] : '',
			);
		} else {
			return new WP_Error('aios-invalid-ip-retrieve-method', __('Invalid IP retrieve method.', 'all-in-one-wp-security-and-firewall'));
		}
		die;
	}

	/**
	 * Dismiss a notice
	 *
	 * @param array $data - the request data contains the notice to dismiss
	 *
	 * @return array
	 */
	public function dismiss_notice($data) {
		global $aio_wp_security;

		$time_now = $aio_wp_security->notices->get_time_now();
		
		if (in_array($data['notice'], array('dismissdashnotice', 'dismiss_season'))) {
			$aio_wp_security->configs->set_value($data['notice'], $time_now + (366 * 86400));
		} elseif (in_array($data['notice'], array('dismiss_page_notice_until', 'dismiss_notice'))) {
			$aio_wp_security->configs->set_value($data['notice'], $time_now + (84 * 86400));
		} elseif ('dismiss_review_notice' == $data['notice']) {
			if (empty($data['dismiss_forever'])) {
				$aio_wp_security->configs->set_value($data['notice'], $time_now + (84 * 86400));
			} else {
				$aio_wp_security->configs->set_value($data['notice'], $time_now + (100 * 365.25 * 86400));
			}
		} elseif ('dismiss_automated_database_backup_notice' == $data['notice']) {
			$aio_wp_security->delete_automated_backup_configs();
		} elseif ('dismiss_ip_retrieval_settings_notice' == $data['notice']) {
			$aio_wp_security->configs->set_value($data['notice'], 1);
		} elseif ('dismiss_ip_retrieval_settings_notice' == $data['notice']) {
			$aio_wp_security->configs->set_value('aiowps_is_login_whitelist_disabled_on_upgrade', 1);
		} elseif ('dismiss_login_whitelist_disabled_on_upgrade_notice' == $data['notice']) {
			if (isset($data['turn_it_back_on']) && '1' == $data['turn_it_back_on']) {
				$aio_wp_security->configs->set_value('aiowps_enable_whitelisting', '1');
			}
			$aio_wp_security->configs->delete_value('aiowps_is_login_whitelist_disabled_on_upgrade');
		} elseif ('dismiss_ip_blacklist_notice' == $data['notice']) {
			if (isset($data['turn_it_back_on']) && '1' == $data['turn_it_back_on']) {
				$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', '1');
				AIOWPSecurity_Configure_Settings::set_blacklist_ip_firewall_configs();
				AIOWPSecurity_Configure_Settings::set_user_agent_firewall_configs();
			}
			$aio_wp_security->configs->delete_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade');
		} elseif ('dismiss_firewall_settings_disabled_on_upgrade_notice' == $data['notice']) {
			$is_reactivated = (isset($data['turn_it_back_on']) && '1' == $data['turn_it_back_on']);
				if ($is_reactivated) {
					global $aiowps_firewall_config;
					$active_settings = $aio_wp_security->configs->get_value('aiowps_firewall_active_upgrade');
	
					if (!empty($active_settings)) {
						$active_settings = json_decode($active_settings);
						if (!empty($active_settings)) {
							foreach ($active_settings as $setting) {
								$aiowps_firewall_config->set_value($setting, true);
							}
						}
					}
				}

				$aio_wp_security->configs->delete_value('aiowps_firewall_active_upgrade');
		}
		

		$aio_wp_security->configs->save_config();
		
		return array();
	}

	/**
	 * Gets the last file scan result and returns the scan result HTML template
	 *
	 * @param array $data - the request data
	 *
	 * @return array
	 */
	public function get_last_scan_results($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success',
			'messages' => array(),
			'data' => array(),
			'content' => array(),
		);

		if ($data['reset_change_detected']) $aio_wp_security->configs->set_value('aiowps_fcds_change_detected', false, true);

		$fcd_data = AIOWPSecurity_Scan::get_fcd_data();

		if (!$fcd_data || !isset($fcd_data['last_scan_result'])) {
			// no fcd data found
			$response['messages'][] = __('No previous scan data was found; either run a manual scan or schedule regular file scans', 'all-in-one-wp-security-and-firewall');
			return $response;
		}

		$response['content'] = $aio_wp_security->include_template('wp-admin/scanner/scan-result.php', true, array('fcd_data' => $fcd_data));

		return $response;
	}

	/**
	 * Performs a file scan and returns the scan result
	 *
	 * @return array
	 */
	public function perform_file_scan() {
		global $aio_wp_security;

		$response = array(
			'status' => 'success',
			'messages' => array(),
			'data' => array(),
			'content' => array(),
		);

		$result = $aio_wp_security->scan_obj->execute_file_change_detection_scan();

		if (false === $result) {
			// error case
			$response['messages'][] = __('There was an error during the file change detection scan.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Please check the plugin debug logs.', 'all-in-one-wp-security-and-firewall');
		}
		
		// If this is first scan display special message
		if (1 == $result['initial_scan']) {
			$response['messages'][] = __('This is your first file change detection scan.', 'all-in-one-wp-security-and-firewall').' '.__('The details from this scan will be used for future scans.', 'all-in-one-wp-security-and-firewall'). ' <a href="#" class="aiowps_view_last_fcd_results">' . __('View the file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
			$response['content']['last_scan'] = '<a href="#" class="aiowps_view_last_fcd_results">' . __('View last file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
		} elseif (!$aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
			$response['messages'][] = __('The scan is complete - There were no file changes detected.', 'all-in-one-wp-security-and-firewall');
		} elseif ($aio_wp_security->configs->get_value('aiowps_fcds_change_detected')) {
			$response['messages'][] = __('The scan has detected that there was a change in your website\'s files.', 'all-in-one-wp-security-and-firewall'). ' <a href="#" class="aiowps_view_last_fcd_results">' . __('View the file scan results', 'all-in-one-wp-security-and-firewall') . '</a>';
		}

		return $response;
	}

	/**
	 * This is a helper function to save settings options using key/value pairs
	 *
	 * @param array $options  - An array of options to save to the config
	 * @param null  $callback - A callback function to call when the options are saved
	 *
	 * @return bool
	 */
	public function save_settings($options, $callback = null) {
		global $aio_wp_security;

		foreach ($options as $key => $value) {
			$aio_wp_security->configs->set_value($key, $value);
		}
		//commit the config changes
		$aio_wp_security->configs->save_config();

		if (is_callable($callback)) {
			call_user_func($callback, $options);
		}
		return true;
	}

	/**
	 * This is a helper function to get the output feature details badge
	 *
	 * @param string $feature_id - the id of the feature we want to get the badge for
	 *
	 * @return string
	 */
	public function get_feature_details_badge($feature_id) {
		ob_start();
		$aiowps_feature_mgr = new AIOWPSecurity_Feature_Item_Manager();
		//Recalculate points after the feature status/options have been altered
		$aiowps_feature_mgr->check_feature_status_and_recalculate_points();
		$aiowps_feature_mgr->output_feature_details_badge($feature_id);
		return ob_get_clean();
	}
}
