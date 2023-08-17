<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

/**
 * All settings operation performed from here to use as general for wp cli.
 */
class AIOWPSecurity_Settings_Tasks {

	/**
	 * Enable basic firewall rule.
	 *
	 * @return array messages
	 */
	public static function enable_basic_firewall() {
		global $aio_wp_security;
		$msg = array();
		$aio_wp_security->configs->set_value('aiowps_enable_basic_firewall', '1', true);
		//Now let's write the applicable rules to the .htaccess file
		$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();
		if ($res) {
			$msg['updated'] = __('Settings were successfully saved.', 'all-in-one-wp-security-and-firewall');
		} else {
			$msg['error'] = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'.htaccess') . ' ' . __('Please check the file permissions.', 'all-in-one-wp-security-and-firewall');
		}
		return $msg;
	}
	
	/**
	 * Disable all security features.
	 *
	 * @return array messages
	 */
	public static function disable_all_security_features() {
		$msg = array();
		AIOWPSecurity_Configure_Settings::turn_off_all_security_features();
		//Now let's clear the applicable rules from the .htaccess file
		$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();
		
		//Now let's revert the disable editing setting in the wp-config.php file if necessary
		$res2 = AIOWPSecurity_Utility::enable_file_edits();
		if ($res) {
			$msg['updated'] = __('All the security features have been disabled successfully.', 'all-in-one-wp-security-and-firewall');
		} else {
			$msg['error'][] = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'.htaccess') . ' ' . sprintf(__('Please restore it manually using the restore functionality in the "%s" tab.', 'all-in-one-wp-security-and-firewall'), '.htaccess ' . __('file', 'all-in-one-wp-security-and-firewall'));
		}

		if (!$res2) {
			$msg['error'][] = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'wp-config.php') . ' ' . sprintf(__('Please restore it manually using the restore functionality in the "%s" tab.', 'all-in-one-wp-security-and-firewall'), 'wp-config.php ' . __('file', 'all-in-one-wp-security-and-firewall'));
		}
		return $msg;
	}
	
	/**
	 * Disable all firewall rules.
	 *
	 * @return array messages
	 */
	public static function disable_all_firewall_rules() {
		$msg = array();
		AIOWPSecurity_Configure_Settings::turn_off_all_security_features();
		//Now let's clear the applicable rules from the .htaccess file
		$res = AIOWPSecurity_Utility_Htaccess::write_to_htaccess();
		if ($res) {
			$msg['updated'] = __('All firewall rules have been disabled successfully.', 'all-in-one-wp-security-and-firewall');
		} else {
			$msg['error'] = sprintf(__('Could not write to the %s file.', 'all-in-one-wp-security-and-firewall'), AIOWPSecurity_Utility_File::get_home_path().'.htaccess') . ' ' . sprintf(__('Please restore it manually using the restore functionality in the "%s" tab.', 'all-in-one-wp-security-and-firewall'), '.htaccess ' . __('file', 'all-in-one-wp-security-and-firewall'));
		}
		return $msg;
	}
	
	/**
	 * Reset all settings.
	 *
	 * @return array messages
	 */
	public static function reset_all_settings() {
		$msg = array();
		if (!class_exists('AIOWPSecurity_Reset_Settings')) {
			include(AIO_WP_SECURITY_PATH . '/admin/wp-security-reset-settings.php');
		}
		$reset_option_res = AIOWPSecurity_Reset_Settings::reset_options();
		$delete_htaccess = AIOWPSecurity_Reset_Settings::delete_htaccess();
		AIOWPSecurity_Reset_Settings::reset_db_tables();
		// AIOS premium and other plugin related config settings are reset by adding below action.
		do_action('aios_reset_all_settings');
		
		if (false === $reset_option_res && false === $delete_htaccess) {
			$msg['error'] = __('Deletion of aio_wp_security_configs option and .htaccess directives failed.', 'all-in-one-wp-security-and-firewall');
		} elseif (false === $reset_option_res) {
			$msg['error'] = __('Reset of aio_wp_security_configs option failed.', 'all-in-one-wp-security-and-firewall');
		} elseif (false === $delete_htaccess) {
			$msg['error'] = __('Deletion of .htaccess directives failed.', 'all-in-one-wp-security-and-firewall');
		} else {
			$msg['updated'] = __('All settings have been successfully reset.', 'all-in-one-wp-security-and-firewall');
		}
		return $msg;
	}
}
