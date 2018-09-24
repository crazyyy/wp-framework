<?php

/**
 * Proxy admin controller
 *
 * @since      2.5.4
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_Proxy
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
            $this->CTRL->loader->add_action('admin_post_abtf_proxy_update', $this, 'update_settings');

            /**
             * Handle form submissions
             */
            $this->CTRL->loader->add_action('admin_init', $this, 'init');
        }
    }

    /**
     * Admin init
     */
    public function init()
    {

        // empty cache
        if (isset($_GET['empty_cache']) && intval($_GET['empty_cache']) === 1) {
            $this->CTRL->proxy->empty_cache();
            $this->CTRL->admin->set_notice('<p style="font-size:18px;">The proxy cache directory has been emptied.</p>', 'NOTICE');
            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')));
        }

        // update cache stats
        if (isset($_GET['update_cache_stats']) && intval($_GET['update_cache_stats']) === 1) {
            $this->CTRL->proxy->prune(true);
            $this->CTRL->admin->set_notice('<p style="font-size:18px;">The proxy cache directory has been emptied.</p>', 'NOTICE');
            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')) . '#stats');
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
         * Proxy settings
         */
        $options['proxy_url'] = (isset($input['proxy_url'])) ? trim($input['proxy_url']) : '';
        if ($options['proxy_url']) {
            if (!preg_match('|^http(s)?://|Ui', $options['proxy_url'])) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Invalid proxy url.</p>', 'ERROR');

                wp_redirect(add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')));
                exit;
            }

            if (strpos($options['proxy_url'], '{PROXY:URL}') === false) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Proxy url does not contain <code>{PROXY:URL}</code>.</p>', 'ERROR');
 
                wp_redirect(add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')));
                exit;
            }
        }

        // CDN
        $options['proxy_cdn'] = (isset($input['proxy_cdn'])) ? trim($input['proxy_cdn']) : '';
        if ($options['proxy_cdn'] !== '') {
            if (!preg_match('|^http(s)?://[a-z0-9]|Ui', $options['proxy_cdn'])) {
                $this->CTRL->admin->set_notice('<p style="font-size:18px;">Proxy CDN url is not valid (only http:// and https:// urls are allowed).</p>', 'ERROR');
                $options['proxy_cdn'] = '';
            }

            // remove trailing slash
            $options['proxy_cdn'] = rtrim($options['proxy_cdn'], '/');
        }

        // CSS proxy
        $options['css_proxy'] = (isset($input['css_proxy']) && intval($input['css_proxy']) === 1) ? true : false;
        $options['css_proxy_include'] = $this->CTRL->admin->newline_array($input['css_proxy_include']);
        $options['css_proxy_exclude'] = $this->CTRL->admin->newline_array($input['css_proxy_exclude']);


        // Javascript proxy
        $options['js_proxy'] = (isset($input['js_proxy']) && intval($input['js_proxy']) === 1) ? true : false;
        $options['js_proxy_include'] = $this->CTRL->admin->newline_array($input['js_proxy_include']);
        $options['js_proxy_exclude'] = $this->CTRL->admin->newline_array($input['js_proxy_exclude']);

        // preload urls
        $preload_urls = array(
            'css' => $this->CTRL->admin->newline_array($input['css_proxy_preload']),
            'js' => $this->CTRL->admin->newline_array($input['js_proxy_preload'])
        );

        foreach ($preload_urls as $type => $urls) {
            $options[$type . '_proxy_preload'] = array();

            if (!empty($urls)) {
                $typeName = ($type === 'js') ? 'Javascript' : 'CSS';

                foreach ($urls as $url) {

                    // JSON config
                    if (substr($url, 0, 1) === '{') {
                        $url_config = @json_decode($url, true);
                        if (!is_array($url_config)) {
                            $this->CTRL->admin->set_notice('The '.$typeName.' preload JSON <code>'.htmlentities($url, ENT_COMPAT, 'utf-8').'</code> was not recognized as valid JSON.', 'ERROR');
                            continue;
                        }
                        if (!isset($url_config['url'])) {
                            $this->CTRL->admin->set_notice('The '.$typeName.' preload JSON <code>'.htmlentities($url, ENT_COMPAT, 'utf-8').'</code> does not contain a target url.', 'ERROR');
                            // no target url
                            continue 1;
                        }

                        /**
                         * Verify expire time
                         */
                        if (isset($url_config['expire'])) {
                            if ($url_config['expire'] === '') {
                                unset($url_config['expire']);
                            } else {
                                if (!preg_match('|^[0-9]+$|Ui', $url_config['expire']) || intval($url_config['expire']) <= 0) {
                                    $this->CTRL->admin->set_notice('The '.$typeName.' preload JSON <code>'.htmlentities($url, ENT_COMPAT, 'utf-8').'</code> contains an invalid expire time.', 'ERROR');

                                    // set expire time to 30 days
                                    $url_config['expire'] = 2592000;
                                } else {
                                    $url_config['expire'] = intval($url_config['expire']);
                                }
                            }
                        }

                        /**
                         * Verify regex
                         */
                        if (isset($url_config['regex'])) {
                            if ($url_config['regex'] === '') {
                                unset($url_config['regex']);
                                unset($url_config['regex-flags']);
                            } else {

                                // exec preg_match on null
                                $valid = @preg_match('|'.str_replace('|', '\\|', $url_config['regex']).'|' . (isset($url_config['regex-flags']) ? $url_config['regex-flags'] : ''), null);
                                $error = $this->is_preg_error();
                                if ($valid === false || $error) {
                                    $this->CTRL->admin->set_notice('The '.$typeName.' preload JSON <code>'.htmlentities($url, ENT_COMPAT, 'utf-8').'</code> contains an invalid regular expression.' . (($error) ? '<br /><p>Error: '.$error.'</p>' : ''), 'ERROR');
                                    continue 1;
                                }
                            }
                        }

                        /**
                         * Verify custom CDN
                         */
                        if (isset($url_config['cdn'])) {
                            if ($url_config['cdn'] === '') {
                                unset($url_config['cdn']);
                            } else {
                                if (!preg_match('|^http(s)://[a-z0-9]|Ui', $url_config['cdn'])) {
                                    $this->CTRL->admin->set_notice('The '.$typeName.' preload JSON <code>'.htmlentities($url, ENT_COMPAT, 'utf-8').'</code> does not contain a valid CDN url.', 'ERROR');
                                    // no target url
                                    continue 1;
                                }

                                // remove trailing slash
                                $url_config['cdn'] = rtrim($url_config['cdn'], '/');
                            }
                        }

                        $options[$type . '_proxy_preload'][] = $url_config;
                    } else {
                        $options[$type . '_proxy_preload'][] = $url;
                    }
                }
            }
        }

        // update settings
        $this->CTRL->admin->save_settings($options, 'Proxy settings saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')));
        exit;
    }

    /**
     * Preg error
     */
    public function is_preg_error()
    {
        if (!function_exists('preg_last_error')) {
            return false;
        }
        $error = preg_last_error();

        // no error
        if ($error === PREG_NO_ERROR) {
            return false;
        }

        $errors = array(
            PREG_INTERNAL_ERROR         => 'Code 1 : There was an internal PCRE error',
            PREG_BACKTRACK_LIMIT_ERROR  => 'Code 2 : Backtrack limit was exhausted',
            PREG_RECURSION_LIMIT_ERROR  => 'Code 3 : Recursion limit was exhausted',
            PREG_BAD_UTF8_ERROR         => 'Code 4 : The offset didn\'t correspond to the begin of a valid UTF-8 code point',
            PREG_BAD_UTF8_OFFSET_ERROR  => 'Code 5 : Malformed UTF-8 data',
        );
        return $errors[$error];
    }
}
