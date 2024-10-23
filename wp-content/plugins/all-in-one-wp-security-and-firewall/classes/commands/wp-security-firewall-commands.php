<?php

use AIOWPS\Firewall\Allow_List;

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Firewall_Commands_Trait')) return;

trait AIOWPSecurity_Firewall_Commands_Trait {

	/**
	 * Perform saving php firewall settings
	 *
	 * @param array $data - the request data contains PHP settings
	 *
	 * @return array - containing a status and message
	 */
	public function perform_php_firewall_settings($data) {
		global $aio_wp_security, $aiowps_firewall_config;

		$response = array(
			'status' => 'success',
		);

		$options = array();

		// Save settings
		$aiowps_firewall_config->set_value('aiowps_enable_pingback_firewall', isset($data["aiowps_enable_pingback_firewall"]));
		$options['aiowps_disable_xmlrpc_pingback_methods'] = isset($data["aiowps_disable_xmlrpc_pingback_methods"]) ? '1' : ''; //this disables only pingback methods of xmlrpc but leaves other methods so that Jetpack and other apps will still work
		$options['aiowps_disable_rss_and_atom_feeds'] = isset($data['aiowps_disable_rss_and_atom_feeds']) ? '1' : '';
		$aiowps_firewall_config->set_value('aiowps_forbid_proxy_comments', isset($data['aiowps_forbid_proxy_comments']));
		$aiowps_firewall_config->set_value('aiowps_deny_bad_query_strings', isset($data['aiowps_deny_bad_query_strings']));
		$aiowps_firewall_config->set_value('aiowps_advanced_char_string_filter', isset($data['aiowps_advanced_char_string_filter']));


		// Commit the config settings
		$this->save_settings($options);

		$features = array(
			'firewall-pingback-rules',
			'firewall-disable-rss-and-atom',
			'firewall-forbid-proxy-comments',
			'firewall-deny-bad-queries',
			'firewall-advanced-character-string-filter',
		);

		$response['badges'] = $this->get_features_id_and_html($features);
		$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');
		$response['xmlprc_warning'] = $aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-warning-notice.php', true);

		return $response;
	}

	/**
	 * Perform saving .htaccess firewall settings
	 *
	 * @param array $data - the request data contains the firewall settings
	 *
	 * @return array - containing a status and message
	 */
	public function perform_htaccess_firewall_settings($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success',
			'info' => array(),
		);

		$options = array();

		// Max file upload size in basic rules
		$upload_size = absint($data['aiowps_max_file_upload_size']);

		$max_allowed = apply_filters('aiowps_max_allowed_upload_config', 250); // Set a filterable limit of 250MB
		$max_allowed = absint($max_allowed);

		if ($upload_size > $max_allowed) {
			$upload_size = $max_allowed;
		} elseif (empty($upload_size) || 0 > $upload_size) {
			$upload_size = AIOS_FIREWALL_MAX_FILE_UPLOAD_LIMIT_MB;
			$response['info'][] = __('Max file upload limit was set to default value, because you entered a negative or zero value');
		}

		// Store the current value in case the .htaccess write operation fails and we need to revert it
		$original_options = array(
			'aiowps_enable_basic_firewall' => $aio_wp_security->configs->get_value("aiowps_enable_basic_firewall"),
			'aiowps_max_file_upload_size' => $aio_wp_security->configs->get_value('aiowps_max_file_upload_size'),
			'aiowps_block_debug_log_file_access' => $aio_wp_security->configs->get_value("aiowps_block_debug_log_file_access"),
			'aiowps_disable_index_views' => $aio_wp_security->configs->get_value('aiowps_disable_index_views'),
			'aiowps_disable_trace_and_track' => $aio_wp_security->configs->get_value('aiowps_disable_trace_and_track')
		);


		// Save settings
		$options['aiowps_enable_basic_firewall'] = isset($data["aiowps_enable_basic_firewall"]) ? '1' : '';
		$options['aiowps_max_file_upload_size'] = $upload_size;
		$options['aiowps_block_debug_log_file_access'] = isset($data["aiowps_block_debug_log_file_access"]) ? '1' : '';
		$options['aiowps_disable_index_views'] = isset($data['aiowps_disable_index_views']) ? '1' : '';
		$options['aiowps_disable_trace_and_track'] = isset($data['aiowps_disable_trace_and_track']) ? '1' : '';

