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
		Updraft_Smush_Manager::instance()->delete_log_files();
		Updraft_Tasks_Activation::uninstall(WPO_PLUGIN_SLUG);
		self::delete_wpo_folder();

		$wpo_plugins_table_list = self::get_upload_basedir() . 'wpo-plugins-tables-list.json';
		if (is_file($wpo_plugins_table_list)) {
			@unlink($wpo_plugins_table_list); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress error due to file permission issues
		}
	}

	/**
	 * Returns absolute path to uploads folder
	 *
	 * @return string
	 */
	private static function get_upload_basedir() {
		$upload_dir = wp_get_upload_dir();
		return trailingslashit($upload_dir['basedir']);
	}

	/**
	 * Returns an array of sub folders in `uploads/wpo` folder
	 *
	 * @return array
	 */
	private static function get_wpo_sub_folders() {
		$sub_folders =  array(
			'add-type',
			'content-digest',
			'crash-tester',
			'directory-index',
			'header-set',
			'images',
			'module-loaded',
			'rewrite',
			'server-signature',
		);
		return apply_filters('wpo_uploads_sub_folders', $sub_folders);
	}

	/**
	 * Delete `uploads/wpo` sub folders and if it is empty delete the folder itself
	 */
	public static function delete_wpo_folder() {
		$wpo_folder = self::get_upload_basedir() . trailingslashit('wpo');
		require_once WPO_PLUGIN_MAIN_PATH . '/cache/file-based-page-cache-functions.php';
		if (is_dir($wpo_folder)) {
			$wpo_sub_folders = self::get_wpo_sub_folders();
			foreach ($wpo_sub_folders as $folder) {
				wpo_delete_files($wpo_folder . $folder);
			}
			$files = @scandir($wpo_folder); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress warning if it arises due to race condition
			if (false === $files) return;
			if (2 === count($files)) {
				@rmdir($wpo_folder); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress error due to file permission issues
			}
		}
	}
}

endif;
