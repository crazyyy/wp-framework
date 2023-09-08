<?php
/**
 *  Author: Vitalii A | @knaipa
 *  URL: https://github.com/crazyyy/wp-framework
 *  ACF Plugin customizations
 */

/**
 * ACF Google Maps API Key
 */
function wpeb_acf_google_maps_api(): void
{
  // Update the Google Maps API key in ACF
  acf_update_setting('google_api_key', 'TOKEN');
}
add_action('acf/init', 'wpeb_acf_google_maps_api');

/**
 * Modify the Advanced Custom Fields (ACF) REST API format setting.
 * This function is used as a callback for the 'acf/settings/rest_api_format' filter hook.
 * It modifies the REST API format setting for Advanced Custom Fields (ACF) by returning
 * the value 'standard'. The REST API format determines the format in which ACF field values
 * are returned when accessed via the REST API.
 * @return string The modified REST API format setting.
 */
function wpeb_modify_acf_rest_api_format(): string
{
  return 'standard';
}
add_filter( 'acf/settings/rest_api_format', 'wpeb_modify_acf_rest_api_format' );
