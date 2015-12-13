<?php
/*
 *  Author: knaipa | @Saitobaza
 *  URL: saitobaza.ru
 *  Custom functions, support, custom post types and more.
 */

//  Enable styles for WP admin panel
function wpeAdminThemeStyle() {
  wp_enqueue_style('wpe-admin-style', get_template_directory_uri() . '/css/admin.css');
  wp_enqueue_style('wpe-admin-script', get_template_directory_uri() . '/js/admin.js');
  wp_enqueue_style('wpe-admin-style', get_template_directory_uri() . '/css/editor-style.css');
}
add_action('admin_enqueue_scripts', 'wpeAdminThemeStyle');

//  Catch first image from post and display it
function catchFirstImage() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
    $post->post_content, $matches);
  $first_img = $matches [1] [0];
  if(empty($first_img)){
    $first_img = get_template_directory_uri() . '/img/noimage.jpg'; }
    return $first_img;
}

function wpeStyles()  {

  wp_dequeue_style('fancybox');
  wp_dequeue_style('wp_dequeue_style');

  wp_register_style('wpeasy-style', get_template_directory_uri() . '/css/main.css', array(), '1.0', 'all');
  wp_enqueue_style('wpeasy-style'); // Enqueue it!
}
function wpeHeaderScripts() {
  if (!is_admin()) {
    wp_deregister_script('jquery'); // Deregister WordPress jQuery   RU: Отключаю стандартный JQuery WordPress'а
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', array(), '1.11.0'); // Google CDN jQuery   RU: Регистрирую JQuery с хостинга Google
    wp_enqueue_script('jquery'); // Enqueue it!    RU: Подключаю его

    wp_register_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', array(), '2.8.3'); // Modernizr
    wp_enqueue_script('modernizr'); // Enqueue it!

wp_deregister_script( 'jquery-form' );


    //  Load footer scripts (footer.php)
    wp_register_script('wpeScripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0', true); // Custom scripts
    wp_enqueue_script('wpeScripts'); // Enqueue it!
  }
}

//  Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action('wp_head', array(
    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
    'recent_comments_style'
  ));
}

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width)) {
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
  // Add Menu Support
  add_theme_support('menus');

  // Add Thumbnail Theme Support
  add_theme_support('post-thumbnails');
  add_image_size('large', 1200, '', true); // Large Thumbnail
  add_image_size('medium', 600, '', true); // Medium Thumbnail
  add_image_size('small', 250, '', true); // Small Thumbnail
  add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

  // Enables post and comment RSS feed links to head
  add_theme_support('automatic-feed-links');

  // Localisation Support
  load_theme_textdomain('wpeasy', get_template_directory() . '/languages');
}

// WPE head navigation
function wpeHeadNav()
{
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
    'items_wrap'      => '<ul class="headnav">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    )
  );
}
// WPE footer navigation
function wpeFootNav() {
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
    'items_wrap'      => '<ul class="footernav">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    )
  );
}
// WPE sidebar navigation
function wpeSideNav() {
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
    'items_wrap'      => '<ul class="sidebarnav">%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    )
  );
}
//  Register WPE Navigation
function register_html5_menu() {
  register_nav_menus(array(
    'header-menu' => __('Меню в шапке', 'wpeasy'),
    'sidebar-menu' => __('Меню в сайдбар', 'wpeasy'),
    'footer-menu' => __('Меню в подвал', 'wpeasy')
  ));
}
//  If Dynamic Sidebar Existsов
if (function_exists('register_sidebar')) {
  //  Define Sidebar Widget Area 1
  register_sidebar(array(
    'name' => __('Блок виджетов #1', 'wpeasy'),
    'description' => __('Description for this widget-area...', 'wpeasy'),
    'id' => 'widgetarea1',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h6>',
    'after_title' => '</h6>'
  ));
  //  Define Sidebar Widget Area 2. If your want to display more widget - uncoment this
  /*
  register_sidebar(array(
    'name' => __('Блок виджетов #2', 'wpeasy'),
    'description' => __('Description for this widget-area...', 'wpeasy'),
    'id' => 'widgetarea2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h6>',
    'after_title' => '</h6>'
  ));
  */
}

