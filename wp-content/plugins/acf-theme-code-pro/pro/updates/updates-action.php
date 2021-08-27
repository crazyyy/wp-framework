<?php
// update functionality
function hookturn_acftcp_plugin_updater() {

	if( !class_exists( 'ACFTCP_Plugin_Updater' ) ) {
		// load our custom updater
		include('ACFTCP_Plugin_Updater.php' ); // TODO Add constant to this path
	}

	// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
	define( 'HOOKTURN_STORE_URL', 'https://hookturn.io' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

	// the name of your product. This should match the download name in EDD exactly
	define( 'HOOKTURN_ITEM_NAME', 'ACF Theme Code Pro' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'hookturn_acftcp_license_key' ) );

	// setup the updater
	$edd_updater = new ACFTCP_Plugin_Updater( HOOKTURN_STORE_URL, ACFTC_PLUGIN_FILE, array(
			'version' 	=> ACFTC_PLUGIN_VERSION, // current version number
			'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
			'item_name' => HOOKTURN_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'hookturn',  		// author of this plugin
			'wp_override' => true
		)
	);

}
add_action( 'admin_init', 'hookturn_acftcp_plugin_updater', 0 );