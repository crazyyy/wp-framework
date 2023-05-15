<?php
namespace AIOWPS\Firewall;

class Utility {

	/**
	 * Returns the directory of where the WordPress files are installed
	 * This differs from get_root_dir() when WordPress is setup in a subdirectory
	 *
	 * @return string
	 */
	public static function get_wordpress_dir() {

		if (Context::wordpress_safe()) {
			return wp_normalize_path(ABSPATH);
		}

		global $aiowps_firewall_data;

		return isset($aiowps_firewall_data['ABSPATH']) ? $aiowps_firewall_data['ABSPATH'] : '';
	}

	/**
	 * Returns the root directory of the site
	 * This may be different from where the WordPress files are installed if WordPress is setup in a subdirectory
	 *
	 * @return string|null
	 */
	public static function get_root_dir() {
		
		if (Context::wordpress_safe()) {
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

		if (empty($root)) $root = self::get_wordpress_dir();
		
		$wp_config_file = $root . 'wp-config.php';
		if (file_exists($wp_config_file)) {
			return $wp_config_file;
		} elseif (file_exists(dirname($root) . '/wp-config.php')) {
			return dirname($root) . '/wp-config.php';
		}
		return $wp_config_file;
	}

}
