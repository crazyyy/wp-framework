<?php
if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!trait_exists('WP_Optimize_HTTP_Error_Codes_Trait')) :
trait WP_Optimize_HTTP_Error_Codes_Trait {
	
	/**
	 * List of HTTP semantic codes taken from
	 * https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	 * This list includes non-default HTTP codes that are not part of RFC 9110 but might appear on the wild
	 *
	 * @var array
	 */
	private $http_codes;

	/**
	 * Initialize `$this->http_codes` table
	 *
	 * @return void
	 */
	private function set_codes() {
		$this->http_codes =  array(
			100 => __('Continue', 'wp-optimize'),
			101 => __('Switching Protocols', 'wp-optimize'),
			102 => __('Processing (WebDAV; RFC 2518)', 'wp-optimize'),
			103 => __('Early Hints (RFC 8297)', 'wp-optimize'),
			200 => __('OK', 'wp-optimize'),
			201 => __('Created', 'wp-optimize'),
			202 => __('Accepted', 'wp-optimize'),
			203 => __('Non-Authoritative Information (since HTTP/1.1)', 'wp-optimize'),
			204 => __('No Content', 'wp-optimize'),
			205 => __('Reset Content', 'wp-optimize'),
			206 => __('Partial Content', 'wp-optimize'),
			207 => __('Multi-Status (WebDAV; RFC 4918)', 'wp-optimize'),
			208 => __('Already Reported (WebDAV; RFC 5842)', 'wp-optimize'),
			226 => __('IM Used (RFC 3229)', 'wp-optimize'),
			300 => __('Multiple Choices', 'wp-optimize'),
			301 => __('Moved Permanently', 'wp-optimize'),
			302 => __('Found (Previously "Moved temporarily")', 'wp-optimize'),
			303 => __('See Other (since HTTP/1.1)', 'wp-optimize'),
			304 => __('Not Modified', 'wp-optimize'),
			305 => __('Use Proxy (since HTTP/1.1)', 'wp-optimize'),
			306 => __('Switch Proxy', 'wp-optimize'),
			307 => __('Temporary Redirect (since HTTP/1.1)', 'wp-optimize'),
			308 => __('Permanent Redirect', 'wp-optimize'),
			400 => __('Bad Request', 'wp-optimize'),
			401 => __('Unauthorized', 'wp-optimize'),
			402 => __('Payment Required', 'wp-optimize'),
			403 => __('Forbidden', 'wp-optimize'),
			404 => __('Not Found', 'wp-optimize'),
			405 => __('Method Not Allowed', 'wp-optimize'),
			406 => __('Not Acceptable', 'wp-optimize'),
			407 => __('Proxy Authentication Required', 'wp-optimize'),
			408 => __('Request Timeout', 'wp-optimize'),
			409 => __('Conflict', 'wp-optimize'),
			410 => __('Gone', 'wp-optimize'),
			411 => __('Length Required', 'wp-optimize'),
			412 => __('Precondition Failed', 'wp-optimize'),
			413 => __('Payload Too Large', 'wp-optimize'),
			414 => __('URI Too Long', 'wp-optimize'),
			415 => __('Unsupported Media Type', 'wp-optimize'),
			416 => __('Range Not Satisfiable', 'wp-optimize'),
			417 => __('Expectation Failed', 'wp-optimize'),
			418 => __('I\'m a teapot (RFC 2324, RFC 7168)', 'wp-optimize'),
			421 => __('Misdirected Request', 'wp-optimize'),
			422 => __('Unprocessable Entity', 'wp-optimize'),
			423 => __('Locked (WebDAV; RFC 4918)', 'wp-optimize'),
			424 => __('Failed Dependency (WebDAV; RFC 4918)', 'wp-optimize'),
			425 => __('Too Early (RFC 8470)', 'wp-optimize'),
			426 => __('Upgrade Required', 'wp-optimize'),
			428 => __('Precondition Required (RFC 6585)', 'wp-optimize'),
			429 => __('Too Many Requests (RFC 6585)', 'wp-optimize'),
			431 => __('Request Header Fields Too Large (RFC 6585)', 'wp-optimize'),
			451 => __('Unavailable For Legal Reasons (RFC 7725)', 'wp-optimize'),
			500 => __('Internal Server Error', 'wp-optimize'),
			501 => __('Not Implemented', 'wp-optimize'),
			502 => __('Bad Gateway', 'wp-optimize'),
			503 => __('Service Unavailable', 'wp-optimize'),
			504 => __('Gateway Timeout', 'wp-optimize'),
			505 => __('HTTP Version Not Supported', 'wp-optimize'),
			506 => __('Variant Also Negotiates (RFC 2295)', 'wp-optimize'),
			507 => __('Insufficient Storage (WebDAV; RFC 4918)', 'wp-optimize'),
			508 => __('Loop Detected (WebDAV; RFC 5842)', 'wp-optimize'),
			510 => __('Not Extended (RFC 2774)', 'wp-optimize'),
			511 => __('Network Authentication Required (RFC 6585)', 'wp-optimize'),
			218 => __('This is fine (Apache HTTP Server)', 'wp-optimize'),
			419 => __('Page Expired (Laravel Framework)', 'wp-optimize'),
			420 => __('Method Failure (Spring Framework)', 'wp-optimize'),
			430 => __('Request Header Fields Too Large (Shopify)', 'wp-optimize'),
			450 => __('Blocked by Windows Parental Controls (Microsoft)', 'wp-optimize'),
			498 => __('Invalid Token (Esri)', 'wp-optimize'),
			509 => __('Bandwidth Limit Exceeded (Apache Web Server/cPanel)', 'wp-optimize'),
			529 => __('Site is overloaded', 'wp-optimize'),
			530 => __('Site is frozen', 'wp-optimize'),
			598 => __('(Informal convention) Network read timeout error', 'wp-optimize'),
			599 => __('Network Connect Timeout Error', 'wp-optimize'),
			440 => __('IIS - Login Time-out', 'wp-optimize'),
			449 => __('IIS - Retry With', 'wp-optimize'),
			444 => __('Nginx - No Response', 'wp-optimize'),
			494 => __('Nginx - Request header too large', 'wp-optimize'),
			495 => __('Nginx - SSL Certificate Error', 'wp-optimize'),
			496 => __('Nginx - SSL Certificate Required', 'wp-optimize'),
			497 => __('Nginx - HTTP Request Sent to HTTPS Port', 'wp-optimize'),
			499 => __('Nginx - Client Closed Request', 'wp-optimize'),
			520 => __('Cloudflare - Web Server Returned an Unknown Error', 'wp-optimize'),
			521 => __('Cloudflare - Web Server Is Down', 'wp-optimize'),
			522 => __('Cloudflare - Connection Timed Out', 'wp-optimize'),
			523 => __('Cloudflare - Origin Is Unreachable', 'wp-optimize'),
			524 => __('Cloudflare - A Timeout Occurred', 'wp-optimize'),
			525 => __('Cloudflare - SSL Handshake Failed', 'wp-optimize'),
			526 => __('Cloudflare - Invalid SSL Certificate', 'wp-optimize'),
			527 => __('Cloudflare - Railgun Error', 'wp-optimize'),
			460 => __('AWS Load Balancer - Connection Closed', 'wp-optimize'),
			463 => __('AWS Load Balancer - Too Many Redirects', 'wp-optimize'),
			464 => __('AWS Load Balancer - Incompatible Protocols', 'wp-optimize'),
			561 => __('AWS Load Balancer - Unauthorized', 'wp-optimize'),
		);
	}

