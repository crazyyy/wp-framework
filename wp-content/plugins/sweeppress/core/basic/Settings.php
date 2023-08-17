<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\v42\Core\Plugins\Settings as BaseSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings extends BaseSettings {
	public $base = 'sweeppress';

	public $settings = array(
		'core'       => array(
			'activated' => 0,
		),
		'statistics' => array(
			'months' => array(),
			'total'  => array(),
		),
		'cache'      => array(
			'sweepers' => array(),
		),
		'settings'   => array(
			'expand_cli'          => false,
			'expand_rest'         => false,
			'hide_backup_notices' => false,
		),
		'sweepers'   => array(
			'estimated_mode_full'                => false,
			'estimated_cache'                    => true,
			'keep_days_posts-auto-draft'         => 14,
			'keep_days_posts-spam'               => 14,
			'keep_days_posts-trash'              => 14,
			'keep_days_posts-revisions'          => 14,
			'keep_days_posts-draft-revisions'    => 14,
			'keep_days_comments-spam'            => 14,
			'keep_days_comments-trash'           => 14,
			'keep_days_comments-unapproved'      => 60,
			'keep_days_comments-pingback'        => 14,
			'keep_days_comments-trackback'       => 14,
			'keep_days_comments-ua'              => 14,
			'keep_days_comments-akismet'         => 14,
			'keep_days_signups-inactive'         => 90,
			'keep_days_actionscheduler-log'      => 14,
			'keep_days_actionscheduler-failed'   => 14,
			'keep_days_actionscheduler-complete' => 14,
			'keep_days_actionscheduler-canceled' => 14,
			'db_table_optimize_threshold'        => 40,
			'db_table_optimize_min_size'         => 6,
			'db_table_optimize_method'           => 'optimize',
			'last_used_timestamp'                => array(),
		),
	);

	public function get_sweeper_cache( string $sweeper ) {
		if ( $this->get( 'estimated_cache', 'sweepers' ) ) {
			$cache = $this->current['cache']['sweepers'][ $sweeper ] ?? array();

			if ( empty( $cache ) ) {
				return false;
			}

			$expire = $cache['expire'] ?? 0;
			$data   = $cache['data'] ?? array();

			if ( $expire < time() || empty( $data ) ) {
				return false;
			}

			return $data;
		}

		return false;
	}

	public function set_sweeper_cache( string $sweeper, $data, int $expiration = 7200 ) {
		if ( $this->get( 'estimated_cache', 'sweepers' ) ) {
			$this->current['cache']['sweepers'][ $sweeper ] = array(
				'expire' => time() + $expiration,
				'data'   => $data,
			);

			$this->save( 'cache' );
		}
	}

	public function delete_sweeper_cache( string $sweeper ) {
		if ( $this->get( 'estimated_cache', 'sweepers' ) ) {
			if ( isset( $this->current['cache']['sweepers'][ $sweeper ] ) ) {
				unset( $this->current['cache']['sweepers'][ $sweeper ] );

				$this->save( 'cache' );
			}
		}
	}

	public function purge_sweeper_cache() {
		$this->current['cache']['sweepers'] = array();

		$this->save( 'cache' );
	}

	public function log_statistics( $input = array() ) {
		$default = array(
			'source'   => '',
			'records'  => 0,
			'size'     => 0,
			'time'     => 0,
			'jobs'     => 0,
			'tasks'    => 0,
			'sweepers' => array(),
		);

		$input = wp_parse_args( $input, $default );

		if ( in_array( $input['source'], array( 'quick', 'scheduler', 'panel', 'auto', 'cli', 'rest' ) ) ) {
			$month = date( 'Y-m' );

			if ( ! isset( $this->current['statistics']['months'][ $month ] ) ) {
				$this->current['statistics']['months'][ $month ] = $this->_statistics_empty();
			}

			$this->current['statistics']['months'][ $month ][ $input['source'] ] ++;
			$this->current['statistics']['months'][ $month ]['records'] += $input['records'] ?? 0;
			$this->current['statistics']['months'][ $month ]['size']    += $input['size'] ?? 0;
			$this->current['statistics']['months'][ $month ]['time']    += $input['time'] ?? 0;
			$this->current['statistics']['months'][ $month ]['jobs']    += $input['jobs'] ?? 0;
			$this->current['statistics']['months'][ $month ]['tasks']   += $input['tasks'] ?? 0;

			foreach ( $input['sweepers'] as $sweep => $data ) {
				if ( ! isset( $this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ] ) ) {
					$this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ] = array(
						'records' => 0,
						'size'    => 0,
						'time'    => 0,
						'counts'  => 0,
					);
				}

				$this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ]['records'] += $data['records'] ?? 0;
				$this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ]['size']    += $data['size'] ?? 0;
				$this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ]['time']    += $data['time'] ?? 0;
				$this->current['statistics']['months'][ $month ]['sweepers'][ $sweep ]['counts'] ++;

				$this->current['sweepers']['last_used_timestamp'][ $sweep ] = time();
			}

			if ( empty( $this->current['statistics']['total'] ) ) {
				$this->current['statistics']['total'] = $this->_statistics_empty();
			}

			$this->current['statistics']['total'][ $input['source'] ] ++;
			$this->current['statistics']['total']['records'] += $input['records'] ?? 0;
			$this->current['statistics']['total']['size']    += $input['size'] ?? 0;
			$this->current['statistics']['total']['time']    += $input['time'] ?? 0;
			$this->current['statistics']['total']['jobs']    += $input['jobs'] ?? 0;
			$this->current['statistics']['total']['tasks']   += $input['tasks'] ?? 0;

			foreach ( $input['sweepers'] as $sweep => $data ) {
				if ( ! isset( $this->current['statistics']['total']['sweepers'][ $sweep ] ) ) {
					$this->current['statistics']['total']['sweepers'][ $sweep ] = array(
						'records' => 0,
						'size'    => 0,
						'time'    => 0,
						'counts'  => 0,
					);
				}

				$this->current['statistics']['total']['sweepers'][ $sweep ]['records'] += $data['records'] ?? 0;
				$this->current['statistics']['total']['sweepers'][ $sweep ]['size']    += $data['size'] ?? 0;
				$this->current['statistics']['total']['sweepers'][ $sweep ]['time']    += $data['time'] ?? 0;
				$this->current['statistics']['total']['sweepers'][ $sweep ]['counts'] ++;
			}

			$this->save( 'statistics' );
			$this->save( 'sweepers' );
		}
	}

	public function get_statistics( string $month = '' ) : array {
		if ( empty( $month ) || ! isset( $this->current['statistics']['months'][ $month ] ) ) {
			$value          = $this->current['statistics']['total'];
			$value['label'] = isset( $value['started'] ) ? sprintf( __( "Since: %s", "sweeppress" ), $value['started'] ) : __( "All Time", "sweeppress" );
		} else {
			$value          = $this->current['statistics']['months'][ $month ];
			$value['label'] = sprintf( __( "For Month: %s", "sweeppress" ), date_create_from_format( 'Y-m', $month )->format( 'Y F' ) );
		}

		$value['size_total'] = $value['size'];

		if ( isset( $value['sweepers']['optimize-tables']['size'] ) ) {
			$value['size'] = $value['size'] - $value['sweepers']['optimize-tables']['size'];
		}

		return $value;
	}

	public function list_statistics() : array {
		$list = array(
			'' => __( "All Time Statistics", "sweeppress" ),
		);

		foreach ( array_keys( $this->current['statistics']['months'] ) as $month ) {
			$list[ $month ] = date_create_from_format( 'Y-m', $month )->format( 'Y F' );
		}

		return $list;
	}

	public function show_notice( string $name = 'backup' ) : bool {
		switch ( $name ) {
			default:
			case 'backup':
				return ! $this->get( 'hide_backup_notices' );
		}
	}

	public function get_sweeper_last_used_timestamp( string $sweeper ) : int {
		return isset( $this->current['sweepers']['last_used_timestamp'][ $sweeper ] ) ? intval( $this->current['sweepers']['last_used_timestamp'][ $sweeper ] ) : 0;
	}

	protected function constructor() {
		$this->info = new Information();

		add_action( 'sweeppress_load_settings', array( $this, 'init' ) );
	}

	protected function _statistics_empty() : array {
		return array(
			'started'   => date( 'c' ),
			'quick'     => 0,
			'scheduler' => 0,
			'panel'     => 0,
			'auto'      => 0,
			'cli'       => 0,
			'rest'      => 0,
			'records'   => 0,
			'size'      => 0,
			'jobs'      => 0,
			'tasks'     => 0,
			'time'      => 0,
			'sweepers'  => array(),
		);
	}
}
