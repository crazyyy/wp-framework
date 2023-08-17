<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweep\ActionSchedulerActions;

class ActionSchedulerActionsComplete extends ActionSchedulerActions {
	protected $_code = 'actionscheduler-actions-complete';
	protected $_entry_status = 'complete';

	public static function instance() : ActionSchedulerActionsComplete {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ActionSchedulerActionsComplete();
		}

		return $instance;
	}

	public function title() : string {
		return __( "ActionScheduler Completed Actions", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all the completed actions from the ActionScheduler.", "sweeppress" );
	}

	public function help() : array {
		$help = parent::help();

		$help[] = __( "Only actions with the 'Complete' status will be removed by this sweeper.", "sweeppress" );
		$help[] = __( "If you need list of completed actions, or you need to analyze the logs for these actions, either keep them, or delete old completed actions.", "sweeppress" );

		if ( $this->_days_to_keep > 0 ) {
			$help[] = sprintf( __( "This sweeper will keep completed actions from the past %s days. You can adjust the days to keep value in the plugin Settings.", "sweeppress" ), '<strong>' . $this->_days_to_keep . '</strong>' );
		}

		return $help;
	}
}
