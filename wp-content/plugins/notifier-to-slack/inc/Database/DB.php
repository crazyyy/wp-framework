<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc\Database;

use WPNTS\Inc\nts_fs;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class DB {

	public function get_all() {
		$response = [];
		$site_status_transient = get_transient( 'health-check-site-status-result' );

		$site_status = json_decode( $site_status_transient, true );

		if ( $site_status ) {
			$status_data = [
				'good' => $site_status['good'],
				'recommended' => $site_status['recommended'],
				'critical' => $site_status['critical'],
			];
		} else {
			$status_data = [
				'good' => '',
				'recommended' => '',
				'critical' => '',
			];
		}

		// Get the total plugin update count from the option table.
		$total_plugin_updates = get_option( 'wpnts_total_plugin_updates', 0 );
		$activated_plugins_data = get_option( 'wpnts_activated_plugins', [] );
		$deactivated_plugins_data = get_option( 'wpnts_deactivated_plugins', [] );
		$wpnts_user_login_info = get_option( 'wpnts_user_login_info', [] );

		$wpnts_user_daily_login_info = get_option( 'wpnts_user_daily_login_info', [] );
		$wpnts_user_track_failed_login = get_option( 'wpnts_user_track_failed_login', [] );

		// You can add more data to the response array if needed.
		$response['total_plugin_updates'] = $total_plugin_updates;

		// Check if the activated plugins list was updated in the last 24 hours.
		$current_time = time();

		// Activated plugin list
		if ( isset( $activated_plugins_data['last_updated'] ) && ( $current_time - $activated_plugins_data['last_updated'] ) < 86400 ) {
			$activated_plugins_list = isset( $activated_plugins_data['plugins'] ) ? $activated_plugins_data['plugins'] : [];
			$response['wpnts_activated_plugins'] = $activated_plugins_list;
		} else {
			// If more than 24 hours have passed, reset the list.
			$response['wpnts_activated_plugins'] = [];
		}

		// Deactivated plugin list
		if ( isset( $deactivated_plugins_data['last_updated'] ) && ( $current_time - $deactivated_plugins_data['last_updated'] ) < 86400 ) {
			$deactivated_plugins_list = isset( $deactivated_plugins_data['plugins'] ) ? $deactivated_plugins_data['plugins'] : [];
			$response['wpnts_deactivated_plugins'] = $deactivated_plugins_list;
		} else {
			// If more than 24 hours have passed, reset the list.
			$response['wpnts_deactivated_plugins'] = [];
		}

		// Logged in and logout in last 24
		$response['wpnts_user_login_info'] = $wpnts_user_login_info;
		$response['wpnts_user_daily_login_info'] = $wpnts_user_daily_login_info;
		$response['wpnts_user_track_failed_login'] = $wpnts_user_track_failed_login;
		$response['wpnts_site_health'] = $status_data;

		// Return the response as JSON.
		return $response;
	}

	public function check_pro_plugin_exists(): bool {
		return file_exists( WP_PLUGIN_DIR . '/notifier-to-slack-pro/notifier-to-slack-pro.php' );
	}

	public function is_pro_active() {
		$is_pro_installed = class_exists('Notifierpro') && $this->check_pro_plugin_exists();
		return nts_fs()->can_use_premium_code__premium_only() && $is_pro_installed;
	}

	public function woocommercewoocommerce_status() {
		$cf7_is_installed = is_plugin_active('woocommerce/woocommerce.php');
		if ( $cf7_is_installed ) {
			return $cf7_is_installed;

		} else {
			return $cf7_is_installed;
		}
		wp_die();
	}


	public function debug_mode_status() {
		$response = [];
		$wp_debug = ( defined('WP_DEBUG') && WP_DEBUG === true );
		$mode = $wp_debug ? 'active' : 'inactive';
		$output = '';

		if ( $wp_debug ) {
			$debug_log = WP_CONTENT_DIR . '/debug.log';

			if ( file_exists($debug_log) ) {
				$debug_log_entries = file($debug_log, FILE_IGNORE_NEW_LINES);
				if ( empty($debug_log_entries) ) {
					$output = 'No errors found in the debug log.';
				} else {
					$output = implode("\n", $debug_log_entries);
				}
			} else {
				$output = 'Debug log file not found. No errors found yet.';
			}
		} else {
			$output = 'Debug mode not activated.';
		}

		$response['status'] = $mode;
		$response['log'] = $output;

		return $response;
	}


	public function maintenannotice_mode_status() {
		$response = [];
		$schedules_int = get_option('wpnts_schedules_maintenannotice_settings');
		$schedules_interval = json_decode($schedules_int);
		$maintenance_mode = $schedules_interval->maintenance_mode ?? 'false';

		$response['status'] = $maintenance_mode;

		return $response;
	}
	/**
	 * Global settings
	 */
	public function global_settings() {
		$response = [];
		$schedules_int = get_option('wpnts_global_api_settings');
		$schedules_interval = json_decode($schedules_int);
		$api_active = $schedules_interval->api_active ?? 'false';

		// $global_interval = $schedules_interval->global_interval ?? '300';
		$global_interval = isset($schedules_interval->global_interval) ? (int) $schedules_interval->global_interval : 300;

		$global_webhook = $schedules_interval->global_webhook ?? '';

		$response['api_active'] = $api_active;
		$response['global_interval'] = $global_interval;
		$response['global_webhook'] = $global_webhook;

		return $response;
	}

	/**
	 * All notice default and update settings
	 */
	public function notice_settings() {
		$response = [];
		// List of option names to fetch
		$option_names = array(
			'wpnts_plugin_list',
			'wpnts_default_interval',
			'wpnts_global_api_settings',
			'wpnts_schedules_interval_site_settings',
			'wpnts_schedules_interval_woocommerce_settings',
			'wpnts_schedules_interval_debuglog_settings',
			'maintenance_mode',
			'wpnts_schedules_maintenannotice_settings',
			'wpnts_webhook_site_settings',
			'wpntswebhook_pagenpost_settings',
			'wpntswebhook_media_settings',
			'wpntswebhook_theme_settings',
			'wpntswebhook_emengency_shutdown',
		);

		foreach ( $option_names as $option_name ) {
			$option_value = get_option($option_name);

			// Check if the option value is a JSON string
			$decoded_value = json_decode($option_value);

			// If it's a JSON string, add it to the response with its own name
			if ( json_last_error() === JSON_ERROR_NONE ) {
				$response[ $option_name ] = $decoded_value;
			} else {
				// If it's not a JSON string, just add it to the response as is
				$response[ $option_name ] = $option_value;
			}
		}

		return $response;
	}


	/**
	 * Visitor count
	 */
	public function visitor_data() {
		$response = [];

		// Fetch data from the custom database table
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpnts_visitor_data';
		// $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
		$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY visiting_time DESC", ARRAY_A);

		// Check if any results were returned
		if ( $results ) {
			// Process the data as needed
			$response['visitor_details'] = $results;
		} else {
			// No results found
			$response['message'] = 'No leads found.';
		}

		return $response;
	}


	public function visitor_data_delete( int $id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'wpnts_visitor_data';

		return $wpdb->delete( $table, [ 'id' => $id ], [ '%d' ] );
	}

	public function admin_list() {
		// Get all users with admin role.
		$admins = get_users(array(
			'role'    => 'administrator',
			'orderby' => 'user_login',
		));

		// Initialize an empty array to store admin usernames and names.
		$admin_list = array();

		// Loop through each admin.
		foreach ( $admins as $admin ) {
			// Add admin username and name to the list.
			$admin_list[] = array(
				'value' => $admin->user_login,
				'label' => $admin->display_name, // Use display name as the label.
			);
		}

		// Return the admin list as JSON.
		return json_encode($admin_list);
	}

	public function visitor_data_bulk_delete( array $ids ) {
		global $wpdb;
		$table = $wpdb->prefix . 'wpnts_visitor_data';

		// Ensure that $ids is not empty to avoid unnecessary queries
		if ( empty($ids) ) {
			return false;
		}

		// Use IN clause to delete multiple rows with specified IDs
		$placeholders = implode(', ', array_fill(0, count($ids), '%d'));
		$query = "DELETE FROM $table WHERE id IN ($placeholders)";

		return $wpdb->query($wpdb->prepare($query, $ids));
	}
}
