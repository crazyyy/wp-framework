<?php
/**
 * Class Plugins_Cookiebot
 */
class Axio_Core_Plugins_Cookiebot extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_plugins_cookiebot');

    // var: name
    $this->set('name', 'Settings for the Cookiebot plugin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    add_filter('pre_option_cookiebot_notice_recommend', array($this, 'axio_core_hide_cookiebot_nags'), 10, 3);

  }

  /**
   * Hide review plugin nag
   *
   * @param mixed   $pre_option the initial value
   * @param string  $option the option name
   * @param mixed   $default the default value
   *
   * @return mixed  the filtered value
   */
  public static function axio_core_hide_cookiebot_nags($pre_option, $option, $default) {

    return 'hide';

  }

}
