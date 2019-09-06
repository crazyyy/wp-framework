<?php
/**
 * Page caching functionality
 *
 * Acknowledgement: The page cache functionality was loosely based on the simple cache plugin - https://github.com/tlovett1/simple-cache
 */

if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * Base cache directory, everything else goes under here
 */
if (!defined('WPO_CACHE_DIR')) define('WPO_CACHE_DIR', untrailingslashit(WP_CONTENT_DIR).'/wpo-cache');

/**
 * Extensions directory.
 */
if (!defined('WPO_CACHE_EXT_DIR')) define('WPO_CACHE_EXT_DIR', dirname(__FILE__).'/extensions');

/**
 * Directory that stores config and related files
 */
if (!defined('WPO_CACHE_CONFIG_DIR')) define('WPO_CACHE_CONFIG_DIR', WPO_CACHE_DIR.'/config');

/**
 * Directory that stores the cache, including gzipped files and mobile specifc cache
 */
if (!defined('WPO_CACHE_FILES_DIR')) define('WPO_CACHE_FILES_DIR', untrailingslashit(WP_CONTENT_DIR).'/cache/wpo-cache');

if (!class_exists('WPO_Cache_Config')) require_once(dirname(__FILE__) . '/class-wpo-cache-config.php');
if (!class_exists('WPO_Cache_Rules')) require_once(dirname(__FILE__) . '/class-wpo-cache-rules.php');

if (!class_exists('WP_Optimize_Detect_Cache_Plugins')) require_once(dirname(__FILE__) . '/class-wpo-detect-cache-plugins.php');

if (!class_exists('WP_Optimize_Page_Cache_Preloader')) require_once(dirname(__FILE__) . '/class-wpo-cache-preloader.php');
if (!class_exists('WPO_Cache_Config')) require_once(dirname(__FILE__) . '/class-wpo-cache-config.php');
if (!class_exists('WPO_Cache_Rules')) require_once(dirname(__FILE__) . '/class-wpo-cache-rules.php');

if (!class_exists('Updraft_Abstract_Logger')) require_once(WPO_PLUGIN_MAIN_PATH.'/includes/class-updraft-abstract-logger.php');
if (!class_exists('Updraft_PHP_Logger')) require_once(WPO_PLUGIN_MAIN_PATH.'/includes/class-updraft-php-logger.php');

require_once dirname(__FILE__) . '/file-based-page-cache-functions.php';

wpo_cache_load_extensions();

if (!class_exists('WPO_Page_Cache')) :

class WPO_Page_Cache {

	/**
	 * Cache config object
	 *
	 * @var mixed
	 */
	public $config;

	/**
	 * Logger for this class
	 *
	 * @var mixed
	 */
	public $logger;

	/**
	 * Instance of this class
	 *
	 * @var mixed
	 */
	public static $instance;


	/**
	 * Set everything up here
	 */
	public function __construct() {
		$this->config = WPO_Cache_Config::instance();
		$this->rules  = WPO_Cache_Rules::instance();
		$this->logger = new Updraft_PHP_Logger();

		add_action('activate_plugin', array($this, 'activate_deactivate_plugin'));
		add_action('deactivate_plugin', array($this, 'activate_deactivate_plugin'));

		/**
		 * Regenerate config file on cache flush.
		 */
		add_action('wpo_cache_flush', array($this, 'update_cache_config'));
		add_action('wpo_cache_flush', array($this, 'delete_cache_size_information'));
	}

	/**
	 * Do required actions on activate/deactivate any plugin.
	 */
	public function activate_deactivate_plugin() {
		$this->update_cache_config();

		/**
		 * Filters whether activating / deactivating a plugin will purge the cache.
		 */
		if (apply_filters('wpo_purge_page_cache_on_activate_deactivate_plugin', true)) {
			$this->purge();
		}
	}

