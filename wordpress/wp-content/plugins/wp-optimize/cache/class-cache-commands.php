<?php

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * All cache commands that are intended to be available for calling from any sort of control interface (e.g. wp-admin, UpdraftCentral) go in here. All public methods should either return the data to be returned, or a WP_Error with associated error code, message and error data.
 */
class WP_Optimize_Cache_Commands {

	private $optimizer;

	private $options;

	/**
	 * WP_Optimize_Cache_Commands constructor.
	 */
	public function __construct() {
		$this->optimizer = WP_Optimize()->get_optimizer();
		$this->options = WP_Optimize()->get_options();
	}

	/**
	 * Save cache settings
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function save_cache_settings($data) {

		if (!class_exists('WPO_Cache_Config')) return array(
			'result' => false,
			'message' => "WPO_Cache_Config class doesn't exist",
		);

		$enabled = false;
		$return = array();
		$previous_settings = WPO_Cache_Config::instance()->get();

		// disable cache.
		if (empty($data['cache-settings']['enable_page_caching'])) {
			WPO_Page_Cache::instance()->disable();
		} else {
			// we need to rebuild advanced-cache.php and add WP_CACHE to wp-config.
			$enabled = WPO_Page_Cache::instance()->enable(true);
		}

		if (is_wp_error($enabled)) {
			// disable everything, to avoid half enabled things
			WPO_Page_Cache::instance()->disable();
			// deactivate the setting
			$data['cache-settings']['enable_page_caching'] = null;
			$return['error'] = array(
				'code' => $enabled->get_error_code(),
				'message' => $enabled->get_error_message()
			);
		}
		
		$skip_if_no_file_yet = (!$enabled || is_wp_error($enabled));
		$save_settings_result = WPO_Cache_Config::instance()->update($data['cache-settings'], $skip_if_no_file_yet);

		if ($save_settings_result) {
			WP_Optimize_Page_Cache_Preloader::instance()->cache_settings_updated($data['cache-settings'], $previous_settings);
		}

		$return['result'] = $save_settings_result;
		$return['enabled'] = !empty($data['cache-settings']['enable_page_caching']);

		return $return;

	}

	/**
	 * Purge WP-Optimize page cache.
	 *
	 * @return array
	 */
	public function purge_page_cache() {
		$purged = WP_Optimize()->get_page_cache()->purge();
		$cache_size = WP_Optimize()->get_page_cache()->get_cache_size();
		$wpo_page_cache_preloader = WP_Optimize_Page_Cache_Preloader::instance();

		$response = array(
			'success' => $purged,
			'size' => WP_Optimize()->format_size($cache_size['size']),
			'file_count' => $cache_size['file_count'],
		);

		// if scheduled preload enabled then reschedule and run preloader.
		if ($wpo_page_cache_preloader->is_scheduled_preload_enabled()) {
			// cancel preload and reschedule preload action.
			$wpo_page_cache_preloader->cancel_preload();
			$wpo_page_cache_preloader->reschedule_preload();

			// run preloader.
			$wpo_page_cache_preloader->run('scheduled', $response);
		}

		return $response;
	}

	/**
	 * Run cache preload action.
	 *
	 * @return void|array - Doesn't return anything if run() is successfull (Run() prints a JSON object and closed browser connection) or an array if failed.
	 */
	public function run_cache_preload() {
		return WP_Optimize_Page_Cache_Preloader::instance()->run('manual');
	}

	/**
	 * Cancel cache preload action.
	 *
	 * @return array
	 */
	public function cancel_cache_preload() {
		WP_Optimize_Page_Cache_Preloader::instance()->cancel_preload();
		return WP_Optimize_Page_Cache_Preloader::instance()->get_status_info();
	}

	/**
	 * Get status of cache preload.
	 *
	 * @return array
	 */
	public function get_cache_preload_status() {
		return WP_Optimize_Page_Cache_Preloader::instance()->get_status_info();
	}

	/**
	 * Enable or disable browser cache.
	 *
	 * @param array $params - ['browser_cache_expire' => '1 month 15 days 2 hours' || '' - for disable cache]
	 * @return array
	 */
	public function enable_browser_cache($params) {
		return WP_Optimize()->get_browser_cache()->enable_browser_cache_command_handler($params);
	}
}
