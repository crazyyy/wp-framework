<?php
/**
  *  Author: Vitalii A | @knaipa
  *  URL: https://github.com/crazyyy/wp-framework
  *  Helper Functions for theme
*/

/**
 * Add page slug to body class
 */
function wpeb_add_slug_to_body_class($classes) {
  global $post;

  if (is_home()) {
    $key = array_search('blog', $classes, true);
    if ($key !== false) {
      unset($classes[$key]);
    }
  } elseif (is_page() || is_singular()) {
    $classes[] = sanitize_html_class($post->post_name);
  }

  return $classes;
}
add_filter('body_class', 'wpeb_add_slug_to_body_class');

/**
 * Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
 */
function wpeb_remove_thumbnail_dimensions($html): array|string|null
{
  return preg_replace('/(width|height)=\"\d*\"\s/', '', $html);
}
// Remove width and height dynamic attributes from thumbnails
add_filter('post_thumbnail_html', 'wpeb_remove_thumbnail_dimensions', 10);
// Remove width and height dynamic attributes from post images
add_filter('image_send_to_editor', 'wpeb_remove_thumbnail_dimensions', 10);

/**
 * Custom Gravatar in Settings > Discussion
 */
function wpeb_default_gravatar($avatar_defaults) {
  $default_gravatar = get_template_directory_uri() . '/img/gravatar.png';
  $avatar_defaults[$default_gravatar] = __('Custom Gravatar', 'wpeb');
  return $avatar_defaults;
}
add_filter('avatar_defaults', 'wpeb_default_gravatar');

/**
 * Enable Threaded Comments
 */
