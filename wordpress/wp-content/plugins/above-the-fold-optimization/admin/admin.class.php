<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @since      2.0
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_Admin
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
     * Controllers
     */
    public $criticalcss;
    public $css;
    public $javascript;
    public $proxy;
    public $settings;

    /**
     * Google language code
     */
    public $google_lgcode;
    public $google_intlcode;

    /**
     * Tabs
     */
    public $tabs = array(
        'intro' => 'Intro',
        'html' => 'HTML',
        'css' => 'CSS',
        'javascript' => 'Javascript',
        'criticalcss' => 'Critical CSS',
        'pwa' => 'PWA', // Google PWA Validation
        'http2' => 'HTTP/2',
        'proxy' => 'Proxy',
        'settings' => 'Settings',
        'build-tool' => 'Critical CSS Creator',
        'criticalcss-test' => 'Quality Test',
        'monitor' => 'Monitor'/*,
        'offer' => 'New Plugin'*/
    );

    /**
     * Google Analytics UTM string for external links
     */
    public $utm_string = 'utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=Above%20The%20Fold%20Optimization';

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL = & $CTRL;
        $this->options = & $CTRL->options;

        // Upgrade plugin
        $this->CTRL->loader->add_action('plugins_loaded', $this, 'upgrade', 10);

        // Configure admin bar menu
        if (!isset($this->CTRL->options['adminbar']) || intval($this->CTRL->options['adminbar']) === 1) {
            $this->CTRL->loader->add_action('admin_bar_menu', $this, 'admin_bar', 100);

            // Hook in the frontend admin related styles and scripts
            $this->CTRL->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_frontend_scripts', 30);
        }

        /**
         * Admin panel specific
         */
        if (is_admin()) {

            /**
             * lgcode for Google Documentation links
             */
            $lgcode = strtolower(get_locale());
            if (strpos($lgcode, '_') !== false) {
                $lgparts = explode('_', $lgcode);
                $lgcode = $lgparts[0];
                $this->google_intlcode = $lgparts[0] . '-' . $lgparts[1];
            }
            if ($lgcode === 'en') {
                $lgcode = '';
            }

            $this->google_lgcode = $lgcode;
            if (!$this->google_intlcode) {
                $this->google_intlcode = 'en-us';
            }

            // Hook in the admin options page
            $this->CTRL->loader->add_action('admin_menu', $this, 'admin_menu', 30);

            // Hook in the admin styles and scripts
            $this->CTRL->loader->add_action('admin_enqueue_scripts', $this, 'enqueue_scripts', 30);


            // add settings link to plugin overview
            $this->CTRL->loader->add_filter('plugin_action_links_above-the-fold-optimization/abovethefold.php', $this, 'settings_link');

            // meta links on plugin index
            $this->CTRL->loader->add_filter('plugin_row_meta', $this, 'plugin_row_meta', 10, 2);

            // title on plugin index
            $this->CTRL->loader->add_action('pre_current_active_plugins', $this, 'plugin_title', 10);

            // Handle admin notices
            $this->CTRL->loader->add_action('admin_notices', $this, 'show_notices');

            // Update body class
            $this->CTRL->loader->add_filter('admin_body_class', $this, 'admin_body_class');

            // AJAX page search
            $this->CTRL->loader->add_action('wp_ajax_abtf_page_search', $this, 'ajax_page_search');

            /**
             * Load dependencies
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.criticalcss.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.html.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.css.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.javascript.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.pwa.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.http2.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.proxy.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.settings.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.build-tool.class.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.monitor.class.php';

            /**
             * Load critical CSS management
             */
            $this->criticalcss = new Abovethefold_Admin_CriticalCSS($CTRL);

            /**
             * Load CSS management
             */
            $this->css = new Abovethefold_Admin_CSS($CTRL);

            /**
             * Load HTML management
             */
            $this->html = new Abovethefold_Admin_HTML($CTRL);

            /**
             * Load Javascript management
             */
            $this->javascript = new Abovethefold_Admin_Javascript($CTRL);

            /**
             * Load PWA management
             */
            $this->pwa = new Abovethefold_Admin_PWA($CTRL);

            /**
             * Load HTTP/2 management
             */
            $this->http2 = new Abovethefold_Admin_HTTP2($CTRL);

            /**
             * Load proxy management
             */
            $this->proxy = new Abovethefold_Admin_Proxy($CTRL);

            /**
             * Load settings management
             */
            $this->settings = new Abovethefold_Admin_Settings($CTRL);

            /**
             * Load settings management
             */
            $this->buildtool = new Abovethefold_Admin_BuildTool($CTRL);

            /**
             * Load monitor management
             */
            $this->monitor = new Abovethefold_Admin_Monitor($CTRL);
        }
    }

    /**
     * Set body class
     */
    public function admin_body_class($classes)
    {
        return "$classes abtf-criticalcss";
    }

    /**
     * Settings link on plugin overview
     */
    public function settings_link($links)
    {
        $settings_link = '<a href="' . add_query_arg(array( 'page' => 'pagespeed' ), admin_url('admin.php')) . '">'.__('Settings').'</a>';
        array_unshift($links, $settings_link);

        return $links;
    }
    
    /**
     * Show row meta on the plugin screen.
     */
    public static function plugin_row_meta($links, $file)
    {
        if ($file == plugin_basename(WPABTF_SELF)) {
            $lgcode = strtolower(get_locale());
            $intlcode = 'en-us';
            if (strpos($lgcode, '_') !== false) {
                $lgparts = explode('_', $lgcode);
                $lgcode = $lgparts[0];
                $intlcode = $lgparts[0] . '-' . $lgparts[1];
            }
            if ($lgcode === 'en') {
                $lgcode = '';
            }

            $row_meta = array(
                'pagespeed_insights' => '<a href="' . esc_url('https://developers.google.com/speed/pagespeed/insights/?hl=' . $lgcode) . '" target="_blank" title="' . esc_attr(__('View Google PageSpeed Insights Test', 'pagespeed')) . '">' . __('Google PageSpeed', 'pagespeed') . '</a>',
                'pagespeed_scores' => '<a href="' . esc_url('https://testmysite.' . (($intlcode === 'en-us') ? 'think' : '') . 'withgoogle.com/intl/'.$intlcode.'?url='.home_url()) . '" target="_blank" title="' . esc_attr(__('View Google PageSpeed Scores Documentation', 'pagespeed')) . '">' . __('View Scores', 'pagespeed') . '</a>',
            );

            return array_merge($links, $row_meta);
        }

        return (array) $links;
    }

    /**
     * Plugin title modification
     */
    public function plugin_title()
    {
        ?><script>
jQuery(function() { var desc = jQuery('*[data-plugin="above-the-fold-optimization/abovethefold.php"] .column-description'); desc.html(desc.html().replace('100 Score','<span class="g100">100</span> Score')); });
</script><?php
    }

    /**
     * Get active tab
     */
    public function active_tab($default = 'criticalcss')
    {

        // get tab from query string
        $tab = $default;

        // page based tab
        if (isset($_GET['page']) && strpos($_GET['page'], 'pagespeed-') === 0) {
            $tab = substr($_GET['page'], 10);
            if ($tab === 'above-the-fold') {
                $tab = 'criticalcss';
            }
            if (isset($this->tabs[$tab])) {
                $this->active_tab = $tab;
            }
        }

        // invalid tab
        if (!isset($this->tabs[$tab])) {
            $tab = $default;
        }

        return $tab;
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook)
    {

        // add global admin CSS
        wp_enqueue_style('abtf_admincp_global', plugin_dir_url(__FILE__) . 'css/admincp-global.min.css', false, WPABTF_VERSION);

        if (!isset($_REQUEST['page']) || strpos($_GET['page'], 'pagespeed') !== 0) {
            return;
        }

        /**
         * Clear page cache
         */
        if ((isset($_REQUEST['clear']) && $_REQUEST['clear'] === 'pagecache') || isset($_POST['clear_pagecache'])) {
            check_admin_referer('abovethefold');

            $this->clear_pagecache();

            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-settings' ), admin_url('admin.php')));
            exit;
        }

        // add general admin javascript
        wp_enqueue_script('abtf_admincp', plugin_dir_url(__FILE__) . 'js/admincp.min.js', array( 'jquery' ), WPABTF_VERSION);

        // add general admin CSS
        wp_enqueue_style('abtf_admincp', plugin_dir_url(__FILE__) . 'css/admincp.min.css', false, WPABTF_VERSION);
    }

    /**
     * Enqueue admin bar widget scripts
     */
    public function enqueue_frontend_scripts($hook)
    {
        if (!is_admin_bar_showing()) {
            return;
        }

        // add global admin CSS
        wp_enqueue_style('abtf_admincp_global', plugin_dir_url(__FILE__) . 'css/admincp-global.min.css', false, WPABTF_VERSION);

        // add general admin javascript
        wp_enqueue_script('abtf_css_extract_widget', plugin_dir_url(__FILE__) . 'js/css-extract-widget.min.js', array( 'jquery' ), WPABTF_VERSION);
    }

    /**
     * Admin menu option
     */
    public function admin_menu()
    {
        global $submenu;

        add_menu_page(
            __('Google PageSpeed Optimization', 'pagespeed'),
            __('PageSpeed', 'pagespeed'),
            'manage_options',
            'pagespeed',
            array(
                &$this,
                'settings_page'
            ),
            $this->admin_icon(),
            100
        );

        add_submenu_page('pagespeed', __('Critical CSS (Above The Fold) Optimization', 'pagespeed'), __('Critical CSS', 'pagespeed'), 'manage_options', 'pagespeed-criticalcss', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('HTML Optimization', 'pagespeed'), __('HTML', 'pagespeed'), 'manage_options', 'pagespeed-html', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('CSS Optimization', 'pagespeed'), __('CSS', 'pagespeed'), 'manage_options', 'pagespeed-css', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('Javascript Optimization', 'pagespeed'), __('Javascript', 'pagespeed'), 'manage_options', 'pagespeed-javascript', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('Progressive Web App Optimization', 'pagespeed'), __('PWA', 'pagespeed'), 'manage_options', 'pagespeed-pwa', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('HTTP/2 Optimization', 'pagespeed'), __('HTTP/2', 'pagespeed'), 'manage_options', 'pagespeed-http2', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('External Resource Proxy', 'pagespeed'), __('Proxy', 'pagespeed'), 'manage_options', 'pagespeed-proxy', array(
            &$this,
            'settings_page'
        ));

        add_submenu_page('pagespeed', __('Settings', 'pagespeed'), __('Settings', 'pagespeed'), 'manage_options', 'pagespeed-settings', array(
            &$this,
            'settings_page'
        ));

        /**
         * Add theme settings link to Appearance tab
         */
        add_submenu_page('themes.php', __('Above The Fold Optimization', 'pagespeed'), __('Above The Fold', 'pagespeed'), 'manage_options', 'pagespeed-above-the-fold', array(
            &$this,
            'settings_page'
        ));

        /**
         * Hidden pages
         */
        add_submenu_page(null, __('Critical CSS Quality Test', 'pagespeed'), __('Critical CSS Quality Test', 'pagespeed'), 'manage_options', 'pagespeed-criticalcss-test', array(
            &$this,
            'settings_page'
        ));
        add_submenu_page(null, __('Critical CSS Gulp.js Build Tool', 'pagespeed'), __('Gulp.js Build Tool', 'pagespeed'), 'manage_options', 'pagespeed-build-tool', array(
            &$this,
            'settings_page'
        ));
        add_submenu_page(null, __('Website Monitor', 'pagespeed'), __('Website Monitor', 'pagespeed'), 'manage_options', 'pagespeed-monitor', array(
            &$this,
            'settings_page'
        ));
    }
    
    
    /**
     * Admin bar option
     */
    public function admin_bar($admin_bar)
    {
        $options = get_option('abovethefold');
        if (!empty($options['adminbar']) && intval($options['adminbar']) !== 1) {
            return;
        }

        $settings_url = add_query_arg(array( 'page' => 'pagespeed' ), admin_url('admin.php'));
        $nonced_url = wp_nonce_url($settings_url, 'abovethefold');

        if (is_admin()
            || (defined('DOING_AJAX') && DOING_AJAX)
            || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))
        ) {
            $currenturl = home_url();
        } else {
            $currenturl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        $admin_bar->add_menu(array(
            'id' => 'abovethefold',
            'title' => '<div class="ab-icon wp-menu-image svg" style="background-image: url(\''.$this->admin_icon().'\') !important;"></div><span class="ab-label">' . __('PageSpeed', 'pagespeed') . '</span>',
            'href' => $settings_url,
            'meta' => array( 'title' => __('PageSpeed', 'abovethefold'), 'class' => 'ab-sub-secondary' )

        ));

        $admin_bar->add_group(array(
            'parent' => 'abovethefold',
            'id' => 'abovethefold-top',
            'meta' => array(
                'class' => 'ab-sub-secondary', //
            )
        ));

        /**
         * Optimization menu
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-top',
            'id' => 'abovethefold-optimization',
            'title' => __('Optimization', 'abovethefold')
        ));

        /**
         * Critical CSS menu
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-top',
            'id' => 'abovethefold-critical-css',
            'title' => __('Critical CSS', 'abovethefold'),
            'href' => $this->CTRL->view_url('critical-css-test'),
            'meta' => array( 'title' => __('Critical CSS', 'abovethefold'), 'target' => '_blank' )
        ));

        /**
         * Other tools menu
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-top',
            'id' => 'abovethefold-tools',
            'title' => __('Other Tools', 'abovethefold')
        ));

        // critical CSS quality test
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-critical-css',
            'id' => 'abovethefold-critical-css-quality',
            'title' => __('Quality Test (split view)', 'abovethefold'),
            'href' => $this->CTRL->view_url('critical-css-editor'),
            'meta' => array( 'title' => __('Critical CSS Quality Test (split view)', 'abovethefold'), 'target' => '_blank' )
        ));

        // critical CSS quality test
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-critical-css',
            'id' => 'abovethefold-critical-css-editor',
            'title' => __('Critical CSS Editor', 'abovethefold'),
            'href' => $this->CTRL->view_url('critical-css-editor') . '#editor',
            'meta' => array( 'title' => __('Critical CSS Editor', 'abovethefold'), 'target' => '_blank' )
        ));

        if (!is_admin()) {
            // extract Critical CSS
            $admin_bar->add_node(array(
                'parent' => 'abovethefold-critical-css',
                'id' => 'abovethefold-extract-critical-css-widget',
                'title' => __('Extract Critical CSS (JS widget)', 'abovethefold'),
                'href' => '#',
                'meta' => array( 'title' => __('Extract Critical CSS (javascript widget)', 'abovethefold'), 'onclick' => 'window.extractCriticalCSS();return false;' )
            ));
        }

        // extract full CSS
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-critical-css',
            'id' => 'abovethefold-extract-full-css',
            'title' => __('Extract Full CSS (plugin)', 'abovethefold'),
            'href' => $this->CTRL->view_url('extract-css', array('output' => 'print')),
            'meta' => array( 'title' => __('Extract Full CSS (plugin)', 'abovethefold'), 'target' => '_blank' )
        ));


        if (!is_admin()) {
            $admin_bar->add_node(array(
                'parent' => 'abovethefold-critical-css',
                'id' => 'abovethefold-extract-full-css-widget',
                'title' => __('Extract Full CSS (JS widget)', 'abovethefold'),
                'href' => '#',
                'meta' => array( 'title' => __('Extract Full CSS (javascript widget)', 'abovethefold'), 'onclick' => 'window.extractFullCSS();return false;' )
            ));
        } else {
            $admin_bar->add_node(array(
                'parent' => 'abovethefold-critical-css',
                'id' => 'abovethefold-extract-critical-css-widget-link',
                'title' => __('See frontend for more options...', 'abovethefold'),
                'href' => home_url(),
                'meta' => array( 'title' => __('Extract Full CSS (javascript widget)', 'abovethefold'))
            ));
        }

        /**
         * Optimize HTML
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-html',
            'title' => __('HTML', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-html' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('HTML', 'abovethefold') )
        ));

        /**
         * Optimize CSS
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-css',
            'title' => __('CSS', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-css' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('CSS', 'abovethefold') )
        ));

        /**
         * Optimize Javascript
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-javascript',
            'title' => __('Javascript', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-javascript' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('Javascript', 'abovethefold') )
        ));

        /**
         * Optimize Critical CSS
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-criticalcss',
            'title' => __('Critical CSS', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-criticalcss' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('Critical CSS', 'abovethefold') )
        ));

        /**
         * Optimize PWA
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-pwa',
            'title' => __('Progressive Web App (PWA)', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-pwa' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('PWA', 'abovethefold') )
        ));

        /**
         * Optimize HTTP2
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-http2',
            'title' => __('HTTP/2', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-http2' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('HTTP/2', 'abovethefold') )
        ));

        /**
         * Optimize Proxy
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-optimization',
            'id' => 'abovethefold-optimization-proxy',
            'title' => __('Proxy', 'abovethefold'),
            'href' => add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')),
            'meta' => array( 'title' => __('Proxy', 'abovethefold') )
        ));

        /**
         * Page cache clear
         */
        $clear_url = add_query_arg(array( 'page' => 'pagespeed', 'clear' => 'pagecache' ), admin_url('admin.php'));
        $nonced_url = wp_nonce_url($clear_url, 'abovethefold');
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-tools',
            'id' => 'abovethefold-tools-clear-pagecache',
            'title' => __('Clear Page Caches', 'abovethefold'),
            'href' => $nonced_url,
            'meta' => array( 'title' => __('Clear Page Caches', 'abovethefold') )
        ));

        /**
         * Google PageSpeed Score Test
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold',
            'id' => 'abovethefold-check-pagespeed-scores',
            'title' => __('Google PageSpeed Scores', 'abovethefold'),
            'href' => 'https://testmysite.' . (($this->google_intlcode === 'en-us') ? 'think' : '') . 'withgoogle.com/intl/'.$this->google_intlcode.'?url=' . urlencode($currenturl),
            'meta' => array( 'title' => __('Google PageSpeed Scores', 'abovethefold'), 'target' => '_blank' )
        ));

        /**
         * Test Groups
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold',
            'id' => 'abovethefold-check-google',
            'title' => __('Google tests', 'abovethefold')
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold',
            'id' => 'abovethefold-check-speed',
            'title' => __('Speed tests', 'abovethefold')
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold',
            'id' => 'abovethefold-check-technical',
            'title' => __('Technical & security tests', 'abovethefold')
        ));


        /**
         * Google Tests
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-google',
            'id' => 'abovethefold-check-pagespeed',
            'title' => __('Google PageSpeed Insights', 'abovethefold'),
            'href' => 'https://developers.google.com/speed/pagespeed/insights/?url='.urlencode($currenturl) . '&hl=' . $this->google_lgcode,
            'meta' => array( 'title' => __('Google PageSpeed Insights', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-google',
            'id' => 'abovethefold-check-google-mobile',
            'title' => __('Google Mobile Test', 'abovethefold'),
            'href' => 'https://search.google.com/search-console/mobile-friendly?url='.urlencode($currenturl) . '&hl=' . $this->google_lgcode,
            'meta' => array( 'title' => __('Google Mobile Test', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-google',
            'id' => 'abovethefold-check-google-malware',
            'title' => __('Google Malware & Security', 'abovethefold'),
            'href' => 'https://www.google.com/transparencyreport/safebrowsing/diagnostic/index.html?hl=' . $this->google_lgcode . '#url='.urlencode(str_replace('www.', '', parse_url($currenturl, PHP_URL_HOST))),
            'meta' => array( 'title' => __('Google Malware & Security', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-google',
            'id' => 'abovethefold-check-google-more',
            'title' => __('More tests', 'abovethefold'),
            'href' => 'https://pagespeed.pro/tests#url='.urlencode($currenturl),
            'meta' => array( 'title' => __('More tests', 'abovethefold'), 'target' => '_blank' )
        ));

        /**
         * Speed Tests
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-speed',
            'id' => 'abovethefold-check-webpagetest',
            'title' => __('WebPageTest.org', 'abovethefold'),
            'href' => 'http://www.webpagetest.org/?url='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('WebPageTest.org', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-speed',
            'id' => 'abovethefold-check-pingdom',
            'title' => __('Pingdom Tools', 'abovethefold'),
            'href' => 'http://tools.pingdom.com/fpt/?url='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('Pingdom Tools', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-speed',
            'id' => 'abovethefold-check-gtmetrix',
            'title' => __('GTmetrix', 'abovethefold'),
            'href' => 'http://gtmetrix.com/?url='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('GTmetrix', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-speed',
            'id' => 'abovethefold-check-speed-more',
            'title' => __('More tests', 'abovethefold'),
            'href' => 'https://pagespeed.pro/tests#url='.urlencode($currenturl),
            'meta' => array( 'title' => __('More tests', 'abovethefold'), 'target' => '_blank' )
        ));

        /**
         * Technical & Security Tests
         */
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-securityheaders',
            'title' => __('SecurityHeaders.io', 'abovethefold'),
            'href' => 'https://securityheaders.io/?q='.urlencode($currenturl).'&hide=on&followRedirects=on',
            'meta' => array( 'title' => __('SecurityHeaders.io', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-w3c',
            'title' => __('W3C HTML Validator', 'abovethefold'),
            'href' => 'https://validator.w3.org/nu/?doc='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('W3C HTML Validator', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-ssllabs',
            'title' => __('SSL Labs', 'abovethefold'),
            'href' => 'https://www.ssllabs.com/ssltest/analyze.html?d='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('SSL Labs', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-intodns',
            'title' => __('Into DNS', 'abovethefold'),
            'href' => 'http://www.intodns.com/'.urlencode(str_replace('www.', '', parse_url($currenturl, PHP_URL_HOST))).'',
            'meta' => array( 'title' => __('Into DNS', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-http2',
            'title' => __('HTTP/2', 'abovethefold'),
            'href' => 'https://tools.keycdn.com/http2-test?url='.urlencode($currenturl).'',
            'meta' => array( 'title' => __('HTTP/2', 'abovethefold'), 'target' => '_blank' )
        ));
        $admin_bar->add_node(array(
            'parent' => 'abovethefold-check-technical',
            'id' => 'abovethefold-check-technical-more',
            'title' => __('More tests', 'abovethefold'),
            'href' => 'https://pagespeed.pro/tests#url='.urlencode($currenturl),
            'meta' => array( 'title' => __('More tests', 'abovethefold'), 'target' => '_blank' )
        ));
    }

    /**
     * Return optgroup json for page search
     */
    public function page_search_optgroups()
    {
        $optgroups = array();

        $optgroups[] = array(
            'value' => 'posts',
            'label' => __('Posts')
        );
        $optgroups[] = array(
            'value' => 'pages',
            'label' => __('Pages')
        );
        $optgroups[] = array(
            'value' => 'categories',
            'label' => __('Categories')
        );
        if (class_exists('WooCommerce')) {
            $optgroups[] = array(
                'value' => 'woocommerce',
                'label' => __('WooCommerce')
            );
        }

        return $optgroups;
    }

    /**
     * Return options for page selection menu
     */
    public function ajax_page_search()
    {
        global $wpdb; // this is how you get access to the database

        $query = (isset($_POST['query'])) ? trim($_POST['query']) : '';
        $limit = (isset($_POST['maxresults']) && intval($_POST['maxresults']) > 10 && intval($_POST['maxresults']) < 30) ? intval($_POST['maxresults']) : 10;

        // enable URL (slug) search
        // @Emilybkk
        if (preg_match('|^http(s)?://|Ui', $query) || substr($query, 0, 1) === '/') {
            $slugquery = array_pop(explode('/', trim(preg_replace('|^http(s)://[^/]+/|Ui', '', $query), '/')));
        } else {
            $slugquery = false;
        }

        /**
         * Results
         */
        $results = array();

        $post_types = get_post_types();
        foreach ($post_types as $pt) {
            if (in_array($pt, array('revision','nav_menu_item'))) {
                continue 1;
            }
            
            if (count($results) >= $limit) {
                break;
            }

            // Get random post
            if ($slugquery) {
                $args = array( 'post_type' => $pt, 'posts_per_page' => $limit, 'name' => $slugquery );
            } else {
                $args = array( 'post_type' => $pt, 'posts_per_page' => $limit, 's' => $query );
            }
            
            query_posts($args);
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    switch ($pt) {
                        case "post":
                            $results[] = array(
                                'class' => 'posts',
                                'value' => get_permalink($wp_query->post->ID),
                                'name' => get_the_ID() . '. ' . str_replace(home_url(), '', get_permalink(get_the_ID())) . ' - ' . get_the_title()
                            );
                        break;
                        case "product":
                            $results[] = array(
                                'class' => 'woocommerce',
                                'value' => get_permalink(get_the_ID()),
                                'name' => get_the_ID() . '. ' . str_replace(home_url(), '', get_permalink(get_the_ID())) . ' - ' . get_the_title()
                            );
                        break;
                        default:
                            $results[] = array(
                                'class' => 'pages',
                                'value' => get_permalink(get_the_ID()),
                                'name' => get_the_ID() . '. ' . str_replace(home_url(), '', get_permalink(get_the_ID())) . ' - ' . get_the_title()
                            );
                        break;
                    }
                    if (count($results) >= $limit) {
                        break;
                    }
                }
            }
        }

        if (count($results) < $limit) {
            $taxonomies = get_taxonomies();
            if (!empty($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    if (count($results) >= $limit) {
                        break;
                    }
                    switch ($taxonomy) {
                        case "category":
                        case "post_tag":
                        case "product_cat":
                        case "product_brand":

                            if ($slugquery) {
                                $term_query = array(
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'number' => $limit,
                                    'name' => $slugquery
                                );
                            } else {
                                $term_query = array(
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                    'hide_empty' => false,
                                    'number' => $limit,
                                    'name__like' => $query
                                );
                            }

                            $terms = get_terms($taxonomy, $term_query);
                            if ($terms) {
                                foreach ($terms as $term) {
                                    switch ($taxonomy) {
                                        case "product_cat":
                                        case "product_brand":
                                            $results[] = array(
                                                'class' => 'woocommerce',
                                                'value' => get_term_link($term->slug, $taxonomy),
                                                'name' => $term->term_id.'. ' . str_replace(home_url(), '', get_category_link($term->term_id)) . ' - ' . $term->name
                                            );
                                        break;
                                        default:
                                            $results[] = array(
                                                'class' => 'categories',
                                                'value' => get_category_link($term->term_id),
                                                'name' => $term->term_id.'. ' . str_replace(home_url(), '', get_category_link($term->term_id)) . ' - ' . $term->name
                                            );
                                        break;
                                    }
                                    
                                    if (count($results) >= $limit) {
                                        break;
                                    }
                                }
                            }
                        break;
                        default:
                            
                        break;
                    }
                }
            }
        }
        
        $json = json_encode($results);

        header('Content-Type: application/json');
        header('Content-Length: ' . strlen($json));
        print $json;

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    /**
     * Clear page cache with notice
     */
    public function clear_pagecache($notice = true)
    {
        $this->CTRL->plugins->clear_pagecache();

        if ($notice) {
            $this->set_notice('Page related caches from <a href="https://github.com/optimalisatie/above-the-fold-optimization/tree/master/trunk/modules/plugins/" target="_blank">supported plugins</a> cleared.<p><strong>Note:</strong> This plugin does not contain a page cache. The page cache clear function for other plugins is a tool.', 'NOTICE');
        }
    }

    /**
     * Save settings
     */
    public function save_settings($options, $notice = false)
    {
        if (!is_array($options) || empty($options)) {
            wp_die('No settings to save');
        }

        // store update count
        if (!isset($options['update_count'])) {
            $options['update_count'] = 0;
        }
        $options['update_count']++;

        // update settings
        update_option('abovethefold', $options, true);

        if (!$notice) {
            return;
        }

        // add notice
        $saved_notice = '<div style="font-size:18px;line-height:20px;margin:0px;">'.$notice.'</div>';

        /**
         * Clear full page cache
         */
        if ($options['clear_pagecache']) {
            $this->CTRL->admin->clear_pagecache(false);

            $saved_notice .= '<p style="font-style:italic;font-size:14px;line-height:16px;">Page related caches from <a href="https://github.com/optimalisatie/above-the-fold-optimization/tree/master/trunk/modules/plugins/" target="_blank">supported plugins</a> cleared.</p>';
        }

        $this->set_notice($saved_notice, 'NOTICE');
    }

    /**
     * Display settings page
     */
    public function settings_page()
    {
        global $pagenow, $wp_query;

        // offer
        require_once('admin.offer.inc.php');

        // load options
        $options = get_option('abovethefold');
        if (!is_array($options)) {
            $options = array();
        } ?>
<script>
// pagesearch optgroups
window.abtf_pagesearch_optgroups = <?php print json_encode($this->page_search_optgroups()); ?>;
</script>

<?php

        // active tab
        $tab = $this->active_tab('intro');

        // invalid tab
        if (!isset($this->tabs[$tab])) {
            $tab = 'intro';
        }

        $lgcode = $this->google_lgcode;

        // Google Analytics tracking code
        $utmstring = $this->utm_string;

        // print tabs
        require_once('admin.tabs.inc.php');

         
        // print tab content
        switch ($tab) {
            case "criticalcss":
            case "css":
            case "html":
            case "javascript":
            case "pwa":
            case "http2":
            case "proxy":
            case "settings":
            case "extract":
            case "criticalcss-test":
            case "build-tool":
            case "monitor":
            case "intro":
                require_once('admin.'.$tab.'.inc.php');
            break;
        }
    }

    /**
     * Show admin notices
     */
    public function show_notices()
    {
        settings_errors('abovethefold');

        $notices = get_option('abovethefold_notices', '');
        $persisted_notices = array();
        if (! empty($notices)) {
            $noticerows = array();
            foreach ($notices as $notice) {
                switch (strtoupper($notice['type'])) {
                    case "ERROR":
                        $noticerows[] = '<div class="error">
							<p>
								'.__($notice['text'], 'abovethefold').'
							</p>
						</div>';

                        /**
                         * Error notices remain visible for 1 minute
                         */
                        $expire = (isset($notice['expire']) && is_numeric($notice['expire'])) ? $notice['expire'] : 60;
                        if (isset($notice['date']) && $notice['date'] > (time() - $expire)) {
                            $persisted_notices[] = $notice;
                        }

                    break;
                    default:
                        $noticerows[] = '<div class="updated"><p>
							'.__($notice['text'], 'abovethefold').'
						</p></div>';
                    break;
                }
            } ?>
			<div>
				<?php print implode('', $noticerows); ?>
			</div>
			<?php

            update_option('abovethefold_notices', $persisted_notices, false);
        }
    }

    /**
     * Set admin notice
     */
    public function set_notice($notice, $type = 'NOTICE', $notice_config = array())
    {
        $type = strtoupper($type);

        $notices = get_option('abovethefold_notices', '');
        if (!is_array($notices)) {
            $notices = array();
        }
        if (empty($notice)) {
            delete_option('abovethefold_notices');
        } else {
            $notice_config = (is_array($notice_config)) ? $notice_config : array();
            $notice_config['text'] = $notice;
            $notice_config['type'] = $type;

            array_unshift($notices, $notice_config);
            update_option('abovethefold_notices', $notices, false);
        }
    }

    /**
     * Return newline array from string
     */
    public function newline_array($string, $data = array())
    {
        if (!is_array($data)) {
            $data = array();
        }

        $lines = array_filter(array_map('trim', explode("\n", trim($string))));
        if (!empty($lines)) {
            foreach ($lines as $line) {
                if ($line === '') {
                    continue;
                }
                $data[] = $line;
            }
            $data = array_unique($data);
        }

        return $data;
    }

    /**
     * Return string from newline array
     */
    public function newline_array_string($array)
    {
        if (!is_array($array) || empty($array)) {
            return '';
        }

        return htmlentities(implode("\n", $array), ENT_COMPAT, 'utf-8');
    }

    /**
     * Upgrade plugin
     */
    public function upgrade()
    {
        require_once WPABTF_PATH . 'admin/upgrade.class.php';
        $upgrade = new Abovethefold_Upgrade($this->CTRL);
        $upgrade->upgrade();
    }

    /**
     * File size
     */
    public function human_filesize($bytes, $decimals = 2)
    {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }


    /**
     * Return admin panel SVG icon
     */
    final public function admin_icon($color = false)
    {
        $icon = file_get_contents(WPABTF_PATH.'public/100.svg');
        $icon = 'data:image/svg+xml;base64,'.base64_encode($this->menu_svg_color($icon, $color));

        return $icon;
    }

    /**
     * Fills menu page inline SVG icon color.
     */
    final private function menu_svg_color($svg, $color = false)
    {
        if ($color) {
            $use_icon_fill_color = $color;
        } else {
            if (!($color = get_user_option('admin_color'))) {
                $color = 'fresh';
            }

            /**
             * WordPress admin icon color schemes.
             */
            $wp_admin_icon_colors = array(
                'fresh' => array('base' => '#999999', 'focus' => '#2EA2CC', 'current' => '#FFFFFF'),
                'light' => array('base' => '#999999', 'focus' => '#CCCCCC', 'current' => '#CCCCCC'),
                'blue' => array('base' => '#E5F8FF', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
                'midnight' => array('base' => '#F1F2F3', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
                'sunrise' => array('base' => '#F3F1F1', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
                'ectoplasm' => array('base' => '#ECE6F6', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
                'ocean' => array('base' => '#F2FCFF', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
                'coffee' => array('base' => '#F3F2F1', 'focus' => '#FFFFFF', 'current' => '#FFFFFF'),
            );

            if (empty($wp_admin_icon_colors[$color])) {
                return $svg;
            }
            $icon_colors = $wp_admin_icon_colors[$color];
            $use_icon_fill_color = $icon_colors['base']; // Default base.

            $current_pagenow = !empty($GLOBALS['pagenow']) ? $GLOBALS['pagenow'] : '';
            $current_page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';

            if ($current_page && strpos($_GET['page'], 'pagespeed') === 0) {
                $use_icon_fill_color = $icon_colors['current'];
            }
        }
        
        return preg_replace('|(\s)fill="#000000"|Ui', '$1fill="'.esc_attr($use_icon_fill_color).'"', $svg);
    }
}
