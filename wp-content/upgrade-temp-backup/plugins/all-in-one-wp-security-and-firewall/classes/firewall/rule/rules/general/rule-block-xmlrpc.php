<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks access to the xmlrpc.php file
 */
class Rule_Block_Xmlrpc extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		// Set the rule's metadata
		$this->name     = 'Completely block XMLRPC';
		$this->family   = 'General';
		$this->priority = 10;
	}

	/**
	 * Determines whether the rule is active
	 *
	 * @return boolean
	 */
	public function is_active() {
		global $aiowps_firewall_config;
		return (bool) $aiowps_firewall_config->get_value('aiowps_enable_pingback_firewall');
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing will interfere with 6g rules.
		return (isset($_SERVER['SCRIPT_FILENAME']) && 1 === preg_match('/\/xmlrpc\.php$/i', $_SERVER['SCRIPT_FILENAME']));
	}

}
