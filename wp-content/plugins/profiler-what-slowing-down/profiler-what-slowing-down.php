<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://swit.hr
 * @since             1.0.0
 * @package           Which_Plugin_Slowing_Down
 *
 * @wordpress-plugin
 * Plugin Name:       Profiler - What Slowing Down Your WP
 * Plugin URI:        https://swit.hr#profiler-what-slowing-down
 * Description:       Our Plugin Performance Profiler will help you to detect Which Plugin is Slowing Down your WordPress website and what may help you to increase performance dramatically
 * Version:           1.0.0
 * Author:            SWIT, Sandi Winter
 * Author URI:        https://swit.hr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       profiler-what-slowing-down
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WHICH_PLUGIN_SLOWING_DOWN_VERSION', '1.0.0' );
define( 'WHICH_PLUGIN_SLOWING_DOWN_VERSION_NAME', 'wpsd' );
define( 'WHICH_PLUGIN_SLOWING_DOWN_VERSION_PATH', plugin_dir_path( __FILE__ ) );
define( 'WHICH_PLUGIN_SLOWING_DOWN_VERSION_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-which-plugin-slowing-down-activator.php
 */
function activate_which_plugin_slowing_down() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-which-plugin-slowing-down-activator.php';
	Which_Plugin_Slowing_Down_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-which-plugin-slowing-down-deactivator.php
 */
function deactivate_which_plugin_slowing_down() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-which-plugin-slowing-down-deactivator.php';
	Which_Plugin_Slowing_Down_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_which_plugin_slowing_down' );
register_deactivation_hook( __FILE__, 'deactivate_which_plugin_slowing_down' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-which-plugin-slowing-down.php';

require plugin_dir_path( __FILE__ ) . 'actions.php';
require plugin_dir_path( __FILE__ ) . 'filters.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_which_plugin_slowing_down() {

	$plugin = new Which_Plugin_Slowing_Down();
	$plugin->run();

}
run_which_plugin_slowing_down();




