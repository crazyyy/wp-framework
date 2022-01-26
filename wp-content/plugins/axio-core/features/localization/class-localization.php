<?php
/**
 * Class Localization
 */
class Axio_Core_Localization extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_localization');

    // var: name
    $this->set('name', 'Localization');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_localization_string_translations' => new Axio_Core_Localization_String_Translations,
    ));

  }

}
