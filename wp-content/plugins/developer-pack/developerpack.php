<?php
/*
 * Plugin Name:  Developer Pack
 * Description:  This plugin contain everything a wordpress developer need.
 * Author:       nguyenhongphat0
 * Author URI:   https://nguyenhongphat0.github.io
 * License:      GPL3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:  developerpack
 * Version:      1.3.0
 */

if ( ! defined( 'ABSPATH'  )  ) exit;

add_action( 'init', 'developerpack_ajax' );
function developerpack_ajax() {
	$is_admin = current_user_can( 'administrator' );
	if ( $is_admin ) {
		require_once( 'ajax.php' );
	}
}

add_action( 'admin_menu', 'developerpack_menu' );
function developerpack_menu() {
	add_submenu_page( 'tools.php', 'Developer Pack Settings', 'Developer Pack', 'administrator', __FILE__, 'developerpack_settings_page' );
}

function developerpack_settings_page() {
	$developerpack_dir = plugins_url( '', __FILE__ );
	$theme_dir = substr( get_stylesheet_directory(), strlen( realpath( '..' ) ) + 1 );
	$child_theme_dir = substr( get_template_directory(), strlen( realpath( '..' ) ) + 1 );
	ob_start();
		phpinfo();
		$phpinfo = ob_get_contents();
	ob_end_clean();
	require_once( 'template.php' );
}
