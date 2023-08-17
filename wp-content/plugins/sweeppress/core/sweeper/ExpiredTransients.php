<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\BlogTransients;
use Dev4Press\Plugin\SweepPress\Query\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ExpiredTransients extends BlogTransients {
	protected $_code = 'expired-transients';

	protected $_flag_bulk_network = true;

	public static function instance() : ExpiredTransients {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ExpiredTransients();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Expired Transients", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all transient records that have expired. These options are used for caching purposes by WordPress and plugins.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Only transient records that have expired will be removed.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Options::instance()->expired_transients(),
		);
	}
}
