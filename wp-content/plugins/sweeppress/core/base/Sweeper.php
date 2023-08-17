<?php

namespace Dev4Press\Plugin\SweepPress\Base;

use Dev4Press\Plugin\SweepPress\Basic\Database;
use Dev4Press\Plugin\SweepPress\Basic\Prepare;
use Dev4Press\v42\Core\Scope;
use Dev4Press\v42\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @method bool for_single_task()
 * @method bool for_quick_cleanup()
 * @method bool for_scheduled_cleanup()
 * @method bool for_auto_cleanup()
 * @method bool for_monitor_task()
 * @method bool for_bulk_network()
 */
abstract class Sweeper {
	protected $_code = '';
	protected $_scope = 'blog';
	protected $_category = 'posts';
	protected $_version = '1.0';
	protected $_capability = 'activate_plugins';
	protected $_tasks = array();
	protected $_cached = false;
	protected $_affected_tables = array();

	protected $_flag_single_task = true;
	protected $_flag_quick_cleanup = true;
	protected $_flag_scheduled_cleanup = true;
	protected $_flag_auto_cleanup = true;
	protected $_flag_monitor_task = true;
	protected $_flag_bulk_network = false;

	protected $_sweepable_records_size = true;
	protected $_timer_prepare = array(
		'start'  => 0,
		'end'    => 0,
		'length' => 0,
	);

	protected $_versions = array(
		'wordpress'    => array(
			'5.5',
			'5.6',
			'5.7',
			'5.8',
			'5.9',
			'6.0',
			'6.1',
			'6.2',
			'6.3',
			'6.4',
		),
		'classicpress' => array(
			'1.3',
			'1.4',
			'1.5',
		),
	);

	public function __construct() {

	}

	public function __call( $name, $arguments ) {
		switch ( $name ) {
			case 'for_single_task':
				return $this->_flag_single_task;
			case 'for_quick_cleanup':
				return $this->_flag_quick_cleanup;
			case 'for_scheduled_cleanup':
				return $this->_flag_scheduled_cleanup;
			case 'for_auto_cleanup':
				return $this->_flag_auto_cleanup;
			case 'for_monitor_task':
				return $this->_flag_monitor_task;
			case 'for_bulk_network':
				return $this->_flag_bulk_network;
		}

		return false;
	}

	public function has_empty_tasks() : bool {
		$total = 0;
		$empty = 0;

		foreach ( $this->get_tasks() as $data ) {
			$total ++;

			if ( $data['records'] > 0 || $data['size'] > 0 ) {
				$empty ++;
			}
		}

		return $total > $empty;
	}

	public function is_allowed() : bool {
		return WordPress::instance()->is_cron() ||
		       Scope::instance()->is_scope_cli() ||
		       current_user_can( $this->_capability );
	}

	public function is_available() : bool {
		$_valid = $this->get_supported_version();
		$_major = WordPress::instance()->major_version();

		$is = in_array( $_major, $_valid );

		if ( $is ) {
			if ( Scope::instance()->get_scope() == 'cli' ) {
				if ( $this->_scope == 'network' ) {
					$is = Scope::instance()->is_multisite() && Scope::instance()->is_main_blog();
				} else {
					$is = true;
				}
			} else {
				if ( $this->_scope == 'network' ) {
					if ( Scope::instance()->is_multisite() && is_main_site() ) {
						$is = current_user_can( 'setup_network' );
					} else {
						$is = false;
					}
				} else {
					$is = current_user_can( $this->_capability );
				}
			}
		}

		return $is;
	}

	public function is_sweepable() : bool {
		if ( $this->_sweepable_records_size ) {
			foreach ( $this->get_tasks() as $data ) {
				if ( $data['records'] > 0 || $data['size'] > 0 ) {
					return true;
				}
			}
		} else {
			return ! empty( $this->get_tasks() );
		}

		return false;
	}

	public function is_task_valid( string $task ) : bool {
		if ( $this->for_single_task() ) {
			return $task == $this->_code;
		} else {
			return in_array( $task, $this->list_tasks_keys() );
		}
	}

