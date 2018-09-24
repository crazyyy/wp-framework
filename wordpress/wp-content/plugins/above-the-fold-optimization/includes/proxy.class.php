<?php

/**
 * Abovethefold caching external resource proxy.
 *
 * This class provides the functionality for caching external resource proxy functions and hooks.
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_Proxy
{

    /**
     * Above the fold controller
     *
     * @var object $CTRL
     */
    public $CTRL;

    /**
     * Preload list for javascript
     */
    public $js_preload = array();

    /**
     * Preload list for styles (CSS)
     */
    public $css_preload = array();

    /**
     * Include list for javascript
     */
    public $js_include = array();

    /**
     * Include list for styles (CSS)
     */
    public $css_include = array();

    /**
     * Exclude list for javascript
     */
    public $js_exclude = array();

    /**
     * Exclude list for styles (CSS)
     */
    public $css_exclude = array(
        'fonts.googleapis.com/css'
    );

    /**
     * Resources with custom expire time
     */
    public $custom_expire = array();

    /**
     * Regex based target url translation
     */
    public $regex_url_translation = array();

    /**
     * CDN for cached resources
     */
    public $cdn = false;

    /**
     * Custom CDN url for individual resources
     */
    public $custom_resource_cdn = array();

    /**
     * CDN hosts (for localhost checking)
     */
    public $cdn_hosts = array();

    /**
     * Valid javascript mimetypes
     */
    public $js_mimetypes = array(
        'application/javascript',
        'application/x-javascript',
        'application/ecmascript',
        'text/javascript',
        'text/ecmascript',
        'text/plain'
    );

    /**
     * Valid CSS mimetypes
     */
    public $css_mimetypes = array(
        'text/css',
        'text/plain'
    );

    /**
     * Absolute path with trailingslash
     */
    private $abspath;
    
    /**
     * Default cache expire time in seconds
     */
    public $default_cache_expire = 2592000; // 30 days

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL = & $CTRL;

        if ($this->CTRL->disabled) {
            return; // above the fold optimization disabled for area / page
        }

        if (!isset($this->CTRL->options['js_proxy'])) {
            $this->CTRL->options['js_proxy'] = false;
        }
        if (!isset($this->CTRL->options['css_proxy'])) {
            $this->CTRL->options['css_proxy'] = false;
        }
        if (isset($this->CTRL->options['proxy_cdn']) && $this->CTRL->options['proxy_cdn']) {
            $this->cdn = $this->CTRL->options['proxy_cdn'];

            $parsed_url = parse_url($this->cdn);
            $this->cdn_hosts[] = $parsed_url['host'];
        }

        // set include/exclude list
        $keys = array('js_include','css_include','js_exclude','css_exclude');
        foreach ($keys as $key) {
            $params = explode('_', $key);

            if (empty($this->$key)) {
                if (isset($this->CTRL->options[$params[0] . '_proxy_' . $params[1]]) && is_array($this->CTRL->options[$params[0] . '_proxy_' . $params[1]])) {
                    $this->$key = $this->CTRL->options[$params[0] . '_proxy_' . $params[1]];
                    continue 1;
                }
            }

            // merge default include / exclude list with settings
            $this->$key = array_unique(
                array_filter(
                    array_merge($this->$key, ((isset($this->CTRL->options[$params[0] . '_proxy_' . $params[1]]) && is_array($this->CTRL->options[$params[0] . '_proxy_' . $params[1]])) ? $this->CTRL->options[$params[0] . '_proxy_' . $params[1]] : array())),
                    create_function('$value', 'return trim($value) !== "";')
                )
            );
        }

        // preload list
        $preloadlist = array();

        if ($this->CTRL->options['css_proxy']) {
        
            // add filter for CSS file processing
            $this->CTRL->loader->add_filter('abtf_cssfile_pre', $this, 'process_cssfile');

            /**
             * Preload urls
             */
            if (isset($this->CTRL->options['css_proxy_preload']) && is_array($this->CTRL->options['css_proxy_preload']) && !empty($this->CTRL->options['css_proxy_preload'])) {
                if (!empty($this->CTRL->options['css_proxy_preload'])) {
                    foreach ($this->CTRL->options['css_proxy_preload'] as $url) {
                        $preloadlist[] = array($url,'css');
                    }
                }
            }
        }

        if ($this->CTRL->options['js_proxy']) {
        
            // add filter for javascript file processing
            $this->CTRL->loader->add_filter('abtf_jsfile_pre', $this, 'process_jsfile');

            /**
             * Preload urls
             */
            if (isset($this->CTRL->options['js_proxy_preload']) && is_array($this->CTRL->options['js_proxy_preload']) && !empty($this->CTRL->options['js_proxy_preload'])) {
                foreach ($this->CTRL->options['js_proxy_preload'] as $url) {
                    $preloadlist[] = array($url,'js');
                }
            }
        }

        if (!empty($preloadlist)) {
            $preload_hashes = array();
            foreach ($preloadlist as $preloadurl) {
                list($url, $type) = $preloadurl;

                // JSON config
                if ($url && is_array($url)) {

                    // regex
                    if (!isset($url['url']) || trim($url['url']) === '') {
                        // no target url
                        continue 1;
                    }

                    // apply custom expire time
                    if (isset($url['expire']) && $url['expire']) {
                        $this->custom_expire[$url['url']] = $url['expire'];
                    }

                    // regex
                    if (isset($url['regex']) && $url['regex']) {
                        $this->regex_url_translation[$url['url']] = array($url['regex'],$url['regex-flags']);
                    }

                    // custom resource CDN
                    if (isset($url['cdn']) && $url['cdn']) {
                        $this->custom_resource_cdn[$url['url']] = $url['cdn'];

                        $parsed_url = parse_url($url['cdn']);
                        if (!in_array($parsed_url['host'], $this->cdn_hosts)) {
                            $this->cdn_hosts[] = $parsed_url['host'];
                        }
                    }

                    $url_config = $url;
                    $url = $url_config['url'];
                    unset($url_config['url']);
                } else {
                    $url_config = false;
                }

                // verify url
                $url = trim($url);
                if ($url === '') {
                    continue;
                }

                $cache_hash = $this->cache_hash($url, $type, $url);

                if ($url_config) {
                    $preload_url = array();

                    // JSON config object
                    if (isset($url_config['regex'])) {
                        $preload_url[0] = 'regex';
                        $preload_url[1] = ($cache_hash) ? $cache_hash : false;
                        $preload_url[2] = $url_config['regex'];
                        $preload_url[3] = (isset($url_config['regex-flags']) ? $url_config['regex-flags'] : '');
                    } else {
                        if ($cache_hash || (isset($url_config['cdn']) && $url_config['cdn'])) {
                            $preload_url[0] = $url;
                            $preload_url[1] = ($cache_hash) ? $cache_hash : false;
                            $preload_url[2] = false;
                            $preload_url[3] = false;
                        }
                    }
                    if (isset($url_config['cdn']) && $url_config['cdn']) {
                        $preload_url[4] = preg_replace('|^(http(s)?:)?//[^/]+/|Ui', trailingslashit($url_config['cdn']), $this->CTRL->cache_dir('proxy'));
                    }
                    $this->{$type . '_preload'}[] = $preload_url;
                } elseif ($cache_hash) {

                    // general cached resource
                    $this->{$type . '_preload'}[] = array($url,$cache_hash);
                }
            }
        }

        // WordPress root with trailingslash
        $this->abspath = trailingslashit(ABSPATH);
    }

    /**
     * Get proxy url for an URL
     *
     * Returns cache url
     */
    public function url($url = '{PROXY:URL}', $type = '{PROXY:TYPE}', $tryCache = false, $htmlUrl = false)
    {
        if ($url !== '{PROXY:URL}') {
            
            // strip hash from url
            if (strpos($url, '#') !== false) {
                $url = strstr($url, '#', true);
            }

            // parse url
            $parsed = $this->parse_url($url);
            if ($parsed) {
                list($url, $filehash, $local_file) = $parsed;

                // try direct url to file
                if ($tryCache) {

                    // CDN
                    $cdn = false;
                    if (!empty($this->custom_resource_cdn) && isset($this->custom_resource_cdn[$url])) {
                        $cdn = $this->custom_resource_cdn[$url];
                    } elseif ($this->cdn) {
                        $cdn = $this->cdn;
                    }

                    $cache_url = $this->cache_url($filehash, $type, $url, $cdn);
                    if ($cache_url) {
                        return $cache_url;
                    }
                }

                $url = urlencode($url);
            }
        }
        
        // html valid ampersand
        $amp = ($htmlUrl) ? '&amp;' : '&';

        // custom proxy url
        if (isset($this->CTRL->options['proxy_url']) && $this->CTRL->options['proxy_url'] !== '') {
            $proxy_url = $this->CTRL->options['proxy_url'];
            if ($url !== '{PROXY:URL}') {
                $proxy_url = str_replace(array(
                    '{PROXY:URL}',
                    '{PROXY:TYPE}'
                ), array(
                    $url,
                    $type
                ), $proxy_url);
            }
        } else {

            // default WordPress PHP proxy url
            $site_url = site_url();
            $proxy_url = $site_url . ((strpos($site_url, '?') !== false) ? $amp : '?') . 'url=' . $url . $amp . 'type=' . $type . $amp . 'abtf-proxy=' . md5(SECURE_AUTH_KEY . AUTH_KEY);
        }

        return $proxy_url;
    }

    /**
     * Parse CSS file in CSS file loop
     */
    public function process_cssfile($cssfile)
    {

        // ignore
        if (!$cssfile || is_array($cssfile) || in_array($cssfile, array('delete','ignore'))) {
            return $cssfile;
        }

        $parsed_url = parse_url($cssfile);
        if ($localfile = $this->is_local($parsed_url, $cssfile)) {

            // not external
            return $localfile;
        }

        if (!empty($this->cdn_hosts) && in_array($parsed_url['host'], $this->cdn_hosts)) {

            // on CDN, not external
            return $cssfile;
        }

        /**
         * File does not match include list, ignore
         */
        if (!$this->url_include($cssfile, 'css')) {
            return $cssfile;
        }

        /**
         * File matches exclude list, ignore
         */
        if ($this->url_exclude($cssfile, 'css')) {
            return $cssfile;
        }

        // External, proxify url
        return $this->url($cssfile, 'css', true, true);
    }

    /**
     * Parse javascript file in javascript file loop
     */
    public function process_jsfile($jsfile)
    {

        // ignore
        if (!$jsfile || in_array($jsfile, array('delete','ignore'))) {
            return $jsfile;
        }

        $parsed_url = parse_url($jsfile);
        if ($localfile = $this->is_local($parsed_url, $jsfile)) {

            // not external
            return $localfile;
        }

        if (!empty($this->cdn_hosts) && in_array($parsed_url['host'], $this->cdn_hosts)) {

            // on CDN, not external
            return $jsfile;
        }

        /**
         * File does not match include list, ignore
         */
        if (!$this->url_include($jsfile, 'js')) {
            return $jsfile;
        }

        /**
         * File matches exclude list, ignore
         */
        if ($this->url_exclude($jsfile, 'js')) {
            return $jsfile;
        }

        // External, proxify url
        return $this->url($jsfile, 'js', true, true);
    }

    /**
     * Handle forbidden requests
     */
    public function forbidden($text = 'Forbidden')
    {
        while (ob_get_level()) {
            ob_end_clean();
        };
        wp_die($text, 'Proxy Forbidden - Above The Fold Optimization', array(
            'response' => '403'
        ));
    }

    /**
     * Handle errors
     */
    public function error($text = 'Forbidden')
    {
        while (ob_get_level()) {
            ob_end_clean();
        };
        wp_die($text, 'Proxy Error - Above The Fold Optimization', array(
            'response' => '500'
        ));
    }

    /**
     * Cache file path
     */
    public function cache_file_path($hash, $type, $create = true)
    {

        // verify hash
        if (strlen($hash) !== 32) {
            $this->forbidden('Invalid cache file hash');
        }

        // Initialize cache path
        $cache_path = $this->CTRL->cache_path('proxy');
        if (!is_dir($cache_path)) {
            $this->error('Proxy cache directory not available ' . $cache_path);
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

        $cache_path .= $hash;

        if ($type === 'js') {
            $cache_path .= '.js';
        } elseif ($type === 'css') {
            $cache_path .= '.css';
        }

        if (!$create && !file_exists($cache_path)) {
            return false;
        }

        return $cache_path;
    }

    /**
     * Cache file expired check
     */
    public function cache_file_expired($cache_file, $url)
    {

        // file does not exist
        if (!$cache_file || !file_exists($cache_file)) {
            return true;
        }

        $last_modified = filemtime($cache_file);

        if (!empty($this->custom_expire) && isset($this->custom_expire[$url])) {
            $expire_time = $this->custom_expire[$url];
        } else {
            $expire_time = $this->default_cache_expire;
        }

        // expired
        if ($last_modified < (time() - $expire_time)) {
            return true;
        }

        return false;
    }

    /**
     * Strip www. from hostname
     */
    public function nowww_host($hostname)
    {
        if (stripos($hostname, 'www.') === 0) {
            return substr($hostname, 4);
        }

        return $hostname;
    }

    /**
     * Is local url?
     */
    public function is_local($url, $originalUrl = false)
    {
        if (!$originalUrl) {
            $originalUrl = $url;
            $url = parse_url($url);
        }

        if (is_array($url) && $url['host']) {
            $hostname = $url['host'];
        } else {
            $parsed_url = parse_url($url);
            $hostname = $parsed_url['host'];
        }

        /**
         * Verify hostname
         */
        if ($this->nowww_host($hostname) === $this->nowww_host($_SERVER['HTTP_HOST'])) {
            if (stripos($originalUrl, $_SERVER['HTTP_HOST']) === false) {
                $originalUrl = str_ireplace($hostname, $_SERVER['HTTP_HOST'], $originalUrl);
            }

            /**
             * Translate protocol relative url
             */
            if (substr($originalUrl, 0, 2) === '//') {

                // prefix url with protocol
                $originalUrl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https:' : 'http:') . $originalUrl;
            }

            return $originalUrl;
        }

        return false;
    }

    /**
     * Cache url
     */
    public function cache_url($hash, $type, $urlExpiredCheck = false, $cdn = false)
    {

        // verify hash
        if (strlen($hash) !== 32) {
            $this->forbidden('Invalid cache file hash');
        }

        // check if cache file exists
        $cache_path = $this->cache_file_path($hash, $type, false);
        if (!$cache_path) {
            return false;
        }

        // check if cache file is expired
        if ($urlExpiredCheck && $this->cache_file_expired($cache_path, $urlExpiredCheck)) {
            return false;
        }

        $url = $this->CTRL->cache_dir('proxy');
        
        $dir_blocks = array_slice(str_split($hash, 2), 0, 3);
        foreach ($dir_blocks as $block) {
            $url .= $block . '/';
        }

        $url .= $hash;

        if ($type === 'js') {
            $url .= '.js';
        } elseif ($type === 'css') {
            $url .= '.css';
        }

        // apply CDN
        if ($cdn) {
            $url = preg_replace('|^http(s)?://[^/]+/|Ui', trailingslashit($cdn), $url);
        }

        return $url;
    }

    /**
     * Handle request
     */
    public function handle_request()
    {
        if ((!isset($this->CTRL->options['js_proxy']) || !$this->CTRL->options['js_proxy']) && (!isset($this->CTRL->options['css_proxy']) || !$this->CTRL->options['css_proxy'])) {
            $this->forbidden('Proxy is disabled');
        }

        $url = (isset($_REQUEST['url'])) ? trim($_REQUEST['url']) : '';
        $type = (isset($_REQUEST['type'])) ? trim($_REQUEST['type']) : '';

        if (!in_array($type, array('js','css'))) {
            $this->forbidden();
        }

        // proxy resource
        $proxy_resource = $this->proxy_resource($url, $type, true);
        if (!$proxy_resource) {
            $this->forbidden();
        }
        list($filehash, $cache_file, $url) = $proxy_resource;

        // Proxy failed for url (potentially insecure, not a valid javascript or CSS resource, url not recognized etc)
        if (!$cache_file) {
            
            // forward request to original location
            header("Location: " . $url);
            exit;
        }

        // get last modified time
        $last_modified = filemtime($cache_file);

        /**
         * Verify last modified
         */
        if (
            (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified)
            || (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) == $filehash)
        ) {
            header("Etag: $filehash");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified) . " GMT");
            header("HTTP/1.1 304 Not Modified");
            exit;
        }

        /**
         * Turn of output buffering
         */
        while (ob_get_level()) {
            ob_end_clean();
        };

        /**
         * File headers
         */
        if ($type === 'css') {
            header("Content-Type: text/css", true);
        } else {
            header("Content-Type: application/javascript", true);
        }

        header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified) . " GMT");

        /**
         * Set gzip compression
         */
        //if (extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
        //ini_set("zlib.output_compression", 1);
        //}

        // prevent sniffing of content type
        header("X-Content-Type-Options: nosniff", true);

        /**
         * Custom expire time for url
         */
        if (!empty($this->custom_expire) && isset($this->custom_expire[$url])) {
            $expire_time = $this->custom_expire[$url];
        } else {
            $expire_time = $this->default_cache_expire;
        }

        /**
         * Cache headers
         */
        header("Pragma: cache");
        header("Cache-Control: max-age=".$expire_time.", public");
        header("Expires: " .  gmdate("D, d M Y H:i:s", ($last_modified + $expire_time)) . " GMT");

        readfile($cache_file);
        exit;
    }

    /**
     * Proxy resource
     */
    public function proxy_resource($url, $type, $debugExit = false)
    {
        if (!in_array($type, array('js','css'))) {
            if ($debugExit) {
                $this->error('Invalid proxy resource type');
            }

            return false;
        }

        // parse url
        $parsed = $this->parse_url($url, true);
        if (!$parsed) {
            return false;
        }
        list($url, $filehash, $local_file) = $parsed;

        /**
         * File does not match include list, ignore
         */
        if (!$this->url_include($url, $type)) {
            if ($debugExit) {
                $this->forbidden('The resource is not specifically included via the include list.');
            }

            return false;
        }

        /**
         * File matches exclude list, ignore
         */
        if ($this->url_exclude($url, $type)) {
            if ($debugExit) {
                $this->forbidden('The resource is excluded via the exclude list.');
            }

            return false;
        }

        // cache file
        $cache_file = $this->cache_file_path($filehash, $type);

        /**
         * Return cache file
         */
        if (file_exists($cache_file)) {

            // check if cache file is expired
            if (!$this->cache_file_expired($cache_file, $url)) {
                return array($filehash,$cache_file, $url);
            }
        }

        // verify local file
        if ($local_file) {

            /**
             * Detect mime type of file
             */
            $mime = mime_content_type($local_file);

            if (!$mime) {
                // failed
                // @todo test support / stability in all environments
                if ($debugExit) {
                    $this->forbidden('The local javascript resource does not have a valid mimetype.<br /><br />File: '.str_replace(ABSPATH, '[HIDDEN]/', $local_file).'<br />Mime Type: <strong>'.$mime.'</strong>');
                }

                return false;
            }

            /**
             * Make sure file has valid mime type
             */
            if ($type === 'js') {

                // valid javascript mime type?
                if (!in_array($mime, $this->js_mimetypes) && !(substr($local_file, -3) === '.js' && substr($mime, 0, 5) === 'text/')) {
                    if ($debugExit) {
                        $this->forbidden('The local javascript resource does not have a valid mimetype.<br /><br />File: '.str_replace(ABSPATH, '[HIDDEN]/', $local_file).'<br />Mime Type: <strong>'.$mime.'</strong>');
                    }

                    return false;
                }
            } elseif ($type === 'css') {

                // valid CSS mime type?
                if (!in_array($mime, $this->css_mimetypes) && !(substr($local_file, -4) === '.css' && substr($mime, 0, 5) === 'text/')) {
                    if ($debugExit) {
                        $this->forbidden('The local CSS resource does not have a valid mimetype.<br /><br />File: '.str_replace(ABSPATH, '[HIDDEN]/', $local_file) . '<br />Mime Type: <strong>'.$mime.'</strong>');
                    }

                    return false;
                }
            }
        }

        /**
         * External file? Require proxy to be enabled
         */
        if (!$local_file && (!isset($this->CTRL->options[$type . '_proxy']) || !$this->CTRL->options[$type . '_proxy'])) {
            if ($debugExit) {
                $this->forbidden('The proxy is not enabled for file type '.$type);
            }

            return false;
        }

        /**
         * Download file
         */
        if ($local_file) {
            $file_data = file_get_contents($local_file);
        } else {
            $file_data = $this->CTRL->remote_get($url);
        }

        /**
         * Add proxy identification header (and increase security)
         */
        if ($file_data) {
            if (!empty($this->custom_expire) && isset($this->custom_expire[$url])) {
                $expire_time = $this->custom_expire[$url];
            } else {
                $expire_time = $this->default_cache_expire;
            }

            $file_data = "/** " . (($type === 'js') ? 'Javascript' : 'CSS') . " Proxy / Above The Fold Optimization v".WPABTF_VERSION."\n * @url ".$url."\n * @expire ".date("Y/m/d H:i:s", (time() + $expire_time))." */\n" . $file_data;
        }

        /**
         * Apply optimization filters to resource content
         */
        $file_data = apply_filters('abtf_css', $file_data);

        if ($file_data) {
            $this->CTRL->file_put_contents($cache_file, $file_data);
        } else {
            if ($debugExit) {
                $this->error('Failed to proxy file ' . htmlentities($url, ENT_COMPAT, 'utf-8'));
            }
        }

        return array($filehash,$cache_file,$url);
    }

    /**
     * Parse url
     */
    public function parse_url($url, $x = false)
    {
        $url = trim($url);

        /**
         * Translate protocol relative url
         */
        if (substr($url, 0, 2) === '//') {

            // prefix url with protocol
            $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https:' : 'http:') . $url;
        }

        /**
         * Handle local file
         */
        $local_file = false;

        // http(s):// based file, match host with server host
        if (strpos($url, '://') !== false) {
            $http_prefix = false;

            $prefix_match = substr($url, 0, 6);
            if ($prefix_match === 'https:') {
                
                // HTTPS
                $http_prefix = 'https://';
            } elseif ($prefix_match === 'http:/') {

                // HTTPS
                $http_prefix = 'http://';
            } else {

                /**
                 * Invalid protocol
                 * @security
                 */
                return false;
            }

            $parsed_url = parse_url($url);

            if ($this->is_local($parsed_url, $url) || (!empty($this->cdn_hosts) && in_array($parsed_url['host'], $this->cdn_hosts))) {

                // local file
                $url = str_ireplace($http_prefix . $parsed_url['host'], '', $url);
            }
        }

        // local file
        if (strpos($url, '://') === false) {

            // remove query string
            if (strpos($url, '?') !== false) {
                $url = substr($url, 0, strpos($url, "?"));
            }

            // remove hash
            if (strpos($url, '#') !== false) {
                $url = substr($url, 0, strpos($url, "#"));
            }

            // get real path for url
            if (substr($url, 0, 1) === '/') {
                $url = substr($url, 1);
            }
            $resource_path = realpath($this->abspath . $url);

            /**
             * Make sure resource is in WordPress root
             * @security
             */
            if (strpos($resource_path, $this->abspath) === false || !file_exists($resource_path)) {
                return false;
            }

            // create file hash based on file contents (force browser cache update on file changes)
            $filehash = md5_file($resource_path);

            return array($url, $filehash, $resource_path);
        } else {

            // translate url
            $url = $this->regex_translate_url($url);

            // file hash based on url
            $filehash = md5($url);

            return array($url, $filehash, false);
        }
    }

    /**
     * Translate url based on regex config
     */
    public function regex_translate_url($url)
    {
        if (empty($this->regex_url_translation)) {
            return $url;
        }
        foreach ($this->regex_url_translation as $matchurl => $regex) {
            if (preg_match('|'.str_replace('|', '\\|', $regex[0]).'|' . $regex[1], $url)) {
                return $matchurl;
            }
        }

        return $url;
    }

    /**
     * Return cache hash for url
     */
    public function cache_hash($url, $type, $urlExpiredCheck = false)
    {
        $parsed = $this->parse_url($url);
        if ($parsed) {
            $cache_path = $this->cache_file_path($parsed[1], $type, false);

            if (!$cache_path) {
                return false;
            }

            // check if cache file is expired
            if ($urlExpiredCheck && $this->cache_file_expired($cache_path, $urlExpiredCheck)) {
                return false;
            }

            return $parsed[1];
        }

        // not in cache
        return false;
    }

    /**
     * Match url against include list
     */
    public function url_include($url, $type)
    {

        /**
         * Require proxy to be enabled
         */
        if (!isset($this->CTRL->options[$type . '_proxy']) || !$this->CTRL->options[$type . '_proxy']) {
            return false;
        }

        $include_key = $type . '_include';

        /**
         * Include list empty, include all
         */
        if (empty($this->$include_key)) {
            return true;
        }
        
        /**
         * Match url against include list
         */
        foreach ($this->$include_key as $str) {
            if (strpos($url, $str) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Match url against exclude list
     */
    public function url_exclude($url, $type)
    {

        /**
         * Require proxy to be enabled
         */
        if (!isset($this->CTRL->options[$type . '_proxy']) || !$this->CTRL->options[$type . '_proxy']) {
            return false;
        }

        $exclude_key = $type . '_exclude';

        /**
         * Exclude list empty, exclude none
         */
        if (empty($this->$exclude_key)) {
            return false;
        }

        /**
         * Match url against exclude list
         */
        foreach ($this->$exclude_key as $str) {
            if (strpos($url, $str) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Javascript client settings
     */
    public function client_jssettings(&$jssettings, &$jsfiles, $jsdebug)
    {
        $proxyindex = $this->CTRL->optimization->client_config_ref['proxy'];
        $proxyindexsub = $this->CTRL->optimization->client_config_ref['proxy-sub'];

        /**
         * Proxy settings
         */
        $proxy_url = $this->url();

        $jssettings[$proxyindex] = array(
            $proxyindexsub['url'] => $proxy_url,
            $proxyindexsub['js'] => (isset($this->CTRL->options['js_proxy']) && $this->CTRL->options['js_proxy']) ? true : false,
            $proxyindexsub['css'] => (isset($this->CTRL->options['css_proxy']) && $this->CTRL->options['css_proxy']) ? true : false
        );

        if ($this->cdn) {
            $jssettings[$proxyindex][$proxyindexsub['cdn']] = trailingslashit($this->cdn);
        }

        /**
         * Preload urls
         */
        $preload_hashes = array();
        if (isset($this->CTRL->options['css_proxy']) && $this->CTRL->options['css_proxy'] && !empty($this->CTRL->proxy->css_preload)) {
            foreach ($this->CTRL->proxy->css_preload as $url) {
                $preload[] = $url;
            }
        }
        if (isset($this->CTRL->options['js_proxy']) && $this->CTRL->options['js_proxy'] && !empty($this->CTRL->proxy->js_preload)) {
            foreach ($this->CTRL->proxy->js_preload as $url) {
                $preload[] = $url;
            }
        }

        if (!empty($preload)) {
            $jssettings[$proxyindex][$proxyindexsub['preload']] = $preload;
        }
        
        // base path
        $jssettings[$proxyindex][$proxyindexsub['base']] = $this->CTRL->cache_dir('proxy');

        $keys = array('js_include','css_include','js_exclude','css_exclude');
        foreach ($keys as $key) {
            $params = explode('_', $key);
            if ($this->CTRL->options[$params[0] . '_proxy'] && is_array($this->CTRL->proxy->$key) && !empty($this->CTRL->proxy->$key)) {
                $jssettings[$proxyindex][$proxyindexsub[$key]] = $this->CTRL->proxy->$key;
            }
        }

        // fill empty array values to preserve JSON array format
        $max = 0;
        foreach ($jssettings[$proxyindex] as $index => $value) {
            if ($index > $max) {
                $max = $index;
            }
        }
        if ($max > 0) {
            for ($i = 0; $i <= $max; $i++) {
                if (!isset($jssettings[$proxyindex][$i])) {
                    $jssettings[$proxyindex][$i] = -1;
                }
            }
            ksort($jssettings[$proxyindex]);
        }

        $jsfiles[] = WPABTF_PATH . 'public/js/abovethefold-proxy'.$jsdebug.'.min.js';
    }

    /**
     * Prune expired cache entries
     */
    public function prune($stats_only = false)
    {

        // age to delete cache file
        $prune_age = 30 * 86400; // 1 month
        $prune_time = (time() - $prune_age);

        $file_count = 0;
        $file_size = 0;
        $deleted_count = 0;

        $cache_path = $this->CTRL->cache_path('proxy');

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
                                        if (!$stats_only) {
                                            @unlink($C_cache_path . $file);
                                            $deleted_count++;
                                        }
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

        // add warning for admin
        if ($file_count > 500) {
            $this->CTRL->admin->set_notice('<h4 style="margin:0px;padding:0px;">Above The Fold Optimization</h4><p style="margin:0px;margin-top:4px;">The Proxy Cache directory contains '.number_format($file_count, 0, '.', ',').' cache entries. This may indicate that auto-capture captures a script with a changing url that causes a new cache entry to be created on each request.</p>
				<p style="margin:0px;">The <a href="'. add_query_arg(array( 'page' => 'pagespeed-proxy' ), admin_url('admin.php')) . '#jsoncnf">Proxy configuration page</a> shows a solution to capture scripts with a changing url using a JSON config object.</p>', 'ERROR', array(
                    'date' => time(),
                    'expire' => (60 * 2)
                ));
        }

        // empty cache directory when reaching > 5,000 files
        if ($file_count > 5000) {
            $this->empty_cache();

            $this->CTRL->admin->set_notice('<h4 style="margin:0px;padding:0px;">Above The Fold Optimization</h4><p style="margin:0px;margin-top:4px;">The Proxy Cache directory reached '.number_format($file_count, 0, '.', ',').' cache entries. The cache directory has been emptied.</p>', 'ERROR', array(
                    'date' => time(),
                    'expire' => (60 * 2)
                ));

            $deleted_count = $file_count + $deleted_count;
            $file_size = $file_count = 0;
        }

        // update proxy stats
        $stats = get_option('abovethefold-proxy-stats');
        if (!is_array($stats)) {
            $stats = array();
        }
        $stats['files'] = $file_count;
        $stats['size'] = $file_size;
        $stats['deleted'] = $deleted_count;

        $stats['date'] = time();

        update_option('abovethefold-proxy-stats', $stats, false);

        return $stats;
    }

    /**
     * Empty cache directory
     */
    public function empty_cache()
    {
        $cache_path = $this->CTRL->cache_path('proxy');
        $root_dir = array_diff(scandir($cache_path), array('..', '.'));
        foreach ($root_dir as $dirA) {
            $this->CTRL->rmdir($cache_path . $dirA . '/');
        }

        $this->prune(true);
    }

    /**
     * Get proxy cache stats
     */
    public function cache_stats()
    {
        $stats = get_option('abovethefold-proxy-stats');
        if (is_array($stats) && isset($stats['date']) && intval($stats['date']) > (time() - (60 * 60))) {
            return $stats;
        }

        return $this->prune(true);
    }

    /**
     * Cron prune method
     */
    public function cron_prune()
    {

        // cron logfile
        $cache_path = $this->CTRL->cache_path('proxy');
        $cronlog = $cache_path . 'cleanup_cron.log';
        $this->CTRL->file_put_contents($cronlog, 'start: ' . date('r'));

        // prune cache
        $stats = $this->prune(false);

        // log result
        $this->CTRL->file_put_contents($cronlog, 'completed: ' . date('r') . "\nDeleted: " . $stats['deleted'] . "\nFiles: " . $stats['files'] . "\nSize: " . $stats['size']);
    }
}
