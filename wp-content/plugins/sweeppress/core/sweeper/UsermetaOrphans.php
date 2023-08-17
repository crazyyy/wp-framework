<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Users;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UsermetaOrphans extends Sweeper {
	protected $_code = 'usermeta-orphans';
	protected $_category = 'users';
	protected $_affected_tables = array(
		'usermeta',
	);

	public static function instance() : UsermetaOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new UsermetaOrphans();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Usermeta Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `usermeta` database table that are no longer connected to users.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Orphaned meta records are usually product of broken users deletion, or other issues.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Users::instance()->usermeta_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$removal = Removal::instance()->usermeta_orphans();

		return $this->base_sweep( $removal );
	}
}
