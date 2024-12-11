<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_404_Detector_Cron')) :

class WP_Optimize_404_Detector_Cron {

	/**
	 * Class constructor
	 */
	private function __construct() {
		$this->initialize();
	}
	
	/**
	 * Initialize the class as a singleton
	 *
	 * @return WP_Optimize_404_Detector_Cron
	 */
	public static function get_instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}

	/**
	 * Initialize class actions
	 */
	public function initialize() {
		if (WP_Optimize()->get_options()->get_option('404_detector')) {
			$this->setup_cron_event();
		} else {
			$this->remove_cron_event();
		}
	}

	/**
	 * Schedule cron event
	 */
	private function setup_cron_event() {
		if (!wp_next_scheduled('wpo_prune_404_log')) {
			wp_schedule_event(time(), 'wpo_daily', 'wpo_prune_404_log');
		}
	}

	/**
	 * Remove scheduled cron event
	 */
	private function remove_cron_event() {
		wp_clear_scheduled_hook('wpo_prune_404_log');
	}
}

endif;
