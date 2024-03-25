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
		'3.0.17' => array('disable_cache_directories_viewing'),
		'3.1.0' => array('reset_wpo_plugin_cron_tasks_schedule'),
		'3.1.4' => array('enable_minify_defer'),
		'3.1.5' => array('update_minify_excludes'),
		'3.2.14' => array('update_3214_modify_cache_config_in_windows'),
		'3.2.15' => array('update_3215_modify_cache_config_for_webp'),
		'3.2.17' => array('update_3217_remove_htaccess_capability_tester_files'),
		'3.2.18' => array('update_3218_reset_webp_serving_method'),
		'3.2.19' => array('update_3219_modify_cache_config_for_cache_time'),
		'3.3.0' => array('update_330_ua_async_exclusion_list')
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

	/**
	 * Disable cache directories viewing.
	 */
	public static function disable_cache_directories_viewing() {
		wpo_disable_cache_directories_viewing();
	}

	public static function reset_wpo_plugin_cron_tasks_schedule() {
		wp_clear_scheduled_hook('wpo_plugin_cron_tasks');
	}

	/**
	 * Update Minify Defer option (The option was hidden until now, but we're changing the setting)
	 *
	 * @return void
	 */
	public static function enable_minify_defer() {
		if (!function_exists('wp_optimize_minify_config')) {
			include_once WPO_PLUGIN_MAIN_PATH . 'minify/class-wp-optimize-minify-config.php';
		}
		$current_setting = wp_optimize_minify_config()->get('enable_defer_js');
		if (true === $current_setting) {
			wp_optimize_minify_config()->update(array('enable_defer_js' => 'all'));
		} else {
			wp_optimize_minify_config()->update(array('enable_defer_js' => 'individual'));
		}
	}

	/**
	 * Update Minify default exclude options
	 *
	 * @return void
	 */
	public static function update_minify_excludes() {
		if (!WPO_MINIFY_PHP_VERSION_MET) return;
		if (!function_exists('wp_optimize_minify_config')) {
			include_once WPO_PLUGIN_MAIN_PATH . 'minify/class-wp-optimize-minify-config.php';
		}

		if (!class_exists('WP_Optimize_Minify_Functions')) {
			include_once WPO_PLUGIN_MAIN_PATH . 'minify/class-wp-optimize-minify-functions.php';
		}

		$new_default_items = array(
			'elementor-admin-bar',
			'pdfjs-dist',
			'wordpress-popular-posts',
		);

		$user_excluded_blacklist_items = array();
		$user_excluded_ignorelist_items = array();

		// Get the lists as saved in the DB
		$current_blacklist = wp_optimize_minify_config()->get('blacklist');
		$current_ignorelist = wp_optimize_minify_config()->get('ignore_list');

		// Only proceed if the the upgrade hasn't been done yet, i.e. the values aren't arrays
		if (is_array($current_blacklist) && is_array($current_ignorelist)) return;

		$current_blacklist = array_map('trim', explode("\n", $current_blacklist));
		$current_ignorelist = array_map('trim', explode("\n", $current_ignorelist));

		// Get the default lists
		$default_blacklist = WP_Optimize_Minify_Functions::get_default_ie_blacklist();
		$default_ignorelist = WP_Optimize_Minify_Functions::get_default_ignore();

		foreach ($default_blacklist as $bl_item) {
			// If a blacklist item isn't in the list, it was manually removed by the user, so we save that.
			if (!in_array($bl_item, $current_blacklist)) $user_excluded_blacklist_items[] = $bl_item;
		}

		foreach ($default_ignorelist as $il_item) {
			if (!in_array($il_item, $current_ignorelist) && !in_array($il_item, $new_default_items)) $user_excluded_ignorelist_items[] = $il_item;
		}

		// Update the options
		wp_optimize_minify_config()->update(array('blacklist' => $user_excluded_blacklist_items));
		wp_optimize_minify_config()->update(array('ignore_list' => $user_excluded_ignorelist_items));
	}

	/**
	 * Checks if it's a new installation of the plugin, as opposed to being updated.
	 *
	 * @return bool
	 */
	public static function is_new_install() {
		$db_version = get_option('wpo_update_version');
		return !$db_version;
	}

	/**
	 * Modifies the cache configuration for Windows OS by regenerating the 'uploads' path.
	 */
	public static function update_3214_modify_cache_config_in_windows() {
		
		// Check if the OS is Windows and it's not a new installation.
		if ('WIN' !== strtoupper(substr(PHP_OS, 0, 3)) || self::is_new_install()) {
			return;
		}

		// Retrieve the current cache configuration
		$config = WPO_Cache_Config::instance()->get();

		// Remove the 'uploads' path from the configuration, this will force the 'uploads' path to regenerate from the defaults
		if (isset($config['uploads'])) {
			unset($config['uploads']);
		}

		// Update the cache configuration
		WPO_Cache_Config::instance()->update($config);
	}

	/**
	 * Updates the cache configuration to incorporate the new 'use_webp_images' default setting in the cache config.
	 */
	private static function update_3215_modify_cache_config_for_webp() {

		// Check if it's not a new installation
		if (self::is_new_install()) {
			return;
		}
		
		// Retrieve the current status of page caching and WebP conversion
		$cache_enabled = (bool) WPO_Cache_Config::instance()->get_option('enable_page_caching');
		$webp_enabled  = (bool) WP_Optimize()->get_options()->get_option('webp_conversion');

		// If both page caching and WebP conversion are enabled, update the cache configuration
		if ($cache_enabled && $webp_enabled) {
			$config = WPO_Cache_Config::instance()->get();
			$config['use_webp_images'] = true;
			WPO_Cache_Config::instance()->update($config);
		}
	}

	/**
	 * Remove files in `uploads/wpo` folder created by htaccess capability tester library which is removed in 3.2.17 version
	 */
	private static function update_3217_remove_htaccess_capability_tester_files() {
		if (self::is_new_install()) return;
		WPO_Uninstall::delete_wpo_folder();
	}
	
	/**
	 * Resets WebP serving method
	 *
	 * We removed `uploads/wpo` folder in 3.2.17, When the redirection is possible
	 * it doesn't cause issues. However, when using alter html method
	 * WPO_WebP_Self_Test::is_webp_served requests a non-existing `uploads/wpo/images/wpo_logo_small.png`
	 * which causes High CPU usage problem
	 */
	private static function update_3218_reset_webp_serving_method() {
		if (self::is_new_install()) return;
		WP_Optimize()->get_webp_instance()->reset_webp_serving_method();
	}
	
	/**
	 * Updates cache config file with date and time format
	 */
	private static function update_3219_modify_cache_config_for_cache_time() {
		if (self::is_new_install()) return;
		$config = WPO_Cache_Config::instance()->get();
		$cache_enabled = $config['enable_page_caching'];
		if ($cache_enabled) {
			WPO_Cache_Config::instance()->update($config);
		}
	}

	/**
	 * Update async loading exclusion UA list
	 */
	private static function update_330_ua_async_exclusion_list() {
		if (self::is_new_install()) return;

		$config = wp_optimize_minify_config();
		$defaults = $config->get_defaults();
		$new_list = $defaults['ualist'];

		$config->update(array(
			'ualist' => $new_list
		));
	}
}

endif;
