<?php
/**
 * Class AdminProfileCleanupTest
 *
 * @package Axio_Core
 */

class AdminProfileCleanupTest extends WP_UnitTestCase {

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

  public function test_admin_profile_cleanup() {
    $class = $this->admin->get_sub_features()['axio_core_admin_profile_cleanup'];
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

    global $wp_filter;

    // check that the actions have been removed
    $this->assertArrayNotHasKey(
      'admin_color_scheme_picker', $wp_filter
    );

    // check filter hook
    $this->assertSame(
      10, has_filter( 'user_contactmethods', array($class, 'axio_core_remove_contact_methods'))
    );

    // AXIO_CORE_REMOVE_CONTACT_METHODS()

    // mock args
    $args = array(
      'aim'        => '',
      'jabber'     => '',
      'yim'        => '',
      'googleplus' => '',
      'twitter'    => '',
      'facebook'   => ''
    );

    // check that the callback functions return correct values
    $this->assertSame(
      array(), $class->axio_core_remove_contact_methods($args)
    );
  }

}
