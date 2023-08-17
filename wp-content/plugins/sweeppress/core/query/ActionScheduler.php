<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;
use Dev4Press\v42\Core\Quick\Str;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ActionScheduler extends Query {
	protected $_group = 'action-scheduler';

	public static function instance() : ActionScheduler {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new ActionScheduler();
		}

		return $instance;
	}

	public function log_orphaned_status() : array {
		$list = $this->retrieve( 'log-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_actionscheduler_log_orphaned_records();

			$list = array(
				'title'   => __( "Orphaned Records", "sweeppress" ),
				'records' => absint( $raw['key_records'] ),
				'size'    => absint( $raw['key_size'] ) > 0 && absint( $raw['key_size'] ) < 1025 ? 1024 : absint( $raw['key_size'] ),
			);

			$this->store( 'log-orphans', $list );
		}

		return $list;
	}

	public function log_records( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'log' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_actionscheduler_log_records( $keep_days );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['log_size'] );
				$_slug = $row['slug'] ?? '-no-group-';

				$list[ 'id-' . $row['group_id'] ] = array(
					'real_title' => $_slug,
					'title'      => Str::slug_to_name( $_slug, '-' ),
					'items'      => absint( $row['log_records'] ),
					'records'    => absint( $row['log_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'log', $list );
		}

		return $list;
	}

	public function actions_records( array $entry_status, int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'actions-' . join( '-', $entry_status ) );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_actionscheduler_actions_records_for_status( $entry_status, $keep_days );

			$list = array();

			foreach ( $raw as $row ) {
				$_size = absint( $row['action_size'] ) + absint( $row['log_size'] );
				$_slug = $row['slug'] ?? '-no-group-';

				$list[ 'id-' . $row['group_id'] ] = array(
					'real_title' => $_slug,
					'title'      => Str::slug_to_name( $_slug, '-' ),
					'items'      => absint( $row['action_records'] ),
					'records'    => absint( $row['action_records'] ) + absint( $row['log_records'] ),
					'size'       => $_size > 0 && $_size < 1025 ? 1024 : $_size,
				);
			}

			$this->store( 'actions-' . join( '-', $entry_status ), $list );
		}

		return $list;
	}
}
