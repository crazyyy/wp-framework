<?php

/**
 * Removes the settings created by the plugin for single and multi site.
 */
if ( !defined('ABSPATH') || !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}

// if you change the key update the plugin too
$option_name = 'orbisius_child_theme_creator_options';

if ( is_multisite() ) {
    global $wpdb;

    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $original_blog_id = get_current_blog_id();

    foreach ($blog_ids as $blog_id) {
        switch_to_blog($blog_id);
        delete_site_option($option_name);
    }

    switch_to_blog($original_blog_id);
} else { // For Single site
    delete_option($option_name);
}
