<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\ActionScheduler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActionSchedulerLogOrphans extends Sweeper {
	protected $_code = 'actionscheduler-log-orphans';
	protected $_category = 'actionscheduler';
	protected $_affected_tables = array(
		'actionscheduler_logs',
	);

	protected $_flag_bulk_network = true;

	public static function instance() : ActionSchedulerLogOrphans {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ActionSchedulerLogOrphans();
		}

		return $instance;
	}

	public function title() : string {
		return __( "ActionScheduler Log Orphans", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `actionscheduler_logs` database table that are no longer connected to actions.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "ActionScheduler is a system shared and used by various WordPress plugins, including WooCommerce, RankMath and many others.", "sweeppress" ),
			__( "Orphaned log records are usually product of broken actions deletion, or other issues.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => ActionScheduler::instance()->log_orphaned_status(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$this->log_sweep_start();

		$removal = Removal::instance()->actionscheduler_log_orphaned_records();

		return $this->base_sweep( $removal );
	}
}
