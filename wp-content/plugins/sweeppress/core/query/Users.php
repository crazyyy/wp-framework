<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Users extends Query {
	protected $_group = 'query-users';

	public static function instance() : Users {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Users();
		}

		return $instance;
	}

	public function usermeta_orphaned_status() : array {
		$list = $this->retrieve( 'meta-record-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_usermeta_orphaned_records();

			$list = array(
				'title'   => __( "Orphaned Records", "sweeppress" ),
				'records' => $raw['key_records'],
				'size'    => $raw['key_size'],
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'meta-record-orphans', $list );
		}

		return $list;
	}

	public function signups_inactive( int $keep_days = 0 ) : array {
		$list = $this->retrieve( 'inactive-signups' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_user_signups_inactive( $keep_days );

			$list = array(
				'title'   => __( "Inactive Signup Records", "sweeppress" ),
				'records' => $raw['records'],
				'size'    => $raw['size'],
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'inactive-signups', $list );
		}

		return $list;
	}
}