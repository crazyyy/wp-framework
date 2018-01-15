<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Remove_Category_URL
 * @author    Valerio Souza <eu@valeriosouza.com.br>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins/remove-category-url
 * @copyright 2013 CodeHost
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

remove_filter('category_rewrite_rules', 'remove_category_url_rewrite_rules');
global $wp_rewrite;
$wp_rewrite->flush_rules();
