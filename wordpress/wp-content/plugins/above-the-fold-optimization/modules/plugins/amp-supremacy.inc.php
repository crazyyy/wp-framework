<?php

/**
 * AMP Supremacy module
 *
 * @link       https://ampsupremacy.com/
 *
 * Tested with @version 1.0.85
 *
 * @since      2.6.16
 * @package    abovethefold
 * @subpackage abovethefold/modules/plugins
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_OPP_AmpSupremacy extends Abovethefold_OPP
{

    /**
     * Plugin file reference
     */
    public $plugin_file = 'amp-supremacy/amp-supremacy.php';

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
        * WordPress init hook
        */
        $this->CTRL->loader->add_action('init', $this, 'init');
    }

    /**
     * Is plugin active?
     */
    public function init()
    {

        // Disable Above The Fold on AMP pages
        if (class_exists('MAMP_Render') && MAMP_Render::extractAMP($_SERVER['REQUEST_URI'])) {
            $this->CTRL->disabled = true;
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
}
