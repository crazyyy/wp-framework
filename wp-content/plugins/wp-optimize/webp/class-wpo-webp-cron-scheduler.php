<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WPO_WebP_Cron_Scheduler')) :

class WPO_WebP_Cron_Scheduler {

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->setup_cron_event();
		add_action('wpo_reset_webp_conversion_test_result', array($this, 'reset_webp_conversion_flags'));
	}

	/**
	 * Returns singleton instance of this class
	 *
	 * @return WPO_WebP_Cron_Scheduler Singleton Instance
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Setup cron event to reset webp conversion test result
	 */
	private function setup_cron_event() {
		if (!wp_next_scheduled('wpo_reset_webp_conversion_test_result')) {
			wp_schedule_event(time(), 'wpo_daily', 'wpo_reset_webp_conversion_test_result');
		}
	}

	/**
	 * Reset all webp conversion flags
	 */
	public function reset_webp_conversion_flags() {
		WP_Optimize()->get_webp_instance()->reset_webp_serving_method();
	}
}

endif;
