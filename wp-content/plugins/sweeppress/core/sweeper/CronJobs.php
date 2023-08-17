<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CronJobs extends Sweeper {
	protected $_code = 'cron-jobs';
	protected $_category = 'options';
	protected $_affected_tables = array(
		'options',
	);

	protected $_flag_auto_cleanup = false;
	protected $_flag_monitor_task = false;

	protected $_flag_bulk_network = true;

	public static function instance() : CronJobs {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new CronJobs();
		}

		return $instance;
	}

	public function title() : string {
		return __( "CRON Jobs", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all currently scheduled CRON Jobs in WordPress CRON Scheduler", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Once cleared, jobs from active plugins and WordPress core will be recreated on next page load.", "sweeppress" ),
			__( "This is useful to remove scheduled jobs from plugins that are no longer in use.", "sweeppress" ),
			__( "All CRON Jobs are stored inside the single record.", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used from Dashboard for Auto Sweep and Monitor Task.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			$this->_code => Options::instance()->all_cron_jobs(),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 1,
			'size'    => 0,
			'tasks'   => array(),
		);

		if ( in_array( $this->_code, $tasks ) ) {
			$input = Options::instance()->all_cron_jobs();

			$results['tasks'][ $this->_code ] = $input['title'];
			$results['size']                  += $input['size'];

			Removal::instance()->cron_jobs();
		}

		return $results;
	}
}
