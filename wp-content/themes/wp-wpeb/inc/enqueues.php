<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Enqueue scripts and styles
*/

/**
 * Enqueue styles and scripts for WP Console Editor
 */
function wpeb_enqueue_editor_assets()
{
  wp_enqueue_style(
    'wpeb-wp-console-style',
    WPEB_TEMPLATE_URL . '/css/wpeb-wp-console-style.css',
    array(),
    WPEB_VERSION
  );

  wp_enqueue_style(
    'wpeb-editor-style',
    WPEB_TEMPLATE_URL . '/css/wpeb-editor-style.css',
    array(),
    WPEB_VERSION
  );

  wp_enqueue_script(
    'wpeb-editor-script',
    WPEB_TEMPLATE_URL . '/js/wpeb-editor-scripts.js',
    array(),
    WPEB_VERSION
  );
}
add_action('admin_enqueue_scripts', 'wpeb_enqueue_editor_assets');

/**
 * Enqueue theme stylesheet
 */
function wpeb_enqueue_theme_styles()
{
  wp_dequeue_style('fancybox');

  wp_enqueue_style(
    'wpeb-style',
    WPEB_TEMPLATE_URL . '/css/main.css',
    array(),
    WPEB_VERSION,
    'all'
  );
}
add_action('wp_enqueue_scripts', 'wpeb_enqueue_theme_styles');

/**
 * Enqueue theme header scripts
 */
function wpeb_enqueue_theme_header_scripts()
{
  // wp_deregister_script('jquery');
  // wp_deregister_script('jquery-migrate');
  wp_deregister_script('modernizr');
  wp_deregister_script('jquery-form');

  wp_enqueue_script(
    'jquery',
    '//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js',
    array(),
    '3.7.1'
  );

  wp_enqueue_script(
    'jquery-migrate',
    '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.1/jquery-migrate.min.js',
    array('jquery'),
    '3.4.1'
  );

  wp_enqueue_script(
    'modernizr',
    '//cdn.jsdelivr.net/npm/modernizr@3.12.0/lib/cli.min.js',
    array(),
    '3.12.0'
  );
}
add_action('wp_enqueue_scripts', 'wpeb_enqueue_theme_header_scripts');

/**
 * Enqueue theme footer scripts
 */
function wpeb_enqueue_theme_footer_scripts()
{
  wp_register_script(
    'wpeb-scripts',
    WPEB_TEMPLATE_URL . '/js/scripts.js',
    array('jquery'),
    WPEB_VERSION,
    true
  );
  wp_enqueue_script('wpeb-scripts');
  wp_localize_script('wpeb-scripts', 'adminAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'templatePath' => WPEB_TEMPLATE_URL,
    'posts_per_page' => get_option('posts_per_page')
  ));
}
add_action('wp_enqueue_scripts', 'wpeb_enqueue_theme_footer_scripts');
