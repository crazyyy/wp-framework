<?php

/**
 * Nginx full page cache module
 *
 * @link       https://wordpress.org/plugins/nginx-helper/
 *
 * Tested with @version 1.9.8
 *
 * @since      2.5.4
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_NginxHelper extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'nginx-helper/nginx-helper.php';

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
        global $rt_wp_nginx_purger;
        if (isset($rt_wp_nginx_purger) && method_exists($rt_wp_nginx_purger, 'true_purge_all')) {
            try {
                $rt_wp_nginx_purger->true_purge_all();
            } catch (Exception $err) {
            }
        }
    }
}
