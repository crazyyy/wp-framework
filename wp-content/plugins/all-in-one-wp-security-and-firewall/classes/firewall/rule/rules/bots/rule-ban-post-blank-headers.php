<?php
namespace AIOWPS\Firewall;

/**
 * Rule that bans the IP address if the POST request has a blank user-agent and referer
 */
class Rule_Ban_Post_Blank_Headers extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Permblock_and_Exit_Trait;
	
	/**
	 * Construct our rule
	 */
	public function __construct() {

		// Set the rule's metadata
		$this->name     = 'Ban POST requests with blank user-agent and referer';
		$this->family   = 'Bots';
		$this->priority = 10;
	}

	/**
	 * Determines whether the rule is active
	 *
	 * @return boolean
	 */
	public function is_active() {
		global $aiowps_firewall_config;
		return (bool) $aiowps_firewall_config->get_value('aiowps_ban_post_blank_headers');
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		$this->set_perm_block_reason('firewall_post_blank_user_agent_and_referer');
		return isset($_SERVER['REQUEST_METHOD']) && (0 === strcasecmp($_SERVER['REQUEST_METHOD'], "POST")) && empty($_SERVER['HTTP_USER_AGENT']) && empty($_SERVER['HTTP_REFERER']); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- This is not a WordPress context. Also this only evaluates to a boolean.
	}
}
