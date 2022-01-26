<?php

namespace WBCR\Factory_Feedback_112;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Factory request class.
 *
 * Performs a server request, retrieves banner data and stores it in the cache.
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 * @author        Artem Prihodko <webtemyk@yandex.ru>
 *
 * @since         1.0.0 Added
 *
 * @package       factory-feedback
 * @copyright (c) 2019 Webcraftic Ltd
 */
class Creative_Motion_API {

	/**
	 * Rest request url.
	 *
	 * Define rest request url for rest request to remote server.
	 *
	 * @since 1.2.1
	 */
	//const SERVER_URL = 'http://antispam.loc';
	const SERVER_URL = 'https://api.cm-wp.com';
	/**
	 * Rest route path.
	 *
	 * Define rest route path for rest request.
	 *
	 * @since 1.0.0
	 */
	const REST_ROUTE = '/feedback/v1/add';

	/**
	 * Plugin instance this module interacts with
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 * @var \Wbcr_Factory450_Plugin
	 */
	private $plugin;


	/**
	 * Request constructor.
	 *
	 * Variable initialization.
	 *
	 * @since 1.0.0 Added
	 *
	 * @param \Wbcr_Factory450_Plugin $plugin_name
	 */
	public function __construct( \Wbcr_Factory450_Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Get adverts content.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 *
	 * @param $position
	 *
	 * @return string|\WP_Error
	 */
	public function send_feedback( $plugin, $data ) {
		$resp = $this->do_api_request( $plugin, $data );

		if ( is_wp_error( $resp ) ) {
			return $resp;
		}

		return true;
	}

	/**
	 * Performs rest api request.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	private function do_api_request( $plugin, $data ) {
		$default_result = [];
		$data['plugin'] = $plugin;

		$url = untrailingslashit( self::SERVER_URL ) . '/wp-json' . self::REST_ROUTE;
		//$url = add_query_arg( $data, $url);

		$response = wp_remote_post( $url, [ 'body' => $data ] );

		$code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );

		$res_data = @json_decode( $body, true );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( 200 !== $code ) {
			return new \WP_Error( 'http_request_error', 'Failed request to the remote server. Code: ' . $code );
		}

		return wp_parse_args( $res_data, $default_result );
	}
}
