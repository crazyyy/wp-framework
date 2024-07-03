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
use WPCF7_ContactForm; 		    // phpcs:ignore
use WP_Upgrader; 				// phpcs:ignore
use Plugin_Upgrader; 			// phpcs:ignore
use WP_Upgrader_Skin; 			// phpcs:ignore
use WP_Session_Tokens;

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

		// add_action( 'wp_ajax_woo_plugin_installed', [ $this, 'woo_plugin_installed' ] );
		add_action( 'wp_ajax_nts_is_woocommerce_installed', [ $this, 'IS_woocommerce_installed' ] );
		add_action('wp_ajax_activate_woocommerce_plugin', [ $this, 'activate_woocommerce_plugin' ]);
		add_action('wp_ajax_install_and_activate_woocommerce_plugin', [ $this, 'install_and_activate_woocommerce_plugin' ]);

		add_action( 'wp_ajax_nts_is_cf7_installed', [ $this, 'IS_CF7_installed' ] );
		add_action('wp_ajax_activate_cf7_plugin', [ $this, 'activate_cf7_plugin' ]);
		add_action('wp_ajax_install_and_activate_cf7_plugin', [ $this, 'install_and_activate_cf7_plugin' ]);


		add_action( 'wp_ajax_nts_is_formflow_installed', [ $this, 'IS_formflow_installed' ] );
		add_action('wp_ajax_activate_formflow_plugin', [ $this, 'activate_formflow_plugin' ]);
		add_action('wp_ajax_install_and_activate_formflow_plugin', [ $this, 'install_and_activate_formflow_plugin' ]);



		add_action( 'wp_ajax_wpnts_get_visitor_data', [ $this, 'get_visitor_data' ] );
		add_action( 'wp_ajax_wpnts_visitor_data_delete_leads', [ $this, 'visitor_data_delete' ] );
		add_action( 'wp_ajax_wpnts_visitor_data_bulk_delete_leads', [ $this, 'visitor_data_bulk_delete' ] );

		add_action( 'wp_ajax_wpnts_logoutUser_forcefully', [ $this, 'wpnts_logoutUser_forcefully' ] );
		add_action( 'wp_ajax_update_active_users_data', [ $this, 'update_active_users_data' ] );

		add_action( 'wp_ajax_notice_settings', [ $this, 'notice_settings' ] );


		add_action( 'wp_ajax_gswpts_notice_action', [ $this, 'manage_notices' ] );
		add_action( 'wp_ajax_nopriv_gswpts_notice_action', [ $this, 'manage_notices' ] );


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

	

	/**
	 * WooCommerce
	 */
	public function IS_woocommerce_installed() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		if ( is_plugin_active('woocommerce/woocommerce.php') ) {
			wp_send_json_success([
				'status'       => 'active',
			]);

		} elseif ( file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php') ) {
				// 'Installed but not activated' .
				wp_send_json_success([
					'status'       => 'inactive',
				]);
		} else {
			wp_send_json_success([
				'status'       => 'notinstalled',
			]);
		}
	}


   public function activate_woocommerce_plugin() {
	   // Activate the Contact Form 7 plugin.
	   activate_plugin('woocommerce/woocommerce.php');
	   wp_send_json('activated');
   }

   /**
	* Install and activate the Contact Form 7 plugin.
	*
	* @since 3.0.0
	*/
   public function install_and_activate_woocommerce_plugin() {
	   $plugin_slug = 'woocommerce';
	   require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	   require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	   require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

	   $api = plugins_api('plugin_information', [
		   'slug' => $plugin_slug,
	   ]);

	   $upgrader = new Plugin_Upgrader(new WP_Upgrader_Skin());
	   $install = $upgrader->install($api->download_link);

	   if ( is_wp_error($install) ) {
		   wp_send_json('failedtoinstall');
	   }

	   activate_plugin('woocommerce/woocommerce.php');

	   wp_send_json('installedandactivated');
   }



	 /**
	  * Contact Form 7
	  */
	public function IS_CF7_installed() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
			wp_send_json_success([
				'status'       => 'active',
			]);

		} elseif ( file_exists(WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php') ) {
				// 'Installed but not activated' .
				wp_send_json_success([
					'status'       => 'inactive',
				]);
		} else {
			wp_send_json_success([
				'status'       => 'notinstalled',
			]);
		}
	}


   public function activate_cf7_plugin() {
	   // Activate the Contact Form 7 plugin.
	   activate_plugin('contact-form-7/wp-contact-form-7.php');
	   wp_send_json('activated');
   }

   /**
	* Install and activate the Contact Form 7 plugin.
	*
	* @since 3.0.0
	*/
   public function install_and_activate_cf7_plugin() {
	   $plugin_slug = 'contact-form-7';
	   require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	   require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	   require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

	   $api = plugins_api('plugin_information', [
		   'slug' => $plugin_slug,
	   ]);

	   $upgrader = new Plugin_Upgrader(new WP_Upgrader_Skin());
	   $install = $upgrader->install($api->download_link);

	   if ( is_wp_error($install) ) {
		   wp_send_json('failedtoinstall');
	   }

	   activate_plugin('contact-form-7/wp-contact-form-7.php');

	   wp_send_json('installedandactivated');
   }


   	/**
	* FormFlow
    */
	  public function IS_formflow_installed() {
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}

		if ( is_plugin_active('simple-form/simple-form.php') ) {
			wp_send_json_success([
				'status'       => 'active',
			]);

		} elseif ( file_exists(WP_PLUGIN_DIR . '/simple-form/simple-form.php') ) {
				// 'Installed but not activated' .
				wp_send_json_success([
					'status'       => 'inactive',
				]);
		} else {
			wp_send_json_success([
				'status'       => 'notinstalled',
			]);
		}
	}


   public function activate_formflow_plugin() {
	   // Activate the Contact Form 7 plugin.
	   activate_plugin('simple-form/simple-form.php');
	   wp_send_json('activated');
   }

   /**
	* Install and activate the Contact Form 7 plugin.
	*
	* @since 3.0.0
	*/
   public function install_and_activate_formflow_plugin() {
	   $plugin_slug = 'simple-form';
	   require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	   require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	   require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

	   $api = plugins_api('plugin_information', [
		   'slug' => $plugin_slug,
	   ]);

	   $upgrader = new Plugin_Upgrader(new WP_Upgrader_Skin());
	   $install = $upgrader->install($api->download_link);

	   if ( is_wp_error($install) ) {
		   wp_send_json('failedtoinstall');
	   }

	   activate_plugin('simple-form/simple-form.php');

	   wp_send_json('installedandactivated');
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
	/**
	 * Logout users
	 */
	
	public function wpnts_logoutUser_forcefully() {
		// Validate nonce
		if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'wp_rest') ) {
			wp_send_json_error([
				'message' => __('Invalid nonce.', 'wpnts'),
			]);
		}
	 
		$user_id = ! empty( $_POST['id'] ) ? absint( $_POST['id'] ) : false;
	
		if ( $user_id ) {
			// Get all sessions for the user
			$sessions = WP_Session_Tokens::get_instance($user_id);
	
			if ( $sessions ) {
				// Invalidate all sessions
				$sessions->destroy_all();
	
				wp_send_json_success([
					'message' => sprintf( __('User with ID %d has been forcefully logged out.', 'wpnts'), $user_id ),
					'status' => 'success'
				]);
			} else {
				wp_send_json_error([
					'message' => sprintf( __('User with ID %d not found.', 'wpnts'), $user_id ),
					'status' => 'notfound'
				]);
			}
		} else {
			wp_send_json_error([
				'message' => __('Invalid User ID.', 'wpnts'),
				'status' => 'invalid'
			]);
		}
	}



	public function update_active_users_data() {
		// Check nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'wp_rest' ) ) {
			wp_send_json_error( [
				'message' => __( 'Invalid nonce.', 'wpnts' ),
			] );
		}
	
		// Get user ID
		$user_id = isset( $_POST['user_id'] ) ? absint( $_POST['user_id'] ) : 0;
	
		// Get active users data from options table
		$active_users_data = get_option( 'active_users_data', [] );
	
		// Remove user data from active users data
		if ( isset( $active_users_data[ $user_id ] ) ) {
			unset( $active_users_data[ $user_id ] );
		}
	
		// Update the option with active users data
		update_option( 'active_users_data', $active_users_data );
	
		// Send success response
		wp_send_json_success();
	}




	/**
	 * Manage notices ajax endpoint response.
	 *
	 * @since 2.12.15
	 */
	public function manage_notices() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'notifier_notices_nonce' ) ) {
			wp_send_json_error([
				'message' => __( 'Invalid action', 'wpnts' ),
			]);
		}

		$action_type = isset( $_POST['actionType'] ) ? sanitize_text_field( wp_unslash( $_POST['actionType'] ) ) : '';
		$info_type   = isset( $_POST['info']['type'] ) ? sanitize_text_field( wp_unslash( $_POST['info']['type'] ) ) : '';
		$info_value  = isset( $_POST['info']['value'] ) ? sanitize_text_field( wp_unslash( $_POST['info']['value'] ) ) : '';

		if ( 'hide_notice' === $info_type ) {
			$this->hide_notice( $action_type );
		}

		if ( 'reminder' === $info_type ) {
			$this->set_reminder( $action_type, $info_value );
		}
	}

	/**
	 * Hide notices.
	 *
	 * @param string $action_type The action type.
	 * @since 2.12.15
	 */
	public function hide_notice( $action_type ) {
		if ( 'review_notice' === $action_type ) {
			update_option( 'NotifierReviewNotice', true );
		}


		if ( 'upgrade_notice' === $action_type ) {
			update_option( 'NotifierUpgradeNotice', true );
		}

		wp_send_json_success([
			'response_type' => 'success',
		]);
	}

	/**
	 * Set reminder to display notice.
	 *
	 * @param string $action_type The action type.
	 * @param string $info_value  The reminder value.
	 * @since 2.12.15
	 */
	public function set_reminder( $action_type, $info_value = '' ) {
		if ( 'hide_notice' === $info_value ) {
			$this->hide_notice( $action_type );
			wp_send_json_success([
				'response_type' => 'success',
			]);
		} else {

			if ( 'review_notice' === $action_type ) {
				update_option( 'DefaultNTReviewNoticeInterval', ( time() + intval( $info_value ) * 24 * 60 * 60 ) );
			}


			if ( 'upgrade_notice' === $action_type ) {
				update_option( 'DefaultNTUpgradeInterval', ( time() + intval( $info_value ) * 24 * 60 * 60 ) );
			}

			wp_send_json_success([
				'response_type' => 'success',
			]);
		}
	}
	

}
