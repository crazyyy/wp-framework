<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Initialize Gutenberg Blocks customizations and initiations
*/

/**
 * Enables Gutenberg Block Editor Developer Mode.
 * This function enables the developer mode for the Gutenberg Block Editor.
 * By setting the 'gutenberg_can_edit_post_type' filter to return true, it allows
 * the block editor to be used for all post types.
 */
function wpeb_enable_gutenberg_developer_mode(): bool
{
  return true;
}
add_filter('gutenberg_can_edit_post_type', 'wpeb_enable_gutenberg_developer_mode');

/**
 * Enables Block Labelling for inspecting blocks.
 * This function enables the block labelling feature in the Gutenberg Block Editor.
 * By setting the 'gutenberg_debug' filter to return true, it adds labels to the blocks
 * in the editor, making it easier to inspect and identify blocks.
 */
function wpeb_enable_block_labelling(): bool
{
  return true;
}
add_filter('gutenberg_debug', 'wpeb_enable_block_labelling');

/**
 * Add WPEB Block Category
 * Adds a custom block category to the Gutenberg editor.
 * @param array $block_categories Array of block categories.
 * @param object $editor_context Context of the editor.
 * @return array Updated array of block categories.
 */
function add_wpeb_block_category(array $block_categories, object $editor_context): array
{
  // Check if the editor context has a post
  if (!empty($editor_context->post)) {
    // Add the Artkai block category
    $block_categories[] = array(
      'slug' => 'wpeb-category',
      'title' => __('WP Bruce Easy', 'wpeb'),
      'icon' => null,
    );
  }

  return $block_categories;
}

add_filter('block_categories_all', 'add_wpeb_block_category', 10, 2);


/**
 * Example ACF Gutenberg Block Init
 */
require_once WPEB_TEMPLATE_PATH . '/blocks/example-block/init.php';