//  Custom Excerpts
//  RU: Произвольное обрезание текста
function wpeExcerpt10($length) {
  return 10;
}
function wpeExcerpt20($length) {
  return 20;
}
function wpeExcerpt40($length) {
  return 40;
}
//  Create the Custom Excerpts callback
//  RU: Собственная обрезка контента
function wpeExcerpt($length_callback = '', $more_callback = '') {
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

//  Custom View Article link to Post
//  RU: Добавляем "Читать дальше" к обрезанным записям
/*
function html5_blank_view_article($more) {
  global $post;
  return '... <!-- noindex --><a rel="nofollow" class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'wpeasy') . '</a><!-- /noindex -->';
}
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
*/
// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var) {
  return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist) {
  return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
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

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
  global $wp_query;
  $big = 999999999;
  echo paginate_links(array(
    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $wp_query->max_num_pages
  ));
}

// Remove Admin bar
function remove_admin_bar() {
  return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag) {
  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
  return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults) {
  $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
  $avatar_defaults[$myavatar] = "Custom Gravatar";
  return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments() {
  if (!is_admin()) {
    if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script('comment-reply');
    }
  }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth) {
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

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
      <?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' ); ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
      <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
      <?php if ( 'div' != $args['style'] ) : ?>
    </div>
  <?php endif; ?>
<?php }

// Add Actions
add_action('init', 'wpeHeaderScripts'); // Add Scripts to wp_head
add_action('wp_enqueue_scripts', 'wpeStyles'); // Add Theme Stylesheet
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

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
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)

add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

 // Как отключить комментарии для Медиафайлов WordPress
 // http://wordpresso.org/hacks/kak-otklyuchit-kommentarii-dlya-mediafaylov-wordpress/
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );
function filter_media_comment_status( $open, $post_id ) {
  $post = get_post( $post_id );
  if( $post->post_type == 'attachment' ) {
    return false;
  }
  return $open;
}


 // Редирект записи, когда поисковый запрос выдает один результат
 // http://wordpresso.org/hacks/29-wordpress-tryukov-dlya-rabotyi-s-zapisyami-i-stranitsami/
add_action('template_redirect', 'single_result');
function single_result() {
  if (is_search()) {
    global $wp_query;
    if ($wp_query->post_count == 1) {
      wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
    }
  }
}

// хлебные крошки   http://dimox.name/wordpress-breadcrumbs-without-a-plugin/
// < ?php if (function_exists('easy_breadcrumbs')) easy_breadcrumbs(); ? >
//
function easy_breadcrumbs() {
  /* === ОПЦИИ === */
  $text['home'] = 'Главная'; // текст ссылки "Главная"
  $text['category'] = 'Архив рубрики "%s"'; // текст для страницы рубрики
  $text['search'] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
  $text['tag'] = 'Записи с тегом "%s"'; // текст для страницы тега
  $text['author'] = 'Статьи автора %s'; // текст для страницы автора
  $text['404'] = 'Ошибка 404'; // текст для страницы 404

  $show_current = 1; // 1 - показывать название текущей статьи/страницы/рубрики, 0 - не показывать
  $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
  $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
  $show_title = 1; // 1 - показывать подсказку (title) для ссылок, 0 - не показывать
  $delimiter = ' &raquo; '; // разделить между "крошками"
  $before = '<span class="current">'; // тег перед текущей "крошкой"
  $after = '</span>'; // тег после текущей "крошки"
  /* === КОНЕЦ ОПЦИЙ === */

  global $post;
  $home_link = home_url('/');
  $link_before = '<span typeof="v:Breadcrumb">';
  $link_after = '</span>';
  $link_attr = ' rel="v:url" property="v:title"';
  $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
  $parent_id = $parent_id_2 = $post->post_parent;
  $frontpage_id = get_option('page_on_front');

  if (is_home() || is_front_page()) {

    if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

  } else {

    echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
    if ($show_home_link == 1) {
        echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
        if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
    }

    if ( is_category() ) {
        $this_cat = get_category(get_query_var('cat'), false);
        if ($this_cat->parent != 0) {
            $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
            if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
            echo $cats;
        }
        if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

    } elseif ( is_search() ) {
        echo $before . sprintf($text['search'], get_search_query()) . $after;

    } elseif ( is_day() ) {
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
        echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
        echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
        echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
        echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
        if ( get_post_type() != 'post' ) {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
        } else {
            $cat = get_the_category(); $cat = $cat[0];
            $cats = get_category_parents($cat, TRUE, $delimiter);
            if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
            $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
            $cats = str_replace('</a>', '</a>' . $link_after, $cats);
            if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
            echo $cats;
            if ($show_current == 1) echo $before . get_the_title() . $after;
        }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
        $post_type = get_post_type_object(get_post_type());
        echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
        $parent = get_post($parent_id);
        $cat = get_the_category($parent->ID); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
        printf($link, get_permalink($parent), $parent->post_title);
        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
        if ($show_current == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
        if ($parent_id != $frontpage_id) {
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                if ($parent_id != $frontpage_id) {
                    $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                }
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs)-1) echo $delimiter;
            }
        }
        if ($show_current == 1) {
            if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
            echo $before . get_the_title() . $after;
        }

    } elseif ( is_tag() ) {
        echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

    } elseif ( is_author() ) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . sprintf($text['author'], $userdata->display_name) . $after;

    } elseif ( is_404() ) {
        echo $before . $text['404'] . $after;
    }

    if ( get_query_var('paged') ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
        echo __('Page') . ' ' . get_query_var('paged');
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div><!-- .breadcrumbs -->';

  }
} // end easy_breadcrumbs()

