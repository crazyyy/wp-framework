<?php
/**
 * Class Admin_Front_Page_Edit_Link
 */
class Axio_Core_Admin_Front_Page_Edit_Link extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_admin_front_page_edit_link');

    // var: name
    $this->set('name', 'Link to edit the front page');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {
    add_action('admin_menu', array($this, 'axio_core_add_edit_link_to_front_page'));
  }

  /**
   * Add link to pages menu to edit front page
   */
  public static function axio_core_add_edit_link_to_front_page() {

    $front_page_id = get_option('page_on_front');

    if (!empty($front_page_id)) {

      // localize based on selected language
      if (function_exists('pll_get_post')) {
        $front_page_id = pll_get_post($front_page_id);
      }

      if (!empty($front_page_id)) {
        add_submenu_page('edit.php?post_type=page', __('Home'), __('Home'), 'edit_pages', get_edit_post_link($front_page_id));
      }

    }

  }

}
