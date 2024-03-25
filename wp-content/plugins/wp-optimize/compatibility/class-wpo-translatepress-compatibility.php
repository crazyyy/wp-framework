<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WPO_TranslatePress_Compatibility')) :
/**
 * Adds compatibility for TranslatePress plugin.
 */
class WPO_TranslatePress_Compatibility {

	private $trp_settings;
	
	/**
	 * Constructor.
	 */
	private function __construct() {
		// Bail out if TranslatePress is not active
		if (!class_exists('TRP_Translate_Press')) return;

		// Using the TranslatePress instance retrieve the settings
		$this->trp_settings = TRP_Translate_Press::get_trp_instance()->get_component('settings')->get_settings();
		// Add action hooks to delete cache for all languages
		add_action('wpo_single_post_cache_deleted', array($this, 'translatepress_delete_post_cache_for_all_languages'));
		add_action('wpo_single_post_feed_cache_deleted', array($this, 'translatepress_delete_post_feed_cache_for_all_languages'));
	}

	/**
	 * Returns singleton instance.
	 *
	 * @return WPO_TranslatePress_Compatibility
	 */
	public static function instance() {
		static $_instance;
		if (null === $_instance) {
			$_instance = new self();
		}

		return $_instance;
	}

	/**
	 * Deletes cache files for all connected languages for a post.
	 *
	 * @param int $deleted_post_id Post id whose cache file is already deleted.
	 */
	public function translatepress_delete_post_cache_for_all_languages($deleted_post_id) {

		$deleted_post_url = get_permalink($deleted_post_id);
		$homepage_url = get_home_url(get_current_blog_id());
		$post_path = str_replace($homepage_url, "", $deleted_post_url);

		// Retrieve the url slugs from TranslatePress setting options
		$url_slugs = $this->trp_settings['url-slugs'];
		foreach ($url_slugs as $value) {
			// Build url using the url-slugs and the path of the deleted post
			$possible_lang_url = $homepage_url. '/' . $value . $post_path;
			WPO_Page_Cache::delete_cache_by_url($possible_lang_url);
		}
	}

	/**
	 * Deletes cache files for all connected languages for a post feed.
	 *
	 * @param int $deleted_post_id Post id whose cache file for feed is already deleted.
	 */
	public function translatepress_delete_post_feed_cache_for_all_languages($deleted_post_id) {

		$deleted_post_url = get_permalink($deleted_post_id);
		$homepage_url = get_home_url(get_current_blog_id());
		$post_path = str_replace($homepage_url, "", $deleted_post_url);

		// Retrieve the url slugs from TranslatePress setting options
		$url_slugs = $this->trp_settings['url-slugs'];
		foreach ($url_slugs as $value) {
			// Build url using the url-slugs and the path of the deleted post
			$possible_lang_url = $homepage_url.'/'. $value . untrailingslashit($post_path) . '/feed/';
			WPO_Page_Cache::delete_cache_by_url($possible_lang_url);
		}
	}
}
endif;
