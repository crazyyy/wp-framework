<?php
namespace AIOWPS\Firewall;

class Utility {

	/**
	 * Returns the root directory of the WordPress installation
	 *
	 * @return string|null
	 */
	public static function get_root_dir() {
		// We're in a WordPress context if this class exists, so use the get_home_path() method
		if (class_exists('AIOWPSecurity_Utility_File')) {
			return \AIOWPSecurity_Utility_File::get_home_path();
		}

		// We're in the firewall context here, so get the root directory from the bootstrap file path
		$includes = get_included_files();

		foreach ($includes as $file) {
			if (preg_match('/aios-bootstrap\.php$/', $file)) {
				return self::normalize_path(dirname($file).'/');
			}
		}

		return null;
	}

	/**
	 * Normalizes the file path
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_normalize_path/
	 * @param string $path
	 * @return string
	 */
	public static function normalize_path($path) {
		// Standardize all paths to use '/'.
		$path = str_replace('\\', '/', $path);
	
		// Replace multiple slashes down to a singular, allowing for network shares having two slashes.
		$path = preg_replace('|(?<=.)/+|', '/', $path);
	
		// Windows paths should uppercase the drive letter.
		if (':' === substr($path, 1, 1)) {
			$path = ucfirst($path);
		}
	
		return $path;
	}

	/**
	 * Returns the path to wp-config.php
	 *
	 * @param string $root - Where to look for wp-config.php file
	 * @return string
	 */
	public static function get_wpconfig_path($root = '') {

		if (empty($root)) {
			$root = self::get_root_dir();
		}

		if (!is_dir($root)) throw new \Exception("Invalid root provided: {$root}");

		$wp_config_file = $root . 'wp-config.php';
		if (file_exists($wp_config_file)) {
			return $wp_config_file;
		} elseif (file_exists(dirname($root) . '/wp-config.php')) {
			return dirname($root) . '/wp-config.php';
		}
		return $wp_config_file;
	}

}
