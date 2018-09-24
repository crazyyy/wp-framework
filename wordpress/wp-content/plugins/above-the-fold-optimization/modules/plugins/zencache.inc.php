<?php

/**
 * Zencache full page cache module
 *
 * @link       https://wordpress.org/plugins/zencache
 *
 * Tested with @version 160316
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_Zencache extends Abovethefold_OPP
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
    public $plugin_file = 'zencache/zencache.php';

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

        // setup special hook for zencache setup
        // @see https://wordpress.org/support/topic/clearing-cache-from-autoptimize-base_dir-option/
        $this->CTRL->loader->add_action('after_theme_setup', $this, 'theme_setup');
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
     * Theme setup hook
     */
    public function theme_setup()
    {
        $this->theme_setup_completed = true;

        // clear pagecache called, perform cache clear action
        if ($this->clear_cache) {
            $this->do_clear_pagecache();
        }
    }

    /**
     * Clear full page cache
     */
    public function clear_pagecache()
    {

        // zencache setup
        if ($this->theme_setup_completed) {
            $this->do_clear_pagecache();
        } else {

            // set clear cache flag
            $this->clear_cache = true;
        }
    }

    /**
     * Perform cache clear action
     */
    public function do_clear_pagecache()
    {
        if (!class_exists('zencache')) {
            return;
        }

        // clear zencache
        try {
            zencache::clear();
        } catch (Exception $e) {
            // auch
        }
    }
}
