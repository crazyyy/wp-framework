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
		$upload_dir = wp_upload_dir();
		$upload_base = trailingslashit($upload_dir['basedir']);
		if (!is_dir($upload_base . 'wpo/logs')) {
			wp_mkdir_p($upload_base . 'wpo/logs');
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
}

endif;
