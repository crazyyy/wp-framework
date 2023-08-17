<?php
namespace AIOWPS\Firewall;

/**
 * Rule that blocks comments being posted if a proxy is detected.
 */
class Rule_Proxy_Comment_Posting extends Rule {

	/**
	 * Implements the action to be taken
	 */
	use Action_Forbid_and_Exit_Trait;

	/**
	 * Construct our rule
	 */
	public function __construct() {
		// Set the rule's metadata
		$this->name     = 'Proxy comment posting';
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
		return (bool) $aiowps_firewall_config->get_value('aiowps_forbid_proxy_comments');
	}

	/**
	 * The condition to be satisfied for the rule to apply
	 *
	 * @return boolean
	 */
	public function is_satisfied() {

		//Preconditions for the rule
		$is_comment_form = (1 === preg_match('/\/wp-comments-post\.php$/i', $_SERVER['SCRIPT_FILENAME']));
		$is_post         = (0 === strcasecmp($_SERVER['REQUEST_METHOD'], "POST"));

		if (!$is_post || !$is_comment_form)  return Rule::NOT_SATISFIED;

		//Headers that are present if a proxy is being used
		$headers = array(
			'HTTP_VIA',
			'HTTP_FORWARDED',
			'HTTP_USERAGENT_VIA',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED_HOST',
			'HTTP_PROXY_CONNECTION',
			'HTTP_XPROXY_CONNECTION',
			'HTTP_PC_REMOTE_ADDR',
			'HTTP_CLIENT_IP',
		);

		foreach ($headers as $header) {
			if (!empty($_SERVER[$header])) return Rule::SATISFIED;
		}

		return Rule::NOT_SATISFIED;
	}

}
