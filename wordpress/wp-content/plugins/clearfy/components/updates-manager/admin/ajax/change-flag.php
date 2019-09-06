<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ajax action for switch option
 */
function wbcr_upm_change_flag()
{
    $is_theme = false;
    $app = WUPM_Plugin::app();
    $slug = $app->request->post('theme', null, true);
    if (!empty($slug)) {
        $is_theme = true;
    } else {
        $slug = $app->request->post('plugin', null, true);
    }

    $flag = $app->request->post('flag', null, true);
    $new_value = (bool)$app->request->post('value');

    if (empty($slug) or empty($flag)) {
        wp_send_json_error(array('error_message' => __('Required arguments of slug, flag is empty!', 'webcraftic-updates-manager')));
    }

    if ($is_theme) {
        $plugin_filters = new WUPM_ThemeFilters($app);
    } else {
        $plugin_filters = new WUPM_PluginFilters($app);
    }

    $method = (($new_value) ? 'disable' : 'enable') . $flag;

    if (!method_exists($plugin_filters, $method)) {
        wp_send_json_error(array('error_message' => __('Method %s is not found!', 'webcraftic-updates-manager')));
    }

    $plugin_filters->$method($slug);
    $plugin_filters->save();

    wp_send_json_success();
}

add_action('wp_ajax_wbcr-upm-change-flag', 'wbcr_upm_change_flag');