<?php
namespace AIOWPS\Firewall;

class Event {

	/**
	 * Stores our events
	 *
	 * @var array
	 */
	private static $events = array();

	/**
	 * Captures an event
	 *
	 * @param string   $name     - Name of the event
	 * @param callable $callback - Callback to execute when the event is raised
	 * @return void
	 */
	public static function capture($name, callable $callback) {
		$name = strtolower($name);

		if (!isset(self::$events[$name])) {
			self::$events[$name] = array();
		}

		self::$events[$name][] = $callback;
	}

	/**
	 * Raises the event
	 *
	 * All the callbacks in a given name are executed
	 *
	 * @param string $name    - Name of the event to raise
	 * @param array  ...$args - Variable list of arguments to pass to the callback
	 * @return void
	 */
	public static function raise($name, ...$args) {
		$name = strtolower($name);

		if (empty(self::$events[$name])) return;

		array_unshift($args, $name);

		foreach (self::$events[$name] as $event) {
			call_user_func_array($event, $args);
		}
	
	}
}
