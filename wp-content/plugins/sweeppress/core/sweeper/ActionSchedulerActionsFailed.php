<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\ActionSchedulerActions;

class ActionSchedulerActionsFailed extends ActionSchedulerActions {
	protected $_code = 'actionscheduler-actions-failed';
	protected $_entry_status = 'failed';

	public static function instance() : ActionSchedulerActionsFailed {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ActionSchedulerActionsFailed();
		}

		return $instance;
	}

	public function title() : string {
		return __( "ActionScheduler Failed Actions", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all the failed actions from the ActionScheduler.", "sweeppress" );
	}

	public function help() : array {
		$help = parent::help();

		$help[] = __( "Only actions with the 'Failed' status will be removed by this sweeper.", "sweeppress" );

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep failed actions from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}
}
