<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sitemeta extends Query {
	protected $_group = 'query-sitemeta';

	public static function instance() : Sitemeta {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Sitemeta();
		}

		return $instance;
	}

	public function expired_transients() : array {
		$list = $this->retrieve( 'expired-transients' );

		if ( ! $list ) {
			$list = array(
				'transients' => sweeppress_prepare()->get_expired_network_transients(),
				'title'      => __( "Expired Transients", "sweeppress" ),
				'items'      => 0,
			);

			$data = sweeppress_prepare()->get_network_transients_information( $list['transients'] );

			$list['records'] = $data['records'];
			$list['size']    = $data['size'] > 0 && $data['size'] < 1025 ? 1024 : $data['size'];

			$this->store( 'expired-transients', $list );
		}

		return $list;
	}

	public function all_transients() : array {
		$list = $this->retrieve( 'all-transients' );

		if ( ! $list ) {
			$list = array(
				'transients' => sweeppress_prepare()->get_all_network_transients(),
				'title'      => __( "All Transients", "sweeppress" ),
				'items'      => 0,
			);

			$data = sweeppress_prepare()->get_network_transients_information( $list['transients'] );

			$list['records'] = $data['records'];
			$list['size']    = $data['size'] > 0 && $data['size'] < 1025 ? 1024 : $data['size'];

			$this->store( 'all-transients', $list );
		}

		return $list;
	}
}
