<?php
namespace AIOWPS\Firewall;

/**
 * Rule that uses a cookie to prevent bruteforce attacks.
 */
class Rule_Cookie_Prevent_Bruteforce extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Redirect_and_Exit_Trait;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		// Set the rule's metadata
		$this->name     = 'Cookie based prevent bruteforce';
		$this->family   = 'Bruteforce';
		$this->priority = 0;
	}

	/**
	 * Determines whether the rule is active
	 *
	 * @return boolean
	 */
	public function is_active() {
		global $aiowps_firewall_config, $aiowps_firewall_constants;
		if ($aiowps_firewall_constants->AIOS_DISABLE_COOKIE_BRUTE_FORCE_PREVENTION) {
			return false;
		} else {
			return (bool) $aiowps_firewall_config->get_value('aios_enable_brute_force_attack_prevention');
		}
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		global $aiowps_firewall_config;
		/**
		 * This rule is not applied at AIOS plugin activation time.
		 */
		$is_plugins_page = isset($_SERVER['SCRIPT_FILENAME']) && 1 === preg_match('#/wp-admin/(network/)?plugins\.php$#i', $_SERVER['SCRIPT_FILENAME']);
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. A nonce is not available at this point.
		$is_activation_action = isset($_GET['action']) && 'activate' === $_GET['action'];
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. A nonce is not available at this point.
		$is_target_plugin = isset($_GET['plugin']) && 'all-in-one-wp-security-and-firewall/wp-security.php' === $_GET['plugin'];
		

		if ($is_plugins_page && $is_activation_action && $is_target_plugin) {
			return Rule::NOT_SATISFIED;
		}

		$brute_force_secret_word = $aiowps_firewall_config->get_value('aios_brute_force_secret_word');
		$brute_force_secret_cookie_name = $aiowps_firewall_config->get_value('aios_brute_force_secret_cookie_name');
		$login_page_slug = $aiowps_firewall_config->get_value('aios_login_page_slug');
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. A nonce is not available at this point.
		if (!isset($_GET[$brute_force_secret_word])) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing is not required, as we validate the raw input.
			$brute_force_secret_cookie_val = isset($_COOKIE[$brute_force_secret_cookie_name]) ? $_COOKIE[$brute_force_secret_cookie_name] : '';
			$pw_protected_exception = $aiowps_firewall_config->get_value('aios_brute_force_attack_prevention_pw_protected_exception');
			$prevent_ajax_exception = $aiowps_firewall_config->get_value('aios_brute_force_attack_prevention_ajax_exception');

			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing is not required, as we validate the raw input.
			if (!empty($_SERVER['REQUEST_URI']) && !hash_equals($brute_force_secret_cookie_val, \AIOS_Helper::get_hash($brute_force_secret_word))) {

				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing is not required, as we validate the raw input.
				$request_uri = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

				// admin section or login page or login custom slug called
				$is_admin_or_login = (false != strpos($request_uri, 'wp-admin') || false != strpos($request_uri, 'wp-login') || ('' != $login_page_slug && false != strpos($request_uri, $login_page_slug))) ? 1 : 0;
				
				// admin side ajax called
				$is_admin_ajax_request = ('1' == $prevent_ajax_exception && isset($_SERVER['SCRIPT_NAME']) && ('admin-ajax.php' === basename($_SERVER['SCRIPT_NAME']))) ? 1 : 0;
				
				// password protected page called
				$is_password_protected_access = ('1' == $pw_protected_exception && isset($_GET['action']) && 'postpass' == $_GET['action']) ? 1 : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. A nonce is not available at this point.
				
				// logout, set password, reset password  action called
				$is_logout_resetpassword_action = (isset($_GET['action']) && ('logout' == $_GET['action'] || 'rp' == $_GET['action'] || 'resetpass' == $_GET['action'])) ? 1 : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- PCP warning. A nonce is not available at this point.
				
				// cookie based brute force on and accessing admin without ajax and password protected then redirect
				if ($is_admin_or_login && !$is_admin_ajax_request && !$is_password_protected_access && !$is_logout_resetpassword_action) {
					$redirect_url = $aiowps_firewall_config->get_value('aios_cookie_based_brute_force_redirect_url');
					$this->location = $redirect_url;
					return Rule::SATISFIED;
				}
			}
		}
		return Rule::NOT_SATISFIED;
	}

}