	/**
	 * Get the current theme's style.css headers
	 *
	 * @return array|WP_Error
	 */
	protected function get_stylesheet_headers() {
		static $headers;
		if (isset($headers)) return $headers;

		$style = get_template_directory_uri() . '/style.css';

		/**
		 * Filters wp_remote_get parameters, when checking if browser cache is enabled.
		 *
		 * @param array $request_params Default parameters
		 */
		$request_params = apply_filters('wpoptimize_get_stylesheet_headers_args', array('timeout' => 10));

		// trying to load style.css.
		$response = wp_remote_get($style, $request_params);

		if (is_wp_error($response)) return $response;

		$response_code = wp_remote_retrieve_response_code($response);
		if (200 != $response_code) {
			$link = sprintf('<a href="%s" target="_blank">%s</a>', $style, $style);

			if (401 == $response_code) {
				$error = '<b>' . esc_html__('401 Unauthorized', 'wp-optimize') . '</b>';
				// translators: %s is a `401 Unauthorized` error message
				$error_string = sprintf(esc_html__('The server responded with a %s error.', 'wp-optimize'), $error) . ' '
					. esc_html__('This usually happens when the site requires authentication to access it.', 'wp-optimize') . ' '
					// translators: %s is a link to the style.css file
					. sprintf(esc_html__('Please temporarily disable authentication for the following URL: %s and retry.', 'wp-optimize'), $link);
			} elseif (404 == $response_code) {
				$error = '<b>' . esc_html__('404 File Not Found', 'wp-optimize') . '</b>';
				// translators: %s is a `404 File Not Found` error message
				$error_string = sprintf(esc_html__('The server responded with a %s error', 'wp-optimize'), $error) . ' '
					// translators: %s is a link to the style.css file
					. sprintf(esc_html__('Please temporarily restore the file under URL: %s, or just create an empty file and try again.', 'wp-optimize'), $link);
			} else {
				$error = '<b>' . $response_code . ' ' . $this->get_http_code_label($response_code) . '</b>';
				// translators: %1$s is an HTTP error response code, %2$s is a link to the style.css file
				$error_string = sprintf(esc_html__('The server responded with a %1$s error whilst trying to open the URL: %2$s.', 'wp-optimize'), $error, $link) . ' '
					. esc_html__('Please contact your website administrator to resolve this.', 'wp-optimize') . ' ' . esc_html__('Once the issue is addressed, try again.', 'wp-optimize');
			}

			return new WP_Error('unauthorized', $error_string);
		}

		$headers = wp_remote_retrieve_headers($response);

		if (is_object($headers) && method_exists($headers, 'getAll')) {
			$headers = $headers->getAll();
		}

		return is_array($headers) ? $headers : array();
	}

	/**
	 * Return label for HTTP code
	 *
	 * @param int $code The HTTP code
	 * @return string
	 */
	private function get_http_code_label($code) {
		if (!isset($this->http_codes)) {
			$this->set_codes();
		}

		return $code . " " . empty($this->http_codes[$code]) ? esc_html__("HTTP Code", "wp-optimize") : $this->http_codes[$code];
	}
}
endif;
