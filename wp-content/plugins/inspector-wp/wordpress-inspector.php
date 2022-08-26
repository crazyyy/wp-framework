<?php
  /*
  Plugin Name: WordPress Inspector
  Plugin URI: http://wordpress.inspector.io
  Description: Inspect your WordPress for speed, seo, security and performance. Find broken plugins and themes that affect your WordPress performance and get recommendations to optimize.
  Version: 1.1.0
  Author: MailMunch
  Author URI: http://www.mailmunch.co
  License: GPL2
  */

  define( 'WPINSPECTOR_SLUG', "wordpress-inspector" );
  define( 'WPINSPECTOR_VER' , "1.1.0" );
  define( 'WPINSPECTOR_URL', "https://wordpress.inspector.io/" );

  // Adding Admin Menu
  add_action( 'admin_menu', 'wpinsp_register_wpinspector_page' );

  function wpinsp_register_wpinspector_page(){
     $menu_page = add_menu_page( 'WordPress Inspector', 'WP Inspector', 'manage_options', WPINSPECTOR_SLUG, 'wpinsp_wpinspector_setup', plugins_url( 'img/icon.png', __FILE__ ), 102.786 ); 
     // If successful, load admin assets only on that page.
     if ($menu_page) add_action('load-' . $menu_page, 'wpinsp_load_plugin_assets');
  }

  function wpinsp_load_plugin_assets() {
    add_action( 'admin_enqueue_scripts', 'wpinsp_enqueue_admin_styles' );
    add_action( 'admin_enqueue_scripts', 'wpinsp_enqueue_admin_scripts'  );
  }

  function wpinsp_enqueue_admin_styles() {
    wp_enqueue_style(WPINSPECTOR_SLUG . '-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), WPINSPECTOR_VER );
  }

  function wpinsp_enqueue_admin_scripts() {
    wp_enqueue_script(WPINSPECTOR_SLUG . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), WPINSPECTOR_VER );
  }

  function wpinsp_wpinspector_setup() {
?>
<div class="container wrap">
  <div class="page-header">
    <h2>WordPress Inspector</h2>
  </div>

  <div class="insp-content">
    <hr />

    <form action="<?php echo WPINSPECTOR_URL ?>results/wordpress" target="_blank" method="POST">
  <?php
  $version = get_bloginfo('version');
  $plugins = get_plugins();
  $active_plugins = get_option('active_plugins');
  $filtered_plugins = array_intersect_key($plugins, array_flip($active_plugins));
  foreach ($filtered_plugins as $key => &$value) {
    $slug = explode("/", $key);
    $slug = reset($slug);
  ?>
  <input type="hidden" name="plugins[][name]" value='<?php echo $value['Name']; ?>' />
  <input type="hidden" name="plugins[][slug]" value='<?php echo $slug; ?>' />
  <input type="hidden" name="plugins[][url]" value='<?php echo $value['PluginURI']; ?>' />
  <input type="hidden" name="plugins[][description]" value='<?php echo $value['Description']; ?>' />
  <input type="hidden" name="plugins[][author]" value='<?php echo $value['Author']; ?>' />
  <input type="hidden" name="plugins[][author_uri]" value='<?php echo $value['AuthorURI']; ?>' />
  <input type="hidden" name="plugins[][author_name]" value='<?php echo $value['AuthorName']; ?>' />
  <input type="hidden" name="plugins[][title]" value='<?php echo $value['Title']; ?>' />
  <input type="hidden" name="plugins[][version]" value='<?php echo $value['Version']; ?>' />
  <?php
  }

  $theme = wp_get_theme();
  ?>
      <input type="hidden" name="theme[][name]" value='<?php echo $theme->get('Name'); ?>' />
      <input type="hidden" name="theme[][url]" value='<?php echo $theme->get('ThemeURI'); ?>' />
      <input type="hidden" name="theme[][description]" value='<?php echo $theme->get('Description'); ?>' />
      <input type="hidden" name="theme[][author]" value='<?php echo $theme->get('Author'); ?>' />
      <input type="hidden" name="theme[][author_uri]" value='<?php echo $theme->get('AuthorURI'); ?>' />
      <input type="hidden" name="theme[][version]" value='<?php echo $theme->get('Version'); ?>' />
      <input type="hidden" name="theme[][text_domain]" value='<?php echo $theme->get('TextDomain'); ?>' />

      <table class="form-table insp-form-table">
        <tbody>
          <tr valign="top">
            <th scope="row"><label for="mailchimp_api_key">WordPress Version</label></th>
            <td>
              <?php echo $version ?>
              <input type="hidden" name="wp_version" value='<?php echo $version ?>' />
            </td>
          </tr>

          <tr valign="top">
            <th scope="row"><label for="mailchimp_api_key">Theme</label></th>
            <td>
              <?php echo $theme->get('Name'); ?>
              <?php echo $theme->get('Version'); ?>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row"><label for="mailchimp_api_key">Plugins</label></th>
            <td>
              <?php echo sizeof($filtered_plugins) ?> activated plugins
            </td>
          </tr>

          <tr valign="top">
            <th scope="row"><label for="mailchimp_api_key">WordPress URL</label></th>
            <td>
              <input type="text" name="wp_url" value='<?php echo home_url(); ?>' class="widefat insp-field" />
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="mailchimp_api_key">Email Address</label></th>
            <td>
              <input type="email" name="email" value='<?php echo wp_get_current_user()->user_email; ?>' class="widefat insp-field" placeholder="Your Email Address" />
            </td>
          </tr>
        </tbody>
      </table>

      <input type="submit" value="Start Inspection" class="button button-primary" />
    </form>

    <br />
    <hr />

    <h3>Popular Inspections</h3>

    <p>Check out some of the inspections on popular WordPress blogs.</p>

    <div class="insp-popular">
      <div class="insp-inspection">
        <a href="<?php echo WPINSPECTOR_URL ?>results/wplift.com" target="_blank">
          <img src="<?php echo plugins_url( 'img/wplift.png', __FILE__ ) ?>" /><br />
          WP Lift (wplift.com)
        </a>
      </div>

      <div class="insp-inspection">
        <a href="<?php echo WPINSPECTOR_URL ?>results/wpmayor.com" target="_blank">
          <img src="<?php echo plugins_url( 'img/wpmayor.png', __FILE__ ) ?>" /><br />
          WP Mayor (wpmayor.com)
        </a>
      </div>

      <div class="insp-inspection">
        <a href="<?php echo WPINSPECTOR_URL ?>results/wptavern.com" target="_blank">
          <img src="<?php echo plugins_url( 'img/wptavern.png', __FILE__ ) ?>" /><br />
          WP Tavern (wptavern.com)
        </a>
      </div>
    </div>

    <div class="clearfix"></div>
  </div>

  <div class="insp-sidebar">
    <div class="insp-feature-box">
      <h3>What Will Be Inspected?</h3>
      <p><em>This plugin will inspect your WordPress for speed, seo, security and overall performance.</em></p>
      <ul class="ul-square">
        <li>
          <strong>Speed</strong><br>
          How fast does your site load for users?
        </li>
        <li>
          <strong>SEO</strong><br>
          Have you implemented basic SEO practices?
        </li>
        <li>
          <strong>Security</strong><br>
          Is your WordPress secure from attacks?
        </li>
        <li>
          <strong>Performance</strong><br>
          Is your WordPress optimized for performance?
        </li>
        <li>
          <strong>Broken Theme or Plugins</strong><br>
          Is your theme and plugins performing fine?
        </li>
      </ul>
    </div>
  </div>

  <div class="clearfix"></div>
</div>
<?php
  }
?>