<?php
  /**
   *  Author: Vitalii A | @knaipa
   *  URL: https://github.com/crazyyy/wp-framework
   *  Initialize Gutenberg Blocks customizations and initiations
   */

  /**
   * Register a custom Gutenberg block type: Block Example.
   * This function registers a custom Gutenberg block type called "Block Example".
   * It sets various attributes and options for the block, such as name, title, description,
   * category, icon, keywords, render template, enqueue styles and scripts, and block supports.
   * The block is registered using the acf_register_block_type() function from the Advanced Custom Fields (ACF) plugin.
   */
  function register_block_example() {
    acf_register_block_type(array(
      'name' => 'wpeb-block-example',
      'title' => __('Block Example', 'wpeb'),
      'description' => __('Block Example Description', 'wpeb'),
      'category' => 'wpeb-category',
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125" style="enable-background:new 0 0 100 100" xml:space="preserve"><switch><g><path d="m39.9 56.2-7.7-10.8c-1.9-2.6-2-6.3-.2-9 .2-.3 2.4-3.5 6.8-6.7-16.5 7.4-34.5 21.4-36 23.8-2.5 4 11.5 5.6 14 19.2 2.1 11.9 18 17.6 20.4 11.9 2.3-5.6 5-10.8 7.9-15.4l.8-9.7c-2.5-.2-4.6-1.4-6-3.3z"/><path d="M93.1 26.6H60c-17 0-24.8 11.3-25.1 11.8-1 1.5-1 3.5.1 5l7.7 10.8c.9 1.2 2.2 1.8 3.6 1.8.9 0 1.8-.3 2.5-.8l.6-.6v3.1l-2.7 32.6c-.2 2.7 1.8 5 4.5 5.3 2.7.2 5-1.8 5.3-4.5l2.6-31.3H61L63.6 91c.2 2.5 2.3 4.5 4.9 4.5h.4c2.7-.2 4.7-2.6 4.5-5.3l-2.7-32.6-.2-22.3h22.7c2.4 0 4.4-2 4.4-4.4-.1-2.4-2.1-4.3-4.5-4.3zm-43.6 22-5.3-7.4c1.2-1.1 3-2.4 5.4-3.6l-.1 11z"/><circle cx="60" cy="14.2" r="9.8"/></g></switch></svg>',
      'keywords' => array(
        'wpeb',
        'example',
      ),
      'render_template' => 'blocks/example-block/block.php',
      'enqueue_style' => WPEB_TEMPLATE_URL . '/blocks/example-block/block.css',
      'enqueue_script' => WPEB_TEMPLATE_URL . '/blocks/example-block/block.js',
      'supports' => array(
        'anchor' => true,
        'align' => true,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'mode' => true,
        'multiple' => true,
        'example' => array(),
        'jsx' => false,
      ),
    ));
  }
  add_action('acf/init', 'register_block_example');
