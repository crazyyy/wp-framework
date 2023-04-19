<?php
if (!defined('ABSPATH')) {
	die('No direct access allowed');
}

/**
 * Adds compatibility for Polylang plugin.
 */
class WPO_Polylang_Compatibility {

	/**
	 * Instance of this class
	 *
	 * @var WPO_Polylang_Compatibility|null
	 */
	protected static $instance = null;
	
	/**
	 * Constructor.
	 */
	private function __construct() {
		// Check if polylang is active
		if (!class_exists('Polylang')) {
			return;
		}

		// Add action hooks to delete cache for all languages
		add_action('wpo_single_post_cache_deleted', array($this, 'polylang_delete_post_cache_for_all_languages'));
		add_action('wpo_single_post_feed_cache_deleted', array($this, 'polylang_delete_post_feed_cache_for_all_languages'));
	}

	/**
	 * Returns singleton instance.
	 *
	 * @return WPO_Polylang_Compatibility
	 */
	public static function instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Deletes cache files for all connected langauges for a post.
	 *
	 * @param int $deleted_post_id Post id whose cache file is already deleted.
	 */
	public function polylang_delete_post_cache_for_all_languages($deleted_post_id) {

		// Check if polylang translation function is available
		if (!function_exists('pll_get_post_translations')) {
			return;
		}

		$translated_post_ids = pll_get_post_translations($deleted_post_id);

		// Delete cache for each translated post
		foreach ($translated_post_ids as $post_id) {
			if ($deleted_post_id !== $post_id) {
				WPO_Page_Cache::really_delete_single_post_cache($post_id);
			}
		}
	}

	/**
	 * Deletes cache files for all connected langauges for a post feed.
	 *
	 * @param int $deleted_post_id Post id whose cache file for feed is already deleted.
	 */
	public function polylang_delete_post_feed_cache_for_all_languages($deleted_post_id) {
		
		// Check if polylang translation function is available
		if (!function_exists('pll_get_post_translations')) {
			return;
		}

		$translated_post_ids = pll_get_post_translations($deleted_post_id);

		// Delete cache for each translated post
		foreach ($translated_post_ids as $post_id) {
			if ($deleted_post_id !== $post_id) {
				WPO_Page_Cache::really_delete_post_feed_cache($post_id);
			}
		}
	}
}
