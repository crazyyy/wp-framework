<?php

namespace Dev4Press\Plugin\SweepPress\Expand;

use Dev4Press\v42\Core\Quick\File;
use WP_CLI;
use WP_CLI\Formatter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Run database sweeping tasks via SweepPress plugin.
 */
class CLI {
	/**
	 * List all available sweepers and tasks with the cleanup estimates.
	 *
	 * To get individual tasks, run this command with the name of the sweeper as an argument.
	 *
	 * The table with the results will include number of tasks, records to be removed and size of the data that will be removed. All these values are estimates!
	 *
	 * ## OPTIONS
	 *
	 * [<sweeper>...]
	 * : Get information about individual sweeper and list of all individual sweeper tasks
	 *
	 * Without additional sweeper name, this will show status of all the sweepers.
	 * Include the name of the sweeper to see the status of individual sweeper tasks.
	 *
	 * ## EXAMPLES
	 *
	 * # Show status for every sweeper that has any data to remove
	 *   wp sweeppress list
	 *
	 * # Show status for the 'posts-revisions' sweeper and each task that has any data to remove
	 *   wp sweeppress list posts-revisions
	 */
	public function list( $args, $assoc_args ) {
		if ( isset( $args[0] ) ) {
			$sweeper = $args[0];

			if ( sweeppress_core()->is_sweeper_valid( $sweeper ) ) {
				$tasks = $this->_available_tasks_for_sweeper( $sweeper );

				if ( empty( $tasks ) ) {
					WP_CLI::line( __( "This sweeper reported no tasks available for sweeping.", "sweeppress" ) );
				} else {
					$formatter = new Formatter( $assoc_args, array(
						'sweeper',
						'task',
						'records',
						'size',
					) );

					$formatter->display_items( $tasks );
				}
			} else {
				WP_CLI::error( __( "The requested sweeper is not valid.", "sweeppress" ) );
			}
		} else {
			$jobs = $this->_available_jobs();

			if ( empty( $jobs ) ) {
				WP_CLI::line( __( "No sweepers reported any data available for sweeping.", "sweeppress" ) );
			} else {
				$formatter = new Formatter( $assoc_args, array(
					'sweeper',
					'tasks',
					'records',
					'size',
				) );

				$formatter->display_items( $jobs );
			}
		}
	}

	/**
	 * Run automatic sweeping with all available sweepers and tasks.
	 *
	 * Not all sweepers are available for auto sweeping! Check out information about individual sweepers for possible limits.
	 *
	 * ## EXAMPLES
	 *
	 * # Run all available sweepers and tasks
	 *   wp sweeppress auto
	 */
	public function auto() {
		$results = sweeppress_core()->auto_sweep( 'cli' );

		$this->_render_results_as_cli( $results );
	}

	/**
	 * Run one or more sweepers, all available tasks for included sweepers.
	 *
	 * ## OPTIONS
	 *
	 * <sweeper>...
	 * : Include the names of the sweepers you want to run. All tasks for the listed sweepers will be run.
	 *
	 * ## EXAMPLES
	 *
	 * # Run the 'posts-spam' sweeper
	 *   wp sweeppress sweep posts-spam
	 *
	 * # Run the 'posts-spam', 'comments-trash' and 'terms-orphans' sweepers
	 *   wp sweeppress sweep posts-spam comments-trash terms-orphans
	 */
	public function sweep( $args, $assoc_args ) {
		if ( empty( $args ) ) {
			WP_CLI::error( __( "No sweeper specified.", "sweeppress" ) );
		} else {
			$sweepers = [];

			foreach ( $args as $sweeper ) {
				if ( sweeppress_core()->is_sweeper_valid( $sweeper ) ) {
					$sweepers[ $sweeper ] = true;
				}
			}

			if ( empty( $sweepers ) ) {
				WP_CLI::error( __( "No valid sweepers specified.", "sweeppress" ) );
			} else {
				$results = sweeppress_core()->sweep( $sweepers, 'cli' );

				$this->_render_results_as_cli( $results );
			}
		}
	}

