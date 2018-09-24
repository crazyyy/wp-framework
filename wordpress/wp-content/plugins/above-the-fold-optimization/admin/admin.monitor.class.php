<?php
/**
 * Website monitor admin controller
 *
 * @package    optimization
 * @subpackage optimization/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_Monitor
{

    /**
     * Advanced optimization controller
     */
    public $CTRL;

    /**
     * Options
     */
    public $options;

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL =& $CTRL;
        $this->options =& $CTRL->options;

        /**
         * Admin panel specific
         */
        if (is_admin()) {

            /**
             * Handle form submissions
             */
            $this->CTRL->loader->add_action('admin_post_abovethefold-monitor-update', $this, 'update_settings');
        }
    }

    /**
     * Update settings
     */
    public function update_settings()
    {
        check_admin_referer('abovethefold');

        // @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
        $_POST = array_map('stripslashes_deep', $_POST);

        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        }

        // input
        $input = (isset($_POST['ao']) && is_array($_POST['ao'])) ? $_POST['ao'] : array();


        // update settings
        //$this->CTRL->admin->save_settings($options, 'Proxy settings saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-monitor' ), admin_url('admin.php')));
        exit;
    }
}
