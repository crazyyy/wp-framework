<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostmetaOrphans extends Sweeper {
	protected $_code = 'postmeta-orphans';
	protected $_category = 'posts';
	protected $_affected_tables = array(
		'postmeta',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : PostmetaOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostmetaOrphans();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Postmeta Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `postmeta` database table that are no longer connected to posts.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Orphaned meta records are usually product of broken posts deletion, or other issues.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Posts::instance()->postmeta_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->postmeta_orphans();

		return $this->base_sweep( $removal );
	}
}
