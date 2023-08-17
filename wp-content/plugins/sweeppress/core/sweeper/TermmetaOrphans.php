<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Terms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TermmetaOrphans extends Sweeper {
	protected $_code = 'termmeta-orphans';
	protected $_category = 'terms';
	protected $_affected_tables = array(
		'termmeta',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : TermmetaOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new TermmetaOrphans();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Termmeta Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `termmeta` database table that are no longer connected to terms.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Orphaned meta records are usually product of broken terms deletion, or other issues.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Terms::instance()->termmeta_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->termmeta_orphans();

		return $this->base_sweep( $removal );
	}
}
