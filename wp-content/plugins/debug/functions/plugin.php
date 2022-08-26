<?php
if (!defined('ABSPATH')) {
     exit();
}
//add menu in left side bar
function debug_admin_menu() {
    add_menu_page('debug', 'Debug', 'manage_options', 'debug', 'debug_log_file_page', 'dashicons-migrate');
    add_submenu_page('debug', 'Error Log', 'Error Log', 'manage_options', 'debug', 'debug_log_file_page');
    add_submenu_page('debug', 'Setting', 'Settings', 'manage_options', 'debug_settings', 'debug_admin_page');
}

add_action('admin_menu', 'debug_admin_menu');
if (isset($_POST['downloadlog'])) {
    add_action('admin_init', 'debug_downloadlog');
} elseif (isset($_POST['downloadconfig'])) {
    add_action('admin_init', 'debug_downloadconfig');
}

/**
 * Add setting link on plugin install page
 * 
 * @param type $links
 * @return type
 */
function debug_settings_link($links) {
    $settings_link = '<a href="admin.php?page=debug_settings">' . __('Settings', 'debug') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

add_filter("plugin_action_links_" . DEBUG_PLUGIN_BASENAME, 'debug_settings_link');
/**
 * get and send email notification.
 */
function debug_send_notification_email() {
    $debug_setting = debug_get_options();
    if (isset($debug_setting['enable']) && $debug_setting['enable'] == 1) {
        set_error_handler('debug_error_handler'); 
    }
}

add_action('init', 'debug_send_notification_email');
