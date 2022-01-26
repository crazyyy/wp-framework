<?php
/**
 * Class PluginsAcfTest
 *
 * @package Axio_Core
 */

class PluginsAcfTest extends WP_UnitTestCase {

  private $plugins;

  public function setUp() {
    parent::setUp();
    $this->plugins = new Axio_Core_Plugins;
  }

  public function tearDown() {
    unset($this->plugins);
    parent::tearDown();
  }

  // test plugins sub feature

  public function test_plugins_acf() {
    $class = $this->plugins->get_sub_features()['axio_core_plugins_acf'];
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

    // check filter hook
    $this->assertSame(
      10, has_filter('acf/settings/show_admin', array($class, 'axio_core_hide_acf_from_nonadmins'))
    );
    // check filter hook
    $this->assertSame(
      1, has_filter('render_block_data', array($class, 'axio_core_acf_render_block_data'))
    );

    // AXIO_CORE_HIDE_ACF_FROM_NONADMINS()

    // create an admin user and set it as the current user
    $user_admin = $this->factory->user->create(array('role' => 'administrator'));
    wp_set_current_user($user_admin);

    // check the that the returning boolean is correct
    $this->assertTrue(
      $class->axio_core_hide_acf_from_nonadmins(true)
    );

    // create a subscribe user and set it as the current user
    $user_sub = $this->factory->user->create(array('role' => 'subscriber'));
    wp_set_current_user($user_sub);

    // check the that the returning boolean is correct
    $this->assertFalse(
      $class->axio_core_hide_acf_from_nonadmins(true)
    );
  }

}
