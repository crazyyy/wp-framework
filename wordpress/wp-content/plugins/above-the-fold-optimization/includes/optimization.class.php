<?php

/**
 * Abovethefold optimization functions and hooks.
 *
 * This class provides the functionality for optimization functions and hooks.
 *
 * @since      1.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_Optimization
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * CSS buffer started
     */
    public $css_buffer_started = false;

    /**
     * Optimize CSS delivery
     */
    public $optimize_css_delivery = false;

    /**
     * Optimize Javascript delivery
     */
    public $optimize_js_delivery = false;

    /**
     * HTML Search & Replace
     */
    public $html_replace = false;

    /**
     * Javascript replacement string
     */
    public $js_replacement_string = 'ABTF_JS';

    /**
     * Critical CSS replacement string
     */
    public $criticalcss_replacement_string = 'ABTF_CRITICALCSS';

    /**
     * HTTP/2 Server Push Critical CSS
     */
    public $http2push_criticalcss = false;

    /**
     * Preserve comments
     */
    public $preserve_comments;

    // client config key references
    public $client_config_index;
    public $client_config_ref;

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL = & $CTRL;

        if ($this->CTRL->disabled) {
            return; // above the fold optimization disabled for area / page
        }
        
        // load client config index
        $config_index = WPABTF_PATH . 'public/js/src/config-index.json';
        try {
            if (file_exists($config_index)) {
                $this->client_config_index = json_decode(file_get_contents($config_index), true);
            }
        } catch (Exception $err) {
            $this->client_config_index = false;
        }
        if (!$this->client_config_index) {
            wp_die('Failed to read ' . str_replace(ABSPATH, '', WPABTF_PATH . 'public/js/src/config.index.json'));
        }

        // set key index references
        $this->client_config_ref = array();
        foreach ($this->client_config_index as $position => $key) {
            if (is_string($key)) {
                $this->client_config_ref[$key] = $position;
            } else {
                $keys = array_keys($key);
                $subkeys = $key[$keys[0]];
                $key = $keys[0];

                $this->client_config_ref[$key] = $position;
                $this->client_config_ref[$key . '-sub'] = array();
                foreach ($subkeys as $subposition => $subkey) {
                    $this->client_config_ref[$key . '-sub'][$subkey] = $subposition;
                }
            }
        }

        /**
         * Optimize CSS delivery
         */
        $this->optimize_css_delivery = (isset($this->CTRL->options['cssdelivery']) && intval($this->CTRL->options['cssdelivery']) === 1) ? true : false;

        /**
         * Optimize Javascript loading
         */
        $this->optimize_js_delivery = (isset($this->CTRL->options['jsdelivery']) && intval($this->CTRL->options['jsdelivery']) === 1) ? true : false;

        /**
         * HTML Search & Replace
         */
        $this->html_replace = (isset($this->CTRL->options['html_search_replace']) && is_array($this->CTRL->options['html_search_replace']) && !empty($this->CTRL->options['html_search_replace'])) ? $this->CTRL->options['html_search_replace'] : false;


        // ignore critical css view controller in javascript optimization
        if ($this->CTRL->view === 'critical-css-view') {
            add_filter('abtf_jsfile_pre', function ($file) {
                if (strpos($file, 'critical-css-view.min.js') !== false) {
                    return 'ignore';
                }

                return $file;
            });
        }

        /**
         * Extract Full CSS view
         */
        if (in_array($this->CTRL->view, array('extract-css','abtf-buildtool-css'))) {

            // load optimization controller
            $this->CTRL->extractcss = new Abovethefold_ExtractFullCss($this->CTRL);
        } elseif ($this->CTRL->view === 'critical-css-editor') {

            /**
             * Compare Critical CSS view
             */
            $this->CTRL->critical_css_test = new Abovethefold_CriticalCSSEditor($this->CTRL);
        } else {

            /**
             * Standard view
             */
            
            /**
             * Check if an optimization module offers an output buffer hook
             */
            if (!$this->CTRL->plugins->html_output_hook($this)) {

                /**
                 * Use Above The Fold Optimization standard output buffer
                 */
                $this->CTRL->loader->add_action('init', $this, 'start_output_buffer', 99999);

                /**
                 * Move output buffer to front of other buffers
                 * /
                 * $this->CTRL->loader->add_action('template_redirect', $this, 'move_ob_to_front',99999);
                 */
            }
        }

        // wordpress header
        $this->CTRL->loader->add_action('wp_head', $this, 'header', 1);
    }

    /**
     * Init output buffering
     */
    public function start_output_buffer()
    {

        /**
         * Re-check if an optimization module offers an output buffer hook, the buffer may be started in the init hook
         */
        if (!$this->CTRL->plugins->html_output_hook($this)) {

            // set output buffer
            ob_start(array($this, 'process_output_buffer'));
        }
    }

    /**
     * Move Above The Fold Optimization output buffer to front
     */
    public function move_ob_to_front()
    {

        // get active output buffers
        $ob_callbacks = ob_list_handlers();

        // check if Above The Fold Optimization is last output buffer
        // try to move to front
        if (
            !empty($ob_callbacks)
            && in_array('Abovethefold_Optimization::process_output_buffer', $ob_callbacks)
            && $ob_callbacks[(count($ob_callbacks) - 1)] !== 'Abovethefold_Optimization::process_output_buffer'
         ) {
            $callbacks_to_move = array();

            $n = count($ob_callbacks) - 1;
            while ($ob_callbacks[$n] && $ob_callbacks[$n] !== 'Abovethefold_Optimization::process_output_buffer') {
                if ($ob_callbacks[$n] === 'default output handler') {
                    $callbacks_to_move[] = false;
                } else {
                    if (strpos($ob_callbacks[$n], '::') !== false) {
                        $callback = explode('::', $ob_callbacks[$n]);

                        // check if singleton
                        if (is_callable($callback[0].'::getInstance')) {
                            $callbacks_to_move[] = array( call_user_func(array( $callback[0], 'getInstance' )), $callback[1]);
                        } elseif (is_callable($callback[0].'::singleton')) {
                            $callbacks_to_move[] = array( call_user_func(array( $callback[0], 'singleton' )), $callback[1]);
                        } else {
                            $callbacks_to_move[] = $ob_callbacks[$n];
                        }
                    } else {
                        $callbacks_to_move[] = $ob_callbacks[$n];
                    }
                }
                
                $n--;
            }

            // end output buffers in front of Above The Fold output buffer
            foreach ($callbacks_to_move as $callback) {
                ob_end_clean();
            }

            // end above the fold output buffer
            ob_end_clean();

            // restore output buffers
            $callbacks_to_restore = array_reverse($callbacks_to_move);
            foreach ($callbacks_to_restore as $callback) {
                if ($callback) {
                    @ob_start($callback);
                } else {
                    // ignore output buffers without callback
                    // @todo
                }
            }

            // restore Above The Fold Optimization output buffer in front
            ob_start(array($this, 'process_output_buffer'));

            $ob_callbacks = ob_list_handlers();
        }
    }

    /**
     * Extract stylesheets from HTML
     */
    public function extract_stylesheets($HTML)
    {
        $stylesheets = array();

        // stylesheet regex
        $stylesheet_regex = '#(<\!--\[if[^>]+>\s*)?<link[^>]+>#is';

        if (preg_match_all($stylesheet_regex, $HTML, $out)) {
            foreach ($out[0] as $n => $stylesheet) {

                /**
                 * Conditional, skip
                 */
                if (trim($out[1][$n]) != '') {
                    continue 1;
                }

                /**
                 * No href or rel="stylesheet", skip
                 */
                if (strpos($stylesheet, 'href') === false
                    || strpos($stylesheet, 'stylesheet') === false

                    // ignore HTTP/2 server push stylesheet
                    || (strpos($stylesheet, 'AbtfCSS') !== false)
                    
                    || !preg_match('#href\s*=\s*["\']([^"\']+)["\']#i', $stylesheet, $hrefOut)) {
                    continue 1;
                }

                $stylesheets[] = array($hrefOut[1],$out[0][$n]);
            }
        }

        return $stylesheets;
    }

    /**
     * Extract scripts from HTML
     */
    public function extract_scripts($HTML)
    {
        $scripts = array();

        // script regex
        $script_regex = '#(<\!--\[if[^>]+>\s*)?<script[^>]+src[^>]+>([^<]*</script>)?#is';

        if (preg_match_all($script_regex, $HTML, $out)) {
            foreach ($out[0] as $n => $script) {

                /**
                 * Conditional, skip
                 */
                if (trim($out[1][$n]) != '') {
                    continue 1;
                }

                /**
                 * No src, skip
                 */
                if (strpos($script, 'src') === false || !preg_match('#src\s*=\s*["\']([^"\']+)["\']#i', $script, $srcOut)) {
                    continue 1;
                }

                $scripts[] = array(
                    $srcOut[1],  // script
                    $out[0][$n] // tag
                );
            }
        }

        return $scripts;
    }

    /**
     * Get script dependencies
     */
    public function wp_script_dependencies()
    {
        global $wp_scripts;

        $scriptdeps = array();
        $dependencygroups = array();
        $dependencyreferences = array();

        if (isset($wp_scripts) && isset($wp_scripts->done) && !empty($wp_scripts->done)) {

            // load dependency references from WordPress scripts
            foreach ($wp_scripts->done as $handle) {
                if (isset($wp_scripts->registered[$handle]) && isset($wp_scripts->registered[$handle]->handle)) {

                    // Handle
                    $handle = (string) $wp_scripts->registered[$handle]->handle;
                    if (trim($handle) === '') {
                        continue 1;
                    }

                    $handleindex = array_search($handle, $dependencyreferences);
                    if ($handleindex === false) {
                        $handleindex = count($dependencyreferences);
                        $dependencyreferences[$handleindex] = $handle;
                    }

                    $deps = array();
                    $handledeps = (isset($wp_scripts->registered[$handle]->deps) && is_array($wp_scripts->registered[$handle]->deps)) ? $wp_scripts->registered[$handle]->deps : array();

                    // jquery migrate is part of jquery group
                    if ($handle === 'jquery-migrate') {
                        // wait for jquery-core
                        $handledeps[] = 'jquery-core';
                    }

                    // admin-bar requires jquery
                    if ($handle === 'admin-bar') {
                        // wait for jquery
                        $handledeps[] = 'jquery';
                    }

                    if (!empty($handledeps)) {
                        foreach ($handledeps as $dep) {
                            if (trim($dep) === '') {
                                continue;
                            }

                            $depindex = array_search($dep, $dependencyreferences);
                            if ($depindex === false) {
                                $depindex = count($dependencyreferences);
                                $dependencyreferences[$depindex] = $dep;
                            }

                            $deps[] = $depindex;

                            $scriptdepsrefs[] = array($depindex,$dep);
                        }
                    }

                    if (!isset($wp_scripts->registered[$handle]->src) || trim($wp_scripts->registered[$handle]->src) === '') {

                        // group reference
                        if (!empty($deps)) {
                            $dependencygroups[$handleindex] = $deps;
                        }
                    } else {
                        $scriptdeps[str_replace(home_url(), '', $wp_scripts->registered[$handle]->src)] = array(
                            $handleindex,
                            $deps
                        );
                    }
                }
            }
        }

        return array($scriptdeps,$dependencygroups,$dependencyreferences);
    }

    /**
     * Rewrite callback
     */
    public function process_output_buffer($buffer)
    {

        // disabled, do not process buffer
        if (!$this->CTRL->is_enabled()) {
            return $buffer;
        }

        if ($this->CTRL->view === 'abtf-buildtool-html') {
            return $buffer;
        }

        // search / replace
        $search = array();
        $replace = array();

        // search / replace regex
        $search_regex = array();
        $replace_regex = array();

        // apply pre HTML filters
        $buffer = apply_filters('abtf_html_pre', $buffer);

        /**
         * CSS Delivery Optimization
         */
        if ($this->optimize_css_delivery) {

            /**
             * Ignore List
             *
             * Matching files will be ignored / left untouched in the HTML
             */
            $ignorelist = array();
            if (isset($this->CTRL->options['cssdelivery_ignore']) && !empty($this->CTRL->options['cssdelivery_ignore'])) {
                foreach ($this->CTRL->options['cssdelivery_ignore'] as $row) {
                    $ignorelist[] = $row;
                }
            }

            /**
             * Delete List
             *
             * Matching files will be removed from the HTML
             */
            $deletelist = array();
            if (isset($this->CTRL->options['cssdelivery_remove']) && !empty($this->CTRL->options['cssdelivery_remove'])) {
                foreach ($this->CTRL->options['cssdelivery_remove'] as $row) {
                    $deletelist[] = $row;
                }
            }

            /**
             * Parse CSS links
             */
            $async_styles = array();

            $stylesheets = $this->extract_stylesheets($buffer);
            if (!empty($stylesheets)) {
                foreach ($stylesheets as $stylesheet) {
                    list($file, $matchedTag) = $stylesheet;
                    if (empty($file)) {
                        continue 1;
                    }

                    // apply css file filter pre processing
                    $filterResult = apply_filters('abtf_cssfile_pre', $file);

                    if (is_array($filterResult)) {
                        if ($filterResult[1] === 'ignore') {

                            // replace URL and ignore optimization
                            $search[] = $matchedTag;
                            $replace[] = str_replace($file, $filterResult[0], $matchedTag);
                            continue;
                        } else {
                            // not supported
                            $filterResult = false;
                        }
                    }

                    // ignore file
                    if ($filterResult === 'ignore') {
                        continue;
                    }

                    // delete file
                    if ($filterResult === 'delete') {

                        // delete from HTML
                        $search[] = $matchedTag;
                        $replace[] = '';
                        continue;
                    }

                    // replace url
                    if ($filterResult && $filterResult !== $file) {
                        $file = $filterResult;
                    }

                    // match file against ignore list
                    if (!empty($ignorelist)) {
                        $ignore = false;
                        foreach ($ignorelist as $ignored_file_string) {
                            if (strpos($file, $ignored_file_string) !== false) {
                                $ignore = true;
                                break 1;
                            }
                        }
                        if ($ignore) {
                            continue;
                        }
                    }

                    // match file against delete list
                    if (!empty($deletelist)) {
                        $delete = false;
                        foreach ($deletelist as $deleted_file_string) {
                            if (strpos($file, $deleted_file_string) !== false) {
                                $delete = true;
                                break 1;
                            }
                        }
                        if ($delete) {
                            $search[] = $matchedTag;
                            $replace[] = '';
                            continue;
                        }
                    }

                    // Detect media for file
                    $media = false;
                    if (strpos($matchedTag, 'media=') !== false) {
                        $el = (array)simplexml_load_string($matchedTag);
                        $media = trim($el['@attributes']['media']);
                    }
                    if (!$media) {
                        $media = 'all';
                    }

                    /**
                     * Convert HTML entities
                     */
                    $media = html_entity_decode($media, ENT_COMPAT, 'utf-8');
                    $file = html_entity_decode($file, ENT_COMPAT, 'utf-8');

                    // convert media to array
                    $media = explode(',', $media);

                    // add file to style array to be processed
                    $async_styles[] = array($media,$file);
                    
                    $search[] = $matchedTag;
                    $replace[] = '';
                }
            }
        } else {

            /**
             * Filter CSS files
             */
            if ($this->CTRL->options['gwfo'] || $this->CTRL->options['css_proxy'] || $this->CTRL->view === 'critical-css-view') {
                $stylesheets = $this->extract_stylesheets($buffer);
                if (!empty($stylesheets)) {
                    foreach ($stylesheets as $stylesheet) {
                        list($file, $matchedTag) = $stylesheet;
                        if (empty($file)) {
                            continue 1;
                        }

                        // apply filter for css file pre processing
                        $filterResult = apply_filters('abtf_cssfile_pre', $file);

                        // ignore file
                        if ($filterResult === 'ignore') {
                            continue;
                        }

                        // delete file
                        if ($filterResult === 'delete' || $this->CTRL->view === 'critical-css-view') {

                            // delete from HTML
                            $search[] = $matchedTag;
                            $replace[] = '';
                            continue;
                        }

                        // replace url
                        if ($filterResult && $filterResult !== $file) {

                            // change file in original tag
                            $newTag = str_replace($file, $filterResult, $matchedTag);
                            
                            $search[] = $matchedTag;
                            $replace[] = $newTag;
                        }
                    }
                }
            }
        }


        /**
         * Javascript Delivery Optimization
         */
        if ($this->optimize_js_delivery) {

            /**
             * Ignore List
             *
             * Matching files will be ignored / left untouched in the HTML
             */
            $ignorelist = array();
            if (isset($this->CTRL->options['jsdelivery_ignore']) && !empty($this->CTRL->options['jsdelivery_ignore'])) {
                foreach ($this->CTRL->options['jsdelivery_ignore'] as $row) {
                    $ignorelist[] = $row;
                }
            }

            /**
             * Delete List
             *
             * Matching files will be removed from the HTML
             */
            $deletelist = array();
            if (isset($this->CTRL->options['jsdelivery_remove']) && !empty($this->CTRL->options['jsdelivery_remove'])) {
                foreach ($this->CTRL->options['jsdelivery_remove'] as $row) {
                    $deletelist[] = $row;
                }
            }

            /**
             * Force Async for all scripts
             */
            $forceAsync = (isset($this->CTRL->options['jsdelivery_async_all']) && intval($this->CTRL->options['jsdelivery_async_all']) === 1) ? true : false;

            /**
             * Async Force List
             *
             * Matching files will be loaded asynchrounously
             */
            $asynclist = array();
            if (!$forceAsync && isset($this->CTRL->options['jsdelivery_async']) && !empty($this->CTRL->options['jsdelivery_async'])) {
                foreach ($this->CTRL->options['jsdelivery_async'] as $row) {
                    $asynclist[] = $row;
                }
            }

            /**
             * Async Disabled List
             *
             * Matching files will be loaded non-async (blocking)
             */
            $async_disabledlist = array();
            if (isset($this->CTRL->options['jsdelivery_async_disabled']) && !empty($this->CTRL->options['jsdelivery_async_disabled'])) {
                foreach ($this->CTRL->options['jsdelivery_async_disabled'] as $row) {
                    $async_disabledlist[] = $row;
                }
            }

            /**
             * Load WordPRess dependencies
             */
            if (isset($this->CTRL->options['jsdelivery_deps']) && $this->CTRL->options['jsdelivery_deps']) {
                list($wp_script_deps, $wp_script_depgroups, $wp_script_deprefs) = $this->wp_script_dependencies();
            } else {
                $wp_script_deps = false;
            }

            /**
             * Parse scripts
             */
            $optimized_scripts = array();

            $scripts = $this->extract_scripts($buffer);
            if (!empty($scripts)) {
                foreach ($scripts as $script) {
                    list($file, $matchedTag) = $script;
                    if (empty($file)) {
                        continue 1;
                    }

                    // apply css file filter pre processing
                    $filterResult = apply_filters('abtf_jsfile_pre', $file);

                    // ignore file
                    if ($filterResult === 'ignore') {
                        continue;
                    }

                    // delete file
                    if ($filterResult === 'delete') {

                        // delete from HTML
                        $search[] = $matchedTag;
                        $replace[] = '';
                        continue;
                    }

                    // replace url
                    if ($filterResult && $filterResult !== $file) {
                        $file = $filterResult;
                    }

                    // match file against ignore list
                    if (!empty($ignorelist)) {
                        $ignore = false;
                        foreach ($ignorelist as $ignored_file_string) {
                            if (strpos($file, $ignored_file_string) !== false) {
                                $ignore = true;
                                break 1;
                            }
                        }
                        if ($ignore) {
                            continue;
                        }
                    }

                    // match file against delete list
                    if (!empty($deletelist)) {
                        $delete = false;
                        foreach ($deletelist as $deleted_file_string) {
                            if (strpos($file, $deleted_file_string) !== false) {
                                $delete = true;
                                break 1;
                            }
                        }
                        if ($delete) {
                            $search[] = $matchedTag;
                            $replace[] = '';
                            continue;
                        }
                    }

                    // async loading
                    $async = -1;

                    // match file against async disabled list
                    if (!empty($async_disabledlist)) {
                        foreach ($async_disabledlist as $disabled_file_string) {
                            if (strpos($file, $disabled_file_string) !== false) {
                                $async = false;
                                break 1;
                            }
                        }
                    }

                    if ($async === -1 && $forceAsync) {
                        $async = true;
                    }

                    // match file against async force list
                    if ($async === -1 && !$forceAsync && !empty($asynclist)) {
                        foreach ($asynclist as $async_file_string) {
                            if (strpos($file, $async_file_string) !== false) {
                                $async = true;
                                break 1;
                            }
                        }
                    }

                    // async script tag
                    if ($async === -1) {
                        $async = (strpos($matchedTag, ' async') !== false || strpos($matchedTag, ' defer') !== false);
                    }

                    $handle = false;
                    $deps = false;

                    // check for dependencies
                    if ($wp_script_deps) {
                        foreach ($wp_script_deps as $script => $scriptdeps) {
                            if (strpos($file, $script) !== false) {

                                // found
                                $handle = $scriptdeps[0];
                                $deps = $scriptdeps[1];
                                break;
                            }
                        }
                    }

                    // decode file
                    $file = html_entity_decode($file, ENT_COMPAT, 'utf-8');

                    // add file to style array to be processed
                    $optimized_scripts[] = array($file,$async,$handle,$deps);
                    
                    $search[] = $matchedTag;
                    $replace[] = '';
                }
            }
        } else {

            /**
             * Filter Javascript files
             */
            if ($this->CTRL->options['js_proxy']) {
                $scripts = $this->extract_scripts($buffer);
                if (!empty($scripts)) {
                    foreach ($scripts as $script) {
                        list($file, $matchedTag) = $script;
                        if (empty($file)) {
                            continue 1;
                        }

                        // apply filter for css file pre processing
                        $filterResult = apply_filters('abtf_jsfile_pre', $file);

                        // ignore file
                        if ($filterResult === 'ignore') {
                            continue;
                        }

                        // delete file
                        if ($filterResult === 'delete') {

                            // delete from HTML
                            $search[] = $matchedTag;
                            $replace[] = '';
                            continue;
                        }

                        // replace url
                        if ($filterResult && $filterResult !== $file) {
                            
                            // change file in original tag
                            $newTag = str_replace($file, $filterResult, $matchedTag);
                            
                            $search[] = $matchedTag;
                            $replace[] = $newTag;
                        }
                    }
                }
            }
        }

        /**
         * CSS Delivery Optimization
         */
        if ($this->optimize_css_delivery) {

            /**
             * Remove full CSS and show critical CSS only
             */
            if ($this->CTRL->view === 'critical-css-view') { // , 'abtf-buildtool-html'

                // do not render the stylesheet files
                $styles_json = 'false';
            } else {

                /**
                 * Remove duplicate CSS files
                 */
                $reflog = array();
                $styles = array();
                if (isset($async_styles) && !empty($async_styles)) {
                    foreach ($async_styles as $link) {
                        if (isset($reflog[$link[1]])) {
                            continue 1;
                        }
                        $reflog[$link[1]] = 1;
                        $styles[] = $link;
                    }
                }

                if (defined('JSON_UNESCAPED_SLASHES')) {
                    $styles_json = json_encode($styles, JSON_UNESCAPED_SLASHES);
                } else {
                    $styles_json = str_replace('\\/', '/', json_encode($styles));
                }
            }
        
            /**
             * Update CSS JSON configuration
             */
            $search[] = '"'.$this->criticalcss_replacement_string    .'"';
            $replace[] = esc_attr($styles_json);
        }

        /**
         * Javascript Delivery Optimization
         */
        if ($this->optimize_js_delivery) {

            /**
             * Remove duplicate Javascript files
             */
            $reflog = array();
            $scripts = array();
            if (isset($optimized_scripts) && !empty($optimized_scripts)) {
                foreach ($optimized_scripts as $script) {
                    if (isset($reflog[$script[0]])) {
                        continue 1;
                    }
                    $reflog[$script[0]] = 1;
                    $scripts[] = $script;
                }
            }

            $scripts_data = array($scripts);
            if ($wp_script_deps === false) {
                $scripts_data[] = false;
            } else {
                $scripts_data[] = $wp_script_depgroups;
                $scripts_data[] = $wp_script_deprefs;
            }

            if (defined('JSON_UNESCAPED_SLASHES')) {
                $scripts_json = json_encode($scripts_data, JSON_UNESCAPED_SLASHES);
            } else {
                $scripts_json = str_replace('\\/', '/', json_encode($scripts_data));
            }

            /**
             * Update Javascript JSON configuration
             */
            $search[] = '"'.$this->js_replacement_string    .'"';
            $replace[] = $scripts_json;
        }

        // apply search replace filter
        $searchreplace = apply_filters('abtf_html_replace', array($search,$replace,$search_regex,$replace_regex));
        if (is_array($searchreplace) && count($searchreplace) === 4) {
            list($search, $replace, $search_regex, $replace_regex) = $searchreplace;
        }

        // HTML Search & Replace configuration
        if ($this->html_replace) {
            foreach ($this->html_replace as $cnf) {
                if (!is_array($cnf) || !isset($cnf['search']) || !isset($cnf['replace'])) {
                    continue;
                }
                if (isset($cnf['regex'])) {
                    $search_regex[] = $cnf['search'];
                    $replace_regex[] = $cnf['replace'];
                } else {
                    $search[] = $cnf['search'];
                    $replace[] = $cnf['replace'];
                }
            }
        }

        // update buffer
        if (!empty($search)) {
            try {
                $replaced = str_replace($search, $replace, $buffer);
            } catch (Exception $e) {
                $replaced = false;
            }
            if ($replaced) {
                $buffer = $replaced;
            }
        }
        if (!empty($search_regex)) {
            try {
                $replaced = preg_replace($search_regex, $replace_regex, $buffer);
            } catch (Exception $e) {
                $replaced = false;
            }
            if ($replaced) {
                $buffer = $replaced;
            }
        }

        // apply HTML filters
        try {
            $replaced = apply_filters('abtf_html', $buffer);
        } catch (Exception $e) {
            $replaced = false;
        }
        if ($replaced) {
            $buffer = $replaced;
        }
        
        // strip comments
        if (isset($this->CTRL->options['html_comments']) && $this->CTRL->options['html_comments']) {

            // preserve comments
            $this->preserve_comments = (isset($this->CTRL->options['html_comments_preserve']) && !empty($this->CTRL->options['html_comments_preserve'])) ? $this->CTRL->options['html_comments_preserve'] : array();

            try {
                $replaced = preg_replace_callback(
                '/<!--([\\s\\S]*?)-->/',
                    array($this, 'remove_comments'),
                    $buffer
                );
            } catch (Exception $e) {
                $replaced = false;
            }
            if ($replaced) {
                $buffer = $replaced;
            }
        }

        // minify HTML
        if (isset($this->CTRL->options['html_minify']) && $this->CTRL->options['html_minify']) {
            $buffer = $this->minify_html($buffer);
        }

        return $buffer;
    }

    /**
     * WordPress Header hook
     */
    public function header()
    {
        if ($this->CTRL->disabled) {
            return;
        }

        /**
         * Add noindex meta to prevent indexing in Google
         */
        if ($this->CTRL->view) {

            // send noindex HTTP header
            if (!headers_sent()) {
                header("X-Robots-Tag: noindex, nofollow", true);
            }
            
            print '<meta name="robots" content="noindex, nofollow" />';
        }

        if (in_array($this->CTRL->view, array('critical-css-view', 'full-css-view'))) {
            require_once WPABTF_PATH . 'includes/critical-css-view-header.inc.php';
        }

        // debug enabled?
        $debug = (current_user_can('administrator') && intval($this->CTRL->options['debug']) === 1) ? true : false;

        /**
         * Load Critical CSS
         */
        $inlineCSS = $this->CTRL->criticalcss->get();

        // HTTP/2 Push Critical CSS
        if (isset($this->CTRL->options['http2_push_criticalcss']) && $this->CTRL->options['http2_push_criticalcss']) {
            $this->http2push_criticalcss = $this->CTRL->criticalcss->http2_push_file($inlineCSS);
        }

        /**
         * Optimize CSS delivery
         */
        if ($this->optimize_css_delivery) {
            $headCSS = ($this->CTRL->options['cssdelivery_position'] === 'header') ? true : false;
        } else {

            // do not load CSS
            $headCSS = false;
        }

        // client script and settings
        $clientjs = $this->get_client_script($debug);


        // print HTML such as meta
        if ($clientjs['html_before']) {
            print $clientjs['html_before'];
        }

        // print javascript
        print '<script '.((!defined('ABTF_NOREF') || !ABTF_NOREF) ? 'data-ref="https://goo.gl/C1gw96"' : '').' data-abtf=\''.str_replace('\'', '&#39;', json_encode($clientjs['config'])).'\'>'.$clientjs['client'].'</script>';

        // HTTP/2 Server Push Critical CSS
        if ($this->http2push_criticalcss) {
            print '<link href="'.$this->http2push_criticalcss.'" media="all" rel="stylesheet" id="AbtfCSS" data-abtf/>';
        }

        // print meta
        if ($clientjs['html_after']) {
            print $clientjs['html_after'];
        }

        // inline Critical CSS
        if (!$this->http2push_criticalcss) {
            print '<style type="text/css" id="AbtfCSS" data-abtf>' . $inlineCSS . '</style>';
        }
    }

    /**
     * Get client script code
     */
    public function get_client_script($debug = false)
    {
        $html_before = $html_after = '';

        // Inline js
        $script_code = '';
        $script_code_before = '';

        // javascript debug extension
        $jsdebug = ($debug) ? '.debug' : '';

        /**
         * Inline settings JSON
         */
        $jssettings = array();
        
        /**
         * Javascript client files to combine
         */
        $jsfiles = array();

        /**
         * Google Web Font Loader Inline
         */
        if ($this->CTRL->options['gwfo']) {

            // get web font loader client
            $this->CTRL->gwfo->client_jssettings($jssettings, $jsfiles, $inlineJS, $jsdebug, $script_code_before);
        }

        /** main client controller */
        $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold'.$jsdebug.'.min.js';

        /**
         * Google PWA Optimization
         */
        $this->CTRL->pwa->client_jssettings($jssettings, $jsfiles, $script_code, $jsdebug, $html_before);

        /**
         * HTTP/2 optimization
         */
        $this->CTRL->http2->client_jssettings($html_after);

        // Proxy external files
        if ($this->CTRL->options['js_proxy'] || $this->CTRL->options['css_proxy']) {

            // get proxy client
            $this->CTRL->proxy->client_jssettings($jssettings, $jsfiles, $jsdebug);
        }

        /**
         * Javascript delivery optimization
         */
        if ($this->optimize_js_delivery) {

            // jQuery ready stub
            if (isset($this->CTRL->options['jsdelivery_jquery']) && $this->CTRL->options['jsdelivery_jquery']) {
                $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-jquery-stub'.$jsdebug.'.min.js';
            }

            $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-js'.$jsdebug.'.min.js';

            // script loader
            if (isset($this->CTRL->options['jsdelivery_scriptloader']) && $this->CTRL->options['jsdelivery_scriptloader'] !== 'little-loader') {

                // proxy is required for HTML5 script loader
                if ($this->CTRL->options['jsdelivery_scriptloader'] === 'html5' && $this->CTRL->options['js_proxy']) {
                    $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-js-localstorage'.$jsdebug.'.min.js';
                }
            }
        }

        /**
         * CSS delivery optimization
         */
        if ($this->optimize_css_delivery) {
            $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-css'.$jsdebug.'.min.js';

            /** Async CSS controller */
            if (intval($this->CTRL->options['loadcss_enhanced']) === 1) {
                $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-loadcss-enhanced'.$jsdebug.'.min.js';
            } else {
                $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-loadcss'.$jsdebug.'.min.js';
            }
        }

        /**
         * Combine javascript files into inline code
         */
        foreach ($jsfiles as $file) {
            if (!file_exists($file)) {
                continue 1;
            }
            $js = trim(file_get_contents($file));
            if (substr($js, -1) !== ';') {
                $js .= ' ';
            }
            $script_code .= $js;
        }

        /**
         * Optimize Javascript delivery
         */
        if ($this->optimize_js_delivery) {
            $jssettings[$this->client_config_ref['js']] = array($this->js_replacement_string,($this->CTRL->options['jsdelivery_position'] === 'footer') ? true : false);
            if (isset($this->CTRL->options['jsdelivery_idle']) && !empty($this->CTRL->options['jsdelivery_idle'])) {
                $jssettings[$this->client_config_ref['js']][] = $this->CTRL->options['jsdelivery_idle'];
            }
        }

        /**
         * Optimize CSS delivery
         */
        if ($this->optimize_css_delivery) {
            $jssettings[$this->client_config_ref['css']] = $this->criticalcss_replacement_string;

            if (isset($this->CTRL->options['cssdelivery_renderdelay']) && intval($this->CTRL->options['cssdelivery_renderdelay']) > 0) {
                $jssettings[$this->client_config_ref['css_delay']] = intval($this->CTRL->options['cssdelivery_renderdelay']);
            }

            if (!isset($this->CTRL->options['cssdelivery_position']) || $this->CTRL->options['cssdelivery_position'] !== 'header') {
                $jssettings[$this->client_config_ref['css_footer']] = true;
            }
        }

        $max = 0;
        foreach ($jssettings as $index => $value) {
            if ($index > $max) {
                $max = $index;
            }
        }
        if ($max > 0) {
            for ($i = 0; $i <= $max; $i++) {
                if (!isset($jssettings[$i])) {
                    $jssettings[$i] = -1;
                }
            }
            ksort($jssettings);
        }

        return array(
            'html_before' => $html_before,
            'html_after' => $html_after,
            'config' => $jssettings,
            'client' => trim($script_code_before . 'window.Abtf={};' . $script_code . 'Abtf['.$this->client_config_ref['header_load'].']();')
        );
    }

    /**
     * Get client script hash
     */
    public function get_client_script_hash($debug = false, $algorithm = 'sha256')
    {
        $script = $this->get_client_script($debug);

        return base64_encode(hash($algorithm, $script['client'], true));
    }

    /**
     * Minify HTML
     */
    public function minify_html($HTML)
    {
       
        // use PHP minifier
        require_once WPABTF_PATH . 'includes/HTML.php';
        $htmlmin = new ABTF_HTMLMinify();

        // try minification
        try {
            $minified = $htmlmin->minify($HTML);
        } catch (Exception $err) {
            $minified = false;
        }

        if ($minified) {
            return $minified;
        }

        return $HTML;
    }

    /**
     * Remove comments from HTML
     *
     * @param  array  $match The preg_replace_callback match result.
     * @return string The modified string.
     */
    public function remove_comments($match)
    {
        if (!empty($this->preserve_comments)) {
            foreach ($this->preserve_comments as $str) {
                if (strpos($match[1], $str) !== false) {
                    return $match[0];
                }
            }
        }

        return (0 === strpos($match[1], '[') || false !== strpos($match[1], '<!['))
            ? $match[0]
            : '';
    }
}
