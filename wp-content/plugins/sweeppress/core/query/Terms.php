<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Terms extends Query {
	protected $_group = 'query-terms';

	public static function instance() : Terms {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Terms();
		}

		return $instance;
	}

	public function terms_orphaned_status() : array {
		$list = $this->retrieve( 'terms-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_terms_orphans();

			$list = array(
				'title'   => __( "Orphaned Terms", "sweeppress" ),
				'items'   => $raw['terms_records'],
				'records' => $raw['terms_records'] + $raw['meta_records'],
				'size'    => $raw['terms_size'] + $raw['meta_size'],
			);

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'terms-orphans', $list );
		}

		return $list;
	}

	public function termmeta_orphaned_status() : array {
		$list = $this->retrieve( 'meta-record-orphans' );

		if ( ! $list ) {
			$raw = sweeppress_prepare()->get_termmeta_orphaned_records();

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
}
