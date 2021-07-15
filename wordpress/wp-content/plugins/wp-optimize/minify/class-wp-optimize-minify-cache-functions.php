<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!defined('WP_OPTIMIZE_MINIFY_DIR')) {
	die('No direct access.');
}

if (!class_exists('WP_Optimize_Minify_Functions')) {
	include WP_OPTIMIZE_MINIFY_DIR.'/class-wp-optimize-minify-functions.php';
}

if (!function_exists('wpo_delete_files')) {
	include WPO_PLUGIN_MAIN_PATH.'/cache/file-based-page-cache-functions.php';
}

class WP_Optimize_Minify_Cache_Functions {

	/**
	 * Fix the permission bits on generated files
	 *
	 * @param String $file - full path to a file
	 */
	public static function fix_permission_bits($file) {
		if (function_exists('stat')) {
			if ($stat = stat(dirname($file))) {
				$perms = $stat['mode'] & 0007777;
				chmod($file, $perms);
				clearstatcache();
				return true;
			}
		}
				
		// Get permissions from parent directory
		$perms = 0777;
		if (function_exists('stat')) {
			if ($stat = stat(dirname($file))) {
				$perms = $stat['mode'] & 0007777;
			}
		}
				
		if (file_exists($file)) {
			if (($perms & ~umask() != $perms)) {
				$folder_parts = explode('/', substr($file, strlen(dirname($file)) + 1));
				for ($i = 1, $c = count($folder_parts); $i <= $c; $i++) {
					chmod(dirname($file) . '/' . implode('/', array_slice($folder_parts, 0, $i)), $perms);
				}
			}
		}
		return true;
	}

	/**
	 * Get cache directories and urls
	 *
	 * @return Array
	 */
	public static function cache_path() {
		// get latest time stamp
		$cache_time = wp_optimize_minify_config()->get('last-cache-update');

		$cache_dir_url = WPO_CACHE_MIN_FILES_URL . "/$cache_time/assets";
		$tmp_dir      = WPO_CACHE_MIN_FILES_DIR . "/tmp";
		$header_dir   = WPO_CACHE_MIN_FILES_DIR . "/$cache_time/header";
		$cache_dir    = WPO_CACHE_MIN_FILES_DIR . "/$cache_time/assets";

		// Create directories
		$dirs = array($cache_dir, $tmp_dir, $header_dir);
		foreach ($dirs as $target) {
			if (!is_dir($target) && !wp_mkdir_p($target)) {
				error_log('WP_Optimize_Minify_Cache_Functions::cache_path(): The folder "'.$target.'" could not be created.');
			}
		}
		return array(
			'tmpdir' => $tmp_dir,
			'cachedir' => $cache_dir,
			'cachedirurl' => $cache_dir_url,
			'headerdir' => $header_dir
		);
	}

	/**
	 * Increment file names
	 */
	public static function cache_increment() {
		$stamp = time();
		wp_optimize_minify_config()->update(array(
			'last-cache-update' => $stamp
		));
		return $stamp;
	}

	/**
	 * Will delete temporary intermediate stuff but leave final css/js alone for compatibility
	 *
	 * @return Array
	 */
	public static function purge_temp_files() {
		// get cache directories and urls
		$cache_path = self::cache_path();
		$tmp_dir = $cache_path['tmpdir'];
		$header_dir = $cache_path['headerdir'];

		// delete temporary directories only
		if (is_dir($tmp_dir)) {
			wpo_delete_files($tmp_dir, true);
		}
		if (is_dir($header_dir)) {
			wpo_delete_files($header_dir, true);
		}
		
		/**
		 * Action triggered after purging temporary files
		 */
		do_action('wpo_min_after_purge_temp_files');
		return array(
			'tmpdir' => $tmp_dir,
			'headerdir' => $header_dir,
		);
	}

