<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\CommentType;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TrackbacksCleanup extends CommentType {
	protected $_code = 'trackbacks-cleanup';
	protected $_comment_type = 'trackback';

	protected $_flag_bulk_network = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_comments-trackbacks', 'sweepers', 14 );
	}

	public static function instance() : TrackbacksCleanup {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new TrackbacksCleanup();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Trackbacks Cleanup", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove trackbacks from the database.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "Trackbacks are rarely used in recent years, because they can be a huge source of spam.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep related comments from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}
}
