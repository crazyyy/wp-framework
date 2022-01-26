<?php
/**
 * Class ACFPolyfillTest
 *
 * @package Axio_Core
 */

class ACFPolyfillTest extends WP_UnitTestCase {

  private $local;

  public function setUp() {
    parent::setUp();
    $this->local = new Axio_Core_Polyfills;
  }

  public function tearDown() {
    unset($this->local);
    parent::tearDown();
  }

  // test localization sub feature

  public function test_localization_polyfill() {
    $class = $this->local->get_sub_features()['axio_core_polyfills_acf'];
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
     * - nothing is actually run in the run function, but the "semi-class" provides
     *  polyfill functions for the Polylang plugin
     */

    // FOR ALL THE POLYFILLS

    // check that the function exists, mock args and check return values
    // for the _e()-functions buffer the output

    $this->assertTrue(
      function_exists('get_field')
    );

    $this->assertTrue(
      function_exists('the_field')
    );

    $this->assertTrue(
      function_exists('get_fields')
    );

    $this->assertTrue(
      function_exists('have_rows')
    );

    $this->assertTrue(
      function_exists('the_row')
    );

    $this->assertTrue(
      function_exists('get_sub_field')
    );

    $this->assertTrue(
      function_exists('the_sub_field')
    );

  }

}
