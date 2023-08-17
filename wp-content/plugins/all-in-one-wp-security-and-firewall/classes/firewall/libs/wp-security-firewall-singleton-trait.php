<?php
namespace AIOWPS\Firewall;

/**
 * A trait with a basic singleton implementation
 */
trait Singleton_Trait {

	/**
	 * Internally stores the class's instance
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Returns an instance of the class
	 *
	 * @return object
	 */
	public static function instance() {

		if (is_null(self::$instance)) self::$instance = new self();

		return self::$instance;

	}

	/**
	 * We don't want our singleton object to be cloned
	 *
	 * @return void
	 */
	private function __clone() {
	}
}
