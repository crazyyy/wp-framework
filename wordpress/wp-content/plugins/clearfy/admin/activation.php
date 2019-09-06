<?php
	/**
	 * Activator for the clearfy
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 09.09.2017, Webcraftic
	 * @see Factory409_Activator
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_Activation extends Wbcr_Factory409_Activator {

		/**
		 * Runs activation actions.
		 *
		 * @since 1.0.0
		 */
		public function activate()
		{
			if( !function_exists('is_plugin_active') ) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			// Deactivate components for code minification, if alternative plugins are installed
			// -------------
			$minify_js_plugins = array(
				'autoptimize/autoptimize.php',
				'fast-velocity-minify/fvm.php',
				'js-css-script-optimizer/js-css-script-optimizer.php',
				'merge-minify-refresh/merge-minify-refresh.php',
				'wp-super-minify/wp-super-minify.php'
			);

			$is_activate_minify_js = true;
			foreach($minify_js_plugins as $m_plugin) {

				if( is_plugin_active($m_plugin) ) {
					$is_activate_minify_js = false;
				}
			}

			if( !$is_activate_minify_js ) {
				WCL_Plugin::app()->deactivateComponent('minify_and_combine');
				WCL_Plugin::app()->deactivateComponent('html_minify');
			}

			// -------------
			// Deactivate yoast component features if it is not activated
			// -------------

			if( !defined('WPSEO_VERSION') ) {
				WCL_Plugin::app()->deactivateComponent('yoast_seo');
			}

			// Deactivate cyrlitera component for all languages except selected
			if( !in_array(get_locale(), array('ru_RU', 'bel', 'kk', 'uk', 'bg', 'bg_BG', 'ka_GE')) ) {
				WCL_Plugin::app()->deactivateComponent('cyrlitera');
			}

			// Добавляем крон событие для сихнронизации лицензионных данных
			$licensing = WCL_Licensing::instance();

			if( $licensing->isLicenseValid() && !wp_next_scheduled('wbcr_clearfy_license_autosync') ) {
				wp_schedule_event(time(), 'twicedaily', 'wbcr_clearfy_license_autosync');
			}
			// -------------

			$package_plugin = WCL_Package::instance();
			$package_plugin->active();

			/**
			 * @since 1.4.1
			 */
			do_action('wbcr/clearfy/activated');
		}

		/**
		 * Runs activation actions.
		 *
		 * @since 1.0.0
		 */
		public function deactivate()
		{
			if( wp_next_scheduled('wbcr_clearfy_license_autosync') ) {
				wp_clear_scheduled_hook('wbcr_clearfy_license_autosync');
			}

			$dependent = 'clearfy_package/clearfy-package.php';

			require_once ABSPATH . '/wp-admin/includes/plugin.php';
			if( is_plugin_active($dependent) ) {
				add_action('update_option_active_plugins', array($this, 'deactivateDependent'));
			}
			add_action('update_site_option_active_sitewide_plugins', array($this, 'deactivateDependent'));

			/**
			 * @since 1.4.1
			 */
			do_action('wbcr/clearfy/deactivated');
		}

		/**
		 * Deactivate clearfy package
		 */
		public function deactivateDependent()
		{
			$package_plugin = WCL_Package::instance();
			$package_plugin->deactive();
		}
	}
