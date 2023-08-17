<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostmetaEdits extends Sweeper {
	protected $_code = 'postmeta-edits';
	protected $_category = 'posts';
	protected $_affected_tables = array(
		'postmeta',
	);

	protected $_flag_auto_cleanup = false;

	protected $_flag_bulk_network = true;

	public static function instance() : PostmetaEdits {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostmetaEdits();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Postmeta Last Edits", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all '_edit_last' records from the `postmeta` database table.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Records for '_edit_last' are created to indicate user who edited the post last.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper is not available from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Posts::instance()->postmeta_record_status( '_edit_last' ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->postmeta_by_key( '_edit_last' );

		return $this->base_sweep( $removal );
	}
}