	/**
	 * Purge supported hosting and plugins
	 *
	 * @return string
	 */
	public static function purge_others() {
		/**
		 * Action triggered before purging other plugins cache
		 */
		do_action('wpo_min_before_purge_others');

		// WordPress default cache
		if (function_exists('wp_cache_flush')) {
			wp_cache_flush();
		}

		// Purge WP-Optimize
		WP_Optimize()->get_page_cache()->purge();

		// Purge all W3 Total Cache
		if (function_exists('w3tc_pgcache_flush')) {
			w3tc_pgcache_flush();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>W3 Total Cache</strong>');
		}

		// Purge WP Super Cache
		if (function_exists('wp_cache_clear_cache')) {
			wp_cache_clear_cache();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>WP Super Cache</strong>');
		}

		// Purge WP Rocket
		if (function_exists('rocket_clean_domain')) {
			rocket_clean_domain();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>WP Rocket</strong>');
		}

		// Purge Cachify
		if (function_exists('cachify_flush_cache')) {
			cachify_flush_cache();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Cachify</strong>');
		}

		// Purge Comet Cache
		if (is_callable(array('comet_cache', 'clear'))) {
			comet_cache::clear();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Comet Cache</strong>');
		}

		// Purge Zen Cache
		if (is_callable(array('zencache', 'clear'))) {
			zencache::clear();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Zen Cache</strong>');
		}

		// Purge LiteSpeed Cache
		if (is_callable(array('LiteSpeed_Cache_Tags', 'add_purge_tag'))) {
			LiteSpeed_Cache_Tags::add_purge_tag('*');
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>LiteSpeed Cache</strong>');
		}

		// Purge SG Optimizer
		if (function_exists('sg_cachepress_purge_cache')) {
			sg_cachepress_purge_cache();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>SG Optimizer</strong>');
		}

		// Purge Hyper Cache
		if (class_exists('HyperCache')) {
			do_action('autoptimize_action_cachepurged');
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>HyperCache</strong>');
		}

		// Purge Godaddy Managed WordPress Hosting (Varnish + APC)
		if (class_exists('WPaaS\Plugin')) {
			self::godaddy_request('BAN');
			return sprintf(__('A cache purge request has been sent to %s. Please note that it may not work 100% of the time, due to cache rate limiting by your host!', 'wp-optimize'), '<strong>Go Daddy Varnish</strong>');
		}

		// purge cache enabler
		if (has_action('ce_clear_cache')) {
			do_action('ce_clear_cache');
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Cache Enabler</strong>');
		}

		// Purge WP Engine
		if (class_exists("WpeCommon")) {
			if (method_exists('WpeCommon', 'purge_memcached')) {
				WpeCommon::purge_memcached();
			}
			if (method_exists('WpeCommon', 'clear_maxcdn_cache')) {
				WpeCommon::clear_maxcdn_cache();
			}
			if (method_exists('WpeCommon', 'purge_varnish_cache')) {
				WpeCommon::purge_varnish_cache();
			}

			if (method_exists('WpeCommon', 'purge_memcached') || method_exists('WpeCommon', 'clear_maxcdn_cache') || method_exists('WpeCommon', 'purge_varnish_cache')) {
					return sprintf(__('A cache purge request has been sent to %s. Please note that it may not work 100% of the time, due to cache rate limiting by your host!', 'wp-optimize'), '<strong>WP Engine</strong>');
			}
		}

		// add breeze cache purge support
		if (is_callable(array('Breeze_PurgeCache', 'breeze_cache_flush'))) {
			Breeze_PurgeCache::breeze_cache_flush();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Breeze</strong>');
		}

		// other lesser plugins

		// swift
		if (is_callable(array('Swift_Performance_Cache', 'clear_all_cache'))) {
			Swift_Performance_Cache::clear_all_cache();
			return sprintf(__('All caches from %s have also been purged.', 'wp-optimize'), '<strong>Swift Performance</strong>');
		}

		/**
		 * Action triggered when purging other plugins cache, and nothing was triggered
		 */
		do_action('wpo_min_after_purge_others');

	}

	/**
	 * Purge all public files on uninstallation
	 * This will break cached pages that ref minified JS/CSS
	 *
	 * @return Boolean
	 */
	public static function purge() {
		if (is_dir(WPO_CACHE_MIN_FILES_DIR)) {
			wpo_delete_files(WPO_CACHE_MIN_FILES_DIR, true);
		}
		return true;
	}

	/**
	 * Purge cache files older than 30 days
	 *
	 * @return array
	 */
	public static function purge_old() {
		if (!class_exists('WP_Optimize_Minify_Config')) {
			include_once WPO_PLUGIN_MAIN_PATH . '/minify/class-wp-optimize-minify-config.php';
		}
		$cache_time = wp_optimize_minify_config()->get('last-cache-update');

		/**
		 * Minify cache lifespan
		 *
		 * @param int The minify cache expiry timestamp
		 */
		$expires = apply_filters('wp_optimize_minify_cache_expiry_time', time() - 86400 * 30);
		$log = array();

		// get all directories that are a direct child of current directory
		if (is_dir(WPO_CACHE_MIN_FILES_DIR) && is_writable(dirname(WPO_CACHE_MIN_FILES_DIR))) {
			if ($handle = opendir(WPO_CACHE_MIN_FILES_DIR)) {
				while (false !== ($d = readdir($handle))) {
					if (strcmp($d, '.')==0 || strcmp($d, '..')==0) {
						continue;
					}
					$log[] = "checking if cache has expired - $d";
					if ($d != $cache_time && (is_numeric($d) && $d <= $expires)) {
						$dir = WPO_CACHE_MIN_FILES_DIR.'/'.$d;
						if (is_dir($dir)) {
							$log[] = "deleting cache in $dir";
							wpo_delete_files($dir, true);
							rmdir($dir);
						}
					}
				}
				closedir($handle);
			}
		}
		return $log;
	}

	/**
	 * Get transients from the disk
	 *
	 * @return String|Boolean
	 */
	public static function get_transient($key) {
		$cache_path = self::cache_path();
		$tmp_dir = $cache_path['tmpdir'];
		$f = $tmp_dir.'/'.$key.'.transient';
		clearstatcache();
		if (file_exists($f)) {
			return file_get_contents($f);
		} else {
			return false;
		}
	}

