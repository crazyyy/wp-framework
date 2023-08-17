<?php

namespace Dev4Press\Plugin\SweepPress\Sweeper;

use Dev4Press\Plugin\SweepPress\Base\Sweeper;
use Dev4Press\Plugin\SweepPress\Basic\Removal;
use Dev4Press\Plugin\SweepPress\Query\Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PostmetaOld extends Sweeper {
	protected $_code = 'postmeta-old';
	protected $_category = 'posts';
	protected $_version = '2.1';
	protected $_affected_tables = array(
		'postmeta',
	);

	protected $_flag_auto_cleanup = false;
	protected $_flag_quick_cleanup = false;
	protected $_flag_monitor_task = false;
	protected $_flag_scheduled_cleanup = false;

	protected $_flag_single_task = false;

	protected $_flag_bulk_network = true;

	public static function instance() : PostmetaOld {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new PostmetaOld();
		}

		return $instance;
	}

	public function title() : string {
		return __( "Postmeta Old Posts Data", "sweeppress" );
	}

	public function description() : string {
		return __( "Remove all '_wp_old_*' records from the `postmeta` database table.", "sweeppress" );
	}

	public function help() : array {
		return array(
			__( "Currently, this includes '_wp_old_slug' and '_wp_old_date' meta records.", "sweeppress" ),
			__( "Record for '_wp_old_slug' is used to redirect posts with changed URL slugs, and it is useful if you change post URL slugs after post is published.", "sweeppress" ),
			__( "Do not remove records for '_wp_old_slug' if you change post URL slugs after post is published, because without these records, old URLs will no longer work.", "sweeppress" ),
			__( "Record for '_wp_old_date' is used for finding posts by old dates, if you have changed post date after post publishing.", "sweeppress" ),
			__( "Record for '_wp_old_date' is also linked to the old slug redirection code, and if you change post dates after publishing, these records should not be removed.", "sweeppress" ),
			__( "Both of these record types should not be removed, unless you absolutely sure you understand their use, and you are sure that you will not need them later on!", "sweeppress" ),
		);
	}

	public function limitations() : array {
		return array(
			__( "This sweeper can't be used for scheduled jobs and it is not available from the Dashboard for Quick or Auto Sweep.", "sweeppress" ),
			__( "Make sure to check out the Help information provided for this sweeper to better understand these limitations.", "sweeppress" ),
		);
	}

	public function list_tasks() : array {
		return array(
			'_wp_old_slug' => __( "WP Old Slug", "sweeppress" ),
			'_wp_old_date' => __( "WP Old Date", "sweeppress" ),
		);
	}

	public function prepare() {
		$this->_tasks = array(
			'_wp_old_slug' => Posts::instance()->postmeta_record_status( '_wp_old_slug' ),
			'_wp_old_date' => Posts::instance()->postmeta_record_status( '_wp_old_date' ),
		);
	}

	public function sweep( $tasks = array() ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$start = $this->get_tasks();

		foreach ( $tasks as $name ) {
			$task = $start[ $name ] ?? array( 'records' => 0 );

			if ( $task['records'] > 0 ) {
				$removal = Removal::instance()->postmeta_by_key( $name );

				if ( is_wp_error( $removal ) ) {
					$results['tasks'][ $name ] = $removal;
				} else {
					$results['tasks'][ $name ] = $task['title'];
					$results['records']        += $task['records'];
					$results['size']           += $task['size'];
				}
			}
		}

		return $results;
	}
}