	/**
	 * Enables page cache
	 *
	 * @param bool $force_enable - Force regenerating everything. E.g. we want to do that when saving the settings
	 *
	 * @return WP_Error|bool - true on success, error otherwise
	 */
	public function enable($force_enable = false) {
		static $already_ran_enable = false;

		if ($already_ran_enable) return $already_ran_enable;

		$folders_created = $this->create_folders();
		if (is_wp_error($folders_created)) {
			$already_ran_enable = $folders_created;
			return $already_ran_enable;
		}

		// if WPO_ADVANCED_CACHE isn't set, or environment doesn't contain the right constant, force regeneration
		if (!defined('WPO_ADVANCED_CACHE') || !defined('WP_CACHE')) {
			$force_enable = true;
		}

		if (!$force_enable) {
			$already_ran_enable = true;
			return true;
		}

		if (!$this->write_advanced_cache()) {
			$already_ran_enable = new WP_Error("write_advanced_cache", "The request to write the advanced-cache.php file failed. You might not have the permission to write inside wp-content.");
			return $already_ran_enable;
		}

		if (!$this->write_wp_config(true)) {
			$already_ran_enable = new WP_Error("write_wp_config", "Could not toggle the WP_CACHE constant in wp-config.php. Check your permissions.");
			return $already_ran_enable;
		}

		if (!$this->verify_cache()) {
			$already_ran_enable = new WP_Error("verify_cache", "Could not verify if cache was enabled. Turn on logging to find the reason.");
			return $already_ran_enable;
		}

		$already_ran_enable = true;

		return true;
	}


	/**
	 * Disables page cache
	 *
	 * @return bool - true on success, false otherwise
	 */
	public function disable() {
		$ret = true;

		$advanced_cache_file = untrailingslashit(WP_CONTENT_DIR) . '/advanced-cache.php';
		
		// We only touch advanched-cache.php and wp-config.php if it appears that we were in control of advanced-cache.php
		if (!file_exists($advanced_cache_file) || false !== strpos(file_get_contents($advanced_cache_file), 'WP-Optimize advanced-cache.php')) {

			// First try to remove (so that it doesn't look to any other plugin like the file is already 'claimed')
			if (file_exists($advanced_cache_file) && (!unlink($advanced_cache_file) && false === file_put_contents($advanced_cache_file, "<?php\n// WP-Optimize: page cache disabled"))) {
				$this->log("The request to the filesystem to remove or empty advanced-cache.php failed");
				$ret = false;
			}

			// N.B. The only use of WP_CACHE in WP core is to include('advanced-cache.php') (and run a function if it's then defined); so, if the decision to leave it enable is, for some unexpected reason, technically incorrect, it still can't cause a problem.
			if (!$this->write_wp_config(false)) {
				$this->log("Could not toggle the WP_CACHE constant in wp-config.php");
				$ret = false;
			}
		}

		// Delete cache to avoid stale cache on next activation
		$this->purge();

		return $ret;
	}


	/**
	 * Purges the cache
	 *
	 * @return bool - true on success, false otherwise
	 */
	public function purge() {

		if (!self::delete(WPO_CACHE_FILES_DIR)) {
			$this->log("The request to the filesystem to delete the cache failed");
			return false;
		}

		/**
		 * Fires after purging the cache
		 */
		do_action('wpo_cache_flush');

		return true;
	}

	/**
	 * Purges the cache
	 *
	 * @return bool - true on success, false otherwise
	 */
	public function clean_up() {

		$this->disable();

		if (!self::delete(WPO_CACHE_DIR, true)) {
			$this->log("The request to the filesystem to clean up the cache failed");
			return false;
		}

		return true;
	}

	/**
	 * Check if cache is enabled and working
	 *
	 * @return bool - true on success, false otherwise
	 */
	public function is_enabled() {

		if (!defined('WP_CACHE') || !WP_CACHE) {
			return false;
		}

		if (!defined('WPO_ADVANCED_CACHE') || !WPO_ADVANCED_CACHE) {
			return false;
		}

		if (!$this->config->get_option('enable_page_caching', false)) {
			return false;
		}

		return true;
	}

