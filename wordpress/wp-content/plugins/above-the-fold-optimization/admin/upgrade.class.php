<?php
/**
 * The plugin upgrade controller.
 *
 * @since      2.7.0
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Upgrade
{

    /**
     * Advanced optimization controller
     */
    public $CTRL;

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL =& $CTRL;
    }

    /**
     * Upgrade plugin
     */
    public function upgrade()
    {
        $current_version = get_option('wpabtf_version');
        $update_options = false;

        if (!defined('WPABTF_VERSION') || WPABTF_VERSION !== $current_version) {
            $options = get_option('abovethefold');

            update_option('wpabtf_version', WPABTF_VERSION, false);

            /**
             * Pre 2.5.0 update
             */
            if (version_compare($current_version, '2.5.0', '<')) {

                /**
                 * Disable Google Web Font Optimizer plugin if ABTF Webfont Optimization is enabled
                 */
                if (isset($options['gwfo']) && $options['gwfo']) {
                    @deactivate_plugins('google-webfont-optimizer/google-webfont-optimizer.php');

                    $options['gwfo_loadmethod'] = 'inline';
                    $options['gwfo_loadposition'] = 'header';
                    $update_options = true;
                }

                /**
                 * Enable external resource proxy if Localize Javascript is enabled
                 */
                if (isset($options['localizejs_enabled']) && $options['localizejs_enabled']) {
                    $options['js_proxy'] = true;
                    $options['css_proxy'] = true;
                    $update_options = true;
                }
            }

            /**
             * Pre 2.5.11 update
             */
            if (version_compare($current_version, '2.5.10', '<=')) {

                // convert url list to array
                $newline_conversion = array(
                    'gwfo_googlefonts',
                    'cssdelivery_ignore',
                    'cssdelivery_remove',
                    'css_proxy_preload',
                    'js_proxy_preload',
                    'css_proxy_include',
                    'js_proxy_include',
                    'css_proxy_exclude',
                    'js_proxy_exclude'

                );
                foreach ($newline_conversion as $field) {
                    if (isset($options[$field]) && is_string($options[$field])) {
                        $options[$field] = $this->newline_array($options[$field]);
                        $update_options = true;
                    }
                }

                /**
                 * Verify Google WebFontConfig variable
                 */
                if (isset($options['gwfo_config']) && $options['gwfo_config'] !== '') {
                    if ($this->CTRL->gwfo->verify_webfontconfig($options['gwfo_config'])) {
                        $options['gwfo_config_valid'] = true;
                    } else {
                        $options['gwfo_config_valid'] = false;
                    }

                    $update_options = true;
                    
                    // Extract Google Fonts
                    $this->CTRL->gwfo->fonts_from_webfontconfig($options['gwfo_config'], $options['gwfo_googlefonts']);

                    // modify Google font config in WebFontConfig
                    $googlefonts_regex = '|google\s*:\s*(\{[^\}]+\})|is';
                    if (preg_match($googlefonts_regex, $options['gwfo_config'], $out)) {
                        $config = @json_decode($this->CTRL->gwfo->fixJSON($out[1]), true);
                        if (is_array($config) && isset($config['families'])) {
                            $config['families'] = 'GOOGLE-FONTS-FROM-INCLUDE-LIST';
                            $options['gwfo_config'] = preg_replace($googlefonts_regex, 'google:' . json_encode($config), $options['gwfo_config']);
                        }
                    }
                } else {
                    $options['gwfo_config_valid'] = true;

                    $update_options = true;
                }
            }

            /**
             * Pre 2.6.1 update
             */
            if (version_compare($current_version, '2.6.4', '<=')) {
                if (!isset($options['jsdelivery'])) {
                    $options['jsdelivery'] = false;
                }
                if (!isset($options['jsdelivery_position'])) {
                    $options['jsdelivery_position'] = 'header';
                }
                if (!isset($options['jsdelivery_jquery'])) {
                    $options['jsdelivery_jquery'] = true;
                }
                if (!isset($options['jsdelivery_deps'])) {
                    $options['jsdelivery_deps'] = true;
                }
                if (!isset($options['jsdelivery_scriptloader'])) {
                    $options['jsdelivery_scriptloader'] = 'little-loader';
                }
                
                $update_options = true;
            }

            /**
             * Pre 2.7 update
             */
            if (version_compare($current_version, '2.7', '<=')) {
                $dir = wp_upload_dir();
                $old_cachepath = trailingslashit($dir['basedir']) . 'abovethefold/';
                if (!is_dir($old_cachepath)) {
                    $old_cachepath = false;
                }

                /**
                 * Move critical CSS to new location (theme directory)
                 */
                
                // global css
                $inlinecss = '';

                if ($old_cachepath) {
                    $old_cssfile = $old_cachepath . 'criticalcss_global.css';
                    if (file_exists($old_cssfile)) {
                        $inlinecss = file_get_contents($old_cssfile);
                    } else {
                        $old_cssfile = $old_cachepath . 'inline.min.css';
                        if (file_exists($old_cssfile)) {
                            $inlinecss = file_get_contents($old_cssfile);
                        }
                    }
                }

                // save new critical css file
                $config = array(
                    'name' => 'Global Critical CSS'
                );
                $errors = $this->CTRL->criticalcss->save_file_contents('global.css', $config, $inlinecss);

                // remove old critical css file
                if (!$errors || empty($errors)) {
                    @unlink($old_cssfile);
                }
                
                // conditional CSS
                if ($old_cachepath && isset($options['conditional_css']) && !empty($options['conditional_css'])) {
                    foreach ($options['conditional_css'] as $conditionhash => $conditional) {
                        if (empty($conditional['conditions']) || !is_array($conditional['conditions'])) {
                            continue 1;
                        }

                        $inlinecss = '';
                        $old_cssfile = $old_cachepath . 'criticalcss_'.$conditionhash.'.css';
                        if (file_exists($old_cssfile)) {
                            $inlinecss = file_get_contents($old_cssfile);
                        }
                        if (trim($inlinecss) === '') {
                            continue 1;
                        }

                        $config = array(
                            'name' => $conditional['name'],
                            'weight' => ((is_numeric($conditional['weight'])) ? $conditional['weight'] : 1),
                            'conditions' => array()
                        );
                
                        $conditions = array();

                        foreach ($conditional['conditions'] as $condition) {
                            if ($condition === 'categories') {
                                $config['conditions'][] = 'is_category()';
                            } elseif ($condition === 'frontpage') {
                                $config['conditions'][] = 'is_front_page()';
                            } elseif (substr($condition, 0, 3) === 'pt_') {

                                /**
                                 * Page Template Condition
                                 */
                                if (substr($condition, 0, 7) === 'pt_tpl_') {
                                    $config['conditions'][] = 'is_page_template():' . substr($condition, 7);
                                } else {

                                    /**
                                     * Post Type Condition
                                     */
                                    $pt = substr($condition, 3);
                                    switch ($pt) {
                                        case "page":
                                        case "attachment":
                                            $config['conditions'][] = 'is_'.$pt.'()';
                                        break;
                                        case "post":
                                            $config['conditions'][] = 'is_single()';
                                            $config['conditions'][] = 'is_singular():' . $pt;
                                        break;
                                        default:
                                            $config['conditions'][] = 'is_singular():' . $pt;
                                        break;
                                    }
                                }
                            } elseif (class_exists('WooCommerce') && substr($condition, 0, 3) === 'wc_') {

                                /**
                                 * WooCommerce page type
                                 */
                                $wcpage = substr($condition, 3);
                                $match = false;
                                switch ($wcpage) {
                                    case "shop":
                                    case "product_category":
                                    case "product_tag":
                                    case "product":
                                    case "cart":
                                    case "checkout":
                                    case "account_page":
                                        $config['conditions'][] = 'is_'.$wcpage.'()';
                                    break;
                                }
                            } elseif (substr($condition, 0, 3) === 'tax') {

                                /**
                                 * Taxonomy page
                                 */
                                $tax = substr($condition, 3);
                                $config['conditions'][] = 'is_tax():' . $tax;
                            } elseif (substr($condition, 0, 3) === 'cat') {

                                /**
                                 * Categories
                                 */
                                $cat = substr($condition, 3);
                                $config['conditions'][] = 'is_category():' . $cat;
                            } elseif (substr($condition, 0, 3) === 'catpost') {

                                /**
                                 * Posts with categories
                                 */
                                $cat = substr($condition, 3);
                                $config['conditions'][] = 'has_category():' . $cat;
                            } elseif (substr($condition, 0, 4) === 'page') {

                                /**
                                 * Individual pages
                                 */
                                $pageid = intval(substr($condition, 4));
                                $config['conditions'][] = 'is_page():' . $pageid;
                            } elseif (substr($condition, 0, 4) === 'post') {

                                /**
                                 * Individual posts
                                 */
                                $postid = intval(substr($condition, 4));
                                $config['conditions'][] = 'is_single():' . $pageid;
                            }
                        }

                        $config['matchType'] = 'any';

                        $newfile_name = trim(preg_replace(array('|\s+|is','|[^a-z0-9\-]+|is'), array('-',''), strtolower($conditional['name']))) . '.css';

                        $errors = $this->CTRL->criticalcss->save_file_contents($newfile_name, $config, $inlinecss);

                        // remove old critical css file
                        if (!$errors || empty($errors)) {
                            @unlink($old_cssfile);
                        }
                    }
                }
                
                $update_options = true;
            }


            /**
             * Pre 2.7.6 update
             */
            if (version_compare($current_version, '2.7.6', '<=')) {

                /**
                 * Remove plugin directory from /uploads/
                 */
                $dir = wp_upload_dir();
                $old_cachepath = trailingslashit($dir['basedir']) . 'abovethefold/';
                if (is_dir($old_cachepath)) {
                    $this->CTRL->rmdir($old_cachepath);
                }
            }


            /**
             * Pre 2.8 update
             */
            if (version_compare($current_version, '2.8.0', '<')) {
                $update_options = true;
                
                $options['pwa'] = false;
                $options['manifest_json_update'] = true;
                $options['pwa_offline_class'] = true;
                $options['pwa_meta'] = true;
                $options['html_minify'] = false;
                $options['html_comments'] = false;
                $options['html_comments_preserve'] = array();
                $options['html_search_replace'] = array();
                $options['jsdelivery_idle'] = array();

                delete_option('abtf-pageoptions');
                delete_option('abtf-conditionoptions');
            }


            /**
             * Pre 2.8.5 update
             */
            if (version_compare($current_version, '2.8.5', '<')) {
                $update_options = true;

                if (!isset($options['pwa'])) {
                    $options['manifest_json_update'] = true;
                    $options['pwa_meta'] = true;
                }
                
                // update new abtf-pwa-policy.json format
                if (isset($options['pwa']) && $options['pwa']) {

                    // delete old config
                    $old_sw_config = trailingslashit(ABSPATH) . 'abtf-pwa-policy.json';
                    if (file_exists($old_sw_config)) {
                        @unlink($old_sw_config);
                    }
                }
            }

            /**
             * Pre 2.8.7 update
             */
            if (version_compare($current_version, '2.8.7', '<')) {
                
                // fix invalid default manifest.json
                $manifest_file = trailingslashit(ABSPATH) . 'manifest.json';
                if (file_exists($manifest_file)) {
                    $manifest = file_get_contents($manifest_file);
                    if ($manifest) {
                        $json = @json_decode($manifest, true);

                        $updated_json = false;

                        // fix invalid default start url
                        if (is_array($json) && isset($json['start_url']) && $json['start_url'] === '.\\/?utm_source=web_app_manifest') {
                            $json['start_url'] = '/?utm_source=web_app_manifest';
                            $updated_json = true;
                        }

                        if (isset($options['pwa']) && $options['pwa']) {

                            // fix invalid service worker src
                            if (is_array($json) && isset($json['serviceworker']) && isset($json['serviceworker']['src']) && $json['serviceworker']['src'] !== '/abtf-pwa.js') {
                                $json['start_url'] = '/abtf-pwa.js';
                                $updated_json = true;
                            }
                        }

                        if ($updated_json) {
                            try {

                                // PHP 5.3
                                if (version_compare(phpversion(), '5.4.0', '<')) {
                                    $json = str_replace('\\/', '/', json_encode($json));
                                } else {
                                    $json = json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                                }

                                file_put_contents($manifest_file, $json);
                            } catch (Exception $error) {
                            }
                        }
                    }
                }
            }


            /**
             * Pre 2.8.8 update
             */
            if (version_compare($current_version, '2.8.8', '<')) {
                $update_options = true;

                if (isset($options['pwa']) && $options['pwa']) {
                    $options['pwa_manifest_meta'] = true;
                }
                
                // convert meta checkbox to HTML input field
                if (isset($options['pwa_meta']) && $options['pwa_meta'] === true) {
                    $meta = array();
                    $meta[] = '<meta name="mobile-web-app-capable" content="yes">';

                    if (isset($options['pwa_meta_name']) && $options['pwa_meta_name']) {
                        $meta[] = '<meta name="application-name" content="'.esc_attr($options['pwa_meta_name']).'">';
                    }

                    // theme color
                    if (isset($options['pwa_meta_theme_color']) && $options['pwa_meta_theme_color']) {
                        $meta[] = '<meta name="theme-color" content="'.esc_attr($options['pwa_meta_theme_color']).'">';
                    }

                    
                    // legacy Web App meta
                    if (isset($options['pwa_legacy_meta']) && $options['pwa_legacy_meta']) {
                        $meta[] = '<meta name="apple-mobile-web-app-capable" content="yes">';
                        $meta[] = '<meta name="apple-mobile-web-app-status-bar-style" content="black">';

                        // start url
                        if (isset($options['pwa_meta_starturl']) && $options['pwa_meta_starturl']) {
                            $meta[] = '<meta name="msapplication-starturl" content="'.esc_attr($options['pwa_meta_starturl']).'">';
                        }

                        // application name
                        if (isset($options['pwa_meta_name']) && $options['pwa_meta_name']) {
                            $meta[] = '<meta name="application-name" content="'.esc_attr($options['pwa_meta_name']).'">';
                            $meta[] = '<meta name="apple-mobile-web-app-title" content="'.esc_attr($options['pwa_meta_name']).'">';
                            $meta[] = '<meta name="msapplication-tooltip" content="'.esc_attr($options['pwa_meta_name']).'">';
                        }

                        // theme color
                        if (isset($options['pwa_meta_theme_color']) && $options['pwa_meta_theme_color']) {
                            $meta[] = '<meta name="msapplication-TileColor" content="'.esc_attr($options['pwa_meta_theme_color']).'">';
                        }

                        // icons
                        if (isset($options['pwa_meta_icons']) && is_array($options['pwa_meta_icons'])) {
                            $sizes = array();

                            $ms_tile = false;
                            $max_size = 0;
                            $max_size_icon = false;

                            foreach ($options['pwa_meta_icons'] as $icon) {
                                if (is_array($icon) && isset($icon['sizes'])) {
                                    $size = explode('x', $icon['sizes']);
                                    if (count($size) === 2 && is_numeric($size[0]) && intval($size[0]) > $max_size) {
                                        $max_size = intval($size[0]);
                                        $max_size_icon = $icon;
                                    }

                                    $meta[] = '<link rel="apple-touch-icon" sizes="'.esc_attr($icon['sizes']).'" href="'.esc_attr($icon['src']).'">';

                                    $meta[] =  '<link rel="icon" type="image/png" sizes="'.esc_attr($icon['sizes']).'" href="'.esc_attr($icon['src']).'">';

                                    switch ($icon['sizes']) {
                                        case "144x144":

                                            // microsoft
                                            if (!$ms_tile) {
                                                $meta[] = '<meta name="msapplication-TileImage" content="'.esc_attr($icon['src']).'">';
                                                $ms_tile = true;
                                            }
                                        break;
                                    }
                                } else {
                                    $meta[] = '';
                                }
                            }

                            if ($max_size_icon) {
                                $meta[] = '<link rel="apple-touch-startup-image" href="'.esc_attr($max_size_icon['src']).'">';
                            }
                        }
                    }
                    $options['pwa_meta'] = implode("\n", $meta);
                }
            }


            /**
             * Pre 2.8.19 update
             */
            if (version_compare($current_version, '2.8.19', '<')) {
                if (isset($options['pwa']) && $options['pwa']) {
                    $update_options = true;
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
            }

            // update new abtf-pwa-policy.json format
            if (isset($options['pwa']) && $options['pwa']) {

                // update service worker
                try {
                    $this->CTRL->pwa->update_sw();
                } catch (Exception $error) {
                }

                // update abtf-pwa-config.json to latest format
                try {
                    $this->CTRL->pwa->update_sw_config();
                } catch (Exception $error) {
                }
            }

            // remove old options
            $old_options = array(
                'dimensions',
                'phantomjs_path',
                'cleancss_path',
                'remove_datauri',
                'urls',
                'genurls',
                'localizejs_enabled',
                'conditionalcss_enabled',
                'conditional_css',

                'pwa_meta_theme_color',
                'pwa_legacy_meta',
                'pwa_meta_starturl',
                'pwa_meta_name',
                'pwa_meta_theme_color',
                'pwa_meta_icons'
            );
            foreach ($old_options as $opt) {
                if (isset($options[$opt])) {
                    unset($options[$opt]);
                    $update_options = true;
                }
            }

            if ($update_options) {
                update_option('abovethefold', $options, true);
            }

            // restore limited offer
            update_user_meta(get_current_user_id(), 'abtf_show_offer', 0);

            /**
             * Clear full page cache
             */
            $this->CTRL->plugins->clear_pagecache();
        }
    }
}
