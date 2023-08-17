<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Database extends Query {
	protected $_group = 'query-database';

	public static function instance() : Database {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Database();
		}

		return $instance;
	}

	public function repair_tables() : array {
		$list = $this->retrieve( 'repair-tables' );

		if ( ! $list ) {
			$tables = sweeppress_prepare()->get_tables_status( true );
			$list   = array();

			foreach ( $tables as $table ) {
				$list[ $table['table'] ] = array(
					'title'   => $table['table'],
					'items'   => 0,
					'records' => 0,
					'size'    => 0,
				);
			}

			$this->store( 'repair-tables', $list );
		}

		return $list;
	}

	public function optimize_tables() : array {
		$list = $this->retrieve( 'optimize-tables' );

		if ( ! $list ) {
			$tables = sweeppress_prepare()->get_tables_to_optimize();
			$list   = array();

			foreach ( $tables as $table ) {
				$list[ $table['table'] ] = array(
					'title'   => $table['table'] . ' (' . sprintf( '%s fragmented', $table['fragment'] . '%' ) . ')',
					'items'   => 0,
					'records' => 0,
					'size'    => absint( $table['free'] ),
				);
			}

			$this->store( 'optimize-tables', $list );
		}

		return $list;
	}
}
