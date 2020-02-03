<?php
defined('ABSPATH') or die("you do not have acces to this page!");
require_once('forms.php');

global $cmplz_integrations_list;
$cmplz_integrations_list= apply_filters('cmplz_integrations', array(
    //user registration plugin
    'addtoany' => array(
        'constant_or_function' => 'A2A_SHARE_SAVE_init',
        'label' => 'Add To Any',
    ),
    'amp' => array(
        'constant_or_function' => 'AMP__VERSION',
        'label' => 'AMP (official AMP plugin for WordPress)',
    ),
    'beehive' => array(
	    'constant_or_function' => 'BEEHIVE_PRO',
	    'label' => 'Beehive',
    ),
    'pixelyoursite' => array(
        'constant_or_function' => 'PYS_FREE_VERSION',
        'label' => 'PixelYourSite',
    ),
    'user-registration' => array(
        'constant_or_function' => 'UR',
        'label' => 'User Registration',
    ),
    'contact-form-7' => array(
        'constant_or_function' => 'WPCF7_VERSION',
        'label' => 'Contact Form 7',
    ),

    'facebook-for-wordpress' => array(
        'constant_or_function' => 'FacebookPixelPlugin\\FacebookForWordpress',
        'label' => 'Official Facebook Pixel',
    ),

    'google-tagmanager-for-wordpress' => array(
        'constant_or_function' => 'GTM4WP_VERSION',
        'label' => 'Google Tag Manager for WordPress',
    ),

    'jetpack' => array(
	    'constant_or_function' => 'JETPACK__VERSION',
	    'label' => 'JetPack',
    ),

    'g1-gmaps' => array(
        'constant_or_function' => 'G1_GMaps',
        'label' => 'G1 GMAPS',
    ),

    'monsterinsights' => array(
        'constant_or_function' => 'MonsterInsights',
        'label' => 'MonsterInsights',
    ),

    'mappress' => array(
        'constant_or_function' => 'Mappress',
        'label' => 'MapPress Maps for WordPress',
    ),

    'caos-host-analytics-local' => array(
        'constant_or_function' => 'CAOS_STATIC_VERSION',
        'label' => 'CAOS host analytics locally',

    ),
    'wp-google-maps' => array(
        'constant_or_function' => 'WPGMZA_VERSION',
        'label' => 'WP Google Maps',

    ),

    'geo-my-wp' => array(
        'constant_or_function' => 'GMW_VERSION',
        'label' => 'Geo My WP',
    ),

    'google-analytics-dashboard-for-wp' => array(
        'constant_or_function' => 'GADWP_CURRENT_VERSION',
        'label' => 'Google Analytics Dashboard for WP',
    ),

    'wp-google-maps-widget' => array(
        'constant_or_function' => 'GMW_PLUGIN_DIR',
        'label' => 'Maps Widget for Google Maps',

    ),

    'wp-donottrack' => array(
        'constant_or_function' => 'wp_donottrack_config',
        'label' => 'WP Do Not Track',
    ),

    'pixel-caffeine' => array(
        'constant_or_function' => 'AEPC_PIXEL_VERSION',
        'label' => 'Pixel Caffeine',

    ),


    //Super Socializer
    'super-socializer' => array(
        'constant_or_function' => 'THE_CHAMP_SS_VERSION',
        'label' => 'Super Socializer',

    ),

    //Tidio Live Chat
    'tidio-live-chat' => array(
        'constant_or_function' => 'TIDIOCHAT_VERSION',
        'label' => 'Tidio Live Chat',

    ),
    //Instagram feed / Smash balloon social photo feed
    'instagram-feed' => array(
        'constant_or_function' => 'SBIVER',
        'label' => 'Instagram Feed',
    ),


    //Sumo
    'sumo' => array(
        'constant_or_function' => 'SUMOME__PLUGIN_DIR',
        'label' => 'Sumo – Boost Conversion and Sales',
    ),

    //WP Forms
    'wpforms' => array(
        'constant_or_function' => 'wpforms',
        'label' => 'WP Forms',
    ),

    'wp-rocket' => array(
	    'constant_or_function' => 'WP_ROCKET_VERSION',
	    'label' => 'WP Rocket',
    ),

    'forminator' => array(
        'constant_or_function' => 'FORMINATOR_VERSION',
        'label' => 'Forminator',
        'early_load' => 'forminator-addon-registration.php',
        'callback_condition' => array(
            'regions' => array('eu','uk'),
        ),

    ),

    'happyforms' => array(
        'constant_or_function' => 'HAPPYFORMS_VERSION',
        'label' => 'Happy Forms',
    ),

    'osm' => array(
        'constant_or_function' => 'OSM_PLUGIN_URL',
        'label' => 'OSM - OpenStreetMap',
    ),

    'so-widgets-bundle' => array(
        'constant_or_function' => 'SOW_BUNDLE_VERSION',
        'label' => 'SiteOrigin Widgets Bundle',
    ),


    'gravity-forms' => array(
        'constant_or_function' => 'GF_MIN_WP_VERSION',
        'label' => 'Gravity Forms',
        'callback_condition' => array(
                'privacy-statement' => 'yes',
                'regions' => 'eu',
            ),

        ),
));


require_once('fields.php');

/**
 * Wordpress, include always
 */
require_once('wordpress/wordpress.php');


