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
	 * Checks whether debug is enabled
	 *
	 * @return boolean
	 */
	public function is_debug_enabled() {
		global $aiowps_constants;

		return $aiowps_constants->AIOS_FIREWALL_DEBUG;
	}

	/**
	 * Checks whether we include the request with the debug output
	 *
	 * @return boolean
	 */
	public function is_debug_request_enabled() {
		global $aiowps_constants;
		
		return $aiowps_constants->AIOS_FIREWALL_DEBUG_SHOW_REQUEST;
	}

	/**
	 * Captures the firewall's events for debugging rules
	 *
	 * @param string $event
	 * @param Rule   $rule
	 * @return void
	 */
	public function rule_debug($event, Rule $rule) {

		if (!$this->is_debug_enabled()) return;

		error_log("{$event}: '{$rule->family}:{$rule->name}'");

		// we only want to display the request for `rule_triggered` and `rule_not_triggered` events.
		if ($this->is_debug_request_enabled() && preg_match('/^rule_(not_)?triggered$/', $event)) {
			error_log(print_r($_SERVER, true));
		}
	}
}
