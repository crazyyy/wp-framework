<?php

/**
 * WP Super Minify module
 *
 * @link       https://wordpress.org/plugins/wp-super-minify/
 *
 * Tested with @version 1.4
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_WpSuperMinify extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'wp-super-minify/wp-super-minify.php';

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        parent::__construct($CTRL);

        // Is the plugin enabled?
        if (!$this->active()) {
            return;
        }
    }

    /**
     * Is plugin active?
     */
    public function active($type = false)
    {
        if ($this->CTRL->plugins->active($this->plugin_file)) {

            // plugin is active
            if (!$type) {
                return true;
            }
        }

        return false; // not active for special types (css, js etc.)
    }

    /**
     * Clear full page cache
     */
    public function clear_pagecache()
    {
        if (class_exists('Cache_Enabler')) {
            try {
                Cache_Enabler::clear_total_cache(true);
            } catch (Exception $err) {
            }
        }
    }
}
