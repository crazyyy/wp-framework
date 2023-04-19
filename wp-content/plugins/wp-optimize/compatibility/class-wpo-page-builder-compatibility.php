<?php
if (!defined('ABSPATH')) {
	die('No direct access allowed');
}

/**
 * Adds compatibility for Page Builder plugins.
 */
class WPO_Page_Builder_Compatibility {

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->disable_webp_alter_html_in_edit_mode();
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
	 * Checks if current page is in Page Builder edit mode.
	 *
	 * @return bool
	 */
	private function is_edit_mode() {
		return isset($_GET['fl_builder']) || isset($_GET['et_fb']);
	}

	/**
	 * Disables altering HTML for WebP when current page is in edit mode.
	 */
	private function disable_webp_alter_html_in_edit_mode() {
		if ($this->is_edit_mode()) {
			add_filter('wpo_disable_webp_alter_html', '__return_true');
		}
	}
}
