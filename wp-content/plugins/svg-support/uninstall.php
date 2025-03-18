<?php if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$bodhi_options_on_deletion = get_option( 'bodhi_svgs_settings' );

if ( isset($bodhi_options_on_deletion[ 'del_plugin_data' ]) && $bodhi_options_on_deletion[ 'del_plugin_data' ] === 'on' ) {
    // Delete plugin options
    delete_option( 'bodhi_svgs_plugin_version' );
    delete_option( 'bodhi_svgs_settings' );
    
    // Delete all post meta related to SVG Support
    global $wpdb;
    $wpdb->delete($wpdb->postmeta, array('meta_key' => 'inline_featured_image'));
}