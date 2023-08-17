<?php

namespace Dev4Press\Plugin\SweepPress\Base\Sweep;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Data;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\ActionScheduler;
use Dev4Press\v42\Core\Quick\Str;

abstract class ActionSchedulerActions extends Sweeper {
	protected $_entry_status = '';
	protected $_category = 'actionscheduler';
	protected $_days_to_keep = 0;
	protected $_affected_tables = array(
		'actionscheduler_actions',
		'actionscheduler_logs',
	);

	protected $_flag_quick_cleanup = false;
	protected $_flag_auto_cleanup = false;
	protected $_flag_bulk_network = true;

	public function __construct() {
		parent::__construct();

		$this->_days_to_keep = sweeppress_settings()->get( 'keep_days_actionscheduler-' . $this->_entry_status, 'sweepers', 0 );
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s action", "%s actions", $value, "sweeppress" );
	}

	public function list_tasks() : array {
		return Data::get_actionscheduler_groups();
	}

	public function help() : array {
		return array(
			__( "ActionScheduler is a system shared and used by various WordPress plugins, including WooCommerce, RankMath and many others.", "sweeppress" ),
			__( "Each action can be associated to the group. You can delete actions for selected groups only.", "sweeppress" ),
			__( "'No Group' actions are registered without the group. In some versions of the scheduler this was allowed.", "sweeppress" ),
			__( "Deleting action with also remove all the associated log entries for the action.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
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

		$this->_tasks = array_merge( $this->_tasks, ActionScheduler::instance()->actions_records( (array) $this->_entry_status, $this->_days_to_keep ) );
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

				$removal = Removal::instance()->actionscheduler_actions_records_for_status( (array) $this->_entry_status, $id, $this->_days_to_keep );

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
