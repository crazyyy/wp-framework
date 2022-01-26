<?php
/**
 * Class AdminImageLinkTest
 *
 * @package Axio_Core
 */

class AdminImageLinkTest extends WP_UnitTestCase {

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

  public function test_admin_image_link() {
    $class = $this->admin->get_sub_features()['axio_core_admin_image_link'];
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
    // check action hook
    $this->assertSame(
      10, has_action('admin_init', array($class, 'axio_core_default_image_link_to_none'))
    );

    // AXIO_CORE_DEFAULT_IMAGE_LINK_TO_NONE()

    // inject a wrong value to options
    update_option('image_default_link_type', 'file');

    //run callback function
    $class->axio_core_default_image_link_to_none();

    // check that the option is correct
    $this->assertEquals(
      'none', get_option('image_default_link_type')
    );
  }

}