function wpeb_enable_threaded_comments() {
  if (!is_admin() && is_singular() && comments_open() && (get_option('thread_comments') === 1)) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('get_header', 'wpeb_enable_threaded_comments');

/**
 * Custom Comments Callback
 */
function wpeb_custom_comments_callback($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  extract($args, EXTR_SKIP);

  if ('div' === $args['style']) {
    $tag = 'div';
    $add_below = 'comment';
  } else {
    $tag = 'li';
    $add_below = 'div-comment';
  }
  ?>
  <!-- heads up: starting < for the html tag (li or div) in the next line: -->
  <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
  <?php if ('div' !== $args['style']) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
  <?php endif; ?>
  <div class="comment-author vcard">
    <?php if ($args['avatar_size'] !== 0) {
      echo get_avatar($comment, $args['180']);
    } ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">'. __('says:', 'wpeb') .'</span>'), get_comment_author_link()) ?>
  </div>
  <?php if ($comment->comment_approved === '0') : ?>
    <em class="comment-awaiting-moderation"><?php __('Your comment is awaiting moderation.', 'wpeb') ?></em>
  <?php endif; ?>

  <div class="comment-meta comment-metadata">
    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
      <?php printf(__(' %1$s at %2$s', 'wpeb'), get_comment_date(), get_comment_time()) ?>
    </a>
    <?php edit_comment_link(__('(Edit)', 'wpeb'), '  ', ''); ?>
  </div>

  <?php comment_text() ?>

  <div class="reply">
    <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  </div>
  <?php if ('div' !== $args['style']) : ?>
    </div>
  <?php endif;
}

/**
 * Disable comments for WordPress media files
 */
function wpeb_disable_media_comments($open, $post_id) {
  $post = get_post($post_id);
  if ($post->post_type === 'attachment') {
    return false;
  }
  return $open;
}
add_filter('comments_open', 'wpeb_disable_media_comments', 10, 2);

/**
 * Redirect to single entry when search returns one result
 */
function wpeb_redirect_single_search_result() {
  if (is_search()) {
    global $wp_query;
    if ($wp_query->post_count === 1) {
      wp_redirect(get_permalink($wp_query->posts[0]->ID));
      exit;
    }
  }
}
add_action('template_redirect', 'wpeb_redirect_single_search_result');

/**
 * Displays Breadcrumbs based on the current page.
 * Usage: <?php if (function_exists('wpeb_breadcrumbs')) { wpeb_breadcrumbs(); } ?>
 * @param array $args Optional arguments to customize the breadcrumbs.
 */
function wpeb_breadcrumbs(array $args = []): void
{
  // Default arguments
  $defaults = [
    'separator' => ' > ',
    'id' => 'breadcrumbs',
    'class' => 'breadcrumbs col-9',
    'home_title' => __('Home', 'wpeb'),
  ];
  $args = wp_parse_args($args, $defaults);

  // Get the query & post information
  global $post, $wp_query;

  // Do not display on the homepage
  if (!is_front_page()) {

    // Build the breadcrumbs
    echo '<ul id="' . esc_attr($args['id']) . '" class="' . esc_attr($args['class']) . '">';

    // Home page
    echo '<li class="item-home">';
    echo '<a class="bread-link bread-home" href="' . esc_url(get_home_url()) . '" title="' . esc_attr($args['home_title']) . '">' . esc_html($args['home_title']) . '</a>';
    echo '</li>';

    // Separator
    echo '<li class="separator separator-home">' . esc_html($args['separator']) . '</li>';

    if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
      // Archive page
      echo '<li class="item-current item-archive">';
      echo '<span class="bread-current bread-archive">' . esc_html(post_type_archive_title('', false)) . '</span>';
      echo '</li>';
    } elseif (is_archive() && is_tax() && !is_category() && !is_tag()) {
      // Custom post type archive with taxonomy
      $post_type = get_post_type();
      if ($post_type !== 'post') {
        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '">';
        echo '<a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_html($post_type_object->labels->name) . '</a>';
        echo '</li>';

        echo '<li class="separator">' . esc_html($args['separator']) . '</li>';
      }

      $custom_tax_name = get_queried_object()->name;

      echo '<li class="item-current item-archive">';
      echo '<span class="bread-current bread-archive">' . esc_html($custom_tax_name) . '</span>';
      echo '</li>';
    } elseif (is_single()) {
      // Single post
      $post_type = get_post_type();
      if ($post_type !== 'post') {
        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="item-cat item-custom-post-type-' . esc_attr($post_type) . '">';
        echo '<a class="bread-cat bread-custom-post-type-' . esc_attr($post_type) . '" href="' . esc_url($post_type_archive) . '" title="' . esc_attr($post_type_object->labels->name) . '">' . esc_html($post_type_object->labels->name) . '</a>';
        echo '</li>';

        echo '<li class="separator">' . esc_html($args['separator']) . '</li>';
      }

      $category = get_the_category();
      if (!empty($category)) {
        $category_values = array_values($category);
        $last_category = end($category_values);
        $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
        $cat_parents = explode(',', $get_cat_parents);

        foreach ($cat_parents as $index => $parents) {
          echo '<li class="item-cat">' . wp_kses_post($parents) . '</li>';
          if ($index < count($cat_parents) - 1) {
            echo '<li class="separator">' . esc_html($args['separator']) . '</li>';
          }
        }
      }

      $taxonomy_exists = taxonomy_exists($args['custom_taxonomy']);
      if (empty($last_category) && !empty($args['custom_taxonomy']) && $taxonomy_exists) {
        $taxonomy_terms = get_the_terms($post->ID, $args['custom_taxonomy']);
        if ($taxonomy_terms && !is_wp_error($taxonomy_terms)) {
          $cat_id = $taxonomy_terms[0]->term_id;
          $cat_nicename = $taxonomy_terms[0]->slug;
          $cat_link = get_term_link($taxonomy_terms[0]->term_id, $args['custom_taxonomy']);
          $cat_name = $taxonomy_terms[0]->name;

          echo '<li class="item-cat item-cat-' . esc_attr($cat_id) . ' item-cat-' . esc_attr($cat_nicename) . '">';
          echo '<a class="bread-cat bread-cat-' . esc_attr($cat_id) . ' bread-cat-' . esc_attr($cat_nicename) . '" href="' . esc_url($cat_link) . '" title="' . esc_attr($cat_name) . '">' . esc_html($cat_name) . '</a>';
          echo '</li>';

          echo '<li class="separator">' . esc_html($args['separator']) . '</li>';
        }
      }

      echo '<li class="item-current item-' . esc_attr($post->ID) . '">';
      echo '<span class="bread-current bread-' . esc_attr($post->ID) . '" title="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</span>';
      echo '</li>';
    } elseif (is_category()) {
      // Category page
      echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . esc_html(single_cat_title('', false)) . '</span></li>';
    } elseif (is_page()) {
      // Page
      $parents = null;
      if ($post->post_parent) {
        $anc = get_post_ancestors($post->ID);
        $anc = array_reverse($anc);

        foreach ($anc as $ancestor) {
          echo '<li class="item-parent item-parent-' . esc_attr($ancestor) . '"><a class="bread-parent bread-parent-' . esc_attr($ancestor) . '" href="' . esc_url(get_permalink($ancestor)) . '" title="' . esc_attr(get_the_title($ancestor)) . '">' . esc_html(get_the_title($ancestor)) . '</a></li>';
          echo '<li class="separator separator-' . esc_attr($ancestor) . '">' . esc_html($args['separator']) . '</li>';
        }

        echo '<li class="item-current item-' . esc_attr($post->ID) . '"><span title="' . esc_attr(get_the_title()) . '"> ' . esc_html(get_the_title()) . '</span></li>';
      } else {
        echo '<li class="item-current item-' . esc_attr($post->ID) . '"><span class="bread-current bread-' . esc_attr($post->ID) . '"> ' . esc_html(get_the_title()) . '</span></li>';
      }
    } elseif (is_tag()) {
      // Tag page
      $term_id = get_query_var('tag_id');
      $taxonomy = 'post_tag';
      $args = 'include=' . $term_id;
      $terms = get_terms($taxonomy, $args);

      if ($terms && !is_wp_error($terms)) {
        $get_term_id = $terms[0]->term_id;
        $get_term_slug = $terms[0]->slug;
        $get_term_name = $terms[0]->name;

        echo '<li class="item-current item-tag-' . esc_attr($get_term_id) . ' item-tag-' . esc_attr($get_term_slug) . '"><span class="bread-current bread-tag-' . esc_attr($get_term_id) . ' bread-tag-' . esc_attr($get_term_slug) . '">' . esc_html($get_term_name) . '</span></li>';
      }
    } elseif (is_day()) {
      // Day archive
      echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_html(get_the_time('Y')) . ' Archives</a></li>';
      echo '<li class="separator separator-' . esc_attr(get_the_time('Y')) . '">' . esc_html($args['separator']) . '</li>';
      echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><a class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '" title="' . esc_attr(get_the_time('M')) . '">' . esc_html(get_the_time('M')) . ' Archives</a></li>';
      echo '<li class="separator separator-' . esc_attr(get_the_time('m')) . '">' . esc_html($args['separator']) . '</li>';
      echo '<li class="item-current item-' . esc_attr(get_the_time('j')) . '"><span class="bread-current bread-' . esc_attr(get_the_time('j')) . '"> ' . esc_html(get_the_time('jS')) . ' ' . esc_html(get_the_time('M')) . ' Archives</span></li>';
    } elseif (is_month()) {
      // Month archive
      echo '<li class="item-year item-year-' . esc_attr(get_the_time('Y')) . '"><a class="bread-year bread-year-' . esc_attr(get_the_time('Y')) . '" href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_html(get_the_time('Y')) . ' Archives</a></li>';
      echo '<li class="separator separator-' . esc_attr(get_the_time('Y')) . '">' . esc_html($args['separator']) . '</li>';
      echo '<li class="item-month item-month-' . esc_attr(get_the_time('m')) . '"><span class="bread-month bread-month-' . esc_attr(get_the_time('m')) . '" title="' . esc_attr(get_the_time('M')) . '">' . esc_html(get_the_time('M')) . ' Archives</span></li>';
    } elseif (is_year()) {
      // Year archive
      echo '<li class="item-current item-current-' . esc_attr(get_the_time('Y')) . '"><span class="bread-current bread-current-' . esc_attr(get_the_time('Y')) . '" title="' . esc_attr(get_the_time('Y')) . '">' . esc_html(get_the_time('Y')) . ' Archives</span></li>';
    } elseif (is_author()) {
      // Author archive
      global $author;
      $userdata = get_userdata($author);
      echo '<li class="item-current item-current-' . esc_attr($userdata->user_nicename) . '"><span class="bread-current bread-current-' . esc_attr($userdata->user_nicename) . '" title="' . esc_attr($userdata->display_name) . '">Author: ' . esc_html($userdata->display_name) . '</span></li>';
    } elseif (get_query_var('paged')) {
      // Paginated archives
      echo '<li class="item-current item-current-' . esc_attr(get_query_var('paged')) . '"><span class="bread-current bread-current-' . esc_attr(get_query_var('paged')) . '" title="Page ' . esc_attr(get_query_var('paged')) . '">' . __('Page', 'wpeb') . ' ' . esc_html(get_query_var('paged')) . '</span></li>';
    } elseif (is_search()) {
      // Search results page
      echo '<li class="item-current item-current-' . esc_attr(get_search_query()) . '"><span class="bread-current bread-current-' . esc_attr(get_search_query()) . '" title="Search results for: ' . esc_attr(get_search_query()) . '">Search results for: ' . esc_html(get_search_query()) . '</span></li>';
    } elseif (is_404()) {
      // 404 page
      echo '<li>' . esc_html__('Error 404', 'wpeb') . '</li>';
    }

    echo '</ul>';
  }
}

