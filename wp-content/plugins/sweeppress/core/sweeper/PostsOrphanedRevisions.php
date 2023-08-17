<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostsOrphanedRevisions extends Sweeper {
	protected $_code = 'posts-orphaned-revisions';
	protected $_category = 'posts';
	protected $_affected_tables = array(
		'posts',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : PostsOrphanedRevisions {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostsOrphanedRevisions();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Posts Orphaned Revisions", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove revisions that are no longer belong to any posts.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "When posts are deleted, all revisions should be deleted, but that doesn't happen always.", "sweeppress" ),
			__( "Revisions no longer having parent posts can't be accessed by WordPress and just take space in the database.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Posts::instance()->posts_revisions_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->posts_orphaned_revisions();

		return $this->base_sweep( $removal );
	}
}