		// Commit the config settings
		$this->save_settings($options);

		//Now let's write the applicable rules to the .htaccess file
		$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();

		if ($res) {
			$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');
		} else {
			$response['status'] = 'error';
			$response['message'] = __('Could not write to the .htaccess file', 'all-in-one-wp-security-and-firewall');

			$this->save_settings($original_options);
		}

		$features = array(
			'firewall-basic-rules',
			'firewall-block-debug-file-access',
			'firewall-disable-index-views',
			'firewall-disable-trace-track',
		);

		$response['badges'] = $this->get_features_id_and_html($features);
		$response['values'] = array('aiowps_max_file_upload_size' => $upload_size);

		return $response;
	}

	/**
	 * Perform saving blacklist settings
	 *
	 * @param array $data - the request data contains blacklist settings
	 *
	 * @return array - containing a status, message and feature badge html
	 */
	public function perform_save_blacklist_settings($data) {
		global $aio_wp_security, $aiowps_firewall_config;
		$response = array(
			'status' => 'success',
		);
		$options = array();

		$result = 1;
		$aiowps_enable_blacklisting = isset($data["aiowps_enable_blacklisting"]) ? '1' : '';

		if (!empty($data['aiowps_banned_ip_addresses'])) {
			$ip_addresses = sanitize_textarea_field(stripslashes($data['aiowps_banned_ip_addresses']));
			$ip_list_array = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ip_addresses);
			$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ip_list_array, 'blacklist');
			if (is_wp_error($validated_ip_list_array)) {
				$result = -1;
				$response['status'] = 'error';
				$response['message'] = nl2br($validated_ip_list_array->get_error_message());
			} else {
				$banned_ip_addresses_list = preg_split('/\R/', $aio_wp_security->configs->get_value('aiowps_banned_ip_addresses')); // Historical settings where the separator may have depended on PHP_EOL.
				if ($banned_ip_addresses_list !== $validated_ip_list_array) {
					$banned_ip_data = implode("\n", $validated_ip_list_array);
					$options['aiowps_banned_ip_addresses'] = $banned_ip_data;
					$aiowps_firewall_config->set_value('aiowps_blacklist_ips', $validated_ip_list_array);
				}
				$data['aiowps_banned_ip_addresses'] = ''; // Clear the post variable for the banned address list.
			}
		} else {
			$options['aiowps_banned_ip_addresses'] = ''; // Clear the IP address config value
			$aiowps_firewall_config->set_value('aiowps_blacklist_ips', array());
		}

		if (!empty($data['aiowps_banned_user_agents'])) {
			$this->validate_user_agent_list(stripslashes($data['aiowps_banned_user_agents']));
		} else {
			// Clear the user agent list
			$options['aiowps_banned_user_agents'] = '';
			$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', array());
		}

		if (1 == $result) {
			$aio_wp_security->configs->set_value('aiowps_enable_blacklisting', $aiowps_enable_blacklisting, true);
			if ('1' == $aio_wp_security->configs->get_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade')) {
				$aio_wp_security->configs->delete_value('aiowps_is_ip_blacklist_settings_notice_on_upgrade');
			}

			$response['message'] = __('The settings have been successfully updated.', 'all-in-one-wp-security-and-firewall');
			$response['badges'] = $this->get_features_id_and_html(array("blacklist-manager-ip-user-agent-blacklisting"));
		}

		$this->save_settings($options);

		return $response;
	}

	/**
	 * Perform saving wp rest api settings
	 *
	 * @param array $data - the request data array
	 *
	 * @return array - containing a status, message and feature badge html
	 */
	public function perform_save_wp_rest_api_settings($data) {
		global $aio_wp_security;

		$response = array(
			'status' => 'success',
		);

		// Save settings
		$aio_wp_security->configs->set_value('aiowps_disallow_unauthorized_rest_requests', isset($data["aiowps_disallow_unauthorized_rest_requests"]) ? '1' : '', true);

		$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');

		$response['badges'] = $this->get_features_id_and_html(array("disallow-unauthorised-requests"));

		return $response;
	}

	/**
	 * Perform saving internet bot settings
	 *
	 * @param array $data - the request data contains the internet bot settings to be updated
	 *
	 * @return array - containing a status and message
	 */
	public function perform_internet_bot_settings($data) {
		global $aiowps_firewall_config;
		$response = array(
			'status' => 'success'
		);

		$error = false;

		if (isset($data['aiowps_block_fake_googlebots'])) {
			$validated_ip_list_array = AIOWPSecurity_Utility::get_googlebot_ip_ranges();

			if (is_wp_error($validated_ip_list_array)) {
				$response['message'] = __('The attempt to save the \'Block fake Googlebots\' settings failed, because it was not possible to validate the Googlebot IP addresses:', 'all-in-one-wp-security-and-firewall') . ' ' . $validated_ip_list_array->get_error_message();
				$response['status'] = 'error';
				$error = true;
			} else {
				$aiowps_firewall_config->set_value('aiowps_block_fake_googlebots', true);
				$aiowps_firewall_config->set_value('aiowps_googlebot_ip_ranges', $validated_ip_list_array);
			}
		} else {
			$aiowps_firewall_config->set_value('aiowps_block_fake_googlebots', false);
		}

		$aiowps_firewall_config->set_value('aiowps_ban_post_blank_headers', isset($data['aiowps_ban_post_blank_headers']));

		if (!$error) {
			$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');
		}

		$featues = array(
			"firewall-block-fake-googlebots",
			"firewall-ban-post-blank-headers",
		);

		$response['badges'] = $this->get_features_id_and_html($featues);

		return $response;
	}

	/**
	 * Perform saving xG firewall settings
	 *
	 * @param array $data - the request data contains firewall settings to be updated
	 *
	 * @return array - containing a status and message
	 */
	public function perform_xG_firewall_settings($data) {
		global $aio_wp_security, $aiowps_firewall_config;

		$response = array(
			'status' => 'success',
			'content' => array()
		);
		$options = array();

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
			$options['aiowps_enable_6g_firewall'] = '1';
		}

		//Save 6G/5G

		// If the user has changed the 5G firewall checkbox settings, then there is a need to write htaccess rules again.
		$is_5G_firewall_option_changed = ((isset($data['aiowps_enable_5g_firewall']) && '1' != $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')) || (!isset($data['aiowps_enable_5g_firewall']) && '1' == $aio_wp_security->configs->get_value('aiowps_enable_5g_firewall')));

		// Save settings
		$options['aiowps_enable_5g_firewall'] = isset($data['aiowps_enable_5g_firewall']) ? '1' : '';

		$res = true;

		if ($is_5G_firewall_option_changed) {
			$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess(); // let's write the applicable rules to the .htaccess file
		}
		if (isset($data['aiowps_enable_6g_firewall'])) {
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
					if (isset($data['aiowps_block_request_method_'.$block_request_method])) {
						$methods[] = strtoupper($block_request_method);
					}
				}

				$aiowps_firewall_config->set_value('aiowps_6g_block_request_methods', $methods);
				$aiowps_firewall_config->set_value('aiowps_6g_block_query', isset($data['aiowps_block_query']));
				$aiowps_firewall_config->set_value('aiowps_6g_block_request', isset($data['aiowps_block_request']));
				$aiowps_firewall_config->set_value('aiowps_6g_block_referrers', isset($data['aiowps_block_refs']));
				$aiowps_firewall_config->set_value('aiowps_6g_block_agents', isset($data['aiowps_block_agents']));
			}

			$options['aiowps_enable_6g_firewall'] = '1';

			//shows the success notice
		} else {
			AIOWPSecurity_Configure_Settings::turn_off_all_6g_firewall_configs();
			$options['aiowps_enable_6g_firewall'] = '';
		}

		// Commit the config settings
		$this->save_settings($options);

		if ($res) {
			$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');

			$block_request_methods = array_map('strtolower', AIOS_Abstracted_Ids::get_firewall_block_request_methods());
			$methods = $aiowps_firewall_config->get_value('aiowps_6g_block_request_methods');
			if (empty($methods)) {
				$methods = array();
			}

			$blocked_query     = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_query');
			$blocked_request   = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_request');
			$blocked_referrers = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_referrers');
			$blocked_agents    = (bool) $aiowps_firewall_config->get_value('aiowps_6g_block_agents');
			$response['content']['aios-6g-firewall-settings-container .aios-advanced-options-panel'] = $aio_wp_security->include_template('wp-admin/firewall/partials/advanced-settings-6g.php', true, compact('methods', 'blocked_query', 'blocked_request', 'blocked_referrers', 'blocked_agents', 'block_request_methods'));
		} else {
			$response['status'] = 'error';
			$response['message'] = __('Could not write to the .htaccess file, please check the file permissions.', 'all-in-one-wp-security-and-firewall');
		}

		$response['badges'] = $this->get_features_id_and_html(array('firewall-enable-6g'));

		return $response;
	}

	/**
	 * The AJAX function for storing ips in firewall allowlist
	 *
	 * @param array $data - the request data contains data to updated
	 *
	 * @return array - containing a status and message
	 */
	public function perform_firewall_allowlist($data) {

		$response = array(
			'status' => 'success',
		);

		$allowlist = $data['aios_firewall_allowlist'];

		if (empty($allowlist)) {
			$response['status'] = 'error';
			$response['message'] = __("You must submit at least one IP address.", 'all-in-one-wp-security-and-firewall');
			return $response;
		}

		$ips = sanitize_textarea_field(wp_unslash($allowlist));
		$ips = AIOWPSecurity_Utility_IP::create_ip_list_array_from_string_with_newline($ips);
		$validated_ip_list_array = AIOWPSecurity_Utility_IP::validate_ip_list($ips, 'firewall_allowlist');

		if (is_wp_error($validated_ip_list_array)) {
			$response['status'] = 'error';
			$response['message'] = nl2br($validated_ip_list_array->get_error_message());
		} else {
			Allow_List::add_ips($validated_ip_list_array);
			$response['message'] = __('The settings were successfully updated.', 'all-in-one-wp-security-and-firewall');
		}

		return $response;
	}

	/**
	 * Perform the setup process for the firewall.
	 *
	 * This function handles the setup form for the firewall and renders notices accordingly.
	 *
	 * @return array An array containing the content and message for the response.
	 */
	public function perform_setup_firewall() {
		global $aio_wp_security;

		$firewall_setup = AIOWPSecurity_Firewall_Setup_Notice::get_instance();
		$content = array('aiowps-firewall-status-container' => $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-set-up-button.php', true));

		$firewall_setup->do_setup();
		ob_start();
		$firewall_setup->render_notices();
		$message = ob_get_clean();


		$response = array(
			'content' => $content,
			'info_box' => $message
		);

		if (AIOWPSecurity_Utility_Firewall::is_firewall_setup()) {
			$content['aiowps-firewall-status-container'] = $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-downgrade-button.php', true);
			$response['message'] = __('Firewall has been setup successfully.', 'all-in-one-wp-security-and-firewall');
			$response['content'] = $content;
		}

		return $response;
	}

	/**
	 * Perform the downgrade process for the firewall.
	 *
	 * This function removes the firewall and returns a response indicating success.
	 *
	 * @return array An array containing the status, content, and message for the response.
	 */
	public function perform_downgrade_firewall() {
		global $aio_wp_security;

		AIOWPSecurity_Utility_Firewall::remove_firewall();

		return array(
			'status' => 'success',
			'content' => array('aiowps-firewall-status-container' => AIOWPSecurity_Utility_Firewall::is_firewall_setup() ? $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-downgrade-button.php', true) : $aio_wp_security->include_template('wp-admin/firewall/partials/firewall-set-up-button.php', true)),
			'info_box' => $aio_wp_security->include_template('notices/firewall-setup-notice.php', true, array('show_dismiss' => false)),
			'message' => __('Firewall has been downgraded successfully.', 'all-in-one-wp-security-and-firewall')
		);
	}


	/**
	 * Validates posted user agent list and set, save as config.
	 *
	 * @param string $banned_user_agents - List of banned user agents
	 *
	 * @return void
	 */
	private function validate_user_agent_list($banned_user_agents) {
		global $aiowps_firewall_config;
		$submitted_agents = AIOWPSecurity_Utility::splitby_newline_trim_filter_empty($banned_user_agents);
		$agents = array_unique(
			array_filter(
				array_map(
					'sanitize_text_field',
					$submitted_agents
				),
				'strlen'
			)
		);
		$aiowps_firewall_config->set_value('aiowps_blacklist_user_agents', $agents);
		$this->save_settings(array(
			'aiowps_banned_user_agents' => implode("\n", $agents)
		));
	}
}
