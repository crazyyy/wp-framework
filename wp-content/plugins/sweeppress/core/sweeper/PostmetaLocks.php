<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostmetaLocks extends Sweeper {
	protected $_code = 'postmeta-locks';
	protected $_category = 'posts';
	protected $_affected_tables = array(
		'postmeta',
	);

	protected $_flag_auto_cleanup = false;

	protected $_flag_bulk_network = true;

	public static function instance() : PostmetaLocks {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostmetaLocks();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Postmeta Locks", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all '_edit_lock' records from the `postmeta` database table.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Records for '_edit_lock' are created while any user edits any post.", "sweeppress" ),
			__( "While present, only one user can edit posts with '_edit_lock' in place.", "sweeppress" ),
			__( "In some cases, removal or update of these records can became problematic on some setups.", "sweeppress" ),
			__( "If you remove these records, try doing it when you are sure that posts are not edited.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper is not available from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Posts::instance()->postmeta_record_status( '_edit_lock' ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->postmeta_by_key( '_edit_lock' );

		return $this->base_sweep( $removal );
	}
}
