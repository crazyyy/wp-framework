<?php
  /*
    *  Author: Vitalii A | @knaipa
    *  URL: https://github.com/crazyyy/wp-framework
    *  Custom functions, support, custom post types and more.
  */

  /*------------------------------------*\
      Theme Setup
  \*------------------------------------*/

  $wpeb_version = '2023.05.24';

  if (!isset($content_width)) {
    $content_width = 980;
  }

  /*
    * Enable styles for WP Console Editor
  */
  function wpeb_editor_theme_style() {
    global $wpeb_version;
    wp_register_style('wpeb-editor-style', get_template_directory_uri() . '/css/wpeb-editor-style.css', array(), $wpeb_version);
    wp_enqueue_style('wpeb-editor-style');

    wp_register_script('wpeb-editor-script', get_template_directory_uri() . '/js/wpeb-editor-scripts.js', array(), $wpeb_version);
    wp_enqueue_script( 'wpeb-editor-script' );
  }
  add_action('admin_enqueue_scripts', 'wpeb_editor_theme_style');

  /*
    * Add Theme Stylesheet
  */
  function wpeb_theme_styles()  {
    global $wpeb_version;
    wp_dequeue_style('fancybox');

    wp_register_style('wpeb-style', get_template_directory_uri() . '/css/main.css', array(), $wpeb_version, 'all');
    wp_enqueue_style('wpeb-style');
  }
  add_action('wp_enqueue_scripts', 'wpeb_theme_styles'); //

  /*
    * Add Theme Header Scripts
    * to wp_head()
  */
  function wpeb_theme_header_scripts() {
    // wp_deregister_script('jquery');
    // wp_deregister_script('jquery-migrate');
    wp_deregister_script('modernizr');
    wp_deregister_script( 'jquery-form' );

    wp_register_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js', array(), '3.6.4');
    wp_enqueue_script('jquery');
  }
  add_action('wp_enqueue_scripts', 'wpeb_theme_header_scripts'); //

  /*
    * Add Theme Footer Scripts
    * to wp_footer()
  */
  function wpeb_theme_footer_scripts() {
    global $wpeb_version;
    wp_register_script('wpeb-scripts', get_template_directory_uri() . '/js/scripts.js', array(), $wpeb_version, true);
    wp_enqueue_script('wpeb-scripts');
    wp_localize_script( 'wpeb-scripts', 'adminAjax', array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'templatePath' => get_template_directory_uri(),
      'posts_per_page' => get_option('posts_per_page')
    ));
  }
  add_action('wp_enqueue_scripts', 'wpeb_theme_footer_scripts'); // Add Scripts to wp_head

  /*------------------------------------*\
      Theme Support
  \*------------------------------------*/

  if (function_exists('add_theme_support')) {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Twenty Twenty-One, use a find and replace
     * to change 'wpeb' to the name of your theme in all the template files.
     */
    load_theme_textdomain('wpeb', get_template_directory() . '/languages');

    // Add Menu Support
    add_theme_support('menus');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1568, 9999 );

    add_image_size('large', 1200, '', true); // Large Thumbnail
    add_image_size('medium', 600, '', true); // Medium Thumbnail
    add_image_size('small', 250, '', true); // Small Thumbnail

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /**
     * Add post-formats support.
     */
    add_theme_support(
      'post-formats',
      array(
        'link',
        'aside',
        'gallery',
        'image',
        'quote',
        'status',
        'video',
        'audio',
        'chat',
      )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
      'html5',
      array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
      )
    );

    /*
      * Let WordPress manage the document title.
      * This theme does not use a hard-coded <title> tag in the document head,
      * WordPress will provide it for us.
    */
    add_theme_support( 'title-tag' );

    /*
       * Add support for core custom logo.
       *
       * @link https://codex.wordpress.org/Theme_Logo
    */
    $logo_width  = 300;
    $logo_height = 100;

    add_theme_support(
      'custom-logo',
      array(
        'height'               => $logo_height,
        'width'                => $logo_width,
        'flex-width'           => true,
        'flex-height'          => true,
        'unlink-homepage-logo' => true,
      )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for responsive embedded content.
    add_theme_support( 'responsive-embeds' );

    // Add support for custom line height controls.
    add_theme_support( 'custom-line-height' );

    // Add support for experimental link color control.
    add_theme_support( 'experimental-link-color' );

    // Add support for experimental cover block spacing.
    add_theme_support( 'custom-spacing' );

    // Add support for custom units.
    // This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
    add_theme_support( 'custom-units' );

    // Remove feed icon link from legacy RSS widget.
    add_filter( 'rss_widget_feed_link', '__return_empty_string' );

  }

  /*
  * Add page slug to body class
  */
  function wpeb_add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
      $key = array_search('blog', $classes);
      if ($key > -1) {
        unset($classes[$key]);
      }
    } elseif (is_page()) {
      $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
      $classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
  }
  add_filter('body_class', 'wpeb_add_slug_to_body_class');

  /*------------------------------------*\
      Theme Menus
  \*------------------------------------*/
  /*
   * WPEB Header navigation
   */
  function wpeb_header_navigation() {
    wp_nav_menu(
    array(
      'theme_location'  => 'header-menu',
      'menu'            => '',
      'container'       => 'div',
      'container_class' => 'menu-{menu slug}-container',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul class="header--menu_container">%3$s</ul>',
      'depth'           => 0,
      'walker'          => ''
      )
    );
  }
  /*
   * WPEB Footer navigation
   */
  function wpeb_footer_navigation() {
    wp_nav_menu(
    array(
      'theme_location'  => 'footer-menu',
      'menu'            => '',
      'container'       => 'div',
      'container_class' => 'menu-{menu slug}-container',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul class="footer--menu_container">%3$s</ul>',
      'depth'           => 0,
      'walker'          => ''
      )
    );
  }
  /*
   * WPEB Sidebar navigation
   */
  function wpeb_sidebar_navigation() {
    wp_nav_menu(
    array(
      'theme_location'  => 'sidebar-menu',
      'menu'            => '',
      'container'       => 'div',
      'container_class' => 'menu-{menu slug}-container',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul class="sidebar--menu_container">%3$s</ul>',
      'depth'           => 0,
      'walker'          => ''
      )
    );
  }
  /*
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

  /*
   * Remove the <div> surrounding the dynamic WP Navigation to cleanup markup
   */
  function wpeb_wp_nav_menu_args($args = '') {
    $args['container'] = false;
    return $args;
  }
  add_filter('wp_nav_menu_args', 'wpeb_wp_nav_menu_args');

  /*
   * Remove Injected classes, ID's and Page ID's from Navigation <li> items
   */
  function wpeb_id_class_attr_filter($var) {
    return is_array($var) ? array() : '';
  }
  // add_filter('nav_menu_css_class', 'wpeb_id_class_attr_filter', 100, 1); // Remove Navigation <li> injected classes
  // add_filter('nav_menu_item_id', 'wpeb_id_class_attr_filter', 100, 1); // Remove Navigation <li> injected ID
  // add_filter('page_css_class', 'wpeb_id_class_attr_filter', 100, 1); // Remove Navigation <li> Page ID's

  /*------------------------------------*\
    Theme Widgets
  \*------------------------------------*/
  //  If Dynamic Sidebar Exists
  if ( function_exists('register_sidebar') ) {
    //  Define Sidebar Widget Area 1
    register_sidebar(array(
      'id' => 'widget-area-1',
      'name' => __('Widgets area #1', 'wpeb'),
      'description' => __('Description for this widget-area...', 'wpeb'),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
    ));

    //  Define Sidebar Widget Area 2.
    register_sidebar(array(
      'id' => 'widget-area-2',
      'name' => __('Widgets area #2', 'wpeb'),
      'description' => __('Description for this widget-area...', 'wpeb'),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
    ));
  }

  /*
   * Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
   */
  function wpeb_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links( array (
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'prev_text' => __('« Previous'),
        'next_text' => __('Next »'),
        'total' => $wp_query->max_num_pages
      )
    );
  }
  add_action('init', 'wpeb_pagination');

  /*
   * Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
   */
  function wpeb_remove_thumbnail_dimensions( $html ) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
  }
  add_filter('post_thumbnail_html', 'wpeb_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
  add_filter('image_send_to_editor', 'wpeb_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

  /*------------------------------------*\
    Theme Comments
  \*------------------------------------*/
  /*
   * Custom Gravatar in Settings > Discussion
   */
  function wpeb_default_gravatar ($avatar_defaults) {
    $default_gravatar = get_template_directory_uri() . '/img/gravatar.png';
    $avatar_defaults[$default_gravatar] = "Custom Gravatar";
    return $avatar_defaults;
  }
  add_filter('avatar_defaults', 'wpeb_default_gravatar');

  /*
   * Threaded Comments
   */
  function wpeb_enable_threaded_comments() {
    if (!is_admin()) {
      if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
        wp_enqueue_script('comment-reply');
      }
    }
  }
  add_action('get_header', 'wpeb_enable_threaded_comments'); // Enable Threaded Comments

  /*
   * Custom Comments Callback
   */
  function wpeb_blank_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }
  ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
      <?php if ( 'div' != $args['style'] ) : ?>
      <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
          <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
        <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a
            href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
            <?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' ); ?>
        </div>

        <?php comment_text() ?>

        <div class="reply">
          <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
        <?php if ( 'div' != $args['style'] ) : ?>
      </div>
    <?php endif;
  }

 /*
  * Turn off comments for WordPress media files
  */
  function wpeb_filter_media_comment_status( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' ) {
      return false;
    }
    return $open;
  }
  add_filter( 'comments_open', 'wpeb_filter_media_comment_status', 10 , 2 );

 /*
  * Redirect entry when a search query returns one result
  */
  function wpeb_single_search_result() {
    if (is_search()) {
      global $wp_query;
      if ($wp_query->post_count == 1) {
        wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
      }
    }
  }
  add_action('template_redirect', 'wpeb_single_search_result');

  /*
   * Breadcrumbs
   * <?php if ( function_exists('wpeb_breadcrumbs') ) { wpeb_breadcrumbs(); } ?>
   */
  function wpeb_breadcrumbs() {
    // Settings
    $separator = ' > ';
    $breadcrumbs_id = 'breadcrumbs';
    $breadcrumbs_class = 'breadcrumbs col-9';
    $home_title = __('Home', 'wpeasy');

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product-category';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

    // Build the breadcrumbs
    echo '<ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '">';
      // Home page
      echo '<li class="item-home">';
      echo '<a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a>';
      echo '</li>';
      echo '<li class="separator separator-home"> ' . $separator . ' </li>';

      if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
        echo '<li class="item-current item-archive">';
        echo '<span class="bread-current bread-archive">'. post_type_archive_title($prefix, false) .'</span>';
        echo '</li>';
      } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
        // If post is a custom post type
        $post_type = get_post_type();
        // If it is a custom post type display name and link
        if($post_type != 'post') {
          $post_type_object = get_post_type_object($post_type);
          $post_type_archive = get_post_type_archive_link($post_type);
          echo '<li class="item-cat item-custom-post-type-' . $post_type . '">';
          echo '<a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a>';
          echo '</li>';
          echo '<li class="separator"> ' . $separator . ' </li>';
        }
        $custom_tax_name = get_queried_object()->name;
        echo '<li class="item-current item-archive">';
        echo '<span class="bread-current bread-archive">' . $custom_tax_name .'</span>';
        echo '</li>';
      } else if ( is_single() ) {
      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if($post_type != 'post') {
      $post_type_object = get_post_type_object($post_type);
      $post_type_archive = get_post_type_archive_link($post_type);

      echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a
          class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '"
          title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
      echo '<li class="separator"> ' . $separator . ' </li>';
      }

      // Get post category info
      $category = get_the_category();

      if (!empty($category)) {
        // Get last category post is in
        $category_values = array_values($category);
        $last_category = end($category_values);

        // Get parent any categories and create array
        $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
        $cat_parents = explode(',', $get_cat_parents);

        // Loop through parent categories and store in variable $cat_display
        $cat_display = '';
        $cat_parents_count = count($cat_parents);
        foreach ($cat_parents as $index => $parents) {
          $cat_display .= '<li class="item-cat">' . $parents . '</li>
          <li class="separator"> ' . $separator . ' </li>';
          if ($index < $cat_parents_count - 1) {
            $cat_display .='<li class="separator"> ' . $separator . ' </li>' ;
          }
        }
      }

      // If it's a custom post type within a custom taxonomy $taxonomy_exists=taxonomy_exists($custom_taxonomy);
      if ( empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
        $taxonomy_terms=get_the_terms( $post->ID, $custom_taxonomy );
        $cat_id = $taxonomy_terms[0]->term_id;
        $cat_nicename = $taxonomy_terms[0]->slug;
        $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
        $cat_name = $taxonomy_terms[0]->name;
      }

      // Check if the post is in a category
      if(!empty($last_category)) {
        echo $cat_display;
        echo '<li class="item-current item-' . $post->ID . '">';
        echo '<span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span>';
        echo '</li>';
      } else if(!empty($cat_id)) {
        // Else if post is in a custom taxonomy
        echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '">';
        echo '<a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' .  $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a>';
        echo '</li>';
        echo '<li class="separator"> ' . $separator . ' </li>';
        echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"
          title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
      } else {
      echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"
          title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
      }
        } else if ( is_category() ) {
        // Category page
        echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . single_cat_title('', false) .
            '</span></li>';
        } else if ( is_page() ) {
        // Standard page
        if( $post->post_parent ){
        // If child page, get parents
        $anc = get_post_ancestors( $post->ID );
        // Get parents in the right order
        $anc = array_reverse($anc);
        // Parent page loop
        if ( !isset( $parents ) ) $parents = null;
        foreach ( $anc as $ancestor ) {
        $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a
            class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '"
            title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
        $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
        }

        // Display parent pages
        echo $parents;

        // Current page
        echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() .
            '</span></li>';
        } else {
        // Just display current page if not parents
        echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' .
            get_the_title() . '</span></li>';
        }
        } else if ( is_tag() ) {
        // Tag page
        // Get tag information
        $term_id = get_query_var('tag_id');
        $taxonomy = 'post_tag';
        $args = 'include=' . $term_id;
        $terms = get_terms( $taxonomy, $args );
        $get_term_id = $terms[0]->term_id;
        $get_term_slug = $terms[0]->slug;
        $get_term_name = $terms[0]->name;

        // Display the tag name
        echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span
            class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name .
            '</span></li>';
        } elseif ( is_day() ) {
        // Day archive
        // Year link
        echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a
            class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '"
            title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

        // Month link
        echo '<li class="item-month item-month-' . get_the_time('m') . '"><a
            class="bread-month bread-month-' . get_the_time('m') . '"
            href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' .
            get_the_time('M') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

        // Day display
        echo '<li class="item-current item-' . get_the_time('j') . '"><span
            class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . '
            Archives</span></li>';
        } else if ( is_month() ) {
        // Month Archive
        // Year link
        echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a
            class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '"
            title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
        // Month display
        echo '<li class="item-month item-month-' . get_the_time('m') . '"><span
            class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' .
            get_the_time('M') . ' Archives</span></li>';
        } else if ( is_year() ) {
        // Display year archive
        echo '<li class="item-current item-current-' . get_the_time('Y') . '"><span
            class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' .
            get_the_time('Y') . ' Archives</span></li>';
        } else if ( is_author() ) {
        // Author archive
        // Get the author information
        global $author;
        $userdata = get_userdata( $author );
        // Display author name
        echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span
            class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">'
            . 'Author: ' . $userdata->display_name . '</span></li>';
        } else if ( get_query_var('paged') ) {
        // Paginated archives
        echo '<li class="item-current item-current-' . get_query_var('paged') . '"><span
            class="bread-current bread-current-' . get_query_var('paged') . '"
            title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</span></li>';
        } else if ( is_search() ) {
        // Search results page
        echo '<li class="item-current item-current-' . get_search_query() . '"><span
            class="bread-current bread-current-' . get_search_query() . '"
            title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</span>
        </li>';
        } elseif ( is_404() ) {
        // 404 page
        echo '<li>' . 'Error 404' . '</li>';
        }
        echo '
    </ul>';
    }
  }
  // end wpeb_breadcrumbs()

  /*
   * remove the /./ from links, use this filter
   * https://stackoverflow.com/questions/17798815/remove-category-tag-base-from-wordpress-url-without-a-plugin
   */
  add_filter( 'term_link', function($termlink){
    return str_replace('/./', '/', $termlink);
  }, 10, 1 );

  /*------------------------------------*\
    Theme Cleanup
  \*------------------------------------*/

  /*
   * Remove Admin bar
   */
  function wpeb_remove_admin_bar() { return false; }
  add_filter('show_admin_bar', 'wpeb_remove_admin_bar');

  /*
   * Remove inline Recent Comment Styles from wp_head()
  */
  function wpeb_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
    ));
  }
  // add_action('widgets_init', 'wpeb_remove_recent_comments_style');

  /*
   * Remove invalid rel attribute values in the categorylist
   */
  function wpeb_emove_category_rel_from_category_list($thelist) {
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
  }
  add_filter('the_category', 'wpeb_emove_category_rel_from_category_list');

  /*
  * Disable WP Emoji Icons
  */
  function wpeb_disable_wp_emoji_icons() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', 'wpeb_disable_wp_emoji_icons_tinymce' );
  }
  function wpeb_disable_wp_emoji_icons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
  add_action( 'init', 'wpeb_disable_wp_emoji_icons' );

  /*
  * Remove 'text/css' from our enqueued stylesheet
  */
  function wpeb_style_cleanup($tag) {
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
  }
  add_filter('style_loader_tag', 'wpeb_style_cleanup');

  // Remove Actions
  remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
  remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
  remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
  remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
  remove_action('wp_head', 'index_rel_link'); // Index link
  remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
  remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
  remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

  // Add Filters
  add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
  add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
  add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
  add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)

  // Remove Filters
  remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

  /*------------------------------------*\
    Other Configs
  \*------------------------------------*/

  /*
    * ACF Google Maps API Key
  */
  function wpeb_acf_init() {
    acf_update_setting('google_api_key', 'TOKEN');
  }
  add_action('acf/init', 'wpeb_acf_init');

  /*
  * Change /wp-login.php and /wp-admin logo image
  */
  function wpeb_custom_login_logo() {
    echo '<style type="text/css">
      h1 a {
        background-image: url("'. get_bloginfo('template_directory'). '/img/logo.svg") !important;
        background-size: 100% !important;
        width: 100% !important;
        background-position: center !important;
      }
    </style>';
  }
  add_action('login_head', 'wpeb_custom_login_logo');

  /*
   * Change /wp-login.php and /wp-admin logo link
   */
  function wpeb_custom_login_link() {
    echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
        updateHrefAttribute();
      });
      function updateHrefAttribute() {
        // Check if both elements exist
        const backToBlogLink = document.querySelector("#backtoblog a");
        const headerLink = document.querySelector("h1 a");
        if (backToBlogLink && headerLink) {
          // Get the href attribute value from #backtoblog a
          const hrefValue = backToBlogLink.getAttribute("href");
          // Set the href attribute in h1 a
          headerLink.setAttribute("href", hrefValue);
        }
      }
    </script>';
  }
  add_action('login_head', 'wpeb_custom_login_link');

  /*------------------------------------*\
    Helper Functions
  \*------------------------------------*/

  /*
    * Catch first image from post and display it
    * wpeb_catch_first_image();
    * <?php echo wpeb_catch_first_image(); ?>
  */
  function wpeb_catch_first_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
      $post->post_content, $matches);
    $first_img = $matches [1] [0];
    if ( empty($first_img) ) {
      $first_img = get_template_directory_uri() . '/img/noimage.png'; }
    return $first_img;
  }

  /*
  * Custom Excerpts Size
  */
  function wpeb_excerpt_10($length) { return 10; }
  function wpeb_excerpt_20($length) { return 20; }
  function wpeb_excerpt_40($length) { return 40; }
  /*
   * Create the Custom Excerpts callback
   */
  function wpeb_excerpt($length_callback = '', $more_callback = '') {
    global $post;
    if (function_exists($length_callback)) {
      add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
      add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
  }

  /*
   * Custom View Article link to Post
   * Add 'View Article' button instead of [...] for Excerpts
   */
  function wpeb_blank_view_article($more) {
    global $post;
    return '... <a rel="nofollow" class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'wpeb') . '</a>';
  }
  add_filter('excerpt_more', 'wpeb_blank_view_article');

  /*
   * Add Featured Image Column in WordPress Admin
   * https://bloggerpilot.com/en/featured-image-admin-en/
   */
  // Set thumbnail size
  add_image_size( 'wpeb-admin-featured-image', 60, 60, false );

  // Add the posts and pages columns filter. Same function for both.
  add_filter('manage_posts_columns', 'wpeb_add_thumbnail_column', 2);
  add_filter('manage_pages_columns', 'wpeb_add_thumbnail_column', 2);
  function wpeb_add_thumbnail_column($wpeb_columns){
    $wpeb_columns['wpeb_thumb'] = __('Image');
    return $wpeb_columns;
  }

  // Add featured image thumbnail to the WP Admin table.
  function wpeb_show_thumbnail_column($wpeb_columns, $wpeb_id){
    switch($wpeb_columns){
      case 'wpeb_thumb':
        if( function_exists('the_post_thumbnail') )
          echo the_post_thumbnail( 'wpeb_admin-featured-image' );
        break;
    }
  }
  add_action('manage_posts_custom_column', 'wpeb_show_thumbnail_column', 5, 2);
  add_action('manage_pages_custom_column', 'wpeb_show_thumbnail_column', 5, 2);

  // Move the new column at the first place.
  function wpeb_column_order($columns) {
    $n_columns = array();
    $move = 'wpeb_thumb'; // which column to move
    $before = 'title'; // move before this column

    foreach($columns as $key => $value) {
      if ($key==$before){
        $n_columns[$move] = $move;
      }
      $n_columns[$key] = $value;
    }
    return $n_columns;
  }
  add_filter('manage_posts_columns', 'wpeb_column_order');

  // Format the column width with CSS
  function wpeb_add_admin_styles() {
    echo '<style>.column-wpeb-thumb {width: 60px;}</style>';
  }
  add_action('admin_head', 'wpeb_add_admin_styles');
