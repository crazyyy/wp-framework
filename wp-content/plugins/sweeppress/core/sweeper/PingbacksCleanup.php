<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\CommentType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PingbacksCleanup extends CommentType {
	protected $_code = 'pingbacks-cleanup';
	protected $_comment_type = 'pingback';

	protected $_flag_auto_cleanup = false;

	protected $_flag_bulk_network = true;

	public static function instance() : PingbacksCleanup {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PingbacksCleanup();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Pingbacks Cleanup", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove pingbacks from the database.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "Pingbacks are rarely used in recent years, because they can be a huge source of spam.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep related comments from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}

	public function limitations() : array {
		return array(
			__( "This sweeper is not available from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
		);
	}
}
