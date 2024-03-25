<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks user agents to access.
 */
class Rule_User_Agent_Blacklist extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;
	
	/**
	 * List of user agents to block
	 *
	 * @var array
	 */
	private $blocked_user_agents;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		global $aiowps_firewall_config;

		// Set the rule's metadata
		$this->name     = 'Blocked user agents';
		$this->family   = 'Blacklist';
		$this->priority = 0;
		$this->blocked_user_agents = $aiowps_firewall_config->get_value('aiowps_blacklist_user_agents');
	}

	/**
	 * Determines whether the rule is active
	 *
	 * @return boolean
	 */
	public function is_active() {
		return !empty($this->blocked_user_agents) && isset($_SERVER['HTTP_USER_AGENT']);
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		foreach ($this->blocked_user_agents as $block_user_agent) {
			if (!empty($block_user_agent) && false !== stripos($_SERVER['HTTP_USER_AGENT'], $block_user_agent)) {
				return Rule::SATISFIED;
			}
		}
		return Rule::NOT_SATISFIED;
	}
}
