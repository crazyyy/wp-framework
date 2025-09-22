<?php

/**
 * Don't want to show the settings in the plugins list
 *
 * @since 3.1.0
 * @return bool
 */
function cf7apps__is_cf7_active() {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	return is_plugin_active( 'contact-form-7/wp-contact-form-7.php' );
}

if ( ! cf7apps__is_cf7_active() ) {
	return;
}


if ( ! defined( 'ABSPATH' ) ) exit;

if ( defined( 'WPCF7_VERSION' ) ) {
	define( 'CF7APPS_WPCF7_VERSION', WPCF7_VERSION );
} else {
	$path_to_cf7 = WP_PLUGIN_DIR . '/' . CF7APPS_DEP_PLUGIN;
	if ( file_exists( $path_to_cf7 ) ) {
		$cf7_plugin_data = get_file_data($path_to_cf7, array('Version' => 'Version'), 'plugin');
	}

	if ( ! empty( $cf7_plugin_data['Version'] ) ) {
		define( 'CF7APPS_WPCF7_VERSION', $cf7_plugin_data['Version'] );
	} else {
		define( 'CF7APPS_WPCF7_VERSION', '0.0.0' );
	}
}

require_once 'includes/honeypot4cf7-admin.php';
require_once 'includes/honeypot4cf7.php';