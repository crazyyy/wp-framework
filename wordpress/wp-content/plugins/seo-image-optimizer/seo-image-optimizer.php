<?php 
/*
 * Plugin Name:       SEO Images Optimizer by Weblizar
 * Description:       Weblizar team introduce a new plugin which is dynamically insert Seo Friendly alt attributes and title attributes to your Images. You can also manually changed the alt and title attributes of images.
 * Version: 		  1.1.4
 * Author: 			  Weblizar
 * Text Domain: 	  seo_images_optimizer
 * Author URI:        https://weblizar.com/plugins/seo_images_optimizer_by_weblizar/
 * Plugin URI:        https://weblizar.com/plugins/seo_images_optimizer_by_weblizar/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Copyright 2012 Weblizar (email : info@Weblizar.com, twitter : @Weblizar)  
 */

/**
 * Default Constants
 */
define( 'WSIO_TEXT_DOMAIN','seo_images_optimizer'); // Your textdomain
define( 'WSIO_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); 
define( 'WSIO_PLUGIN_NAME', __('SEO Images Optimizer by Weblizar', WSIO_TEXT_DOMAIN ) ); // Plugin Name shows up on the admin settings screen.
include 'options/option-panel.php';
include 'options/default-options.php'; 

add_action('plugins_loaded', 'WSIO_Language_Translater');
function wsio_Language_Translater() {
	load_plugin_textdomain(WSIO_TEXT_DOMAIN, FALSE, dirname( plugin_basename(__FILE__)).'/options/languages' );
}

function weblizar_WSIO_activation(){
	$wsio_default_options_data = wsio_default_options_data();
	$wsio_default_options_data_settings = get_option('weblizar_wsio_options'); // get existing option data 		
	if($wsio_default_options_data_settings) {
		$wsio_default_options_data_settings = array_merge($wsio_default_options_data, $wsio_default_options_data_settings);
		update_option('weblizar_wsio_options', $wsio_default_options_data_settings);	// Set existing and new option data			
	} else {
		add_option('weblizar_wsio_options', $wsio_default_options_data);  // set New option data
	} 
}

register_activation_hook( __FILE__, 'weblizar_wsio_activation' );

// Do redirect when Plugin activate

function wsio_nht_plugin_activate() {
	add_option('wsio_nht_plugin_do_activation_redirect', true);
}
function wsio_nht_plugin_redirect() {
	if (get_option('wsio_nht_plugin_do_activation_redirect', false)) {
		delete_option('wsio_nht_plugin_do_activation_redirect');
		if(!isset($_GET['activate-multi'])) {
			wp_redirect("admin.php?page=wsio-weblizar");
		}
	}
}
register_activation_hook(__FILE__, 'wsio_nht_plugin_activate');
add_action('admin_init', 'wsio_nht_plugin_redirect');

// Settings link on plugins page
function seo_settings_link($links) {
	$seo_settings_link = '<a href="admin.php?page=wsio-weblizar">Settings</a>';
	$seo_pro_link = '<a href="https://weblizar.com/plugins/seo-image-optimizer-pro/" style="font-weight:700; color:#e35400" target="_blank">Get Premium</a>';
    array_unshift($links, $seo_pro_link, $seo_settings_link);
    return $links;
}
$seo_plugin_name = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$seo_plugin_name", 'seo_settings_link' );