	/**
	 * Set cache on disk
	 *
	 * @param String $key
	 * @param Mixed  $code
	 *
	 * @return Boolean
	 */
	public static function set_transient($key, $code) {
		if (is_null($code) || empty($code)) {
			return false;
		}
		$cache_path = self::cache_path();
		$tmp_dir = $cache_path['tmpdir'];
		$f = $tmp_dir.'/'.$key.'.transient';
		file_put_contents($f, $code);
		self::fix_permission_bits($f);
		return true;
	}

	/**
	 * Get the cache size and count
	 *
	 * @return String
	 */
	public static function get_cachestats() {
		clearstatcache();
		if (is_dir(WPO_CACHE_MIN_FILES_DIR)) {
			$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(WPO_CACHE_MIN_FILES_DIR, FilesystemIterator::SKIP_DOTS)); // phpcs:ignore PHPCompatibility.Classes.NewClasses.filesystemiteratorFound
			$size = 0;
			foreach ($dir as $file) {
				$size += $file->getSize();
			}
			return self::format_filesize($size);
		} else {
			return sprintf(__('Error: %s is not a directory!', 'wp-optimize'), WPO_CACHE_MIN_FILES_DIR);
		}
	}

	/**
	 * Return size in human format
	 *
	 * @param integer $bytes
	 * @param integer $decimals
	 *
	 * @return string
	 */
	public static function format_filesize($bytes, $decimals = 2) {
		$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' );
		for ($i = 0; ($bytes / 1024) > 0.9; $i++, $bytes /= 1024) {
		}
		return sprintf("%1.{$decimals}f %s", round($bytes, $decimals), $units[$i]);
	}

	/**
	 * Purge GoDaddy Managed WordPress Hosting (Varnish)
	 *
	 * Source: https://github.com/wp-media/wp-rocket/blob/master/inc/3rd-party/hosting/godaddy.php
	 *
	 * @param String      $method
	 * @param String|Null $url
	 */
	public static function godaddy_request($method, $url = null) {
		$url  = empty($url) ? home_url() : $url;
		$host = parse_url($url, PHP_URL_HOST);
		$url  = set_url_scheme(str_replace($host, WPaas\Plugin::vip(), $url), 'http'); // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs.t_ns_separatorFound
		wp_cache_flush();
		update_option('gd_system_last_cache_flush', time()); // purge apc
		wp_remote_request(esc_url_raw($url), array('method' => $method, 'blocking' => false, 'headers' => array('Host' => $host)));
	}

	/**
	 * List all cache files
	 *
	 * @param integer $stamp     A timestamp
	 * @param boolean $use_cache If true, do not use transient value
	 * @return array
	 */
	public static function get_cached_files($stamp = 0, $use_cache = true) {
		if ($use_cache && $files = get_transient('wpo_minify_get_cached_files')) {
			return $files;
		}
		$cache_path = self::cache_path();
		$cache_dir = $cache_path['cachedir'];
		$size = self::get_cachestats();
		$o = wp_optimize_minify_config()->get();
		$cache_time = (0 == $o['last-cache-update']) ? __('Never.', 'wp-optimize') : self::format_date_time($o['last-cache-update']);
		$return = array(
			'js' => array(),
			'css' => array(),
			'stamp' => $stamp,
			'cachesize' => $size,
			'cacheTime' => $cache_time,
			'cachePath' => $cache_path['cachedir']
		);
		
		// Inspect directory with opendir, since glob might not be available in some systems
		clearstatcache();
		if ($handle = opendir($cache_dir.'/')) {
			while (false !== ($file = readdir($handle))) {
				$file = $cache_dir.'/'.$file;
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				if (in_array($ext, array('js', 'css'))) {
					$log = '';
					if (file_exists($file.'.txt')) {
						$log = file_get_contents($file.'.txt');
					}
					$min_css = substr($file, 0, -4).'.min.css';
					$minjs = substr($file, 0, -3).'.min.js';
					$file_name = basename($file);
					if ('css' == $ext && file_exists($min_css)) {
						$file_name = basename($min_css);
					}
					if ('js' == $ext && file_exists($minjs)) {
						$file_name = basename($minjs);
					}
					$file_size = WP_Optimize_Minify_Functions::format_filesize(filesize($file));
					$uid = hash('adler32', $file_name);
					array_push($return[$ext], array('uid' => $uid, 'filename' => $file_name, 'log' => $log, 'fsize' => $file_size));
				}
			}
			closedir($handle);
		}
		set_transient('wpo_minify_get_cached_files', $return, DAY_IN_SECONDS);
		return $return;
	}

	/**
	 * Format a timestamp using WP's date_format and time_format
	 *
	 * @param integer $timestamp - The timestamp
	 * @return string
	 */
	public static function format_date_time($timestamp) {
		return date(get_option('date_format').' @ '.get_option('time_format'), $timestamp);
	}
}
