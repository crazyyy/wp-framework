<?php
/**
 * Class Front_End_Clean_Empty_HTML
 */
class Axio_Core_Front_End_Clean_Empty_HTML extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_front_end_clean_empty_html');

    // var: name
    $this->set('name', 'Clean empty HTML nodes from content');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    add_filter('the_content', array($this, 'axio_core_clean_empty_html_nodes'));

  }

  /**
   * Clean empty HTML nodes
   *
   * @param string $content a HTML string
   *
   * @return string clean HTML sting
   */
  public static function axio_core_clean_empty_html_nodes($content) {

    $content = str_replace('<p></p>', '', $content);
    $content = str_replace('<p>&nbsp;</p>', '', $content);
    $content = str_replace('<p class="wp-block-paragraph"></p>', '', $content);
    $content = str_replace('<li></li>', '', $content);
    $content = str_replace('<span></span>', '', $content);

    return $content;

  }

}
