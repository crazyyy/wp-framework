<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Custom functions, support, custom post types and more.
*/

const WPEB_VERSION = '2024.07.03';
define('WPEB_TEMPLATE_URL',   get_template_directory_uri() );
define('WPEB_TEMPLATE_PATH',  get_template_directory() );

/**
 * Init Development Helper Functions
 */
require_once WPEB_TEMPLATE_PATH . '/inc/dev-help.php';

/**
 * Init Theme Setup and Customizations
 */
require_once WPEB_TEMPLATE_PATH . '/inc/theme-customize.php';

/**
 * Init Theme Menu Navigation and Widget Areas
 */
require_once WPEB_TEMPLATE_PATH . '/inc/theme-menus-widgets.php';

/**
 * Init Theme Script and Styles Enqueue
 */
require_once WPEB_TEMPLATE_PATH . '/inc/enqueues.php';

/**
 * Init Custom Post Types and Taxonomies
 */
require_once WPEB_TEMPLATE_PATH . '/inc/custom-post-type.php';

/**
 * Init Theme Helper Functions
 */
require_once WPEB_TEMPLATE_PATH . '/inc/helper-functions.php';

/**
 * Init REST API customizations and endpoints
 */
require_once WPEB_TEMPLATE_PATH . '/inc/api.php';

/**
 * Init Custom Gutenberg Blocks
 */
require_once WPEB_TEMPLATE_PATH . '/blocks/blocks-init.php';

/**
 * Init ACF Plugin options
 */
require_once WPEB_TEMPLATE_PATH . '/inc/acf.php';