/*
  Plugin Name: Top Level Categories
  Plugin URI: http://fortes.com/projects/wordpress/top-level-cats/
  Description: Removes the prefix from the URL for a category. For instance, if your old category link was <code>/category/catname</code> it will now be <code>/catname</code>
*/

// In case we're running standalone, for some odd reason
if (function_exists('add_action')) {
  register_activation_hook(__FILE__, 'top_level_cats_activate');
  register_deactivation_hook(__FILE__, 'top_level_cats_deactivate');

  // Setup filters
  add_filter('category_rewrite_rules', 'top_level_cats_category_rewrite_rules');
  add_filter('generate_rewrite_rules', 'top_level_cats_generate_rewrite_rules');
  add_filter('category_link', 'top_level_cats_category_link', 10, 2);

  global $clean_category_rewrites, $clean_rewrites;
  $clean_category_rewrites = array();
}
function top_level_cats_activate() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
function top_level_cats_deactivate() {
  // Remove the filters so we don't regenerate the wrong rules when we flush
  remove_filter('category_rewrite_rules', 'top_level_cats_category_rewrite_rules');
  remove_filter('generate_rewrite_rules', 'top_level_cats_generate_rewrite_rules');
  remove_filter('category_link', 'top_level_cats_category_link');

  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
function top_level_cats_generate_rewrite_rules($wp_rewrite) {
  global $clean_category_rewrites;
  $wp_rewrite->rules = $wp_rewrite->rules + $clean_category_rewrites;
}

function top_level_cats_category_rewrite_rules($category_rewrite)
{
  global $clean_category_rewrites;

  global $wp_rewrite;
  // Make sure to use verbose rules, otherwise we'll clobber our
  // category permalinks with page permalinks
  $wp_rewrite->use_verbose_page_rules = true;

  while (list($k, $v) = each($category_rewrite)) {
    // Strip off the category prefix
    $new_k = top_level_cats_remove_cat_base($k);
    $clean_category_rewrites[$new_k] = $v;
  }

    return $category_rewrite;
}

function top_level_cats_category_link($cat_link, $cat_id) {
  return top_level_cats_remove_cat_base($cat_link);
}

function top_level_cats_remove_cat_base($link) {
  $category_base = get_option('category_base');

  // WP uses "category/" as the default
  if ($category_base == '')
      $category_base = 'category';

  // Remove initial slash, if there is one (we remove the trailing slash in the regex replacement and don't want to end up short a slash)
  if (substr($category_base, 0, 1) == '/')
      $category_base = substr($category_base, 1);

  $category_base .= '/';

  return preg_replace('|' . $category_base . '|', '', $link, 1);
}

?>
