<?php

/**
 * Abovethefold Web Font optimization functions and hooks.
 *
 * This class provides the functionality for Web Font optimization functions and hooks.
 *
 * @since      2.5.0
 * @package    abovethefold
 * @subpackage abovethefold/includes
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */


class Abovethefold_WebFonts
{

    /**
     * Above the fold controller
     */
    public $CTRL;

    /**
     * webfont.js CDN url
     */
    public $cdn_url = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';

    /**
     * webfont.js CDN version
     */
    public $cdn_version = '1.6.28';

    /**
     * Google fonts
     */
    public $googlefonts = array();
    public $googlefonts_ignore = array();

    /**
     * Web Font replacement string
     */
    public $webfont_inline_replacement_string = 'ABTF_WEBFONT_INLINE_CONFIG';

    /**
     * Initialize the class and set its properties
     */
    public function __construct(&$CTRL)
    {
        $this->CTRL =& $CTRL;

        if ($this->CTRL->disabled) {
            return; // above the fold optimization disabled for area / page
        }

        // set default state
        if (!isset($this->CTRL->options['gwfo'])) {
            $this->CTRL->options['gwfo'] = false;
        }

        // load google fonts from settings
        if (isset($this->CTRL->options['gwfo_googlefonts']) && is_array($this->CTRL->options['gwfo_googlefonts'])) {
            $this->googlefonts = $this->CTRL->options['gwfo_googlefonts'];
        }
        if (isset($this->CTRL->options['gwfo_googlefonts_ignore']) && is_array($this->CTRL->options['gwfo_googlefonts_ignore'])) {
            $this->googlefonts_ignore = $this->CTRL->options['gwfo_googlefonts_ignore'];
        }

        // autodetect google fonts
        $this->googlefonts_autodetect = (!isset($this->CTRL->options['gwfo_googlefonts_auto']) || $this->CTRL->options['gwfo_googlefonts_auto']) ? true : false;

        // define default settings
        if (!isset($this->CTRL->options['gwfo_loadmethod'])) {
            $this->CTRL->options['gwfo_loadmethod'] = 'inline';
        }
        if (!isset($this->CTRL->options['gwfo_loadposition'])) {
            $this->CTRL->options['gwfo_loadposition'] = 'header';
        }

        /**
         * Google Web Font Optimizer enabled
         */
        if ($this->CTRL->options['gwfo']) {

            // add filter for CSS minificaiton output
            $this->CTRL->loader->add_filter('abtf_css', $this, 'process_css');

            // add filter for CSS file processing
            $this->CTRL->loader->add_filter('abtf_cssfile_pre', $this, 'process_cssfile');

            // add filter for HTML output
            $this->CTRL->loader->add_filter('abtf_html_pre', $this, 'process_html_pre');

            // add filter for HTML output
            $this->CTRL->loader->add_filter('abtf_html_replace', $this, 'replace_html');

            if (isset($this->CTRL->options['gwfo_loadmethod']) && $this->CTRL->options['gwfo_loadmethod'] === 'wordpress') {

                /**
                 * load webfont.js via WordPress include
                 */
                $this->CTRL->loader->add_action('wp_enqueue_scripts', $this, 'enqueue_webfontjs', 10);
            }
        }
    }

    /**
     * Extract fonts from CSS
     */
    public function process_css($CSS)
    {

        /**
         * Regex search replace on CSS
         */
        $search = array();
        $replace = array();

        /**
         * Parse Google Fonts
         */
        $googlefonts = array();

        // find @import with Google Font CSS
        if (preg_match_all('#(?:@import)(?:\\s)(?:url)?(?:(?:(?:\\()(["\'])?(?:[^"\')]+)\\1(?:\\))|(["\'])(?:.+)\\2)(?:[A-Z\\s])*)+(?:;)#Ui', $CSS, $out) && !empty($out[0])) {
            foreach ($out[0] as $n => $fontLink) {
                if (substr_count($fontLink, "fonts.googleapis.com/css") > 0) {
                    $fontLink = preg_replace('|^.*(//fonts\.[^\s\'\"\)]+)[\s\|\'\|\"\|\)].*|is', '$1', $fontLink);

                    // parse fonts
                    list($fonts, $ignoredFontsLink) = $this->fonts_from_url($fontLink);

                    // font contains Google Fonts
                    if ($fonts && !empty($fonts['google'])) {
                        foreach ($fonts['google'] as $googlefont) {
                            if (!in_array(trim($googlefont), $this->googlefonts)) {
                                $googlefonts[] = trim($googlefont);
                            }
                        }

                        /**
                         * Remove or replace @import in CSS
                         */
                        $search[] = '|'.preg_quote($out[0][$n]).'|Ui';
                        $replace[] = ($ignoredFontsLink) ? '@import ' . $ignoredFontsLink . ';' : ' ';
                    }
                }
            }

            if (!empty($googlefonts)) {
                $this->update_google_fonts($googlefonts);
            }
        }

        // perform search/replace
        if (!empty($search)) {
            $CSS = preg_replace($search, $replace, $CSS);
        }

        return trim($CSS);
    }

