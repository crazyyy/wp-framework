<?php

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WP_Optimize_Utils')) :

class WP_Optimize_Utils {

	/**
	 * Returns the folder path for log files
	 *
	 * @return string - Folder path for log files with trailing slash
	 */
	public static function get_log_folder_path() {
		$upload_base = self::get_base_upload_dir();
		if (!is_dir($upload_base . 'wpo/logs')) {
			wp_mkdir_p($upload_base . 'wpo/logs');
		}
		// Ensure index.php in log folder to stop directory listing
		if (!file_exists($upload_base . 'wpo/logs/index.php')) {
			file_put_contents($upload_base . 'wpo/logs/index.php', "<?php");
		}
		return $upload_base . 'wpo/logs/';
	}

	/**
	 * Generates a log file name based on the given prefix.
	 *
	 * @param string $prefix The prefix to be added to the log file name.
	 * @return string The generated log file name.
	 */
	public static function get_log_file_name($prefix) {
		return $prefix . '-' . substr(md5(wp_salt()), 0, 20) . '.log';
	}

	/**
	 * Returns the file path for the log file.
	 *
	 * @param string $prefix The prefix to be added to the log file name.
	 * @return string The file path for the log file.
	 */
	public static function get_log_file_path($prefix) {
		return self::get_log_folder_path() . self::get_log_file_name($prefix);
	}

	/**
	 * Returns WordPress GMT offset in seconds.
	 *
	 * @return int
	 */
	public static function get_gmt_offset() {
		$timezone_string = get_option('timezone_string');

		if (!empty($timezone_string)) {
			$timezone = new DateTimeZone($timezone_string);
			$gmt_offset = $timezone->getOffset(new DateTime());
		} else {
			$gmt_offset_option = get_option('gmt_offset');
			$gmt_offset = (int) (3600 * $gmt_offset_option);
		}

		return $gmt_offset;
	}

	/**
	 * Returns the folder path for the upload directory with trailing slash
	 *
	 * @return string - Folder path for the upload directory with trailing slash
	 */
	public static function get_base_upload_dir() {
		$upload_dir = wp_upload_dir();
		return trailingslashit($upload_dir['basedir']);
	}

	/**
	 * Get the file path
	 *
	 * @param string $url
	 * @return string
	 */
	public static function get_file_path($url) {
		if (is_multisite()) {
			if (function_exists('get_main_site_id')) {
				$site_id = get_main_site_id();
			} else {
				$network = get_network();
				$site_id = $network->site_id;
			}
			switch_to_blog($site_id);
		}
		$upload_dir = wp_upload_dir();
		$uploads_url = trailingslashit($upload_dir['baseurl']);
		$uploads_dir = trailingslashit($upload_dir['basedir']);
		if (is_multisite()) {
			restore_current_blog();
		}
		$possible_urls = array(
			WP_CONTENT_URL => WP_CONTENT_DIR,
			WP_PLUGIN_URL => WP_PLUGIN_DIR,
			$uploads_url => $uploads_dir,
			get_template_directory_uri() => get_template_directory(),
			untrailingslashit(includes_url()) => ABSPATH . WPINC,
		);
		$file = '';
		foreach ($possible_urls as $possible_url => $path) {
			$pos = strpos($url, $possible_url);
			if (0 === $pos) {
				$file = substr_replace($url, $path, $pos, strlen($possible_url));
				break;
			}
		}
		return $file;
	}

	/**
	 * Parse tag attributes and return array with them.
	 *
	 * @param string $tag
	 * @return array
	 */
	public static function parse_attributes($tag) {
		$attributes = array();

		$_attributes = wp_kses_hair($tag, wp_allowed_protocols());

		if (empty($_attributes)) return $attributes;

		foreach ($_attributes as $key => $value) {
			$attributes[$key] = $value['value'];
		}

		return $attributes;
	}

	/**
	 * Checks whether supplied string is a valid html document or not
	 *
	 * @param string $html - HTML document as string
	 * @return bool
	 */
	public static function is_valid_html($html) {
		if (is_feed()) return false;

		// To prevent issue with `simple_html_dom` class
		// Exit if it doesn't look like HTML
		// https://github.com/rosell-dk/webp-express/issues/228
		if (!preg_match("#^\\s*<#", $html)) return false;

		if ('' === $html) return false;
		return true;
	}

	/**
	 * Include simple html dom script if not available
	 */
	public static function maybe_include_simple_html_dom() {
		if (!function_exists('str_get_html')) {
			require_once WPO_PLUGIN_MAIN_PATH . 'vendor/simplehtmldom/simplehtmldom/simple_html_dom.php';
		}
	}

	/**
	 * Returns simplehtmldom\HtmlDocument object
	 *
	 * @param string $html_buffer - HTML document as string
	 * @return simplehtmldom\HtmlDocument | boolean
	 */
	public static function get_simple_html_dom_object($html_buffer) {
		self::maybe_include_simple_html_dom();
		return str_get_html($html_buffer, false, false,
			get_option('blog_charset'), false, DEFAULT_BR_TEXT,
			DEFAULT_SPAN_TEXT, false);
	}

	/**
	 * Unserialize data
	 *
	 * @param string        $serialized_data Data to be unserialized, should be one that is already serialized
	 * @param boolean|array $allowed_classes Either an array of class names which should be accepted, false to accept no classes, or true to accept all classes
	 * @param integer       $max_depth       The maximum depth of structures permitted during unserialization, and is intended to prevent stack overflows
	 * @return mixed Unserialized data can be any of types (integer, float, boolean, string, array or object)
	 */
	public static function unserialize($serialized_data, $allowed_classes = false, $max_depth = 0) {
		// phpcs:ignore PHPCompatibility.FunctionUse.NewFunctionParameters.unserialize_optionsFound -- Used in PHP 7.0+
		// phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress PHP warning in case of failure
		return @unserialize(trim($serialized_data), array('allowed_classes' => $allowed_classes, 'max_depth' => $max_depth));
	}

	/**
	 * Checks whether supplied data is serialized or not, and if so, unserializes it
	 *
	 * @param string        $serialized_data Data to be unserialized, should be one that is already serialized
	 * @param boolean|array $allowed_classes Either an array of class names which should be accepted, false to accept no classes, or true to accept all classes
	 * @param integer       $max_depth       The maximum depth of structures permitted during unserialization, and is intended to prevent stack overflows
	 * @return mixed Unserialized data can be any of types (integer, float, boolean, string, array or object)
	 */
	public static function maybe_unserialize($serialized_data, $allowed_classes = false, $max_depth = 0) {
		if (!is_serialized($serialized_data)) return $serialized_data;

		return self::unserialize($serialized_data, $allowed_classes, $max_depth);
	}
			
	/**
	 * Get associative array with tag attributes and their values and build tag attribute string.
	 *
	 * @param array $attributes
	 * @return string
	 */
	public static function build_attributes($attributes) {
		$_attributes = array();

		if (!empty($attributes)) {
			foreach ($attributes as $key => $value) {
				$_attributes[] = $key . '="' . esc_attr($value) . '"';
			}
		}

		return join(' ', $_attributes);
	}
}

endif;
