<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;

$can_unistall = false;

if ( is_multisite() ) {
	$can_unistall = get_site_option( 'wbcr_clearfy_complete_uninstall' );
} else {
	$can_unistall = get_option( 'wbcr_clearfy_complete_uninstall' );
}

if ( ! $can_unistall ) {
	return;
}

require_once ABSPATH . '/wp-admin/includes/plugin.php';

/**
 * Удаление кеша и опций
 */
function uninstall() {
	// remove plugin options
	global $wpdb;
	
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name = 'factory_plugin_activated_wbcr_clearfy';" );
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wbcr-clearfy_%';" );
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wbcr_clearfy_%';" );
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wbcr_wp_term_%';" );
	$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key='wbcr_wp_old_slug';" );
	
	$dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	
	if ( in_array( 'wbcr_clearfy_settings_pointer_1_4_2', $dismissed_pointers ) ) {
		$key = array_search( 'wbcr_clearfy_settings_pointer_1_4_2', $dismissed_pointers );
		if ( isset( $dismissed_pointers[ $key ] ) ) {
			unset( $dismissed_pointers[ $key ] );
			if ( ! empty( $dismissed_pointers ) ) {
				update_user_meta( get_current_user_id(), 'dismissed_wp_pointers', implode( ',', $dismissed_pointers ) );
			} else {
				delete_user_meta( get_current_user_id(), 'dismissed_wp_pointers' );
			}
		}
	}
}

if ( is_multisite() ) {
	global $wpdb, $wp_version;
	
	$wpdb->query( "DELETE FROM {$wpdb->sitemeta} WHERE meta_key LIKE 'wbcr_clearfy_%';" );
	
	$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	
	if ( ! empty( $blogs ) ) {
		foreach ( $blogs as $id ) {
			
			switch_to_blog( $id );
			
			uninstall();
			
			restore_current_blog();
		}
	}
} else {
	uninstall();
}

$package_plugin_basename = 'clearfy_package/clearfy-package.php';

if ( is_plugin_active( $package_plugin_basename ) ) {
	if ( is_multisite() && is_plugin_active_for_network( $package_plugin_basename ) ) {
		deactivate_plugins( $package_plugin_basename, false, true );
	} else {
		deactivate_plugins( $package_plugin_basename );
	}
}

delete_plugins( array( $package_plugin_basename ) );

//todo: добавить функции очистки для компонентов