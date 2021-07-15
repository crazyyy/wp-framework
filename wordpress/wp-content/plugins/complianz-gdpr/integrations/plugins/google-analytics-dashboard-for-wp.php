<?php
defined('ABSPATH') or die("you do not have acces to this page!");


/**
 * Keep GADWP settings in sync with Complianz
 */

add_filter( 'admin_init', 'cmplz_gadwp_options' ,10,2);
function cmplz_gadwp_options(){

	if (class_exists('GADWP_Config')) {
		$save = false;
		$gadwp = new GADWP_Config();
		//handle anonymization
		if ( cmplz_no_ip_addresses() && !$gadwp->options['ga_anonymize_ip']) {
			$save=true;
			$gadwp->options['ga_anonymize_ip'] = true;
		}

		//handle sharing of data
		if ( cmplz_statistics_no_sharing_allowed() && $gadwp->options['ga_remarketing']) {
			$save=true;
			$gadwp->options['ga_remarketing'] = false;
		}

		if ($save) $gadwp->set_plugin_options();
	}

}

/**
 * Make sure there's no warning about configuring GA anymore
 * @param $warnings
 * @return mixed
 */

function cmplz_gadwp_filter_warnings($warnings)
{
    if (($key = array_search('ga-needs-configuring', $warnings)) !== false) {
        unset($warnings[$key]);
    }
	if (($key = array_search('gtm-needs-configuring', $warnings)) !== false) {
		unset($warnings[$key]);
	}
    return $warnings;
}
add_filter('cmplz_warnings', 'cmplz_gadwp_filter_warnings');

/**
 * Hide the stats configuration options when gadwp is enabled.
 * @param $fields
 * @return mixed
 */

function cmplz_gadwp_filter_fields($fields)
{
    unset($fields['configuration_by_complianz']);
    unset($fields['UA_code']);

    return $fields;
}
add_filter('cmplz_fields', 'cmplz_gadwp_filter_fields', 20, 1);


/**
 * We remove some actions to integrate fully
 * */
function cmplz_gadwp_remove_scripts_others()
{
	remove_action('cmplz_statistics_script', array(COMPLIANZ()->cookie_admin, 'get_statistics_script'), 10);
}

add_action('after_setup_theme', 'cmplz_gadwp_remove_scripts_others');

/**
 * Tell the user the consequences of choices made
 */
function cmplz_gadwp_compile_statistics_more_info_notice()
{
    if (cmplz_no_ip_addresses()) {
        cmplz_notice(sprintf(__("You have selected you anonymize IP addresses. This setting is now enabled in %s.", 'complianz-gdpr'),'Google Analytics Dashboard for WP'));
    }
    if (cmplz_statistics_no_sharing_allowed()) {
        cmplz_notice(sprintf(__("You have selected you do not share data with third party networks. Display advertising is now disabled in %s.", 'complianz-gdpr'), 'Google Analytics Dashboard for WP'));
    }
}
add_action('cmplz_notice_compile_statistics_more_info', 'cmplz_gadwp_compile_statistics_more_info_notice');