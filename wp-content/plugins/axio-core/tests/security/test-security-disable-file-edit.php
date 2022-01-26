<?php
/**
 * Class SecurityDisableFileEditTest
 *
 * @package Axio_Core
 */

class SecurityDisableFileEditTest extends WP_UnitTestCase {

  private $security;

  public function setUp() {
    parent::setUp();
    $this->security = new Axio_Core_Security;
  }

  public function tearDown() {
    unset($this->security);
    parent::tearDown();
  }

  // test security sub feature

  public function test_security_disable_file_edit() {
    $class = $this->security->get_sub_features()['axio_core_security_disable_file_edit'];
    // key
    $this->assertNotEmpty(
       $class->get_key()
    );
    // name
    $this->assertNotEmpty(
      $class->get_name()
    );
    // status
    $this->assertTrue(
      $class->is_active()
    );

    /**
     * Run
     */

    // check defined constant
    $this->assertTrue(
      DISALLOW_FILE_EDIT
    );
  }

}
