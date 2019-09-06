<?php

/**
 * This class configures the code cleanup settings
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_ConfigPrivacy extends Wbcr_FactoryClearfy206_Configurate {

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

	public function registerActionsAndFilters() {
		if ( ! is_admin() ) {
			if ( $this->getPopulateOption( 'remove_meta_generator' ) ) {
				// Clean meta generator for Woocommerce
				if ( class_exists( 'WooCommerce' ) ) {
					remove_action( 'wp_head', 'woo_version' );
				}

				// Clean meta generator for SitePress
				if ( class_exists( 'SitePress' ) ) {
					global $sitepress;
					remove_action( 'wp_head', [ $sitepress, 'meta_generator_tag' ] );
				}

				// Clean meta generator for Wordpress core
				remove_action( 'wp_head', 'wp_generator' );
				add_filter( 'the_generator', '__return_empty_string' );

				// Clean all meta generators
				add_action( 'wp_head', [ $this, 'clean_meta_generators' ], 100 );
			}

			if ( $this->getPopulateOption( 'remove_html_comments' ) ) {
				add_action( 'wp_loaded', [ $this, 'clean_html_comments' ] );
			}
		}
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.5.3
	 */
	public function clean_meta_generators() {
		ob_start( [ $this, 'replace_meta_generators' ] );
	}

	/**
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 */
	public function clean_html_comments() {
		ob_start( [ $this, 'replace_html_comments' ] );
	}

	/**
	 * Replace <meta .* name="generator"> like tags
	 * which may contain versioning of
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.5.3
	 *
	 * @param $html
	 *
	 * @return string|string[]|null
	 */
	public function replace_meta_generators( $html ) {
		$raw_html = $html;

		$pattern = '/<meta[^>]+name=["\']generator["\'][^>]+>/i';
		$html    = preg_replace( $pattern, '', $html );

		// If replacement is completed with an error, user will receive a white screen.
		// We have to prevent it.
		if ( empty( $html ) ) {
			return $raw_html;
		}

		return $html;
	}

	/**
	 * !ngg_resource - can not be deleted, otherwise the plugin nextgen gallery will not work
	 *
	 * @param string $data
	 *
	 * @return mixed
	 */
	public function replace_html_comments( $html ) {
		$raw_html = $html;

		//CLRF-166 issue fix bug with noindex (\s?\/?noindex)
		$html = preg_replace( '#<!--(?!<!|\s?ngg_resource|\s?\/?noindex)[^\[>].*?-->#s', '', $html );

		// If replacement is completed with an error, user will receive a white screen.
		// We have to prevent it.
		if ( empty( $html ) ) {
			return $raw_html;
		}

		return $html;
	}
}