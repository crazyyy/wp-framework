<?php

	// if uninstall.php is not called by WordPress, die
	if( !defined('WP_UNINSTALL_PLUGIN') ) {
		die;
	}

	// remove plugin options
	global $wpdb;

	if( is_multisite() ) {
		$wpdb->query("DELETE FROM {$wpdb->sitemeta} WHERE meta_key LIKE 'wbcr_updates_manager_%';");
		$wpdb->query("DELETE FROM {$wpdb->sitemeta} WHERE meta_key LIKE 'wbcr_upm_%';");
	}

	$wpdb->query("DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_updates_manager_%';");
	$wpdb->query("DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_upm_%';");

