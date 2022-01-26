<?php
/**
 * Class Debug
 */
class Axio_Core_Debug extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_debug');

    // var: name
    $this->set('name', 'Debug');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_debug_style_guide'   => new Axio_Core_Debug_Style_Guide,
      'axio_core_debug_wireframe'     => new Axio_Core_Debug_Wireframe,
    ));

  }

}
