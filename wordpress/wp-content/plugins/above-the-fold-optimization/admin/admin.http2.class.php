<?php

/**
 * HTTP/2 Optimization Controller
 *
 * @since      2.9.0
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_HTTP2
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * Options
     */
    public $options;

    /**
     * Initialize the class and set its properties.
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
            $this->CTRL->loader->add_action('admin_post_abtf_http2_update', $this, 'update_settings');

            // add scripts/styles
            $this->CTRL->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts', 30);
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
        $input = (isset($_POST['abovethefold']) && is_array($_POST['abovethefold'])) ? $_POST['abovethefold'] : array();

        /**
         * HTTP/2 Server Push optimization
         */
        $options['http2_push'] = (isset($input['http2_push']) && intval($input['http2_push']) === 1) ? true : false;
        $options['http2_push_config'] = (isset($input['http2_push_config']) && trim($input['http2_push_config']) !== '') ? $input['http2_push_config'] : '';
        if ($options['http2_push_config']) {
            try {
                $options['http2_push_config'] = @json_decode($options['http2_push_config'], true);
            } catch (Exception $error) {
                $options['http2_push_config'] = '';
            }

            if (!is_array($options['http2_push_config'])) {
                $options['http2_push_config'] = array();
                $this->CTRL->admin->set_notice('The HTML/2 push config does not contain valid JSON.', 'ERROR');
            }
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'HTTP/2 Optimization settings saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-http2' ), admin_url('admin.php')));
        exit;
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook)
    {
        if (!isset($_REQUEST['page']) || $_GET['page'] !== 'pagespeed-http2') {
            return;
        }

        // add global admin CSS
        wp_enqueue_style('abtf_admincp_jsoneditor_editor', plugin_dir_url(__FILE__) . 'js/jsoneditor/jsoneditor.min.css', false, WPABTF_VERSION);
        wp_enqueue_style('abtf_admincp_jsoneditor', plugin_dir_url(__FILE__) . 'css/admincp-jsoneditor.min.css', false, WPABTF_VERSION);

        // add general admin javascript
        wp_enqueue_script('abtf_admincp_jsoneditor', plugin_dir_url(__FILE__) . 'js/jsoneditor/jsoneditor.min.js', array( 'jquery' ), WPABTF_VERSION);
        wp_enqueue_script('abtf_admincp_http2', plugin_dir_url(__FILE__) . 'js/admincp-http2.min.js', array( 'jquery', 'abtf_admincp_jsoneditor' ), WPABTF_VERSION);
    }
}
