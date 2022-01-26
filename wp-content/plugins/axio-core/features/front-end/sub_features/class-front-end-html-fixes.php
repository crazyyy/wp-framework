<?php
/**
 * Class Front_End_Html_Fixes
 */
class Axio_Core_Front_End_Html_Fixes extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_front_html_fixes');

    // var: name
    $this->set('name', 'Add Schema markup to posts navigations and remove obsolete type attribute from scripts');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('next_posts_link_attributes', array($this, 'axio_core_next_posts_attributes'));
    add_filter('script_loader_tag', array($this, 'axio_core_cleanup_script_tags'));
  }

  /**
   * Add Schema markup to posts navigations
   *
   * @param string $attr HTML attributes of the anchor tag
   *
   * @return string HTML attributes of the anchor tag
   */
  public static function axio_core_next_posts_attributes($attr) {
    return $attr . ' itemprop="relatedLink/pagination" ';
  }

  /**
   * Remove obsolete type attribute from scripts (HTML validator warning)
   *
   * @param string $tag the generated <script>
   */
  public static function axio_core_cleanup_script_tags($tag) {
    return str_replace(array('type=\'text/javascript\' ', 'type="text/javascript" '), '', $tag);
  }

}
