<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

use \WebPConvert\Convert\ConverterFactory;

require_once WPO_PLUGIN_MAIN_PATH . 'vendor/autoload.php';

if (!class_exists('WPO_WebP_Utils')) :

class WPO_WebP_Utils {

	/**
	 * Determines whether we can do webp conversion or not
	 *
	 * @return bool
	 */
	public static function can_do_webp_conversion() {
		$webp_conversion = WP_Optimize()->get_options()->get_option('webp_conversion', false);
		$webp_converters = WP_Optimize()->get_options()->get_option('webp_converters', false);
		return $webp_conversion && !empty($webp_converters);
	}

	/**
	 * Convert given image file to webp format
	 *
	 * @param string $source Path of image file
	 *
	 * @return void
	 */
	public static function do_webp_conversion($source) {
		$webp_converter = new WPO_WebP_Convert();
		$webp_converter->convert($source);
	}

	/**
	 * Converts an image to WebP format using a specified converter.
	 *
	 * This method acts as a wrapper for the `WebPConvert\Convert\Converters\AbstractConverter::doConvert()` method
	 * from the `webp-convert` library.
	 *
	 * @param string $converter   The converter to be used for the conversion process.
	 * @param string $source      The path to the source image file.
	 * @param string $destination The path to the destination WebP image file.
	 */
	public static function perform_webp_conversion($converter, $source, $destination) {
		$converter_instance = ConverterFactory::makeConverter(
			$converter,
			$source,
			$destination
		);

		set_error_handler(array(__CLASS__, 'handle_webp_conversion_warnings'), E_WARNING);

		$converter_instance->doConvert();

		restore_error_handler();
	}

	/**
	 * Custom error handler for handling PHP warnings during the WebP conversion process.
	 *
	 * @param int    $errno  The level of the error raised, as an integer.
	 * @param string $errstr The error message.
	 *
	 * @return bool
	 */
	public static function handle_webp_conversion_warnings($errno, $errstr) {
		$patterns = array(
			'/unlink\(.+\): No such file or directory/',
			'/rename\(.+\): No such file or directory/',
			'/filesize\(\): stat failed for/',
		);

		foreach ($patterns as $pattern) {
			if (preg_match($pattern, $errstr)) {
				// Suppress the warning by returning true
				return true;
			}
		}

		// For other PHP warnings, use the default PHP error handler by returning false
		return false;
	}
}

endif;
