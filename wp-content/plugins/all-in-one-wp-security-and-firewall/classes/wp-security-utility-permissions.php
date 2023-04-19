<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Utility_Permissions {
	
	/**
	 * Check whether the current logged in user has the capability to manage the AIOWPS plugin and check if the given nonce is valid
	 *
	 * @param string $nonce      - a WordPress nonce
	 * @param string $nonce_name - the name of the nonce
	 *
	 * @return WP_Error|boolean - return true if all checks pass otherwise return a WP_Error
	 */
	public static function check_nonce_and_user_cap($nonce, $nonce_name) {
		if (!self::has_manage_cap()) return new WP_Error('missing_capability', 'Current user lacks the required capability for this action');
		if (!wp_verify_nonce($nonce, $nonce_name)) return new WP_Error('invalid_nonce', 'Invalid nonce ('.$nonce_name.') provided for this action');
		return true;
	}

	/**
	 * Check whether the current logged in user has the capability to manage the AIOWPS plugin
	 *
	 * @return Boolean - true if the logged in user has capability to manage the AIOWPS plugin, otherwise false
	 */
	public static function has_manage_cap() {
		$cap = apply_filters('aios_management_permission', 'manage_options');
		// This filter will useful when the administrator would like to give permission to access AIOWPS to Security Analyst.
		return apply_filters('aiowps_management_capability', current_user_can($cap));
	}

	/**
	 * This function checks if premium is installed and returns true otherwise false
	 *
	 * @return boolean - true if premium is installed otherwise false
	 */
	public static function is_premium_installed() {
		return (defined('AIOWPSECURITY_NOADS_B') && AIOWPSECURITY_NOADS_B) ? true : false;
	}

	/**
	 * Checks whether it's the main site and super admin
	 *
	 * @return Bool - true if it's the main site and super admin otherwise false
	 */
	public static function is_main_site_and_super_admin() {
		return (is_main_site() && is_super_admin());
	}
}
