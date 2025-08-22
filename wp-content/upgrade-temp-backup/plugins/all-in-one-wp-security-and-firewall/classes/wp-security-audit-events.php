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
		// Setup event types to display filter dropdown for audit logs list
		add_action('init', 'AIOWPSecurity_Audit_Events::setup_event_types');

		// Core events
		add_action('_core_updated_successfully', 'AIOWPSecurity_Audit_Events::core_updated', 10, 2);

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

		// Translation events
		add_action('upgrader_process_complete', 'AIOWPSecurity_Audit_Events::translation_updated', 10, 2);

		// User events
		add_action('password_reset', 'AIOWPSecurity_Audit_Events::password_reset', 10, 1);
		add_action('deleted_user', 'AIOWPSecurity_Audit_Events::user_deleted', 10, 3);
		add_action('remove_user_from_blog', 'AIOWPSecurity_Audit_Events::user_removed_from_blog', 10, 3);

		// Rule events
		add_action('plugins_loaded', 'AIOWPSecurity_Audit_Events::rule_event', 10, 2);

		// Attach an URL to the details to show as a link for configuring rules
		add_filter('aios_audit_filter_details', function($details, $event_type) {

			// Ensure we only process rules from the firewall
			if (!preg_match('/^rule_/', $event_type)) return $details;

			$key = "{$details['firewall_event']['rule_name']}::{$details['firewall_event']['rule_family']}";

			// Get the URL for the corresponding rule
			$location = AIOS_Helper::get_firewall_rule_location($key);
			$can_show_configure = !empty($location);

			// Only the super admin on the main site can configure the firewall, so only show the configure link to them
			if (is_multisite()) $can_show_configure = $can_show_configure && is_main_site() && is_super_admin();

			if ($can_show_configure) $details['firewall_event']['location'] = admin_url("admin.php?{$location}");

			return $details;
		}, 10, 2);
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
	public static function setup_event_types() {
		self::$event_types = array(
			'core_updated' => __('Core updated', 'all-in-one-wp-security-and-firewall'),
			'plugin_installed' => __('Plugin installed', 'all-in-one-wp-security-and-firewall'),
			'plugin_activated' => __('Plugin activated', 'all-in-one-wp-security-and-firewall'),
			'plugin_updated' => __('Plugin updated', 'all-in-one-wp-security-and-firewall'),
			'plugin_deactivated' => __('Plugin deactivated', 'all-in-one-wp-security-and-firewall'),
			'plugin_deleted' => __('Plugin deleted', 'all-in-one-wp-security-and-firewall'),
			'theme_installed' => __('Theme installed', 'all-in-one-wp-security-and-firewall'),
			'theme_activated' => __('Theme activated', 'all-in-one-wp-security-and-firewall'),
			'theme_updated' => __('Theme updated', 'all-in-one-wp-security-and-firewall'),
			'theme_deleted' => __('Theme deleted', 'all-in-one-wp-security-and-firewall'),
			'translation_updated' => __('Translation updated', 'all-in-one-wp-security-and-firewall'),
			'entity_changed' => __('Entity changed', 'all-in-one-wp-security-and-firewall'),
			'successful_login' => __('Successful login', 'all-in-one-wp-security-and-firewall'),
			'successful_logout' => __('Successful logout', 'all-in-one-wp-security-and-firewall'),
			'failed_login' => __('Failed login', 'all-in-one-wp-security-and-firewall'),
			'user_registration' => __('User registration', 'all-in-one-wp-security-and-firewall'),
			'user_deleted' => __('User deleted', 'all-in-one-wp-security-and-firewall'),
			'user_removed' => __('User removed from blog', 'all-in-one-wp-security-and-firewall'),
			'table_migration' => __('Table migration', 'all-in-one-wp-security-and-firewall'),
			'rule_triggered' => __('Rule triggered', 'all-in-one-wp-security-and-firewall'),
			'rule_not_triggered' => __('Rule not triggered', 'all-in-one-wp-security-and-firewall'),
			'rule_active' => __('Rule active', 'all-in-one-wp-security-and-firewall'),
			'rule_not_active' => __('Rule not active', 'all-in-one-wp-security-and-firewall'),
			'password_reset' => __('Password reset', 'all-in-one-wp-security-and-firewall'),
		);
	}

	/**
	 * Adds a core updated event to the audit log
	 *
	 * @param string $new_version - the wp version we updated to
	 *
	 * @return void
	 */
	public static function core_updated($new_version) {
		global $wp_version;

		$details = array(
			'core_updated' => array(
				'old_version' => $wp_version,
				'new_version' => $new_version
			)
		);
		do_action('aiowps_record_event', 'core_updated', $details, 'info');
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
		// If this is empty then we have no way to know if this is a plugin/theme install/update so create an entity changed event
		if (empty($hook_extra)) {
			self::event_entity_changed($upgrader);
			return;
		}
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
		// If this is empty then we have no way to know if this is a plugin/theme install/update so return as we catch this in plugin_installed()
		if (empty($hook_extra)) return;
		if ('plugin' !== $hook_extra['type'] || 'update' !== $hook_extra['action']) return;
		if (isset($hook_extra['plugin'])) {
			$plugin = $hook_extra['plugin'];
			self::event_plugin_changed('updated', $plugin, '');
		} elseif (isset($hook_extra['plugins'])) {
			foreach ($hook_extra['plugins'] as $plugin) {
				self::event_plugin_changed('updated', $plugin, '');
			}
		}
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
		// If this is empty then we have no way to know if this is a plugin/theme install/update so return as we catch this in plugin_installed()
		if (empty($hook_extra)) return;
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
		// If this is empty then we have no way to know if this is a plugin/theme install/update so return as we catch this in plugin_installed()
		if (empty($hook_extra)) return;
		if ('theme' !== $hook_extra['type'] || 'update' !== $hook_extra['action']) return;
		if (isset($hook_extra['theme'])) {
			$theme = $hook_extra['theme'];
			self::event_theme_changed('updated', $theme, '');
		} elseif (isset($hook_extra['themes'])) {
			foreach ($hook_extra['themes'] as $theme) {
				self::event_theme_changed('updated', $theme, '');
			}
		}
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
	 * Adds a translation updated event to the audit log
	 *
	 * @param WP_Upgrader $upgrader   - WP_Upgrader instance
	 * @param array       $hook_extra - Array of bulk item update data
	 *
	 * @return void
	 */
	public static function translation_updated($upgrader, $hook_extra) {

		// If this is empty then we have no way to know if this is a plugin/theme/translation install/update so return as we catch this in plugin_installed()
		if (empty($hook_extra)) return;

		if ('translation' !== $hook_extra['type'] || 'update' !== $hook_extra['action']) return;

		if (!isset($hook_extra['translations']) || empty($hook_extra['translations'])) return;

		foreach ($hook_extra['translations'] as $info) {
			$details = array(
				'translation_updated' => $info
			);
			do_action('aiowps_record_event', 'translation_updated', $details, 'info');
		}
	}

	/**
	 * Adds a entity changed event to the audit log
	 *
	 * @param WP_Upgrader $upgrader - WP_Upgrader instance
	 *
	 * @return void
	 */
	public static function event_entity_changed($upgrader) {

		$entity = (isset($upgrader->result) && isset($upgrader->result['destination_name'])) ? $upgrader->result['destination_name'] : false;

		$details = array(
			'entity_changed' => array(
				'entity' => $entity,
			)
		);
		do_action('aiowps_record_event', 'entity_changed', $details, 'warning');
	}

	/**
	 * Adds all the firewall rule events to the audit log
	 *
	 * @return void
	 */
	public static function rule_event() {
		$aiowps_firewall_message_store = AIOS_Firewall_Resource::request(AIOS_Firewall_Resource::MESSAGE_STORE);
		$events = array();
		foreach (array('active', 'not_active', 'triggered', 'not_triggered') as $event) {
			$data = $aiowps_firewall_message_store->get('rule_'.$event);

			if (empty($data)) continue;

			foreach ($data as $rule) {

				$details = array(
					'firewall_event' => array(
						'event'       => $event,
						'rule_name'   => $rule['name'],
						'rule_family' => $rule['family'],
					)
				);

				$blog_id = AIOWPSecurity_Utility::get_blog_id_from_request($rule['request']);

				$rule['request'] = apply_filters('aios_audit_filter_request', $rule['request'], $event);

				$events[] = array(
					'network_id' => get_current_network_id(),
					'site_id' => $blog_id,
					'username' => (isset($rule['potential_user']) ? AIOWPSecurity_Utility::verify_username($rule['potential_user']) : false),
					'ip' => $rule['ip'],
					'level' => 'triggered' === $event ? 'warning' : 'info',
					'event_type' => 'rule_'.$event,
					'details' => wp_json_encode($details, true),
					'stacktrace' => (isset($rule['request']) ? print_r($rule['request'], true) : ''), // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r -- PCP warning. Part of AOIS error reporting system.
					'created' => $rule['time']
				);
			}
		}

		if (empty($events)) return;

		do_action('aiowps_bulk_record_events', $events);
	}

	/**
	 * Adds a password reset event to the audit log
	 *
	 * @param object $user_data - Object containing user's data
	 */
	public static function password_reset($user_data) {

		$user_login = (false === $user_data) ? 'unknown' : $user_data->user_login;

		$details = array(
			'password_reset' => array(
				'user_login' => $user_login
			)
		);
		do_action('aiowps_record_event', 'password_reset', $details, 'warning');
	}

	/**
	 * Adds a user deleted event to the audit log
	 *
	 * @param int      $user_id   - the id of the deleted user
	 * @param int|null $reassign  - the id of the user to reassign data to or null
	 * @param object   $user_data - Object containing user's data
	 *
	 * @return void
	 */
	public static function user_deleted($user_id, $reassign, $user_data) {

		$user_login = (false === $user_data) ? 'unknown' : $user_data->user_login;

		$details = array(
			'user_deleted' => array(
				'user_id' => $user_id,
				'reassign' => $reassign,
				'user_login' => $user_login

			)
		);
		do_action('aiowps_record_event', 'user_deleted', $details, 'warning');
	}

	/**
	 * Adds a user removed event to the audit log
	 *
	 * @param int $user_id  - the id of the removed user
	 * @param int $blog_id  - the id of the blog the user was removed from
	 * @param int $reassign - the id of the user to reassign data to or null
	 *
	 * @return void
	 */
	public static function user_removed_from_blog($user_id, $blog_id, $reassign) {
		$user_data = get_user_by('ID', $user_id);
		$user_login = is_a($user_data, 'WP_User') && 0 !== $user_data->ID ? $user_data->user_login : 'unknown';

		$details = array(
			'user_removed' => array(
				'user_id' => $user_id,
				'blog_id' => $blog_id,
				'reassign' => $reassign,
				'user_login' => $user_login

			)
		);
		do_action('aiowps_record_event', 'user_removed', $details, 'warning');
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

	/**
	 * Adds a user registration event to the audit log
	 *
	 * @param integer $user_id - the user ID of the newly registered user
	 * @param string  $type    - the type of registration valid values (admin, pending, registered)
	 *
	 * @return void
	 */
	public static function event_user_registration($user_id, $type) {
		$registered_user = get_user_by('ID', $user_id);
		$registered_username = is_a($registered_user, 'WP_User') && 0 !== $registered_user->ID ? $registered_user->user_login : '';

		$details = array(
			'user_registration' => array(
				'registered_username' => $registered_username,
				'type' => $type,
			)
		);

		if ('admin' == $type) {
			$admin_user = wp_get_current_user();
			$admin_username = is_a($admin_user, 'WP_User') ? $admin_user->user_login : '';
			$details['user_registration']['admin_username'] = $admin_username;
			do_action('aiowps_record_event', 'user_registration', $details, 'info');
		} elseif ('pending' == $type) {
			do_action('aiowps_record_event', 'user_registration', $details, 'info', $registered_username);
		} elseif ('registered' == $type) {
			do_action('aiowps_record_event', 'user_registration', $details, 'info', $registered_username);
		}
	}

	/**
	 * Adds a successful login event to the audit log
	 *
	 * @param string $username - the username for the successful login
	 *
	 * @return void
	 */
	public static function event_successful_login($username) {
		$details = array(
			'successful_login' => array(
				'username' => $username,
			)
		);
		do_action('aiowps_record_event', 'successful_login', $details, 'info', $username);
	}

	/**
	 * Adds a successful logout event to the audit log
	 *
	 * @param string  $username     - the username for the successful logout
	 * @param boolean $force_logout - if the logout was a force logout
	 *
	 * @return void
	 */
	public static function event_successful_logout($username, $force_logout = false) {
		$details = array(
			'successful_logout' => array(
				'username' => $username,
				'force_logout' => $force_logout ? __('(force logout)', 'all-in-one-wp-security-and-firewall') : ''
			)
		);
		do_action('aiowps_record_event', 'successful_logout', $details, 'info', $username);
	}

}
