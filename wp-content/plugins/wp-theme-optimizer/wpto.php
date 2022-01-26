<?php

/**
 *
 * @link              https://www.designsbytouch.co.uk
 * @since             1.0.0
 * @package           Wp_Theme_Optimizer
 *
 * @wordpress-plugin
 * Plugin Name:       WP Theme Optimizer
 * Plugin URI:        www.themeoptimizer.io
 * Description:       Optimize your WordPress theme header by removing excess tags and scripts. Make your site faster and more secure by hiding WordPress tags.
 * Version:           1.1.4
 * Author:            Studio Touch (Daniel Hand)
 * Author URI:        https://www.designsbytouch.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-theme-optimizer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpto-activator.php
 */
function activate_wpto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpto-activator.php';
	wpto_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpto-deactivator.php
 */
function deactivate_wpto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpto-deactivator.php';
	wpto_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpto' );
register_deactivation_hook( __FILE__, 'deactivate_wpto' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpto.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpto() {

	$plugin = new wpto();
	$plugin->run();

}
run_wpto();
