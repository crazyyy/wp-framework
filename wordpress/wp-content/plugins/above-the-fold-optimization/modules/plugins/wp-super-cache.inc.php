<?php

/**
 * WP Super Cache module
 *
 * @link       https://wordpress.org/plugins/wp-super-cache/
 *
 * Tested with @version 1.4.8
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_WpSuperCache extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'wp-super-cache/wp-cache.php';

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

            // verify if plugin is active for optimization type
            switch ($type) {

                case "html_output_buffer": // hook to WP Page Cache Output Buffer

                    global $cache_enabled;
                    
                    if ($cache_enabled) {
                        return true;
                    }
                break;

            }

            return false;
        }

        return false; // not active
    }

    /**
     * Clear cache
     */
    public function clear_pagecache()
    {
        global $file_prefix;

        if (function_exists('wp_cache_clean_cache')) {
            try {
                wp_cache_clean_cache($file_prefix, true);
            } catch (Exception $err) {
            }
        }
    }

    /**
     * HTML output hook
     *
     * The goal is to apply above the fold optimization after the output of optimization plugins, but before full page cache.
     *
     * Use the active() -> "html_output_buffer" method above to enable/disable this HTML output buffer hook.
     */
    public function html_output_hook($optimization)
    {

        // hook to wp super cache output buffer
        $this->CTRL->loader->add_filter('wp_cache_ob_callback_filter', $optimization, 'process_output_buffer');

        return true;
    }
}
