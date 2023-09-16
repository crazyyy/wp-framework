<?php
/**
 * Plugin Name: Code Generator
 * Version: 1.0
 * Description: The easiest and fastest way to create custom and high quality code for your WordPress project using the latest WordPress coding standards and API's.
 * Author: ioannup
 * Author URI: https://www.upwork.com/freelancers/~0165d3dc4b2ffbbd7d
 * Requires at least: 4.0
 * Tested up to: 5.7.1
 * Requires PHP: 5.6
 *
 * Tags: code creater, hooks, development, tool, developer
 *
 * Text Domain: generate-wp
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author ioannup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load plugin class files.
require_once 'includes/class-generate-wp.php';
require_once 'includes/class-generate-wp-fields.php';
require_once 'includes/class-generate-wp-settings.php';

// Load plugin libraries.
require_once 'includes/lib/class-generate-wp-admin-api.php';
require_once 'includes/lib/class-generate-wp-post-type.php';
require_once 'includes/lib/class-generate-wp-taxonomy.php';

/**
 * Returns the main instance of Generate_WP to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Generate_WP
 */
function generate_wp() {
	$instance = Generate_WP::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Generate_WP_Settings::instance( $instance );
	}

	return $instance;
}

generate_wp();
