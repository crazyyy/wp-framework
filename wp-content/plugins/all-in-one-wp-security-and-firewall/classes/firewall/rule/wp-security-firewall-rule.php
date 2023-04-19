<?php
namespace AIOWPS\Firewall;

/**
 * Base class for our firewall rules
 */
abstract class Rule {

	/**
	 * Name of the rule
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Name of the family the rule belongs to
	 *
	 * @var string
	 */
	public $family;

	/**
	 * Rule's priority (0 is the highest)
	 *
	 * @var int
	 */
	public $priority;

	/**
	 * An abstraction for when the rule is satisfied
	 *
	 * @var boolean
	 */
	const SATISFIED = true;

	/**
	 * An abstraction for when the rule is not satisfied
	 *
	 * @var boolean
	 */
	const NOT_SATISFIED = false;


	/**
	 * Executes the rule's action
	 *
	 * @return void
	 */
	abstract public function do_action();

	/**
	 * Check if the rule is active
	 *
	 * @return boolean
	 */
	abstract public function is_active();

	/**
	 * Check if the rule has been satisfied
	 *
	 * @return boolean
	 */
	abstract public function is_satisfied();

	/**
	 * Apply the rule and execute the action if satisfied
	 *
	 * @return void
	 */
	public function apply() {

		if ($this->is_satisfied()) {

			Event::raise('rule_triggered', $this, time());
			$this->do_action();

		}

		Event::raise('rule_not_triggered', $this, time());
	}

	/**
	 * Show the rule's name
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}
}
