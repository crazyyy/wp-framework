<?php
  /**
   *  Author: Vitalii A | @knaipa
   *  URL: https://github.com/crazyyy/wp-framework
   *  Theme Menus Navigation and Widgets
   */

  /**
   * WPEB Header navigation
   */
  function wpeb_header_navigation() {
    wp_nav_menu(
      array(
        'theme_location'  => 'header-menu',
        'container'       => 'nav',
        'container_class' => 'header__nav-container header__nav-{menu slug}-container',
        'menu_class'      => 'header__menu',
        'fallback_cb'     => 'wp_page_menu',
        'depth'           => 0,
        //'fallback_cb'     => false,
        //'depth'           => 1,
      )
    );
  }

  /**
   * WPEB Footer navigation
   */
  function wpeb_footer_navigation() {
    wp_nav_menu(
      array(
        'theme_location'  => 'footer-menu',
        'container'       => 'nav',
        'container_class' => 'footer__nav-container footer__nav-{menu slug}-container',
        'menu_class'      => 'footer__menu',
        'fallback_cb'     => 'wp_page_menu',
        'depth'           => 0,
        //'fallback_cb'     => false,
        //'depth'           => 1,
      )
    );
  }

  /**
   * WPEB Sidebar navigation
   */
  function wpeb_sidebar_navigation() {
    wp_nav_menu(
      array(
        'theme_location'  => 'sidebar-menu',
        'container'       => 'nav',
        'container_class' => 'sidebar__nav-container sidebar__nav-{menu slug}-container',
        'menu_class'      => 'sidebar__menu',
        'fallback_cb'     => 'wp_page_menu',
        'depth'           => 0,
        //'fallback_cb'     => false,
        //'depth'           => 1,
      )
    );
  }

  /**
   * Register WPE Navigation
   */
  function wpeb_menus() {
    register_nav_menus(array(
      'header-menu'   => __('Header Navigation', 'wpeb'),
      'sidebar-menu'  => __('Sidebar Navigation', 'wpeb'),
      'footer-menu'   => __('Footer Navigation', 'wpeb')
    ));
  }
  add_action('init', 'wpeb_menus');

  /**
   * Remove the <div> surrounding the dynamic WP Navigation to clean up markup
   */
  function wpeb_wp_nav_menu_args($args)
  {
    $args['container'] = false;
    return $args;
  }
  add_filter('wp_nav_menu_args', 'wpeb_wp_nav_menu_args');

  /**
   * Remove Injected classes, ID's and Page ID's from Navigation <li> items
   */
  function wpeb_id_class_attr_filter($classes, $item, $args): array
  {
    return array();
  }
  // Remove Navigation <li> injected classes
  //add_filter('nav_menu_css_class', 'wpeb_id_class_attr_filter', 10, 3);
  // Remove Navigation <li> injected ID
  //add_filter('nav_menu_item_id', 'wpeb_id_class_attr_filter', 10, 3);
  // Remove Navigation <li> Page ID's
  //add_filter('page_css_class', 'wpeb_id_class_attr_filter', 10, 3);

  /**
   * Register WPEB Sidebars
   */
  function wpeb_register_sidebars()
  {
    // Check if Dynamic Sidebar Exists
    if (function_exists('register_sidebar')) {
      // Define Sidebar Widget Area 1
      register_sidebar(array(
        'id' => 'widget-area-1',
        'name' => __('Widgets area #1', 'wpeb'),
        'description' => __('Description for this widget-area...', 'wpeb'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h6>',
        'after_title' => '</h6>'
      ));

      // Define Sidebar Widget Area 2
      register_sidebar(array(
        'id' => 'widget-area-2',
        'name' => __('Widgets area #2', 'wpeb'),
        'description' => __('Description for this widget-area...', 'wpeb'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h6>',
        'after_title' => '</h6>'
      ));
    }
  }
  add_action('widgets_init', 'wpeb_register_sidebars');

  /**
   * WPEB Pagination
   */
  function wpeb_pagination()
  {
    global $wp_query;
    $big = 999999999;

    echo paginate_links(array(
      'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'prev_text' => __('« Previous', 'wpeb'),
      'next_text' => __('Next »', 'wpeb'),
      'total' => $wp_query->max_num_pages
    ));
  }
  add_action('init', 'wpeb_pagination');

