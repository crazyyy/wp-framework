<?php
/**
 * Plugin Name: Webcraftic Local Google Analytics
 * Plugin URI: https://wordpress.org/plugins/simple-google-analytics/
 * Description: Old plugin name: Simple Google Analytics. To improve Google Page Speed indicators Analytics caching is needed. However, it can also slightly increase your website loading speed, because Analytics js files will load locally. The second case that you might need these settings is the usual Google Analytics connection to your website. You do not need to do this with other plugins or insert the tracking code into your theme.
 * Author: Webcraftic <wordpress.webraftic@gmail.com>, JeromeMeyer62<jerome.meyer@hollywoud.net>
 * Version: 3.0.2
 * Text Domain: simple-google-analytics
 * Domain Path: /languages/
 * Author URI: http://clearfy.pro
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'WGA_PLUGIN_VERSION' ) ) {
	define( 'WGA_PLUGIN_VERSION', '3.0.1' );
}

// Fix for ithemes sync. When the ithemes sync plugin accepts the request, set the WP_ADMIN constant,
// after which the plugin Clearfy begins to create errors, and how the logic of its work is broken.
// Solution to simply terminate the plugin if there is a request from ithemes sync
// --------------------------------------
if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'ithemes_sync_request' ) {
	return;
}

if ( isset( $_GET['ithemes-sync-request'] ) && ! empty( $_GET['ithemes-sync-request'] ) ) {
	return;
}
// ----------------------------------------

if ( ! defined( 'WGA_PLUGIN_DIR' ) ) {
	define( 'WGA_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'WGA_PLUGIN_BASE' ) ) {
	define( 'WGA_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'WGA_PLUGIN_URL' ) ) {
	define( 'WGA_PLUGIN_URL', plugins_url( null, __FILE__ ) );
}



if ( ! defined( 'LOADING_GA_CACHE_AS_ADDON' ) ) {
	require_once( WGA_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php' );
	require_once( WGA_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php' );
}

$plugin_info = array(
	'prefix'         => 'wbcr_gac_',
	'plugin_name'    => 'wbcr_gac',
	'plugin_title'   => __( 'Webcraftic Local Google Analytics', 'simple-google-analytics' ),
	'plugin_version' => WGA_PLUGIN_VERSION,
	'plugin_build'   => 'free',
	'updates'        => WGA_PLUGIN_DIR . '/updates/'
);

/**
 * Проверяет совместимость с Wordpress, php и другими плагинами.
 */
$compatibility = new Wbcr_FactoryClearfy_Compatibility( array_merge( $plugin_info, array(
	'factory_version'                  => 'FACTORY_409_VERSION',
	'plugin_already_activate'          => defined( 'WGA_PLUGIN_ACTIVE' ),
	'plugin_as_component'              => defined( 'LOADING_GA_CACHE_AS_ADDON' ),
	'plugin_dir'                       => WGA_PLUGIN_DIR,
	'plugin_base'                      => WGA_PLUGIN_BASE,
	'plugin_url'                       => WGA_PLUGIN_URL,
	'required_php_version'             => '5.3',
	'required_wp_version'              => '4.2.0',
	'required_clearfy_check_component' => true
) ) );

/**
 * Если плагин совместим, то он продолжит свою работу, иначе будет остановлен,
 * а пользователь получит предупреждение.
 */
if ( ! $compatibility->check() ) {
	return;
}

define( 'WGA_PLUGIN_ACTIVE', true );

if ( ! defined( 'LOADING_GA_CACHE_AS_ADDON' ) ) {
	require_once( WGA_PLUGIN_DIR . '/libs/factory/core/boot.php' );
}

require_once( WGA_PLUGIN_DIR . '/includes/class.plugin.php' );

if ( ! defined( 'LOADING_GA_CACHE_AS_ADDON' ) ) {
	new WGA_Plugin( __FILE__, $plugin_info );
}
	