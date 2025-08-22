<?php
if (!defined('ABSPATH')) die('No direct access.');

if (!class_exists('AIOWPSecurity_Reset_Settings')) :

/**
 * Reset Settings various methods
 */
class AIOWPSecurity_Reset_Settings {

	/**
	 * Delete config option.
	 *
	 * @return boolean true if the aio_wp_security_configs option deleted successfully.
	 */
	public static function reset_options() {
		$result_delete_option = false === get_option('aio_wp_security_configs', false) || delete_option('aio_wp_security_configs');
		$result_reset_settings = AIOWPSecurity_Configure_Settings::set_default_settings();
		return $result_delete_option && $result_reset_settings;
	}

	/**
	 * Delete htaccess rules.
	 *
	 * @param string $section - section used to find AIOS rules in .htaccess file
	 *
	 * @return boolean true if the aio_wp_security_configs option deleted successfully.
	 */
	public static function delete_htaccess($section = 'All In One WP Security') {
		$htaccess = ABSPATH . '.htaccess';

		if (!file_exists($htaccess)) {
			return false;
		}
		$ht_contents = preg_split('/\r\n|\r|\n/', file_get_contents($htaccess));
		if ($ht_contents) { // as long as there are lines in the file
			$state = true;
			$f = @fopen($htaccess, 'w+');
			if (!$f) {
				@chmod($htaccess, 0644);
				$f = @fopen($htaccess, 'w+');
				if (!$f) {
					return false;
				}
			}

			foreach ($ht_contents as $markerline) { // for each line in the file
				if (strpos($markerline, '# BEGIN ' . $section) !== false) { // if we're at the beginning of the section
					$state = false;
				}
				if (true == $state) { // as long as we're not in the section keep writing
					fwrite($f, trim($markerline) . "\n");
				}
				if (strpos($markerline, '# END ' . $section) !== false) { // see if we're at the end of the section
					$state = true;
				}
			}
			@fclose($f);
			return true;
		}
		return true;
	}

	/**
	 * Delete database tables
	 *
	 * @return boolean true
	 */
	public static function reset_db_tables() {
		// Reset (TRUNCATE) all the db tables of the plugin.
		global $wpdb;
		$wpdb->query('TRUNCATE ' . $wpdb->prefix . 'aiowps_login_lockdown');
		$wpdb->query('TRUNCATE ' . $wpdb->prefix . 'aiowps_global_meta');
		$wpdb->query('TRUNCATE ' . $wpdb->prefix . 'aiowps_events');
		$wpdb->query('TRUNCATE ' . $wpdb->prefix . 'aiowps_permanent_block');
		if (is_main_site()) {
			$wpdb->query('TRUNCATE ' . AIOWSPEC_TBL_LOGGED_IN_USERS);
			$wpdb->query('TRUNCATE ' . AIOWPSEC_TBL_MESSAGE_STORE);
			$wpdb->query('TRUNCATE ' . AIOWPSEC_TBL_DEBUG_LOG);
			$wpdb->query('TRUNCATE ' . AIOWPSEC_TBL_AUDIT_LOG);
		}
		return true;
	}
}

endif;
