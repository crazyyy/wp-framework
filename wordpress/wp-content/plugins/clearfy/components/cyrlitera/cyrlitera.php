<?php
/**
 * Plugin Name: Webcraftic Cyrlitera – transliteration of links and file names
 * Plugin URI: https://wordpress.org/plugins/cyrlitera/
 * Description: The plugin converts Cyrillic, Georgian links, filenames into Latin. It is necessary for correct work of WordPress plugins and improve links readability.
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.1.7
 * Text Domain: cyrlitera
 * Domain Path: /languages/
 * Author URI: http://clearfy.pro
 * Framework Version: FACTORY_409_VERSION
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WCTR_PLUGIN_VERSION' ) ) {
	define( 'WCTR_PLUGIN_VERSION', '1.0.6' );
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

if ( ! defined( 'WCTR_PLUGIN_DIR' ) ) {
	define( 'WCTR_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'WCTR_PLUGIN_BASE' ) ) {
	define( 'WCTR_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'WCTR_PLUGIN_URL' ) ) {
	define( 'WCTR_PLUGIN_URL', plugins_url( null, __FILE__ ) );
}



if ( ! defined( 'LOADING_CYRLITERA_AS_ADDON' ) ) {
	require_once( WCTR_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php' );
	require_once( WCTR_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php' );
}

$plugin_info = array(
	'prefix'         => 'wbcr_cyrlitera_',
	'plugin_name'    => 'wbcr_cyrlitera',
	'plugin_title'   => __( 'Webcraftic Cyrlitera', 'cyrlitera' ),
	'plugin_version' => WCTR_PLUGIN_VERSION,
	'plugin_build'   => 'free',
	'updates'        => WCTR_PLUGIN_DIR . '/updates/'
);

/**
 * Проверяет совместимость с Wordpress, php и другими плагинами.
 */
$compatibility = new Wbcr_FactoryClearfy_Compatibility( array_merge( $plugin_info, array(
	'factory_version'                  => 'FACTORY_409_VERSION',
	'plugin_already_activate'          => defined( 'WCTR_PLUGIN_ACTIVE' ),
	'plugin_as_component'              => defined( 'LOADING_CYRLITERA_AS_ADDON' ),
	'plugin_dir'                       => WCTR_PLUGIN_DIR,
	'plugin_base'                      => WCTR_PLUGIN_BASE,
	'plugin_url'                       => WCTR_PLUGIN_URL,
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

define( 'WCTR_PLUGIN_ACTIVE', true );

if ( ! defined( 'LOADING_CYRLITERA_AS_ADDON' ) ) {
	require_once( WCTR_PLUGIN_DIR . '/libs/factory/core/boot.php' );
}

require_once( WCTR_PLUGIN_DIR . '/includes/class.helpers.php' );
require_once( WCTR_PLUGIN_DIR . '/includes/class.plugin.php' );

if ( ! defined( 'LOADING_CYRLITERA_AS_ADDON' ) ) {
	new WCTR_Plugin( __FILE__, $plugin_info );
}
