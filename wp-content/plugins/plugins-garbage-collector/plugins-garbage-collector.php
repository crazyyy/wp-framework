<?php
/*
Plugin Name: Plugins Garbage Collector (Database Cleanup) Old!
Plugin URI: http://www.shinephp.com/plugins-garbage-collector-wordpress-plugin/
Description: Find and clear unused data from the deactivated or uninstalled plugins. Look at the list of database tables created and used by plugins with quantity of records, size and owner plugin name.
Version: 0.14
Author: Vladimir Garagulya
Author URI: http://www.shinephp.com
Text Domain: plugins-garbage-collector
Domain Path: ./lang/
*/

/*
Copyright 2010-2020  Vladimir Garagulya  (email: vladimir@shinephp.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if (!function_exists('get_option')) {
  header('HTTP/1.0 403 Forbidden');
  die;  // Silence is golden, direct call is prohibited
}

global $wp_version;

define('PGC_PLUGIN_NAME', esc_html__('Database Cleanup', 'plugins-garbage-collector'));
define('PGC_VERSION', '0.14');
define('PGC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PGC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PGC_PLUGIN_FILE', __FILE__);


$exit_msg = PGC_PLUGIN_NAME .' '. esc_html__('requires PHP version 5.6 or newer.', 'plugins-garbage-collector') .
        ' <a href="http://wordpress.org/about/requirements/">'. esc_html__('Please update!', 'plugins-garbage-collector').'</a>';
if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
    deactivate_plugins( PGC_PLUGIN_FILE );
    wp_die( $exit_msg );
}

$exit_msg = PGC_PLUGIN_NAME .' '. esc_html__('requires WordPress 4.0 or newer.', 'plugins-garbage-collector') .
        ' <a href="http://codex.wordpress.org/Upgrading_WordPress">'. esc_html__('Please update!', 'plugins-garbage-collector').'</a>';
if ( version_compare( $wp_version, '4.0', '<' ) ) {
    deactivate_plugins( PGC_PLUGIN_FILE );
    wp_die( $exit_msg );
}

require_once(PGC_PLUGIN_DIR .'includes/lib.php');
require_once(PGC_PLUGIN_DIR .'includes/classes/known-plugins.php');
require_once(PGC_PLUGIN_DIR .'includes/classes/plugins-garbage-collector.php');

new Plugins_Garbage_Collector();
