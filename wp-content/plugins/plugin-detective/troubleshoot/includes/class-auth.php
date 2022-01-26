<?php
/**
 * Troubleshoot Auth.
 *
 * @since   0.0.0
 * @package Troubleshoot
 */

/**
 * Troubleshoot Auth.
 *
 * @since 0.0.0
 */
class PDT_Auth {
	/**
	 * Parent plugin class.
	 *
	 * @since 0.0.0
	 *
	 * @var   Troubleshoot
	 */
	protected $plugin = null;

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

	public static function get_user( $username, $password, $action ) {
		$username = sanitize_user($username);
		$password = trim($password);

		$user = apply_filters( 'authenticate', null, $username, $password );
		if ( $user == null ) {
			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Invalid username, email address or incorrect password.', 'plugin-detective' ) );
		}
		if ( is_a( $user, 'WP_Error' ) ) {
			return $user;
		}

		if ( !user_can( $user, 'activate_plugins' ) ) {
			return new WP_Error( 'permission_denied', __( '<strong>ERROR</strong>: This user does not have permission to activate/deactivate plugins', 'plugin-detective' ) );
		}

		// $slug = sanitize_title( $username.sha1( DB_PASSWORD . $password ).$action );
		return $user->data;
	}

	public static function get_nonce( $username, $password, $action ) {
		$username = sanitize_user($username);
		$password = trim($password);

		$user = apply_filters( 'authenticate', null, $username, $password );
		if ( $user == null ) {
			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Invalid username, email address or incorrect password.', 'plugin-detective' ) );
		}
		if ( is_a( $user, 'WP_Error' ) ) {
			return $user;
		}

		if ( !user_can( $user, 'activate_plugins' ) ) {
			return new WP_Error( 'permission_denied', __( '<strong>ERROR</strong>: This user does not have permission to activate/deactivate plugins', 'plugin-detective' ) );
		}

		// $slug = sanitize_title( $username.sha1( DB_PASSWORD . $password ).$action );
		return self::create_nonce( $action );
	}

	public static function create_nonce( $action ) {
		$uid = 'api';

		if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$token = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$token = '';
		}
		$i = strtotime( gmdate( 'Y-m-d' ) );

		return substr( sha1( DB_PASSWORD . $i . '|' . $action . '|' . $uid . '|' . $token  ), -12, 10 );	
	}

	public static function verify_nonce( $nonce, $action ) {
		$nonce = (string) $nonce;
		$uid = 'api';
		if ( !empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$token = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$token = '';
		}

		if ( empty( $nonce ) ) {
			return false;
		}

		$i = strtotime( gmdate( 'Y-m-d' ) );

		// Nonce generated today (gmt)
		$expected = substr( sha1( DB_PASSWORD . $i . '|' . $action . '|' . $uid . '|' . $token ), -12, 10 );
		if ( hash_equals( $expected, $nonce ) ) {
			return 1;
		}

		// Nonce generated yesterday (gmt)
		$expected = substr( sha1( DB_PASSWORD . ( $i - 24*60*60 ) . '|' . $action . '|' . $uid . '|' . $token  ), -12, 10 );
		if ( hash_equals( $expected, $nonce ) ) {
			return 2;
		}

		// Invalid nonce
		return false;
	}

}
