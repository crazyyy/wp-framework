<?php
/**
 * Get registered strings
 *
 * @return array list of registerd strings as key => value structure
 */
function axio_core_get_registered_strings() {

  // support legacy filter
  $strings = apply_filters('aucor_core_pll_register_strings', array());

  // current filter
  $strings = apply_filters('axio_core_pll_register_strings', $strings);

  return $strings;

}

/**
 * Class Localization_String_Translations
 */
class Axio_Core_Localization_String_Translations extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_localization_string_translations');

    // var: name
    $this->set('name', 'Handling and registering site specific string translations');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('init', array($this, 'axio_core_string_registration'));
  }

  /**
   * String translations
   */
  public static function axio_core_string_registration() {

    if (function_exists('pll_register_string')) {
      $group_name = get_bloginfo();
      $strings = axio_core_get_registered_strings();
      foreach ($strings as $key => $value) {
        pll_register_string($key, $value, $group_name);
      }
    }

  }

}

/**
 * Get localized string by key
 *
 * @example ask__('Social share: Title')
 *
 * @param string $key unique identifier of string
 * @param string $lang 2-character language code (defaults to current language)
 *
 * @return string translated value or key if not registered string
 */
if (!function_exists('ask__')) {

  function ask__($key, $lang = null) {

    $strings = axio_core_get_registered_strings();
    if (isset($strings[$key])) {
      if ($lang === null) {
        return pll__($strings[$key]);
      } else {
        return pll_translate_string($strings[$key], $lang);
      }
    }

    // debug missing strings
    axio_core_debug_msg('Localization error - Missing string by key {' . $key . '}', array('ask__', 'ask_e'));

    return $key;

  }

}

/**
 * Echo localized string by key
 *
 * @param string $key unique identifier of string
 * @param string $lang 2 character language code (defaults to current language)
 */
if (!function_exists('ask_e')) {

  function ask_e($key, $lang = null) {
    echo wp_kses(ask__($key, $lang), wp_kses_allowed_html());
  }

}

/**
 * Get localized string by value
 *
 * @example asv__('Share on social media')
 *
 * @param string $value default value for string
 * @param string $lang 2 character language code (defaults to current language)
 *
 * @return string translated value or value if not registered string
 */
if (!function_exists('asv__')) {

  function asv__($value, $lang = null) {

    $strings = axio_core_get_registered_strings();
    if (array_search($value, $strings)) {
      if ($lang === null) {
        return pll__($value);
      } else {
        return pll_translate_string($value, $lang);
      }
    }

    // debug missing strings
    axio_core_debug_msg('Localization error - Missing string by value {' . $value . '}', array('asv__', 'asv_e'));

    return $value;
  }

}

/**
 * Echo localized string by value
 *
 * @param string $value default value for string
 * @param string $lang 2 character language code (defaults to current language)
 */
if (!function_exists('asv_e')) {

  function asv_e($value, $lang = null) {
    echo wp_kses(asv__($value, $lang), wp_kses_allowed_html());
  }

}