    /**
     * Parse CSS file in CSS file loop
     */
    public function process_cssfile($cssfile)
    {
        
        // ignore
        if (!$cssfile || in_array($cssfile, array('delete','ignore'))) {
            return $cssfile;
        }

        // Google font?
        if (strpos($cssfile, 'fonts.googleapis.com/css') !== false) {
            $googlefonts = array();

            list($fonts, $ignoredFontsLink) = $this->fonts_from_url($cssfile);
            if ($fonts && !empty($fonts['google'])) {
                foreach ($fonts['google'] as $googlefont) {
                    if (!in_array(trim($googlefont), $this->googlefonts)) {
                        $googlefonts[] = trim($googlefont);
                    }
                }

                // google fonts
                if (!empty($googlefonts)) {
                    $this->update_google_fonts($googlefonts);
                }

                // delete or replace stylesheet in HTML
                return ($ignoredFontsLink) ? array($ignoredFontsLink,'ignore') : 'delete';
            }
        }

        return $cssfile;
    }

    /**
     * Extract fonts from HTML pre optimization
     */
    public function process_html_pre($HTML)
    {

        /**
         * Parse Google Fonts in WebFontConfig
         */
        if (strpos($HTML, 'WebFontConfig') !== false) {
            $googlefonts = array();

            // Try to parse WebFontConfig variable
            if (preg_match_all('#WebFontConfig\s*=\s*\{[^;]+\};#s', $HTML, $out)) {
                foreach ($out[0] as $wfc) {
                    $this->fonts_from_webfontconfig($wfc, $googlefonts);
                }
            }

            // google fonts
            if (!empty($googlefonts)) {
                $this->update_google_fonts($googlefonts);
            }
        }

        return $HTML;
    }

    /**
     * Replace HTML
     */
    public function replace_html($searchreplace)
    {
        list($search, $replace, $search_regex, $replace_regex) = $searchreplace;

        /**
         * Inline Web Font Loading
         */
        if (isset($this->CTRL->options['gwfo_loadmethod'])) {
            if ($this->CTRL->options['gwfo_loadmethod'] !== 'disabled') {

                /**
                 * Update Web Font configuration
                 */
                $google_fonts = $this->get_google_fonts();
                if (!empty($google_fonts)) {
                    $google_fonts = json_encode($google_fonts);
                } else {
                    $google_fonts = -9;
                }
                $search[] = '"' . $this->webfont_inline_replacement_string . '"';
                $replace[] = esc_attr($google_fonts);
            }
        }

        return array($search, $replace, $search_regex, $replace_regex);
    }

    /**
     * Update Google fonts
     */
    public function update_google_fonts($googlefonts)
    {

        /**
         * Get current google font configuration
         */
        $current_googlefonts = $this->googlefonts;

        $new = false; // new fonts?

        foreach ($googlefonts as $googlefont) {
            $googlefont = trim($googlefont);
            if (!in_array($googlefont, $current_googlefonts)) {
                $new = true;
                $current_googlefonts[] = $googlefont;
            }
        }

        /**
         * Update Google Web Font Configuration
         */
        if ($new) {
            $current_googlefonts = array_unique($current_googlefonts);
            
            if ($this->googlefonts_autodetect) {
                $options = get_option('abovethefold');
                $options['gwfo_googlefonts'] = $current_googlefonts;
                update_option('abovethefold', $options);
            }

            $this->CTRL->options['gwfo_googlefonts'] = $current_googlefonts;
            $this->googlefonts = $current_googlefonts;
        }
    }

