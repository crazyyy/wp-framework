<?php

/**
 * Better WordPress Minify module
 *
 * @link       https://wordpress.org/plugins/bwp-minify/
 *
 * Tested with @version 1.3.3
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_BwpMinify extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'bwp-minify/bwp-minify.php';

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
        * Apply resource proxy to minification tag to apply CSS and Javascript optimization to minified code
        */
        $this->CTRL->loader->add_filter('bwp_minify_get_tag', $this, 'get_minify_tag', 10, 4);
    }

    /**
     * Process minification tag
     */
    public function get_minify_tag($return, $string, $type, $group)
    {
        global $bwp_minify;

        if ($type === 'script') {
            $proxy_type = 'js';
        } elseif ($type === 'style') {
            $proxy_type = 'css';
        } else {
            return $return; // not supported
        }

        /**
         * Verify if group-string array matches string
         */
        if (empty($group['string']) || strpos($string, implode(',', $group['string'])) === false) {

            // failed to match minified resource string, abort
            // @todo debug
            return $return;
        }

        $original_string = implode(',', $group['string']);

        /**
         * Proxy resources to apply optimization filters
         */
        foreach ($group['string'] as $n => $url) {
            $proxy_file = $this->CTRL->proxy->proxy_resource($group['string'][$n], $proxy_type);
            if ($proxy_file) {
                $group['string'][$n] = str_replace(trailingslashit(ABSPATH), '', $proxy_file[1]);
            }
        }

        // string replaced with proxy cache file locations
        $proxied_string = str_replace($original_string, implode(',', $group['string']), $string);

        // return proxied tag
        return preg_replace('|'.preg_quote($string, '|').'|is', $proxied_string, $return);
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

        /**
         * Mimic private BWP_MINIFY::_flush_cache function
         *
         * This method works since @version 1.3.3
         */
        global $bwp_minify;
        try {
            if (isset($bwp_minify) && method_exists($bwp_minify, 'get_cache_dir')) {
                $cache_dir = $bwp_minify->get_cache_dir();

                $deleted = 0;
                $cache_dir = trailingslashit($cache_dir);

                if (is_dir($cache_dir)) {
                    if ($dh = opendir($cache_dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if (preg_match('/^minify_[a-z0-9\\.=_,]+(\.gz)?$/ui', $file)
                            || preg_match('/^minify-b\d+-[a-z0-9-_.]+(\.gz)?$/ui', $file)
                        ) {
                                $deleted += true === @unlink($cache_dir . $file)
                                ? 1 : 0;
                            }
                        }
                        closedir($dh);
                    }
                }
            }
        } catch (Exception $err) {
        }
    }
}
