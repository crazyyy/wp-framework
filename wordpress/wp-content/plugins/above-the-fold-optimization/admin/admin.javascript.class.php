<?php

/**
 * Javascript admin controller
 *
 * @since      2.5.4
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_Javascript
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
            $this->CTRL->loader->add_action('admin_post_abtf_javascript_update', $this, 'update_settings');
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
         * Optimize Javascript delivery
         */
        $options['jsdelivery'] = (isset($input['jsdelivery']) && intval($input['jsdelivery']) === 1) ? true : false;
        $options['jsdelivery_position'] = trim($input['jsdelivery_position']);
        $options['jsdelivery_ignore'] = $this->CTRL->admin->newline_array($input['jsdelivery_ignore']);
        $options['jsdelivery_remove'] = $this->CTRL->admin->newline_array($input['jsdelivery_remove']);
        $options['jsdelivery_deps'] = (isset($input['jsdelivery_deps']) && intval($input['jsdelivery_deps']) === 1) ? true : false;
        $options['jsdelivery_jquery'] = (isset($input['jsdelivery_jquery']) && intval($input['jsdelivery_jquery']) === 1) ? true : false;
        $options['jsdelivery_async_all'] = (isset($input['jsdelivery_async_all']) && intval($input['jsdelivery_async_all']) === 1) ? true : false;
        $options['jsdelivery_async'] = $this->CTRL->admin->newline_array($input['jsdelivery_async']);
        $options['jsdelivery_async_disabled'] = $this->CTRL->admin->newline_array($input['jsdelivery_async_disabled']);
        $options['jsdelivery_scriptloader'] = trim($input['jsdelivery_scriptloader']);

        $options['jsdelivery_idle'] = $this->CTRL->admin->newline_array(isset($input['jsdelivery_idle']) ? $input['jsdelivery_idle'] : '');
        $idle = array();
        if (!empty($options['jsdelivery_idle'])) {
            foreach ($options['jsdelivery_idle'] as $str) {
                if (trim($str) === '') {
                    continue;
                }
                $cnf = array();
                if (strpos($str, ':') !== false) {
                    $cnf[0] = trim(substr("$str", 0, strrpos($str, ':')));
                    
                    $timeframe = trim(substr("$str", (strrpos($str, ':') + 1)));
                    if (is_numeric($timeframe) && intval($timeframe) > 0) {
                        $cnf[1] = intval($timeframe);
                    }
                } else {
                    $cnf[0] = trim($str);
                }
                $idle[] = $cnf;
            }
            $options['jsdelivery_idle'] = $idle;
        }

        // Lazy Load Scripts
        $options['lazyscripts_enabled'] = (isset($input['lazyscripts_enabled']) && intval($input['lazyscripts_enabled']) === 1) ? true : false;

        if (!in_array($options['jsdelivery_scriptloader'], array('little-loader','html5'))) {
            $this->CTRL->admin->set_notice('You did not select a valid script loader.', 'ERROR');
            $options['jsdelivery_scriptloader'] = 'little-loader';
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'Javascript optimization settings saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-javascript' ), admin_url('admin.php')));
        exit;
    }
}
