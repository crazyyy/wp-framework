<?php

/**
 * WP Fastest Cache module
 *
 * @link       https://wordpress.org/plugins/wp-fastest-cache/
 *
 * Tested with @version 0.8.6.1
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_WpFastestCache extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'wp-fastest-cache/wpFastestCache.php';

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

            /**
             * Load WP Fastest Cache config
             */
            $options = @json_decode(get_option("WpFastestCache"));

            // check on/off status
            if (!$options || !isset($options->wpFastestCacheStatus)) {
                return false; // disabled
            }

            // plugin is active
            if (!$type) {
                return true;
            }

            // verify if plugin is active for optimization type
            switch ($type) {

                case "html_output_buffer": // hook to WP Fastest Cache Output Buffer

                    // only hook to output buffer when optimizations before page cache are enabled
                    // @see /wp-fastest-cache/inc/cache.php -> callback($buffer)
                    if (
                        (isset($options->wpFastestCacheRenderBlocking) && method_exists("WpFastestCachePowerfulHtml", "render_blocking"))
                        or isset($options->wpFastestCacheCombineCss)
                        or isset($options->wpFastestCacheMinifyCss)
                        or (isset($options->wpFastestCacheCombineJs) || isset($options->wpFastestCacheMinifyJs) || isset($options->wpFastestCacheCombineJsPowerFul))
                        or class_exists("WpFastestCachePowerfulHtml")
                        or isset($options->wpFastestCacheLazyLoad)
                        or isset($options->wpFastestCacheMinifyHtml)
                    ) {
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
        if (isset($GLOBALS["wp_fastest_cache"])) {
            try {
                $GLOBALS["wp_fastest_cache"]->deleteCache(true);
            } catch (Exception $err) {
            }
        }
    }

    /**
     * Handle output buffer
     */
    public function ob_callback($buffer)
    {

        /**
         * Apply WP Fastest Cache optimization for minification
         */
        $wpfc = new WpFastestCacheCreateCache();
        $buffer = $wpfc->callback($buffer);

        // remove cache creation comment
        $buffer = str_replace('<!-- need to refresh to see cached version -->', '', $buffer);

        // delete page cache file
        $extension = 'html';
        $prefix = '';
        @unlink($wpfc->cacheFilePath."/".$prefix."index.".$extension);

        // apply Above The Fold Optimization
        $buffer = $this->CTRL->optimization->process_output_buffer($buffer);

        // update page cache with Above The Fold optimized HTML
        $wpfc->createFolder($wpfc->cacheFilePath, $buffer);

        return $buffer;
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

        /**
         * Check if WP Fastest Cache output buffer is defined, and if it is the last output buffer to replace it with a modified callback.
         *
         * This override will fail if a second output buffer is started after WP Fastest Cache and before Above The Fold Optimization
         *
         * An idea for improvement? Please contact the author of this plugin.
         *
         * This method works for WP Fastest Cache @version 0.8.6.1
         */
        $ob_callbacks = ob_list_handlers();
        if (!empty($ob_callbacks) && in_array('WpFastestCacheCreateCache::callback', $ob_callbacks) && $ob_callbacks[(count($ob_callbacks) - 1)] === 'WpFastestCacheCreateCache::callback') {

            // stop WP Fastest Cache output buffer
            ob_end_clean();

            // start modified output buffer for WP Fastest Cache + Above The Fold Optimization
            ob_start(array($this, 'ob_callback'));

            return true;
        }

        // not supported
        return false;
    }
}
