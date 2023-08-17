<?php

namespace Dev4Press\Plugin\SweepPress\Expand;

use Dev4Press\v42\Core\Quick\File;
use WP_REST_Server;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class REST {
	private $namespace = 'sweeppress/v1';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'init' ) );
	}

	public static function instance() : REST {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new REST();
		}

		return $instance;
	}

	public function init() {
		register_rest_route( $this->namespace, '/list', array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'route_list' ),
			'permission_callback' => array( $this, 'is_allowed' ),
		) );

		register_rest_route( $this->namespace, '/list/(?P<sweeper>[\w-]+)', array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( $this, 'route_list_sweeper' ),
			'permission_callback' => array( $this, 'is_allowed' ),
			'args'                => array(
				'sweeper' => array(
					'description'       => __( "Name of the sweeper to get list of tasks.", "sweeppress" ),
					'type'              => 'string',
					'required'          => true,
					'validate_callback' => array( $this, 'is_sweeper_valid' ),
				),
			),
		) );

		register_rest_route( $this->namespace, '/auto', array(
			'methods'             => WP_REST_Server::DELETABLE,
			'callback'            => array( $this, 'route_auto' ),
			'permission_callback' => array( $this, 'is_allowed' ),
		) );

		register_rest_route( $this->namespace, '/sweep/(?P<sweeper>[\w-]+)', array(
			'methods'             => WP_REST_Server::DELETABLE,
			'callback'            => array( $this, 'route_sweep' ),
			'permission_callback' => array( $this, 'is_allowed' ),
			'args'                => array(
				'sweeper' => array(
					'description'       => __( "Name of the sweeper to run.", "sweeppress" ),
					'type'              => 'string',
					'required'          => true,
					'validate_callback' => array( $this, 'is_sweeper_valid' ),
				),
			),
		) );
	}

	public function route_list( $request ) : array {
		return $this->_available_jobs();
	}

	public function route_list_sweeper( $request ) : array {
		$sweeper = $request->get_param( 'sweeper' );

		return $this->_available_tasks_for_sweeper( $sweeper );
	}

	public function route_auto( $request ) : array {
		$results = sweeppress_core()->auto_sweep( 'rest' );

		return $this->_format_results_as_json( $results );
	}

	public function route_sweep( $request ) : array {
		$sweeper = $request->get_param( 'sweeper' );
		$results = sweeppress_core()->sweep( array( $sweeper => true ), 'rest' );

		return $this->_format_results_as_json( $results );
	}

	public function is_sweeper_valid( $sweeper ) : bool {
		return sweeppress_core()->is_sweeper_valid( $sweeper );
	}

	public function is_allowed() : bool {
		return current_user_can( 'activate_plugins' );
	}

	private function _available_tasks_for_sweeper( string $code ) : array {
		$tasks   = array();
		$sweeper = sweeppress_core()->sweeper( $code );

		if ( $sweeper ) {
			if ( $sweeper->is_sweepable() ) {
				$_tasks = $sweeper->get_tasks();

				foreach ( $_tasks as $task => $data ) {
					if ( $data['records'] > 0 || $data['size'] > 0 ) {
						$tasks[ $task ] = array(
							'records' => $data['records'],
							'size'    => File::size_format( $data['size'], 2, '', false ),
						);
					}
				}
			}
		}

		return $tasks;
	}

	private function _available_jobs() : array {
		$jobs = array();
		$list = sweeppress_core()->available();

		foreach ( $list as $sweepers ) {
			foreach ( $sweepers as $sweeper ) {
				if ( $sweeper->is_sweepable() ) {
					$_tasks = $sweeper->get_tasks();

					$_records = $_size = $_count = 0;

					foreach ( $_tasks as $data ) {
						if ( $data['records'] > 0 || $data['size'] > 0 ) {
							$_count ++;
							$_records += $data['records'];
							$_size    += $data['size'];
						}
					}

					if ( $_records > 0 || $_size > 0 ) {
						$jobs[ $sweeper->get_code() ] = array(
							'tasks'   => $_count,
							'records' => $_records,
							'size'    => File::size_format( $_size, 2, '', false ),
						);
					}
				}
			}
		}

		return $jobs;
	}

	private function _format_results_as_json( $results ) : array {
		$json            = $results['stats'];
		$json['started'] = $results['timer']['started'];
		$json['ended']   = $results['timer']['ended'];

		unset( $json['source'] );

		return $json;
	}
}
