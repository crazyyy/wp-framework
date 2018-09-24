<?php

/**
 * Abovethefold critical css optimization functions and hooks.
 *
 * This class provides the functionality for critical css  related functions and hooks.
 *
 * @since      2.7
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Critical_CSS
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL = & $CTRL;
    }

    /**
     * Get theme based critical CSS configuration
     */
    public function get_theme_criticalcss()
    {
        $errors = array();

        // get config cache
        $fileconfig = get_option('abovethefold-criticalcss', array());
        if (!is_array($fileconfig)) {
            $fileconfig = array();
        }

        // read critical CSS files from theme directory (/abovethefold/critical-css/)
        $criticalcss_dir = $this->CTRL->theme_path('critical-css');
        $criticalcss_files = (is_dir($criticalcss_dir)) ? array_diff(scandir($criticalcss_dir), array('..', '.')) : array();

        // update config?
        $updated = false;

        // process files
        $newfileconfig = array();
        foreach ($criticalcss_files as $file) {
            if (substr($file, -4) !== '.css') {
                // not a css file
                continue 1;
            }

            // global critical CSS
            if ($file === 'global.css') {
                if (!isset($fileconfig[$file]) || filemtime($criticalcss_dir . $file) > $fileconfig[$file]['t']) {
                    $fileconfig[$file] = array(
                        'file' => $criticalcss_dir . $file,
                        't' => filemtime($criticalcss_dir . $file),
                        'weight' => 0
                    );
                    $updated = true;
                }

                $newfileconfig[$file] = $fileconfig[$file];
            } else {

                // check if the config should be updated
                if (!isset($fileconfig[$file]) || filemtime($criticalcss_dir . $file) > $fileconfig[$file]['t']) {
                    $css = trim(file_get_contents($criticalcss_dir . $file));
                    if ($css !== '') {
                        if (!preg_match('|^/\*(.*?)\*/|is', $css, $output)) {
                            $errors[] = array(
                                'message' => 'Critical CSS contains no config header.<br /><br /><textarea style="width:100%;height:150px;">'.htmlentities($css, ENT_COMPAT, 'utf-8').'</textarea>'
                            );
                            continue 1;
                        }
                    }

                    // name
                    if (preg_match('|^\s*\*[\s\*]+([^\n]+)|is', $output[1], $nameout)) {
                        $criticalcss_name = trim($nameout[1]);
                    } else {
                        $criticalcss_name = ucfirst(trim(preg_replace(array('|\.css$|Ui','|\-+|is'), array('',' '), $file)));
                    }

                    $config = array();
                    if (preg_match_all('|\@([^\@\s]*)(\s+([^\n\@]*))?\n|is', $output[1], $matches)) {
                        foreach ($matches[1] as $n => $key) {
                            $key = trim($key);
                            switch ($key) {
                                case "condition":
                                    $key = 'conditions';
                                    if (!isset($config[$key])) {
                                        $config[$key] = array();
                                    }
                                    $condition = trim($matches[2][$n]);
                                    if ($condition === '') {
                                        continue 1; // ignore
                                    }
                                    if (strpos($condition, ':') !== false) {
                                        $split = explode(':', $condition, 2);
                                        $condition_key = $split[0];
                                        $data = $split[1];

                                        switch ($condition_key) {
                                            case "filter":
                                                if (strpos($data, ':') !== false) {
                                                    $datasplit = explode(':', $data, 2);
                                                    $filtername = $datasplit[0];
                                                    $data = @json_decode('[' . trim($datasplit[1]) . ']');
                                                    if (!is_array($data) || empty($data)) {
                                                        $errors[] = array(
                                                            'message' => 'Failed to parse filter params for filter <strong>'.htmlentities(trim($filtername), ENT_COMPAT, 'utf-8').'</strong> ('.htmlentities(trim($datasplit[1]), ENT_COMPAT, 'utf-8').'). The parameters should be JSON encoded, e.g. <code>"param1","param2"</code>.'
                                                        );
                                                        continue 1;
                                                    }
                                                    foreach ($data as $dn => $datavalue) {
                                                        if (is_string($datavalue) && substr($datavalue, 0, 1) === '"') {
                                                            $data[$dn] = json_decode($datavalue);
                                                        }
                                                    }
                                                } else {
                                                    $filtername = $data;
                                                    $data = false;
                                                }
                                                if (!isset($config[$key][$condition_key])) {
                                                    $config[$key][$condition_key] = array();
                                                }
                                                $config[$key][$condition_key][$filtername] = $data;
                                            break;
                                            default:
                                                $data = @json_decode('[' . trim($split[1]) . ']');
                                                if (!is_array($data) || empty($data)) {
                                                    $errors[] = array(
                                                        'message' => 'Failed to parse filter params for filter <strong>'.htmlentities(trim($filtername), ENT_COMPAT, 'utf-8').'</strong> ('.htmlentities(trim($datasplit[1]), ENT_COMPAT, 'utf-8').'). The parameters should be JSON encoded, e.g. <code>"param1","param2"</code>.'
                                                    );
                                                    continue 1;
                                                }

                                                foreach ($data as $dn => $datavalue) {
                                                    if (is_string($datavalue) && substr($datavalue, 0, 1) === '"') {
                                                        $data[$dn] = json_decode($datavalue);
                                                    }
                                                }

                                                if (!isset($config[$key][$condition_key])) {
                                                    $config[$key][$condition_key] = array();
                                                }

                                                $config[$key][$condition_key] = array_unique(array_merge($config[$key][$condition_key], $data));
                                            break;
                                        }
                                    } else {
                                        //$condition = array($condition);
                                        $condition_key = $condition;
                                        $condition_data = false;

                                        $config[$key][$condition_key] = $condition_data;
                                    }
                                break;
                                case "append":
                                case "prepend":
                                    if (!isset($config[$key])) {
                                        $config[$key] = array();
                                    }
                                    $append = trim($matches[2][$n]);

                                    // file
                                    if ($append !== '' && strpos($append, '/') !== false) {

                                        // resolve relative path from critical-css directory
                                        if (substr($append, 0, 1) !== '/') {
                                            $appendPath = $criticalcss_dir . $append;
                                        }
                                        
                                        $appendPath = realpath($appendPath);
                                        if (strpos($appendPath, ABSPATH) === false) {
                                            // not in WordPress root, ignore
                                            wp_die('Critical CSS file '.$file.' contains append/prepend location outside WordPress root.');
                                        }
                                        if (!in_array($append, $config[$key])) {
                                            $config[$key][] = $append;
                                        }
                                    } else {
                                        if (!in_array($append, $config[$key])) {
                                            $config[$key][] = $append;
                                        }
                                    }
                                break;
                                default:
                                    $config[$key] = trim($matches[2][$n]);
                                break;
                            }
                        }
                    }

                    $config['name'] = $criticalcss_name;
                    $config['file'] = $criticalcss_dir . $file;
                    $config['t'] = filemtime($criticalcss_dir . $file);

                    $fileconfig[$file] = $config;
                    $updated = true;
                }

                if (isset($fileconfig[$file]['appendToAny'])) {
                    $fileconfig[$file]['appendToAny'] = true;
                }
                if (isset($fileconfig[$file]['prependToAny'])) {
                    $fileconfig[$file]['prependToAny'] = true;
                }

                if (isset($fileconfig[$file]['append']) && !empty($fileconfig[$file]['append'])) {
                    $fileconfig[$file]['append'] = array_unique($fileconfig[$file]['append']);
                }
                if (isset($fileconfig[$file]['prepend']) && !empty($fileconfig[$file]['prepend'])) {
                    $fileconfig[$file]['prepend'] = array_unique($fileconfig[$file]['prepend']);
                }

                $newfileconfig[$file] = $fileconfig[$file];
            }
        }

        /**
         * Cache critical CSS file config
         */
        if ($updated || count($fileconfig) !== count($newfileconfig)) {

            // sort based on weight
            uasort($newfileconfig, function ($a, $b) {
                if ($a['weight'] == $b['weight']) {
                    return 0;
                }

                return ($a['weight'] < $b['weight']) ? +1 : -1;
            });

            update_option('abovethefold-criticalcss', $newfileconfig, true);

            return $newfileconfig;
        } else {
            return $fileconfig;
        }
    }

    /**
     * Get critical CSS file contents
     */
    public function get_file_contents($file)
    {
        if (!file_exists($file)) {
            return '';
        }

        // strip config header
        $cssdata = trim(preg_replace('|^\s*/\*(.*?)\*/|is', '', trim(file_get_contents($file))));

        return $cssdata;
    }

    /**
     * Delete critical CSS file
     */
    public function delete_file($file)
    {
        $criticalcss_dir = $this->CTRL->theme_path('critical-css');
        if (strpos($file, '/') === false) {
            $file = $criticalcss_dir . $file;
        }

        // verify if file is located in critical css directory
        if (strpos($file, $criticalcss_dir) === false) {
            wp_die('File to delete not located in critical CSS directory.');
        }

        // strip config header
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    /**
     * Save critical CSS file contents
     */
    public function save_file_contents($file, $config, $css)
    {
        $errors = array();

        if (strpos($file, '/') !== false || substr($file, -4) !== '.css') {
            $errors[] = array(
                'message' => 'Invalid Critical CSS file: ' . htmlentities($file, ENT_COMPAT, 'utf-8')
            );

            return $errors;
        }

        if (!isset($config['name']) || trim($config['name']) === '') {
            $config['name'] = str_replace('.css', '', $file);
        }

        // header
        $cssheader = '/**
 * ' . $config['name'] . '
 *';

        // conditions
        $conditions = array();
        if (isset($config['conditions']) && !empty($config['conditions'])) {
            foreach ($config['conditions'] as $condition) {
                if (trim($condition) === '') {
                    continue 1;
                }

                $split = explode(':', $condition, 2);
                $condition_key = $split[0];
                $data = isset($split[1]) ? $split[1] : false;
                switch ($condition_key) {
                    case "filter":
                        if ($data && strpos($data, ':') !== false) {
                            $datasplit = explode(':', $data, 2);
                            $filtername = $datasplit[0];

                            if (trim($datasplit[1]) === '') {
                                $data = array();
                            } else {
                                $data = @json_decode('[' . trim($datasplit[1]) . ']');
                                if (!is_array($data) || empty($data)) {
                                    $errors[] = array(
                                        'message' => 'Failed to parse filter params for filter <strong>'.htmlentities(trim($filtername), ENT_COMPAT, 'utf-8').'</strong> ('.htmlentities(trim($datasplit[1]), ENT_COMPAT, 'utf-8').'). The parameters should be JSON encoded, e.g. <code>"param1","param2"</code>.'
                                    );
                                    continue 1;
                                }
                            }
                            //$data = explode(',',$datasplit[1]);
                            foreach ($data as $dn => $datavalue) {
                                if (is_string($datavalue) && substr($datavalue, 0, 1) === '"') {
                                    $data[$dn] = json_decode($datavalue);
                                }
                            }
                        } else {
                            $filtername = $data;
                            $data = false;
                        }

                        if (!isset($conditions[$condition_key])) {
                            $conditions[$condition_key] = array();
                        }
                        $conditions[$condition_key][$filtername] = $data;
                    break;
                    default:
                        if (!isset($conditions[$condition_key])) {
                            $conditions[$condition_key] = array();
                        }
                        if ($data) {
                            $conditions[$condition_key][] = $data;
                        }
                    break;
                }
            }
        }

        foreach ($conditions as $condition_key => $condition_data) {
            switch ($condition_key) {
                case "filter":
                    foreach ($condition_data as $filter_key => $filter_vars) {
                        $cssheader .= "\n * @condition filter:" . $filter_key;

                        if (is_array($filter_vars) && !empty($filter_vars)) {
                            foreach ($filter_vars as $dn => $datavalue) {
                                if (is_string($datavalue) && substr($datavalue, 0, 1) === '"') {
                                    $filter_vars[$dn] = json_decode($datavalue);
                                }
                            }

                            $cssheader .= ':' . trim(json_encode($filter_vars, true), '[]');
                        }
                    }
                break;
                default:
                    $cssheader .= "\n * @condition " . $condition_key;
                    if (is_array($condition_data) && count($condition_data) > 0) {
                        $cssheader .= ':' . trim(json_encode($condition_data, true), '[]');
                    }
                break;
            }
        }

        if (isset($config['matchType']) && in_array($config['matchType'], array('any','all'))) {
            $cssheader .= "\n * @matchType " . $config['matchType'];
        }
        if (isset($config['appendToAny'])) {
            $cssheader .= "\n * @appendToAny";
        }
        if (isset($config['prependToAny'])) {
            $cssheader .= "\n * @prependToAny";
        }

        // append/prepend
        $preappend = array('append','prepend');
        foreach ($preappend as $type) {
            if (isset($config[$type]) && !empty($config[$type])) {
                foreach ($config[$type] as $appendfile) {
                    if (trim($appendfile) === '') {
                        continue 1;
                    }
                    $cssheader .= "\n * @" . $type . " " . $appendfile;
                }
            }
        }
        if (isset($config['weight'])) {
            $cssheader .= "\n * @weight " . ((is_numeric($config['weight']) && $config['weight'] >= 1) ? $config['weight'] : 1);
        }

        $cssheader = trim($cssheader);
        if (substr($cssheader, -1) === '*') {
            $cssheader = trim(substr($cssheader, 0, -1));
        }

        $cssheader .= "\n */\n";

        $criticalcss_dir = $this->CTRL->theme_path('critical-css');

        $this->CTRL->file_put_contents($criticalcss_dir . $file, $cssheader . $css);

        return (!empty($errors)) ? $errors : false;
    }

    /**
     * Retrieve critical CSS for environment conditions
     */
    public function get()
    {

        // debug
        $debug = (current_user_can('administrator') || current_user_can('editor')) ? true : false;
        $debug_enabled = ($debug && isset($this->CTRL->options['debug']) && intval($this->CTRL->options['debug']) === 1) ? true : false;

        $criticalcss_files = $this->get_theme_criticalcss();
        $criticalcss_dir = $this->CTRL->theme_path('critical-css');

        $primary_criticalcss = array();
        $preAppendFiles = array();

        $debug_criticalcss = ($this->CTRL->view === 'critical-css-view');

        if (!empty($criticalcss_files)) {
            // match conditional CSS
            foreach ($criticalcss_files as $file => $config) {

                // no conditions, skip
                if ($file === 'global.css') {
                    continue 1;
                }

                // critical css already matched and no append/prepend to any, skip
                if ($primary_criticalcss && (!isset($config['appendToAny']) && !isset($config['prependToAny']))) {
                    continue 1;
                }

                $matchType = (isset($config['matchType']) && strtolower($config['matchType']) === 'all') ? 'all' : 'any';

                $match = false;
                $matchAll = true;
                $matchedConditions = array();

                // no conditions: match
                if (!isset($config['conditions']) || empty($config['conditions'])) {
                    $match = true;
                } else {
                    foreach ($config['conditions'] as $condition_key => $data) {
                        switch ($condition_key) {
                            case "filter":
                                foreach ($data as $filter => $filterdata) {
                                    if (function_exists($filter)) {
                                        $matchRes = call_user_func($filter, $filterdata);
                                        if ($matchRes === true) {

                                            // match
                                            $match = true;
                                        } else {
                                            $matchAll = false;
                                        }

                                        $matchedConditions[] = $filter;
                                    }
                                }
                            break;
                            default:
                                $condition_fn = rtrim($condition_key, '()');
                                if (!function_exists($condition_fn)) {

                                    // condition not recognized
                                    continue 1;
                                }

                                $skip = false;
                                switch ($condition_fn) {
                                    case "has_category":
                                        if (!is_single()) {
                                            $skip = true;
                                        }
                                    break;
                                }

                                if ($skip) {
                                    continue 1;
                                }

                                if (call_user_func($condition_fn, (($data) ? $data : null))) {

                                    // match
                                    $match = true;
                                    $matchedConditions[] = $condition_key;
                                } else {
                                    $matchAll = false;
                                }
                            break;
                        }
                    }
                }

                // all conditions must match
                if ($matchType === 'all' && !$matchAll) {
                    $match = false;
                }

                // found matching condition
                if ($match) {
                    $cssdata = $this->get_file_contents($config['file']);
                    if ($cssdata === '') {
                        // empty
                        continue 1;
                    }
                    $csshash = md5($cssdata);

                    if ($debug_criticalcss) {
                        $cssdata = "\n\n/*\n * @critical-css-file " . basename($config['file']) . "\n */\n" . $cssdata;
                    }

                    $appendPrepend = false;
                    $preappend = array('append','prepend');
                    foreach ($preappend as $type) {

                        // append/prepend to any other matching file or global.css
                        if (isset($config[$type . 'ToAny']) && $config[$type . 'ToAny']) {
                            if (!isset($preAppendFiles[$type])) {
                                $preAppendFiles[$type] = array();
                            }
                            $preAppendFiles[$type][$file] = $cssdata;
                            $appendPrepend = true;
                        }

                        // append files
                        if (isset($config[$type]) && !empty($config[$type])) {
                            foreach ($config[$type] as $append) {
                                $appendcss = '';
                                if (strpos($append, '/') !== false) {
                                    if (substr($append, 0, 1) !== '/') {
                                        $appendPath = $criticalcss_dir . $append;
                                    } else {
                                        $appendPath = $append;
                                    }
                                    $appendcss = $this->get_file_contents($appendPath);
                                } else {
                                    if (isset($criticalcss_files[$append]) && file_exists($criticalcss_files[$append]['file'])) {
                                        $appendcss = $this->get_file_contents($criticalcss_files[$append]['file']);
                                    }
                                }
                                if ($appendcss !== '') {
                                    $preAppendFiles[$type][$append] = $appendcss;
                                }
                            }
                        }
                    }

                    if (!$appendPrepend) {
                        $primary_criticalcss = array(
                            'css' => $cssdata,
                            'file' => basename($config['file']),
                            'match' => $matchedConditions
                        );
                    }
                }
            }
        }
        
        // no matching primary critical css, use global.css
        if (!$primary_criticalcss) {
            $cssdata = (isset($criticalcss_files['global.css']) ? $this->get_file_contents($criticalcss_files['global.css']['file']) : '');
            if ($debug_criticalcss) {
                $cssdata = "\n\n/*\n * @critical-css-file global.css\n */\n" . $cssdata;
            }
            $primary_criticalcss = $primary_criticalcss = array(
                'css' => $cssdata,
                'file' => 'global.css',
                'match' => false
            );
        }

        $servedfiles = '';
        if (isset($preAppendFiles['prepend']) && !empty($preAppendFiles['prepend'])) {
            $primary_criticalcss['css'] = implode(' ', array_values($preAppendFiles['prepend'])) . ' ' . $primary_criticalcss['css'];
            $files = array_keys($preAppendFiles['prepend']);
            foreach ($files as $file) {
                if ($servedfiles !== '') {
                    $servedfiles .= "\n";
                }
                $servedfiles .= ' * @prepended ' . $file;
            }
        }

        if ($servedfiles !== '') {
            $servedfiles .= "\n";
        }
        $servedfiles .= ' * @primary ' . $primary_criticalcss['file'];

        if (isset($preAppendFiles['append']) && !empty($preAppendFiles['append'])) {
            $primary_criticalcss['css'] = $primary_criticalcss['css'] . ' ' . implode(' ', array_values($preAppendFiles['append']));
            $files = array_keys($preAppendFiles['append']);
            foreach ($files as $file) {
                if ($servedfiles !== '') {
                    $servedfiles .= "\n";
                }
                $servedfiles .= ' * @appended ' . $file;
            }
        }

        $matchedconditions = '';

        if ($primary_criticalcss['match']) {
            foreach ($primary_criticalcss['match'] as $match) {
                $matchedconditions .= "\n" . ' * @condition ' . $match;
            }
        }

        $debugnotice = (($debug_enabled) ? "\n" . ' * @debug enabled' : '');

        $primary_criticalcss['css'] = trim($primary_criticalcss['css']);

        // critical css
        $criticalCSS = '';

        if ($debug_criticalcss) {
            $criticalCSS .= "/**\n * Critical CSS Editor\n *\n * The extracted Critical CSS has been annotated with file references for easy editing. \n * The Critical CSS source files are located in the theme directory .../".basename(get_stylesheet_directory())."/abovethefold/critical-css/\n */\n\n";
        }

        /**
         * Hide Critical CSS for verification view
         */
        if ($this->CTRL->view === 'no-critical-css' || $this->CTRL->view === 'critical-css-creator-html') {
            if ($debug) {
                $criticalCSS .= '
/*!
 * Page Speed Optimization ' . $this->CTRL->get_version() . '
 * Full CSS View: Critical CSS is excluded from page.
 */
';
            }
        }

        /**
         * Include inline CSS
         */
        elseif ($primary_criticalcss['css'] !== '') {

            /**
             * Debug header
             */
            if ($debug) {
                $criticalCSS .= '
/*!
 * Page Speed Optimization ' . $this->CTRL->get_version() . '
 * This message is visible to admins and editors only.
 *
' . htmlentities($servedfiles, ENT_COMPAT, 'utf-8') . $matchedconditions . $debugnotice . '
 */
' . $primary_criticalcss['css'];
            } else {
                $criticalCSS .= $primary_criticalcss['css'];
            }
        } else {

            /**
             * Print warning when Critical CSS is empty
             */
            $criticalCSS .= '
/*!
 * Page Speed Optimization ' . $this->CTRL->get_version() . '
 * 
 * ------------------------------------
 *    WARNING: CRITICAL CSS IS EMPTY     
 * ------------------------------------
 */
';
        }

        return $criticalCSS;
    }

    /**
     * HTTP/2 Server Push file from critical CSS
     */
    public function http2_push_file($css)
    {
        $css = trim($css);
        if ($css === '') {
            return false;
        }

        // file hash
        $hash = md5($css);
        $cache_file = $this->http2_cache_file_path($hash);

        // write critical css
        if (!file_exists($cache_file) || filemtime($cache_file) < (time() - 86400)) {
            $this->CTRL->file_put_contents($cache_file, $css);
        }

        return $this->http2_cache_url($hash);
    }

    /**
     * Prune expired HTTP/2 cache entries
     */
    public function http2_cache_prune()
    {

        // age to delete cache file
        $prune_age = 7 * 86400; // 1 week
        $prune_time = (time() - $prune_age);

        $file_count = 0;
        $file_size = 0;
        $deleted_count = 0;

        $cache_path = $this->CTRL->cache_path('http2_css');

        $root_dir = array_diff(scandir($cache_path), array('..', '.'));
        foreach ($root_dir as $dirA) {
            if (strlen($dirA) === 2 && is_dir($cache_path . $dirA . '/')) {
                $A_dir = array_diff(scandir($cache_path . $dirA . '/'), array('..', '.'));
                foreach ($A_dir as $dirB) {
                    if (strlen($dirB) === 2 && is_dir($cache_path . $dirA . '/' . $dirB . '/')) {
                        $C_dir = array_diff(scandir($cache_path . $dirA . '/' . $dirB . '/'), array('..', '.'));
                        foreach ($C_dir as $dirC) {
                            if (strlen($dirC) === 2 && is_dir($cache_path . $dirA . '/' . $dirB . '/' . $dirC . '/')) {
                                $C_cache_path = $cache_path . $dirA . '/' . $dirB . '/' . $dirC . '/';
                                
                                $cache_files = array_diff(scandir($C_cache_path), array('..', '.'));
                                foreach ($cache_files as $file) {

                                    // date created
                                    $date_created = filemtime($C_cache_path . $file);

                                    // older than min age, delete cache file
                                    if ($date_created < $prune_time) {
                                        @unlink($C_cache_path . $file);
                                        $deleted_count++;
                                    } else {
                                        $file_count++;
                                        $file_size += filesize($C_cache_path . $file);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Empty HTTP/2 cache directory
     */
    public function http2_empty_cache()
    {
        $cache_path = $this->CTRL->cache_path('http2_css');
        $root_dir = array_diff(scandir($cache_path), array('..', '.'));
        foreach ($root_dir as $dirA) {
            $this->CTRL->rmdir($cache_path . $dirA . '/');
        }
    }

    /**
     * HTTP/2 Cache file path
     */
    public function http2_cache_file_path($hash, $create = true)
    {

        // verify hash
        if (strlen($hash) !== 32) {
            $this->forbidden('Invalid cache file hash');
        }

        // Initialize cache path
        $cache_path = $this->CTRL->cache_path('http2_css');
        if (!is_dir($cache_path)) {
            $this->error('HTTP/2 CSS cache directory not available ' . $cache_path);
        }

        $dir_blocks = array_slice(str_split($hash, 2), 0, 3);
        foreach ($dir_blocks as $block) {
            $cache_path .= $block . '/';

            if (!is_dir($cache_path)) {
                if (!$create) {
                    return false;
                } else {
                    if (!$this->CTRL->mkdir($cache_path)) {
                        $this->error('Failed to create directory ' . $cache_path);
                    }
                }
            }
        }

        $cache_path .= $hash . '.css';

        if (!$create && !file_exists($cache_path)) {
            return false;
        }

        return $cache_path;
    }

    /**
     * Cache url
     */
    public function http2_cache_url($hash, $urlExpiredCheck = false, $cdn = false)
    {

        // verify hash
        if (strlen($hash) !== 32) {
            $this->forbidden('Invalid cache file hash');
        }

        // check if cache file exists
        $cache_path = $this->http2_cache_file_path($hash, false);
        if (!$cache_path) {
            return false;
        }

        $url = $this->CTRL->cache_dir('http2_css');
        
        $dir_blocks = array_slice(str_split($hash, 2), 0, 3);
        foreach ($dir_blocks as $block) {
            $url .= $block . '/';
        }

        $url .= $hash . '.css';

        return $url;
    }

    /**
     * Cron prune method
     */
    public function http2_cache_cron_prune()
    {

        // cron logfile
        $cache_path = $this->CTRL->cache_path('http2_css');
        $cronlog = $cache_path . 'cleanup_cron.log';
        $this->CTRL->file_put_contents($cronlog, 'start: ' . date('r'));

        // prune cache
        $stats = $this->http2_cache_prune();

        // log result
        $this->CTRL->file_put_contents($cronlog, 'completed: ' . date('r') . "\nDeleted: " . $stats['deleted'] . "\nFiles: " . $stats['files'] . "\nSize: " . $stats['size']);
    }
}
