<?php
/**
 * Class Localization
 */
class Axio_Core_Polyfills extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_polyfills');

    // var: name
    $this->set('name', 'Polyfills');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_polyfills_acf'         => new Axio_Core_Polyfills_ACF,
      'axio_core_polyfills_polylang'    => new Axio_Core_Polyfills_Polylang,
    ));

  }

}
