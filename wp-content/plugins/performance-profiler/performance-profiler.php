<?php 

    /*
       Plugin Name: Performance Profiler
       Plugin URI: https://wordpress.org/plugins/performance-profiler/
       Description: Performance Profiler plugin silently monitors the resources consumption of your WordPress installation.
       Version: 0.1.0
       Author: Nevma.gr
       Author URI: http://www.nevma.gr/
       License: GPLv2 or later
       License URI: https://www.gnu.org/licenses/gpl-2.0.html
    */



    /**
     * Copyright 2015 Nevma.gr (http://www.nevma.gr, info@nevma.gr)
     *
     * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General 
     * Public License, version 2, as published by the Free Software Foundation. This program is distributed in the hope
     * that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
     * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
     *
     * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
     * Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.
     * 
     * GPL: http://www.gnu.org/copyleft/gpl.html
     */


    
    // Exit, if file is accessed directly.

    if ( ! defined( 'ABSPATH' ) ) {

        exit; 

    }



    // Include necessary scripts.

    require_once( 'includes.php' );



    // Initialise the singleton plugin.

    $plugin = Nevma_Performance_Profiler_Plugin::get_instance();

    $plugin->initialize();

?>