<?php

	// if uninstall.php is not called by WordPress, die
	if( !defined('WP_UNINSTALL_PLUGIN') ) {
		die;
	}

	// remove plugin options
	global $wpdb;

	$wpdb->query("DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_cyrlitera_%';");
	$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wbcr_wp_term_%';");
	$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key='wbcr_wp_old_slug';");

