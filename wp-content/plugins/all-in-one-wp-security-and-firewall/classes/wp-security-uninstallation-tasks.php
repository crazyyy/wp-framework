<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

require_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-base-tasks.php');

class AIOWPSecurity_Uninstallation_Tasks extends AIOWPSecurity_Base_Tasks {
	/**
	 * Runs various uninstallation tasks
	 * Handles single and multi-site (NW activation) cases
	 *
	 * @global type $wpdb
	 * @global type $aio_wp_security
	 */
	public static function run() {
		parent::run();
	}

	/**
	 * Run uninstallation task for a single site.
	 *
	 * @return void
	 */
	protected static function run_for_a_site() {
		// Unset the plugin deletion hooks so that we don't try to log to the audit table after it has been removed
		AIOWPSecurity_Audit_Events::remove_event_actions();

		// Drop db tables and configs
		self::drop_database_tables_and_configs();
	}

	/**
	 * Function to drop database tables and remove configuration settings
	 *
	 * @return void
	 */
	public static function drop_database_tables_and_configs() {
		global $wpdb, $aio_wp_security;

		$database_tables = array(
			$wpdb->prefix.'aiowps_login_lockdown',
			$wpdb->prefix.'aiowps_failed_logins',
			$wpdb->prefix.'aiowps_login_activity',
			$wpdb->prefix.'aiowps_global_meta',
			$wpdb->prefix.'aiowps_events',
			$wpdb->prefix.'aiowps_permanent_block',
			$wpdb->prefix.'aiowps_debug_log',
			$wpdb->prefix.'aiowps_audit_log',
			$wpdb->prefix.'aiowps_logged_in_users',
			$wpdb->prefix.'aiowps_message_store',
		);

		$aio_wp_security->configs->load_config();

		// check and drop database tables
		if ('1' == $aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_db_tables')) {
			foreach ($database_tables as $table_name) {
				$wpdb->query("DROP TABLE IF EXISTS `$table_name`");
			}
		}

		// check and delete configurations
		if ('1' == $aio_wp_security->configs->get_value('aiowps_on_uninstall_delete_configs')) {
			if (is_main_site()) {
				$firewall_rules_path = AIOWPSecurity_Utility_Firewall::get_firewall_rules_path();
				AIOWPSecurity_Utility_File::remove_local_directory($firewall_rules_path);
			}

			delete_option('aio_wp_security_configs');
			delete_option('aiowpsec_db_version');
			delete_option('aiowpsec_firewall_version');
			delete_option('aios_antibot_key_map_info');
		}
	}
}