/**
 * Remove the /./ from links.
 * @param string $termlink The term link.
 * @return string The modified term link.
 */
function wpeb_remove_term_link_dot(string $termlink): string
{
  return str_replace('/./', '/', $termlink);
}
add_filter('term_link', 'wpeb_remove_term_link_dot');

/**
 * Remove inline Recent Comment Styles from wp_head().
 */
function wpeb_remove_recent_comments_style() {
  global $wp_widget_factory;

  remove_action(
    'wp_head',
    array(
      $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
      'recent_comments_style'
    )
  );
}
// add_action('widgets_init', 'wpeb_remove_recent_comments_style');

/**
 * Remove invalid rel attribute values in the category list.
 * @param string $the_list The category list.
 * @return string The modified category list.
 */
function wpeb_remove_category_rel_from_category_list(string $the_list): string
{
  return str_replace('rel="category tag"', 'rel="tag"', $the_list);
}
add_filter('the_category', 'wpeb_remove_category_rel_from_category_list');

/**
 * Disable WP Emoji Icons.
 */
function wpeb_disable_wp_emoji_icons() {
  // Remove actions related to emojis
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');

  // Add filter to remove TinyMCE emojis
  add_filter('tiny_mce_plugins', 'wpeb_disable_wp_emoji_icons_tinymce');
}
/**
 * Filter to disable WP Emoji Icons in TinyMCE.
 * @param array $plugins Array of TinyMCE plugins.
 * @return array Modified array of TinyMCE plugins.
 */
