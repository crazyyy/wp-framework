<?php

/**
 * Abovethefold optimization plugin module functions and hooks.
 *
 * This class provides the functionality for optimization plugin module functions and hooks.
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_Plugins {

	/**
	 * Above the fold controller
	 */
	public $CTRL;

	/**
	 * Active plugins
	 */
	public $active_plugins = array();

	/**
	 * Active plugin modules
	 */
	public $active_modules = array();

	// return false reference
	public $falseReference = false;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( &$CTRL ) {

		$this->CTRL =& $CTRL;

		$this->active_plugins = (array) get_option( 'active_plugins', array() );

	}

	/**
	 * Hook to HTML buffer of full page cache plugin
	 */
	public function html_output_hook($optimization) {

		if ($this->CTRL->disabled) {
			return false; // above the fold optimization disabled for area / page
		}

		foreach ($this->active_modules as $module) {
			if ($module->active('html_output_buffer') && method_exists($module, 'html_output_hook')) {

				// apply first hook, ignore potential other / conflicting hooks
				// most of the times a website has just 1 full page cache hook
				// @todo verify compatibility issues between plugins
				if ($module->html_output_hook($optimization)) {
					return true; // activate output bufferon plugin hook
				}
			}
		}
	}

	/**
	 * Disable CSS minification in applicable plugins
	 */
	public function diable_css_minification() {
		foreach ($this->active_modules as $module) {
			$module->disable_css_minify();
		}
	}

	/**
	 * Clear full page cache
	 */
	public function clear_pagecache() {

		/**
		 * Clear full page cache from active plugin modules
		 */
		foreach ($this->active_modules as $module) {
			$module->clear_pagecache();
		}

		/**
		 * Other cache clear methods
		 */
		if (function_exists('w3tc_pgca	che_flush')) {
			w3tc_pgcache_flush();
		} else if (function_exists('wp_cache_clear_cache')) {
			wp_cache_clear_cache();
		}

	}

	/**
	 * Get plugin modules
	 */
	public function get_modules( ) {

		$dirs = array(
			plugin_dir_path( realpath(dirname( __FILE__ ) . '/') ) . 'modules/plugins/',
			get_stylesheet_directory() . '/abovethefold/plugins/'
		);

		$modules = array();

		foreach ($dirs as $dir) {

			if (!is_dir($dir)) {
				continue 1;
			}

			$files = scandir($dir);

			foreach ($files as $file) {

				if (is_file($dir . $file)
					&& substr($file,-7) === 'inc.php'
				) {
					$hash = md5($file);
					$modules[$hash] = $dir . $file;
				}
			}
		}

		$modules = array_values($modules);
		sort($modules);

		return $modules;

	}

	/**
	 * Load modules
	 */
	public function load_modules( ) {

		$modules = $this->get_modules( );

		$this->active_modules = array();

		foreach ($modules as $module_file) {
			$plugin_module =& $this->load_module( $module_file );
			if ($plugin_module && $plugin_module->active()) {
				$this->active_modules[] =& $plugin_module;
			}
		}

	}

	/**
	 * Check if plugin is active
	 */
	public function active( $plugin_name ) {

		if ( in_array( $plugin_name, $this->active_plugins ) ) {
			return true;
		}
		return false;

	}

	/**
	 * Load module
	 */
	public function &load_module( $module_file ) {

		if ( !file_exists($module_file) ) {
			return $this->falseReference;
		}

		/**
		 * Verify if module has a plugin name reference file
		 *
		 * To save memory with 100+ modules, modules have a separate file with the plugin reference to check if a module is active
		 */
		$active_txtfile = str_replace('.inc.php','.active.txt',$module_file);
		if (file_exists($active_txtfile)) {

			$plugin_name = file_get_contents($active_txtfile);
			if (!$this->active( $plugin_name )) {
				return $this->falseReference;
			}
		}

		$file = basename($module_file);

		// Verify data
		$classname = str_replace(array('.inc.php'),array(''),$file);
		$parts = explode('-',$classname);
		$classname = '';
		foreach ($parts as $part) {
			$classname .= ucfirst($part);
		}
		
		if (isset($this->modules[$classname])) {
			return $this->modules[$classname];
		}

		// requore plugin module class
		require_once($module_file);

		$classnameName = 'Abovethefold_OPP_' . $classname;
		if (!class_exists($classnameName)) {
			return $this->falseReference;
		}

		$this->modules[$classname] = new $classnameName( $this->CTRL );

		return $this->modules[$classname];

	}


}
