<?php
/**
 * Class Front_End_Excerpt
 */
class Axio_Core_Front_End_Excerpt extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_front_end_excerpt');

    // var: name
    $this->set('name', 'Replace default excerpt dots and set custom excerpt length');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_filter('excerpt_more', array($this, 'axio_core_excerpt_more'));
    add_filter('excerpt_length', array($this, 'axio_core_excerpt_length'));

  }

  /**
   * Replace default excerpt dots
   *
   * @param string $more default read more string
   *
   * @return string read more string
   */
  public static function axio_core_excerpt_more($more) {
    return '...';
  }

  /**
   * Set custom excerpt length
   *
   * @param int $length the length of excerpt
   *
   * @return int the length of excerpt
   */
  public static function axio_core_excerpt_length($length) {
    return 20;
  }

}
