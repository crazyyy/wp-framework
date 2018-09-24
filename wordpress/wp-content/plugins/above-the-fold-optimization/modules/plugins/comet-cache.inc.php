<?php

/**
 * Comet Cache full page cache module
 *
 * @link       https://wordpress.org/plugins/comet-cache/
 *
 * Tested with @version 160917
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_CometCache extends Abovethefold_OPP
{

    /**
     * Clear page cache flag
     */
    public $clear_cache = false;

    /**
     * Theme setup completed flag
     */
    public $theme_setup_completed = false;

    /**
     * Plugin file reference
     */
    public $plugin_file = 'comet-cache/comet-cache.php';

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
        if (!isset($GLOBALS['comet_cache'])) {
            return;
        }

        try {
            $GLOBALS['comet_cache']->clearCache();
        } catch (Exception $err) {
        }
    }
    

    /**
     * Move output buffer after Above The Fold optimization output buffer
     */
    public function move_output_buffer()
    {

        // get callbacks
        $ob_callbacks = ob_list_handlers();
        if (!empty($ob_callbacks) && in_array('WebSharks\\CometCache\\Classes\\AdvancedCache::outputBufferCallbackHandler', $ob_callbacks)) {

            // move
            $this->CTRL->optimization->move_ob_to_front();
        }
    }
}
