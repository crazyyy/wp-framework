<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

if (class_exists('AIOWPSecurity_Utility_API')) return;

class AIOWPSecurity_Utility_API {

	/**
	 * Performs a GET request.
	 *
	 * @param string $url  The URL to send the request to.
	 * @param array  $args The request arguments.
	 *
	 * @return array|string|WP_Error The response or WP_Error on failure.
	 */
	public function get($url, $args = array()) {
		return $this->make_api_request($url, $args, 'GET');
	}

	/**
	 * Performs a POST request.
	 *
	 * @param string $url  The URL to send the request to.
	 * @param array  $args The request arguments.
	 *
	 * @return array|string|WP_Error The response or WP_Error on failure.
	 */
	public function post($url, $args = array()) {
		return $this->make_api_request($url, $args, 'POST');
	}

	/**
	 * Main method to make the API request.
	 *
	 * @param string $url    The URL to send the request to.
	 * @param array  $args   The request arguments.
	 * @param string $method The request method: 'GET' or 'POST'.
	 *
	 * @return array|string|WP_Error The response or WP_Error on failure.
	 */
	private function make_api_request($url, $args = array(), $method = 'GET') {
		global $aio_wp_security;

		// Validate the method
		$method = strtoupper($method);
		if (!in_array($method, array('GET', 'POST'))) {
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() - Invalid request method. Only GET and POST are supported.", 4);
			return new WP_Error('aios_api_invalid_method', 'Invalid request method. Only GET and POST are supported.');
		}

		// Validate the URL
		if ('' !== $url && !filter_var($url, FILTER_VALIDATE_URL)) {
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() - Invalid or missing request URL.", 4);
			return new WP_Error('aios_api_invalid_url', 'Invalid or missing request URL.');
		}

		// Set up default arguments
		$default_args = array(
			'headers' => array(),
			'body'    => array(),
			'timeout' => 10,
		);

		// Merge default arguments with provided arguments
		$request_args = wp_parse_args($args, $default_args);

		// Make the request
		if ('POST' === $method) {
			$response = wp_remote_post($url, $request_args);
		} else {
			$response = wp_remote_get($url, $request_args);
		}

		// Check for errors
		if (is_wp_error($response)) {
			// Get error code and message
			$error_code = $response->get_error_code();
			$error_message = $response->get_error_message();
			$error_data = $response->get_error_data(); // Optional additional error data

			// Log the error details
			$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() | Response error - Code: {$error_code}, Message: {$error_message}", 4);

			// Log any additional error data (could be useful for debugging)
			if ($error_data) {
				if (is_array($error_data) || is_object($error_data)) {
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() | Response error - Additional Error Data: " . json_encode($error_data), 4);
				} else {
					$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() | Response error - Additional Error Data: {$error_data}", 4);
				}
			}
			
			return $response;
		}

		// Get the response body
		$response_body = wp_remote_retrieve_body($response);

		// Check for JSON response
		$content_type = wp_remote_retrieve_header($response, 'content-type');
		if (false !== strpos($content_type, 'application/json')) {

			// Decode the response body if it's JSON
			$decoded_body = json_decode($response_body, true);

			// Log JSON decoding error if any
			if (JSON_ERROR_NONE !== json_last_error()) {
				$aio_wp_security->debug_logger->log_debug("AIOWPSecurity_Utility_API::make_api_request() - JSON decode error: " . json_last_error_msg(), 4);
				return new WP_Error('aios_api_json_decode_error', json_last_error_msg());
			}

			// Return the decoded JSON response body
			return $decoded_body;
		}

		// Return raw response body if it's not JSON
		return $response_body;
	}
}
