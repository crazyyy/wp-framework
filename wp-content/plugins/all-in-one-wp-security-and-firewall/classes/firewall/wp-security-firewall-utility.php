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

	
	/**
	 * Recursive directory creation based on full path
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_mkdir_p/
	 * @param string $target
	 * @return bool
	 */
	public static function wp_mkdir_p($target) {
		$wrapper = null;
	
		// Strip the protocol.
		if (self::wp_is_stream($target)) {
			list($wrapper, $target) = explode('://', $target, 2);
		}
	
		// From php.net/mkdir user contributed notes.
		$target = str_replace('//', '/', $target);
	
		// Put the wrapper back on the target.
		if (null !== $wrapper) {
			$target = $wrapper . '://' . $target;
		}
	
		/*
		 * Safe mode fails with a trailing slash under certain PHP versions.
		 * Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
		 */
		$target = rtrim($target, '/');
		if (empty($target)) {
			$target = '/';
		}
	
		if (file_exists($target)) {
			return @is_dir($target);
		}
	
		// Do not allow path traversals.
		if (false !== strpos($target, '../') || false !== strpos($target, '..' . DIRECTORY_SEPARATOR)) {
			return false;
		}
	
		// We need to find the permissions of the parent folder that exists and inherit that.
		$target_parent = dirname($target);
		while ('.' !== $target_parent && ! is_dir($target_parent) && dirname($target_parent) !== $target_parent) {
			$target_parent = dirname($target_parent);
		}
	
		// Get the permission bits
		$stat = @stat($target_parent);
		if ($stat) {
			$dir_perms = $stat['mode'] & 0007777;
		} else {
			$dir_perms = 0777;
		}
	
		if (@mkdir($target, $dir_perms, true)) {
	
			/*
			 * If a umask is set that modifies $dir_perms, we'll have to re-set
			 * the $dir_perms correctly with chmod()
			 */
			if (($dir_perms & ~umask()) != $dir_perms) {
				$folder_parts = explode('/', substr($target, strlen($target_parent) + 1));
				for ($i = 1, $c = count($folder_parts); $i <= $c; $i++) {
					chmod($target_parent . '/' . implode('/', array_slice($folder_parts, 0, $i)), $dir_perms);
				}
			}
	
			return true;
		}
	
		return false;
	}
	

	/**
	 * Tests if a given path is a stream URL
	 *
	 * @see https://developer.wordpress.org/reference/functions/wp_is_stream/
	 * @param string $path
	 * @return bool
	 */
	public static function wp_is_stream($path) {
		$scheme_separator = strpos($path, '://');
	
		if (false === $scheme_separator) {
			// $path isn't a stream.
			return false;
		}
	
		$stream = substr($path, 0, $scheme_separator);
	
		return in_array($stream, stream_get_wrappers(), true);
	}


	/**
	 * Attempts to give us access to the $wpdb object from the firewall.
	 * This should only be used when you're sure WordPress will not be loading after the firewall.
	 *
	 * @return bool
	 */
	public static function attempt_to_access_wpdb() {
		
		// wpdb is already accessible
		if (isset($GLOBALS['wpdb'])) return true;

		$wp_path = self::get_wordpress_dir() . 'wp-load.php';
			
		clearstatcache();
		if (!file_exists($wp_path)) return false;

		define('SHORTINIT', true);
	
		$included = (bool) include $wp_path;
	
		global $wpdb;

		// If $wpdb is inaccessible by this point, it means loading wp-settings didn't complete.
		// So we have to manually include the wp-config (which includes wp-settings) for it to complete.
		if (empty($wpdb) && $included) include self::get_wpconfig_path();
		
		global $wpdb;

		return !empty($wpdb);
		
	}
}
