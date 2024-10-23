<?php
/**
 * Enqueue scripts and styles
 * This file is to enqueue the scripts and styles both admin and front end
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue the admin CSS using screen check functions
 */
function bodhi_svgs_admin_css() {
	global $svgs_plugin_version;

	// Check if user is on SVG Support settings page or media library page
	if ( bodhi_svgs_specific_pages_settings() || bodhi_svgs_specific_pages_media_library() ) {
		wp_enqueue_style( 'bodhi-svgs-admin', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin.css', array(), $svgs_plugin_version );
	}

	// Check if user is on SVG Support settings page and not in "Advanced Mode"
	if ( bodhi_svgs_specific_pages_settings() && ! bodhi_svgs_advanced_mode() ) {
		wp_enqueue_style( 'bodhi-svgs-admin-simple-mode', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin-simple-mode.css', array(), $svgs_plugin_version );
	}

	// Check if user is on an edit post page
	if ( bodhi_svgs_is_edit_page() ) {
		wp_enqueue_style( 'bodhi-svgs-admin-edit-post', BODHI_SVGS_PLUGIN_URL . 'css/svgs-admin-edit-post.css', array(), $svgs_plugin_version );
	}
}
add_action( 'admin_enqueue_scripts', 'bodhi_svgs_admin_css' );

/*
 * Enqueue multiselect for settings page only
 */
function bodhi_svgs_admin_multiselect() {
	global $svgs_plugin_version;

	// Ensure multiselect is only loaded on the settings page
	if ( bodhi_svgs_specific_pages_settings() ) {
		wp_enqueue_style( 'CSS-for-multiselect', BODHI_SVGS_PLUGIN_URL . 'css/jquery.dropdown-min.css', array(), $svgs_plugin_version );
		wp_enqueue_script( 'js-for-multiselect', BODHI_SVGS_PLUGIN_URL . 'js/min/jquery.dropdown-min.js', array( 'jquery' ), $svgs_plugin_version, true );

		wp_add_inline_script( 'js-for-multiselect', 'jQuery(document).ready(function(){jQuery(".upload_allowed_roles").dropdown({multipleMode: "label",input: \'<input type="text" maxLength="20" placeholder="Search">\',searchNoData: \'<li style="color:#ddd">No Results</li>\'});});', 'after' );
		wp_add_inline_script( 'js-for-multiselect', 'jQuery(document).ready(function(){jQuery(".sanitize_on_upload_roles").dropdown({multipleMode: "label",input: \'<input type="text" maxLength="20" placeholder="Search">\',searchNoData: \'<li style="color:#ddd">No Results</li>\'});});', 'after' );
	}
}
add_action( 'admin_enqueue_scripts', 'bodhi_svgs_admin_multiselect' );

/**
 * Enqueue Block editor JS
 */
function bodhi_svgs_block_editor() {
	global $svgs_plugin_version;

	if ( bodhi_svgs_advanced_mode() ) {
		wp_enqueue_script( 'bodhi-svgs-gutenberg-filters', BODHI_SVGS_PLUGIN_URL . '/js/gutenberg-filters.js', ['wp-edit-post'], $svgs_plugin_version, true );
	}
}
add_action( 'enqueue_block_editor_assets', 'bodhi_svgs_block_editor' );

/**
 * Enqueue frontend CSS
 */
function bodhi_svgs_frontend_css() {
	global $bodhi_svgs_options;
	global $svgs_plugin_version;

	if ( ! empty( $bodhi_svgs_options['frontend_css'] ) ) {
		wp_enqueue_style( 'bodhi-svgs-attachment', BODHI_SVGS_PLUGIN_URL . 'css/svgs-attachment.css', array(), $svgs_plugin_version );
	}
}
add_action( 'wp_enqueue_scripts', 'bodhi_svgs_frontend_css' );

/**
 * Enqueue frontend JS
 */
function bodhi_svgs_frontend_js() {
	global $bodhi_svgs_options;
	global $svgs_plugin_version;

	if ( ! empty( $bodhi_svgs_options['sanitize_svg_front_end'] ) && $bodhi_svgs_options['sanitize_svg_front_end'] === 'on' && bodhi_svgs_advanced_mode() === true ) {
		$bodhi_svgs_js_footer = ! empty( $bodhi_svgs_options['js_foot_choice'] );
		wp_enqueue_script( 'bodhi-dompurify-library', BODHI_SVGS_PLUGIN_URL . 'vendor/DOMPurify/DOMPurify.min.js', array(), '1.0.1', $bodhi_svgs_js_footer );
	}
}
add_action( 'wp_enqueue_scripts', 'bodhi_svgs_frontend_js', 9 );

/**
 * Enqueue and localize JS for IMG tag replacement
 */
function bodhi_svgs_inline() {
	global $bodhi_svgs_options;
	global $svgs_plugin_version;

	if ( bodhi_svgs_advanced_mode() ) {
		$force_inline_svg_active = ! empty( $bodhi_svgs_options['force_inline_svg'] ) ? 'true' : 'false';

		if ( ! empty( $bodhi_svgs_options['css_target'] ) ) {
			$css_target_array = array(
				'Bodhi' => 'img.' . esc_attr( $bodhi_svgs_options['css_target'] ),
				'ForceInlineSVG' => esc_attr( $bodhi_svgs_options['css_target'] )
			);
		} else {
			$css_target_array = array(
				'Bodhi' => 'img.style-svg',
				'ForceInlineSVG' => 'style-svg'
			);
		}

		if ( ! empty( $bodhi_svgs_options['use_expanded_js'] ) ) {
			$bodhi_svgs_js_folder = '';
			$bodhi_svgs_js_file = '';
		} else {
			$bodhi_svgs_js_folder = 'min/';
			$bodhi_svgs_js_file = '-min';
		}

		$bodhi_svgs_js_footer = ! empty( $bodhi_svgs_options['js_foot_choice'] );
		$bodhi_svgs_js_vanilla = ! empty( $bodhi_svgs_options['use_vanilla_js'] ) ? '-vanilla' : '';

		$bodhi_svgs_js_path = 'js/' . $bodhi_svgs_js_folder . 'svgs-inline' . $bodhi_svgs_js_vanilla . $bodhi_svgs_js_file . '.js';

		wp_register_script( 'bodhi_svg_inline', BODHI_SVGS_PLUGIN_URL . $bodhi_svgs_js_path, array( 'jquery' ), $svgs_plugin_version, $bodhi_svgs_js_footer );
		wp_enqueue_script( 'bodhi_svg_inline' );

		wp_add_inline_script(
			'bodhi_svg_inline',
			sprintf(
				'cssTarget=%s;ForceInlineSVGActive=%s;frontSanitizationEnabled=%s;',
				wp_json_encode( $css_target_array ),
				wp_json_encode( $force_inline_svg_active ),
				wp_json_encode( $bodhi_svgs_options['sanitize_svg_front_end'] )
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bodhi_svgs_inline' );