    /**
     * Parse Webfont Fonts from link
     */
    public function fonts_from_url($fontLink)
    {

        // fonts found in url
        $fonts = array();

        // parse querystring of url
        parse_str(parse_url($fontLink, PHP_URL_QUERY), $urlParameters);

        /**
         * Custom font
         */
        if (isset($urlParameters['text'])) {

            /**
        	 * @todo custom fonts
        	 */
        } else {

            /**
        	 * Google Font Family config
        	 */
            $familyParams = explode('|', $urlParameters['family']);

            foreach ($familyParams as $familyKey => $fontFamilies) {
                $fontFamily = explode(':', $fontFamilies);

                if (isset($urlParameters['subset'])) {
                    # Use the subset parameter for a subset
                    $subset = $urlParameters['subset'];
                } else {
                    if (isset($fontFamily[2])) {
                        # Use the subset in the family string
                        $subset = $fontFamily[2];
                    } else {
                        # Use a default subset
                        $subset = "latin";
                    }
                }

                
                if (strlen($fontFamily[0]) > 0) {

                    // font reference
                    $fontstr = $fontFamily[0] . ":" . $fontFamily[1] . ":" . $subset;

                    // verify if font is ignored
                    $ignored = false;
                    if (!empty($this->googlefonts_ignore)) {
                        foreach ($this->googlefonts_ignore as $ignoreFont) {
                            if (stripos($fontstr, $ignoreFont) !== false) {
                                $ignored = true;
                                break 1;
                            }
                        }
                    }

                    if (!$ignored) {

                        // initiate google fonts array
                        if (!isset($fonts['google'])) {
                            $fonts['google'] = array();
                        }
                        $fonts['google'][] = $fontstr;

                        unset($familyParams[$familyKey]);
                    }
                }
            }

            // ignored fonts
            if (!empty($familyParams)) {
                $familyParams = array_values($familyParams);

                $urlParameters['family'] = implode('|', $familyParams);

                $queryPortion = parse_url($fontLink, PHP_URL_QUERY);
                $modifiedQuery = http_build_query($urlParameters);

                $fontLink = str_replace($queryPortion, $modifiedQuery, $fontLink);

                return array(((!empty($fonts)) ? $fonts : false), $fontLink);
            }
        }

        return array(((!empty($fonts)) ? $fonts : false), false);
    }

    /**
     * Parse Webfont Fonts from link
     */
    public function fonts_from_webfontconfig($WebFontConfig, &$googlefonts)
    {

        // Extract Google fonts
        if (strpos($WebFontConfig, 'google') !== false) {
            if (preg_match('#google[\'|"]?\s*:\s*\{[^\}]+families\s*:\s*(\[[^\]]+\])#is', $WebFontConfig, $gout)) {
                $gfonts = @json_decode($this->fixJSON($gout[1]), true);
                if (is_array($gfonts) && !empty($gfonts)) {
                    $googlefonts = array_unique(array_merge($googlefonts, $gfonts));
                }
            }
        }
    }

    /**
     * Return Google fonts
     */
    public function get_google_fonts()
    {
        /**
         * Apply Google Font Remove List
         */
        if (!empty($this->googlefonts) && isset($this->CTRL->options['gwfo_googlefonts_remove']) && !empty($this->CTRL->options['gwfo_googlefonts_remove'])) {
            $removeList = $this->CTRL->options['gwfo_googlefonts_remove'];
            $this->googlefonts =  array_filter($this->googlefonts, function ($font) use ($removeList) {
                foreach ($removeList as $removeFont) {
                    if (stripos($font, $removeFont) !== false) {
                        // remove font
                        return false;
                    }
                }
                return true;
            });
        }

        /**
         * Add Google Fonts to config
         */
        if (!empty($this->googlefonts)) {
            return $this->googlefonts;
        }

        return array();
    }

