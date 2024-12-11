<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_Installer {

	private static $db_tasks = array(
		'2.0.2' => array(
			'clean_audit_log_stacktraces',
		),
		'2.0.9' => array(
			'update_table_column_to_timestamp',
		),
		'2.0.10' => array(
			'delete_aiowps_temp_configs_option',
		)
	);

	/**
	 * Run installer function.
	 *
	 * @return void
	 */
	public static function run_installer() {
		global $wpdb;
		if (function_exists('is_multisite') && is_multisite() && is_main_site()) {
			// check if it is a network activation - if so, run the activation function for each blog id
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				AIOWPSecurity_Installer::create_db_tables();
				AIOWPSecurity_Installer::migrate_db_tables();
				AIOWPSecurity_Installer::check_tasks();
				AIOWPSecurity_Configure_Settings::add_option_values();
				AIOWPSecurity_Configure_Settings::update_aiowpsec_db_version();
				restore_current_blog();
			}
		} else {
			AIOWPSecurity_Installer::create_db_tables();
			AIOWPSecurity_Installer::migrate_db_tables();
			AIOWPSecurity_Installer::check_tasks();
			AIOWPSecurity_Configure_Settings::add_option_values();
			AIOWPSecurity_Configure_Settings::update_aiowpsec_db_version();
		}

		AIOWPSecurity_Installer::create_db_backup_dir(); // Create a backup dir in the WP uploads directory.
	}

	/**
	 * See if any database tasks need to be run, and perform them if so.
	 *
	 * @return void
	 */
	public static function check_tasks() {
		$our_version = AIO_WP_SECURITY_DB_VERSION;
		$db_version = get_option('aiowpsec_db_version');
		// database tasks not need to be run if first time install - false check added
		if (false != $db_version && version_compare($our_version, $db_version, '>')) {
			foreach (self::$db_tasks as $version => $updates) {
				if (version_compare($version, $db_version, '>')) {
					foreach ($updates as $update) {
						call_user_func(array(__CLASS__, $update));
					}
				}
			}
		}
	}

	public static function create_db_tables() {
		global $wpdb;

		if (!function_exists('dbDelta')) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		}

		if (function_exists('is_multisite') && is_multisite()) {
			/*
			 * FIX for multisite table creation case:
			 * Although each table name is defined in a constant inside the wp-security-core.php,
			 * we need to do this step for multisite case because we need to refresh the $wpdb->prefix value
			 * otherwise it will contain the original blog id and not the current id we need.
			 *
			 */
			$lockout_tbl_name = $wpdb->prefix.'aiowps_login_lockdown';
			$aiowps_global_meta_tbl_name = $wpdb->prefix.'aiowps_global_meta';
			$aiowps_event_tbl_name = $wpdb->prefix.'aiowps_events';
			$perm_block_tbl_name = $wpdb->prefix.'aiowps_permanent_block';
		} else {
			$lockout_tbl_name = AIOWPSEC_TBL_LOGIN_LOCKOUT;
			$aiowps_global_meta_tbl_name = AIOWPSEC_TBL_GLOBAL_META_DATA;
			$aiowps_event_tbl_name = AIOWPSEC_TBL_EVENTS;
			$perm_block_tbl_name = AIOWPSEC_TBL_PERM_BLOCK;
		}

		$message_store_log_tbl_name = AIOWPSEC_TBL_MESSAGE_STORE;
		$audit_log_tbl_name = AIOWPSEC_TBL_AUDIT_LOG;
		$debug_log_tbl_name = AIOWPSEC_TBL_DEBUG_LOG;
		$logged_in_users_tbl_name = AIOWSPEC_TBL_LOGGED_IN_USERS;

		$charset_collate = '';
		if (!empty($wpdb->charset)) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		} else {
			$charset_collate = "DEFAULT CHARSET=utf8";
		}
		if (!empty($wpdb->collate)) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}

		$ld_tbl_sql = "CREATE TABLE " . $lockout_tbl_name . " (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		user_id bigint(20) NOT NULL,
		user_login VARCHAR(150) NOT NULL,
		lockdown_date datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
		created INTEGER UNSIGNED,
		release_date datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
		released INTEGER UNSIGNED,
		failed_login_ip varchar(100) NOT NULL DEFAULT '',
		lock_reason varchar(128) NOT NULL DEFAULT '',
		unlock_key varchar(128) NOT NULL DEFAULT '',
		is_lockout_email_sent tinyint(1) NOT NULL DEFAULT '1',
		backtrace_log text NOT NULL,
		ip_lookup_result LONGTEXT DEFAULT NULL,
		PRIMARY KEY  (id),
		  KEY failed_login_ip (failed_login_ip),
		  KEY is_lockout_email_sent (is_lockout_email_sent),
		  KEY unlock_key (unlock_key)
		)" . $charset_collate . ";";
		dbDelta($ld_tbl_sql);

		$gm_tbl_sql = "CREATE TABLE " . $aiowps_global_meta_tbl_name . " (
		meta_id bigint(20) NOT NULL auto_increment,
		date_time datetime NOT NULL default '1000-10-10 10:00:00',
		created INTEGER UNSIGNED,
		meta_key1 varchar(255) NOT NULL,
		meta_key2 varchar(255) NOT NULL,
		meta_key3 varchar(255) NOT NULL,
		meta_key4 varchar(255) NOT NULL,
		meta_key5 varchar(255) NOT NULL,
		meta_value1 varchar(255) NOT NULL,
		meta_value2 text NOT NULL,
		meta_value3 text NOT NULL,
		meta_value4 longtext NOT NULL,
		meta_value5 longtext NOT NULL,
		PRIMARY KEY  (meta_id)
		)" . $charset_collate . ";";
		dbDelta($gm_tbl_sql);

		$evt_tbl_sql = "CREATE TABLE " . $aiowps_event_tbl_name . " (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		event_type VARCHAR(150) NOT NULL DEFAULT '',
		username VARCHAR(150),
		user_id bigint(20),
		event_date datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
		created INTEGER UNSIGNED,
		ip_or_host varchar(100),
		referer_info varchar(255),
		url varchar(255),
		country_code varchar(50),
		event_data longtext,
		PRIMARY KEY  (id)
		)" . $charset_collate . ";";
		dbDelta($evt_tbl_sql);

		$pb_tbl_sql = "CREATE TABLE " . $perm_block_tbl_name . " (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		blocked_ip varchar(100) NOT NULL DEFAULT '',
		block_reason varchar(128) NOT NULL DEFAULT '',
		country_origin varchar(50) NOT NULL DEFAULT '',
		blocked_date datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
		created INTEGER UNSIGNED,
		unblock tinyint(1) NOT NULL DEFAULT '0',
		PRIMARY KEY  (id),
		KEY blocked_ip (blocked_ip)
		)" . $charset_collate . ";";
		dbDelta($pb_tbl_sql);

		$audit_log_tbl_sql = "CREATE TABLE " . $audit_log_tbl_name . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			network_id bigint(20) NOT NULL DEFAULT '0',
			site_id bigint(20) NOT NULL DEFAULT '0',
			username varchar(60) NOT NULL DEFAULT '',
			ip VARCHAR(45) NOT NULL DEFAULT '',
			level varchar(25) NOT NULL DEFAULT '',
			event_type varchar(25) NOT NULL DEFAULT '',
			details text NOT NULL,
			stacktrace text NOT NULL,
			created INTEGER UNSIGNED,
			country_code varchar(50),
			PRIMARY KEY  (id),
			INDEX username (username),
			INDEX ip (ip),
			INDEX level (level),
			INDEX event_type (event_type)
			)" . $charset_collate . ";";
		dbDelta($audit_log_tbl_sql);

		$debug_log_tbl_sql = "CREATE TABLE " . $debug_log_tbl_name . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			created datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
			logtime INTEGER UNSIGNED,
			level varchar(25) NOT NULL DEFAULT '',
			network_id bigint(20) NOT NULL DEFAULT '0',
			site_id bigint(20) NOT NULL DEFAULT '0',
			message text NOT NULL,
			type varchar(25) NOT NULL DEFAULT '',
			PRIMARY KEY  (id)
			)" . $charset_collate . ";";
		dbDelta($debug_log_tbl_sql);

		$liu_tbl_sql = "CREATE TABLE " . $logged_in_users_tbl_name . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) NOT NULL,
			username varchar(60) NOT NULL DEFAULT '',
			ip_address varchar(45) NOT NULL DEFAULT '',
			site_id bigint(20) NOT NULL,
			created integer UNSIGNED,
			expires integer UNSIGNED,
			PRIMARY KEY (id),
			UNIQUE KEY unique_user_id (user_id),
			INDEX created (created),
			INDEX expires (expires),
			INDEX user_id (user_id),
			INDEX site_id (site_id)
			) " . $charset_collate . ";";
		dbDelta($liu_tbl_sql);

		$message_store_log_tbl_sql = "CREATE TABLE " . $message_store_log_tbl_name . " (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			message_key text NOT NULL,
			message_value text NOT NULL,
			created INTEGER UNSIGNED,
			PRIMARY KEY  (id)
			)" . $charset_collate . ";";
		dbDelta($message_store_log_tbl_sql);
	}

	/**
	 * This function will handle any database table migrations
	 *
	 * @return void
	 */
	public static function migrate_db_tables() {
		global $wpdb;

		if (function_exists('is_multisite') && is_multisite()) {
			/*
			 * FIX for multisite table creation case:
			 * Although each table name is defined in a constant inside the wp-security-core.php,
			 * we need to do this step for multisite case because we need to refresh the $wpdb->prefix value
			 * otherwise it will contain the original blog id and not the current id we need.
			 *
			 */
			$failed_login_tbl_name = $wpdb->prefix.'aiowps_failed_logins';
			$login_activity_tbl_name = $wpdb->prefix.'aiowps_login_activity';
			
		} else {
			$failed_login_tbl_name = AIOWPSEC_TBL_FAILED_LOGINS;
			$login_activity_tbl_name = AIOWPSEC_TBL_USER_LOGIN_ACTIVITY;
		}

		$audit_log_tbl_name = AIOWPSEC_TBL_AUDIT_LOG;
		$network_id = get_current_network_id();
		$site_id = get_current_blog_id();
		
		$query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($failed_login_tbl_name));
		$table_exists = $wpdb->get_var($query);
		if ($table_exists) {
			$import_details = array(
				'failed_login' => array(
					'imported' => true,
				)
			);
			$import_details = json_encode($import_details, true);
			$table_migration_details = array(
				'table_migration' => array(
					'success' => true,
					'from_table' => $failed_login_tbl_name,
					'to_table' => $audit_log_tbl_name
				)
			);

			if (false === $wpdb->query($wpdb->prepare("INSERT INTO $audit_log_tbl_name (network_id, site_id, username, ip, level, event_type, details, stacktrace, created) SELECT %d AS network_id, %d AS site_id, fl.user_login AS username, fl.login_attempt_ip AS ip, 'warning' AS level, 'Failed login' AS event_type, %s AS details, '' AS stacktrace, UNIX_TIMESTAMP(fl.failed_login_date) AS created FROM $failed_login_tbl_name fl", $network_id, $site_id, $import_details))) {
				$table_migration_details['table_migration']['success'] = false;
				do_action('aiowps_record_event', 'table_migration', $table_migration_details, 'error');
			} else {
				do_action('aiowps_record_event', 'table_migration', $table_migration_details, 'info');
				$wpdb->query("DROP TABLE IF EXISTS `$failed_login_tbl_name`");
			}
		}

		$query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($login_activity_tbl_name));
		$table_exists = $wpdb->get_var($query);
		if ($table_exists) {
			$wpdb->query("DROP TABLE IF EXISTS `$login_activity_tbl_name`");
		}
	}

	/**
	 * This function will run SQL to clean sensitive information from the audit log table stacktrace
	 *
	 * @return void
	 */
	public static function clean_audit_log_stacktraces() {
		global $wpdb;
		$wpdb->query("UPDATE ".AIOWPSEC_TBL_AUDIT_LOG." SET stacktrace = '' WHERE event_type = 'failed_login' OR event_type = 'successful_login' OR event_type = 'user_registration'");
	}

	/**
	 * This function will update the table datetime column to timestamp with backward compability
	 *
	 * @return void
	 */
	public static function update_table_column_to_timestamp() {
		$db_version = get_option('aiowpsec_db_version', '1.0');
		if (version_compare('2.0.8', $db_version, '>')) {
			self::update_column_to_timestamp(AIOWPSEC_TBL_EVENTS, 'event_date', 'created');
			self::update_column_to_timestamp(AIOWPSEC_TBL_LOGIN_LOCKOUT, 'lockdown_date', 'created');
			self::update_column_to_timestamp(AIOWPSEC_TBL_LOGIN_LOCKOUT, 'release_date', 'released');
		}
		
		if (version_compare('2.0.9', $db_version, '>')) {
			self::update_column_to_timestamp(AIOWPSEC_TBL_PERM_BLOCK, 'blocked_date', 'created');
			self::update_column_to_timestamp(AIOWPSEC_TBL_GLOBAL_META_DATA, 'date_time', 'created');
			self::update_column_to_timestamp(AIOWPSEC_TBL_DEBUG_LOG, 'created', 'logtime');
		}
	}

	/**
	 * Update the table column to UTC timestamp not depending on the timezone of the user or server settings
	 *
	 * @global wpdb $wpdb
	 *
	 * @param string $table_name
	 * @param string $field_datetime
	 * @param string $field_timestamp
	 *
	 * @return boolean - returns the rows updated or not
	 */
	public static function update_column_to_timestamp($table_name, $field_datetime, $field_timestamp) {
		global $wpdb;
		//MySQL UNIX_TIMESTAMP will convert datetime based on local timezone not UTC
		$offset = $wpdb->get_var("SELECT TIMESTAMPDIFF(SECOND, NOW(), UTC_TIMESTAMP())");
		if (AIOWPSEC_TBL_PERM_BLOCK == $table_name || AIOWPSEC_TBL_GLOBAL_META_DATA == $table_name || AIOWPSEC_TBL_DEBUG_LOG == $table_name) {
			//User local settings date time saved offset timezone needs to removed for UTC correct value
			$offset += AIOWPSecurity_Utility::get_wp_timezone()->getOffset(new DateTime('now', new DateTimeZone('UTC')));
		}
		if (function_exists('is_multisite') && is_multisite() && AIOWPSEC_TBL_EVENTS == $table_name) {
			$table_name = $wpdb->prefix.'aiowps_events';
		} elseif (function_exists('is_multisite') && is_multisite() && AIOWPSEC_TBL_LOGIN_LOCKOUT == $table_name) {
			$table_name = $wpdb->prefix.'aiowps_login_lockdown';
		} elseif (function_exists('is_multisite') && is_multisite() && AIOWPSEC_TBL_PERM_BLOCK == $table_name) {
			$table_name = $wpdb->prefix.'aiowps_permanent_block';
		} elseif (function_exists('is_multisite') && is_multisite() && AIOWPSEC_TBL_GLOBAL_META_DATA == $table_name) {
			$table_name = $wpdb->prefix.'aiowps_global_meta';
		} elseif (function_exists('is_multisite') && is_multisite() && AIOWPSEC_TBL_DEBUG_LOG == $table_name) {
			$table_name = $wpdb->prefix.'aiowps_debug_log';
		}
		//offset to make sure UTC timestamp updated
		$wpdb->query($wpdb->prepare("UPDATE $table_name SET $field_timestamp = (UNIX_TIMESTAMP($field_datetime) - %d)", $offset));
	}

	/**
	 * Deletes the aiowps_temp_configs option if present.
	 *
	 * @return void
	 */
	public static function delete_aiowps_temp_configs_option() {
		delete_option('aiowps_temp_configs');
	}

	public static function create_db_backup_dir() {
		global $aio_wp_security;
		//Create our folder in the "wp-content" directory
		$aiowps_dir = WP_CONTENT_DIR . '/' . AIO_WP_SECURITY_BACKUPS_DIR_NAME;
		if (!is_dir($aiowps_dir) && is_writable(WP_CONTENT_DIR)) {
			mkdir($aiowps_dir, 0755, true);
			//Let's also create an empty index.html file in this folder
			$index_file = $aiowps_dir . '/index.html';
			$handle = fopen($index_file, 'w'); //or die('Cannot open file:  '.$index_file);
			fclose($handle);
		}
		$server_type = AIOWPSecurity_Utility::get_server_type();
		//Only create .htaccess if server is the right type
		if ('apache' == $server_type || 'litespeed' == $server_type) {
			$file = $aiowps_dir . '/.htaccess';
			if (!file_exists($file)) {
				//Create an .htacces file
				//Write some rules which will only allow people originating from wp admin page to download the DB backup
				$rules = '';
				$rules .= 'order deny,allow' . PHP_EOL;
				$rules .= 'deny from all' . PHP_EOL;
				$write_result = file_put_contents($file, $rules);
				if (false === $write_result) {
					$aio_wp_security->debug_logger->log_debug("Creation of .htaccess file in " . AIO_WP_SECURITY_BACKUPS_DIR_NAME . " directory failed!", 4);
				}
			}
		}
	}

	/**
	 * Setup AIOS cron tasks.
	 * Handles both single and multi-site (NW activation) cases.
	 *
	 * @global type $wpdb
	 *
	 * @return Void
	 */
	public static function set_cron_tasks_upon_activation() {
		require_once(__DIR__.'/wp-security-cronjob-handler.php');
		// It is required because we are going to schedule a 15-minute cron event upon activation.
		add_filter('cron_schedules', array('AIOWPSecurity_Cronjob_Handler', 'cron_schedules'));
		if (is_multisite() && is_main_site()) {
			global $wpdb;
			// check if it is a network activation
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				AIOWPSecurity_Installer::schedule_cron_events();
				do_action('aiowps_activation_complete');
				restore_current_blog();
			}
		} else {
			AIOWPSecurity_Installer::schedule_cron_events();
			do_action('aiowps_activation_complete');
		}
	}

	/**
	 * Helper function for scheduling AIOS cron events.
	 *
	 * @return Void
	 */
	public static function schedule_cron_events() {
		if (!wp_next_scheduled('aios_15_minutes_cron_event')) {
			wp_schedule_event(time(), 'aios-every-15-minutes', 'aios_15_minutes_cron_event'); //schedule a 15 minutes cron event
		}
		if (!wp_next_scheduled('aiowps_hourly_cron_event')) {
			wp_schedule_event(time(), 'hourly', 'aiowps_hourly_cron_event'); //schedule an hourly cron event
		}
		if (!wp_next_scheduled('aiowps_daily_cron_event')) {
			wp_schedule_event(time(), 'daily', 'aiowps_daily_cron_event'); //schedule an daily cron event
		}
		if (!wp_next_scheduled('aiowps_weekly_cron_event')) {
			wp_schedule_event(time(), 'weekly', 'aiowps_weekly_cron_event'); //schedule an daily cron event
		}
	}
}
