<?php
/**
 * Class Admin
 */
class Axio_Core_Admin extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_admin');

    // var: name
    $this->set('name', 'Admin');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_admin_front_page_edit_link'  => new Axio_Core_Admin_Front_Page_Edit_Link,
      'axio_core_admin_gallery'               => new Axio_Core_Admin_Gallery,
      'axio_core_admin_image_link'            => new Axio_Core_Admin_Image_Link,
      'axio_core_admin_login'                 => new Axio_Core_Admin_Login,
      'axio_core_admin_menu_cleanup'          => new Axio_Core_Admin_Menu_Cleanup,
      'axio_core_admin_notifications'         => new Axio_Core_Admin_Notifications,
      'axio_core_admin_profile_cleanup'       => new Axio_Core_Admin_Profile_Cleanup,
      'axio_core_admin_remove_customizer'     => new Axio_Core_Admin_Remove_Customizer,
    ));

  }

}
