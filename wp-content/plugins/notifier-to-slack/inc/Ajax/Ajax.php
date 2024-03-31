<?php
/**
 * Admin Chat Box Rest Route
 *
 * This class is used to response and all rest route works
 *
 * @package WPNTS\Inc
 */

namespace WPNTS\Inc\Ajax;

use WPNTS\Inc\Database\DB;
use WP_Upgrader; // phpcs:ignore
use Plugin_Upgrader; // phpcs:ignore
use WP_Upgrader_Skin; // phpcs:ignore

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Update used to rest route created
 *
 * @since 1.0.0
 */
class Ajax {

	/**
	 * Construct method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_wpnts_dashboard_data', [ $this, 'get_all' ] );
		add_action( 'wp_ajax_wpnts_woocommercewoocommerce_status', [ $this, 'woocommercewoocommerce_status' ] );
		add_action( 'wp_ajax_wpnts_debug_mode_status', [ $this, 'debug_mode_status' ] );
		add_action( 'wp_ajax_maintenannotice_mode_status', [ $this, 'maintenannotice_mode_status' ] );

		add_action( 'wp_ajax_global_settings', [ $this, 'global_settings' ] );
		add_action( 'wp_ajax_woo_plugin_installed', [ $this, 'woo_plugin_installed' ] );

		add_action( 'wp_ajax_wpnts_get_visitor_data', [ $this, 'get_visitor_data' ] );
		add_action( 'wp_ajax_wpnts_visitor_data_delete_leads', [ $this, 'visitor_data_delete' ] );
		add_action( 'wp_ajax_wpnts_visitor_data_bulk_delete_leads', [ $this, 'visitor_data_bulk_delete' ] );

		add_action( 'wp_ajax_notice_settings', [ $this, 'notice_settings' ] );
	}

	public function get_all() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'wp_rest' ) ) {
			wp_send_json_error([
				'message' => __( 'Invalid nonce.', 'wpnts' ),
			]);
		}

		$wpnts_db_instance = new DB();
		$dashboard_data = $wpnts_db_instance->get_all();

		wp_send_json_success([
			'tables'       => $dashboard_data,
		]);
	}
	public function woocommercewoocommerce_status() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'wp_rest' ) ) {
			wp_send_json_error([
				'message' => __( 'Invalid nonce.', 'wpnts' ),
			]);
		}

		$woocommerce = is_plugin_active('woocommerce/woocommerce.php');
		if ( $woocommerce ) {
			wp_send_json_success([
				'status'       => $woocommerce,
			]);
		} else {
			wp_send_json_success([
				'status'       => $woocommerce,
			]);
		}
		wp_die();
	}


	public function debug_mode_status() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$wpnts_db_instance = new DB();
		$debug_mode_status = $wpnts_db_instance->debug_mode_status();

		wp_send_json_success([
			'debug_data'       => $debug_mode_status,
		]);
	}

	public function maintenannotice_mode_status() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$wpnts_db_instance = new DB();
		$maintenance_mode_status = $wpnts_db_instance->maintenannotice_mode_status();

		wp_send_json_success([
			'maintenance_status'       => $maintenance_mode_status,
		]);
	}

	public function global_settings() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$wpnts_db_instance = new DB();
		$global_settings = $wpnts_db_instance->global_settings();

		wp_send_json_success([
			'global_settings_status'       => $global_settings,
		]);
	}

	public function notice_settings() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$wpnts_db_instance = new DB();
		$notice_settings = $wpnts_db_instance->notice_settings();

		wp_send_json_success([
			'notice_settings'       => $notice_settings,
		]);
	}

	public function woo_plugin_installed() {
		$woocommerce = is_plugin_active('woocommerce/woocommerce.php');

		if ( true === $woocommerce ) {
			wp_send_json('Woocommerce is already installed.');
		}

		if ( ! current_user_can('manage_options') ) {
			wp_send_json(false, __('You do not have permission to do this', 'wpnts'));
		} else {

			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

			$api = plugins_api( 'plugin_information', [
				'slug' => 'woocommerce',
			] );

			$upgrader = new Plugin_Upgrader( new WP_Upgrader_Skin() );
			$install = $upgrader->install( $api->download_link );

			if ( is_wp_error( $install ) ) {
				wp_send_json( 'Failed to install Contact Form 7 plugin' );
			}

			activate_plugin( 'woocommerce/woocommerce.php' );

			wp_send_json('WooCommerce plugin has been installed and activated successfully!');
		}
	}


	/**
	 * Visitor data
	 */
	public function get_visitor_data() {

		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$wpnts_db_instance = new DB();
		$visitor_data = $wpnts_db_instance->visitor_data();

		wp_send_json_success([
			'visitor_data'       => $visitor_data,
		]);
	}


	public function visitor_data_delete() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		$id = ! empty( $_POST['id'] ) ? absint( $_POST['id'] ) : false;

		if ( $id ) {
			$wpnts_db_instance = new DB();
			$response = $wpnts_db_instance->visitor_data_delete( $id );

			if ( $response ) {
				wp_send_json_success([// phpcs:ignore
					'message'      => sprintf( __( '%s leads deleted.', 'wpx' ), $response ),// phpcs:ignore
				]);
			}

			wp_send_json_error([
				'message'      => sprintf( __( 'Failed to delete leads with id %d' ), $id ),// phpcs:ignore
			]);
		}

		wp_send_json_error([
			'message'      => sprintf( __( 'Invalid ID to delete.' ), $id ),
		]);
	}

	public function visitor_data_bulk_delete() {
		// Validate nonce
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		// Check if 'id' parameter is set and is an array
		// $ids = ! empty($_POST['id']) ? $_POST['id'] : false; . 
		$ids = !empty($_POST['id']) ? sanitize_text_field(wp_unslash($_POST['id'])) : false;

		if ( $ids && is_array($ids) && ! empty($ids) ) {
			$wpnts_db_instance = new DB();
			$response = $wpnts_db_instance->visitor_data_bulk_delete($ids);

			if ( false !== $response ) {
				wp_send_json_success([
					'message' => sprintf(__('%s leads deleted.', 'wpx'), $response),
				]);
			} else {
				wp_send_json_error([
					'message' => __('Failed to delete leads.', 'wpx'),
				]);
			}
		} else {
			wp_send_json_error([
				'message' => __('Invalid IDs to delete.', 'wpx'),
			]);
		}
	}
}
