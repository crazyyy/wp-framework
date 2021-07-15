<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_WebP')) :

class WP_Optimize_WebP {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->get_converter_status();
	}

	/**
	 * Test Run and find converter status
	 */
	public function get_converter_status() {
		include_once WPO_PLUGIN_MAIN_PATH . 'webp/class-wpo-webp-test-run.php';
		$converters = WP_Optimize()->get_options()->get_option('webp_converters', false);

		if (false === $converters) {
			$converter_status = WPO_WebP_Test_Run::get_converter_status();
			WP_Optimize()->get_options()->update_option('webp_converters', $converter_status['working_converters']);
		}
	}
}

endif;

new WP_Optimize_WebP();
