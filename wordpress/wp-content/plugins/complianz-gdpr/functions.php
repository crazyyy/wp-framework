<?php
defined('ABSPATH') or die("you do not have acces to this page!");

if (!function_exists('cmplz_uses_google_analytics')) {
    function cmplz_uses_google_analytics()
    {
        return COMPLIANZ()->cookie->uses_google_analytics();
    }
}

/*
 * This overrides the enabled setting for use_categories, based on the tagmanager settings
 * When tagmanager is enabled, use of TM cats is obligatory
 *
 *
 * */

add_filter('cmplz_fields', 'cmplz_fields_filter', 10, 1);
if (!function_exists('cmplz_fields_filter')) {

    function cmplz_fields_filter($fields)
    {

        $tm_fires_scripts = cmplz_get_value('fire_scripts_in_tagmanager') === 'yes' ? true : false;
        $uses_tagmanager = cmplz_get_value('compile_statistics') === 'google-tag-manager' ? true : false;
        if ($uses_tagmanager && $tm_fires_scripts) {
            $fields['use_categories']['help'] = __('Because you have selected Tag Manager and Tag Manager fires scripts, categories are required','complianz-gdpr');
            $fields['use_categories']['disabled'] = true;
        }

        return $fields;
    }
}

if (!function_exists('cmplz_get_template')) {

    function cmplz_get_template($file)
    {

        $file = trailingslashit(cmplz_path) . 'templates/' . $file;
        $theme_file = trailingslashit(get_stylesheet_directory()) . dirname(cmplz_path) . $file;

        if (file_exists($theme_file)) {
            $file = $theme_file;
        }

        if (strpos($file, '.php') !== FALSE) {
            ob_start();
            require $file;
            $contents = ob_get_clean();
        } else {
            $contents = file_get_contents($file);
        }

        return $contents;
    }
}

if (!function_exists('cmplz_tagmanager_conditional_helptext')) {

    function cmplz_tagmanager_conditional_helptext()
    {
        if (cmplz_no_ip_addresses() && cmplz_statistics_no_sharing_allowed() && cmplz_accepted_processing_agreement()) {
            $text = __("Based on your Analytics configuration you should fire Analytics as a functional cookie on event cmplz_event_functional.", 'complianz-gdpr');
        } else {
            $text = __("Based on your Analytics configuration you should fire Analytics as a non-functional cookie with a category of your choice, for example cmplz_event_0.", 'complianz-gdpr');
        }

        return $text;
    }
}

