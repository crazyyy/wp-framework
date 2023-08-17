<?php

namespace Dev4Press\Plugin\SweepPress\Query;

use Dev4Press\Plugin\SweepPress\Base\Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Options extends Query {
	protected $_group = 'query-options';

	public static function instance() : Options {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Options();
		}

		return $instance;
	}

	public function all_cron_jobs() : array {
		$list = $this->retrieve( 'cron-jobs' );

		if ( ! $list ) {
			$list = array(
				'title'   => __( "All CRON Jobs", "sweeppress" ),
				'items'   => 0,
				'records' => 1,
			);

			$list['size'] = strlen( maybe_serialize( _get_cron_array() ) );

			if ( $list['size'] > 0 && $list['size'] < 1025 ) {
				$list['size'] = 1024;
			}

			$this->store( 'cron-jobs', $list );
		}

		return $list;
	}

	public function expired_transients() : array {
		$list = $this->retrieve( 'expired-transients' );

		if ( ! $list ) {
			$list = array(
				'transients' => sweeppress_prepare()->get_expired_transients(),
				'title'      => __( "Expired Transients", "sweeppress" ),
				'items'      => 0,
			);

			$data = sweeppress_prepare()->get_transients_information( $list['transients']['local'], $list['transients']['site'] );

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
				'transients' => sweeppress_prepare()->get_all_transients(),
				'title'      => __( "All Transients", "sweeppress" ),
				'items'      => 0,
			);

			$data = sweeppress_prepare()->get_transients_information( $list['transients']['local'], $list['transients']['site'] );

			$list['records'] = $data['records'];
			$list['size']    = $data['size'] > 0 && $data['size'] < 1025 ? 1024 : $data['size'];

			$this->store( 'all-transients', $list );
		}

		return $list;
	}

	public function rss_feeds() : array {
		$list = $this->retrieve( 'rss-feeds' );

		if ( ! $list ) {
			$list = array(
				'transients' => sweeppress_prepare()->get_all_transients( true ),
				'title'      => __( "All Feeds", "sweeppress" ),
				'items'      => 0,
			);

			$data = sweeppress_prepare()->get_transients_information( $list['transients']['local'], $list['transients']['site'] );

			$list['records'] = $data['records'];
			$list['size']    = $data['size'] > 0 && $data['size'] < 1025 ? 1024 : $data['size'];

			$this->store( 'rss-feeds', $list );
		}

		return $list;
	}
}
