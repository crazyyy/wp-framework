<?php
/**
 * Class Security_Disable_File_Edit
 */
class Axio_Core_Security_Disable_File_Edit extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_security_disable_file_edit');

    // var: name
    $this->set('name', 'Disables editing of files from the dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    if (!defined('DISALLOW_FILE_EDIT')) {
      define('DISALLOW_FILE_EDIT', true);
    }

  }

}
