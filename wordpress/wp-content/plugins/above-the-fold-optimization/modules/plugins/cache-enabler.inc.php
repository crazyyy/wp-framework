<?php

/**
 * Cache Enabler (KeyCDN.com) full page cache module
 *
 * @link       https://wordpress.org/plugins/cache-enabler/
 *
 * Tested with @version 1.1.0
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_CacheEnabler extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'cache-enabler/cache-enabler.php';

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

        /**
         * Move output buffer behind Above The Folt Optimization
         *
         * Cache Enabler uses position 0, this action should fire directly after
         */
        $this->CTRL->loader->add_action('template_redirect', $this, 'move_output_buffer', 1);
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


    /**
     * Move output buffer after Above The Fold optimization output buffer
     */
    public function move_output_buffer()
    {

        // get callbacks
        $ob_callbacks = ob_list_handlers();
        if (!empty($ob_callbacks) && in_array('wpsmy_minify_html', $ob_callbacks)) {

            // move
            $this->CTRL->optimization->move_ob_to_front();
        }
    }
}
