<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\NetworkTransients;
use Dev4Press\Plugin\SweepPress\Query\Sitemeta;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NetworkExpiredTransients extends NetworkTransients {
	protected $_code = 'network-expired-transients';

	public static function instance() : NetworkExpiredTransients {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new NetworkExpiredTransients();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Expired Network Transients", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all network transient records that have expired. These options are used for caching purposes by WordPress and plugins.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Only transient records that have expired will be removed.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Sitemeta::instance()->expired_transients(),
		);
	}
}
