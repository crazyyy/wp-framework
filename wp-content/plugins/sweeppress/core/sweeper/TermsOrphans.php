<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Terms;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TermsOrphans extends Sweeper {
	protected $_code = 'terms-orphans';
	protected $_category = 'terms';
	protected $_affected_tables = array(
		'termmeta',
		'terms',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : TermsOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new TermsOrphans();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s term", "%s terms", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Terms Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `terms` database table that are no longer connected to taxonomies.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "This is very rare issue, but it can happen with the terms deletion process.", "sweeppress" ),
			__( "Terms no longer connected to taxonomies can't be used by WordPress.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Terms::instance()->terms_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->terms_orphans();

		return $this->base_sweep( $removal );
	}
}
