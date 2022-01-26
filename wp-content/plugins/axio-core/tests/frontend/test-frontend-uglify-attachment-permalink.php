<?php
/**
 * Class FrontEndUglifyAttachmentPermalinkTest
 *
 * @package Axio_Core
 */

class FrontEndUglifyAttachmentPermalinkTest extends WP_UnitTestCase {

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
    $class = $this->front_end->get_sub_features()['axio_core_front_end_uglify_attachment_permalink'];
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
      10, has_filter('wp_unique_post_slug_is_bad_attachment_slug', array($class, 'axio_core_uglify_attachment_permalink'))
    );

  }

}
