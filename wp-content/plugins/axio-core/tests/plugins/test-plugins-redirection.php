<?php
/**
 * Class PluginsRedirectionTest
 *
 * @package Axio_Core
 */

class PluginsRedirectionTest extends WP_UnitTestCase {

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

  public function test_plugins_redirection() {
    $class = $this->plugins->get_sub_features()['axio_core_plugins_redirection'];
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
      10, has_filter('redirection_role', array($class, 'axio_core_redirection_role'))
    );

    // AXIO_CORE_REDIRECTION_ROLE()

    // mock args
    $args = 'publish_pages';

    // check that the return value is correct
    $this->assertSame(
      $args, $class->axio_core_redirection_role()
    );
  }

}