	public function is_no_size() : bool {
		return ! $this->_sweepable_records_size;
	}

	public function is_cached() : bool {
		return $this->_cached;
	}

	public function get_supported_version() : array {
		return WordPress::instance()->is_wordpress()
			?
			$this->_versions['wordpress']
			:
			$this->_versions['classicpress'];
	}

	public function get_unique_id() : string {
		return $this->_scope . '-' . $this->_category . '-' . $this->_code;
	}

	public function get_code() : string {
		return $this->_code;
	}

	public function get_version() : string {
		return $this->_version;
	}

	public function get_scope() : string {
		return $this->_scope;
	}

	public function get_category() : string {
		return $this->_category;
	}

	public function get_capability() : string {
		return $this->_capability;
	}

	public function get_task( string $name = null ) : array {
		if ( empty( $this->_tasks ) ) {
			$this->prepare();
		}

		$name = $name ?? $this->_code;

		return $this->_tasks[ $name ] ?? array();
	}

	public function get_tasks() : array {
		if ( empty( $this->_tasks ) ) {
			$data = sweeppress_settings()->get_sweeper_cache( $this->_code );

			if ( $data === false ) {
				$this->_timer_prepare['start'] = microtime( true );

				$this->prepare();

				$this->_timer_prepare['end']    = microtime( true );
				$this->_timer_prepare['length'] = $this->_timer_prepare['end'] - $this->_timer_prepare['start'];

				sweeppress_settings()->set_sweeper_cache( $this->_code, $this->_tasks );
			} else {
				$this->_tasks  = $data;
				$this->_cached = true;
			}
		}

		return $this->_tasks;
	}

	public function items_count_n( int $value ) : string {
		return _n( "%s item", "%s items", $value, "sweeppress" );
	}

	public function tasks_count_n( int $value ) : string {
		return _n( "%s task", "%s tasks", $value, "sweeppress" );
	}

	public function limitations() : array {
		return array();
	}

	public function list_tasks() : array {
		return array();
	}

	public function list_tasks_keys() : array {
		$_tasks = $this->list_tasks();

		if ( empty( $_tasks ) ) {
			return array( $this->_code );
		}

		return array_keys( $_tasks );
	}

	public function list_sweepable_tasks_keys() : array {
		$_tasks = $this->get_tasks();

		if ( empty( $_tasks ) ) {
			return array( $this->_code );
		} else {
			$_list = array();

			foreach ( $_tasks as $_task => $data ) {
				if ( $data['records'] > 0 || $data['size'] > 0 ) {
					$_list[] = $_task;
				}
			}

			return $_list;
		}
	}

	public function affected_tables() : array {
		$list = array();

		foreach ( $this->_affected_tables as $table ) {
			$name = Prepare::instance()->wpdb()->$table ?? '';

			if ( ! empty( $name ) ) {
				$list[] = $name;
			}
		}

		return $list;
	}

	public function affected_tables_size() : int {
		return Database::instance()->calculate( 'size', $this->_affected_tables );
	}

	public function calculate_percentage( int $size ) : float {
		$affected_size = $this->affected_tables_size();

		return $affected_size == 0 ? 0 : round( 100 * ( $size / $this->affected_tables_size() ), 2 );
	}

	protected function base_sweep( $removal ) : array {
		$results = array(
			'records' => 0,
			'size'    => 0,
			'tasks'   => array(),
		);

		$task = $this->get_task();

		if ( is_wp_error( $removal ) ) {
			$results['tasks'][ $this->_code ] = $removal;
		} else {
			$results['tasks'][ $this->_code ] = $task['title'];
			$results['records']               = $task['records'];
			$results['size']                  = $task['size'];
		}

		return $results;
	}

	abstract public function title() : string;

	abstract public function description() : string;

	abstract public function help() : array;

	abstract public function prepare();

	abstract public function sweep( $tasks = array() ) : array;
}
