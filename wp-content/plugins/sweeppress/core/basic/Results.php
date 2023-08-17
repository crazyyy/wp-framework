<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

use Dev4Press\v42\Core\Quick\File;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Results {
	public static function instance() : Results {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Results();
		}

		return $instance;
	}

	public function as_html( array $results ) : string {
		$_sweepers = '';
		$_status   = true;

		foreach ( $results['sweepers'] as $code => $data ) {
			$_sweepers .= '<h6>' . esc_html( sweeppress_core()->get_sweeper_title( $code ) ) . '</h6>';

			if ( $data === false ) {
				$_sweepers .= '<p>' . esc_html__( "This sweeper was not run.", "sweeppress" ) . '</p>';
			} else {
				$_tasks  = array();
				$_errors = array();

				foreach ( $data['tasks'] as $task => $obj ) {
					if ( is_wp_error( $obj ) ) {
						$_errors[] = '[' . $task . '] ' . esc_html( $obj->get_error_message() );

						if ( $_status ) {
							$_status = false;
						}
					} else {
						$_tasks[] = esc_html( $obj );
					}
				}

				$_sweepers .= '<dl>';
				$_sweepers .= '<dt>' . esc_html__( "Total Time", "sweeppress" ) . '</dt><dd>' . number_format( $data['time'], 1 ) . ' ' . __( "seconds", "sweeppress" ) . '</dd>';
				$_sweepers .= '<dt>' . esc_html__( "Records Removed", "sweeppress" ) . '</dt><dd>' . absint( $data['records'] ) . '</dd>';
				$_sweepers .= '<dt>' . esc_html__( "Space Recovered", "sweeppress" ) . '</dt><dd>' . File::size_format( $data['size'], 2, ' ', false ) . '</dd>';

				if ( ! empty( $_tasks ) ) {
					$_sweepers .= '<dt>' . esc_html__( "Tasks", "sweeppress" ) . '</dt><dd>' . join( '<br/>', $_tasks ) . '</dd>';
				}

				if ( ! empty( $_errors ) ) {
					$_sweepers .= '<dt class="sweeppress-with-errors">' . esc_html__( "Errors", "sweeppress" ) . '</dt><dd class="sweeppress-with-errors">' . join( '<br/>', $_errors ) . '</dd>';
				}

				$_sweepers .= '</dl>';

				if ( isset( $data['info'] ) ) {
					$_sweepers .= '<hr/>';
					$_sweepers .= '<dl>';

					foreach ( $data['info'] as $task => $info ) {
						$show = array();

						if ( ! empty( $info['error'] ) ) {
							$show[] = sprintf( esc_html__( "Error: %s (%s)", "sweeppress" ), '<strong>' . esc_html( $info['status'] ) . '</strong>', $info['error'] );
						} else {
							$show[] = sprintf( esc_html__( "Status: %s", "sweeppress" ), '<strong>' . esc_html( $info['status'] ) . '</strong>' );
						}

						if ( ! empty( $info['note'] ) ) {
							$show[] = esc_html( $info['note'] );
						}

						$_sweepers .= '<dt>' . esc_html( $data['tasks'][ $task ] ) . '</dt><dd>' . join( '<br/>', $show ) . '</dd>';
					}

					$_sweepers .= '</dl>';
				}
			}
		}

		$render = '<div class="sweeppress-cleanup-results">';
		$render .= '<h5>' . esc_html__( "Sweeping Results", "sweeppress" ) . '</h5>';
		$render .= '<dl>';
		$render .= '<dt>' . esc_html__( "Status", "sweeppress" ) . '</dt><dd>' . ( $_status ? '<strong>' . __( "OK", "sweeppress" ) . '</strong>' : '<span class="sweeppress-with-errors"><strong>' . __( "Has Errors", "sweeppress" ) . '</strong></span>' ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Started", "sweeppress" ) . '</dt><dd>' . date( 'c', floor( $results['timer']['started'] ) ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Ended", "sweeppress" ) . '</dt><dd>' . date( 'c', floor( $results['timer']['ended'] ) ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Total Time", "sweeppress" ) . '</dt><dd>' . number_format( $results['stats']['time'], 1 ) . ' ' . __( "seconds", "sweeppress" ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Records Removed", "sweeppress" ) . '</dt><dd>' . absint( $results['stats']['records'] ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Space Recovered", "sweeppress" ) . '</dt><dd>' . File::size_format( $results['stats']['size'], 2, ' ', false ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Sweepers Used", "sweeppress" ) . '</dt><dd>' . absint( $results['stats']['jobs'] ) . '</dd>';
		$render .= '<dt>' . esc_html__( "Tasks Completed", "sweeppress" ) . '</dt><dd>' . absint( $results['stats']['tasks'] ) . '</dd>';
		$render .= '</dl>';
		$render .= '<h5>' . esc_html__( "Sweepers Used", "sweeppress" ) . '</h5>';
		$render .= $_sweepers;
		$render .= '</div>';

		return $render;
	}
}
