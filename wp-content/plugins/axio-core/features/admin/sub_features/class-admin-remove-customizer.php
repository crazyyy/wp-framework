<?php
/**
 * Class Admin_Remove_Customizer
 */
class Axio_Core_Admin_Remove_Customizer extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_admin_remove_customizer');

    // var: name
    $this->set('name', 'Remove customizer from admin bar');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('admin_bar_menu', array($this, 'axio_core_remove_customizer_admin_bar'), 999);
  }

  /**
   * Remove customizer from admin bar
   *
   * @param WP_Admin_Bar $wp_admin_bar the admin bar
   */
  public static function axio_core_remove_customizer_admin_bar($wp_admin_bar) {
    $wp_admin_bar->remove_menu('customize');
  }

}
