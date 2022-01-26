<?php
/**
 * Class Dashboard_Remove_Panels
 */
class Axio_Core_Dashboard_Remove_Panels extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_dashboard_remove_panels');

    // var: name
    $this->set('name', 'Removes the \'Try out Gutenberg\' and the welcome panel from the dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    remove_action('try_gutenberg_panel', 'wp_try_gutenberg_panel');
    remove_action('welcome_panel', 'wp_welcome_panel');
  }

}
