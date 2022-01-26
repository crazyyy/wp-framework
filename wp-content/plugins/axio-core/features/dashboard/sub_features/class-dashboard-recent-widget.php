<?php
/**
 * Class Dashboard_Recent_Widget
 */
class Axio_Core_Dashboard_Recent_Widget extends Axio_Core_Sub_Feature {

  public function setup() {

    // var: key
    $this->set('key', 'axio_core_dashboard_recent_widget');

    // var: name
    $this->set('name', 'Adds a widget displaying recent activity on the site to the dashboard');

    // var: is_active
    $this->set('is_active', true);

  }

  /**
   * Run feature
   */
  public function run() {

    add_action('wp_dashboard_setup', array($this, 'register_axio_recent_dashboard_widget'));
    add_action('admin_enqueue_scripts', array($this, 'axio_recent_dashboard_widget_styles'));

  }

  /**
   * Register the widget
   */
  public static function register_axio_recent_dashboard_widget() {

    global $wp_meta_boxes;
    add_meta_box( 'axio_recent_dashboard_widget', __('Activity'), array('Axio_Core_Dashboard_Recent_Widget', 'axio_recent_dashboard_widget_display'), 'dashboard', 'side', 'high' );

  }

  /**
   * Build the widget to display
   */
  public static function axio_recent_dashboard_widget_display() {
    $current_user_id = intval(get_current_user_id());
    $current_user_obj = get_user_by('ID', $current_user_id);
    $post_types = get_post_types(array('show_ui' => true));
    $skip_post_types = array('attachment', 'revision', 'acf-field', 'acf-field-group', 'nav_menu_item', 'polylang_mo');
    $post_types = array_diff($post_types, $skip_post_types);
    $date_format = get_option('date_format');
    $time_format = get_option('time_format');

    //Date format to j.n.Y and time format to H:i
    if (!strstr($date_format, '.Y')) {
      $date_format = 'j.n.Y';
      $time_format = 'H:i';
    }

    $user_posts = array();
    global $wpdb;

    /*
      * GET REVISIONS BY CURRENT USER
      * ==============================
      * Use $wpdb because there is no clean way to get revisions. We group the posts by post_parent because
      * multiple revisions might point to same post. We only need the post_parent ID because that points us
      * to the original post_type post that we will need. Grouping messes up post_modified but order seems
      * to be correct. This will break in multi-sites, I think.
      */

    $my_revisions = $wpdb->get_results("SELECT post_parent FROM $wpdb->posts WHERE post_author = $current_user_id AND post_type = 'revision' GROUP BY post_parent ORDER BY post_modified DESC LIMIT 4");

    foreach ($my_revisions as $revision) {
      array_push($user_posts, get_post($revision->post_parent));
    }

    // recently published
    $user_query = new WP_Query(array(
      'post_type'                 => $post_types,
      'author'                    => $current_user_id,
      'posts_per_page'            => 6,
      'post_status'               => 'any',
      'orderby'                   => 'date',
      'order'                     => 'DESC',
      'no_found_rows'             => true, // no pagination
      'update_post_term_cache'    => false, // no tax
      'update_post_meta_cache'    => false, // no meta
    ));

    while ($user_query->have_posts()) : $user_query->the_post();
      $post_is_unique = true;
      foreach ($user_posts as $user_post) {
        if ($user_query->post->ID == $user_post->ID) {
          $post_is_unique = false;
        }
      }
      if ($post_is_unique) {
        $post_revisions = wp_get_post_revisions($user_query->post->ID, '');
        if (!empty($post_revisions)) {
          $most_recent_revision_id = max(array_keys($post_revisions));
          $user_query->post->post_modified = $post_revisions[$most_recent_revision_id]->post_modified;
        }
        array_push($user_posts, $user_query->post);
      }
    endwhile;

    usort($user_posts, array('Axio_Core_Dashboard_Recent_Widget', 'axio_core_order_posts_array_by_modified_date'));
    $user_posts = array_reverse($user_posts);

    if (!empty($user_posts)) :
      ?>
      <div class="axio-recent-section">
        <h3><?php echo esc_attr__('My content and changes', 'axio-core'); ?></h3>
        <ul>
      <?php
        $limit = (count($user_posts) > 4) ? 4 : count($user_posts);
        for ($i=0; $i < $limit; $i++) {
          $obj = get_post_type_object(get_post_type($user_posts[$i]->ID));
          $obj_name = '';
          if (is_object($obj)) {
            $obj_name = $obj->labels->singular_name;
          }
          $title = $user_posts[$i]->post_title;
          if (empty($title)) {
            $title = '#' . $user_posts[$i]->ID;
          }
          if (!empty($obj_name)) {
            $title .= ' (' . $obj_name . ')';
          }
          $modified_time = date_create($user_posts[$i]->post_modified);
      ?>
        <li><span class="axio-recent-time"><?php echo esc_html(date_format($modified_time, "$date_format $time_format")); ?></span><span class="axio-recent-link"><?php edit_post_link($title, '', '', $user_posts[$i]->ID); ?></span></li>
        <?php
      }
        ?>
        </ul>
      </div>
      <?php
    endif;

    // prevent users without post editing capabilities from viewing the recent edits section
    // (results in empty items for posts by others, so no new information is conveyed for them)

    $default_roles = array('subscriber', 'contributor', 'author');

    // support legacy filter
    $user_blacklist = apply_filters('aucor_core_recent_widget_user_blacklist', $default_roles);

    // new filter
    $user_blacklist = apply_filters('axio_core_recent_widget_user_blacklist', $user_blacklist);

    if (array_diff($current_user_obj->roles, $user_blacklist)) :
    ?>

    <div class="axio-recent-section">
      <h3><?php echo esc_attr__('Recent edits', 'axio-core'); ?></h3>
      <ul>
      <?php
      $query = new WP_Query(array(
        'post_type'               => $post_types,
        'posts_per_page'          => 6,
        'post_status'             => array('publish', 'private', 'future', 'pending'),
        'orderby'                 => 'modified',
        'order'                   => 'DESC',
        'no_found_rows'           => true, // no pagination
        'update_post_term_cache'  => false, // no tax
        'update_post_meta_cache'  => false, // no meta
      ));
      while ($query->have_posts()) : $query->the_post();
        $obj = get_post_type_object(get_post_type($query->post->ID));
        $obj_name = '';
        if (is_object($obj)) {
          $obj_name = $obj->labels->singular_name;
        }
        $title = $query->post->post_title;
        if (empty($title)) {
          $title = '#' . $query->post->ID;
        }
        if (!empty($obj_name)) {
          $title .= ' (' . $obj_name . ')';
        }
      ?>
        <li><span class="axio-recent-time"><?php echo esc_html(get_the_modified_date("$date_format $time_format")); ?></span><span class="axio-recent-link"><?php edit_post_link($title, '', '', $query->post->ID); ?></span></li>
        <?php
      endwhile;
      ?>
      </ul>
    </div>
      <?php
    endif;
  }

  /**
   * Enqueue custom styles
   */
  public static function axio_recent_dashboard_widget_styles($hook) {
    if ($hook == 'index.php') {
      wp_enqueue_style('axio_core-dashboard-widget-styles', AXIO_CORE_DIR . '/assets/axio-core.css', array(), AXIO_CORE_VERSION);
    }
  }

  /**
   * Helper function - order posts from nearest to oldest
   */
  public static function axio_core_order_posts_array_by_modified_date($a, $b) {
    return strcmp(strtotime($a->post_modified), strtotime($b->post_modified));
  }
}

