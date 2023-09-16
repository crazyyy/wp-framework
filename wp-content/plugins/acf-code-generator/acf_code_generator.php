<?php
/*
Plugin Name: acf Code Generator
Plugin URI: https://tutsocean.com/acf-code-generator/
Description: Generates code for ACF fields. Just copy the code and paste in theme or plugin.
Version: 1.0.2
Author: Deepak Anand
Author URI: https://tutsocean.com/about-me
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {
	
	if ( ! class_exists( 'ACFCG_Core' ) ) {

		defined( 'ACFCG_PLUGIN_VERSION' ) or define( 'ACFCG_PLUGIN_VERSION', '1.0.2' );
		defined( 'ACFCG_PLUGIN_DIR_PATH' ) or define( 'ACFCG_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
		defined( 'ACFCG_PLUGIN_DIR_URL' ) or define( 'ACFCG_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
		defined( 'ACFCG_PLUGIN_BASENAME' ) or define( 'ACFCG_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		defined( 'ACFCG_PLUGIN_FILE' ) or define( 'ACFCG_PLUGIN_FILE', __FILE__ );

		// Classes
		include('core/ACFCG_core.php');
		include('core/ACFCG_locations.php');
		include('core/ACFCG_group.php');
		include('core/ACFCG_field.php');
		// Single function for accessing plugin core instance
		function acftc() {
			static $instance;
			if ( !$instance )
				$instance = new ACFCG_Core(); 
			return $instance;
		}
		acftc();
	} else {
		include('core/ACFCG_Conflict.php');
		new ACFCG_Conflict;
	}
}