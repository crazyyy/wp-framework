<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Query\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RepairTables extends Sweeper {
	protected $_code = 'repair-tables';
	protected $_category = 'database';
	protected $_version = '1.6';

	protected $_flag_single_task = false;
	protected $_flag_quick_cleanup = false;
	protected $_flag_scheduled_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	protected $_flag_bulk_network = true;

	protected $_sweepable_records_size = false;

	public static function instance() : RepairTables {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new RepairTables();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s table", "%s tables", $value, "sweeppress" );
	}

	public function tasks_count_n( int $value ) : string {
		return _n( "%s table", "%s tables", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Repair Database Tables", "sweeppress" );
	}

	public function description() : string {
		return __( "Attempt to repair database tables that are marked as broken or crashed.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Only tables related to WordPress installation will be taken into account (using proper prefix in table name).", "sweeppress" ),
			__( "Repair process might fail in some cases, or it can result in loss of data (especially related to the time of the table crashing).", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for scheduled jobs and it is not available from the Dashboard for Quick and Auto Sweep and Monitor Task.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = Database::instance()->repair_tables();
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
			'info'    => array(),
		);

		if ( count( $tasks ) > 0 && ! in_array( $this->_code, $tasks ) ) {
			foreach ( $tasks as $name ) {
				$results['tasks'][ $name ] = $name;

				if ( ! SWEEPPRESS_SIMULATION ) {
					$results['info'][ $name ] = sweeppress_db()->repair_table( $name );
				}
			}
		}

		return $results;
	}
}
