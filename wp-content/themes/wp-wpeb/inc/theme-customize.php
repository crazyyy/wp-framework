<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Setup theme options and customizations
*/

/**
 * Theme setup
 */
if (function_exists('add_theme_support')) {
  // Make the theme available for translation.
  load_theme_textdomain('wpeb', WPEB_TEMPLATE_PATH . '/languages');

  // Add Menu Support.
  add_theme_support('menus');

  /*
    * Enable support for Post Thumbnails on posts and pages.
    * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size(1568, 9999);

  // Define image sizes.
  add_image_size('large', 1200, '', true); // Large Thumbnail
  add_image_size('medium', 800, '', true); // Medium Thumbnail
  add_image_size('small', 300, '', true); // Small Thumbnail

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  // Add post-formats support.
  add_theme_support(
    'post-formats',
    [
      'link',
      'aside',
      'gallery',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat',
    ]
  );

  // Switch default core markup for search form, comment form, and comments to output valid HTML5.
  add_theme_support(
    'html5',
    [
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
      'navigation-widgets',
    ]
  );

  // Add support for core custom logo.
  $logo_width = 300;
  $logo_height = 100;
  add_theme_support(
    'custom-logo',
    [
      'height' => $logo_height,
      'width' => $logo_width,
      'flex-width' => true,
      'flex-height' => true,
      'unlink-homepage-logo' => true,
    ]
  );

  /**
   * Set up the WordPress core custom background feature.
   * This function adds support for custom backgrounds in the theme.
   * It allows users to set a custom background color or image for their site.
   */
  function wpeb_setup_custom_background(): void
  {
    $args = array(
      'default-color' => 'ffffff',
      'default-image' => '',
    );
    add_theme_support( 'custom-background', apply_filters( 'wpeb_custom_background_args', $args ) );
  }
  add_action( 'after_setup_theme', 'wpeb_setup_custom_background' );

  /*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
    */
  add_theme_support( 'title-tag' );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');

  // Add support for Block Styles.
  add_theme_support('wp-block-styles');

  // Add support for full and wide align images.
  add_theme_support('align-wide');

  // Add support for responsive embedded content.
  add_theme_support('responsive-embeds');

  // Add support for custom line height controls.
  add_theme_support('custom-line-height');

  // Add support for experimental link color control.
  add_theme_support('experimental-link-color');

  // Add support for experimental cover block spacing.
  add_theme_support('custom-spacing');

  // Add support for experimental custom units.
  add_theme_support('custom-units');

  // Remove feed icon link from legacy RSS widget.
  add_filter('rss_widget_feed_link', '__return_empty_string');

  /**
   * Set the content width in pixels, based on the theme's design and stylesheet.
   * This function sets the `$content_width` global variable, which is used
   * by WordPress to determine the maximum width of embedded media and images
   * to ensure proper layout and responsiveness.
   * @global int $content_width The content width variable.
   */
  function wpeb_set_content_width(): void
  {
    $GLOBALS['content_width'] = apply_filters( 'wpeb_content_width', 980 );
  }
  add_action( 'after_setup_theme', 'wpeb_set_content_width', 0 );
}

add_action('admin_init', function () {
  // Redirect any user trying to access comments page
  global $pagenow;

  if ($pagenow === 'edit-comments.php') {
    wp_safe_redirect(admin_url());
    exit;
  }

  // Remove comments metabox from dashboard
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

  // Disable support for comments and trackbacks in post types
  foreach (get_post_types() as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove the "Comments" admin menu.
function wpeb_hide_comments_menu(): void
{
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'wpeb_hide_comments_menu');

// Remove comments links from admin bar
function wpeb_remove_admin_bar_comments_menu () {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
}
add_action('init', 'wpeb_remove_admin_bar_comments_menu');

/**
 * Customize login logo for /wp-login.php and /wp-admin
 */
function wpeb_custom_login_logo(): void {
  // ToDo: If a custom logo is available in the customizer, use it
  echo '<style>
    h1 a {
      background-image: url("' . esc_url(WPEB_TEMPLATE_URL) . '/img/logo.svg") !important;
      background-size: 100% !important;
      width: 100% !important;
      background-position: center !important;
    }
  </style>';
}
add_action('login_head', 'wpeb_custom_login_logo');

/**
 * Customize login logo link for /wp-login.php and /wp-admin
 */
function wpeb_custom_login_link(): void {
  echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
      updateHrefAttribute();
    });
    function updateHrefAttribute() {
      const backToBlogLink = document.querySelector("#backtoblog a");
      const headerLink = document.querySelector("h1 a");
      if (backToBlogLink && headerLink) {
        headerLink.href = backToBlogLink.href;
      }
    }
  </script>';
}
add_action('login_head', 'wpeb_custom_login_link');

/**
 * Remove Admin bar.
 */
function wpeb_remove_admin_bar(): bool
{
  return false;
}
add_filter('show_admin_bar', 'wpeb_remove_admin_bar');

// To remove all the WordPress default items use the code given below.
function wpeb_remove_dashboard_meta() {
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
}
add_action( 'admin_init', 'wpeb_remove_dashboard_meta' );
