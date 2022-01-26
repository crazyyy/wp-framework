<?php
/**
 * Class Speed
 */
class Axio_Core_Speed extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_speed');

    // var: name
    $this->set('name', 'Speed');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_speed_limit_revisions'  => new Axio_Core_Speed_Limit_Revisions,
      'axio_core_speed_move_jquery'      => new Axio_Core_Speed_Move_Jquery,
      'axio_core_speed_remove_emojis'    => new Axio_Core_Speed_Remove_Emojis,
      'axio_core_speed_remove_metabox'   => new Axio_Core_Speed_Remove_Metabox,
    ));

  }

}
