<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CommentmetaOrphans extends Sweeper {
	protected $_code = 'commentmeta-orphans';
	protected $_category = 'comments';
	protected $_affected_tables = array(
		'commentmeta',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : CommentmetaOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new CommentmetaOrphans();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Commentmeta Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `commentmeta` database table that are no longer connected to comments.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Orphaned meta records are usually product of broken comments deletion, or other issues.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Comments::instance()->commentmeta_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->commentmeta_orphans();

		return $this->base_sweep( $removal );
	}
}
