<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks certain data from the URL's query string
 */
class Rule_Bad_Query_Strings extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		// Set the rule's metadata
		$this->name     = 'Bad query strings';
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
		return (bool) $aiowps_firewall_config->get_value('aiowps_deny_bad_query_strings');
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		
		if (empty($_SERVER['QUERY_STRING'])) return Rule::NOT_SATISFIED;

		$patterns = array(
			'/ftp:/i',
			'/http:/i',
			'/https:/i',
			'/mosConfig/i',
			'/^.*(globals|encode|loopback).*/i',
			"/(\;|'|\"|%22).*(request|insert|union|declare|drop)/i",
		);

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing will interfere with 6g rules.
		return Rule_Utils::contains_pattern($_SERVER['QUERY_STRING'], $patterns);
	}

}
