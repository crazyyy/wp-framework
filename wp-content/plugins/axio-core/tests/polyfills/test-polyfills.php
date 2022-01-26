<?php
/**
 * Class PolyfillsTest
 *
 * @package Axio_Core
 */

class PolyfillsTest extends WP_UnitTestCase {

  private $instance;

  public function setUp() {
    parent::setUp();
    $this->instance = new Axio_Core_Polyfills;
  }

  public function tearDown() {
    unset($this->instance);
    parent::tearDown();
  }

  // test polyfills feature

  public function test_polyfills() {
    $class = $this->instance;
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

    // sub feature init
    $this->assertNotEmpty(
      $class->get_sub_features()
    );
  }

}
