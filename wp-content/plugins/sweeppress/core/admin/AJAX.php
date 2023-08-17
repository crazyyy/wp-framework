<?php

namespace Dev4Press\Plugin\SweepPress\Admin;

use Dev4Press\Plugin\SweepPress\Basic\Results;
use Dev4Press\Plugin\SweepPress\Basic\Sweep;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AJAX {
	public function __construct() {
		add_action( 'wp_ajax_sweeppress-run-auto', array( $this, 'auto' ) );
		add_action( 'wp_ajax_sweeppress-run-quick', array( $this, 'quick' ) );
		add_action( 'wp_ajax_sweeppress-run-sweep', array( $this, 'sweep' ) );
	}

	public static function instance() : AJAX {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new AJAX();
		}

		return $instance;
	}

	public function auto() {
		@ini_set( 'memory_limit', '256M' );
		@set_time_limit( 3000 );

		$_nonce = $_REQUEST['_wpnonce'] ? sanitize_text_field( $_REQUEST['_wpnonce'] ) : '';

		if ( empty( $_nonce ) || ! wp_verify_nonce( $_nonce, 'sweeppress-dashboard-auto-sweep' ) ) {
			$error = new WP_Error( 400, __( "Invalid Request", "sweeppress" ) );
		} else {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				$error = new WP_Error( 401, __( "Unauthorized Request", "sweeppress" ) );
			} else {
				$results = sweeppress_core()->auto_sweep( 'auto' );

				status_header( 200 );
				die( $this->_render_results_as_html( $results ) );
			}
		}

		if ( is_wp_error( $error ) ) {
			status_header( $error->get_error_code(), $error->get_error_message() );

			die( $error->get_error_message() );
		}
	}

	public function quick() {
		$this->_the_sweeper( 'sweeppress-dashboard-quick-sweep', 'quick' );
	}

	public function sweep() {
		$this->_the_sweeper( 'sweeppress-sweep-panel-sweeper', 'panel' );
	}

	private function _the_sweeper( $nonce_action, $source ) {
		@ini_set( 'memory_limit', '256M' );
		@set_time_limit( 3000 );

		$request = $_REQUEST['sweeppress'] ? sweeppress_sanitize_keys_based_array( (array) $_REQUEST['sweeppress'] ) : array();

		if ( empty( $request ) ) {
			$error = new WP_Error( 400, __( "Invalid Request", "sweeppress" ) );
		} else {
			$_nonce = $request['nonce'] ?? '';

			if ( empty( $_nonce ) || ! wp_verify_nonce( $_nonce, $nonce_action ) ) {
				$error = new WP_Error( 400, __( "Invalid Request", "sweeppress" ) );
			} else {
				if ( ! current_user_can( 'activate_plugins' ) ) {
					$error = new WP_Error( 401, __( "Unauthorized Request", "sweeppress" ) );
				} else {
					$args    = $this->_prepare_sweeper_args( $request );
					$results = sweeppress_core()->sweep( $args, $source );

					status_header( 200 );
					die( $this->_render_results_as_html( $results ) );
				}
			}
		}

		if ( is_wp_error( $error ) ) {
			status_header( $error->get_error_code(), $error->get_error_message() );

			die( $error->get_error_message() );
		}
	}

	private function _prepare_sweeper_args( $request ) : array {
		$sweeper = $request['sweeper'] ?? array();
		$args    = array();

		foreach ( $sweeper as $sweepers ) {
			foreach ( $sweepers as $sweep => $items ) {
				if ( Sweep::instance()->is_sweeper_valid( $sweep ) ) {
					if ( ! isset( $args[ $sweep ] ) ) {
						$args[ $sweep ] = array();
					}

					foreach ( $items as $item => $val ) {
						if ( $val == 'sweep' ) {
							$args[ $sweep ][] = $item;
						}
					}
				}
			}
		}

		$args = array_filter( $args );

		foreach ( $args as $sweep => &$items ) {
			$items = array_unique( $items );
			$items = array_filter( $items );
			$items = array_values( $items );

			if ( count( $items ) == 1 && $items[0] == $sweep ) {
				$items = true;
			}
		}

		return $args;
	}

	private function _render_results_as_html( array $results ) : string {
		return Results::instance()->as_html( $results );
	}
}
