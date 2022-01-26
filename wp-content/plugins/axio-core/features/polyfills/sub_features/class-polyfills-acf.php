<?php
/**
 * Class Localization_Polyfill
 */
class Axio_Core_Polyfills_ACF extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key (keep legacy structure for backwards compatibility)
    $this->set('key', 'axio_core_polyfills_acf');

    // var: name
    $this->set('name', 'Preserve functionality without ACF plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

  }

}

/**
 * This structure of not having the polyfills in the class is so that the functions
 * might be used outside the class (i.e. the theme) without having to declare an instance
 * of the class first. The instance created below is to still maintain the option of diabling
 * the polyfills, if that need ever rises for some reason.
 */

$instance = new Axio_Core_Polyfills_ACF;

/**
 * Fallback ACF (preserve functionality without the plugin)
 *
 * Fallbacks are not used in admin or WP_CLI to allow activation of ACF plugin.
 * This restriction is not optimal, but this is only meant to fix the fatal
 * errors in front-end.
 */
if ($instance->is_active() && (!is_admin() || (defined('WP_CLI') && WP_CLI))) :
  if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true) {
      if (empty($post_id)) {
        $post_id = get_the_ID();
      }
      if (is_numeric($post_id)) {
        return get_post_meta($selector, $post_id, true);
      }
      return '';
    }
  }
  if (!function_exists('the_field')) {
    function the_field($selector, $post_id = false, $format_value = true) {
      echo wp_kses(get_field($selector, $post_id, $format_value), wp_kses_allowed_html());
    }
  }
  if (!function_exists('get_fields')) {
    function get_fields($post_id = false, $format_value = true) {
      return array();
    }
  }
  if (!function_exists('have_rows')) {
    function have_rows($selector, $post_id = false) {
      return false;
    }
  }
  if (!function_exists('the_row')) {
    function the_row() {
      return false;
    }
  }
  if (!function_exists('get_sub_field')) {
    function get_sub_field($selector, $format_value = true) {
      return '';
    }
  }
  if (!function_exists('the_sub_field')) {
    function the_sub_field($selector, $format_value = true) {
      echo wp_kses(get_sub_field($selector, $format_value), wp_kses_allowed_html());
    }
  }
endif;

unset($instance);
