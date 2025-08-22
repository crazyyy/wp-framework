<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

require_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-base-tasks.php');

class AIOWPSecurity_Deactivation_Tasks extends AIOWPSecurity_Base_Tasks {

	/**
	 * Run deactivation task for a single site.
	 *
	 * @return void
	 */
	protected static function run_for_a_site() {
		global $aio_wp_security;

		$aio_wp_security->configs->load_config();

		if (is_main_site()) {
			// Remove all firewall and other .htaccess rules and remove all settings from .htaccess file that were added by this plugin.
			AIOWPSecurity_Utility_Htaccess::delete_from_htaccess();
			
			// Remove user meta info so next activation if force logout on it do not logs user out
			AIOWPSecurity_User_Login::remove_login_activity();

			// Deactivate PHP-based firewall.
			AIOWPSecurity_Utility_Firewall::remove_firewall();
		}

		self::clear_cron_events();
	}

	/**
	 * Helper function which clears aiowps cron events
	 */
	private static function clear_cron_events() {
		wp_clear_scheduled_hook('aiowps_hourly_cron_event');
		wp_clear_scheduled_hook('aiowps_daily_cron_event');
		wp_clear_scheduled_hook('aios_15_minutes_cron_event');
	}

}
