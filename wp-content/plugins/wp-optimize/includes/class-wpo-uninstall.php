<?php
if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WPO_Uninstall')) :

class WPO_Uninstall {

	/**
	 * Actions to be performed upon plugin uninstallation
	 */
	public static function actions() {
		WP_Optimize()->get_gzip_compression()->disable();
		WP_Optimize()->get_browser_cache()->disable();
		WP_Optimize()->get_options()->delete_all_options();
		WP_Optimize()->get_minify()->plugin_uninstall();
		WP_Optimize()->get_options()->wipe_settings();
		WP_Optimize()->delete_transients_and_semaphores();
	}
}

endif;
