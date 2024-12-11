<?php

if (!defined('ABSPATH')) die('No direct access allowed');

if (trait_exists('AIOWPSecurity_Tools_Commands_Trait')) return;

trait AIOWPSecurity_Tools_Commands_Trait {

	/**
	 * Perform a WHOIS lookup for the provided IP address or domain.
	 *
	 * @param array $data The data containing the IP address or domain for the WHOIS lookup.
	 *                    The data should include the key 'aiowps_whois_ip_or_domain'.
	 * @return array An array containing the status of the operation and the WHOIS lookup result content.
	 *               The 'status' key indicates whether the operation was successful.
	 *               The 'content' key contains the result of the WHOIS lookup.
	 */
	public function perform_whois_lookup($data) {
		global $aio_wp_security;

		$ip_or_domain = trim(stripslashes($data['aiowps_whois_ip_or_domain']));

		$invalid_domain = false;

		if (empty($ip_or_domain)) {
			$invalid_domain = true;
		} elseif (version_compare(phpversion(), '5.6', '>')) {
			if (!(filter_var($ip_or_domain, FILTER_VALIDATE_IP) || filter_var($ip_or_domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME))) $invalid_domain = true; // phpcs:ignore PHPCompatibility.Constants.NewConstants.filter_validate_domainFound -- This code only runs on php 7.0+ so ignore the warning
		}

		if ($invalid_domain) {
			$result = __('Please enter a valid IP address or domain name to look up.', 'all-in-one-wp-security-and-firewall');
			$result .= __('Nothing to show.', 'all-in-one-wp-security-and-firewall');
		} else {
			$result = $this->whois_lookup($ip_or_domain);

			if (is_wp_error($result)) {
				$result = htmlspecialchars($result->get_error_message());
				$result .= __('Nothing to show.', 'all-in-one-wp-security-and-firewall');
			} else {
				$result = htmlspecialchars($result);
			}
		}

		$args = array(
			'content' => array('aios-who-is-lookup-result-container' => $aio_wp_security->include_template('wp-admin/tools/partials/who-is-lookup-result.php', true, array('result' => $result, 'ip_or_domain' => $ip_or_domain)))
		);

		return $this->handle_response(true, false, $args);
	}

	/**
	 * Store custom .htaccess settings provided by the user.
	 *
	 * @param array $data The data containing the custom .htaccess settings.
	 *                    It should include keys 'aiowps_enable_custom_rules', 'aiowps_custom_rules',
	 *                    and 'aiowps_place_custom_rules_at_top' if applicable.
	 * @return array An array containing the status of the operation and any relevant messages.
	 *               The 'status' key indicates whether the operation was successful.
	 *               The 'message' key contains any informational or error messages.
	 */
	public function perform_store_custom_htaccess_settings($data) {
		global $aio_wp_security;

		$success = true;
		$message = '';

		$options = array();
		// Save settings
		if (isset($data["aiowps_enable_custom_rules"]) && empty($data['aiowps_custom_rules'])) {
			$message = __('You must enter some .htaccess directives in the text box below', 'all-in-one-wp-security-and-firewall');
			return $this->handle_response(false, $message);
		} else {
			if (!empty($data['aiowps_custom_rules'])) {
				// Sanitize textarea shoud not be used as <filesMatch "\.(js|css|html)$"> etc rules gets removed.
				// Escape textarea should not be used the & becomes &amp;.
				// Here stripslashes as old version 5.3.0 not required, AIOWPSecurity_Ajax::set_data applies wp_unslash for ajax data.
				// So the .htacces rule having index\.php backslashes removed if used stripslashes below.
				$options['aiowps_custom_rules'] = $data['aiowps_custom_rules'];
			} else {
				$options['aiowps_custom_rules'] = ''; //Clear the custom rules config value
			}

			$aiowps_custom_rules = $aio_wp_security->configs->get_value('aiowps_custom_rules');
			$aiowps_place_custom_rules_at_top = $aio_wp_security->configs->get_value('aiowps_place_custom_rules_at_top');

			$options['aiowps_enable_custom_rules'] = isset($data["aiowps_enable_custom_rules"]) ? '1' : '';
			$options['aiowps_place_custom_rules_at_top'] = isset($data["aiowps_place_custom_rules_at_top"]) ? '1' : '';
			$this->save_settings($options); // Save the configuration

			$write_result = AIOWPSecurity_Utility_Htaccess::write_to_htaccess(); //now let's write to the .htaccess file
			if (!$write_result) {
				$options['aiowps_enable_custom_rules'] = $aiowps_custom_rules;
				$options['aiowps_place_custom_rules_at_top'] = $aiowps_place_custom_rules_at_top;

				$this->save_settings($options);

				$success = false;
				$message = __('The plugin was unable to write to the .htaccess file, please edit file manually.', 'all-in-one-wp-security-and-firewall');
				$aio_wp_security->debug_logger->log_debug("Custom Rules feature - The plugin was unable to write to the .htaccess file.");
			}
		}

		return $this->handle_response($success, $message);
	}

