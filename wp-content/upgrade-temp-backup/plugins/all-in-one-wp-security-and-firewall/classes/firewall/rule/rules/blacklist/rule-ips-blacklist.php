<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks IPs to access.
 */
class Rule_Ips_Blacklist extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;

	/**
	 * List of IPs / IP range to block
	 *
	 * @var array
	 */
	private $blocked_ips;

	/**
	 * Construct our rule
	 *
	 * @global Config $aiowps_firewall_config
	 */
	public function __construct() {
		global $aiowps_firewall_config;

		// Set the rule's metadata
		$this->name     = 'Blocked IPs';
		$this->family   = 'Blacklist';
		$this->priority = 0;
		$this->blocked_ips = $aiowps_firewall_config->get_value('aiowps_blacklist_ips');
	}

	/**
	 * Determines whether the rule is active
	 *
	 * @global Constants $aiowps_firewall_constants
	 *
	 * @return boolean
	 */
	public function is_active() {
		global $aiowps_firewall_constants;
		if ($aiowps_firewall_constants->AIOS_DISABLE_BLACKLIST_IP_MANAGER) {
			return false;
		} else {
			return !empty($this->blocked_ips);
		}
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
	
		$user_ip_blocked = \AIOS_Helper::is_user_ip_address_within_list($this->blocked_ips);
		
		if (true == $user_ip_blocked) return Rule::SATISFIED;
		
		return Rule::NOT_SATISFIED;
	}
}
