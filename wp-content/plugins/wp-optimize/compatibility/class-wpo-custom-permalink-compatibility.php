<?php
if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * Adds compatibility for Custom Permalink plugin.
 */
class WPO_Custom_Permalink_Compatibility {

	/**
	 * Constructor.
	 */
	private function __construct() {
		if (!class_exists('Custom_Permalinks')) return;

		add_filter('custom_permalink_before_saving', array($this, 'custom_permalink_before_saving'), 10, 1);
		add_filter('pre_update_option_custom_permalink_table', array($this, 'pre_update_option_custom_permalink_table'), 10, 2);
		add_action('update_option_permalink_structure', array($this, 'update_option_permalink_structure'), 10, 2);
	}

	/**
	 * Returns singleton instance.
	 */
	public static function instance() {
		static $instance = null;
		if (null == $instance) {
			$instance = new static;
		}

		return $instance;
	}

	/**
	 * Modifies post's custom permalink based on site's permalink structure
	 *
	 * @param string $permalink
	 *
	 * @return string
	 */
	public function custom_permalink_before_saving($permalink) {
		return $this->fix_permalink($permalink);
	}

	/**
	 * Updates custom permalink table option based on site's permalink structure
	 *
	 * @param mixed $value
	 * @param mixed $old_value
	 *
	 * @return mixed
	 */
	public function pre_update_option_custom_permalink_table($value, $old_value) {
		if ($old_value === $value) return $value;

		if (is_string($value)) {
			return $this->fix_permalink($value);
		}
		$new_value = array();
		foreach ($value as $key => $item) {
			$new_key = $this->fix_permalink($key);
			$new_value[$new_key] = $item;
		}
		return $new_value;
	}

	/**
	 * Decides whether permalink structure has trailing slash or not
	 *
	 * @return bool
	 */
	private function does_permalink_have_trailingslash() {
		$permalink_structure = get_option('permalink_structure', '');
		return '/' === substr($permalink_structure, -1);
	}

	/**
	 * Adds/Removes trailing slash based on permalink structure
	 *
	 * @param string $permalink
	 *
	 * @return string
	 */
	private function fix_permalink($permalink) {
		if ($this->does_permalink_have_trailingslash()) {
			$permalink = trailingslashit($permalink);
		} else {
			$permalink = untrailingslashit($permalink);
		}
		return $permalink;
	}

	/**
	 * Updates custom permalinks
	 *
	 * @param mixed $old_value
	 * @param mixed $new_value
	 *
	 * @return void
	 */
	public function update_option_permalink_structure($old_value, $new_value) {
		if ($old_value === $new_value) return;
		$this->update_terms_custom_permalinks();
		$this->update_posts_custom_permalinks();
	}

	/**
	 * Updates terms custom permalinks
	 *
	 * @return void
	 */
	private function update_terms_custom_permalinks() {
		$terms_custom_permalinks = get_option('custom_permalink_table');
		if ($terms_custom_permalinks) {
			$custom_permalink_table = $this->pre_update_option_custom_permalink_table($terms_custom_permalinks, array());
			update_option('custom_permalink_table', $custom_permalink_table);
		}
	}

	/**
	 * Updates post custom permalinks for all post types
	 *
	 * @return void
	 */
	private function update_posts_custom_permalinks() {
		$post_types = get_post_types(array('public' => true), 'names');
		$args = array(
			'post_type' => $post_types,
			'posts_per_page' => -1,
		);
		$posts = get_posts($args);

		foreach ($posts as $post) {
			$permalink = get_post_meta($post->ID, 'custom_permalink', true);
			if (empty($permalink)) continue;
			$permalink = $this->fix_permalink($permalink);
			update_post_meta($post->ID, 'custom_permalink', $permalink);
		}
	}
}
