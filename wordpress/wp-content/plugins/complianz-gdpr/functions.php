<?php
defined('ABSPATH') or die("you do not have acces to this page!");

if (!function_exists('cmplz_uses_google_analytics')) {
    function cmplz_uses_google_analytics()
    {
        return COMPLIANZ()->cookie_admin->uses_google_analytics();
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
            //$fields['use_categories']['disabled'] = true;
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
        if ($stats === 'matomo' && cmplz_no_ip_addresses()) {
            return true;
        }

        //Google Tag Manager should also be possible to embed yourself if you haven't integrated it anonymously
        if ($stats === 'google-tag-manager') {
            return true;
        }

        if ($stats === 'google-analytics') {
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
	    $html = "";
        //if (!cmplz_is_amp()){
	        $text = apply_filters('cmplz_revoke_button_text', $text);
	        $css = '<style>.cmplz-status-accepted,.cmplz-status-denied {display: none;}</style>';
	        $html = $css.'<button class="cc-revoke-custom">' . $text . '</button>&nbsp;<span class="cmplz-status-accepted">' . sprintf(__('Current status: %s', 'complianz-gdpr'), __("Accepted", 'complianz-gdpr')) . '</span><span class="cmplz-status-denied">' . sprintf(__('Current status: %s', 'complianz-gdpr'), __("Denied", 'complianz-gdpr')) . '</span>';
        //}
        
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

    function cmplz_get_value($fieldname, $post_id = false, $page = false, $use_default=true)
    {
        if (!$page && !isset(COMPLIANZ()->config->fields[$fieldname])) return false;

        //if  a post id is passed we retrieve the data from the post
        if (!$page) $page = COMPLIANZ()->config->fields[$fieldname]['source'];
        if ($post_id && ($page !== 'wizard')) {
            $value = get_post_meta($post_id, $fieldname, true);
        } else {
            $fields = get_option('complianz_options_' . $page);

            $default = ($use_default && $page && isset(COMPLIANZ()->config->fields[$fieldname]['default'])) ? COMPLIANZ()->config->fields[$fieldname]['default'] : '';
            $value = isset($fields[$fieldname]) ? $fields[$fieldname] : $default;

        }

        /*
         * Translate output
         *
         * */

        $type = isset(COMPLIANZ()->config->fields[$fieldname]['type']) ? COMPLIANZ()->config->fields[$fieldname]['type'] : false;
        if ($type === 'cookies' || $type === 'thirdparties' || $type === 'processors') {
            if (is_array($value)) {

                //this is for example a cookie array, like ($item = cookie("name"=>"_ga")

                foreach ($value as $item_key => $item) {
                    //contains the values of an item
                    foreach ($item as $key => $key_value) {
                        if (function_exists('pll__')) $value[$item_key][$key] = pll__($item_key.'_'.$fieldname . "_" . $key);
                        if (function_exists('icl_translate')) $value[$item_key][$key] = icl_translate('complianz', $item_key.'_'.$fieldname . "_" . $key, $key_value);

                        $value[$item_key][$key] = apply_filters( 'wpml_translate_single_string',  $key_value, 'complianz', $item_key.'_'.$fieldname . "_" . $key );
                    }
                }
            }
        } else {
            if (isset(COMPLIANZ()->config->fields[$fieldname]['translatable']) && COMPLIANZ()->config->fields[$fieldname]['translatable']) {
                if (function_exists('pll__')) {
                    $value = pll__($value);
                }
                if (function_exists('icl_translate')) $value = icl_translate('complianz', $fieldname, $value);

                $value = apply_filters( 'wpml_translate_single_string',  $value, 'complianz', $fieldname );
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
        return COMPLIANZ()->cookie_admin->site_needs_cookie_warning('eu');
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

if (!function_exists('cmplz_company_located_in_region')) {

    function cmplz_company_located_in_region($region)
    {
        $country_code = cmplz_get_value('country_company');
        return (cmplz_get_region_for_country($country_code) === $region);
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
        if (isset($regions[$code])) {
            return true;
        }

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


if (!function_exists('cmplz_get_consenttype_for_country')) {

	function cmplz_get_consenttype_for_country($country_code)
	{
		$regions = COMPLIANZ()->config->regions;
		foreach ($regions as $region_code => $region) {
			if (in_array($country_code, $region['countries'])) return $region['type'];
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

    function cmplz_panel($title, $html, $custom_btn = '', $validate = '', $echo =true)
    {
        if ($title == '') return '';

        $slide = ($html == '') ? false : true;

        $output = '
        <div class="cmplz-panel cmplz-slide-panel cmplz-toggle-active">
            <div class="cmplz-panel-title">

                <span class="cmplz-panel-toggle">
                    <i class="toggle fa fa-caret-right"></i>
                    <span class="cmplz-title">'.$title.'</span>
                 </span>


                '.$validate .'
                <span>'.$custom_btn .'</span>
            </div>
            <div class="cmplz-panel-content">
                '. $html .'
            </div>
        </div>';

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }

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
        $social_media = get_option('cmplz_detected_social_media', array());
        if (!is_array($social_media)) $social_media = array($social_media);
        $social_media = array_filter($social_media);

        $social_media = apply_filters('cmplz_detected_social_media', $social_media);

        //nothing scanned yet, or nothing found
        if (!$social_media || (count($social_media) == 0)) $social_media = false;

        return $social_media;
    }
}

if (!function_exists('cmplz_scan_detected_thirdparty_services')) {

    function cmplz_scan_detected_thirdparty_services()
    {
        $thirdparty = get_option('cmplz_detected_thirdparty_services', array());
        if (!is_array($thirdparty)) $thirdparty = array($thirdparty);
        $thirdparty = array_filter($thirdparty);
        $thirdparty = apply_filters('c', $thirdparty);

        //nothing scanned yet, or nothing found
        if (!$thirdparty || (count($thirdparty) == 0)) $thirdparty = false;

        return $thirdparty;
    }
}


if (!function_exists('cmplz_scan_detected_stats')) {

    function cmplz_scan_detected_stats()
    {
        $stats = get_option('cmplz_detected_stats', array());
        if (!is_array($stats)) $stats = array($stats);
        $stats = array_filter($stats);
        //nothing scanned yet, or nothing found
        if (!$stats || (count($stats) == 0)) $stats = false;

        $stats = apply_filters('cmplz_detected_stats', $stats);

        return $stats;
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
        return COMPLIANZ()->cookie_admin->uses_only_functional_cookies();
    }
}

if (!function_exists('cmplz_third_party_cookies_active')) {

    function cmplz_third_party_cookies_active()
    {
        return COMPLIANZ()->cookie_admin->third_party_cookies_active();
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

        return false;
    }
}

if (!function_exists('cmplz_cookie_warning_required_stats')) {
    function cmplz_cookie_warning_required_stats()
    {
        return COMPLIANZ()->cookie_admin->cookie_warning_required_stats();
    }
}

if (!function_exists('cmplz_consent_anonymous_stats_question')) {

    function cmplz_consent_anonymous_stats_question()
    {
        if (!cmplz_has_region('eu')) return false;

        $uses_google = COMPLIANZ()->cookie_admin->uses_google_analytics() || COMPLIANZ()->cookie_admin->uses_google_tagmanager();
        return $uses_google && (cmplz_get_value('eu_consent_regions') === 'yes') && COMPLIANZ()->cookie_admin->statistics_privacy_friendly();
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
        $preview = false;
        global $wp_customize;
        if (isset( $wp_customize ) || isset($_GET['fb-edit']) || isset($_GET['et_pb_preview']) || isset($_GET['et_fb']) || isset($_GET['elementor-preview']) || isset($_GET['fl_builder']) || isset($_GET['tve'])) {
            $preview = true;
        }

        return apply_filters('cmplz_is_preview', $preview);
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
        $data['region'] = apply_filters('cmplz_user_region', COMPLIANZ()->company->get_default_region());
        $data['version'] = cmplz_version;
        $data['forceEnableStats'] = apply_filters('cmplz_user_force_enable_stats', false);

        //We need this here because the integrations are not loaded yet, so the filter will return empty, overwriting the loaded data.
        //@todo: move this to the inline script  generation
        //and move all generic, not banner specific data away from the banner.
        unset($data["set_cookies"]);
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
add_filter('locale', 'cmplz_set_plugin_language', 19, 1);
if (!function_exists('cmplz_set_plugin_language')) {
    function cmplz_set_plugin_language($locale)
    {
        $post_id = false;
        if (isset($_GET['post'])) $post_id = $_GET['post'];
        if (isset($_GET['post_id'])) $post_id = $_GET['post_id'];
        $region = (isset($_GET['region'])) ? $_GET['region'] : false;

        if ($post_id && $region) {
            $post_type = get_post_type($post_id);

            if (($region === 'us'|| $region === 'uk') && ($post_type === 'cmplz-dataleak' || $post_type === 'cmplz-processing')) {
                $locale = 'en_US';
            }
        }
        if (isset($_GET['clang']) && $_GET['clang'] === 'en') {
            $locale = 'en_US';

        }
        return $locale;
    }
}

/**
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
        if (!$cmplz_lang && !cmplz_is_pagebuilder_preview()) {
            global $wp;
            $type = false;

            $post = get_queried_object();
            $locale = get_locale();

            //if the locale is english, don't add any query args.
            if (strpos($locale, 'en') !== false) return;

            if ($post && property_exists($post, 'post_content')) {
                $pattern = '/cmplz-document type="(.*?)"/i';
	            $pattern_gutenberg = '/<!-- wp:complianz\/document {.*?selectedDocument":"(.*?)"} \/-->/i';
                if (preg_match_all($pattern, $post->post_content, $matches, PREG_PATTERN_ORDER)) {
                    if (isset($matches[1][0])) $type = $matches[1][0];
                } elseif(preg_match_all($pattern_gutenberg, $post->post_content, $matches, PREG_PATTERN_ORDER)) {
                    if (isset($matches[1][0])) $type = $matches[1][0];
                }

                if (strpos($type, '-us') !== FALSE || strpos($type, '-uk') !== FALSE) {
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

if (!function_exists('cmplz_is_amp')){
    /**
     * Check if we're on AMP
     * @return bool
     */
    function cmplz_is_amp(){

	    $amp_on = false;
        if (function_exists('ampforwp_is_amp_endpoint') ) {
            $amp_on = ampforwp_is_amp_endpoint();
        }
        
        if ( function_exists('is_amp_endpoint')) {
	        $amp_on = is_amp_endpoint();
        }

        if ($amp_on){
	        $amp_on = cmplz_amp_integration_active();
        }

	    return $amp_on;
    }
}

if (!function_exists('cmplz_amp_integration_active')){
    /**
     * Check if AMP integration is active
     * @return bool
     */
    function cmplz_amp_integration_active(){
	    return cmplz_is_integration_enabled('amp');
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
     * @param bool|string $type
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
            if (strpos($src, 'maps.googleapis') !== FALSE) $type = 'google-maps';
            if (strpos($src, 'openstreetmaps.org') !== FALSE) $type = 'openstreetmaps';
        }

        if (!$type) {
            $type = COMPLIANZ()->cookie_admin->parse_for_social_media($src, true);
            if (!$type) {
                $type = COMPLIANZ()->cookie_admin->parse_for_thirdparty_services($src, true);
            }
        }

        $new_src = cmplz_default_placeholder($type);

        $new_src = apply_filters("cmplz_placeholder_$type", $new_src, $src);

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
        if (!$sm) {
            return 0;
        }
        if (!is_array($sm)) {
            return 1;
        } else {
            return count(array_filter($sm));
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

if (!function_exists('cmplz_used_cookies')){
    function cmplz_used_cookies(){
        $services_template = cmplz_get_template('cookiepolicy_services.php');

        $cookies_row = cmplz_get_template('cookiepolicy_cookies_row.php');
        $purpose_row = cmplz_get_template('cookiepolicy_purpose_row.php');

        $language = substr(get_locale(),0,2);

        $args = array('language' => $language, 'showOnPolicy' => true, 'hideEmpty'=>true,'ignored' => false);
        if (cmplz_get_value('wp_admin_access_users')==='yes') {
            $args['isMembersOnly'] = 'all';
        }

        $cookies = COMPLIANZ()->cookie_admin->get_cookies_by_service($args);
      
        $servicesHTML = '';
        foreach($cookies as $serviceID => $serviceData){
            $has_empty_cookies = false;

            $service = new CMPLZ_SERVICE($serviceID, substr(get_locale(),0,2));
            $cookieHTML = "";
            foreach($serviceData as $purpose => $service_cookies){
	            $cookieHTML .= str_replace(array('{purpose}'), array($purpose), $purpose_row);

	            foreach ($service_cookies as $cookie){
                    $has_empty_cookies = $has_empty_cookies || strlen($cookie->retention)==0;
		            $link_open = $link_close ='';

		            if (cmplz_get_value('use_cdb_links')==='yes' && strlen($cookie->slug)!==0){
		                $service_slug  = (strlen($service->slug)===0) ? 'unknown-service' : $service->slug;
			            $link_open = '<a target="_blank" rel="nofollow" href="https://cookiedatabase.org/cookie/'.$service_slug.'/'.$cookie->slug.'">';
			            $link_close = '</a>';
		            }
                    $cookieHTML .= str_replace(array('{name}','{retention}', '{cookieFunction}', '{link_open}', '{link_close}'), array($cookie->name,$cookie->retention, ucfirst($cookie->cookieFunction), $link_open, $link_close), $cookies_row);
                }
            }

            $service_name = $service->ID && strlen($service->name)>0 ? $service->name : __('Miscellaneous','complianz-gdpr');

            if ($service->sharesData || $service_name==='Complianz') {
	            $sharing = '';
                if (strlen($service->privacyStatementURL)!=0){
	                $link = '<a target="_blank" href="'.$service->privacyStatementURL.'">';
	                $sharing = sprintf(__('For more information, please read the %s%s Privacy Policy%s.','complianz-gdpr'), $link, $service_name,'</a>');
                }
            } else {
                $sharing = __('This data is not shared with third parties.','complianz-gdpr');
            }
            $purposeDescription = ((strlen($service_name)>0) && (strlen($service->serviceType)>0)) ? sprintf(_x("We use %s for %s.", 'Legal document cookie policy', 'complianz-gdpr'),$service_name, $service->serviceType) : '';

	        if (cmplz_get_value('use_cdb_links')==='yes' && strlen($service->slug)!==0 && $service->slug !== 'unknown-service'){
		        $link_open = '<a target="_blank" rel="nofollow" href="https://cookiedatabase.org/service/'.$service->slug.'">';
		        $link_close = '</a>';
		        $purposeDescription .= ' '.$link_open.__('Read more', "complianz-gdpr").$link_close;
	        }

            $servicesHTML .= str_replace(array('{service}','{sharing}','{purposeDescription}','{cookies}'), array($service_name, $sharing, $purposeDescription, $cookieHTML), $services_template);
        }

        return $servicesHTML;
    }
}


/**
 * Check if this field is translatable
 * @param $fieldname
 * @return bool
 */

if (!function_exists('cmplz_translate')){
    function cmplz_translate($value, $fieldname){
        if (function_exists('pll__')) $value = pll__($value);

        if (function_exists('icl_translate')) $value = icl_translate('complianz', $fieldname, $value);

        $value = apply_filters( 'wpml_translate_single_string',  $value, 'complianz', $fieldname );

        return $value;

    }
}


/**
 * Show a reference to cookiedatabase if user has accepted the API
 * @return bool
 */

if (!function_exists('cmplz_cdb_reference_in_policy')){
	function cmplz_cdb_reference_in_policy(){
		if (cmplz_get_value('uses_cookies')==='no') {
			$use_reference = false;
        } else {
			$use_reference = COMPLIANZ()->cookie_admin->use_cdb_api();
		}
	    return apply_filters('cmplz_use_cdb_reference', $use_reference);
	}
}

/**
 * Registrer a translation
 * @param $fieldname
 * @return bool
 */

if (!function_exists('cmplz_register_translation')) {

    function cmplz_register_translation($string, $fieldname)
    {
        //polylang
        if (function_exists("pll_register_string")) {
            pll_register_string($fieldname, $string, 'complianz');
        }

        //wpml
        if (function_exists('icl_register_string')) {
            icl_register_string('complianz', $fieldname, $string);
        }

        do_action('wpml_register_single_string', 'complianz', $fieldname, $string);

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

        return apply_filters('cmplz_default_placeholder', $img_url, $type);
    }
}


if (!function_exists('cmplz_us_cookie_statement_title')) {
    /**
     * US Cookie policy can have two different titles depending on the Californian targeting
     * @return string $title
     * @since 2.0.6
     */

    function cmplz_us_cookie_statement_title()
    {
        $california = cmplz_get_value('california');

        if ($california === 'yes' && COMPLIANZ()->company->sells_personal_data()) {
            $title = "Do Not Sell My Personal Information";
        } else {
            $title = "Cookie Policy (US)";
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
    function cmplz_update_cookie_policy_title()
    {
        //get page id of US cookie policy
        $page_id = COMPLIANZ()->document->get_shortcode_page_id('cookie-statement-us');
        $title = cmplz_us_cookie_statement_title();
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
            if ($region['type']===$consenttype) $regions[] = $region['label'];
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
            if (!isset(COMPLIANZ()->config->regions[$region]['type'])) continue;

            $consent_types[] = COMPLIANZ()->config->regions[$region]['type'];
        }


        //remove duplicates
        $consent_types = array_unique($consent_types);

        return $consent_types;

    }
}

if (!function_exists('cmplz_uses_optin')){

    /**
     * Check if the site uses one of the optin types
     * @return bool
     */
    function cmplz_uses_optin(){
        return (in_array('optin', cmplz_get_used_consenttypes()) || in_array('optinstats', cmplz_get_used_consenttypes()));
    }
}



if (!function_exists('cmplz_uses_optout')){
    function cmplz_uses_optout(){
        return (in_array('optout', cmplz_get_used_consenttypes()));
    }
}

if (!function_exists('cmplz_ab_testing_enabled')){
    function cmplz_ab_testing_enabled(){
        return COMPLIANZ()->cookie_admin->ab_testing_enabled();
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
            case 'optinstats':
                return __('Opt-in (statistics)','complianz-gdpr');
            case 'optin':
                return __('Opt-in','complianz-gdpr');
            case 'optout':
                return __('Opt-out', 'complianz-gdpr');
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

if (!function_exists('cmplz_uses_consenttype')) {
    /**
     * Check if a specific consenttype is used
     * @param string $consenttype
     * @param string $region
     * @return bool $uses_consenttype
     */
    function cmplz_uses_consenttype($check_consenttype, $region=false)
    {
	    if ($region){
		    //get consenttype for region
		    $consenttype = cmplz_get_consenttype_for_region($region);
		    if ($consenttype===$check_consenttype) return true;
	    } else {
		    //check if any region has a consenttype $check_consenttype
		    $regions = cmplz_get_regions(false);
		    foreach ($regions as $region=>$label){
			    $consenttype = cmplz_get_consenttype_for_region($region);
			    if ($consenttype===$check_consenttype) return true;
		    }
	    }
	    return false;
    }
}

if (!function_exists('cmplz_get_document_extension')) {
	/**
	 * Get document extension for a region
	 * @param string $region
	 * @return string $extension
	 */
	function cmplz_get_document_extension($region)
	{
		return isset(COMPLIANZ()->config->regions[$region]['documents']) ? COMPLIANZ()->config->regions[$region]['documents'] : 'eu';
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

if (!function_exists('cmplz_sanitize_language')) {

    /**
     * Validate a language string
     * @param $language
     * @return bool|string
     */

    function cmplz_sanitize_language($language)
    {
        $pattern = '/^[a-zA-Z]{2}$/';
        if (!is_string($language)) return false;
        $language = substr($language, 0, 2);

        if ((bool)preg_match($pattern, $language)) {
            $language =  strtolower($language);
            return $language;
        }

        return false;
    }
}



if (!function_exists('cmplz_sanitize_languages')) {

    /**
     * Validate a languages array
     * @param array $language
     * @return array
     */

    function cmplz_sanitize_languages($languages)
    {
        $output = array();
        foreach ($languages as $language){
            $output[] = cmplz_sanitize_language($language);
        }
        return $output;
    }
}
