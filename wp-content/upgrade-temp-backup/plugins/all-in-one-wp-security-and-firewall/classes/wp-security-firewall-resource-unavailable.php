<?php
if (!defined('ABSPATH') && !defined('AIOWPS_FIREWALL_DIR')) {
	exit; // Exit if accessed directly.
}

if (class_exists('AIOS_Firewall_Resource_Unavailable')) return;

/**
 * Defines the methods to run when firewall resources failed to load.
 */
class AIOS_Firewall_Resource_Unavailable {

	protected $resource;

	/**
	 * Constructs an unavailable firewall resource object.
	 *
	 * @param string $resource
	 *
	 * @return void
	 */
	public function __construct($resource) {
		$this->resource = $resource;
		do_action('aios_firewall_unavailable_resource', $this->resource);
	}

	/**
	 * Handles call operation on an unavailable firewall resource.
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return void
	 */
	public function __call($name, $arguments) {
		do_action('aios_firewall_unavailable_resource_method_call', $this->resource, $name, $arguments);
	}

	/**
	 * Handles call operation on an unavailable static firewall resource.
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return void
	 */
	public static function __callStatic($name, $arguments) {
		do_action('aios_firewall_unavailable_resource_static_method_call', $name, $arguments);
	}

	/**
	 * Handles get operation on an unavailable firewall resource.
	 *
	 * @param string $name
	 *
	 * @return void
	 */
	public function __get($name) {
		do_action('aios_firewall_unavailable_resource_get_property', $this->resource, $name);
	}

	/**
	 * Handles set operation on an unavailable firewall resource.
	 *
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function __set($name, $value) {
		do_action('aios_firewall_unavailable_resource_set_property', $this->resource, $name, $value);
	}

}
