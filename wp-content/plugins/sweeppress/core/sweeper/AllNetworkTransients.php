<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\NetworkTransients;
use Dev4Press\Plugin\SweepPress\Query\Sitemeta;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AllNetworkTransients extends NetworkTransients {
	protected $_code = 'all-network-transients';

	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	public static function instance() : AllNetworkTransients {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new AllNetworkTransients();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Network Transients", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all network transient records. These options are used for caching purposes by WordPress and plugins.", "sweeppress" );
	}

	public function help() : array {
		return array(
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
			$this->_code => Sitemeta::instance()->all_transients(),
		);
	}
}
