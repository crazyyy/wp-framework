<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\Plugin\SweepPress\Base\DB as CoreDB;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DB extends CoreDB {
	protected $plugin_instance = 'db';

	public function get_table_rows_count( string $table ) : int {
		$sql = "SELECT COUNT(*) FROM " . $table;

		return absint( $this->get_var( $sql ) );
	}

	public function get_actionscheduler_groups() : array {
		$sql = "SELECT * FROM " . $this->actionscheduler_groups;
		$raw = $this->get_results( $sql );

		return $this->pluck( $raw, 'slug', 'group_id' );
	}

	public function repair_table( $name ) : array {
		$info = $this->get_results( "REPAIR TABLE `" . $name . "`" );

		$data = array(
			'note'   => '',
			'status' => '',
			'error'  => '',
		);

		foreach ( $info as $row ) {
			$data[ strtolower( $row->Msg_type ) ] = $row->Msg_text;
		}

		if ( empty( $data['status'] ) ) {
			$data['status'] = empty( $data['error'] ) ? __( "Nothing Done", "sweeppress" ) : __( "Operation Failed", "sweeppress" );
		}

		return $data;
	}

	public function optimize_table( $name ) : array {
		$info = $this->get_results( "OPTIMIZE TABLE `" . $name . "`" );

		$data = array(
			'note'   => '',
			'status' => '',
			'error'  => '',
		);

		foreach ( $info as $row ) {
			$data[ strtolower( $row->Msg_type ) ] = $row->Msg_text;
		}

		return $data;
	}
}
