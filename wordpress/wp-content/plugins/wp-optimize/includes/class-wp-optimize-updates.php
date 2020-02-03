<?php
/**
 * WP_Optimize_Updates class using for run updates in database from version to version.
 */

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WP_Optimize_Updates')) :

class WP_Optimize_Updates {

	/**
	 * Format: key=<version>, value=array of method names to call
	 * Example Usage:
	 *	private static $db_updates = array(
	 *		'1.0.1' => array(
	 *			'update_101_add_new_column',
	 *		),
	 *	);
	 *
	 * @var Mixed
	 */
	private static $updates = array(
		'3.0.12' => array('delete_old_locks'),
	);

	/**
	 * See if any database schema updates are needed, and perform them if so.
	 * Example Usage:
	 * public static function update_101_add_new_column() {
	 *		$wpdb = $GLOBALS['wpdb'];
	 *		$wpdb->query('ALTER TABLE tm_tasks ADD task_expiry varchar(300) AFTER id');
	 *	}
	 */
	public static function check_updates() {
		$our_version = WPO_VERSION;
		$db_version = get_option('wpo_update_version');
		if (!$db_version || version_compare($our_version, $db_version, '>')) {
			foreach (self::$updates as $version => $updates) {
				if (version_compare($version, $db_version, '>')) {
					foreach ($updates as $update) {
						call_user_func(array(__CLASS__, $update));
					}
				}
			}
			update_option('wpo_update_version', WPO_VERSION);
		}
	}

	/**
	 * Delete old semaphore locks from options database table.
	 */
	public static function delete_old_locks() {
		global $wpdb;

		// using this query we delete all rows related to locks.
		$query = "DELETE FROM {$wpdb->options}".
				" WHERE (option_name LIKE ('updraft_semaphore_%')".
				" OR option_name LIKE ('updraft_last_lock_time_%')".
				" OR option_name LIKE ('updraft_locked_%')".
				" OR option_name LIKE ('updraft_unlocked_%'))".
				" AND ".
				"(option_name LIKE ('%smush')".
				" OR option_name LIKE ('%load-url-task'));";

		$wpdb->query($query);
	}
}

endif;
