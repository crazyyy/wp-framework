<?php
if(!defined('ABSPATH')){
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
		add_action('aiowps_hourly_cron_event', array($this, 'aiowps_hourly_cron_event_handler'));
		add_action('aiowps_daily_cron_event', array($this, 'aiowps_daily_cron_event_handler'));
		add_action('aiowps_perform_failed_login_cleanup_task', array($this, 'failed_login_cleanup'));
		add_action('aiowps_purge_old_debug_logs', array($this, 'purge_old_debug_logs'));
	}
	
	function aiowps_hourly_cron_event_handler()
	{
		//Do stuff that needs checking hourly
		do_action('aiowps_perform_scheduled_backup_tasks');
		do_action('aiowps_perform_fcd_scan_tasks');
		do_action('aiowps_perform_db_cleanup_tasks');
	}
	
	/**
	 * Run daily cron event
	 *
	 * @return void
	 */
	public function aiowps_daily_cron_event_handler() {
		do_action('aiowps_perform_failed_login_cleanup_task');
		do_action('aiowps_purge_old_debug_logs');
	}

	/**
	 * Purges 90 days old failed login records
	 *
	 * @return void
	 */
	public function failed_login_cleanup() {
		global $wpdb, $aio_wp_security;

		$purge_records_after_days = apply_filters('aiowps_purge_failed_login_records_after_days', AIOWPSEC_PURGE_FAILED_LOGIN_RECORDS_AFTER_DAYS);
		$older_than_date_time 	  = date('Y-m-d H:m:s', strtotime('-' . $purge_records_after_days . ' days', strtotime(current_time('mysql', false))));
		$sql					  = $wpdb->prepare('DELETE FROM ' . AIOWPSEC_TBL_FAILED_LOGINS . ' WHERE failed_login_date<%s', $older_than_date_time);
		$ret_deleted			  = $wpdb->query($sql);
		if (false === $ret_deleted) {
			$err_db = !empty($wpdb->last_error) ? ' ('.$wpdb->last_error.' - '.$wpdb->last_query.')' : '';
			// Status level 4 indicates failure status.
			$aio_wp_security->debug_logger->log_debug_cron('Purge Failed Login Records - failed to purge solder failed login records.'.$err_db, 4);
		} else {
			$aio_wp_security->debug_logger->log_debug_cron(sprintf('Purge Failed Login Records - %d failed login records were deleted.', $ret_deleted));
		}
	}

	/**
	 * Purges debug logs older than 90 days
	 * 
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
		$older_than_date = date('Y-m-d H:m:s', strtotime("-{$after_days} days", strtotime(current_time('mysql', false))));
		
		$query = 'DELETE FROM ' . $debug_tbl_name . ' WHERE created < %s';
		$ret = $wpdb->query($wpdb->prepare($query, $older_than_date));
		if (false === $ret) {
			$error_msg = empty($wpdb->last_error) ? 'Could not receive the reason for the failure' : $wpdb->last_error;
			$aio_wp_security->debug_logger->log_debug_cron("Failed to purge older debug logs : {$error_msg}", 4);
		}
	}

}

