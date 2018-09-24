<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://pagespeed.pro/
 * @since      2.5.0
 *
 * @package    abovethefold
 */

if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// remove settings
$options_to_remove = array(
    'abovethefold',
    'abovethefold-proxy-stats',
    'abovethefold-criticalcss',
    'abtf-build-tool-default',
    'abovethefold_notices',
    'wpabtf_version',
    'abtf_lazyxt_version',
    'abtf_webfontjs_version'
);
foreach ($options_to_remove as $option) {
    delete_option($option);
}

// remove cron
wp_clear_scheduled_hook('abtf_cron');

// remove above the fold cache directory
if (defined('ABTF_CACHE_DIR') && strpos(ABTF_CACHE_DIR, '/abtf/') !== false) {
    $path = trailingslashit(ABTF_CACHE_DIR);
    if (is_dir($path)) {

    // Recursive delete
        function abtf_rmdir_recursive($dir)
        {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file")) ? abtf_rmdir_recursive("$dir/$file") : @unlink("$dir/$file");
            }

            return @rmdir($dir);
        }
        abtf_rmdir_recursive($path);
    }
}

// remove service worker
$path = trailingslashit(ABSPATH);
$sw_files = array(
    'abtf-pwa.js',
    'abtf-pwa.debug.js',
    'abtf-pwa-config.json'
);
foreach ($sw_files as $file) {
    if (file_exists($path . $file)) {
        @unlink($path . $file);
    }
}
