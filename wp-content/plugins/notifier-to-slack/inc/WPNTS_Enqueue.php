<?php
/**
 * Admin Chat Box Enqueue
 *
 * This class is used to enqueue ass assets
 *
 * @package WPNTS\Inc
 */
namespace WPNTS\Inc;

use \WPNTS\Inc\WPNTS_BaseController;

defined('ABSPATH') || die('Hey, what are you doing here? You silly human!');
/**
 * WPNTS_Enqueue Class is used to enqueue ass assets.
 *
 * @since 1.0.0
 */
class WPNTS_Enqueue extends WPNTS_BaseController {
	/**
	 * Register Instance.
	 *
	 * @since  1.0.0
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'WPNTS_admin_enqueue' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'WPNTS_frondend_enqueue' ] );
	}
	/**
	 * This WPNTS_admin_enqueue function is used to enqueue.
	 *
	 * @param string $screen used to show the current screen path.
	 * @since  1.0.0
	 */
	public function WPNTS_admin_enqueue( $screen ) {
		/**
		 * WPNTS admin-all screen loaded file.
		 */
		if ( 'toplevel_page_wpnts_notifier' == $screen || 'notifier_page_wpnts_notifier_setting' == $screen || 'notifier_page_wpnts_notifier_authors' == $screen ) {
			wp_enqueue_style( 'wpnts_main_scss_style', $this->plugin_url . 'build/index.css',[], time(),'all' );
			wp_enqueue_script( 'wcs_smtp_js', $this->plugin_url . 'assets/js/smtp.js',[ 'jquery' ],1.0,true );

			/**
			 * Main Script enqueue here
			 */
			wp_enqueue_script( 'wpnts_min_js', $this->plugin_url . 'build/index.js',[ 'jquery', 'wp-element' ], time(),true );
			wp_localize_script('wpnts_min_js', 'appLocalizer', [
				'wpntsUrl' => home_url( '/wp-json' ),
				'nonce' => wp_create_nonce( 'wp_rest'),
			] );
			wp_enqueue_script('wpnts_min_js');

		}

	}

	/**
	 * WPNTS public-all screen loaded file.
	 */
	public function WPNTS_frondend_enqueue() {
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