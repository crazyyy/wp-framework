<?php
if (!defined('ABSPATH') && !defined('AIOWPS_FIREWALL_DIR')) {
	exit; //Exit if accessed directly
}

/**
 * All ids and static names, array.
 */
if (class_exists('AIOS_Abstracted_Ids')) return;

class AIOS_Abstracted_Ids {

	/**
	 * Get firewall block request methods.
	 *
	 * @return array
	 */
	public static function get_firewall_block_request_methods() {
		return array('DEBUG','MOVE', 'PUT', 'TRACK');
	}

	/**
	 * Get IP retrieve methods.
	 *
	 * @return array
	 */
	public static function get_ip_retrieve_methods() {
		// The keys are merely for maintaining backward compatibility.
		return array(
			'0' => 'REMOTE_ADDR',
			'1' => 'HTTP_CF_CONNECTING_IP',
			'2' => 'HTTP_X_FORWARDED_FOR',
			'3' => 'HTTP_X_FORWARDED',
			'4' => 'HTTP_CLIENT_IP',
			'5'	=> 'HTTP_X_REAL_IP',
			'6'	=> 'HTTP_X_CLUSTER_CLIENT_IP',
		);
	}

	/**
	 * Get AIOS custom admin notice ids.
	 *
	 * @return array
	 */
	public static function custom_admin_notice_ids() {
		return array(
			'automated-database-backup',
			'ip-retrieval-settings',
			'load-firewall-resources-failed',
			'end-of-support-php-56',
		);
	}

	/**
	 * Get notice ids for notices that have transformed HTACESS rules to PHP.
	 *
	 * @return array notice ids.
	 */
	public static function htaccess_to_php_feature_notice_ids() {
		return array(
			'login-whitelist-disabled-on-upgrade',
			'ip-blacklist-settings-on-upgrade',
			'upgrade-firewall-tab-rules',
		);
	}

	/**
	 * Get locale codes that are more than 2 char long supported by Google ReCaptcha.
	 *
	 * @return array
	 */
	public static function get_google_recaptcha_locale_codes() {
		/**
		* Google reCaptcha accepts 2 char language codes and also more than 2 char language codes.
		* Most are 2 chars in length e.g. 'ar' for Arabic.
		* Few are more than 2 char in length e.g 'de-AT' for German (Austria)
		*
		* Below is the list of more than 2 char language codes supported by Google reCaptcha.
		* if determine_locale() detects any of the below we return it, otherwise,
		* we would return the 2 letter code.
		*/
		return array(
			'zh-HK', // Chinese (Hong Kong).
			'zh-CN', // Chinese (Simplified).
			'zh-TW', // Chinese (Traditional).
			'en-GB', // UK.
			'fr-CA', // French (Canadian).
			'de-AT', // German (Austria).
			'de-CH', // German (Switzerland).
			'pt-BR', // Portuguese (Brazil).
			'pt-PT', // Portuguese (Portugal).
		);
	}

	/**
	 * Get IP Lookup services.
	 *
	 * @return array
	 */
	public static function get_ip_lookup_services() {
		return array(
			'ipify'  => 'http://api.ipify.org/',
			'ipecho' => 'http://ipecho.net/plain',
			'ident'  => 'http://ident.me',
			'tnedi'	 => 'http://tnedi.me',
		);
	}

	/**
	 * Get Reverse IP Lookup services.
	 *
	 * @return array
	 */
	public static function get_reverse_ip_lookup_services() {
		return array(
			'ip-api' => 'http://ip-api.com/json/%s',
			'ipinfo' => 'https://ipinfo.io/%s/json'
		);
	}

}