foreach ($cmplz_integrations_list as $plugin => $details) {

    if (!isset($details['early_load'])) continue;
    if (!file_exists(WP_PLUGIN_DIR."/".$plugin."/".$plugin.".php")) continue;

    $early_load = $details['early_load'];
    $file = apply_filters('cmplz_early_load_path', cmplz_path . "integrations/plugins/$early_load", $details);

    if (file_exists($file)) {
        require_once($file);
    } else {
        error_log("searched for $plugin integration at $file, but did not find it");
    }
}


/**
 * Check if this plugin's integration is enabled
 * @return bool
 */
function cmplz_is_integration_enabled($plugin_name){
	global $cmplz_integrations_list;
	if (!array_key_exists($plugin_name, $cmplz_integrations_list)) return false;
	$fields = get_option('complianz_options_integrations');
	//default enabled, which means it's enabled when not set.
	if (isset($fields[$plugin_name]) && $fields[$plugin_name]!=1 ) return false;

	return true;
}


/**
 * code loaded without privileges to allow integrations between plugins and services, when enabled.
 */

function cmplz_integrations(){

    global $cmplz_integrations_list;

    $fields = get_option('complianz_options_integrations');

    foreach($cmplz_integrations_list as $plugin => $details){
        //because we need a default, we don't use the get_value from complianz. The fields array is not loaded yet, so there are no defaults
        $enabled = isset($fields[$plugin]) ? $fields[$plugin] : true;
        if ((defined($details['constant_or_function']) || function_exists($details['constant_or_function']) || class_exists($details['constant_or_function'])) && $enabled){
            $file = apply_filters('cmplz_integration_path', cmplz_path."integrations/plugins/$plugin.php", $plugin);
            if (file_exists($file)){
                require_once($file);
            } else {
                error_log("searched for $plugin integration at $file, but did not find it");
            }
        }
    }

    /**
     * Services
     */

    $services = COMPLIANZ()->config->thirdparty_service_markers;
    $services = array_keys($services);

    foreach($services as $service){
        if (cmplz_uses_thirdparty($service)){
            if (file_exists(cmplz_path."integrations/services/$service.php")) {
                require_once("services/$service.php");
            }
        }
    }

    $services = COMPLIANZ()->config->social_media_markers;
    $services = array_keys($services);

    foreach($services as $service){
        if (cmplz_uses_thirdparty($service)){
            if (file_exists(cmplz_path."integrations/services/$service.php")) {
                require_once("services/$service.php");
            }
        }
    }

    /**
     * advertising
     */

    if (cmplz_get_value('uses_ad_cookies')){
        require_once('services/advertising.php');
    }

    /**
     * statistics
     */

    $statistics = cmplz_get_value('compile_statistics');
    if ($statistics === 'google-analytics' && !defined('CAOS_STATIC_VERSION')) {
        require_once('statistics/google-analytics.php');
    }elseif ($statistics === 'google-tag-manager') {
        require_once('statistics/google-tagmanager.php');
    }

}
add_action('plugins_loaded', 'cmplz_integrations', 10);


/**
 * Check if a third party is used on this site
 * @param string $name
 * @return bool uses_thirdparty
 */

function cmplz_uses_thirdparty($name){
    $thirdparty = (cmplz_get_value('uses_thirdparty_services') === 'yes') ? true : false;
    if ($thirdparty) {
        $thirdparty_types = cmplz_get_value('thirdparty_services_on_site');
        if (isset($thirdparty_types[$name]) && $thirdparty_types[$name] == 1) {
            return true;
        }
    }

    $social_media = (cmplz_get_value('uses_social_media') === 'yes') ? true : false;
    if ($social_media) {
        $social_media_types = cmplz_get_value('socialmedia_on_site');
        if (isset($social_media_types[$name]) && $social_media_types[$name] == 1) return true;
    }

    return false;
}

/**
 * Handle saving of integrations services
 */

function process_integrations_services_save(){
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['cmplz_save_integrations_type'])){
        if (!isset($_POST['complianz_nonce']) || !wp_verify_nonce($_POST['complianz_nonce'], 'complianz_save')) return;

        $thirdparty_services = COMPLIANZ()->config->thirdparty_services;
        unset($thirdparty_services['google-fonts']);

        $active_services = cmplz_get_value('thirdparty_services_on_site');

        foreach($thirdparty_services as $service => $label){
            if (isset($_POST['cmplz_'.$service]) && $_POST['cmplz_'.$service]==1){
                $active_services[$service]=1;
                $service_obj = new CMPLZ_SERVICE();
                $service_obj->add($label, COMPLIANZ()->cookie_admin->get_supported_languages(), false, 'utility');
            }else {
                $active_services[$service]=0;
            }
        }

        cmplz_update_option('wizard', 'thirdparty_services_on_site', $active_services);

        $socialmedia = COMPLIANZ()->config->thirdparty_socialmedia;
        $active_socialmedia = cmplz_get_value('socialmedia_on_site');
        foreach($socialmedia as $service => $label){
            if (isset($_POST['cmplz_'.$service]) && $_POST['cmplz_'.$service]==1){
                $active_socialmedia[$service]=1;
                $service_obj = new CMPLZ_SERVICE();
                $service_obj->add($label, COMPLIANZ()->cookie_admin->get_supported_languages(), false, 'social');
            } else {
                $active_socialmedia[$service]=0;
            }
        }

        cmplz_update_option('wizard', 'socialmedia_on_site', $active_socialmedia);

		if (isset($_POST['cmplz_advertising']) && $_POST['cmplz_advertising']==1){
			cmplz_update_option('wizard', 'uses_ad_cookies','yes');
		} else {
			cmplz_update_option('wizard', 'uses_ad_cookies','no');
		}

    }

}
add_action('admin_init','process_integrations_services_save');
