<?php
namespace AIOWPS\Firewall;

/**
 * Class to help debug the firewall
 */
class Debug {

	/**
	 * Constructs our object
	 */
	public function __construct() {
		//Capture the events that relate to the firewall's rules
		Event::capture('rule_triggered', array($this, 'rule_debug'));
		Event::capture('rule_not_triggered', array($this, 'rule_debug'));
		Event::capture('rule_active', array($this, 'rule_debug'));
		Event::capture('rule_not_active', array($this, 'rule_debug'));
	}

	/**
	 * Captures the firewall's events for debugging rules
	 *
	 * @param string $event
	 * @param Rule   $rule
	 * @return void
	 */
	public function rule_debug($event, Rule $rule) {
		global $aiowps_constants;

		if (!$aiowps_constants->AIOS_FIREWALL_DEBUG && 'rule_triggered' !== $event) return;
		
		$details = array(
			'name'   => $rule->name,
			'family' => $rule->family,
			'ip'     => \AIOS_Helper::get_user_ip_address(),
			'time'   => time(),
		);

		// Get any user information
		foreach ($_COOKIE as $key => $value) {
			if (preg_match('/^wordpress_logged_in_/', $key)) {
				$details['potential_user'] = stripslashes($value);
				break;
			}
		}

		$details['request'] = $_SERVER;
		unset($details['request']['HTTP_COOKIE']);

		// Uncomment when the firewall config issues have been resolved
		// Message_Store::instance()->set($event, $details);
	}
}
