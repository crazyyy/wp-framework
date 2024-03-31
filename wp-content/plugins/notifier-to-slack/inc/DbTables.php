<?php
/**
 * Admin Chat Box Datatable
 *
 * This class is used to builds all of the tables
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * DbTables Class Create Chat box database table
 *
 * @since 1.0.0
 */
class DbTables {
	/**
	 * Holds the instance of the option table.
	 *
	 * @since 1.0.0
	 * @var WPNTS
	 */
	private $sql;
	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		/**
		 * Default setting value.
		 */
		$wpnts_default_interval = [
			'webhook' => 'https://hooks.slack.com/your-services/',
			'interval' => 2500,
			'interval_review' => 2500,
			'reviewDays' => -7,
			'activereview' => 'false',
			'activesupport' => 'false',
		];

		$wpnts_schedules_interval_site_settings = [
			'webhook' => 'https://hooks.slack.com/your-services/',
			'interval_plugin_update' => 10,
			'interval_sitehelgth_update' => 10,
			'intervalDays' => -1,
			'pluginactivation' => false,
			'plugindeactivation' => false,
			'updatenotification' => false,
			'wpnotification' => false,
			'loginandout' => false,
			'sitehelgth' => false,
			'registration' => false,

		];

		$wpnts_webhook_site_settings = [
			'webhook' => 'https://hooks.slack.com/your-services/',
			'intervalDays' => -1,
			'sitessecurityissuesInterval' => 1500,
			'sitessecurityissuesInterval' => 1500,
			'wpconfigmodification' => false,
			'htaccessmodification' => false,
		];

		$admin_email = get_option('admin_email');
		// Check if the admin email is set, otherwise use a default value.
		$admin_email = isset($admin_email) ? $admin_email : '';

		$wpnts_global_api_settings = [
			'global_webhook' => 'https://hooks.slack.com/your-services/',
			'global_interval' => 1500,
			'api_active' => false,
			'mailconfig' => false,
			'recipiantmail' => $admin_email ? $admin_email : '',

		];

		$wpnts_plugin_list = [
			'id' => '1',
			'title' => 'admin-chat-box',
			'content' => 'admin-chat-box',
		];

		add_option( 'wpnts_default_interval', json_encode($wpnts_default_interval) );
		add_option( 'wpnts_schedules_interval_site_settings', json_encode($wpnts_schedules_interval_site_settings) );
		add_option( 'wpnts_webhook_site_settings', json_encode($wpnts_webhook_site_settings) );
		add_option( 'wpnts_plugin_list', json_encode($wpnts_plugin_list) );
		add_option( 'wpnts_global_api_settings', json_encode($wpnts_global_api_settings) );
		add_option( 'wpnts_review_last_sent_time', 0 );
		add_option( 'wpnts_last_sent_time', 0 );
		add_option( 'wpnts_last_plugin_updates', 0 );
		add_option('wpnts_first_saturday_reset_done', 'false');

		/**
		 * Visitor leads
		 */
		global $wpdb;
		$visitor_table = $wpdb->prefix . 'wpnts_visitor_data';

		if ( $wpdb->get_var("SHOW TABLES LIKE '$visitor_table'") !== $visitor_table ) {

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $visitor_table (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                ip VARCHAR(100) NOT NULL,
                country VARCHAR(100),
                city VARCHAR(100),
                count INT NOT NULL,
                visiting_time datetime NOT NULL,
                PRIMARY KEY  (id),
                UNIQUE KEY ip_unique (ip)
            ) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta($sql);

		}
	}
}
