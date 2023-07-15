<?php

/*
  Plugin Name: Easy HTTPS (SSL) Redirection
  Plugin URI: https://www.tipsandtricks-hq.com/wordpress-easy-https-redirection-plugin
  Description: The plugin HTTPS Redirection allows an automatic redirection to the "HTTPS" version/URL of the site.
  Author: Tips and Tricks HQ
  Version: 1.9.2
  Author URI: https://www.tipsandtricks-hq.com/
  License: GPLv2 or later
  Text Domain: https-redirection
  Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if accessed directly
}

include_once('https-rules-helper.php');
include_once('https-redirection-settings.php');

function httpsrdrctn_plugin_init() {
    global $httpsrdrctn_options;
    if ( empty( $httpsrdrctn_options ) ) {
	$httpsrdrctn_options = get_option( 'httpsrdrctn_options' );
    }

    //Do force resource embedded using HTTPS
    if ( isset( $httpsrdrctn_options[ 'force_resources' ] ) && $httpsrdrctn_options[ 'force_resources' ] == '1' ) {
	//Handle the appropriate content filters to force the static resources to use HTTPS URL
	if ( is_admin() ) {
	    add_action( "admin_init", "httpsrdrctn_start_buffer" );
	} else {
	    add_action( "init", "httpsrdrctn_start_buffer" );
	    add_action( "init", "httpsrdrctn_init_time_tasks" );
	}
	add_action( "shutdown", "httpsrdrctn_end_buffer" );
    }
}

function httpsrdrctn_start_buffer() {
    ob_start( "httpsrdrctn_the_content" );
}

function httpsrdrctn_end_buffer() {
    if ( ob_get_length() )
	ob_end_flush();
}

function httpsrdrctn_init_time_tasks() {
    httpsrdrctn_load_language();
}

function httpsrdrctn_load_language() {
    /* Internationalization */
    load_plugin_textdomain( 'https_redirection', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function httpsrdrctn_plugin_admin_init() {
    global $httpsrdrctn_plugin_info;

    $httpsrdrctn_plugin_info = get_plugin_data( __FILE__, false );

    /* Call register settings function */
    if ( isset( $_GET[ 'page' ] ) && "https-redirection" == $_GET[ 'page' ] ) {
	register_httpsrdrctn_settings();
    }
}

/* Register settings function */

function register_httpsrdrctn_settings() {
    global $wpmu, $httpsrdrctn_options, $httpsrdrctn_plugin_info;

    $httpsrdrctn_option_defaults = array(
	'https'			 => 0,
	'https_domain'		 => 1,
	'https_pages_array'	 => array(),
	'force_resources'	 => 0,
	'plugin_option_version'	 => $httpsrdrctn_plugin_info[ "Version" ]
    );

    /* Install the option defaults */
    if ( 1 == $wpmu ) {
	if ( ! get_site_option( 'httpsrdrctn_options' ) )
	    add_site_option( 'httpsrdrctn_options', $httpsrdrctn_option_defaults, '', 'yes' );
    } else {
	if ( ! get_option( 'httpsrdrctn_options' ) )
	    add_option( 'httpsrdrctn_options', $httpsrdrctn_option_defaults, '', 'yes' );
    }

    /* Get options from the database */
    if ( 1 == $wpmu )
	$httpsrdrctn_options	 = get_site_option( 'httpsrdrctn_options' );
    else
	$httpsrdrctn_options	 = get_option( 'httpsrdrctn_options' );

    /* Array merge incase this version has added new options */
    if ( ! isset( $httpsrdrctn_options[ 'plugin_option_version' ] ) || $httpsrdrctn_options[ 'plugin_option_version' ] != $httpsrdrctn_plugin_info[ "Version" ] ) {
	$httpsrdrctn_options				 = array_merge( $httpsrdrctn_option_defaults, $httpsrdrctn_options );
	$httpsrdrctn_options[ 'plugin_option_version' ]	 = $httpsrdrctn_plugin_info[ "Version" ];
	update_option( 'httpsrdrctn_options', $httpsrdrctn_options );
    }
}

function httpsrdrctn_plugin_action_links( $links, $file ) {
    /* Static so we don't call plugin_basename on every plugin row. */
    static $this_plugin;
    if ( ! $this_plugin )
	$this_plugin = plugin_basename( __FILE__ );

    if ( $file == $this_plugin ) {
	$settings_link = '<a href="options-general.php?page=https-redirection">' . __( 'Settings', 'https_redirection' ) . '</a>';
	array_unshift( $links, $settings_link );
    }
    return $links;
}

function httpsrdrctn_register_plugin_links( $links, $file ) {
    $base = plugin_basename( __FILE__ );
    if ( $file == $base ) {
	$links[] = '<a href="options-general.php?page=https-redirection">' . __( 'Settings', 'https_redirection' ) . '</a>';
    }
    return $links;
}

/*
 * Function that changes "http" embeds to "https" 
 */

function httpsrdrctn_filter_content( $content ) {
    //filter buffer
    $home_no_www	 = str_replace( "://www.", "://", get_option( 'home' ) );
    $home_yes_www	 = str_replace( "://", "://www.", $home_no_www );
    $http_urls	 = array(
	str_replace( "https://", "http://", $home_yes_www ),
	str_replace( "https://", "http://", $home_no_www ),
	"src='http://",
	'src="http://',
    );
    $ssl_array	 = str_replace( "http://", "https://", $http_urls );
    //now replace these links
    $str		 = str_replace( $http_urls, $ssl_array, $content );

    //replace all http links except hyperlinks
    //all tags with src attr are already fixed by str_replace

    $pattern = array(
	'/url\([\'"]?\K(http:\/\/)(?=[^)]+)/i',
	'/<link .*?href=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
	'/<meta property="og:image" .*?content=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
	'/<form [^>]*?action=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
    );
    $str	 = preg_replace( $pattern, 'https://', $str );
    return $str;
}

function httpsrdrctn_the_content( $content ) {
    global $httpsrdrctn_options;
    if ( empty( $httpsrdrctn_options ) ) {
	$httpsrdrctn_options = get_option( 'httpsrdrctn_options' );
    }

    $current_page	 = sanitize_post( $GLOBALS[ 'wp_the_query' ]->get_queried_object() );
    // Get the page slug
    $slug		 = str_replace( home_url() . '/', '', get_permalink( $current_page ) );
    $slug		 = rtrim( $slug, "/" ); //remove trailing slash if it's there

    if ( $httpsrdrctn_options[ 'force_resources' ] == '1' && $httpsrdrctn_options[ 'https' ] == 1 ) {
	if ( $httpsrdrctn_options[ 'https_domain' ] == 1 ) {
	    $content = httpsrdrctn_filter_content( $content );
	} else if ( ! empty( $httpsrdrctn_options[ 'https_pages_array' ] ) ) {
	    $pages_str	 = '';
	    $on_https_page	 = false;
	    foreach ( $httpsrdrctn_options[ 'https_pages_array' ] as $https_page ) {
		$pages_str .= preg_quote( $https_page, '/' ) . '[\/|][\'"]|'; //let's add page to the preg expression string in case we'd need it later
		if ( $https_page == $slug ) { //if we are on the page that is in the array, let's set the var to true
		    $on_https_page = true;
		} else { //if not - let's replace all links to that page only to https
		    $http_domain	 = home_url();
		    $https_domain	 = str_replace( 'http://', 'https://', home_url() );
		    $content	 = str_replace( $http_domain . '/' . $https_page, $https_domain . '/' . $https_page, $content );
		}
	    }
	    if ( $on_https_page ) { //we are on one of the https pages
		$pages_str	 = substr( $pages_str, 0, strlen( $pages_str ) - 1 ); //remove last '|'
		$content	 = httpsrdrctn_filter_content( $content ); //let's change everything to https first
		$http_domain	 = str_replace( 'https://', 'http://', home_url() );
		$https_domain	 = str_replace( 'http://', 'https://', home_url() );
		//now let's change all inner links to http, excluding those that user sets to be https in plugin settings
		$content	 = preg_replace( '/<a .*?href=[\'"]\K' . preg_quote( $https_domain, '/' ) . '\/((?!' . $pages_str . ').)(?=[^\'"]+)/i', $http_domain . '/$1', $content );
		$content	 = preg_replace( '/' . preg_quote( $https_domain, '/' ) . '([\'"])/i', $http_domain . '$1', $content );
	    }
	}
    }
    return $content;
}

if ( ! function_exists( 'httpsrdrctn_admin_head' ) ) {

    function httpsrdrctn_admin_head() {
	if ( isset( $_REQUEST[ 'page' ] ) && 'https-redirection' == $_REQUEST[ 'page' ] ) {
	    wp_enqueue_style( 'httpsrdrctn_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
	    wp_enqueue_script( 'httpsrdrctn_script', plugins_url( 'js/script.js', __FILE__ ) );
	}
    }

}

/* Function for delete delete options */
if ( ! function_exists( 'httpsrdrctn_delete_options' ) ) {

    function httpsrdrctn_delete_options() {
	delete_option( 'httpsrdrctn_options' );
	delete_site_option( 'httpsrdrctn_options' );
    }

}

function add_httpsrdrctn_admin_menu() {
    add_submenu_page( 'options-general.php', 'HTTPS Redirection', 'HTTPS Redirection', 'manage_options', 'https-redirection', 'httpsrdrctn_settings_page' );
}

add_action( 'admin_menu', 'add_httpsrdrctn_admin_menu' );
add_action( 'admin_init', 'httpsrdrctn_plugin_admin_init' );
add_action( 'admin_enqueue_scripts', 'httpsrdrctn_admin_head' );

/* Adds "Settings" link to the plugin action page */
add_filter( 'plugin_action_links', 'httpsrdrctn_plugin_action_links', 10, 2 );
/* Additional links on the plugin page */
add_filter( 'plugin_row_meta', 'httpsrdrctn_register_plugin_links', 10, 2 );
//add_filter('mod_rewrite_rules', 'httpsrdrctn_mod_rewrite_rules');//TODO 5

register_uninstall_hook( __FILE__, 'httpsrdrctn_delete_options' );

httpsrdrctn_plugin_init();
