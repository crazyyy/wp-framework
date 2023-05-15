<?php

if (!defined('ABSPATH')) die('No direct access allowed');

class AIOWPSecurity_Audit_Events {

	public static $log_levels = array(
		'info',
		'warning',
		'fatal',
		'error',
		'debug',
		'trace',
	);

	public static $event_types = array();

	private static $installed_plugin_info = array();

	private static $removed_plugin_info = array();

	private static $installed_theme_info = array();

	private static $removed_theme_info = array();

	/**
	 * This function adds all the event actions we want to capture and record in the audit log
	 *
	 * @return void
	 */
	public static function add_event_actions() {
		// Setup
		self::setup_event_types();

		// Plugin events
		add_action('upgrader_process_complete', 'AIOWPSecurity_Audit_Events::plugin_installed', 10, 2);
		add_action('activated_plugin', 'AIOWPSecurity_Audit_Events::plugin_activated', 10, 2);
		add_action('upgrader_process_complete', 'AIOWPSecurity_Audit_Events::plugin_updated', 10, 2);
		add_action('deactivated_plugin', 'AIOWPSecurity_Audit_Events::plugin_deactivated', 10, 2);
		add_action('delete_plugin', 'AIOWPSecurity_Audit_Events::plugin_delete', 10, 2);
		add_action('deleted_plugin', 'AIOWPSecurity_Audit_Events::plugin_deleted', 10, 2);

		// Theme events
		add_action('upgrader_process_complete', 'AIOWPSecurity_Audit_Events::theme_installed', 10, 2);
		add_action('switch_theme', 'AIOWPSecurity_Audit_Events::theme_activated', 10, 1);
		add_action('upgrader_process_complete', 'AIOWPSecurity_Audit_Events::theme_updated', 10, 2);
		add_action('delete_theme', 'AIOWPSecurity_Audit_Events::theme_delete', 10, 2);
		add_action('deleted_theme', 'AIOWPSecurity_Audit_Events::theme_deleted', 10, 2);
	}

	/**
	 * This function removes event actions that need to be removed when we are removing the plugin
	 *
	 * @return void
	 */
	public static function remove_event_actions() {
		remove_action('delete_plugin', 'AIOWPSecurity_Audit_Events::plugin_delete');
		remove_action('deleted_plugin', 'AIOWPSecurity_Audit_Events::plugin_deleted');
	}

	/**
	 * Populates the event_types array
	 *
	 * @return void
	 */
	private static function setup_event_types() {
		self::$event_types = array(
			'plugin_installed' => __('Plugin installed', 'all-in-one-wp-security-and-firewall'),
			'plugin_activated' => __('Plugin activated', 'all-in-one-wp-security-and-firewall'),
			'plugin_updated' => __('Plugin updated', 'all-in-one-wp-security-and-firewall'),
			'plugin_deactivated' => __('Plugin deactivated', 'all-in-one-wp-security-and-firewall'),
			'plugin_deleted' => __('Plugin deleted', 'all-in-one-wp-security-and-firewall'),
			'theme_installed' => __('Theme installed', 'all-in-one-wp-security-and-firewall'),
			'theme_activated' => __('Theme activated', 'all-in-one-wp-security-and-firewall'),
			'theme_updated' => __('Theme updated', 'all-in-one-wp-security-and-firewall'),
			'theme_deleted' => __('Theme deleted', 'all-in-one-wp-security-and-firewall'),
			'successful_login' => __('Successful login', 'all-in-one-wp-security-and-firewall'),
			'failed_login' => __('Failed login', 'all-in-one-wp-security-and-firewall'),
			'user_registration' => __('User registration', 'all-in-one-wp-security-and-firewall'),
			'table_migration' => __('Table migration', 'all-in-one-wp-security-and-firewall'),
		);
	}

	/**
	 * Adds a plugin installed event to the audit log
	 *
	 * @param WP_Upgrader $upgrader   - WP_Upgrader instance
	 * @param array       $hook_extra - Array of bulk item update data
	 *
	 * @return void
	 */
	public static function plugin_installed($upgrader, $hook_extra) {
		if ('plugin' !== $hook_extra['type'] || 'install' !== $hook_extra['action']) return;
		self::$installed_plugin_info = $upgrader->new_plugin_data;
		self::event_plugin_changed('installed', '', '');
	}

