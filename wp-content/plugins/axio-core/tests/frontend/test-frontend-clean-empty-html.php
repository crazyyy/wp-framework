<?php
/**
 * Class FrontEndCleanEmptyHTMLtTest
 *
 * @package Axio_Core
 */

class FrontEndCleanEmptyHTMLtTest extends WP_UnitTestCase {

  private $front_end;

  public function setUp() {
    parent::setUp();
    $this->front_end = new Axio_Core_Front_End;
  }

  public function tearDown() {
    unset($this->front_end);
    parent::tearDown();
  }

  // test front end sub feature

  public function test_front_end_excerpt() {
    $class = $this->front_end->get_sub_features()['axio_core_front_end_clean_empty_html'];
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
      10, has_filter('the_content', array($class, 'axio_core_clean_empty_html_nodes'))
    );

    // AXIO_CORE_EXCERPT_MORE()

     // mock args
    $excerpt = 'Test string';

    // check that cleanup works correctly
    $this->assertSame(
      'Lorem ipsum<br />Dolor sit', $class->axio_core_clean_empty_html_nodes('<p></p>Lorem ipsum<br /><p></p>Dolor sit')
    );
    $this->assertSame(
      'Lorem ipsum<br />Dolor sit', $class->axio_core_clean_empty_html_nodes('<p></p>Lorem ipsum<br /><p>&nbsp;</p>Dolor sit')
    );
    $this->assertSame(
      'Lorem ipsum<br />Dolor sit', $class->axio_core_clean_empty_html_nodes('<p></p>Lorem ipsum<br /><span></span>Dolor sit')
    );
    $this->assertSame(
      '<ul><li>Lorem ipsum</li><li>Dolor sit</li></ul>', $class->axio_core_clean_empty_html_nodes('<ul><li>Lorem ipsum</li><li>Dolor sit</li><li></li></ul>')
    );

  }

}
