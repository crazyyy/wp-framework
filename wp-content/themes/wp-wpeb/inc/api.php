<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Rest API customizations and endpoints
  */

/**
 * Allow anonymous comments via the REST API.
 * This function sets the 'rest_allow_anonymous_comments' filter to return true,
 * allowing anonymous comments to be submitted via the REST API.
 * @return bool Whether anonymous comments are allowed via the REST API.
 */
function wpeb_allow_anonymous_comments(): bool
{
  return true;
}
add_filter( 'rest_allow_anonymous_comments', 'wpeb_allow_anonymous_comments' );

/**
 * Allows Cross-Origin Resource Sharing (CORS) for all requests in WP REST API.
 * This function removes the default filter that handles sending CORS headers in WP REST API,
 * and adds a custom filter to allow CORS for all requests. It sets the necessary headers
 * to allow methods OPTIONS, GET, POST, PUT, and PATCH, allows credentials, and allows all headers.
 */
function wpeb_rest_allow_all_cors(): void
{
  // Remove the default filter.
  remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
  // Add a custom filter.
  add_filter( 'rest_pre_serve_request', 'wpeb_custom_cors_headers' );
}

/**
 * Set custom CORS headers for WP REST API requests.
 * @param bool $value The default filter value.
 * @return bool The modified filter value.
 */
function wpeb_custom_cors_headers(bool $value ): bool
{
  header( 'Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH' );
  header( 'Access-Control-Allow-Credentials: true' );
  header( 'Access-Control-Allow-Headers: *' );
  return $value;
}

add_action( 'rest_api_init', 'wpeb_rest_allow_all_cors', 15 );

/**
 * Remove unnecessary links from the REST API response.
 * This function removes specified links from the REST API response object.
 * @param WP_REST_Response $response The REST API response object.
 * @param array $links The links to be removed.
 * @return WP_REST_Response Modified REST API response object.
 */
function remove_links_from_response(WP_REST_Response $response, array $links ): WP_REST_Response
{
  foreach ($links as $link) {
    $response->remove_link($link);
  }

  return $response;
}

/**
 * Remove unnecessary links from the REST API response.
 * This function is the callback for the 'rest_prepare_post' and 'rest_prepare_page' filter hooks.
 * It removes unnecessary links from the REST API response object for post and page types.
 * @param WP_REST_Response $response The REST API response object.
 * @return WP_REST_Response Modified REST API response object.
 */
function remove_unnecessary_links(WP_REST_Response $response): WP_REST_Response
{
  $remove_links = array(
    'collection',
    'self',
    'about',
    'author',
    'replies',
    'version-history',
    'https://api.w.org/featuredmedia',
    'https://api.w.org/attachment',
    'https://api.w.org/term',
    'curies',
    'predecessor-version'
  );

  return remove_links_from_response($response, $remove_links);
}

// Add filter hooks for removing unnecessary links
$prepare_post_types = array('post', 'page');
foreach ($prepare_post_types as $prepare_post_type) {
  add_filter('rest_prepare_' . $prepare_post_type, 'remove_unnecessary_links', 11, 1);
}
