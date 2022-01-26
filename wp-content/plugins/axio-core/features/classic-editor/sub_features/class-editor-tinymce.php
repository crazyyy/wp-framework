<?php
/**
 * Class Editor_Tinymce
 */
class Axio_Core_Classic_Editor_Tinymce extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_classic_editor_tinymce');

    // var: name
    $this->set('name', 'TinyMCE settings');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('tiny_mce_before_init', array($this, 'axio_core_show_second_editor_row'));
  }

  /**
   * TinyMCE settings
   *
   * @param array $settings TinyMCE settings
   *
   * @return array TinyMCE settings
   */
  public static function axio_core_show_second_editor_row($settings) {

    // show 2nd editor row
    $settings['wordpress_adv_hidden'] = false;

    return $settings;

  }

}
