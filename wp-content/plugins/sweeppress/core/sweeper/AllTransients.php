<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\BlogTransients;
use Dev4Press\Plugin\SweepPress\Query\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AllTransients extends BlogTransients {
	protected $_code = 'all-transients';

	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	public static function instance() : AllTransients {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new AllTransients();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Transients", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all transient records. These options are used for caching purposes by WordPress and plugins.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "This also includes all the RSS Feeds, they are all stored as transients.", "sweeppress" ),
			__( "Transients are very often used for cache by WordPress and plugins, and it is not advisable to remove them too often.", "sweeppress" ),
			__( "When you remove transients, if the plugins that created them are still active, they will create them again when needed.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from Dashboard for Auto Sweep and Monitor Task.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Options::instance()->all_transients(),
		);
	}
}
