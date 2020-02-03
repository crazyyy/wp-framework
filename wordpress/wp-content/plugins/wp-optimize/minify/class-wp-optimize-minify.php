<?php
if (!defined('ABSPATH')) die('No direct access allowed');

define('WP_OPTIMIZE_MINIFY_VERSION', '2.6.5');
define('WP_OPTIMIZE_MINIFY_DIR', dirname(__FILE__));
if (!defined('WP_OPTIMIZE_SHOW_MINIFY_ADVANCED')) define('WP_OPTIMIZE_SHOW_MINIFY_ADVANCED', false);

if (!class_exists('WP_Optimize_Minify_Admin')) {
	include WP_OPTIMIZE_MINIFY_DIR.'/class-wp-optimize-minify-admin.php';
}
if (WPO_MINIFY_PHP_VERSION_MET && !class_exists('WP_Optimize_Minify_Fe')) {
	include WP_OPTIMIZE_MINIFY_DIR.'/class-wp-optimize-minify-fe.php';
}
if (WPO_MINIFY_PHP_VERSION_MET && !class_exists('WP_Optimize_Minify_Cache_Functions')) {
	include WP_OPTIMIZE_MINIFY_DIR.'/class-wp-optimize-minify-cache-functions.php';
}
if (!class_exists('WP_Optimize_Minify_Config')) {
	include WP_OPTIMIZE_MINIFY_DIR.'/class-wp-optimize-minify-config.php';
}

/**
 * Directory that stores the cache, including gzipped files and mobile specifc cache
 */
if (!defined('WPO_CACHE_MIN_FILES_DIR')) define('WPO_CACHE_MIN_FILES_DIR', untrailingslashit(WP_CONTENT_DIR).'/cache/wpo-minify');
if (!defined('WPO_CACHE_MIN_FILES_URL')) define('WPO_CACHE_MIN_FILES_URL', untrailingslashit(WP_CONTENT_URL).'/cache/wpo-minify');


class WP_Optimize_Minify {
	/**
	 * Constructor - Initialize actions and filters
	 *
	 * @return void
	 */
	public function __construct() {
		new WP_Optimize_Minify_Admin();

		// Don't run the rest if PHP requirement isn't met
		if (!WPO_MINIFY_PHP_VERSION_MET) return;

		if (wp_optimize_minify_config()->is_enabled()) {
			new WP_Optimize_Minify_Fe();
		}
		// cron job to delete old wpo_min cache
		add_action('wpo_minify_purge_old_cache', array('WP_Optimize_Minify_Cache_Functions', 'purge_old'));
		// front-end actions; skip on certain post_types or if there are specific keys on the url or if editor or admin
	}

	/**
	 * Run during activation
	 * Increment cache first as it will save files to that dir
	 *
	 * @return void
	 */
	public function plugin_activate() {
		// increment cache time
		WP_Optimize_Minify_Cache_Functions::cache_increment();
		
		// old cache purge event cron
		wp_clear_scheduled_hook('wpo_minify_purge_old_cache');
		if (!wp_next_scheduled('wpo_minify_purge_old_cache')) {
			wp_schedule_event(time() + 86400, 'daily', 'wpo_minify_purge_old_cache');
		}
	}

	/**
	 * Run during plugin deactivation
	 *
	 * @return void
	 */
	public function plugin_deactivate() {
		WP_Optimize_Minify_Cache_Functions::purge_temp_files();
		WP_Optimize_Minify_Cache_Functions::purge_old();
		WP_Optimize_Minify_Cache_Functions::purge_others();

		// old cache purge event cron
		wp_clear_scheduled_hook('wpo_minify_purge_old_cache');
	}

	/**
	 * Run during plugin uninstall
	 *
	 * @return void
	 */
	public function plugin_uninstall() {
		// remove options from DB
		wp_optimize_minify_config()->purge();
		// remove minified files
		WP_Optimize_Minify_Cache_Functions::purge();
		WP_Optimize_Minify_Cache_Functions::purge_others();
	}
}
