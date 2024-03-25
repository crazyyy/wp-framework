<?php
/**
 *  Author: Vitalii A | @knaipa
 *  URL: https://github.com/crazyyy/wp-framework
 *  Theme Menus Navigation and Widgets
 */

// ToDo: Test and add description
function wpeb_register_theme_menus() {
  $menus = array(
    array(
      'location'    => 'header-menu',
      'class'       => 'header',
      'wrapClass'   => 'header--menu',
      'name'        => __('Header Navigation', 'wpeb')
    ),
    array(
      'location'    => 'footer-menu',
      'class'       => 'footer',
      'wrapClass'   => 'footer--menu',
      'name'        => __('Footer Navigation', 'wpeb')
    ),
    array(
      'location'    => 'sidebar-menu',
      'class'       => 'sidebar',
      'wrapClass'   => 'sidebar--menu',
      'name'        => __('Sidebar Navigation', 'wpeb')
    )
  );

  foreach ($menus as $menu) {
    $location = $menu['location'];
    $class = $menu['class'];
    // $wrapClass = $menu['wrapClass'];
    $name = $menu['name'];

    // wp_nav_menu(
    //   array(
    //     'theme_location'  => $location,
    //     'container'       => false,
    //     'menu_class'      => 'menu',
    //     'echo'            => true,
    //     'fallback_cb'     => 'wp_page_menu',
    //     'items_wrap'      => '<ul class="' . $class . '_container">%3$s</ul>',
    //     'depth'           => 0,
    //   )
    // );

    register_nav_menu($location, $name);
  }
}
// ToDo: Fix broken menu initialization
add_action('init', 'wpeb_register_theme_menus');

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
