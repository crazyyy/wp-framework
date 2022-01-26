<?php
/**
 * Class AdminFrontPageEditLinkTest
 *
 * @package Axio_Core
 */

class AdminFrontPageEditLinkTest extends WP_UnitTestCase {

  private $admin;

  public function setUp() {
    parent::setUp();
    $this->admin = new Axio_Core_Admin;
  }

  public function tearDown() {
    unset($this->admin);
    parent::tearDown();
  }

  // test admin sub feature

  public function test_admin_login() {
    $class = $this->admin->get_sub_features()['axio_core_admin_front_page_edit_link'];
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

    // check filter hooks
    $this->assertSame(
      10, has_action('admin_menu', array($class, 'axio_core_add_edit_link_to_front_page'))
    );

  }

}
