<?php
/**
 * Admin Chat Box Enqueue
 *
 * This class is used to enqueue ass assets
 *
 * @package WPNTS\Inc
 */
namespace WPNTS\Inc;

use WPNTS\Inc\nts_fs;
use WPNTS\Inc\BaseController;
use WPNTS\Inc\Database\DB;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * Enqueue Class is used to enqueue ass assets.
 *
 * @since 1.0.0
 */
class Enqueue extends BaseController {
	/**
	 * Register Instance.
	 *
	 * @since  1.0.0
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frondend_enqueue' ] );
	}
	/**
	 * This admin_enqueue function is used to enqueue.
	 *
	 * @param string $screen used to show the current screen path.
	 * @since  1.0.0
	 */
	public function admin_enqueue( $screen ) {
		
		 /**
		 * Banner content & notices
		 */
		$pages = [ 'toplevel_page_wpnts_notifier', 'edit.php', 'plugins.php', 'index.php' ];

		if ( ! in_array($screen, $pages) ) {
			wp_enqueue_style( 'wpnts_noice_prevent_css_style', WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/prevent-notice.css',[], time(),'all' );
			return;
		}

		if ( 'edit.php' !== $screen || 'product' === get_current_screen()->post_type || in_array($screen, $pages) ) {
			wp_enqueue_style( 'wpnts_noice_css_style', WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/notice.css',[], time(),'all' );
		}

		
		/**
		 * WPNTS admin-all screen loaded file.
		 */
		if ( 'toplevel_page_wpnts_notifier' === $screen || 'notifier_page_wpnts_notifier_setting' === $screen || 'notifier_page_wpnts_notifier_authors' === $screen ) {

			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );

			// Enqueue Freemius Checkout script
			wp_enqueue_script('freemius_checkout', '//checkout.freemius.com/checkout.min.js', [ 'jquery' ], '1.0.0', true);

			wp_enqueue_style( 'wpnts_main_scss_style', WP_NOTIFIER_TO_SLACK_DIR_URL . 'build/index.css',[], time(),'all' );
			/**
			 * Admin global CSS.
			 */
			wp_enqueue_style(
				'wpnts-admin-css',
				WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/admin.css',
				'',
				time(),
				'all'
			);

			wp_enqueue_script(
				'wpnts-admin-js',
				WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/admin.js',
				[ 'jquery' ],
				time(),
				true
			);

			/**
			 * Main Script enqueue here
			 */

			$wpnts_db_instance = new DB();
			$dashboard_data = $wpnts_db_instance->get_all();
			$formflow_status = $wpnts_db_instance->formflow_status();
			$woocommercewoocommerce_status = $wpnts_db_instance->woocommercewoocommerce_status();
			$cf7_status = $wpnts_db_instance->cf7_status();
			$is_pro_active = $wpnts_db_instance->is_pro_active();
			$debug_mode_status = $wpnts_db_instance->debug_mode_status();
			$maintenannotice_mode_status = $wpnts_db_instance->maintenannotice_mode_status();
			$global_settings = $wpnts_db_instance->global_settings();
			$get_current_user_id = $wpnts_db_instance->get_current_user_id();
			$visitor_data = $wpnts_db_instance->visitor_data();
			$notice_settings = $wpnts_db_instance->notice_settings();
			$admin_list = $wpnts_db_instance->admin_list();

			wp_enqueue_script( 'wpnts_min_js', $this->plugin_url . 'build/index.js',[ 'jquery', 'wp-element', 'wp-util' ], time(),true );
			wp_localize_script('wpnts_min_js', 'appLocalizer', [
				'nonce' => wp_create_nonce( 'wp_rest'),
				'wpntsUrl' => home_url( '/wp-json' ),
				'homeUrl' => esc_url(admin_url()),
				'admin_ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
				'dashboard_data'  => $dashboard_data,
				'isPro'  => $is_pro_active,
				'formflow_status'  => $formflow_status,
				'isWooactive'  => $woocommercewoocommerce_status,
				'cf7_status'  => $cf7_status,
				'debugMode'  => $debug_mode_status,
				'maintenannoticeMode'  => $maintenannotice_mode_status,
				'globalhook'  => $global_settings,
				'get_current_user_id'  => $get_current_user_id,
				'visitor_data'  => $visitor_data,
				'notice_settings'  => $notice_settings,
				'admin_list'  => $admin_list,
			] );
			wp_enqueue_script('wpnts_min_js');

		}
	}

	/**
	 * WPNTS public-all screen loaded file.
	 */
	public function frondend_enqueue() {
			/**
			 * Main Script enqueue here
			 */
			wp_enqueue_script( 'wpnts_public_min_js', $this->plugin_url . 'build/index.js',[ 'jquery', 'wp-element' ], time(),true );
			wp_localize_script('wpnts_public_min_js', 'appLocalizer', [
				'wpntsUrl' => home_url( '/wp-json' ),
				'nonce' => wp_create_nonce( 'wp_rest'),
			] );
			wp_enqueue_script('wpnts_public_min_js');
	}
}
