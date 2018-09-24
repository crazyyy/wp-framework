<?php

/**
 * Abovethefold Lazy Script Loading functions and hooks.
 *
 * This class provides the functionality for lazy script loading functions and hooks.
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_LazyScripts {

	/**
	 * Above the fold controller
	 */
	public $CTRL;

	/**
	 * Initialize the class and set its properties
	 */
	public function __construct( &$CTRL ) {

		$this->CTRL =& $CTRL;

		if ($this->CTRL->disabled) {
			return; // above the fold optimization disabled for area / page
		}

		/**
		 * Lazy loading of scripts enabled
		 */
		if (isset($this->CTRL->options['lazyscripts_enabled']) && $this->CTRL->options['lazyscripts_enabled']) {

			// enqueue jquery Lazy XT widget module
			$this->CTRL->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_lazyxt', 10);
	
		}

	}

	/**
	 * Enqueue jQuery Lazy XT widget extension
	 */
	public function enqueue_lazyxt() {
		global $a3_lazy_load_global_settings;

		// load in footer?
		$in_footer = false;

		// jQuery Lazy XT libary loaded?
		$lazyxt_loaded = false;

		// dependencies
		$lazyxt_script_dependencies = array('jquery');

		/**
		 * WordPress a3 Lazy Load plugin is enabled
		 *
		 * @link https://wordpress.org/plugins/a3-lazy-load/
		 * @version  1.7.1
		 */
		if (defined('A3_LAZY_VERSION') && isset($a3_lazy_load_global_settings) && $a3_lazy_load_global_settings['a3l_apply_lazyloadxt']) {

			$in_footer = true;

			$a3l_effect = $a3_lazy_load_global_settings['a3l_effect'];

			$theme_loader_function = $a3_lazy_load_global_settings['a3l_theme_loader'];

			if ( $theme_loader_function == 'wp_head' ) {
				$in_footer = false;
			}

			// is libary loaded?
			$lazyxt_loaded = wp_script_is( 'jquery-lazyloadxt' );
			if ($lazyxt_loaded) {
				$lazyxt_script_dependencies[] = 'jquery-lazyloadxt';
			}
		} else if (class_exists('LazyLoadXT')) {

			/**
			 * WordPress Lazy Load XT plugin
			 *
			 * @link https://wordpress.org/plugins/lazy-load-xt/
			 * @version 0.5.3
			 */
			
			// is libary loaded?
			$lazyxt_loaded = wp_script_is( 'lazy-load-xt-script' );
			if ($lazyxt_loaded) {
				$lazyxt_script_dependencies[] = 'lazy-load-xt-script';
			}
		} else {

			// try common name
			$lazyxt_loaded = wp_script_is( 'jquery-lazyloadxt' );
			if ($lazyxt_loaded) {
				$lazyxt_script_dependencies[] = 'jquery-lazyloadxt';
			}
		}

		/**
		 * Lazy Load XT is not loaded, include jQuery Lazy XT library
		 */
		if (!$lazyxt_loaded) {

			wp_enqueue_script( 'jquery-lazyloadxt', WPABTF_URI . 'public/js/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', $in_footer );
			$lazyxt_script_dependencies[] = 'jquery-lazyloadxt';
		}

		/**
		 * Load Lazy Load XT widget module 
		 */
		wp_enqueue_script( 'jquery-lazyloadxt-widget', WPABTF_URI . 'public/js/jquery.lazyloadxt.widget.min.js', $lazyxt_script_dependencies, $this->package_version(), $in_footer );
	}

	/**
	 * Get package version
	 */
	public function package_version($reset = false) {

		if (!$reset) {
			$version = get_option('abtf_lazyxt_version');
			if ($version) {
				return $version;
			}
		}

		// check existence of package file
		$package_json = WPABTF_PATH . 'public/js/src/lazyloadxt_package.json';
		if (!file_exists($package_json)) {
			$this->CTRL->admin->set_notice('PLUGIN INSTALLATION NOT COMPLETE, MISSING public/js/src/lazyloadxt_package.json', 'ERROR');
			return false;
		} else {

			$package = @json_decode(file_get_contents($package_json),true);
			if (!is_array($package)) {
				$this->CTRL->admin->set_notice('failed to parse public/js/src/lazyloadxt_package.json', 'ERROR');
				return false;
			} else {

				$version = update_option('abtf_lazyxt_version', $package['version']);

				// return version
				return $package['version'];
			}
		}
	}

}
