<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Query\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OptimizeTables extends Sweeper {
	protected $_code = 'optimize-tables';
	protected $_category = 'database';

	protected $_flag_single_task = false;
	protected $_flag_quick_cleanup = false;
	protected $_flag_scheduled_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	protected $_flag_bulk_network = true;

	public static function instance() : OptimizeTables {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new OptimizeTables();
		}

		return $instance;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s table", "%s tables", $value, "sweeppress" );
	}

	public function title() : string {
		return __( "Optimize Database Tables", "sweeppress" );
	}

	public function description() : string {
		return __( "Optimize database tables that need optimizations based on free space fragmentation.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "It is a bad idea to optimize every table without it being fragmented or with a lot of free space taken.", "sweeppress" ),
			__( "It is a bad idea to optimize often, especially with large tables: in most cases, optimization will make full copy of the table first.", "sweeppress" ),
			__( "Only tables related to WordPress installation will be taken into account (using proper prefix in table name).", "sweeppress" ),
			__( "Only tables with certain amount of fragmented data will be included for cleanup. You can change that in plugin settings.", "sweeppress" ),
			__( "For smaller tables that experience changes often, fragmented space will remain even after optimization.", "sweeppress" ),
			__( "InnoDB table engine doesn't report real time statistics, so even after optimization, it may show that nothing has changed.", "sweeppress" ),
			__( "Even after optimization is done, depending on the database setup, it might still report fragmented data.", "sweeppress" ),
			__( "In some cases, the process might not work at all if the optimization is not supported by the server.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for scheduled jobs and it is not available from the Dashboard for Quick and Auto Sweep and Monitor Task.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = Database::instance()->optimize_tables();

		if ( empty( $this->_tasks ) ) {
			$this->_tasks = array(
				$this->_code => array(
					'title'   => __( "Fragmented Tables", "sweeppress" ),
					'items'   => 0,
					'records' => 0,
					'size'    => 0,
				),
			);
		}
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
			'info'    => array(),
		);

		if ( count( $tasks ) > 0 && ! in_array( $this->_code, $tasks ) ) {
			$start = $this->get_tasks();

			foreach ( $tasks as $name ) {
				$task = $start[ $name ] ?? array( 'size' => 0 );

				if ( $task['size'] > 0 ) {
					$results['tasks'][ $name ] = $name;

					if ( ! SWEEPPRESS_SIMULATION ) {
						if ( sweeppress_settings()->get( 'db_table_optimize_method' ) == 'alter' ) {
							$results['info'][ $name ] = sweeppress_db()->alter_table_force( $name );
							$results['size']          += $task['size'];
						} else {
							$results['info'][ $name ] = sweeppress_db()->optimize_table( $name );

							if ( empty( $results['info'][ $name ]['error'] ) ) {
								$results['size'] += $task['size'];

								if ( sweeppress_settings()->get( 'db_table_optimize_method' ) == 'both' ) {
									sweeppress_db()->alter_table_force( $name );
								}
							}
						}

						sweeppress_prepare()->analyze_table( $name );
					} else {
						$results['size'] += $task['size'];
					}
				}
			}
		}

		return $results;
	}
}
