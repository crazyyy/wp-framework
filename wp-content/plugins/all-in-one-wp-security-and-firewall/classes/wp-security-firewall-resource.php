<?php
if (!defined('ABSPATH') && !defined('AIOWPS_FIREWALL_DIR')) {
	exit; // Exit if accessed directly.
}

if (class_exists('AIOS_Firewall_Resource')) return;

/**
 * Gives us access to our firewall's resources by proxy.
 */
class AIOS_Firewall_Resource {

	/**
	 * Different possible resources.
	 */
	const CONFIG        = 'aiowps_firewall_config';
	const MESSAGE_STORE = 'aiowps_firewall_message_store';
	const CONSTANTS     = 'aiowps_firewall_constants';
	const ALLOW_LIST    = '\AIOWPS\Firewall\Allow_List';
	const UTILITY       = '\AIOWPS\Firewall\Utility';

	/**
	 * Requests a firewall resource.
	 *
	 * @param string $resource
	 *
	 * @return \AIOWPS\Firewall\Config|\AIOWPS\Firewall\Message_Store|\AIOWPS\Firewall\Constants|\AIOWPS\Firewall\Allow_List|\AIOWPS\Firewall\Utility
	 */
	public static function request($resource) {
		switch ($resource) {
			case self::CONFIG:
			case self::MESSAGE_STORE:
			case self::CONSTANTS:
				return isset($GLOBALS[$resource]) ? $GLOBALS[$resource] : new AIOS_Firewall_Resource_Unavailable($resource);
			case self::ALLOW_LIST:
			case self::UTILITY:
				return class_exists($resource) ? $resource : new AIOS_Firewall_Resource_Unavailable($resource);
		}
	}

	/**
	 * Checks if all of the firewall resources are loaded.
	 *
	 * @return bool
	 */
	public static function all_loaded() {
		return isset($GLOBALS[self::CONFIG])
			&& isset($GLOBALS[self::MESSAGE_STORE])
			&& isset($GLOBALS[self::CONSTANTS])
			&& class_exists(self::ALLOW_LIST)
			&& class_exists(self::UTILITY);
	}
}
