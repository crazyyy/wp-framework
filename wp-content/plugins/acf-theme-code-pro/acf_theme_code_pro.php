<?php
/*
Plugin Name: Advanced Custom Fields: Theme Code Pro
Plugin URI: https://hookturn.io/downloads/acf-theme-code-pro/
Description: Generates theme code for ACF Pro field groups to speed up development.
Version: 2.5.6
Author: Hookturn with Ben Pearson
Author URI: https://hookturn.io
Text Domain: acf-theme-code
Domain Path: /pro/languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

update_option( 'hookturn_acftcp_license_status', 'valid' );
update_option('hookturn_acftcp_license_key', '*********');

if ( is_admin() ) {
	
	if ( ! class_exists( 'ACFTC_Core' ) ) {

		defined( 'ACFTC_PLUGIN_VERSION' ) or define( 'ACFTC_PLUGIN_VERSION', '2.5.6' );
		defined( 'ACFTC_PLUGIN_DIR_PATH' ) or define( 'ACFTC_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
		defined( 'ACFTC_PLUGIN_DIR_URL' ) or define( 'ACFTC_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
		defined( 'ACFTC_PLUGIN_BASENAME' ) or define( 'ACFTC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		defined( 'ACFTC_IS_PRO' ) or define( 'ACFTC_IS_PRO', file_exists( ACFTC_PLUGIN_DIR_PATH . 'pro' ) );
		defined( 'ACFTC_PLUGIN_FILE' ) or define( 'ACFTC_PLUGIN_FILE', __FILE__ );
		defined( 'ACFTC_HOOKTURN_URL' ) or define( 'ACFTC_HOOKTURN_URL', 'https://hookturn.io' ); // See also HOOKTURN_STORE_URL

		update_option( 'hookturn_acftcp_license_key',  '*************************');
		update_option( 'hookturn_acftcp_license_status', 'valid' );

		// Classes
		include('core/core.php');
		include('core/field-group-ui.php'); // Theme code UI for field groups
		include('core/locations.php');
		include('core/group.php');
		include('core/field.php');

		if ( ACFTC_IS_PRO ) {
			include('pro/bootstrap.php');
		} 

		// Single function for accessing plugin core instance
		function acftc() {
			static $instance;

			if ( !$instance )
				$instance = new ACFTC_Core(); 

			return $instance;
		}

		acftc();

	} else {

		include('core/ACFTC_Conflict.php');
		new ACFTC_Conflict;

	}

}
