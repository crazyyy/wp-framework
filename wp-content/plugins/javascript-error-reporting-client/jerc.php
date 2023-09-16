<?php

/**
 * A Wordpress Plugin to collect and report Javascript errors back to the site.
 *
 * PHP version 7
 *
 * @category WP-Plugin
 * @package  Jerc
 * @author   James Amner <jdamner@me.com>
 * @license  GNU GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
 * @link     https://amner.me
 * @since    1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Javascript Error Reporting Client
 * Plugin URI:        https://www.amner.me/
 * Description:       A plugin to collect data about client javascript errors.
 * Version:           1.0.3
 * Author:            James Amner <jdamner@me.com>
 * Author URI:        https://www.amner.me
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Check we can access some core WP functions, just to make sure we're in WP land!
if (!(is_callable('plugin_dir_path') && is_callable('register_activation_hook') && is_callable('register_deactivation_hook'))) {
    die;
}

/**
 * The plugin version
 *
 * @var string The plugin version
 */
define('JERC_VERSION', '1.0.3');

/**
 * Activation Function
 *
 * Calls in the relevant class and fires the activation routines.
 *
 * @return void
 */
function activateJerc()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-jerc-activator.php';
    JercActivator::activate();
}

/**
 * Deactivation Function
 *
 * Calls in the relevant class and fires the deactivation routines.
 *
 * @return void
 */
function deactivateJerc()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-jerc-deactivator.php';
    JercDeactivator::deactivate();
}

/**
 * Register the functions against their hooks
 */
register_activation_hook(__FILE__, 'activateJerc');
register_deactivation_hook(__FILE__, 'deactivateJerc');

/**
 * Include the main class file.
 */
require plugin_dir_path(__FILE__) . 'includes/class-jerc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 *
 * @return void
 */
function runJerc()
{
    /**
     * Instatiate the plugin and run
     */
    $plugin = new Jerc();
    $plugin->run();
}
runJerc();
