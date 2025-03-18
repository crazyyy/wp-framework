<?php
/**
 * Admin init
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add menu item to wp-admin
 */
function bodhi_svgs_admin_menu() {

	$bodhi_svgs_options_page = add_options_page(
		__('SVG Support Settings and Usage', 'svg-support'),
		__('SVG Support', 'svg-support'),
		'manage_options',
		'svg-support',
		'bodhi_svg_support_settings_page'
	);

	// load the help menu on the SVG Support settings page
	add_action( 'load-' . $bodhi_svgs_options_page, 'bodhi_svgs_help_tab' );

	require( BODHI_SVGS_PLUGIN_PATH . 'admin/svgs-settings-page-help.php' );

}
add_action( 'admin_menu', 'bodhi_svgs_admin_menu' );

/**
 * Create settings page
 */
function bodhi_svg_support_settings_page() {

	if ( ! current_user_can( 'manage_options' ) ) {

		wp_die( esc_html__('You can\'t play with this.', 'svg-support') );

	}

	$bodhi_svgs_options = get_option( 'bodhi_svgs_settings' );

	require( BODHI_SVGS_PLUGIN_PATH . 'admin/svgs-settings-page.php' );

}

/**
 * Sanitize and save settings
 */
function bodhi_svgs_settings_sanitize($input) {
	// Process all settings
	$output = $input;
	
	// Sanitize css_target
	if (isset($output['css_target'])) {
		$output['css_target'] = esc_attr( sanitize_text_field( $output['css_target'] ) );
	}

	// Handle sanitize_svg_front_end setting
	if (!isset($output['sanitize_svg_front_end']) || $output['sanitize_svg_front_end'] !== 'on') {
		$output['sanitize_svg_front_end'] = false;
	}

	// Handle sanitize_on_upload_roles setting
	if (!isset($output['sanitize_on_upload_roles'])) {
		$output['sanitize_on_upload_roles'] = array("none");
	} else {
		$output['sanitize_on_upload_roles'] = (array)$output['sanitize_on_upload_roles'];
	}

	// Handle restrict setting
	if (!isset($output['restrict'])) {
		$output['restrict'] = array("none");
	} else {
		$output['restrict'] = (array)$output['restrict'];
	}
	
	return $output;
}

/**
 * Register settings in the database
 */
function bodhi_svgs_register_settings() {

	$args = array(
		'sanitize_callback' => 'bodhi_svgs_settings_sanitize'
	);

	register_setting( 'bodhi_svgs_settings_group', 'bodhi_svgs_settings', $args );

}
add_action( 'admin_init', 'bodhi_svgs_register_settings' );

/**
 * Remove old sanitize setting
 */
function bodhi_svgs_remove_old_sanitize_setting() {
	// Fetch current settings
	$bodhi_svgs_options = get_option('bodhi_svgs_settings');

	// Remove the old 'sanitize_svg' setting if it exists
	if (isset($bodhi_svgs_options['sanitize_svg'])) {
		unset($bodhi_svgs_options['sanitize_svg']);
		update_option('bodhi_svgs_settings', $bodhi_svgs_options);
	}
}
add_action('admin_init', 'bodhi_svgs_remove_old_sanitize_setting');

/**
 * Advanced Mode Check
 * Creates a usable function for conditionals around the plugin
 */
function bodhi_svgs_advanced_mode() {

	global $bodhi_svgs_options;

	if ( ! empty( $bodhi_svgs_options['advanced_mode'] ) ) {

		return true;

	} else {

		return false;

	}

}
add_action( 'admin_init', 'bodhi_svgs_advanced_mode' );

/**
 * Screen check function
 * Checks if current page is SVG Support settings page
 */
function bodhi_svgs_specific_pages_settings() {

	// check current page
	$screen = get_current_screen();

	// check if we're on SVG Support settings page
	if ( is_object( $screen ) && $screen->id == 'settings_page_svg-support' ) {

		return true;

	} else {

		return false;

	}

}

/**
 * Screen check function
 * Checks if the current page is the Media Library page
 */
function bodhi_svgs_specific_pages_media_library() {

	// check current page
	$screen = get_current_screen();

	// check if we're on Media Library page
	if ( is_object( $screen ) && $screen->id == 'upload' ) {

		return true;

	} else {

		return false;

	}
}

/**
 * Screen check function
 * Check if the current page is a post edit page
 */
function bodhi_svgs_is_edit_page( $new_edit = null ) {

	global $pagenow;

	if ( ! is_admin() ) return false;

	if ( $new_edit == 'edit' ) {

		return in_array( $pagenow, array( 'post.php',  ) );

	} elseif ( $new_edit == "new" ) { //check for new post page

		return in_array( $pagenow, array( 'post-new.php' ) );

	} else { //check for either new or edit

		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );

	}

}

/**
 * Add rating text to footer on settings page
 */
function bodhi_svgs_admin_footer_text( $default ) {

	if ( bodhi_svgs_specific_pages_settings() || bodhi_svgs_specific_pages_media_library() ) {

		$strong_open = '<strong>';
		$strong_close = '</strong>';
		$link_open = '<a href="https://wordpress.org/support/view/plugin-reviews/svg-support?filter=5#postform" target="_blank" class="svgs-rating-link">';
		$link_close = '</a>';

		// translators: %1$s: Opening strong tag, %2$s: Closing strong tag, %3$s: Opening anchor tag for rating link, %4$s: Closing anchor tag
		$text = esc_html__( 'If you like %1$sSVG Support%2$s please leave a %3$s★★★★★%4$s rating. A huge thanks in advance!', 'svg-support' );

		echo wp_kses(
			sprintf( 
				$text,
				$strong_open,
				$strong_close,
				$link_open,
				$link_close
			),
			array(
				'strong' => array(),
				'a' => array(
					'href' => array(),
					'target' => array(),
					'class' => array()
				)
			)
		);

	} else {

		return $default;

	}

}
add_filter( 'admin_footer_text', 'bodhi_svgs_admin_footer_text' );