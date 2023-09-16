<?php

    // Exit, if file is accessed directly.

    if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {

        exit();

    }



    // Include necessary scripts.

    require_once( 'includes.php' );



    // Uninstall the singleton plugin.
    
    $plugin = Nevma_Performance_Profiler_Plugin::get_instance();

    $plugin->uninstall();

?>