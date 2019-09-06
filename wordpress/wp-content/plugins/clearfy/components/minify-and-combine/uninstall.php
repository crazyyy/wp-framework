<?php

	// if uninstall.php is not called by WordPress, die
	if( !defined('WP_UNINSTALL_PLUGIN') ) {
		die;
	}

	if( !defined('WMAC_PLUGIN_DIR') ) {
		define('WMAC_PLUGIN_DIR', dirname(__FILE__));
	}

	if( !function_exists('is_plugin_active_for_network') ) {
		require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	}

	require_once(WMAC_PLUGIN_DIR . '/includes/classes/class.mac-cache.php');
	require_once(WMAC_PLUGIN_DIR . '/includes/classes/class.mac-main.php');

	function uninstall()
	{
		// remove plugin options
		global $wpdb;

		$plugin = new WMAC_PluginMain();
		$plugin->setup();

		WMAC_PluginCache::clearAll();

		$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'wbcr_mac_%';");
	}

	if( is_multisite() ) {
		global $wpdb, $wp_version;

		$wpdb->query("DELETE FROM {$wpdb->sitemeta} WHERE meta_key LIKE 'wbcr_mac_%';");

		$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

		if( !empty($blogs) ) {
			foreach($blogs as $id) {

				switch_to_blog($id);

				uninstall();

				restore_current_blog();
			}
		}
	} else {
		uninstall();
	}
