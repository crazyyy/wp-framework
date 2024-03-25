<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

class AIOWPSecurity_Config {

	public $configs;

	public static $_this;

	public function __construct() {
	}

	public function load_config() {
		$this->configs = get_option('aio_wp_security_configs');
	}

	public function get_value($key) {
		return isset($this->configs[$key]) ? $this->configs[$key] : '';
	}
	
	/**
	 * Gets for main site config value for a given $key.
	 *
	 * @param string $key
	 *
	 * @return string|array
	 */
	public function get_site_value($key) {
		if (is_multisite() && !is_main_site()) {
			$mainsite_aio_config = get_blog_option(get_main_site_id(), 'aio_wp_security_configs');
			return isset($mainsite_aio_config[$key]) ? $mainsite_aio_config[$key] : '';
		} else {
			return $this->get_value($key);
		}
	}

	/**
	 * Sets a given config $value for a given $key.
	 *
	 * @param string  $key
	 * @param mixed   $value
	 * @param boolean $save_config - Whether or not to also save the $configs array to the database.
	 *
	 * @return boolean
	 */
	public function set_value($key, $value, $save_config = false) {
		$this->configs[$key] = $value;

		if ($save_config) {
			return $this->save_config();
		} else {
			return true;
		}
	}

	public function add_value($key, $value) {
		if (!is_array($this->configs)) {
			$this->configs = array();
		}

		if (array_key_exists($key, $this->configs)) {
			//Don't update the value for this key
		} else {//It is safe to update the value for this key
			$this->configs[$key] = $value;
		}
	}

	/**
	 * Save configuration that are set.
	 *
	 * @return boolean True on save config, Otherwise false.
	 */
	public function save_config() {
		return update_option('aio_wp_security_configs', $this->configs);
	}

	/**
	 * Remove key element from config.
	 *
	 * @param String $key config key
	 *
	 * @return boolean True if removed, otherwise false.
	 */
	public function delete_value($key) {
		if (!is_array($this->configs)) {
			$this->configs = array();
		}

		if (array_key_exists($key, $this->configs)) {
			unset($this->configs[$key]);
			if (!isset($this->configs[$key])) {
				return true;
			}
		}

		return false;
	}

	public static function get_instance() {
		if (empty(self::$_this)) {
			self::$_this = new AIOWPSecurity_Config();
			self::$_this->load_config();
			return self::$_this;
		}
		return self::$_this;
	}
}