    /**
     * Fix invalid json (single quotes vs double quotes)
     */
    public function fixJSON($json)
    {
        $json = preg_replace("/(?<!\"|'|\w)([a-zA-Z0-9_]+?)(?!\"|'|\w)\s?:/", "\"$1\":", $json);

        $regex = <<<'REGEX'
~
    "[^"\\]*(?:\\.|[^"\\]*)*"
    (*SKIP)(*F)
  | '([^'\\]*(?:\\.|[^'\\]*)*)'
~x
REGEX;

        return preg_replace_callback($regex, function ($matches) {
            return '"' . preg_replace('~\\\\.(*SKIP)(*F)|"~', '\\"', $matches[1]) . '"';
        }, $json);
    }

    /**
     * Enqueue webfont.js
     */
    public function enqueue_webfontjs()
    {

        /**
         * Google Web Font Loader WordPress inlcude
         */
        $in_footer = (isset($this->CTRL->options['gwfo_loadposition']) && $this->CTRL->options['gwfo_loadposition'] === 'footer') ? true : false;
        wp_enqueue_script('abtf_webfontjs', WPABTF_URI . 'public/js/webfont.js', array(), $this->package_version(), $in_footer);
    }

    /**
     * Get package version
     */
    public function package_version($reset = false)
    {
        if (!$reset) {
            $version = get_option('abtf_webfontjs_version');
            if ($version) {
                return $version;
            }
        }

        // check existence of package file
        $webfont_package = WPABTF_PATH . 'public/js/src/webfontjs_package.json';
        if (!file_exists($webfont_package)) {
            $this->CTRL->admin->set_notice('PLUGIN INSTALLATION NOT COMPLETE, MISSING public/js/src/webfontjs_package.json', 'ERROR');
            return false;
        } else {
            $package = @json_decode(file_get_contents($webfont_package), true);
            if (!is_array($package)) {
                $this->CTRL->admin->set_notice('failed to parse public/js/src/webfontjs_package.json', 'ERROR');
                return false;
            } else {
                $version = update_option('abtf_webfontjs_version', $package['version']);

                // return version
                return $package['version'];
            }
        }
    }


    /**
     * Javascript client settings
     */
    public function client_jssettings(&$jssettings, &$jsfiles, &$inlineJS, $jsdebug, &$script_code_before)
    {
        if (isset($this->CTRL->options['gwfo_loadmethod']) && $this->CTRL->options['gwfo_loadmethod'] === 'disabled') {

            // disabled, remove Web Font Loader
            //$this->CTRL->options['gwfo'] = false;
        } else {
            $google_fonts = $this->get_google_fonts();

            /**
             * Support old option to include custom WebFontConfig in the settings.
             *
             * To comply with Content-Security-Policy it is advised to move this config to a file.
             */
            if (isset($this->CTRL->options['gwfo_config']) && $this->CTRL->options['gwfo_config'] !== '' && isset($this->CTRL->options['gwfo_config_valid']) && $this->CTRL->options['gwfo_config_valid']) {
                $WebFontConfig = trim($this->CTRL->options['gwfo_config']);

                // WebFontConfig has Google fonts, merge
                if (strpos($WebFontConfig, 'GOOGLE-FONTS-FROM-INCLUDE-LIST') !== false) {
                    $quote = (strpos($WebFontConfig, '\'GOOGLE-FONTS-FROM-INCLUDE-LIST') !== false) ? '\'' : '"';
                    $WebFontConfig = str_replace($quote . 'GOOGLE-FONTS-FROM-INCLUDE-LIST' . $quote, json_encode($this->googlefonts), $WebFontConfig);
                }
                if (strpos($WebFontConfig, 'WebFontConfig') === 0) {
                    $WebFontConfig = 'var ' . $WebFontConfig;
                }
                $script_code_before .= $WebFontConfig;
            }

            if (empty($google_fonts)) {

                // empty, do not load webfont.js
                $this->CTRL->options['gwfo'] = false;
            } else {
                $gfwindex = $this->CTRL->optimization->client_config_ref['gwf'];

                // google fonts
                $jssettings[$gfwindex] = array();
                $jssettings[$gfwindex][$this->CTRL->optimization->client_config_ref['gwf-sub']['google_fonts']] = $this->webfont_inline_replacement_string;

                // load position
                $jssettings[$gfwindex][$this->CTRL->optimization->client_config_ref['gwf-sub']['footer']] = ($this->CTRL->options['gwfo_loadposition'] === 'footer') ? true : false;

                // async
                if ($this->CTRL->options['gwfo_loadmethod'] === 'async' || $this->CTRL->options['gwfo_loadmethod'] === 'async_cdn') {
                    $jssettings[$gfwindex][$this->CTRL->optimization->client_config_ref['gwf-sub']['async']] = true;
                }

                // async url
                if ($this->CTRL->options['gwfo_loadmethod'] === 'async' || $this->CTRL->options['gwfo_loadmethod'] === 'async_cdn') {
                    if ($this->CTRL->options['gwfo_loadmethod'] === 'async') {
                        $jssettings[$gfwindex][$this->CTRL->optimization->client_config_ref['gwf-sub']['async_url']] = WPABTF_URI . 'public/js/webfont.js';
                    } else {

                    // load from Google CDN
                    $jssettings[$gfwindex][$this->CTRL->optimization->client_config_ref['gwf-sub']['async_url']] = $this->cdn_url;
                    }
                }

                /**
                 * Load webfont.js inline
                 */
                if ($this->CTRL->options['gwfo_loadmethod'] === 'inline') {
                    $jsfiles[] = WPABTF_PATH . 'public/js/webfont.js';
                }
            }
        }
    }

    /**
     * Verify WebFontConfig variable
     */
    public function verify_webfontconfig($WebFontConfig)
    {
        $WebFontConfig = trim($WebFontConfig);
        if ($WebFontConfig === '') {
            return false;
        }

        // verify string
        if (preg_match('|^WebFontConfig\s*=\s*\{.*;$|s', $WebFontConfig)) {
            return true;
        }

        return false;
    }
}
