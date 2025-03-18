<?php
/*
Plugin Name: 	SVG Support
Plugin URI:		http://wordpress.org/plugins/svg-support/
Description: 	Upload SVG files to the Media Library and render SVG files inline for direct styling/animation of an SVG's internal elements using CSS/JS.
Version: 		2.5.14
Author URI: 	https://benbodhi.com
Text Domain: 	svg-support
Domain Path:	/languages
License: 		GPLv2 or later
License URI:	http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 5.8
Requires PHP: 	7.4
Block: 			true

	Copyright 2013 and beyond | Benbodhi (email : wp@benbodhi.com)

*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Global variables and constants
 */
global $bodhi_svgs_options;
$bodhi_svgs_options = array();                                     // Defining global array
define('BODHI_SVGS_VERSION', get_file_data(__FILE__, array('Version' => 'Version'))['Version']);
define('BODHI_SVGS_PLUGIN_FILE', __FILE__);                        // define the absolute plugin file path
define('BODHI_SVGS_PLUGIN_PATH', plugin_dir_path(__FILE__));       // define the absolute plugin path for includes
define('BODHI_SVGS_PLUGIN_URL', plugin_dir_url(__FILE__));         // define the plugin url for use in enqueue
$bodhi_svgs_options = get_option('bodhi_svgs_settings', array());  // Retrieve our plugin settings

// ensure $bodhi_svgs_options is always an array
if (!is_array($bodhi_svgs_options)) {
	$bodhi_svgs_options = [];
	update_option('bodhi_svgs_settings', $bodhi_svgs_options);
}

/**
 * SVG Sanitizer class
 */
// init svg sanitizer for usage
use enshrined\svgSanitize\Sanitizer;
// svg sanitizer
include( BODHI_SVGS_PLUGIN_PATH . 'vendor/autoload.php' );
// interfaces to enable custom whitelisting of svg tags and attributes
include( BODHI_SVGS_PLUGIN_PATH . 'includes/svg-tags.php' );
include( BODHI_SVGS_PLUGIN_PATH . 'includes/svg-attributes.php' );
// initialize sanitizer
$sanitizer = new Sanitizer();

/**
 * Includes - keeping it modular
 */
include( BODHI_SVGS_PLUGIN_PATH . 'admin/admin-init.php' );					// initialize admin menu & settings page
include( BODHI_SVGS_PLUGIN_PATH . 'admin/plugin-action-meta-links.php' );	// add links to the plugin on the plugins page
include( BODHI_SVGS_PLUGIN_PATH . 'functions/mime-types.php' );				// setup mime types support for SVG (with fix for WP 4.7.1 - 4.7.2)
include( BODHI_SVGS_PLUGIN_PATH . 'functions/thumbnail-display.php' );		// make SVG thumbnails display correctly in media library
include( BODHI_SVGS_PLUGIN_PATH . 'functions/attachment.php' );				// make SVG thumbnails display correctly in attachment modals and generate attachment sizes
include( BODHI_SVGS_PLUGIN_PATH . 'functions/enqueue.php' );				// enqueue js & css for inline replacement & admin
include( BODHI_SVGS_PLUGIN_PATH . 'functions/localization.php' );			// setup localization & languages
include( BODHI_SVGS_PLUGIN_PATH . 'functions/attribute-control.php' );		// auto set SVG class & remove dimensions during insertion
include( BODHI_SVGS_PLUGIN_PATH . 'functions/featured-image.php' );			// allow inline SVG for featured images
include( BODHI_SVGS_PLUGIN_PATH . 'functions/meta-cleanup.php' );			// cleanup duplicate meta entries

// Include WP All Import integration only if WP All Import is active
// if ( defined( 'PMXI_VERSION' ) ) {
// 	include( BODHI_SVGS_PLUGIN_PATH . 'integrations/wp-all-import.php' );
// }

/**
 * Handle version updates and migrations
 * 
 * Handles version comparisons for all format types:
 * - Single digit versions (1, 2)
 * - Zero versions (0, 0.1, 0.5.26)
 * - Two-digit versions (1.0, 2.1, 2.5)
 * - Three-digit versions (1.5.17, 2.5.9)
 * - Fresh installs ('0.0.0')
 * - Legacy versions (null, empty, invalid)
 */
function bodhi_svgs_version_updates() {
    $stored_version = get_option('bodhi_svgs_plugin_version', '0.0.0');
    
    if (!is_string($stored_version) || empty($stored_version)) {
        $stored_version = '0.0.0';
    }
    
    // Skip if already at current version
    if ($stored_version === BODHI_SVGS_VERSION) {
        return;
    }
    
    // Store the old version for comparison
    $old_version = $stored_version;
    
    // Update to current version
    update_option('bodhi_svgs_plugin_version', BODHI_SVGS_VERSION);
    
    // If coming from before 2.5.14, run cleanup
    if (version_compare($old_version, '2.5.14', '<')) {
        require_once BODHI_SVGS_PLUGIN_PATH . 'functions/meta-cleanup.php';
        bodhi_svgs_cleanup_duplicate_meta();
    }
}
add_action('admin_init', 'bodhi_svgs_version_updates');

/**
 * Defaults for better security in versions >= 2.5
 */
// Enable 'sanitize_svg_front_end' by default
if ( !isset($bodhi_svgs_options['sanitize_svg_front_end']) ) {
	$bodhi_svgs_options['sanitize_svg_front_end'] = 'on';
	update_option( 'bodhi_svgs_settings', $bodhi_svgs_options );
}

// Allow only admins to upload SVGs by default
if ( !isset($bodhi_svgs_options['restrict']) || $bodhi_svgs_options['restrict'] == "on" ) {
	$bodhi_svgs_options['restrict'] = array('administrator');
	update_option( 'bodhi_svgs_settings', $bodhi_svgs_options );
}
elseif (isset($bodhi_svgs_options['restrict']) && $bodhi_svgs_options['restrict'] == "none" ) {
	$bodhi_svgs_options['restrict'] = array("none");
	update_option( 'bodhi_svgs_settings', $bodhi_svgs_options );
}

// By default sanitize on upload for everyone (no bypass roles)
if ( !isset($bodhi_svgs_options['sanitize_on_upload_roles']) ) {
	$bodhi_svgs_options['sanitize_on_upload_roles'] = array();
	update_option( 'bodhi_svgs_settings', $bodhi_svgs_options );
}
elseif ( isset($bodhi_svgs_options['sanitize_on_upload_roles']) && $bodhi_svgs_options['sanitize_on_upload_roles'] == "none") {
	$bodhi_svgs_options['sanitize_on_upload_roles'] = array("none");
	update_option( 'bodhi_svgs_settings', $bodhi_svgs_options );
}

/**
 * Register activation and deactivation hooks
 */
// Activation Hook
function bodhi_svgs_plugin_activation() {
    bodhi_svgs_remove_old_sanitize_setting();
}
register_activation_hook(__FILE__, 'bodhi_svgs_plugin_activation');

// Deactivation Hook
function bodhi_svgs_plugin_deactivation() {
    bodhi_svgs_remove_old_sanitize_setting();
}
register_deactivation_hook(__FILE__, 'bodhi_svgs_plugin_deactivation');
