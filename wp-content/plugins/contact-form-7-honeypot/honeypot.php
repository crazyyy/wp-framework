<?php
/**
 * Plugin Name: CF7 Apps
 * Plugin URI: https://cf7apps.com/
 * Description: Contact Form 7 Apps is a collection of useful modules and extensions for Contact Form 7.
 * Author: CF7Apps
 * Author URI: https://wpexperts.io/
 * Version: 3.1.0
 * Text Domain: contact-form-7-honeypot
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

define( 'CF7APPS_VERSION', '3.1.0' );
define( 'CF7APPS_PLUGIN', __FILE__ );
define( 'CF7APPS_PLUGIN_BASENAME', plugin_basename( CF7APPS_PLUGIN ) );
define( 'CF7APPS_PLUGIN_NAME', trim( dirname( CF7APPS_PLUGIN_BASENAME ), '/' ) );
define( 'CF7APPS_PLUGIN_DIR', untrailingslashit( dirname( CF7APPS_PLUGIN ) ) );
define( 'CF7APPS_PLUGIN_DIR_URL', untrailingslashit( plugin_dir_url( CF7APPS_PLUGIN ) ) );
define( 'CF7APPS_DEP_PLUGIN', 'contact-form-7/wp-contact-form-7.php' );

require_once CF7APPS_PLUGIN_DIR . '/includes/class-cf7apps.php';

// Legacy Honeypot
require_once CF7APPS_PLUGIN_DIR . '/legacy-honeypot/legacy-honeypot.php';

/**
 * Initialize Contact Form 7 Apps
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'CF7Apps' ) ):
function CF7Apps() {
	/**
	 * Fires before Contact Form 7 Apps is initialized
	 * 
	 * @since 3.0.0
	 */
	do_action( 'cf7apps_before_init' );

	$_class = CF7Apps::instance();

	/**
	 * Fires Contact Form 7 Apps is initialized
	 * 
	 * @since 3.0.0
	 */
	do_action( 'cf7apps_init' );

	return $_class;
}
endif;

CF7Apps();