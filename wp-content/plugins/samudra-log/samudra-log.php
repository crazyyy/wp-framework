<?php

/**
 * Plugin Name: Samudra Log
 * Plugin URI: https://www.samudradigital.com
 * Description: Write log for debugging
 * Version: 1.0.2
 * Author: Kasmin
 * Author URI: https://github.com/wakamin
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: samudra_log
 * Domain Path: /languages
 */

// Exit if accessed directly
if (! defined('ABSPATH')) {
    exit();
}

// Constants
define('SDLOG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SDLOG_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Initialize
require_once SDLOG_PLUGIN_PATH . 'init.php';
