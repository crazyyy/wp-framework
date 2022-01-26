<?php
/**
 * Plugin Name:    Axio Core
 * Description:    Core functionality to Axio Starter powered sites
 * Version:        1.1.2
 * Author:         Generaxion
 * Author URI:     https://www.generaxion.com
 * Text Domain:    axio-core
 */

// constant: version for cache busting etc
define('AXIO_CORE_VERSION', '1.1.2');

// constant: plugin's root directory (used in some sub_features)
define('AXIO_CORE_DIR', plugins_url('', __FILE__));


class Axio_Core {

  // var: active instance of class
  private static $instance;

  public function __construct() {

    /* Helper functions
    ----------------------------------------------- */

    require_once 'helpers.php';

    /* Test incompatibility with legacy plugin
    ----------------------------------------------- */

    if (class_exists('Aucor_Core')) {
      axio_core_debug_msg('Aucor Core plugin detected. Remove it to ensure best compatibility with Axio Core.', array());
    }

    /* Abstract classes
    ----------------------------------------------- */

    require_once 'abstract-feature.php';
    require_once 'abstract-sub-feature.php';

    /* Features for action: plugins_loaded
    ----------------------------------------------- */

    // polyfills
    require_once 'features/polyfills/class-polyfills.php';
    require_once 'features/polyfills/sub_features/class-polyfills-acf.php';
    require_once 'features/polyfills/sub_features/class-polyfills-polylang.php';

    // localization
    require_once 'features/localization/class-localization.php';
    require_once 'features/localization/sub_features/class-localization-string-translations.php';

    // initialize features
    $features = array(
      'axio_core_polyfills'      => new Axio_Core_Polyfills,
      'axio_core_localization'   => new Axio_Core_Localization,

    );

    /* Features for action: after_setup_theme
    ----------------------------------------------- */

    add_action('after_setup_theme', function() {

      // admin
      require_once 'features/admin/class-admin.php';
      require_once 'features/admin/sub_features/class-admin-front-page-edit-link.php';
      require_once 'features/admin/sub_features/class-admin-gallery.php';
      require_once 'features/admin/sub_features/class-admin-image-link.php';
      require_once 'features/admin/sub_features/class-admin-login.php';
      require_once 'features/admin/sub_features/class-admin-menu-cleanup.php';
      require_once 'features/admin/sub_features/class-admin-notifications.php';
      require_once 'features/admin/sub_features/class-admin-profile-cleanup.php';
      require_once 'features/admin/sub_features/class-admin-remove-customizer.php';

      // classic-editor
      require_once 'features/classic-editor/class-classic-editor.php';
      require_once 'features/classic-editor/sub_features/class-editor-tinymce.php';

      // dashboard
      require_once 'features/dashboard/class-dashboard.php';
      require_once 'features/dashboard/sub_features/class-dashboard-cleanup.php';
      require_once 'features/dashboard/sub_features/class-dashboard-recent-widget.php';
      require_once 'features/dashboard/sub_features/class-dashboard-remove-panels.php';

      // debug
      require_once 'features/debug/class-debug.php';
      require_once 'features/debug/sub_features/class-debug-style-guide.php';
      require_once 'features/debug/sub_features/class-debug-wireframe.php';

      // front-end
      require_once 'features/front-end/class-front-end.php';
      require_once 'features/front-end/sub_features/class-front-end-clean-empty-html.php';
      require_once 'features/front-end/sub_features/class-front-end-excerpt.php';
      require_once 'features/front-end/sub_features/class-front-end-html-fixes.php';
      require_once 'features/front-end/sub_features/class-front-end-uglify-attachment-permalink.php';

      // plugins
      require_once 'features/plugins/class-plugins.php';
      require_once 'features/plugins/sub_features/class-plugins-acf.php';
      require_once 'features/plugins/sub_features/class-plugins-cookiebot.php';
      require_once 'features/plugins/sub_features/class-plugins-gravityforms.php';
      require_once 'features/plugins/sub_features/class-plugins-redirection.php';
      require_once 'features/plugins/sub_features/class-plugins-public-post-preview.php';
      require_once 'features/plugins/sub_features/class-plugins-seo.php';
      require_once 'features/plugins/sub_features/class-plugins-yoast.php';

      // security
      require_once 'features/security/class-security.php';
      require_once 'features/security/sub_features/class-security-disable-admin-email-check.php';
      require_once 'features/security/sub_features/class-security-disable-file-edit.php';
      require_once 'features/security/sub_features/class-security-disable-unfiltered-html.php';
      require_once 'features/security/sub_features/class-security-head-cleanup.php';
      require_once 'features/security/sub_features/class-security-hide-users.php';
      require_once 'features/security/sub_features/class-security-remove-comment-moderation.php';
      require_once 'features/security/sub_features/class-security-remove-commenting.php';

      // speed
      require_once 'features/speed/class-speed.php';
      require_once 'features/speed/sub_features/class-speed-limit-revisions.php';
      require_once 'features/speed/sub_features/class-speed-move-jquery.php';
      require_once 'features/speed/sub_features/class-speed-remove-emojis.php';
      require_once 'features/speed/sub_features/class-speed-remove-metabox.php';

      // initialize features
      $features = array(
        'axio_core_admin'          => new Axio_Core_Admin,
        'axio_core_classic_editor' => new Axio_Core_Classic_Editor,
        'axio_core_dashboard'      => new Axio_Core_Dashboard,
        'axio_core_front_end'      => new Axio_Core_Front_End,
        'axio_core_plugins'        => new Axio_Core_Plugins,
        'axio_core_security'       => new Axio_Core_Security,
        'axio_core_speed'          => new Axio_Core_Speed,
        'axio_core_debug'          => new Axio_Core_Debug,
      );

    });

  }

  /**
   * Get instance
   */
  public static function get_instance() {

    if (!isset(self::$instance)) {
      self::$instance = new Axio_Core();
    }
    return self::$instance;

  }

}

// init
add_action('plugins_loaded', function() {

  $axio_core = Axio_Core::get_instance();

});

// load translations
add_action('plugins_loaded', function () {

  load_plugin_textdomain('axio-core', false, basename(dirname( __FILE__ )) . '/languages/');

});
