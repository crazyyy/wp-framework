<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Data;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\ActionScheduler;
use Dev4Press\v42\Core\Quick\Str;

class ActionSchedulerLog extends Sweeper {
	protected $_code = 'actionscheduler-log';
	protected $_category = 'actionscheduler';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'actionscheduler_logs',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_bulk_network = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_actionscheduler-log', 'sweepers', 0 );
	}

	public static function instance() : ActionSchedulerLog {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ActionSchedulerLog();
		}

		return $instance;
	}

	public function title() : string {
		return __( "ActionScheduler Log", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all records from the `actionscheduler_logs` database table based on the actions group.", "sweeppress" );
	}

	public function help() : array {
		$help = array(
			__( "ActionScheduler is a system shared and used by various WordPress plugins, including WooCommerce, RankMath and many others.", "sweeppress" ),
			__( "Each log entry is associated to the action, and the action to the group. You can delete log entries for selected groups only.", "sweeppress" ),
			__( "'No Group' actions are registered without the group. In some versions of the scheduler this was allowed.", "sweeppress" ),
		);

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep log entries from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function list_tasks() : array {
		return Data::get_actionscheduler_groups();
	}

	public function prepare() {
		foreach ( $this->list_tasks() as $id => $group ) {
			$this->_tasks[ 'id-' . $id ] = array(
				'real_title' => $group,
				'title'      => trim( Str::slug_to_name( $group, '-' ) ),
				'items'      => 0,
				'records'    => 0,
				'size'       => 0,
			);
		}

		$this->_tasks = array_merge( $this->_tasks, ActionScheduler::instance()->log_records( $this->_days_to_keep ) );
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$start = $this->get_tasks();

		$this->log_sweep_start();

		foreach ( $tasks as $name ) {
			$task = $start[ $name ] ?? array( 'records' => 0 );

			if ( $task['records'] > 0 ) {
				$id = absint( substr( $name, 3 ) );

				$removal = Removal::instance()->actionscheduler_log_records( $id, $this->_days_to_keep );

				if ( is_wp_error( $removal ) ) {
					$results['tasks'][ $name ] = $removal;
				} else {
					$results['tasks'][ $name ] = $task['title'];
					$results['records']        += $task['records'];
					$results['size']           += $task['size'];
				}
			}
		}

		$this->log_sweep_end();

		return $results;
	}
}