	/**
	 * Perform the general visitor lockout settings operation.
	 *
	 * @param array $data The data containing the general visitor lockout settings.
	 *                    It should include keys 'aiowps_site_lockout' and 'aiowps_site_lockout_msg'.
	 * @return array An array containing the status of the operation and any relevant messages.
	 *               The 'status' key indicates whether the operation was successful.
	 *               The 'message' key contains an informational message about the outcome of the operation.
	 */
	public function perform_general_visitor_lockout($data) {
		$options = array();

		// Save settings
		$options['aiowps_site_lockout'] = isset($data["aiowps_site_lockout"]) ? '1' : '';
		$maint_msg = wp_kses_post(wp_unslash($data['aiowps_site_lockout_msg']));
		$options['aiowps_site_lockout_msg'] = $maint_msg; // Text area/msg box
		$this->save_settings($options);

		do_action('aiowps_site_lockout_settings_saved'); // Trigger action hook.

		return $this->handle_response(true);
	}

	/**
	 * Does a WHOIS lookup on an IP address or domain name and then returns the result.
	 *
	 * @param String  $search  - IP address or domain name to do a WHOIS lookup on
	 * @param Integer $timeout - connection timeout for fsockopen
	 *
	 * @return String|WP_Error - returns preformatted WHOIS lookup result or WP_Error
	 */
	private function whois_lookup($search, $timeout = 10) {
		$fp = @fsockopen('whois.iana.org', 43, $errno, $errstr, $timeout);

		if (!$fp) {
			return new WP_Error('whois_lookup_failed', 'whois.iana.org: Socket Error '.$errno.' - '.$errstr);
		}

		$queries = sprintf(__('Querying %s: %s', 'all-in-one-wp-security-and-firewall'), 'whois.iana.org', $search)."\n";

		fputs($fp, $search."\r\n");
		$out = '';
		while (!feof($fp)) {
			$line = fgets($fp);
			if (preg_match('/refer: +(\S+)/', $line, $matches)) {
				$referral_server = $matches[1];
				$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
				break;
			}
			$out .= $line;
		}
		fclose($fp);

		if (!isset($referral_server) && filter_var($search, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) && preg_match('/whois: +(\S+)/', $out, $matches)) {
			$referral_server = $matches[1];
			$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
		}

		$referrals = array();

		while (isset($referral_server)) {
			$referrals[] = $referral_server;

			$fp = @fsockopen($referral_server, 43, $errno, $errstr, $timeout);

			if (!$fp) {
				return new WP_Error('whois_lookup_failed', $referral_server.': Socket Error '.$errno.' - '.$errstr);
			}

			if ('whois.arin.net' == $referral_server) {
				$formatted_search = 'n + '.$search;
			} elseif ('whois.denic.de' == $referral_server) {
				$formatted_search = '-T dn,ace '.$search;
			} elseif ('whois.dk-hostmaster.dk' == $referral_server) {
				$formatted_search = '--charset=utf-8 --show-handles '.$search;
			} elseif ('whois.nic.ad.jp' == $referral_server || 'whois.jprs.jp' == $referral_server) {
				$formatted_search = $search.'/e';
			} else {
				$formatted_search = $search;
			}

			$queries .= sprintf(__('Querying %s: %s', 'all-in-one-wp-security-and-firewall'), $referral_server, $formatted_search)."\n";

			$referral_server = null;

			fputs($fp, $formatted_search."\r\n");
			$out = '';
			while (!feof($fp)) {
				$line = fgets($fp);
				if (preg_match('/Registrar WHOIS Server: +(\S+)/', $line, $matches)
					|| preg_match('/% referto: +whois -h (\S+)/', $line, $matches)
					|| preg_match('/% referto: +(\S+)/', $line, $matches)
					|| preg_match('/ReferralServer: +rwhois:\/\/(\S+)/', $line, $matches)
					|| preg_match('/ReferralServer: +whois:\/\/(\S+)/', $line, $matches)
				) {
					if (!in_array($matches[1], $referrals)) {
						$referral_server = $matches[1];
						$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
						break;
					}
				}
				$out .= $line;
			}
			fclose($fp);
		}

		return $queries."\n".$out;
	}
}
