<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

/**
 * Handles all cron jobs
 */
class AIOWPSecurity_Cronjob_Handler {
	
	/**
	 * Class constructor
	 */
	public function __construct() {
		add_filter('cron_schedules', array('AIOWPSecurity_Cronjob_Handler', 'cron_schedules'));

		add_action('aios_15_minutes_cron_event', array($this, 'aios_15_minutes_cron_event'));
		add_action('aiowps_hourly_cron_event', array($this, 'aiowps_hourly_cron_event_handler'));
		add_action('aiowps_daily_cron_event', array($this, 'aiowps_daily_cron_event_handler'));
		add_action('aios_change_auth_keys_and_salt', 'AIOWPSecurity_Utility::change_salt_postfixes');
		add_action('aiowps_purge_old_debug_logs', array($this, 'purge_old_debug_logs'));
		add_action('aiowps_send_lockout_email', array($this, 'send_lockout_email'));
		add_action('aios_update_googlebot_ip_ranges', array($this, 'aios_update_googlebot_ip_ranges'));
	}

	/**
	 * Adds a custom cron schedule for every 5 minutes.
	 *
	 * @param array $schedules An array of cron schedules.
	 * @return array Filtered array of cron schedules.
	 */
	public static function cron_schedules($schedules) {
		$schedules['aios-every-15-minutes'] = array(
			'interval' => 900, // 15 * 60
			'display' => __('Every 15 minutes', 'all-in-one-wp-security-and-firewall')
		);
		return $schedules;
	}

	/**
	 * Run cron event every 5 minute.
	 *
	 * @return void
	 */
	public function aios_15_minutes_cron_event() {
		global $aio_wp_security;

		if (!class_exists('Updraft_Semaphore_3_0')) {
			require_once(AIO_WP_SECURITY_PATH.'/vendor/team-updraft/common-libs/src/updraft-semaphore/class-updraft-semaphore.php');
		}

		$fifteen_minutes_cron_semaphore = new Updraft_Semaphore_3_0('aios_15_minutes_cron_event', 60);

		if ($fifteen_minutes_cron_semaphore->lock(2)) {
			try {
				$aio_wp_security->user_login_obj->send_login_lockout_emails();
			} catch (Exception $e) {
				$log_message = 'Exception ('.get_class($e).') occurred during the 5 minutes cron event action call: '.$e->getMessage().' (Code: '.$e->getCode().', line '.$e->getLine().' in '.$e->getFile().')';
				$aio_wp_security->debug_logger->log_debug($log_message, 4);
			// @codingStandardsIgnoreLine
			} catch (Error $e) {
				$log_message = 'PHP Fatal error ('.get_class($e).') occurred during the the 5 minutes cron event action call. Error Message: '.$e->getMessage().' (Code: '.$e->getCode().', line '.$e->getLine().' in '.$e->getFile().')';
				$aio_wp_security->debug_logger->log_debug($log_message, 4);
			}

			$fifteen_minutes_cron_semaphore->release();
		} else {
			$aio_wp_security->debug_logger->log_debug('The 15 minutes cron event lock could not get the lock.');
		}
	}

	public function aiowps_hourly_cron_event_handler() {
		//Do stuff that needs checking hourly
		AIOWPSecurity_Comment::trash_spam_comments();
		do_action('aiowps_perform_fcd_scan_tasks');
		do_action('delete_expired_logged_in_users_event');
	}
	
	/**
	 * Run daily cron event
	 *
	 * @return void
	 */
	public function aiowps_daily_cron_event_handler() {
		do_action('aiowps_perform_db_cleanup_tasks');
		do_action('aiowps_purge_old_debug_logs');
		do_action('aiowps_send_lockout_email');
		do_action('aios_perform_update_antibot_keys');
		do_action('aios_update_googlebot_ip_ranges');
	}

	/**
	 * Purges debug logs older than 90 days
	 * The 90 days can be modified using the constant AIOWPSEC_PURGE_DEBUG_LOGS_AFTER_DAYS
	 *
	 * @return void
	 */
	public function purge_old_debug_logs() {

		global $wpdb, $aio_wp_security;

		$debug_tbl_name = AIOWPSEC_TBL_DEBUG_LOG;
		$after_days = 90;

		if (defined('AIOWPSEC_PURGE_DEBUG_LOGS_AFTER_DAYS')) {
			$after_days = abs(AIOWPSEC_PURGE_DEBUG_LOGS_AFTER_DAYS);
		}

		$after_days = empty($after_days) ? 90 : $after_days;
		$older_than_date_time = strtotime('-' . $after_days . ' days', time());

		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery -- PCP warning. Ignore
		$ret = $wpdb->query($wpdb->prepare('DELETE FROM ' . $debug_tbl_name . ' WHERE logtime < %s', $older_than_date_time));
		if (false === $ret) {
			$error_msg = empty($wpdb->last_error) ? 'Could not receive the reason for the failure' : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug_cron("Failed to purge older debug logs : {$error_msg}", 4);
		}
	}
	/**
	 * Send email notification to an user who has flag is_lockout_email_sent is 0.
	 *
	 * @return Void
	 */
	public function send_lockout_email() {
		global $aio_wp_security;
		$aio_wp_security->user_login_obj->send_login_lockout_emails();
	}

	/**
	 * Update Googlebot IP ranges for the firewall configuration.
	 *
	 * This function updates the Googlebot IP ranges in the firewall configuration.
	 * It checks if the 'Block fake Googlebots' feature is enabled and then retrieves
	 * the validated Googlebot IP ranges. If the IP ranges are retrieved successfully,
	 * they are saved to the firewall configuration. If there is an error in retrieving
	 * the IP ranges, a debug message is logged.
	 *
	 * @global object $aio_wp_security The main AIO WP Security object.
	 * @global object $aiowps_firewall_config The AIO WP Security firewall configuration object.
	 *
	 * @return void
	 */
	public function aios_update_googlebot_ip_ranges() {
		global $aio_wp_security;
		$aiowps_firewall_config = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::CONFIG);

		if ($aiowps_firewall_config->get_value('aiowps_block_fake_googlebots')) {
			$validated_ip_list_array = AIOWPSecurity_Utility::get_googlebot_ip_ranges();

			if (is_wp_error($validated_ip_list_array)) {
				$aio_wp_security->debug_logger->log_debug('The attempt to save the IP addresses failed, because it was not possible to validate the Googlebot IP addresses: ' . $validated_ip_list_array->get_error_message(), 4);
			}

			$aiowps_firewall_config->set_value('aiowps_googlebot_ip_ranges', $validated_ip_list_array);
		}
	}
}
