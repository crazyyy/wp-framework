<?php
if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WPO_Activation')) :

class WPO_Activation {

	/**
	 * Actions to be performed upon plugin activation
	 */
	public static function actions() {
		if (is_multisite() && !is_network_admin()) {
			self::deactivate_and_die();
		}

		if (!self::is_reactivated()) {
			self::set_as_newly_activated();
		}

		WP_Optimize()->get_options()->set_default_options();
		WP_Optimize()->get_minify()->plugin_activate();
		WP_Optimize()->get_gzip_compression()->restore();
		WP_Optimize()->get_browser_cache()->restore();

		self::init_batch_processing();

		if (self::is_premium()) {
			self::init_premium();
		}
	}

	/**
	 * When non network admin tries to activate plugin, deactivate it and die with a message
	 */
	private static function deactivate_and_die() {
		deactivate_plugins(plugin_basename(WPO_PLUGIN_MAIN_PATH . 'wp-optimize.php'));
		wp_die(__('Only Network Administrator can activate WP-Optimize plugin.', 'wp-optimize') .
			' <a href="' . admin_url('plugins.php') . '">' . __('go back', 'wp-optimize') . '</a>');
	}

	/**
	 * Decides whether the plugin is newly installed and activated or already installed and reactivated
	 *
	 * @return mixed
	 */
	private static function is_reactivated() {
		return WP_Optimize()->get_options()->get_option('last-optimized', false);
	}

	/**
	 * Set plugin option `newly-activated` as `true`
	 */
	private static function set_as_newly_activated() {
		WP_Optimize()->get_options()->update_option('newly-activated', true);
	}

	/**
	 * Make use of Task Manager library
	 */
	private static function init_batch_processing() {
		if (!class_exists('Updraft_Tasks_Activation')) {
			require_once(WPO_PLUGIN_MAIN_PATH . 'vendor/team-updraft/common-libs/src/updraft-tasks/class-updraft-tasks-activation.php');
		}
		Updraft_Tasks_Activation::init_db();
		Updraft_Tasks_Activation::reinstall_if_needed();
	}

	/**
	 * Decides whether activate plugin is premium version or not
	 *
	 * @return bool
	 */
	private static function is_premium() {
		return file_exists(WPO_PLUGIN_MAIN_PATH . 'premium.php');
	}

	/**
	 * Run premium plugin activation actions
	 */
	private static function init_premium() {
		if (!class_exists('WP_Optimize_Premium')) {
			include_once(WPO_PLUGIN_MAIN_PATH . 'premium.php');
		}
		WP_Optimize_Premium()->plugin_activation_actions();
	}
}
endif;
