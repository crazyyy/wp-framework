<?php

/**
 * @link              https://ideastocode.com
 * @since             1.0.0
 * @package           Enable SVG, WebP, and ICO Upload
 *
 * @wordpress-plugin
 * Plugin Name:       Enable SVG, WebP, and ICO Upload
 * Plugin URI:        https://ideastocode.com/plugins/enable-svg-WebP-ico-upload/
 * Description:       This plugin will enable you to upload SVG, WebP & ICO files
 * Version:           1.0.3
 * Author:            ideasToCode
 * Author URI:        http://ideastocode.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       enable-svg-webp-ico-upload
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ITC_SVG_UPLOAD_VERSION', '1.0.1' );
if ( ! defined( 'ITC_SVG_UPLOAD_BASENAME' ) ) {
	define( 'ITC_SVG_UPLOAD_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'ITC_SVG_UPLOAD_PLUGIN_DIR_PATH' ) ) {
	define( 'ITC_SVG_UPLOAD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'ITC_SVG_UPLOAD_PLUGIN_DIR_URL' ) ) {
	define( 'ITC_SVG_UPLOAD_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

require_once ITC_SVG_UPLOAD_PLUGIN_DIR_PATH . 'includes/BaseController.php';

function activate_itc_svg_upload() {
	require_once ITC_SVG_UPLOAD_PLUGIN_DIR_PATH . 'includes/class-activator.php';
	$objActivator = new ITC_SVG_Upload_Activator();
	$objActivator->activate();
}

function deactivate_itc_svg_upload() {
	require_once ITC_SVG_UPLOAD_PLUGIN_DIR_PATH . 'includes/class-deactivator.php';
	$objDeactivator = new ITC_SVG_Upload_Deactivator();
	$objDeactivator->deactivate();
}

function run_itc_svg_upload() {
	require_once ITC_SVG_UPLOAD_PLUGIN_DIR_PATH . 'includes/class-itc.php';
	$plugin = new ITC_SVG_Upload();
	$plugin->run();
}

register_activation_hook( __FILE__, 'activate_itc_svg_upload' );
register_deactivation_hook( __FILE__, 'deactivate_itc_svg_upload' );
run_itc_svg_upload();