	/**
	 * Create the folder structure needed for cache to work
	 *
	 * @return bool - true on success, false otherwise
	 */
	private function create_folders() {

		if (!is_dir(WPO_CACHE_DIR) && !wp_mkdir_p(WPO_CACHE_DIR)) {
			return new WP_Error('create_folders', sprintf(__('The request to the filesystem failed: unable to create directory %s. Please check your file permissions.'), str_ireplace(ABSPATH, '', WPO_CACHE_DIR)));
		}

		if (!is_dir(WPO_CACHE_CONFIG_DIR) && !wp_mkdir_p(WPO_CACHE_CONFIG_DIR)) {
			return new WP_Error('create_folders', sprintf(__('The request to the filesystem failed: unable to create directory %s. Please check your file permissions.'), str_ireplace(ABSPATH, '', WPO_CACHE_CONFIG_DIR)));
		}
		
		if (!is_dir(WPO_CACHE_FILES_DIR) && !wp_mkdir_p(WPO_CACHE_FILES_DIR)) {
			return new WP_Error('create_folders', sprintf(__('The request to the filesystem failed: unable to create directory %s. Please check your file permissions.'), str_ireplace(ABSPATH, '', WPO_CACHE_FILES_DIR)));
		}

		return true;
	}

	/**
	 * Writes advanced-cache.php
	 *
	 * @return bool
	 */
	private function write_advanced_cache() {

		$url = parse_url(network_site_url());
	
		if (isset($url['port']) && '' != $url['port'] && 80 != $url['port']) {
			$config_file_basename = 'config-'.$url['host'].'-port'.$url['port'].'.php';
		} else {
			$config_file_basename = 'config-'.$url['host'].'.php';
		}

		$file = untrailingslashit(WP_CONTENT_DIR) . '/advanced-cache.php';
		$contents = '';
		$cache_file_basename = untrailingslashit(plugin_dir_path(__FILE__));
		$plugin_basename = basename(WPO_PLUGIN_MAIN_PATH);
		$cache_path = '/wpo-cache';
		$cache_files_path = '/cache/wpo-cache';
		$cache_extensions_path = WPO_CACHE_EXT_DIR;
		$wpo_version = WPO_VERSION;

		// CS does not like heredoc
		// @codingStandardsIgnoreStart
		$contents = <<<EOF
<?php

if (!defined('ABSPATH')) die('No direct access allowed');

// WP-Optimize advanced-cache.php (written by version: $wpo_version) (do not change this line, it is used for correctness checks)

if (!defined('WPO_ADVANCED_CACHE')) define('WPO_ADVANCED_CACHE', true);

if (is_admin()) { return; }

\$possible_plugin_locations = array(
	defined('WP_PLUGIN_DIR') ? WP_PLUGIN_DIR.'/$plugin_basename/cache' : false,
	defined('WP_CONTENT_DIR') ? WP_CONTENT_DIR.'/plugins/$plugin_basename/cache' : false,
	dirname(__FILE__).'/plugins/$plugin_basename/cache',
	'$cache_file_basename',
);

\$plugin_location = false;

foreach (\$possible_plugin_locations as \$possible_location) {
	if (false !== \$possible_location && @file_exists(\$possible_location.'/file-based-page-cache.php')) {
		\$plugin_location = \$possible_location;
		break;
	}
}

if (!defined('WPO_CACHE_DIR')) define('WPO_CACHE_DIR', WP_CONTENT_DIR.'$cache_path');
if (!defined('WPO_CACHE_CONFIG_DIR')) define('WPO_CACHE_CONFIG_DIR', WPO_CACHE_DIR.'/config');
if (!defined('WPO_CACHE_FILES_DIR')) define('WPO_CACHE_FILES_DIR', WP_CONTENT_DIR.'$cache_files_path');
if (false !== \$plugin_location) {
	if (!defined('WPO_CACHE_EXT_DIR')) define('WPO_CACHE_EXT_DIR', \$plugin_location.'/extensions');
} else {
	if (!defined('WPO_CACHE_EXT_DIR')) define('WPO_CACHE_EXT_DIR', '$cache_extensions_path');
}

if (!@file_exists(WPO_CACHE_CONFIG_DIR . '/$config_file_basename')) { return; }

\$GLOBALS['wpo_cache_config'] = json_decode(file_get_contents(WPO_CACHE_CONFIG_DIR . '/$config_file_basename'), true);

if (empty(\$GLOBALS['wpo_cache_config']) || empty(\$GLOBALS['wpo_cache_config']['enable_page_caching'])) { return; }

if (false !== \$plugin_location) { include_once(\$plugin_location.'/file-based-page-cache.php'); }

EOF;
		// @codingStandardsIgnoreEnd
		if (!file_put_contents($file, $contents)) {
			return false;
		}

		return true;
	}

