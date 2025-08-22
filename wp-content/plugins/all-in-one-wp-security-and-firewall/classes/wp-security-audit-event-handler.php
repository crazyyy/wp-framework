<?php

if (!defined('ABSPATH')) die('No direct access allowed');

require_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-audit-events.php');
require_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-audit-text-handler.php');

class AIOWPSecurity_Audit_Event_Handler {

	protected static $_instance = null;

	/**
	 * This method will create and return the only instance of this class.
	 *
	 * @return AIOWPSecurity_Audit_Event_Handler Returns an instance of the class
	 */
	public static function instance() {
		if (empty(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor for the class.
	 */
	private function __construct() {
		add_action('aiowps_record_event', array($this, 'record_event'), 10, 4);
		add_action('aiowps_bulk_record_events', function($events) {
			$this->add_bulk_events($events);
		}, 10, 4);
		add_action('aiowps_clean_old_events', array($this, 'delete_old_events'), 10);

		if (!wp_next_scheduled('aiowps_clean_old_events')) {
			wp_schedule_event(time(), 'daily', 'aiowps_clean_old_events');
		}

		AIOWPSecurity_Audit_Events::add_event_actions();
	}

	/**
	 * This function records an event in the audit log
	 *
	 * @global AIO_WP_Security $aio_wp_security
	 *
	 * @param string $event_type  - the event type
	 * @param array  $details     - details about the event
	 * @param string $event_level - the event level
	 * @param string $username    - the username, this is only used if there is no user logged in
	 *
	 * @return void
	 */
	public function record_event($event_type, $details, $event_level = 'info', $username = '') {

		if (!function_exists('wp_get_current_user')) {
			global $aio_wp_security;

			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Audit_Event_Handler::record_event() called before plugins_loaded hook has run.", 4);
			return;
		}

		$record_event = apply_filters('aios_audit_log_record_event', true, $event_type, $details, $event_level, $username);

		if (!$record_event) return;

		$user = wp_get_current_user();
		$username = (is_a($user, 'WP_User') && 0 !== $user->ID) ? $user->user_login : $username;
		$ip = apply_filters('aios_audit_log_event_user_ip', AIOWPSecurity_Utility_IP::get_user_ip_address());
		$data = apply_filters('aios_audit_log_event_user_country_code', array('ip' => $ip));
		$country_code = isset($data['country_code']) ? $data['country_code'] : '';
		$stacktrace = maybe_serialize(AIOWPSecurity_Utility::normalise_call_stack_args(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace -- Required for the stacktrace to work.
		$network_id = get_current_network_id();
		$site_id = get_current_blog_id();
		$details = wp_json_encode($details, true);

		$this->add_new_event($network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace, $country_code);
	}

	/**
	 * This function adds the event to the audit log database table
	 *
	 * @param integer $network_id   - the id of the current network
	 * @param integer $site_id      - the id of the current site
	 * @param string  $username     - the username of the user who triggered the event
	 * @param string  $ip           - the IP address of the user
	 * @param string  $event_level  - the event level
	 * @param string  $event_type   - the event type
	 * @param string  $details      - details about the event
	 * @param string  $stacktrace   - the event stacktrace
	 * @param string  $country_code - the country code
	 *
	 * @return void
	 */
	private function add_new_event($network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace, $country_code) {
		global $wpdb;

		$wpdb->query($wpdb->prepare("INSERT INTO ".AIOWPSEC_TBL_AUDIT_LOG." (network_id, site_id, username, ip, level, event_type, details, stacktrace, created, country_code) VALUES (%d, %d, %s, %s, %s, %s, %s, %s, UNIX_TIMESTAMP(), %s)", $network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace, $country_code)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.NotPrepared -- We can't use %i because our plugin supports wordpress < 6.2.
	}

	/**
	 * This function adds multiple events to the audit log database table
	 *
	 * @param array $events - each event in the array must contain the keys (network_id, site_id, username, ip, level, event_type, details, stacktrace and created)
	 *
	 * @return void
	 */
	private function add_bulk_events($events) {
		global $wpdb;

		$sql = "INSERT INTO ".AIOWPSEC_TBL_AUDIT_LOG." (network_id, site_id, username, ip, level, event_type, details, stacktrace, created, country_code) VALUES ";
		$values = array();

		foreach ($events as $event) {
			$sql .= "(%d, %d, %s, %s, %s, %s, %s, %s, %d, %s),";

			$record_event = apply_filters('aios_audit_log_record_event', true, $event['event_type'], $event['details'], $event['level'], $event['username']);
			if (!$record_event) continue;
			
			$event['ip'] = apply_filters('aios_audit_log_event_user_ip', $event['ip']);
			$data = apply_filters('aios_audit_log_event_user_country_code', array('ip' => $event['ip']));
			$event['country_code'] = isset($data['country_code']) ? $data['country_code'] : '';
			$values[] = $event['network_id'];
			$values[] = $event['site_id'];
			$values[] = $event['username'];
			$values[] = $event['ip'];
			$values[] = $event['level'];
			$values[] = $event['event_type'];
			$values[] = $event['details'];
			$values[] = $event['stacktrace'];
			$values[] = $event['created'];
			$values[] = $event['country_code'];
		}

		// remove last ',' character from query
		$sql = rtrim($sql, ',');

		$wpdb->query($wpdb->prepare($sql, $values)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.NotPrepared -- The sql query is being dynamically built.
	}

	/**
	 * This method will try to delete all audit logs older than 3 months from the database.
	 *
	 * @return void
	 */
	public function delete_old_events() {
		global $wpdb;

		$after_days = 90;

		if (defined('AIOWPSEC_PURGE_AUDIT_LOGS_AFTER_DAYS')) {
			$after_days = abs(AIOWPSEC_PURGE_AUDIT_LOGS_AFTER_DAYS);
		}

		$after_days = empty($after_days) ? 90 : $after_days;
		$older_than_date = strtotime("-{$after_days} days", time());

		$wpdb->query($wpdb->prepare("DELETE FROM ".AIOWPSEC_TBL_AUDIT_LOG." WHERE created < %s", $older_than_date)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.PreparedSQL.NotPrepared -- We can't use %i because our plugin supports wordpress < 6.2.
	}
}
