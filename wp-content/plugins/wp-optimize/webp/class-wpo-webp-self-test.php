<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WPO_WebP_Self_Test')) :

class WPO_WebP_Self_Test {

	/**
	 * Determines whether content type header has webp mime or not
	 *
	 * @param array $headers An array of headers
	 *
	 * @return bool
	 */
	private function has_webp_mime($headers) {
		return isset($headers['content-type']) && 0 === strcasecmp('image/webp', $headers['content-type']);
	}

	/**
	 * Determines whether headers has `vary` header or not
	 *
	 * @param array $headers An array of headers
	 *
	 * @return bool
	 */
	private function has_vary($headers) {
		return isset($headers['vary']) && preg_match('/accept/i', $headers['vary']);
	}

	/**
	 * Decided whether webp version is served or not
	 *
	 * @return bool
	 */
	public function is_webp_served() {
		$args = array(
			'headers' => array(
				'accept' => 'image/webp'
			)
		);

		$upload_dir = wp_upload_dir();
		$url =  $upload_dir['baseurl']. '/wpo/images/wpo_logo_small.png';

		$response = wp_remote_head($url, $args);

		if (is_wp_error($response)) return false;
		if (200 != $response['response']['code']) return false;

		$headers = wp_remote_retrieve_headers($response);
		if (method_exists($headers, 'getAll')) {
			$headers = $headers->getAll();
			if ($this->has_webp_mime($headers) && $this->has_vary($headers)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns singleton instance
	 *
	 * @return WPO_WebP_Self_Test
	 */
	public static function get_instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}
}

endif;