	/**
	 * Set WP_CACHE on or off in wp-config.php
	 *
	 * @param  boolean $status value of WP_CACHE.
	 * @return boolean true if the value was set, false otherwise
	 */
	private function write_wp_config($status = true) {

		if (defined('WP_CACHE') && WP_CACHE === $status) {
			return true;
		}

		$config_path = $this->_get_wp_config();

		// Couldn't find wp-config.php.
		if (!$config_path) {
			return false;
		}

		$config_file_string = file_get_contents($config_path);

		// Config file is empty. Maybe couldn't read it?
		if (empty($config_file_string)) {
			return false;
		}

		$config_file = preg_split("#(\n|\r\n)#", $config_file_string);
		$line_key    = false;

		foreach ($config_file as $key => $line) {
			if (!preg_match('/^\s*define\(\s*(\'|")([A-Z_]+)(\'|")(.*)/i', $line, $match)) {
				continue;
			}

			if ('WP_CACHE' === $match[2]) {
				$line_key = $key;
			}
		}

		if (false !== $line_key) {
			unset($config_file[$line_key]);
		}


		if ($status) {
			array_shift($config_file);
			array_unshift($config_file, '<?php', "define('WP_CACHE', true); // WP-Optimize Cache");
		}

		foreach ($config_file as $key => $line) {
			if ('' === $line) {
				unset($config_file[$key]);
			}
		}
		if (!file_put_contents($config_path, implode(PHP_EOL, $config_file))) {
			return false;
		}

		return true;
	}

	/**
	 * Verify we can write to the file system
	 *
	 * @return boolean
	 */
	private function verify_cache() {
		if (function_exists('clearstatcache')) {
			clearstatcache();
		}

		// First check wp-config.php.
		if (!$this->_get_wp_config() && !is_writable($this->_get_wp_config())) {
			$this->log("Unable to write to or find wp-config.php; please check file/folder permissions");
			return false;
		}

		$advanced_cache_file = untrailingslashit(WP_CONTENT_DIR).'/advanced-cache.php';
		
		// Now check wp-content. We need to be able to create files of the same user as this file.
		if ((!file_exists($advanced_cache_file) || false === strpos(file_get_contents($advanced_cache_file), 'WP-Optimize advanced-cache.php')) && !is_writable($advanced_cache_file) && !is_writable(untrailingslashit(WP_CONTENT_DIR))) {
			$this->log("Unable to write the file advanced-cache.php inside the wp-content folder; please check file/folder permissions");
			return false;
		}

		// If the cache and config directories exist, make sure they're writeable.
		if (file_exists(WPO_CACHE_DIR)) {
			if (!is_writable(WPO_CACHE_DIR)) {
				$this->log("Unable to write inside the cache folder; please check file/folder permissions");
				return false;
			}
		}

		if (file_exists(WPO_CACHE_FILES_DIR)) {
			if (!is_writable(WPO_CACHE_FILES_DIR)) {
				$this->log("Unable to write inside the cache files folder; please check file/folder permissions");
				return false;
			}
		}

		if (file_exists(WPO_CACHE_CONFIG_DIR)) {
			if (!is_writable(WPO_CACHE_CONFIG_DIR)) {
				$this->log("Unable to write inside the cache configuration folder; please check file/folder permissions");
				return false;
			}
		}

		return true;
	}

