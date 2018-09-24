<?php

/**
 * W3 Total Cache module
 *
 * @link       https://wordpress.org/plugins/w3-total-cache/
 *
 * Tested with @version 0.9.5.1
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_W3TotalCache extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'w3-total-cache/w3-total-cache.php';

    /**
     * Config data
     */
    private $config;

    /**
     * Page cache callback
     */
    private $pagecache_callback;

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
        * Skip CSS minification
        */
        $this->CTRL->loader->add_filter('w3tc_minify_css_do_tag_minification', $this, 'skip_css', 10, 3);

       /**
        * Skip Javascript minification
        */
        $this->CTRL->loader->add_filter('w3tc_minify_js_do_tag_minification', $this, 'skip_js', 10, 3);
    }

    /**
     * Load config
     */
    public function get_config()
    {
        if (!$this->config) {
            if (class_exists('\\W3TC\\Dispatcher')) {
                $classname = '\\W3TC\\Dispatcher';
                $this->config = $classname::config();

                if ($this->config) {

                    // override minify settings to process content for optimization
                    $minify_options = $this->config->get_array('minify.options');
                    $minify_options['postprocessor'] = array($this,'process_minified_content');

                    $this->config->set('minify.options', $minify_options);
                }

                return $this->config;
            }
            return false;
        }

        return $this->config;
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

            // get W3 config
            if (!$this->get_config()) {
                return false;
            }

            // verify if plugin is active for optimization type
            switch ($type) {

                case "html_output_buffer": // hook to W3TC Output Buffer
                    return true;
                break;

                // Javascript optimization?
                case "js":
                    return ($this->config->get_boolean('minify.enabled') && $this->config->get_boolean('minify.js.enable'));
                break;

                // CSS optimization?
                case "css":
                    return ($this->config->get_boolean('minify.enabled') && $this->config->get_boolean('minify.css.enable'));
                break;

                // HTML optimization?
                case "html":
                    return ($this->config->get_boolean('minify.enabled') && $this->config->get_boolean('minify.html.enable'));
                break;
            }

            return false;
        }

        return false; // not active
    }

    /**
     * Skip CSS from minificaiton
     */
    public function skip_css($do_tag_minification, $style_tag, $file)
    {
        if (!$do_tag_minification) {
            return false;
        }

        if (strpos($style_tag, 'rel="abtf"') !== false) {
            return false;
        }

        return true;
    }

    /**
     * Skip Javascript from Autoptimize minificaiton
     */
    public function skip_js($do_tag_minification, $style_tag, $file)
    {
        if (!$do_tag_minification) {
            return false;
        }

        if (strpos($style_tag, 'rel="abtf"') !== false) {
            return false;
        }

        return true;
    }

    /**
     * Process minified content
     */
    public function process_minified_content($content, $type)
    {
        if (class_exists('Minify0_Minify')) {
            
            /**
             * Process minified CSS
             */
            if ($type === Minify0_Minify::TYPE_CSS) {
                return $this->process_minified_css($content);
            }

            /**
             * Process minified javascript
             */
            if ($type === Minify0_Minify::TYPE_JS) {
                return $this->process_minified_js($content);
            }

            /**
             * Process minified HTML
             */
            if ($type === Minify0_Minify::TYPE_HTML) {
                return $this->process_minified_html($content);
            }
        }

        return $content;
    }

    /**
    * Process minified CSS
    */
    public function process_minified_css($css)
    {
        return apply_filters('abtf_css', $css);
    }

    /**
    * Process minified javascript
    */
    public function process_minified_js($js)
    {
        return apply_filters('abtf_js', $js);
    }

    /**
     * Process HTML
     */
    public function process_minified_html($html)
    {
        return apply_filters('abtf_html', $html);
    }

    /**
     * Disable CSS minification
     */
    public function disable_css_minify()
    {

       /**
        * Add filter to disable CSS optimization
        */
        $this->CTRL->loader->add_filter('w3tc_minify_css_enable', $this, 'noptimize');
    }

    /**
     * Disable HTML minification
     */
    public function disable_html_minify()
    {

       /**
        * Add filter to disable CSS optimization
        */
        $this->CTRL->loader->add_filter('w3tc_minify_html_enable', $this, 'noptimize');
    }

    /**
     * Disable Javascript minification
     */
    public function disable_js_minify()
    {

       /**
        * Add filter to disable Javascript optimization
        */
        $this->CTRL->loader->add_filter('w3tc_minify_js_enable', $this, 'noptimize');
    }

    /**
     * Disable optimization
     */
    public function noptimize()
    {
        return false;
    }

    /**
     * Clear cache
     */
    public function clear_pagecache()
    {
        try {
            if (function_exists('w3tc_pgcache_flush')) {

            // clean the page cache
            w3tc_pgcache_flush();
            }

            if (function_exists('w3tc_minify_flush')) {
            
            // clean minify cache
            w3tc_minify_flush();
            }
        } catch (Exception $err) {
        }
    }

    /**
     * Handle output buffer
     */
    public function ob_callback($buffer)
    {

        // apply Above The Fold Optimization
        $buffer = $this->CTRL->optimization->process_output_buffer($buffer);

        // apply W3 Total Cache pagecache output filter
        if ($this->pagecache_callback) {
            if (is_callable($this->pagecache_callback)) {
                $buffer = call_user_func($this->pagecache_callback, $buffer);
            } elseif (function_exists('wp_get_current_user') && current_user_can('administrator')) {
                return 'Failed to process W3 Total Cache callback. Please contact the author of the <a href="https://goo.gl/C1gw96" target="_blank">Above The Fold Optimization</a> plugin</a>. This message is only visible to administrators.';
            }
        }

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

        // check if pagecache output buffer is started
        if (isset($GLOBALS['_w3tc_ob_callbacks']['pagecache'])) {
            $this->pagecache_callback = $GLOBALS['_w3tc_ob_callbacks']['pagecache'];
        }

        // set / replace pagecache output buffer callback with Above The Fold customized callback
        $GLOBALS['_w3tc_ob_callbacks']['pagecache'] = array($this, 'ob_callback');

        return true;
    }
}
