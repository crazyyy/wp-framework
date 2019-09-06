<?php
/**
 * Plugin Name: Webcraftic Updates manager
 * Plugin URI: https://wordpress.org/plugins/webcraftic-updates-manager/
 * Description: Manage all your WordPress updates, automatic updates, logs, and loads more.
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.0.8
 * Text Domain: webcraftic-updates-manager
 * Domain Path: /languages/
 * Author URI: https://clearfy.pro
 * Framework Version: FACTORY_409_VERSION
 */
if ( ! defined( 'WUPM_PLUGIN_VERSION' ) ) {
	define( 'WUPM_PLUGIN_VERSION', '1.0.8' );
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
if ( ! defined( 'WUPM_PLUGIN_DIR' ) ) {
	define( 'WUPM_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'WUPM_PLUGIN_BASE' ) ) {
	define( 'WUPM_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'WUPM_PLUGIN_URL' ) ) {
	define( 'WUPM_PLUGIN_URL', plugins_url( null, __FILE__ ) );
}



if ( ! defined( 'LOADING_UPDATES_MANAGER_AS_ADDON' ) ) {
	require_once( WUPM_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php' );
	require_once( WUPM_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php' );
}

$plugin_info = array(
	'prefix'         => 'wbcr_upm_',//wbcr_upm_
	'plugin_name'    => 'wbcr_updates_manager',
	'plugin_title'   => __( 'Webcraftic Updates Manager', 'webcraftic-updates-manager' ),
	'plugin_version' => WUPM_PLUGIN_VERSION,
	'plugin_build'   => 'free',
	//'updates' => WUPM_PLUGIN_DIR . '/updates/'
);

/**
 * Проверяет совместимость с Wordpress, php и другими плагинами.
 */
$compatibility = new Wbcr_FactoryClearfy_Compatibility( array_merge( $plugin_info, array(
	'factory_version'                  => 'FACTORY_409_VERSION',
	'plugin_already_activate'          => defined( 'WUPM_PLUGIN_ACTIVE' ),
	'plugin_as_component'              => defined( 'LOADING_UPDATES_MANAGER_AS_ADDON' ),
	'plugin_dir'                       => WUPM_PLUGIN_DIR,
	'plugin_base'                      => WUPM_PLUGIN_BASE,
	'plugin_url'                       => WUPM_PLUGIN_URL,
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

define( 'WUPM_PLUGIN_ACTIVE', true );

if ( ! defined( 'LOADING_UPDATES_MANAGER_AS_ADDON' ) ) {
	require_once( WUPM_PLUGIN_DIR . '/libs/factory/core/boot.php' );
}

require_once( WUPM_PLUGIN_DIR . '/includes/class.plugin.php' );

if ( ! defined( 'LOADING_UPDATES_MANAGER_AS_ADDON' ) ) {
	new WUPM_Plugin( __FILE__, $plugin_info );
}