	/**
	 * Adds a plugin activated event to the audit log
	 *
	 * @param  string  $plugin             - Path to the plugin file relative to the plugins directory
	 * @param  boolean $network_activation - Whether to enable the plugin for all sites in the network or just the current site
	 *
	 * @return void
	 */
	public static function plugin_activated($plugin, $network_activation) {
		$network = $network_activation ? 'network' : '';
		self::event_plugin_changed('activated', $plugin, $network);
	}

	/**
	 * Adds a plugin updated event to the audit log
	 *
	 * @param WP_Upgrader $upgrader   - WP_Upgrader instance
	 * @param array       $hook_extra - Array of bulk item update data
	 *
	 * @return void
	 */
	public static function plugin_updated($upgrader, $hook_extra) {
		if ('plugin' !== $hook_extra['type'] || 'update' !== $hook_extra['action']) return;
		$plugin = '';
		if (isset($hook_extra['plugin'])) $plugin = $hook_extra['plugin'];
		if (isset($hook_extra['plugins'])) $plugin = $hook_extra['plugins'][0];
		if (empty($plugin)) return;

		self::event_plugin_changed('updated', $plugin, '');
	}
	
	/**
	 * Adds a plugin deactivated event to the audit log
	 *
	 * @param  string  $plugin               - Path to the plugin file relative to the plugins directory
	 * @param  boolean $network_deactivation - Whether to disable the plugin for all sites in the network or just the current site
	 *
	 * @return void
	 */
	public static function plugin_deactivated($plugin, $network_deactivation) {
		$network = $network_deactivation ? 'network' : '';
		self::event_plugin_changed('deactivated', $plugin, $network, 'warning');
	}

	/**
	 * Records the plugin info of the plugin that is about to be deleted
	 *
	 * @param string $plugin - Path to the plugin file relative to the plugins directory
	 *
	 * @return void
	 */
	public static function plugin_delete($plugin) {
		$filename = WP_PLUGIN_DIR . '/' . $plugin;
		if (!file_exists($filename)) return;

		self::$removed_plugin_info = get_plugin_data($filename);
	}

	/**
	 * Adds a plugin deleted event to the audit log
	 *
	 * @param string  $plugin  - Path to the plugin file relative to the plugins directory
	 * @param boolean $deleted - Whether the plugin deletion was successful
	 *
	 * @return void
	 */
	public static function plugin_deleted($plugin, $deleted) {
		if ($deleted) self::event_plugin_changed('deleted', $plugin, '', 'warning');
	}

	/**
	 * This function will construct the event details and send it to be recorded
	 *
	 * @param string $action  - the action taken (activated, deactivated)
	 * @param string $plugin  - Path to the plugin file relative to the plugins directory
	 * @param string $network - status of if the plugin was network activated/deactivated
	 * @param string $level   - the log level
	 *
	 * @return void
	 */
	private static function event_plugin_changed($action, $plugin, $network, $level = 'info') {
		if ('deleted' == $action) {
			$info = self::$removed_plugin_info;
		} elseif ('installed' == $action) {
			$info = self::$installed_plugin_info;
		} else {
			$filename = WP_PLUGIN_DIR . '/' . $plugin;
			if (!file_exists($filename)) return;
			$info = get_plugin_data($filename);
		}

		$name = empty($info['Name']) ? 'Unknown' : $info['Name'];
		$version = empty($info['Version']) ? '0.0.0' : $info['Version'];

		$details = array(
			'plugin' => array(
				'name' => $name,
				'version' => $version,
				'action' => $action,
				'network' => $network
			)
		);
		do_action('aiowps_record_event', 'plugin_' . $action, $details, $level);
	}