	/**
	 * Update cache config. Used to support 3d party plugins.
	 */
	public function update_cache_config() {
		// get current cache settings.
		$current_config = $this->config->get();
		// and call update to change if need cookies and query variable names.
		$this->config->update($current_config, true);
	}

	/**
	 * Delete information about cache size.
	 */
	public function delete_cache_size_information() {
		delete_transient('wpo_get_cache_size');
	}

	/**
	 * Get current cache size.
	 *
	 * @return array
	 */
	public function get_cache_size() {
		$cache_size = get_transient('wpo_get_cache_size');

		if (!empty($cache_size)) return $cache_size;

		$infos = $this->get_dir_infos(WPO_CACHE_FILES_DIR);
		$cache_size = array(
			'size' => $infos['size'],
			'file_count' => $infos['file_count']
		);

		set_transient('wpo_get_cache_size', $cache_size);

		return $cache_size;
	}

	/**
	 * Fetch directory informations.
	 *
	 * @param string $dir
	 * @return array
	 */
	private function get_dir_infos($dir) {
		$dir_size = 0;
		$file_count = 0;

		if (!is_dir($dir)) {
			return array('size' => 0, 'file_count' => 0);
		}

		$files = scandir($dir);

		foreach ($files as $file) {
			if ('.' == $file || '..' == $file) continue;

			$current_file = $dir.'/'.$file;

			if (is_dir($current_file)) {
				$sub_dir_infos = $this->get_dir_infos($current_file);
				$dir_size += $sub_dir_infos['size'];
				$file_count += $sub_dir_infos['file_count'];
			} elseif (is_file($current_file)) {
				$dir_size += filesize($current_file);
				$file_count ++;
			}
		}

		return array('size' => $dir_size, 'file_count' => $file_count);
	}

	/**
	 * Returns the path to wp-config
	 *
	 * @return string|boolean wp-config.php path.
	 */
	private function _get_wp_config() {

		$config_path = false;

		foreach (get_included_files() as $filename) {
			if (preg_match('/(\\\\|\/)wp-config\.php$/i', $filename)) {
				$config_path = $filename;
				break;
			}
		}

		return $config_path;
	}

	/**
	 * Util to delete folders and/or files
	 *
	 * @param string $src
	 * @return boolean
	 */
	public static function delete($src) {

		return wpo_delete_files($src);

	}

	/**
	 * Delete cached files for single post.
	 *
	 * @param integer $post_id The post ID
	 */
	public static function delete_single_post_cache($post_id) {
	
		if (!defined('WPO_CACHE_FILES_DIR')) return;
	
		$path = trailingslashit(WPO_CACHE_FILES_DIR) . trailingslashit(wpo_get_url_path(get_permalink($post_id)));

		wpo_delete_files($path, false);
	}

	/**
	 * Delete cached home page files.
	 */
	public static function delete_homepage_cache() {
	
		if (!defined('WPO_CACHE_FILES_DIR')) return;
	
		$path = trailingslashit(WPO_CACHE_FILES_DIR) . trailingslashit(wpo_get_url_path(get_home_url(get_current_blog_id())));

		wpo_delete_files($path, false);
	}

	/**
	 * Logs error messages
	 *
	 * @param  string $message
	 * @return null|void
	 */
	public function log($message) {
		if (isset($this->logger)) {
			$this->logger->log('ERROR', $message);
		} else {
			error_log($message);
		}
	}

	/**
	 * Returns an instance of the current class, creates one if it doesn't exist
	 *
	 * @return object
	 */
	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

endif;
