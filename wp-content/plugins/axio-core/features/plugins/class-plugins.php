<?php
/**
 * Class Plugins
 */
class Axio_Core_Plugins extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_plugins');

    // var: name
    $this->set('name', 'Plugins');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_plugins_acf'                   => new Axio_Core_Plugins_Acf,
      'axio_core_plugins_cookiebot'             => new Axio_Core_Plugins_Cookiebot,
      'axio_core_plugins_gravityforms'          => new Axio_Core_Plugins_Gravityforms,
      'axio_core_plugins_public_post_preview'   => new Axio_Core_Plugins_Public_Post_Preview,
      'axio_core_plugins_redirection'           => new Axio_Core_Plugins_Redirection,
      'axio_core_plugins_seo'                   => new Axio_Core_Plugins_Seo,
      'axio_core_plugins_yoast'                 => new Axio_Core_Plugins_Yoast,
    ));

  }

}
