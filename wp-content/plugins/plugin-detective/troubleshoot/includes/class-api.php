<?php
/**
 * Troubleshoot Api.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Api.
 *
 * @since 0.0.0
 */
class PDT_Api {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Troubleshoot
	 */
	protected $plugin = null;

	public $params = array();
	public $args = array();
	public $errors = array();
	public $data = array();


	/**
	 * Constructor.
	 *
	 * @since  0.0.0
	 *
	 * @param  Troubleshoot $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  0.0.0
	 */
	public function hooks() {

	}

	public function process_params() {
		$param_keys = array(
			'nonce' => array(
				'is_required' => false,
				'escape_callback' => 'esc_attr',
				'validation_callback' => '__return_true',
			),

			'controller' => array(
				'is_required' => false,
				'escape_callback' => 'esc_attr',
				'validation_callback' => '__return_true',
			),

			'action' => array(
				'is_required' => true,
				'escape_callback' => 'esc_attr',
				'validation_callback' => array( 'PDT_Api', 'is_string' ),
			),

			'username' => array(
				'is_required' => false,
				'escape_callback' => 'esc_attr',
				'validation_callback' => '__return_true',
			),

			'password' => array(
				'is_required' => false,
				'escape_callback' => 'esc_attr',
				'validation_callback' => '__return_true',
			),
		);

		foreach ($param_keys as $param_key => $param_options) {
			if ( !isset( $this->request[$param_key] ) ) {
				if ( $param_options['is_required'] ) {
					$this->errors[$param_key] = 'Required parameter';
				}

				$this->params[$param_key] = null;
				continue;
			}

			$param_value = call_user_func( $param_options['escape_callback'], $this->request[$param_key] );

			$validation_response = call_user_func( $param_options['validation_callback'], $param_value );
			if ( true !== $validation_response ) {
				$this->errors[$param_key] = $validation_response;
				continue;
			}

			$this->params[$param_key] = $param_value;
		}

		if ( empty( $this->params['nonce'] ) && $this->params['action'] == 'authenticate' ) {
			if ( empty( $this->params['username'] ) ) {
				$this->errors['username'] = 'Required for authentication';
			}

			if ( empty( $this->params['password'] ) ) {
				$this->errors['password'] = 'Required for authentication';
			}
		}
	}

	public function process_input() {
		$this->request = array();

		if ( !empty( $_REQUEST ) ) {
			$this->request = $_REQUEST;
		}

		$json = file_get_contents("php://input");
		if ( empty( $json ) ) {
			return;
		}

		$array = json_decode( $json, true );
		if ( empty( $array ) ) {
			if ( empty( $this->request ) ) {
				$this->errors['no_input'] = __( 'No input detected, possibly due to a malformed request or server setting. Please contact support', 'plugin-detective' );
			}

			return;
		}

		$this->request = array_merge( $this->request, $array );
	}

	public function process_args() {
		$args = $this->request;
		foreach ($this->params as $key => $value) {
			unset( $args[$key] );
		}
		$this->args = $args;
	}

	public function process_request() {
		if ( empty( $this->request ) ) {
			$this->process_input();
		}

		if ( empty( $this->params ) ) {
			$this->process_params();
		}

		if ( empty( $this->args ) ) {
			$this->process_args();
		}

		if ( !empty( $this->errors ) ) {
			$this->return_response();
		}

		// Authentication Request
		if ( $this->params['action'] == 'authenticate' ) {
			$auth_response = $this->plugin->auth->get_nonce( $this->params['username'], $this->params['password'], 'pd_api' );

			if ( is_a( $auth_response, 'WP_Error' ) ) {
				$this->errors['authentication'] = array_keys( $auth_response->errors );
				$this->errors['authentication'] = $this->errors['authentication']['0'];
			} else {
				$this->data['nonce'] = $auth_response;
			}

			$user_response = $this->plugin->auth->get_user( $this->params['username'], $this->params['password'], 'pd_api' );

			if ( is_a( $user_response, 'WP_Error' ) ) {
				$this->errors['authentication'] = array_keys( $user_response->errors );
				$this->errors['authentication'] = $this->errors['authentication']['0'];
			} else {
				$this->data['user'] = $user_response;
			}

			$this->return_response();
		}


		// Verify nonce value
		if ( empty( $this->params['nonce'] ) ) {
			$this->errors['nonce'] = 'Required for authenticated requests';
			$this->return_response();
		}

		if ( ! $this->plugin->auth->verify_nonce( $this->params['nonce'], 'pd_api' ) ) {
			$this->errors['nonce'] = 'Invalid';
			$this->return_response();
		}


		// Process request
		$object = $this;
		if ( !empty( $this->params['controller'] ) ) {
			if ( !in_array( $this->params['controller'], array(
				'plugins',
				'installed',
				'cases',
				'clues',
			) ) ) {
				$this->errors['controller'] = 'Trying to access a disallowed controller';
				$this->return_response();
			}

			if ( !property_exists( $this->plugin, $this->params['controller'] ) ) {
				$this->errors['controller'] = 'Controller not found';
				$this->return_response();
			}
			$controller = $this->params['controller'];
			$object = $this->plugin->$controller;
		}

		if ( !method_exists( $object, $this->params['action'] ) ) {
			$this->errors['action'] = 'Action not found';
			$this->return_response();
		}
	
		$action = $this->params['action'];

		$response = $object->$action( $this->args );
		if ( is_a( $response, 'WP_Error' ) ) {
			$this->errors[$response->get_error_code()] = $response->get_error_message();
		} else {
			$this->data = $response;
		}

		$this->return_response();
	}

	public function test() {
		return array( 'test' => 'value',);
	}

	public function return_response() {
		header( 'Content-type: application/json' );
		echo json_encode( array(
			'data' => $this->data,
			'errors' => $this->errors,
		) );

		exit();
	}

	public static function is_string( $string ) {
		if ( !is_string( $string ) ) {
			return 'String value required';
		}

		if ( (string)(int)$string === (string)$string ) {
			return 'Non-numeric value';
		}

		return true;
	}
}