if (!function_exists('cmplz_manual_stats_config_possible')) {

    /**
     * Checks if the statistics are configured so no consent is need for statistics
     *
     * @return bool
     */

    function cmplz_manual_stats_config_possible()
    {
        $stats = cmplz_get_value('compile_statistics');
        if ($stats === 'matomo' && cmplz_no_ip_addresses()) return true;

        if ($stats === 'google-analytics' || $stats === 'google-tag-manager') {
            if (cmplz_no_ip_addresses() && cmplz_statistics_no_sharing_allowed() && cmplz_accepted_processing_agreement()) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('cmplz_revoke_link')) {
    function cmplz_revoke_link($text = false)
    {
        $text = $text ? $text : __('Revoke cookie consent', 'complianz-gdpr');
        $html = '<button class="cc-revoke-custom">' . $text . '</button>&nbsp;<span class="cmplz-status-accepted">' . sprintf(__('Current status: %s', 'complianz-gdpr'), __("Accepted", 'complianz-gdpr')) . '</span><span class="cmplz-status-denied">' . sprintf(__('Current status: %s', 'complianz-gdpr'), __("Denied", 'complianz-gdpr')) . '</span>';
        return apply_filters('cmplz_revoke_link', $html);
    }
}

if (!function_exists('cmplz_do_not_sell_personal_data_form')) {

    function cmplz_do_not_sell_personal_data_form()
    {

        $html = cmplz_get_template('do-not-sell-my-personal-data-form.php');

        return $html;
    }
}
if (!function_exists('cmplz_sells_personal_data')) {

    function cmplz_sells_personal_data()
    {
        return COMPLIANZ()->company->sells_personal_data();
    }
}
if (!function_exists('cmplz_sold_data_12months')) {

    function cmplz_sold_data_12months()
    {
        return COMPLIANZ()->company->sold_data_12months();
    }
}
if (!function_exists('cmplz_disclosed_data_12months')) {

    function cmplz_disclosed_data_12months()
    {
        return COMPLIANZ()->company->disclosed_data_12months();
    }
}

/*
 * For usage very early in the execution order, use the $page option. This bypasses the class usage.
 *
 *
 * */
if (!function_exists('cmplz_get_value')) {

    function cmplz_get_value($fieldname, $post_id = false, $page = false)
    {

        if (!$page && !isset(COMPLIANZ()->config->fields[$fieldname])) return false;

        //if  a post id is passed we retrieve the data from the post
        if (!$page) $page = COMPLIANZ()->config->fields[$fieldname]['source'];
        if ($post_id && ($page !== 'wizard')) {
            $value = get_post_meta($post_id, $fieldname, true);
        } else {
            $fields = get_option('complianz_options_' . $page);

            $default = ($page && isset(COMPLIANZ()->config->fields[$fieldname]['default'])) ? COMPLIANZ()->config->fields[$fieldname]['default'] : '';
            $value = isset($fields[$fieldname]) ? $fields[$fieldname] : $default;

        }

        /*
         * Translate output
         *
         * */

        if (function_exists('icl_translate') || function_exists('pll__')) {
            $type = isset(COMPLIANZ()->config->fields[$fieldname]['type']) ? COMPLIANZ()->config->fields[$fieldname]['type'] : false;
            if ($type === 'cookies' || $type === 'thirdparties' || $type === 'processors') {
                if (is_array($value)) {
                    foreach ($value as $key => $key_value) {
                        if (function_exists('pll__')) $value[$key] = pll__($key_value);
                        if (function_exists('icl_translate')) $value[$key] = icl_translate('complianz', $fieldname . "_" . $key, $key_value);
                    }
                }
            } else {
                if (isset(COMPLIANZ()->config->fields[$fieldname]['translatable']) && COMPLIANZ()->config->fields[$fieldname]['translatable']) {
                    if (function_exists('pll__')) {
                        $value = pll__($value);
                    }
                    if (function_exists('icl_translate')) $value = icl_translate('complianz', $fieldname, $value);
                }
            }
        }

        return $value;
    }
}

if (!function_exists('cmplz_strip_variation_id_from_string')) {

    function cmplz_strip_variation_id_from_string($string)
    {
        $matches = array();
        if (preg_match('#(\d+)$#', $string, $matches)) {
            return str_replace($matches[1], '', $string);
        }
        return $string;
    }
}
if (!function_exists('cmplz_eu_site_needs_cookie_warning')) {

    function cmplz_eu_site_needs_cookie_warning()
    {
        return COMPLIANZ()->cookie->site_needs_cookie_warning('eu');
    }
}
/*
 *
 * */
if (!function_exists('cmplz_eu_site_needs_cookie_warning_cats')) {

    function cmplz_eu_site_needs_cookie_warning_cats()
    {
        if (cmplz_eu_site_needs_cookie_warning() && cmplz_get_value('use_categories')) {
            return true;
        }

        return false;
    }
}

if (!function_exists('cmplz_company_in_eu')) {

    function cmplz_company_in_eu()
    {
        $country_code = cmplz_get_value('country_company');
        $in_eu = (cmplz_get_region_for_country($country_code) === 'eu');
        return $in_eu;
    }
}

/*
 * Check if this company has this region selected.
 *
 *
 * */
if (!function_exists('cmplz_has_region')) {

    function cmplz_has_region($code)
    {
        $regions = cmplz_get_regions(false);
        if (isset($regions[$code])) return true;
        return false;
    }
}

if (!function_exists('cmplz_get_regions')) {

    function cmplz_get_regions($labels = true)
    {
        $regions = cmplz_get_value('regions', false, 'wizard');

        if (!is_array($regions) && !empty($regions)) $regions = array($regions => 1);
        $output = array();
        if (!empty($regions)) {
            foreach ($regions as $region => $enabled) {
                if (!$enabled) continue;
                $label = $labels && isset(COMPLIANZ()->config->regions[$region]) ? COMPLIANZ()->config->regions[$region]['label'] : '';
                $output[$region] = $label;
            }
        }

        return $output;
    }
}

if (!function_exists('cmplz_multiple_regions')) {

    function cmplz_multiple_regions()
    {
        //if geo ip is not enabled, return false anyway
        if (!cmplz_geoip_enabled()) return false;

        $regions = cmplz_get_regions();
        return count($regions) > 1;

    }
}

if (!function_exists('cmplz_get_region_for_country')) {

    function cmplz_get_region_for_country($country_code)
    {
        $regions = COMPLIANZ()->config->regions;
        foreach ($regions as $region_code => $region) {
            if (in_array($country_code, $region['countries'])) return $region_code;
        }

        return false;
    }
}

if (!function_exists('cmplz_notice')) {
    /**
     * @param string $msg
     * @param string $type notice | warning | success
     * @param bool $hide
     * @param bool $echo
     * @return string|void
     */
    function cmplz_notice($msg, $type = 'notice', $hide = false, $echo = true)
    {
        if ($msg == '') return;

        $hide_class = $hide ? "cmplz-hide" : "";
        $html = '<div class="cmplz-panel cmplz-' . $type . ' ' . $hide_class . '">' . $msg . '</div>';
        if ($echo) {
            echo $html;
        } else {
            return $html;
        }
    }
}

if (!function_exists('cmplz_panel')) {

    function cmplz_panel($title, $html, $custom_btn = '', $validate = false)
    {
        if ($title == '') return;

        $slide = ($html == '') ? false : true;
        $validate_icon = $validate ? '<span class="cmplz-multiple-field-validation"><i class="fa fa-times"></i></span>' : '';

        ?>
        <div class="cmplz-panel cmplz-slide-panel">
            <div class="cmplz-panel-title">

                <span class="cmplz-panel-toggle">
                    <i class="toggle fa fa-caret-right"></i>
                    <span class="cmplz-title"><?php echo $title ?></span>
                 </span>


                <?php echo $validate_icon ?>
                <span><?php echo $custom_btn ?></span>
            </div>
            <div class="cmplz-panel-content">
                <?php echo $html ?>
            </div>
        </div>
        <?php

    }
}

if (!function_exists('cmplz_list_item')) {

    function cmplz_list_item($title, $link, $btn, $selected)
    {
        if ($title == '') return;
        $selected = $selected ? "selected" : '';
        ?>

            <div class="cmplz-panel cmplz-link-panel <?php echo $selected ?>">
                <div class="cmplz-panel-title">
                    <a class="cmplz-panel-link" href="<?php echo $link ?>">
                <span class="cmplz-panel-toggle">
                    <i class="fa fa-edit"></i>
                    <span class="cmplz-title"><?php echo $title ?></span>
                 </span>
                    </a>

                    <?php echo $btn ?>
                </div>
            </div>
        <?php

    }
}

/**
 * Check if the scan detected social media on the site.
 *
 *
 * */
if (!function_exists('cmplz_scan_detected_social_media')) {

    function cmplz_scan_detected_social_media()
    {
        $social_media = get_option('cmplz_detected_social_media');

        //nothing scanned yet, or nothing found
        if (!$social_media || (count($social_media) == 0)) return false;
        return $social_media;
    }
}

if (!function_exists('cmplz_scan_detected_thirdparty_services')) {

    function cmplz_scan_detected_thirdparty_services()
    {
        $thirdparty = get_option('cmplz_detected_thirdparty_services');
        //nothing scanned yet, or nothing found
        if (!$thirdparty || (count($thirdparty) == 0)) return false;

        return $thirdparty;
    }
}

if (!function_exists('cmplz_update_option')) {

    function cmplz_update_option($page, $fieldname, $value)
    {
        $options = get_option('complianz_options_' . $page);
        $options[$fieldname] = $value;
        if (!empty($options)) update_option('complianz_options_' . $page, $options);
    }
}


if (!function_exists('cmplz_uses_statistics')) {

    function cmplz_uses_statistics()
    {
        $stats = cmplz_get_value('compile_statistics');
        if ($stats !== 'no') return true;

        return false;
    }
}

if (!function_exists('cmplz_uses_only_functional_cookies')) {
    function cmplz_uses_only_functional_cookies()
    {
        return COMPLIANZ()->cookie->uses_only_functional_cookies();
    }
}

if (!function_exists('cmplz_third_party_cookies_active')) {

    function cmplz_third_party_cookies_active()
    {
        return COMPLIANZ()->cookie->third_party_cookies_active();
    }
}

if (!function_exists('cmplz_strip_spaces')) {

    function cmplz_strip_spaces($string)
    {
        return preg_replace('/\s*/m', '', $string);

    }
}

if (!function_exists('cmplz_localize_date')) {

    function cmplz_localize_date($date)
    {
        $month = date('F', strtotime($date)); //june
        $month_localized = __($month); //juni
        $date = str_replace($month, $month_localized, $date);
        $weekday = date('l', strtotime($date)); //wednesday
        $weekday_localized = __($weekday); //woensdag
        $date = str_replace($weekday, $weekday_localized, $date);
        return $date;
    }
}

if (!function_exists('cmplz_wp_privacy_version')) {

    function cmplz_wp_privacy_version()
    {
        global $wp_version;
        return ($wp_version >= '4.9.6');
    }
}

/**
 * callback for privacy document Check if there is a text entered in the custom privacy statement text
 *
 * */
if (!function_exists('cmplz_has_custom_privacy_policy')) {
    function cmplz_has_custom_privacy_policy()
    {
        $policy = cmplz_get_value('custom_privacy_policy_text');
        if (empty($policy)) return false;

        return true;
    }
}

/**
 * callback for privacy statement document, check if google is allowed to share data with other services
 *
 * */
if (!function_exists('cmplz_statistics_no_sharing_allowed')) {
    function cmplz_statistics_no_sharing_allowed()
    {

        $fields = get_option('complianz_options_wizard', false, 'wizard');
        $value = isset($fields['compile_statistics']) ? $fields['compile_statistics'] : false;

        $statistics = cmplz_get_value('compile_statistics', false, 'wizard');
        $tagmanager = ($statistics === 'google-tag-manager') ? true : false;
        $google_analytics = ($statistics === 'google-analytics') ? true : false;

        if ($google_analytics || $tagmanager) {
            $thirdparty = $google_analytics ? cmplz_get_value('compile_statistics_more_info', false, 'wizard') : cmplz_get_value('compile_statistics_more_info_tag_manager', false, 'wizard');

            $no_sharing = (isset($thirdparty['no-sharing']) && ($thirdparty['no-sharing'] == 1)) ? true : false;
            if ($no_sharing) {
                return true;
            } else {
                return false;
            }
        }

        //only applies to google
        return false;
    }
}

/**
 * callback for privacy statement document. Check if ip addresses are stored.
 *
 * */
if (!function_exists('cmplz_no_ip_addresses')) {
    function cmplz_no_ip_addresses()
    {
        $statistics = cmplz_get_value('compile_statistics', false, 'wizard');

        //anonymous stats.
        if ($statistics === 'yes-anonymous') {
            return true;
        }

        //not anonymous stats.
        if ($statistics === 'yes') {
            return false;
        }

        $tagmanager = ($statistics === 'google-tag-manager') ? true : false;
        $matomo = ($statistics === 'matomo') ? true : false;
        $google_analytics = ($statistics === 'google-analytics') ? true : false;

        if ($google_analytics || $tagmanager) {
            $thirdparty = $google_analytics ? cmplz_get_value('compile_statistics_more_info', false, 'wizard') : cmplz_get_value('compile_statistics_more_info_tag_manager', false, 'wizard');
            $ip_anonymous = (isset($thirdparty['ip-addresses-blocked']) && ($thirdparty['ip-addresses-blocked'] == 1)) ? true : false;
            if ($ip_anonymous) {
                return true;
            } else {
                return false;
            }
        }

        if ($matomo) {
            if (cmplz_get_value('matomo_anonymized', false, 'wizard') === 'yes') {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('cmplz_cookie_warning_required_stats')) {
    function cmplz_cookie_warning_required_stats()
    {
        return COMPLIANZ()->cookie->cookie_warning_required_stats();
    }
}

if (!function_exists('cmplz_accepted_processing_agreement')) {
    function cmplz_accepted_processing_agreement()
    {
        $statistics = cmplz_get_value('compile_statistics', false, 'wizard');
        $tagmanager = ($statistics === 'google-tag-manager') ? true : false;
        $google_analytics = ($statistics === 'google-analytics') ? true : false;

        if ($google_analytics || $tagmanager) {
            $thirdparty = $google_analytics ? cmplz_get_value('compile_statistics_more_info', false, 'wizard') : cmplz_get_value('compile_statistics_more_info_tag_manager', false, 'wizard');
            $accepted_google_data_processing_agreement = (isset($thirdparty['accepted']) && ($thirdparty['accepted'] == 1)) ? true : false;
            if ($accepted_google_data_processing_agreement) {
                return true;
            } else {
                return false;
            }
        }

        //only applies to google
        return false;
    }
}

if (!function_exists('cmplz_init_cookie_blocker')) {
    function cmplz_init_cookie_blocker()
    {

        if (!cmplz_third_party_cookies_active() && !cmplz_cookie_warning_required_stats()) return;

        //don't fire on the back-end
        if (wp_doing_ajax() || is_admin() || is_preview() || cmplz_is_pagebuilder_preview()) return;

        if (defined('CMPLZ_DO_NOT_BLOCK') && CMPLZ_DO_NOT_BLOCK) return;

        if (cmplz_get_value('disable_cookie_block')) return;

        /* Do not block when visitors are from outside EU or US, if geoip is enabled */
        //check cache, as otherwise all users would get the same output, while this is user specific
        //@todo better check for any caching plugin, as this check does not work with wp rocket for example.
        //if (!defined('wp_cache') && class_exists('cmplz_geoip') && COMPLIANZ()->geoip->geoip_enabled() && (COMPLIANZ()->geoip->region() !== 'eu') && (COMPLIANZ()->geoip->region() !== 'us')) return;

        /* Do not block if the cookie policy is already accepted */
        //check cache, as otherwise all users would get the same output, while this is user specific
        //removed: this might cause issues when cached, but not in wp

        //do not block cookies during the scan
        if (isset($_GET['complianz_scan_token']) && (sanitize_title($_GET['complianz_scan_token']) == get_option('complianz_scan_token'))) return;

        /* Do not fix mixed content when call is coming from wp_api or from xmlrpc or feed */
        if (defined('JSON_REQUEST') && JSON_REQUEST) return;
        if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) return;

        add_action("template_redirect", array(COMPLIANZ()->cookie_blocker, "start_buffer"));
        add_action("shutdown", array(COMPLIANZ()->cookie_blocker, "end_buffer"), 999);
    }
}

/**
 *
 * Check if we are currently in preview mode from one of the known page builders
 *
 * @return bool
 * @since 2.0.7
 *
 */
if (!function_exists('cmplz_is_pagebuilder_preview')) {
    function cmplz_is_pagebuilder_preview()
    {
        if (isset($_GET['fb-edit']) || isset($_GET['et_pb_preview']) || isset($_GET['et_fb']) || isset($_GET['elementor-preview']) || isset($_GET['fl_builder'])) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * By default, the region which is returned is the region as selected in the wizard settings.
 *
 * */

if (!function_exists('cmplz_ajax_user_settings')) {
    function cmplz_ajax_user_settings()
    {
        $data = apply_filters('cmplz_user_data', array());
        $data['consenttype'] = apply_filters('cmplz_user_consenttype', COMPLIANZ()->company->get_default_consenttype());
        $data['version'] = cmplz_version;
        $banner_id = cmplz_get_default_banner_id();
        $banner = new CMPLZ_COOKIEBANNER($banner_id);
        $data['banner_version'] = $banner->banner_version;
        $response = json_encode($data);
        header("Content-Type: application/json");
        echo $response;
        exit;
    }
}

if (!function_exists('cmplz_geoip_enabled')){
    function cmplz_geoip_enabled(){
        return apply_filters('cmplz_geoip_enabled', false);
    }
}

/*
 *
 * Track the status selected by the user, for statistics.
 *
 *
 * */

add_action('wp_ajax_nopriv_cmplz_track_status', 'cmplz_ajax_track_status');
add_action('wp_ajax_cmplz_track_status', 'cmplz_ajax_track_status');
if (!function_exists('cmplz_ajax_track_status')) {
    function cmplz_ajax_track_status()
    {
        do_action('cmplz_track_status');

        $response = json_encode(array(
            'success' => true,
        ));
        header("Content-Type: application/json");
        echo $response;
        exit;
    }
}

/*
 * Get string of supported laws
 *
 * */

if (!function_exists('cmplz_supported_laws')) {

    function cmplz_supported_laws()
    {
        $regions = cmplz_get_regions();

        $arr = array();
        foreach ($regions as $region => $enabled) {
            //fallback
            if (!isset(COMPLIANZ()->config->regions[$region]['law'])) {
                break;
            }

            $arr[] = COMPLIANZ()->config->regions[$region]['law'];
        }

        if (count($arr) == 0) return __('(select a region)', 'complianz-gdpr');
        return implode('/', $arr);
    }
}

if (!function_exists('cmplz_get_option')) {
    function cmplz_get_option($name)
    {
        return get_option($name);
    }
}

if (!function_exists('cmplz_esc_html')) {
    function cmplz_esc_html($html)
    {
        return esc_html($html);
    }
}

if (!function_exists('cmplz_esc_url_raw')) {
    function cmplz_esc_url_raw($url)
    {
        return esc_url_raw($url);
    }
}

if (!function_exists('cmplz_is_admin')) {

    function cmplz_is_admin()
    {
        return is_admin();
    }
}

register_activation_hook(__FILE__, 'cmplz_set_activation_time_stamp');
if (!function_exists('cmplz_set_activation_time_stamp')) {
    function cmplz_set_activation_time_stamp($networkwide)
    {
        update_option('cmplz_activation_time', time());
    }
}


/*
 * For all legal documents for the US, privacy statement, dataleaks or processing agreements, the language should always be en_US
 *
 * */
add_filter('locale', 'cmplz_set_plugin_language', 9, 1);
if (!function_exists('cmplz_set_plugin_language')) {
    function cmplz_set_plugin_language($locale)
    {
        $post_id = false;
        if (isset($_GET['post'])) $post_id = $_GET['post'];
        if (isset($_GET['post_id'])) $post_id = $_GET['post_id'];
        $region = (isset($_GET['region'])) ? $_GET['region'] : false;

        if ($post_id && $region) {
            $post_type = get_post_type($post_id);

            if ($region === 'us' && ($post_type === 'cmplz-dataleak' || $post_type === 'cmplz-processing')) {
                $locale = 'en_US';
            }
        }

        $cmplz_lang = isset($_GET['clang']) ? $_GET['clang'] : false;
        if ($cmplz_lang == 'en') {
            $locale = 'en_US';
        }

        return $locale;
    }
}

/*
 *
 * To make sure the US documents are loaded entirely in English on the front-end,
 * We check if the locale is a not en- locale, and if so, redirect with a query arg.
 * This allows us to recognize the page on the next page load is needing a force US language.
 *
 *
 * */

add_action('wp', 'cmplz_add_query_arg');
if (!function_exists('cmplz_add_query_arg')) {
    function cmplz_add_query_arg()
    {
        $cmplz_lang = isset($_GET['clang']) ? $_GET['clang'] : false;
        if (!$cmplz_lang) {
            global $wp;
            $type = false;

            $post = get_queried_object();
            $locale = get_locale();

            //if the locale is english, don't add any query args.
            if (strpos($locale, 'en') !== false) return;

            if ($post && property_exists($post, 'post_content')) {
                $pattern = '/cmplz-document type="(.*?)"/i';
                $pattern_gutenberg = '/<!-- wp:complianz\/document {"title":".*?","selectedDocument":"(.*?)"} \/-->/i';
                if (preg_match_all($pattern, $post->post_content, $matches, PREG_PATTERN_ORDER)) {
                    if (isset($matches[1][0])) $type = $matches[1][0];
                } elseif(preg_match_all($pattern_gutenberg, $post->post_content, $matches, PREG_PATTERN_ORDER)) {
                    if (isset($matches[1][0])) $type = $matches[1][0];
                }

                if (strpos($type, '-us') !== FALSE) {
                    //remove lang property, add our own.
                    wp_redirect(home_url(add_query_arg('clang', 'en', remove_query_arg('lang', $wp->request))));
                    exit;
                }
            }

        }
    }
}

if (!function_exists('cmplz_array_filter_multidimensional')) {
    function cmplz_array_filter_multidimensional($array, $filter_key, $filter_value)
    {
        $new = array_filter($array, function ($var) use ($filter_value, $filter_key) {
            return isset($var[$filter_key]) ? ($var[$filter_key] == $filter_value) : false;
        });

        return $new;
    }
}

if (!function_exists('cmplz_allowed_html')) {
    function cmplz_allowed_html()
    {

        $allowed_tags = array(
            'a' => array(
                'class' => array(),
                'href' => array(),
                'rel' => array(),
                'title' => array(),
                'target' => array(),
            ),
            'button' => array(
                'class' => array(),
                'href' => array(),
                'rel' => array(),
                'title' => array(),
                'target' => array(),
            ),
            'b' => array(),
            'br' => array(),
            'blockquote' => array(
                'cite' => array(),
            ),
            'div' => array(
                'class' => array(),
                'id' => array(),
            ),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'h6' => array(),
            'i' => array(),
            'input' => array(
                'type' => array(),
                'class' => array(),
                'id' => array(),
                'required' => array(),
                'value' => array(),
                'placeholder' => array(),
            ),
            'img' => array(
                'alt' => array(),
                'class' => array(),
                'height' => array(),
                'src' => array(),
                'width' => array(),
            ),
            'label' => array(),
            'li' => array(
                'class' => array(),
                'id' => array(),
            ),
            'ol' => array(
                'class' => array(),
                'id' => array(),
            ),
            'p' => array(
                'class' => array(),
                'id' => array(),
            ),
            'span' => array(
                'class' => array(),
                'title' => array(),
                'id' => array(),
            ),
            'strong' => array(),
            'table' => array(
                'class' => array(),
                'id' => array(),
            ),
            'tr' => array(),
            'style' => array(),
            'td' => array('colspan' => array()),
            'ul' => array(
                'class' => array(),
                'id' => array(),
            ),
        );

        return apply_filters("cmplz_allowed_html", $allowed_tags);
    }
}


if (!function_exists('cmplz_placeholder')) {
    /**
     * Get placeholder for any type of blocked content
     *
     * @param string $type
     * @param string $src
     * @return string url
     *
     * @since 2.1.0
     */
    function cmplz_placeholder($type = false, $src = '')
    {
        //@todo: remove this part, as the next check should make this redundant
        if (!$type) {
            if (strpos($src, 'youtube') !== FALSE) $type = 'youtube';
            if (strpos($src, 'facebook') !== FALSE) $type = 'facebook';
            if (strpos($src, 'vimeo') !== FALSE) $type = 'vimeo';
            if (strpos($src, 'dailymotion') !== FALSE) $type = 'dailymotion';
            if (strpos($src, 'maps.googleapis') !== FALSE) $type = 'googlemaps';
        }

        if (!$type) {
            $type = COMPLIANZ()->cookie->parse_for_social_media($src, true);
            if (!$type) {
                $type = COMPLIANZ()->cookie->parse_for_thirdparty_services($src, true);
            }
        }

        switch ($type) {
            case 'googlemaps':
                $key_pattern = '/key=(.*?)&/i';
                if (preg_match($key_pattern, $src, $matches)) {
                    $id = $matches[1];
                    $new_src = get_transient('cmplz_googlemaps_image_'.sanitize_title($id));
                    if (!$new_src || !file_exists($new_src)){
                        $new_src = cmplz_download_to_site(html_entity_decode($src), sanitize_title($id), false);
                        set_transient('cmplz_googlemaps_image_'.sanitize_title($id), $new_src, MONTH_IN_SECONDS);
                    }
                }
                break;
            case 'youtube':
                $youtube_pattern = '/.*(?:youtu.be\/|v\/|u\/\w\/|embed\/videoseries\?list=RD|embed\/|watch\?v=)([^#\&\?]*).*/i';
                if (preg_match($youtube_pattern, $src, $matches)) {
                    $youtube_id = $matches[1];
                    /*
                     * The highest resolution of youtube thumbnail is the maxres, but it does not
                     * always exist. In that case, we take the hq thumb
                     * To lower the number of file exists checks, we cache the result.
                     *
                     * */
                    $new_src = get_transient("cmplz_youtube_image_$youtube_id");
                    if (!$new_src || !file_exists($new_src)) {
                        $new_src = "https://img.youtube.com/vi/$youtube_id/maxresdefault.jpg";
                        if (!cmplz_remote_file_exists($new_src)) {
                            $new_src = "https://img.youtube.com/vi/$youtube_id/hqdefault.jpg";
                        }
                        $new_src = cmplz_download_to_site($new_src, $type.$youtube_id);

                        set_transient("cmplz_youtube_image_$youtube_id", $new_src, WEEK_IN_SECONDS);
                    }
                }
                break;
            case 'vimeo':
                $vimeo_pattern = '/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?/i';
                if (preg_match($vimeo_pattern, $src, $matches)) {
                    $vimeo_id = $matches[1];
                    $new_src = get_transient("cmplz_vimeo_image_$vimeo_id");
                    if (!$new_src || !file_exists($new_src)) {
                        $vimeo_images = simplexml_load_string(file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.xml"));
                        $new_src = $vimeo_images->video->thumbnail_large;
                        $new_src = cmplz_download_to_site($new_src, $type.$vimeo_id);
                        set_transient("cmplz_vimeo_image_$vimeo_id", $new_src, WEEK_IN_SECONDS);
                    }
                }
                break;
            case 'dailymotion':
                if (preg_match('/dailymotion\.com\/(embed\/video)\/([^_]+)[^#]*\?|dailymotion\.com\/(embed\/video|video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly\/([^_]+))!/i', $src, $matches)) {
                    if (isset($matches[6])) {
                        $daily_motion_id = $matches[6];
                    }elseif (isset($matches[4])) {
                        $daily_motion_id = $matches[4];
                    }else{
                        $daily_motion_id = $matches[2];
                    }
                    $new_src = get_transient("cmplz_dailymotion_image_$daily_motion_id");
                    if (!$new_src || !file_exists($new_src)) {
                        $thumbnail_large_url='https://api.dailymotion.com/video/'.$daily_motion_id.'?fields=thumbnail_1080_url'; //pass thumbnail_large_url, thumbnail_medium_url, thumbnail_small_url for different sizes
                        $json_thumbnail = file_get_contents($thumbnail_large_url);
                        $arr_dailymotion = json_decode($json_thumbnail, TRUE);
                        $new_src = $arr_dailymotion['thumbnail_1080_url'];
                        $new_src = cmplz_download_to_site($new_src, $type.$daily_motion_id);
                        set_transient("cmplz_dailymotion_image_$daily_motion_id", $new_src, WEEK_IN_SECONDS);
                    }
                }
                break;
            case 'facebook':
            case 'twitter':
            case 'iframe':
            case 'image':
            case 'div':
            default:
                $new_src = cmplz_default_placeholder($type);
        }

        return apply_filters('cmplz_placeholder', $new_src, $type, $src);
    }
}

if (!function_exists('cmplz_count_socialmedia')){
    /**
     * count the number of social media used on the site
     * @return int
     */
    function cmplz_count_socialmedia(){
        $sm = cmplz_get_value('socialmedia_on_site',false,'wizard');
        if (!$sm) return 0;
        if (!is_array($sm)) {
            return 1;
        } else {
            return count($sm);
        }
    }
}

if (!function_exists('cmplz_download_to_site')){
    /**
     * Download a placeholder from youtube or video to this website
     * @param string $src
     * @param bool|string $id
     * @param bool $use_filename //some filenames are too long to use.
     * @return string url
     *
     *
     * @since 2.1.5
     */
    function cmplz_download_to_site($src, $id=false, $use_filename=true){
        if (strpos($src, "https://")===FALSE && strpos($src, "http://")===FALSE){
            $src = str_replace('//', 'https://', $src);
        }
        if (!$id) $id = time();

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploads = wp_upload_dir();
        $upload_dir = $uploads['basedir'];

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir);
        }

        if (!file_exists($upload_dir . "/complianz")) {
            mkdir($upload_dir . "/complianz");
        }

        if (!file_exists($upload_dir . "/complianz/placeholders")) {
            mkdir($upload_dir . "/complianz/placeholders");
        }

        //set the path
        $filename = $use_filename ? "-".basename($src) : '.jpg';
        $file = $upload_dir . "/complianz/placeholders/".$id.$filename;

        //set the url
        $new_src = $uploads['baseurl'] . "/complianz/placeholders/".$id.$filename;

        //download file
        $tmpfile = download_url($src, $timeout = 25);

        //check for errors
        if (is_wp_error($tmpfile)){
            $new_src = cmplz_default_placeholder();
        } else {
            //remove current file
            if (file_exists($file)) unlink($file);

            //in case the server prevents deletion, we check it again.
            if (!file_exists($file)) copy($tmpfile, $file);
        }

        if (is_string($tmpfile) && file_exists($tmpfile)) unlink($tmpfile); // must unlink afterwards

        if (!file_exists($file)) return cmplz_default_placeholder();

        return $new_src;
    }
}



if (!function_exists('cmplz_default_placeholder')){
    /**
     * Return the default placeholder image
     * @return string placeholder
     * @since 2.1.5
     */
    function cmplz_default_placeholder($type = ''){

        $img = "placeholder.jpg";

        //check if this type exists as placeholder
        if (!empty($type) && file_exists(cmplz_path . "core/assets/images/placeholder-$type.jpg")){
            $img = "placeholder-$type.jpg";
        }

        $img_url = cmplz_url . 'core/assets/images/' . $img;

        //check for image in themedir/complianz-gpdr-premium
        $theme_img = trailingslashit(get_stylesheet_directory()) . dirname(cmplz_path) . $img;
        if (file_exists($theme_img)) {
            $img_url = trailingslashit(get_stylesheet_directory_uri()) . dirname(cmplz_path) . $img;
        }

        return apply_filters('cmplz_default_placeholder', $img_url);
    }
}


if (!function_exists('cmplz_us_cookie_statement_title')) {
    /**
     * US Cookie policy can have two different titles depending on the Californian targeting
     * @return string $title
     * @since 2.0.6
     */

    function cmplz_us_cookie_statement_title($california = false)
    {
        if (!$california) $california = cmplz_get_value('california');
        if ($california === 'yes') {
            $title = "Do Not Sell My Personal Information";
        } else {
            $title = "Cookie Statement (US)";
        }

        return apply_filters('cmplz_us_cookie_statement_title', $title);
    }
}

if (!function_exists('cmplz_get_cookie_policy_url')){

    /**
     * Get url to cookie policy
     * @param string $region
     * @return string URL
     */
    function cmplz_get_cookie_policy_url($region='eu')
    {
        if (cmplz_get_value('cookie-policy-type') === 'custom') {
            return strlen(cmplz_get_value('custom-cookie-policy-url')) == 0 ? '#' : esc_url_raw(cmplz_get_value('custom-cookie-policy-url'));
        } else {
            return COMPLIANZ()->document->get_page_url('cookie-statement', $region);
        }
    }
}


if (!function_exists('cmplz_update_cookie_policy_title')) {
    /**
     * Adjust the cookie policy title according to the california setting
     * @param string $fieldvalue
     * $return void
     */
    function cmplz_update_cookie_policy_title($fieldvalue)
    {
        //get page id of US cookie policy
        $page_id = COMPLIANZ()->document->get_shortcode_page_id('cookie-statement-us');
        $title = cmplz_us_cookie_statement_title($fieldvalue);
        $post = array(
            'ID' => intval($page_id),
            'post_title' => $title,
            'post_name' => sanitize_title($title),
        );
        wp_update_post($post);

        cmplz_update_option('cookie_settings', 'readmore_us', $title);
    }
}

if (!function_exists('cmplz_targets_california')) {
    function cmplz_targets_california()
    {
        return cmplz_get_value('california') === 'yes';
    }
}

if (!function_exists('cmplz_has_async_documentwrite_scripts')) {
    function cmplz_has_async_documentwrite_scripts()
    {
        $social_media = cmplz_get_value('socialmedia_on_site');
        if (isset($social_media['instagram']) && $social_media['instagram'] == 1) return true;

        return false;
    }
}

if (!function_exists('cmplz_remote_file_exists')) {
    function cmplz_remote_file_exists($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if ($result !== FALSE) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('cmplz_uses_gutenberg')) {
    function cmplz_uses_gutenberg()
    {

        if (function_exists('has_block') && !class_exists('Classic_Editor')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_regions_for_consent_type')) {
    /**
     * Get comma separated list of regions, which are using this consent type
     * @param string $type
     * @return string
     */
    function get_regions_for_consent_type($consenttype){
        $regions = array();
        foreach (COMPLIANZ()->config->regions as $region_id => $region){
            if ($region['type']===$consenttype) return $regions[] = $region['label'];
        }
        return implode(', ', $regions);
    }
}

if (!function_exists('cmplz_get_used_consenttypes')) {
    /**
     * Get list of consenttypes in use on this site, based on the selected regions
     * @return array consenttypes
     */
    function cmplz_get_used_consenttypes(){
        //get all regions in use on this site
        $regions = cmplz_get_regions();
        $consent_types = array();
        //for each region, get the consenttype
        foreach ($regions as $region => $label){
            $consent_types[] = COMPLIANZ()->config->regions[$region]['type'];
        }


        //remove duplicates
        $consent_types = array_unique($consent_types);

        return $consent_types;

    }
}

if (!function_exists('cmplz_uses_optin')){
    function cmplz_uses_optin(){
        return (in_array('optin', cmplz_get_used_consenttypes()));
    }
}

if (!function_exists('cmplz_uses_optout')){
    function cmplz_uses_optout(){
        return (in_array('optout', cmplz_get_used_consenttypes()));
    }
}

if (!function_exists('cmplz_ab_testing_enabled')){
    function cmplz_ab_testing_enabled(){
        return COMPLIANZ()->cookie->ab_testing_enabled();
    }
}


if (!function_exists('cmplz_consenttype_nicename')) {
    /**
     * Get nice name for consenttype
     * @param string $consenttype
     * @return string nicename
     */
    function cmplz_consenttype_nicename($consenttype){
        switch ($consenttype) {
            case 'optin':
                return __('Opt in settings','complianz-gdpr');
            case 'optout':
                return __('Opt out settings', 'complianz-gdp');
            default :
                return __('All consent types', 'complianz-gdpr');
        }

    }
}



if (!function_exists('cmplz_get_consenttype_for_region')) {
    /**
     * Get the consenttype which is used in this region
     * @param string $region
     * @return string consenttype
     */
    function cmplz_get_consenttype_for_region($region)
    {
        //fallback
        if (!isset(COMPLIANZ()->config->regions[$region]['type'])) {
            return 'optin';
        }

        return COMPLIANZ()->config->regions[$region]['type'];
    }
}
if (!function_exists('cmplz_get_default_banner_id')) {

    /**
     * Get the default banner ID
     * @return int default_ID
     */
    function cmplz_get_default_banner_id()
    {
        global $wpdb;
        $cookiebanners = $wpdb->get_results("select * from {$wpdb->prefix}cmplz_cookiebanners as cb where cb.default = true");

        //if nothing, try the first entry
        if (empty($cookiebanners)) {
            $cookiebanners = $wpdb->get_results("select * from {$wpdb->prefix}cmplz_cookiebanners");
        }

        if (!empty($cookiebanners)) {
            return $cookiebanners[0]->ID;
        }

        return false;
        //nothing yet, return false
    }
}

if (!function_exists('cmplz_user_can_manage')){
    function cmplz_user_can_manage(){
        if (!is_user_logged_in()) return false;
        if (cmplz_wp_privacy_version() && !current_user_can('manage_privacy_options')) return false;
        if (!current_user_can('manage_options')) return false;

        return true;
    }
}
if (!function_exists('cmplz_get_cookiebanners')) {

    /**
     * Get array of banner objects
     * @param array $args
     * @return array
     */

    function cmplz_get_cookiebanners($args = array())
    {
        $args = wp_parse_args($args, array('status' => 'active'));
        $sql = '';
        global $wpdb;
        if ($args['status'] === 'archived'){
            $sql = 'AND cdb.archived = true';
        }
        if ($args['status'] === 'active'){
            $sql = 'AND cdb.archived = false';
        }

        if (isset($args['default']) && $args['default']==TRUE){
            $sql = 'AND cdb.default = true LIMIT 1';
        }
        if (isset($args['default']) && $args['default']===FALSE){
            $sql = 'AND cdb.default = false';
        }
        $cookiebanners = $wpdb->get_results("select * from {$wpdb->prefix}cmplz_cookiebanners as cdb where 1=1 $sql");


        return $cookiebanners;
    }
}