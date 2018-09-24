<?php

/**
 * Service Worker Optimization / PWA Validation Controller
 *
 * @since      2.8.3
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_PWA
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
        $this->CTRL = & $CTRL;
        $this->options = & $CTRL->options;

        /**
         * Admin panel specific
         */
        if (is_admin()) {

            /**
             * Handle form submissions
             */
            $this->CTRL->loader->add_action('admin_post_abtf_pwa_update', $this, 'update_settings');

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

        // create manifest.json template
        if (isset($_POST['create_manifest'])) {
            $manifest = trailingslashit(ABSPATH) . 'manifest.json';
            if (!file_exists($manifest)) {
                try {
                    $manifestjson = array(
                        "short_name" => "",
                        "name" => "",
                        "icons" => array(),
                        "start_url" => "/?utm_source=web_app_manifest",
                        "background_color" => "#f0f3e9",
                        "theme_color" => "#3da508",
                        "display" => "standalone",
                        "orientation" => "landscape"
                    );

                    // PHP 5.3
                    if (version_compare(phpversion(), '5.4.0', '<')) {
                        $json = str_replace('\\/', '/', json_encode($manifestjson));
                    } else {
                        $json = json_encode($manifestjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                    }

                    @file_put_contents($manifest, $json);
                } catch (Exception $error) {
                }

                if (!file_exists($manifest)) {
                    $this->CTRL->admin->set_notice('Failed to install manifest.json on <strong>' . esc_html(str_replace(ABSPATH, '[ABSPATH]/', $manifest)) . '</strong>. Please check the permissions.', 'ERROR');
                } else {
                    $this->CTRL->admin->set_notice('manifest.json installed.', 'NOTICE');
                }
            }

            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-pwa' ), admin_url('admin.php')) . '#manifest');
            exit;
        }

        // @link https://codex.wordpress.org/Function_Reference/stripslashes_deep
        $_POST = array_map('stripslashes_deep', $_POST);

        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        }

        // input
        $input = (isset($_POST['abovethefold']) && is_array($_POST['abovethefold'])) ? $_POST['abovethefold'] : array();

        /**
         * Google PWA optimization
         */
        $options['pwa'] = (isset($input['pwa']) && intval($input['pwa']) === 1) ? true : false;
        $options['pwa_register'] = (isset($input['pwa_register']) && intval($input['pwa_register']) === 1) ? true : false;
        $options['pwa_unregister'] = (isset($input['pwa_unregister']) && intval($input['pwa_unregister']) === 1) ? true : false;
        $options['pwa_scope'] = (isset($input['pwa_scope']) && trim($input['pwa_scope']) !== '') ? $input['pwa_scope'] : '';
        $options['pwa_meta'] = (isset($input['pwa_meta']) && trim($input['pwa_meta']) !== '') ? trim($input['pwa_meta']) : '';

        // General
        $options['pwa_offline_class'] = (isset($input['pwa_offline_class']) && intval($input['pwa_offline_class']) === 1) ? true : false;
        $options['pwa_cache_max_size'] = (isset($input['pwa_cache_max_size']) && trim($input['pwa_cache_max_size']) !== '' && intval($input['pwa_cache_max_size']) > 0) ? intval($input['pwa_cache_max_size']) : '';

        // Page cache
        $options['pwa_cache_pages'] = (isset($input['pwa_cache_pages']) && intval($input['pwa_cache_pages']) === 1) ? true : false;
        $options['pwa_cache_pages_strategy'] = (isset($input['pwa_cache_pages_strategy']) && trim($input['pwa_cache_pages_strategy']) !== '') ? $input['pwa_cache_pages_strategy'] : '';
        $options['pwa_cache_pages_update_interval'] = (isset($input['pwa_cache_pages_update_interval']) && trim($input['pwa_cache_pages_update_interval']) !== '' && intval($input['pwa_cache_pages_update_interval']) > 0) ? $input['pwa_cache_pages_update_interval'] : '';
        $options['pwa_cache_pages_max_age'] = (isset($input['pwa_cache_pages_max_age']) && trim($input['pwa_cache_pages_max_age']) !== '' && intval($input['pwa_cache_pages_max_age']) > 0) ? $input['pwa_cache_pages_max_age'] : '';
        $options['pwa_cache_pages_head_update'] = (isset($input['pwa_cache_pages_head_update']) && intval($input['pwa_cache_pages_head_update']) === 1) ? true : false;
        $options['pwa_cache_pages_update_notify'] = (isset($input['pwa_cache_pages_update_notify']) && intval($input['pwa_cache_pages_update_notify']) === 1) ? true : false;
        $options['pwa_cache_pages_include'] = $this->CTRL->admin->newline_array($input['pwa_cache_pages_include']);
        $options['pwa_cache_pages_offline'] = (isset($input['pwa_cache_pages_offline']) && trim($input['pwa_cache_pages_offline']) !== '') ? $input['pwa_cache_pages_offline'] : '';
        $options['pwa_cache_version'] = (isset($input['pwa_cache_version']) && trim($input['pwa_cache_version']) !== '') ? trim($input['pwa_cache_version']) : '';

        // Preload
        $options['pwa_cache_preload'] = $this->CTRL->admin->newline_array((isset($input['pwa_cache_preload'])) ? $input['pwa_cache_preload'] : '');
        $options['pwa_cache_preload_require'] = (isset($input['pwa_cache_preload_require']) && intval($input['pwa_cache_preload_require']) === 1) ? true : false;

        // preload on mousedown
        $options['pwa_preload_mousedown'] = (isset($input['pwa_preload_mousedown']) && intval($input['pwa_preload_mousedown']) === 1) ? true : false;

        // Asset cache
        $options['pwa_cache_assets'] = (isset($input['pwa_cache_assets']) && intval($input['pwa_cache_assets']) === 1) ? true : false;
        $options['pwa_cache_assets_policy'] = (isset($input['pwa_cache_assets_policy']) && trim($input['pwa_cache_assets_policy']) !== '') ? $input['pwa_cache_assets_policy'] : '';
        if ($options['pwa_cache_assets_policy']) {
            try {
                $options['pwa_cache_assets_policy'] = @json_decode($options['pwa_cache_assets_policy'], true);
            } catch (Exception $error) {
                $options['pwa_cache_assets_policy'] = '';
            }

            if (!is_array($options['pwa_cache_assets_policy'])) {
                $options['pwa_cache_assets_policy'] = array();
                $this->CTRL->admin->set_notice('The asset cache policy does not contain valid JSON.', 'ERROR');
            }
        }

        // install manifest json
        $options['pwa_manifest_meta'] = (isset($input['pwa_manifest_meta']) && intval($input['pwa_manifest_meta']) === 1) ? true : false;
        $options['manifest_json_update'] = (isset($input['manifest_json_update']) && intval($input['manifest_json_update']) === 1) ? true : false;
        if ($options['manifest_json_update'] && isset($input['manifest_json']) && trim($input['manifest_json']) !== '') {
            $manifest = trailingslashit(ABSPATH) . 'manifest.json';
            if (!file_exists($manifest) || !is_writeable($manifest)) {
                $this->CTRL->admin->set_notice('The Web App Manifest <strong>manifest.json</strong> is not writeable.', 'ERROR');
            } else {
                try {
                    $manifestjson = json_decode(trim($input['manifest_json']), true);
                } catch (Exception $err) {
                    $this->CTRL->admin->set_notice('The Web App Manifest contains invalid JSON.', 'ERROR');
                    $manifestjson = false;
                }
                if ($manifestjson && is_array($manifestjson)) {

                    // add start url to options for PWA cache
                    if (isset($manifestjson['start_url'])) {
                        $options['pwa_manifest_start_url'] = $manifestjson['start_url'];
                    }

                    // add service worker
                    $manifestjson['serviceworker'] = array(
                        'src' => $this->CTRL->pwa->get_sw_path(),
                        'use_cache' => true
                    );
                    if (isset($input['pwa_scope']) && trim($input['pwa_scope']) !== '') {
                        $manifestjson['serviceworker']['scope'] = $input['pwa_scope'];
                    }

                    // PHP 5.3
                    if (version_compare(phpversion(), '5.4.0', '<')) {
                        $json = str_replace('\\/', '/', json_encode($manifestjson));
                    } else {
                        $json = json_encode($manifestjson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                    }
                    try {
                        @file_put_contents($manifest, $json);
                    } catch (Exception $error) {
                    }

                    if (!file_exists($manifest) || file_get_contents($manifest) !== $json) {
                        $this->CTRL->admin->set_notice('Failed to write to Web App Manifest <strong>manifest.json</strong>. Please check the permissions.', 'ERROR');
                    }
                }
            }
        } else {
            $manifest = trailingslashit(ABSPATH) . 'manifest.json';
            if (file_exists($manifest)) {
                try {
                    $manifestjson = json_decode(trim(file_get_contents($manifest)), true);
                } catch (Exception $err) {
                    $manifestjson = false;
                }
                if ($manifestjson && is_array($manifestjson)) {

                    // add start url to options for PWA cache
                    if (isset($manifestjson['start_url'])) {
                        $options['pwa_manifest_start_url'] = $manifestjson['start_url'];
                    }
                }
            }
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'Progressive Web App Optimization settings saved.');

        // install service worker and cache policy
        if ($options['pwa']) {
            $this->install_serviceworker();
        }

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-pwa' ), admin_url('admin.php')));
        exit;
    }

    /**
     * Install Service Worker
     */
    public function install_serviceworker()
    {

        // update service worker files
        if (!$this->CTRL->pwa->update_sw()) {
            $this->CTRL->admin->set_notice('Failed to install the Service Worker. Please copy the file manually from plugins/above-the-fold-optimization/public/js/pwa-serviceworker.js (and .debug.js) to the root directory of the WordPress installation.', 'ERROR');
        }

        // update abtf-pwa-policy.json config
        if (!$this->CTRL->pwa->update_sw_config()) {
            
            // get service worker path
            $sw = $this->CTRL->pwa->get_sw();

            $this->CTRL->admin->set_notice('Failed to install the Service Worker Cache Policy on <strong>' . esc_html(str_replace(ABSPATH, '[ABSPATH]/', $sw['file_config'])) . '</strong>. Please check the permissions or create the file manually with the following JSON content: <div style="padding:10px;"><textarea style="width:100%;height:100px;">'.esc_html(json_encode($this->CTRL->pwa->get_sw_config())).'</textarea></div>', 'ERROR');
        }
    }
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook)
    {
        if (!isset($_REQUEST['page']) || $_GET['page'] !== 'pagespeed-pwa') {
            return;
        }

        // add global admin CSS
        wp_enqueue_style('abtf_admincp_jsoneditor_editor', plugin_dir_url(__FILE__) . 'js/jsoneditor/jsoneditor.min.css', false, WPABTF_VERSION);
        wp_enqueue_style('abtf_admincp_jsoneditor', plugin_dir_url(__FILE__) . 'css/admincp-jsoneditor.min.css', false, WPABTF_VERSION);

        // add general admin javascript
        wp_enqueue_script('abtf_admincp_jsoneditor', plugin_dir_url(__FILE__) . 'js/jsoneditor/jsoneditor.min.js', array( 'jquery' ), WPABTF_VERSION);
        wp_enqueue_script('abtf_admincp_pwa', plugin_dir_url(__FILE__) . 'js/admincp-pwa.min.js', array( 'jquery', 'abtf_admincp_jsoneditor' ), WPABTF_VERSION);
    }
}
