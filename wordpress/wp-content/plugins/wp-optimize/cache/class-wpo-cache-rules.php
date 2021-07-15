<?php

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * Page caching rules and exceptions
 */

if (!class_exists('WPO_Cache_Config')) require_once('class-wpo-cache-config.php');

require_once dirname(__FILE__) . '/file-based-page-cache-functions.php';

if (!class_exists('WPO_Cache_Rules')) :

class WPO_Cache_Rules {

	/**
	 * Cache config object
	 *
	 * @var mixed
	 */
	public $config;

	/**
	 * Instance of this class
	 *
	 * @var mixed
	 */
	public static $instance;

	public function __construct() {
		$this->config = WPO_Cache_Config::instance()->get();
		$this->setup_hooks();
	}

	/**
	 * Setup hooks/filters
	 */
	public function setup_hooks() {
		add_action('save_post', array($this, 'purge_post_on_update'), 10, 1);
		add_action('wp_trash_post', array($this, 'purge_post_on_update'), 10, 1);
		add_action('comment_post', array($this, 'purge_post_on_comment'), 10, 3);
		add_action('wp_set_comment_status', array($this, 'purge_post_on_comment_status_change'), 10, 1);
		add_action('edit_terms', array($this, 'purge_related_elements_on_term_updated'), 10, 2);
		add_action('set_object_terms', array($this, 'purge_related_elements_on_post_terms_change'), 10, 6);

		/**
		 * List of hooks for which when executed, the cache will be purged
		 *
		 * @param array $actions The actions
		 */
		$purge_on_action = apply_filters('wpo_purge_cache_hooks', array('after_switch_theme', 'wp_update_nav_menu', 'customize_save_after', array('wp_ajax_save-widget', 0), array('wp_ajax_update-widget', 0), 'autoptimize_action_cachepurged'));
		foreach ($purge_on_action as $action) {
			if (is_array($action)) {
				add_action($action[0], array($this, 'purge_cache'), $action[1]);
			} else {
				add_action($action, array($this, 'purge_cache'));
			}
		}
	}

	/**
	 * Purge post cache when there is a new approved comment
	 *
	 * @param  int        $comment_id  Comment ID.
	 * @param  int|string $approved    Comment approved status. can be 0, 1 or 'spam'.
	 * @param  array      $commentdata Comment data array. Always sent be WP core, but a plugin was found that does not send it - https://wordpress.org/support/topic/critical-problems-with-version-3-0-10/
	 */
	public function purge_post_on_comment($comment_id, $approved, $commentdata = array()) {
		if (1 !== $approved) {
			return;
		}

		if (!empty($this->config['enable_page_caching']) && !empty($commentdata['comment_post_ID'])) {
			$post_id = $commentdata['comment_post_ID'];

			WPO_Page_Cache::delete_single_post_cache($post_id);
		}
	}

	/**
	 * Every time a comment's status changes, purge it's parent posts cache
	 *
	 * @param int $comment_id Comment ID.
	 */
	public function purge_post_on_comment_status_change($comment_id) {
		if (!empty($this->config['enable_page_caching'])) {
			$comment = get_comment($comment_id);
			if (is_object($comment) && !empty($comment->comment_post_ID)) WPO_Page_Cache::delete_single_post_cache($comment->comment_post_ID);
		}
	}

	/**
	 * Automatically purge all file based page cache on post changes
	 * We want the whole cache purged here as different parts
	 * of the site could potentially change on post updates
	 *
	 * @param Integer $post_id - WP post id
	 */
	public function purge_post_on_update($post_id) {
		$post_type = get_post_type($post_id);

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || 'revision' === $post_type) {
			return;
		}

		/**
		 * Purge the whole cache if set to true, only the edited post otherwise. Default is false.
		 *
		 * @param boolean $purge_all_cache The default filter value
		 * @param integer $post_id         The saved post ID
		 */
		if (apply_filters('wpo_purge_all_cache_on_update', false, $post_id)) {
			$this->purge_cache();
			return;
		} else {
			if (apply_filters('wpo_delete_cached_homepage_on_post_update', true, $post_id)) WPO_Page_Cache::delete_homepage_cache();
			WPO_Page_Cache::delete_single_post_cache($post_id);
		}
	}

	/**
	 * We use it with edit_terms action filter to purge cached elements related
	 * to updated term when term updated.
	 *
	 * @param int    $term_id  Term taxonomy ID.
	 * @param string $taxonomy Taxonomy slug.
	 */
	public function purge_related_elements_on_term_updated($term_id, $taxonomy) {
		// purge cached page for term.
		$term = get_term($term_id, $taxonomy, ARRAY_A);
		if (is_array($term)) {
			$term_permalink = get_term_link($term['term_id']);
			if (!is_wp_error($term_permalink)) {
				WPO_Page_Cache::delete_cache_by_url($term_permalink, true);
			}
		}

		// get posts which belongs to updated term.
		$posts = get_posts(array(
			'numberposts'      => -1,
			'post_type'        => 'any',
			'fields'           => 'ids',
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_id,
				)
			),
		));

		if (!empty($posts)) {
			foreach ($posts as $post_id) {
				WPO_Page_Cache::delete_single_post_cache($post_id);
			}
		}
	}

	/**
	 * Triggered by set_object_terms action. Used to clear all the terms archives a post belongs to or belonged to before being saved.
	 *
	 * @param int    $object_id  Object ID.
	 * @param array  $terms      An array of object terms.
	 * @param array  $tt_ids     An array of term taxonomy IDs.
	 * @param string $taxonomy   Taxonomy slug.
	 * @param bool   $append     Whether to append new terms to the old terms.
	 * @param array  $old_tt_ids Old array of term taxonomy IDs.
	 */
	public function purge_related_elements_on_post_terms_change($object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids) {

		$post_type = get_post_type($object_id);

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || 'revision' === $post_type) {
			return;
		}

		// get all affected terms.
		$affected_terms_ids = array_unique(array_merge($tt_ids, $old_tt_ids));

		if (!empty($affected_terms_ids)) {
			// walk through all changed terms and purge cached pages for them.
			foreach ($affected_terms_ids as $tt_id) {
				$term = get_term($tt_id, $taxonomy, ARRAY_A);
				if (!is_array($term)) continue;

				$term_permalink = get_term_link($term['term_id']);
				if (!is_wp_error($term_permalink)) {
					WPO_Page_Cache::delete_cache_by_url($term_permalink, true);
				}
			}
		}
	}

	/**
	 * Clears the cache.
	 */
	public function purge_cache() {
		if (!empty($this->config['enable_page_caching'])) {
			wpo_cache_flush();
		}
	}

	/**
	 * Returns an instance of the current class, creates one if it doesn't exist
	 *
	 * @return object
	 */
	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

endif;