function wpeb_disable_wp_emoji_icons_tinymce(array $plugins): array
{
  return array_diff($plugins, array('wpemoji'));
}
add_action('init', 'wpeb_disable_wp_emoji_icons');

/**
 * Remove 'text/css' from enqueued stylesheets.
 * @param string $tag The HTML tag for the stylesheet.
 * @return string Modified HTML tag without 'text/css'.
 */
function wpeb_style_cleanup(string $tag): string
{
  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
add_filter('style_loader_tag', 'wpeb_style_cleanup');

/**
 * Remove unnecessary actions from wp_head.
 */
function wpeb_remove_unnecessary_actions() {
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
}
add_action('init', 'wpeb_remove_unnecessary_actions');

/**
 * Add filters to enable shortcodes and remove unnecessary <p> tags.
 */
function wpeb_add_shortcodes_filters() {
  add_filter('widget_text', 'do_shortcode');
  add_filter('the_excerpt', 'do_shortcode');
  add_filter('widget_text_content', 'shortcode_unautop');
  add_filter('the_excerpt', 'shortcode_unautop');
  remove_filter('the_excerpt', 'wpautop');
}
add_action('init', 'wpeb_add_shortcodes_filters');

/**
 * Retrieves the first image from a post and returns its URL.
 *
 * @global WP_Post $post The current post object.
 * @return string The URL of the first image or a default image URL if none is found.
 */
function wpeb_catch_first_image(): string
{
  global $post;
  // Start output buffering to discard any content
  ob_start();
  ob_end_clean();

  // Extract the first image URL using regular expressions
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  // If no image is found, use a default image URL
  if (empty($first_img)) {
    $first_img = get_template_directory_uri() . '/img/noimage.png';
  }

  return $first_img;
}

/**
 * Custom Excerpts Size
 * @param int $length The length of the excerpt.
 * @return int The modified length of the excerpt.
 */
function wpeb_excerpt_40(int $length): int
{
  return 40;
}

/**
 * Create the Custom Excerpts callback
 * @param callable|string $length_callback The callback function to set the excerpt length.
 * @param callable|string $more_callback The callback function to modify the "read more" link.
 */
function wpeb_excerpt(callable|string $length_callback = '', callable|string $more_callback = ''): void
{
  global $post;

  if (is_callable($length_callback)) {
    add_filter('excerpt_length', $length_callback);
  }

  if (is_callable($more_callback)) {
    add_filter('excerpt_more', $more_callback);
  }

  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';

  echo $output;
}

/**
 * Modifies the excerpt more link to display a 'View Article' button.
 * @param string $more The default excerpt more link.
 * @return string The modified excerpt more link.
 */
function wpeb_modify_excerpt_more(string $more): string
{
  global $post;

  // Create the 'View Article' button with the post permalink
  $view_article_link = sprintf(
    ' <a rel="nofollow" class="view-article" href="%s">%s</a>',
    get_permalink($post->ID),
    __('View Article', 'wpeb')
  );

  // Append the 'View Article' button to the excerpt more link
  return '...' . $view_article_link;
}
add_filter('excerpt_more', 'wpeb_modify_excerpt_more');

/**
 * Add thumbnail column to the admin table.
 * @param $wpeb_columns
 * @return array The modified columns with the added thumbnail column.
 */
function wpeb_add_thumbnail_column($wpeb_columns): array
{
  $wpeb_columns['wpeb_thumb'] = __('Featured Image', 'wpeb');
  return $wpeb_columns;
}
/**
 * Add Featured Image Column in WordPress Admin
 * This code adds a thumbnail column to the posts and pages admin table, displaying the featured image.
 * Source: https://bloggerpilot.com/en/featured-image-admin-en/
 */
// Add the posts and pages columns filter. Same function for both.
add_filter( 'manage_posts_columns', 'wpeb_add_thumbnail_column', 10, 1 );
add_filter( 'manage_pages_columns', 'wpeb_add_thumbnail_column', 10, 1 );

/**
 * Display the featured image thumbnail in the admin table.
 * @param $wpeb_columns
 * @param $wpeb_id
 */
function wpeb_show_thumbnail_column($wpeb_columns, $wpeb_id): void
{
  if ($wpeb_columns === 'wpeb_thumb' && function_exists('the_post_thumbnail')) {
    if (has_post_thumbnail($wpeb_id)) {
      echo the_post_thumbnail('post-thumbnail');
    } else {
      // SVG code for "NO IMAGE AVAILABLE" icon
      echo '<svg xmlns="http://www.w3.org/2000/svg" height="300" width="300" viewBox="-300 -300 600 600" font-family="Bitstream Vera Sans,Liberation Sans, Arial, sans-serif" font-size="72" text-anchor="middle"><circle stroke="#AAA" stroke-width="10" r="280" fill="#FFF"/><switch style="fill:#444"><text><tspan x="0" y="-8">NO IMAGE</tspan><tspan x="0" y="80">AVAILABLE</tspan></text></switch></svg>';
    }
  }
}

// Add featured image thumbnail to the WP Admin table.
add_action( 'manage_posts_custom_column', 'wpeb_show_thumbnail_column', 10, 2 );
add_action( 'manage_pages_custom_column', 'wpeb_show_thumbnail_column', 10, 2 );

/**
 * Reorder the admin table columns.
 * @param array $columns The existing columns in the admin table.
 * @return array The modified columns with the thumbnail column moved to the first position.
 */
function wpeb_column_order(array $columns): array
{
  $n_columns = array();
  $move = 'wpeb_thumb'; // which column to move
  $before = 'title'; // move before this column

  foreach($columns as $key => $value) {
    if ($key === $before){
      $n_columns[$move] = $move;
    }
    $n_columns[$key] = $value;
  }
  return $n_columns;
}
// Move the new column to the first position.
add_filter( 'manage_posts_columns', 'wpeb_column_order', 10, 1 );

/**
 * Add custom admin styles.
 */
function wpeb_add_admin_styles(): void
{
  echo '<style>#wpeb_thumb, .attachment-post-thumbnail.size-post-thumbnail {width: 140px;} .wpeb_thumb svg {width: 100%; height: auto;}</style>';
}

// Format the column width with CSS
add_action( 'admin_head', 'wpeb_add_admin_styles' );
