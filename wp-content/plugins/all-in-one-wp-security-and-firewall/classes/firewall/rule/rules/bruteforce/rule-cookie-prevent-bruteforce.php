<?php
namespace AIOWPS\Firewall;

/**
 * Rule that prevents cookie based bruteforce
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
		global $aiowps_firewall_config, $aiowps_constants;
		if ($aiowps_constants->AIOS_DISABLE_COOKIE_BRUTE_FORCE_PREVENTION) {
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
		$brute_force_secret_word = $aiowps_firewall_config->get_value('aios_brute_force_secret_word');
		$brute_force_secret_cookie_name = $aiowps_firewall_config->get_value('aios_brute_force_secret_cookie_name');
		$brute_force_cookie_salt = $aiowps_firewall_config->get_value('aios_brute_force_cookie_salt');
		$login_page_slug = $aiowps_firewall_config->get_value('aios_login_page_slug');
		if (!isset($_GET[$brute_force_secret_word])) {
			$brute_force_secret_cookie_val = isset($_COOKIE[$brute_force_secret_cookie_name]) ? $_COOKIE[$brute_force_secret_cookie_name] : '';
			$pw_protected_exception = $aiowps_firewall_config->get_value('aios_brute_force_attack_prevention_pw_protected_exception');
			$prevent_ajax_exception = $aiowps_firewall_config->get_value('aios_brute_force_attack_prevention_ajax_exception');
			
			if (isset($_SERVER['REQUEST_URI']) && '' != $_SERVER['REQUEST_URI'] && !hash_equals($brute_force_secret_cookie_val, hash_hmac('md5', $brute_force_secret_word, $brute_force_cookie_salt))) {
				// admin section or login page or login custom slug called
				$is_admin_or_login = (false != strpos($_SERVER['REQUEST_URI'], 'wp-admin') || false != strpos($_SERVER['REQUEST_URI'], 'wp-login') || ('' != $login_page_slug && false != strpos($_SERVER['REQUEST_URI'], $login_page_slug))) ? 1 : 0;
				
				// admin side ajax called
				$is_admin_ajax_request = ('1' == $prevent_ajax_exception && false != strpos($_SERVER['REQUEST_URI'], 'wp-admin/admin-ajax.php')) ? intval($prevent_ajax_exception) : 0;
				
				// password protected page called
				$is_password_protected_access = ('1' == $pw_protected_exception && isset($_GET['action']) && 'postpass' == $_GET['action']) ? 1 : 0;
				
				// cookie based brute force on and accessing admin without ajax and password protected then redirect
				if ($is_admin_or_login && !$is_admin_ajax_request && !$is_password_protected_access) {
					$redirect_url = $aiowps_firewall_config->get_value('aios_cookie_based_brute_force_redirect_url');
					$this->location = $redirect_url;
					return Rule::SATISFIED;
				}
			}
		}
		return Rule::NOT_SATISFIED;
	}

}