	/**
	 * Adds a theme installed event to the audit log
	 *
	 * @param WP_Upgrader $upgrader   - WP_Upgrader instance
	 * @param array       $hook_extra - Array of bulk item update data
	 *
	 * @return void
	 */
	public static function theme_installed($upgrader, $hook_extra) {
		if ('theme' !== $hook_extra['type'] || 'install' !== $hook_extra['action']) return;
		self::$installed_theme_info = $upgrader->new_theme_data;
		self::event_theme_changed('installed', '', '');
	}

	/**
	 * Adds a theme activated event to the audit log
	 *
	 * @param  string $new_name - Name of the new active theme
	 *
	 * @return void
	 */
	public static function theme_activated($new_name) {
		$details = array(
			'theme' => array(
				'name' => $new_name,
				'action' => 'activated',
			)
		);
		do_action('aiowps_record_event', 'theme_activated', $details);
	}

	/**
	 * Adds a theme updated event to the audit log
	 *
	 * @param WP_Upgrader $upgrader   - WP_Upgrader instance
	 * @param array       $hook_extra - Array of bulk item update data
	 *
	 * @return void
	 */
	public static function theme_updated($upgrader, $hook_extra) {
		if ('theme' !== $hook_extra['type'] || 'update' !== $hook_extra['action']) return;
		$theme = '';
		if (isset($hook_extra['theme'])) $theme = $hook_extra['theme'];
		if (isset($hook_extra['themes'])) $theme = $hook_extra['themes'][0];
		if (empty($theme)) return;

		self::event_theme_changed('updated', $theme, '');
	}

	/**
	 * Records the theme info of the plugin that is about to be deleted
	 *
	 * @param string $theme - Path to the theme file relative to the themes directory
	 *
	 * @return void
	 */
	public static function theme_delete($theme) {
		$info_object = wp_get_theme($theme);
		$info = array(
			'Name' => $info_object->get('Name'),
			'Version' => $info_object->get('Version'),
		);
		self::$removed_theme_info = $info;
	}

	/**
	 * Adds a theme deleted event to the audit log
	 *
	 * @param string  $theme   - Path to the theme file relative to the themes directory
	 * @param boolean $deleted - Whether the theme deletion was successful
	 *
	 * @return void
	 */
	public static function theme_deleted($theme, $deleted) {
		if ($deleted) self::event_theme_changed('deleted', $theme, '', 'warning');
	}

	/**
	 * This function will construct the event details and send it to be recorded
	 *
	 * @param string $action  - the action taken (activated, deactivated)
	 * @param string $theme   - Path to the theme file relative to the themes directory
	 * @param string $network - status of if the theme was network activated/deactivated
	 * @param string $level   - the log level
	 *
	 * @return void
	 */
	private static function event_theme_changed($action, $theme, $network, $level = 'info') {
		if ('deleted' == $action) {
			$info = self::$removed_theme_info;
		} elseif ('installed' == $action) {
			$info = self::$installed_theme_info;
		} else {
			$info_object = wp_get_theme($theme);
			$info = array(
				'Name' => $info_object->get('Name'),
				'Version' => $info_object->get('Version'),
			);
		}

		$name = empty($info['Name']) ? 'Unknown' : $info['Name'];
		$version = empty($info['Version']) ? '0.0.0' : $info['Version'];

		$details = array(
			'theme' => array(
				'name' => $name,
				'version' => $version,
				'action' => $action,
				'network' => $network
			)
		);
		do_action('aiowps_record_event', 'theme_' . $action, $details, $level);
	}

	/**
	 * Adds a failed login event to the audit log
	 *
	 * @param string $username - the username for the failed login attempt
	 *
	 * @return void
	 */
	public static function event_failed_login($username) {
		$user = is_email($username) ? get_user_by('email', $username) : get_user_by('login', $username);
		$details = array(
			'failed_login' => array(
				'imported' => false,
				'username' => $username,
				'known' => true,
			)
		);
		if (is_a($user, 'WP_User')) {
			do_action('aiowps_record_event', 'failed_login', $details, 'warning', $username);
		} else {
			$details['failed_login']['known'] = false;
			do_action('aiowps_record_event', 'failed_login', $details, 'warning', $username);
		}
	}
}
