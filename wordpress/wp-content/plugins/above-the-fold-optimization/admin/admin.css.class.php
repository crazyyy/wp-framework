<?php

/**
 * CSS admin controller
 *
 * @since      2.5.4
 * @package    abovethefold
 * @subpackage abovethefold/admin
 * @author     PageSpeed.pro <info@pagespeed.pro>
 */

class Abovethefold_Admin_CSS
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
            $this->CTRL->loader->add_action('admin_post_abtf_css_update', $this, 'update_settings');
        }
    }

    /**
     * Update settings
     */
    public function update_settings()
    {
        check_admin_referer('abovethefold');

        if (isset($_POST['uploadgooglefontzip'])) {

            /**
             * Extract Google Fonts
             */
            if (!empty($_FILES) && $_FILES['googlefontzip'] && $_FILES['googlefontzip']['name']) {
                if ($_FILES['googlefontzip']['error']) {
                    $this->CTRL->admin->set_notice('Google Font zip-file upload error: ' . $_FILES['googlefontzip']['error'], 'ERROR');
                } else {
                    if (!class_exists('ZipArchive')) {
                        $this->CTRL->admin->set_notice('Your PHP installation does not support <a href="http://php.net/manual/en/ziparchive.extractto.php" target="_blank">ZipArchive</a>.', 'ERROR');
                    } else {
                        $fontsdir = trailingslashit(get_stylesheet_directory()) . 'fonts/';
                        if (!is_dir($fontsdir)) {
                            // create fonts directory
                            if (!$this->CTRL->mkdir($fontsdir)) {
                                $this->CTRL->admin->set_notice('Failed to create font directory '.htmlentities(str_replace(ABSPATH, '/', trailingslashit(get_stylesheet_directory()) . 'fonts/'), ENT_COMPAT, 'utf-8').'', 'ERROR');
                            }
                        }

                        // try to open zip]
                        $zip = new ZipArchive;
                        if ($zip->open($_FILES['googlefontzip']['tmp_name']) === true) {
                            $zip->extractTo($fontsdir);
                            $zip->close();

                            // Set file permissions to make fonts writable by FTP
                            $fontfiles = array_diff(scandir($fontsdir), array('..', '.'));
                            foreach ($fontfiles as $fontfile) {

                                // font files only
                                if (is_file($fontsdir . $fontfile) && preg_match('#\.(eot|woff|woff2|svg|ttf)$#Ui', $fontfile)) {
                                    @chmod($fontsdir . $fontfile, 0666);
                                }
                            }

                            $this->CTRL->admin->set_notice('<p style="font-size:18px;">Google Font zip-file extracted successfully.</p>', 'NOTICE');
                        } else {
                            $this->CTRL->admin->set_notice('Failed to read Google Font zip-file.', 'ERROR');
                        }
                    }
                }
            }
            
            wp_redirect(add_query_arg(array( 'page' => 'pagespeed-css' ), admin_url('admin.php')));
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
         * Optimize CSS delivery
         */
        $options['cssdelivery'] = (isset($input['cssdelivery']) && intval($input['cssdelivery']) === 1) ? true : false;
        $options['loadcss_enhanced'] = (isset($input['loadcss_enhanced']) && intval($input['loadcss_enhanced']) === 1) ? true : false;
        $options['cssdelivery_position'] = trim($input['cssdelivery_position']);
        $options['cssdelivery_ignore'] = $this->CTRL->admin->newline_array($input['cssdelivery_ignore']);
        $options['cssdelivery_remove'] = $this->CTRL->admin->newline_array($input['cssdelivery_remove']);
        $options['cssdelivery_renderdelay'] = (isset($input['cssdelivery_renderdelay']) && is_numeric($input['cssdelivery_renderdelay']) && intval($input['cssdelivery_renderdelay']) > 0) ? intval($input['cssdelivery_renderdelay']) : false;

        /**
         * Web Font Optimization
         */
        $options['gwfo'] = (isset($input['gwfo']) && intval($input['gwfo']) === 1) ? true : false;
        $options['gwfo_loadmethod'] = trim($input['gwfo_loadmethod']);
        $options['gwfo_loadposition'] = trim($input['gwfo_loadposition']);
        $options['gwfo_googlefonts_auto'] = (isset($input['gwfo_googlefonts_auto']) && intval($input['gwfo_googlefonts_auto']) === 1) ? true : false;
        $options['gwfo_config'] = trim($input['gwfo_config']);

        /**
         * Google Fonts
         */
        $options['gwfo_googlefonts'] = (isset($input['gwfo_googlefonts'])) ? $this->CTRL->admin->newline_array($input['gwfo_googlefonts']) : array();

        /**
         * WebFontConfig
         */
        if ($options['gwfo_config'] !== '') {
            if (substr($options['gwfo_config'], -1) === '}') {
                $options['gwfo_config'] .= ';';
            }

            if (!$this->CTRL->gwfo->verify_webfontconfig($options['gwfo_config'])) {
                $error = true;
                $this->CTRL->admin->set_notice('WebFontConfig variable is not valid. It should consist of <code>WebFontConfig = { ... };</code>.', 'ERROR');
                $options['gwfo_config_valid'] = false;
            } else {

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

                $options['gwfo_config_valid'] = true;
            }
        } else {
            $options['gwfo_config_valid'] = true;
        }

        /**
         * Google Fonts Remove List
         */
        $options['gwfo_googlefonts_remove'] = (isset($input['gwfo_googlefonts_remove'])) ? $this->CTRL->admin->newline_array($input['gwfo_googlefonts_remove']) : array();

        /**
         * Google Fonts Ignore List
         */
        $options['gwfo_googlefonts_ignore'] = (isset($input['gwfo_googlefonts_ignore'])) ? $this->CTRL->admin->newline_array($input['gwfo_googlefonts_ignore']) : array();

        // update settings
        $this->CTRL->admin->save_settings($options, 'CSS optimization settings saved.');

        wp_redirect(add_query_arg(array( 'page' => 'pagespeed-css' ), admin_url('admin.php')));
        exit;
    }
}
