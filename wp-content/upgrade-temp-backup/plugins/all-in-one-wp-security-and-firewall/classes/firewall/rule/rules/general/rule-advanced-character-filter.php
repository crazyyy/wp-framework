<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks certain kinds of data from the request string
 */
class Rule_Advanced_Character_Filter extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		// Set the rule's metadata
		$this->name     = 'Advanced character filter';
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
		return (bool) $aiowps_firewall_config->get_value('aiowps_advanced_char_string_filter');
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {
		
		if (empty($_SERVER['REQUEST_URI'])) return Rule::NOT_SATISFIED;

		// ensure we get the request uri without the query string
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- PCP warning. Sanitizing will interfere with 6g rules.
		$uri = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		return Rule_Utils::contains_pattern($uri, array_merge($this->get_general_characters(), $this->get_common_patterns(), $this->get_specific_exploits()));
	}

	/**
	 * Get the list of 'specific exploits' patterns
	 *
	 * @return array
	 */
	private function get_specific_exploits() {
		return array(
			'/errors\./i',
			'/config\./i',
			'/include\./i',
			'/display\./i',
			'/register\./i',
			'/password\./i',
			'/maincore\./i',
			'/authorize\./i',
			'/macromates\./i',
			'/head\_auth\./i',
			'/submit\_links\./i',
			'/change\_action\./i',
			'/com\_facileforms\//i',
			'/admin\_db\_utilities\./i',
			'/admin\.webring\.docs\./i',
			'/Table\/Latest\/index\./i',
		);
	}

	/**
	 * Get the list of common patterns
	 *
	 * @return array
	 */
	private function get_common_patterns() {
		return array(
			'/\_vpi/i',
			'/\.inc/i',
			'/xAou6/i',
			'/db\_name/i',
			'/select\(/i',
			'/convert\(/i',
			'/\/query\//i',
			'/ImpEvData/i',
			'/\.XMLHTTP/i',
			'/proxydeny/i',
			'/function\./i',
			'/remoteFile/i',
			'/servername/i',
			'/\&rptmode\=/i',
			'/sys\_cpanel/i',
			'/db\_connect/i',
			'/doeditconfig/i',
			'/check\_proxy/i',
			'/system\_user/i',
			'/\/\(null\)\//i',
			'/clientrequest/i',
			'/option\_value/i',
			'/ref\.outcontrol/i',
		);
	}

	/**
	 * Get the list of general characters
	 *
	 * @return array
	 */
	private function get_general_characters() {
		return array(
			'/\,/i',
			'/\:/i',
			'/\;/i',
			'/\=/i',
			'/\[/i',
			'/\]/i',
			'/\^/i',
			'/\`/i',
			'/\{/i',
			'/\}/i',
			'/\~/i',
			'/\"/i',
			'/\$/i',
			'/\</i',
			'/\>/i',
			'/\|/i',
			'/\.\./i',
			'/\%0/i',
			'/\%A/i',
			'/\%B/i',
			'/\%C/i',
			'/\%D/i',
			'/\%E/i',
			'/\%F/i',
			'/\%22/i',
			'/\%27/i',
			'/\%28/i',
			'/\%29/i',
			'/\%3C/i',
			'/\%3E/i',
			'/\%3F/i',
			'/\%5B/i',
			'/\%5C/i',
			'/\%5D/i',
			'/\%7B/i',
			'/\%7C/i',
			'/\%7D/i',
		);
	}

}
