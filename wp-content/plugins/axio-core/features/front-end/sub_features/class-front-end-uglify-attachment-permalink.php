<?php
/**
 * Class Front_End_Uglify_Attachment_Permalink
 */
class Axio_Core_Front_End_Uglify_Attachment_Permalink extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_front_end_uglify_attachment_permalink');

    // var: name
    $this->set('name', 'Uglify attachment permalink (prevent attachments from reserving good slugs)');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    add_filter('wp_unique_post_slug_is_bad_attachment_slug', array($this, 'axio_core_uglify_attachment_permalink'), 10, 2);

  }

  /**
   * Prevent attachments from reserving good slugs (slugs without suffix)
   *
   * @param bool    $is_bad_slug does the slug need suffix
   * @param string  $slug the suggested slug
   *
   * @return string clean HTML sting
   */
  public static function axio_core_uglify_attachment_permalink($is_bad_slug, $slug) {

    return true;

  }

}
