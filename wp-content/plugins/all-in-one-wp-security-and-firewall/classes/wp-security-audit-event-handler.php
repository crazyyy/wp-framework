<?php

if (!defined('ABSPATH')) die('No direct access allowed');

require_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-audit-events.php');

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
		add_action('aiowps_record_event', array($this, 'record_event'), 10, 3);
		add_action('aiowps_clean_old_events', array($this, 'delete_old_events'), 10);

		if (!wp_next_scheduled('aiowps_clean_old_events')) {
			wp_schedule_event(time(), 'daily', 'aiowps_clean_old_events');
		}

		AIOWPSecurity_Audit_Events::add_event_actions();
	}

	/**
	 * This function records an event in the audit log
	 *
	 * @param string $event_type  - the event type
	 * @param string $details     - details about the event
	 * @param string $event_level - the event level
	 *
	 * @return void
	 */
	public function record_event($event_type, $details, $event_level = 'info') {
		
		if (!function_exists('wp_get_current_user')) return;

		$user = wp_get_current_user();
		$username = is_a($user, 'WP_User') ? $user->user_login : '';
		$ip = AIOS_Helper::get_server_detected_user_ip_address();
		$stacktrace = maybe_serialize(AIOWPSecurity_Utility::normalise_call_stack_args(debug_backtrace(false)));
		$network_id = get_current_network_id();
		$site_id = get_current_blog_id();

		$this->add_new_event($network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace);
	}

	/**
	 * This function adds the event to the audit log database table
	 *
	 * @param integer $network_id  - the id of the current network
	 * @param integer $site_id     - the id of the current site
	 * @param string  $username    - the username of the user who triggered the event
	 * @param string  $ip          - the IP address of the user
	 * @param string  $event_level - the event level
	 * @param string  $event_type  - the event type
	 * @param string  $details     - details about the event
	 * @param string  $stacktrace  - the event stacktrace
	 *
	 * @return void
	 */
	private function add_new_event($network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace) {
		global $wpdb;

		$sql = $wpdb->prepare("INSERT INTO ".AIOWPSEC_TBL_AUDIT_LOG." (network_id, site_id, username, ip, level, event_type, details, stacktrace, created) VALUES (%d, %d, %s, %s, %s, %s, %s, %s, UNIX_TIMESTAMP())", $network_id, $site_id, $username, $ip, $event_level, $event_type, $details, $stacktrace);

		$wpdb->query($sql);
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

		$sql = $wpdb->prepare("DELETE FROM ".AIOWPSEC_TBL_AUDIT_LOG." WHERE created < %s", $older_than_date);

		$wpdb->query($sql);
	}
}

AIOWPSecurity_Audit_Event_Handler::instance();