	/**
	 * Run a single sweeper with one or more listed tasks.
	 *
	 * ## OPTIONS
	 *
	 * <sweeper>
	 * : Name of the sweeper to run.
	 *
	 * [<task>...]
	 * : Optionally, after the name of the sweeper, include the names of individual tasks for the sweeper.
	 *
	 * ## EXAMPLES
	 *
	 * # Run the 'posts-spam' sweeper
	 *   wp sweeppress sweeper posts-spam
	 *
	 * # Run the 'posts-spam' sweeper for tasks 'post' and 'page'
	 *   wp sweeppress sweeper posts-spam post page
	 */
	public function sweeper( $args, $assoc_args ) {
		if ( empty( $args ) ) {
			WP_CLI::error( __( "No sweeper specified.", "sweeppress" ) );
		} else {
			$job = $args[0];

			if ( ! sweeppress_core()->is_sweeper_valid( $job ) ) {
				WP_CLI::error( __( "Specified sweeper is not valid.", "sweeppress" ) );
			} else {
				$tasks = null;

				if ( count( $args ) > 1 ) {
					$raw   = array_slice( $args, 1 );
					$tasks = array();

					foreach ( $raw as $task ) {
						if ( sweeppress_core()->sweeper( $job )->is_task_valid( $task ) ) {
							$tasks[] = $task;
						}
					}
				}

				if ( is_array( $tasks ) && empty( $tasks ) ) {
					WP_CLI::error( __( "Specified tasks are not valid.", "sweeppress" ) );
				} else {
					$results = sweeppress_core()->sweep( array( $job => $tasks ?? true ), 'cli' );

					$this->_render_results_as_cli( $results );
				}
			}
		}
	}

	private function _available_tasks_for_sweeper( string $code ) : array {
		$tasks   = array();
		$sweeper = sweeppress_core()->sweeper( $code );

		if ( $sweeper ) {
			if ( $sweeper->is_sweepable() ) {
				$_tasks = $sweeper->get_tasks();

				foreach ( $_tasks as $task => $data ) {
					if ( $data['records'] > 0 || $data['size'] > 0 ) {
						$tasks[] = array(
							'sweeper' => $sweeper->get_code(),
							'task'    => $task,
							'records' => $data['records'],
							'size'    => File::size_format( $data['size'], 2, ' ', false ),
						);
					}
				}
			}
		}

		return $tasks;
	}

	private function _available_jobs() : array {
		$jobs = array();
		$list = sweeppress_core()->available();

		foreach ( $list as $sweepers ) {
			foreach ( $sweepers as $sweeper ) {
				if ( $sweeper->is_sweepable() ) {
					$_tasks = $sweeper->get_tasks();

					$_records = $_size = $_count = 0;

					foreach ( $_tasks as $data ) {
						if ( $data['records'] > 0 || $data['size'] > 0 ) {
							$_count ++;
							$_records += $data['records'];
							$_size    += $data['size'];
						}
					}

					if ( $_records > 0 || $_size > 0 ) {
						$jobs[] = array(
							'sweeper' => $sweeper->get_code(),
							'tasks'   => $_count,
							'records' => $_records,
							'size'    => File::size_format( $_size, 2, ' ', false ),
						);
					}
				}
			}
		}

		return $jobs;
	}

	private function _render_results_as_cli( array $results ) {
		$_status   = true;
		$_sweepers = array();

		foreach ( $results['sweepers'] as $code => $data ) {
			if ( $data === false ) {
				$_sweepers[] = sweeppress_core()->get_sweeper_title( $code ) . ': ' . __( "This sweeper was not run.", "sweeppress" );
			} else {
				$_errors = false;

				foreach ( $data['tasks'] as $task => $obj ) {
					if ( is_wp_error( $obj ) ) {
						$_errors = true;
						$_status = false;
						break;
					}
				}

				$_sweepers[] = sweeppress_core()->get_sweeper_title( $code ) . ': ' . ( ! $_errors ? __( "OK", "sweeppress" ) : __( "Has Errors", "sweeppress" ) );
			}
		}

		WP_CLI::line( __( "Sweeping Results", "sweeppress" ) . ":" );
		WP_CLI::line( '-----------------------------------' );
		WP_CLI::line( __( "Status", "sweeppress" ) . ': ' . ( $_status ? __( "OK", "sweeppress" ) : __( "Has Errors", "sweeppress" ) ) );
		WP_CLI::line( __( "Started", "sweeppress" ) . ': ' . date( 'c', floor( $results['timer']['started'] ) ) );
		WP_CLI::line( __( "Ended", "sweeppress" ) . ': ' . date( 'c', floor( $results['timer']['ended'] ) ) );
		WP_CLI::line( __( "Total Time", "sweeppress" ) . ': ' . number_format( $results['stats']['time'], 1 ) . ' ' . __( "seconds", "sweeppress" ) );
		WP_CLI::line( '-----------------------------------' );
		WP_CLI::line( __( "Records Removed", "sweeppress" ) . ': ' . $results['stats']['records'] );
		WP_CLI::line( __( "Space Recovered", "sweeppress" ) . ': ' . File::size_format( $results['stats']['size'], 2, ' ', false ) );
		WP_CLI::line( __( "Sweepers Used", "sweeppress" ) . ': ' . $results['stats']['jobs'] );
		WP_CLI::line( __( "Tasks Completed", "sweeppress" ) . ': ' . $results['stats']['tasks'] );
		WP_CLI::line( '-----------------------------------' );

		foreach ( $_sweepers as $_sweeper ) {
			WP_CLI::line( $_sweeper );
		}
	}
}
