<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Comments;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CommentsOrphans extends Sweeper {
	protected $_code = 'comments-orphans';
	protected $_category = 'comments';
	protected $_affected_tables = array(
		'commentmeta',
		'comments',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : CommentsOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new CommentsOrphans();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s comment", "%s comments", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Orphaned Comments", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove comments that don't belong to any of the existing posts.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "These comments are not visible via WordPress Comments panel.", "sweeppress" ),
			__( "If you plan to reassign the comments to other, available posts, you can do it only directly in database.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Comments::instance()->comments_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->comments_orphans();

		return $this->base_sweep( $removal );
	}
}
