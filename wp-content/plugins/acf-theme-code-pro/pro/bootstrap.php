<?php

// Core classes
include( ACFTC_PLUGIN_DIR_PATH . 'pro/core/locations.php');
include( ACFTC_PLUGIN_DIR_PATH . 'pro/core/field.php');
include( ACFTC_PLUGIN_DIR_PATH . 'pro/core/flexible-content-layout.php');

// Plugins page
include( ACFTC_PLUGIN_DIR_PATH . 'pro/core/settings-link.php');

// Updates and licensing
define( 'HOOKTURN_STORE_URL', 'https://hookturn.io' ); 
define( 'HOOKTURN_ITEM_ID', 15 );
define( 'HOOKTURN_ITEM_NAME', 'ACF Theme Code Pro' ); 
define( 'HOOKTURN_ACFTCP_LICENSE_PAGE', 'theme-code-pro-license' );

if( ! class_exists( 'Hookturn_ACFTCP_Plugin_Updater' ) ) {
	// include( dirname( __FILE__ ) . '/Hookturn_ACFTCP_Plugin_Updater.php' );
    include( ACFTC_PLUGIN_DIR_PATH . 'pro/updates/Hookturn_ACFTCP_Plugin_Updater.php');
}

include( ACFTC_PLUGIN_DIR_PATH . 'pro/updates/updater-actions.php');
include( ACFTC_PLUGIN_DIR_PATH . 'pro/updates/settings-page.php');