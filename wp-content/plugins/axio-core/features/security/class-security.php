<?php
/**
 * Class Security
 */
class Axio_Core_Security extends Axio_Core_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_security');

    // var: name
    $this->set('name', 'Security');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Initialize and add the sub_features to the $sub_features array
   */
  public function sub_features_init() {

    // var: sub_features
    $this->set('sub_features', array(
      'axio_core_security_disable_admin_email_check' => new Axio_Core_Security_Disable_Admin_Email_Check,
      'axio_core_security_disable_file_edit'         => new Axio_Core_Security_Disable_File_Edit,
      'axio_core_security_disable_unfiltered_html'   => new Axio_Core_Security_Disable_Unfiltered_Html,
      'axio_core_security_head_cleanup'              => new Axio_Core_Security_Head_Cleanup,
      'axio_core_security_hide_users'                => new Axio_Core_Security_Hide_Users,
      'axio_core_security_remove_comment_moderation' => new Axio_Core_Security_Remove_Comment_Moderation,
      'axio_core_security_remove_commenting'         => new Axio_Core_Security_Remove_Commenting,
    ));

  }

}
