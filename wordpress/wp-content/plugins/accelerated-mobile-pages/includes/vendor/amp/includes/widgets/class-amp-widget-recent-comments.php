<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! class_exists('AMP_Widget_Recent_Comments') ) {
	class AMP_Widget_Recent_Comments extends WP_Widget_Recent_Comments {

		/**
		 * Instantiates the widget, and prevents inline styling.
		 *
		 * @since 0.7.0
		 */
		public function __construct() {
			parent::__construct();
			add_filter( 'wp_head', array( $this, 'remove_head_style_in_amp' ), 0 );
		}

		/**
		 * Prevent recent comments widget style from printing in AMP,
		 *
		 * @since 0.7.0
		 */
		public function remove_head_style_in_amp() {
			if ( false === get_query_var( AMP_QUERY_VAR, false ) ) {
			//if ( is_amp_endpoint() ) {
				add_filter( 'show_recent_comments_widget_style', '__return_false' );
			}
		}

	}
}