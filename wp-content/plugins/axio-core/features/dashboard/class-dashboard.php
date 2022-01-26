<?php
/**
 * Class Dashboard
 */
class Axio_Core_Dashboard extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_dashboard');

    // var: name
    $this->set('name', 'Dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_dashboard_cleanup'       => new Axio_Core_Dashboard_Cleanup,
      'axio_core_dashboard_recent_widget' => new Axio_Core_Dashboard_Recent_Widget,
      'axio_core_dashboard_remove_panels' => new Axio_Core_Dashboard_Remove_Panels,
    ));

  }

}
