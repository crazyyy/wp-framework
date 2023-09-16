<?php

if(isset($_GET['wpsd']))
{
    if(!defined('SAVEQUERIES'))
        define('SAVEQUERIES', true);

    add_action( 'wp_loaded','wpsd_plugin_control' );
    
    if($_GET['wpsd'] == '3')
    {
        add_action('wp_footer', 'wpsd_name_show_debug_queries', PHP_INT_MAX);
    }
}

function wpsd_name_show_debug_queries()
{
    $peak_memory_usage = memory_get_peak_usage();

    echo '[PEAK_MEMORY_USAGE]'.number_format($peak_memory_usage / 1024 / 1024, 3).'[/PEAK_MEMORY_USAGE]';

    if (defined('SAVEQUERIES') && SAVEQUERIES) {
        global $wpdb;

        echo '[QUERIES_NUMBER]'.count($wpdb->queries).'[/QUERIES_NUMBER]';
        
        exit('closing request');
    }
}

function wpsd_plugin_control() {

    $active_plugins = get_option('active_plugins');
    $wpsd_backup_active_plugins = get_option('wpsd_backup_active_plugins');

    if($_GET['wpsd'] == '1') // disable plugin
    {
        if(isset($_GET['plugin']))
        {
            $key = array_search($_GET['plugin'], $active_plugins);
            if (false !== $key) {
                unset($active_plugins[$key]);
                update_option('active_plugins', $active_plugins);
                
                exit('disabled: '.esc_html($_GET['plugin']));
            }

            if($_GET['plugin'] == 'NONE')
            {
                update_option('active_plugins', array('profiler-what-slowing-down/profiler-what-slowing-down.php'));
            }
        }

        exit('closing request');
    }
    elseif($_GET['wpsd'] == '2') // enable plugin
    {
        if(isset($_GET['plugin']))
        {
            $key = array_search($_GET['plugin'], $active_plugins);

            if($_GET['plugin'] != 'NONE' && $_GET['plugin'] != 'ALL')
            if (false === $key) {
                update_option('active_plugins', $wpsd_backup_active_plugins);

                exit('enabled: '.esc_html($_GET['plugin']));
            }

            if($_GET['plugin'] == 'NONE')
            {
                update_option('active_plugins', $wpsd_backup_active_plugins);
            }
        }

        exit('closing request');
    }
    elseif($_GET['wpsd'] == '3') // run test
    {
        
    }
}

