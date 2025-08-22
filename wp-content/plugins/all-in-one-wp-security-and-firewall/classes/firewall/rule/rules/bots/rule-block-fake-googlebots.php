<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks fake Googlebots.
 */
class Rule_Block_Fake_Googlebots extends Rule {

	/**
	 * Implements the action to be taken.
	 */
	use Action_Exit_Trait;

	/**
	 * Construct our rule.
	 */
	public function __construct() {
		// Set the rule's metadata.
		$this->name     = 'Block fake Googlebots';
		$this->family   = 'Bots';
		$this->priority = 0;
	}

	/**
	 * Determines whether the rule is active.
	 *
	 * @global Config $aiowps_firewall_config
	 *
	 * @return boolean
	 */
	public function is_active() {
		global $aiowps_firewall_config;
		return (bool) $aiowps_firewall_config->get_value('aiowps_block_fake_googlebots');
	}

	/**
	 * The condition to be satisfied for the rule to apply.
	 *
	 * @global Config $aiowps_firewall_config
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		global $aiowps_firewall_config;

		$user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');

		if (preg_match('/Googlebot/i', $user_agent, $matches)) {
			// If the user agent says it's a Googlebot, start doing checks.

			$ip = \AIOS_Helper::get_user_ip_address();

			if (empty($ip)) {
				return Rule::NOT_SATISFIED;
			}

			try {
				$name = gethostbyaddr($ip); // Let's get the hostname using the IP address.

				if ($name == $ip || false === $name) {
					// gethostbyaddr failed.
					$googlebot_ips = $aiowps_firewall_config->get_value('aiowps_googlebot_ip_ranges');
					if (\AIOS_Helper::is_user_ip_address_within_list($googlebot_ips)) {
						return Rule::NOT_SATISFIED;
					} else {
						return Rule::SATISFIED;
					}
				}

				$host_ip = gethostbyname($name); // Reverse lookup - let's get the IP address using the hostname.
			} catch (\Exception $e) {
				// gethostbyaddr or gethostbyname not available on site.
				$googlebot_ips = $aiowps_firewall_config->get_value('aiowps_googlebot_ip_ranges');
				if (\AIOS_Helper::is_user_ip_address_within_list($googlebot_ips)) {
					return Rule::NOT_SATISFIED;
				} else {
					return Rule::SATISFIED;
				}
			} catch (\Error $e) { // phpcs:ignore PHPCompatibility.Classes.NewClasses.errorFound -- this won't run on PHP 5.6 so we still want to catch it on other versions
				// gethostbyaddr or gethostbyname not available on site.
				$googlebot_ips = $aiowps_firewall_config->get_value('aiowps_googlebot_ip_ranges');
				if (\AIOS_Helper::is_user_ip_address_within_list($googlebot_ips)) {
					return Rule::NOT_SATISFIED;
				} else {
					return Rule::SATISFIED;
				}
			}

			if (preg_match('/^(?:.+\.)?googlebot\.com$/i', $name) || preg_match('/^(?:.+\.)?google\.com$/i', $name) || preg_match('/^(?:.+\.)?googleusercontent\.com$/i', $name)) {
				if ($host_ip == $ip) {
					return Rule::NOT_SATISFIED;
				} else {
					return Rule::SATISFIED;
				}
			} else {
				return Rule::SATISFIED;
			}
		}
	}

}
