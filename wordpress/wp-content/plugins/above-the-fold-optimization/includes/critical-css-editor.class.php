<?php

/**
 * Critical CSS / Above The Fold Quality Test and Editor
 *
 * @since      2.9.7
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_CriticalCSSEditor
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * CSS buffer started
     */
    public $buffer_started = false;

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL = & $CTRL;

        // output buffer
        $this->CTRL->loader->add_action('init', $this, 'start_output_buffer', 99999);
    }

    /**
     * Init output buffering
     */
    public function start_output_buffer()
    {

        // prevent double buffer
        if ($this->buffer_started) {
            return;
        }
        $this->buffer_started = true;

        // start buffer
        ob_start(array($this, 'end_buffering'));
    }

    /**
     * End compare critical CSS output buffer
     */
    public function end_buffering($HTML)
    {
        if (is_feed() || is_admin()) {
            return $HTML;
        }
        if (stripos($HTML, "<html") === false || stripos($HTML, "<xsl:stylesheet") !== false) {
            // Not valid HTML
            return $HTML;
        }

        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        $parsed = array();
        parse_str(substr($url, strpos($url, '?') + 1), $parsed);
        $extractkey = $parsed['extract-css'];
        unset($parsed['critical-css-editor']);
        unset($parsed['output']);
        $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . preg_replace('|\?.*$|Ui', '', $_SERVER['REQUEST_URI']);
        if (!empty($parsed)) {
            $url .= '?' . http_build_query($parsed);
        }

        /**
         * Print compare critical CSS page
         */
        require_once(plugin_dir_path(realpath(dirname(__FILE__) . '/')) . 'includes/critical-css-editor.inc.php');

        return $output;
    }
}
