<?php

/**
 * LiteSpeed Cache module
 *
 * @link       https://wordpress.org/plugins-wp/litespeed-cache/
 *
 * Untested (pending evalution by requesting user)
 * @link https://wordpress.org/support/topic/please-add-support-for-litespeed-cache/
 *
 * @since      2.7.7
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_LitespeedCache extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'litespeed-cache/litespeed-cache.php';

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
        if (!class_exists('LiteSpeed_Cache')) {
            return false;
        }

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
        if (class_exists('LiteSpeed_Cache')) {
            try {
                $cache = LiteSpeed_Cache::plugin();
                $cache->purge_all();
            } catch (Exception $err) {
            }
        }
    }
}
