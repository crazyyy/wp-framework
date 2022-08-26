<?php
/*
  Plugin Name: Orbisius Child Theme Creator
  Plugin URI: https://orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator/
  Description: This plugin allows you to quickly create child themes from any theme that you have currently installed on your site/blog.
  Version: 1.5.4
  Author: Svetoslav Marinov (Slavi)
  Author URI: https://orbisius.com
 */

/*  Copyright 2012-2050 Svetoslav Marinov (Slavi) <slavi@orbisius.com>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

define( 'ORBISIUS_CHILD_THEME_CREATOR_BASE_DIR', dirname(__FILE__) );
define( 'ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE', __FILE__ );

// Set up plugin
add_action('admin_init', 'orbisius_child_theme_creator_admin_init');
add_action('admin_init', 'orbisius_child_theme_creator_register_settings');
add_action('admin_enqueue_scripts', 'orbisius_child_theme_creator_admin_enqueue_scripts');
add_action('admin_menu', 'orbisius_child_theme_creator_setup_admin');
add_action('network_admin_menu', 'orbisius_child_theme_creator_setup_admin'); // manage_network_themes
add_action('wp_footer', 'orbisius_child_theme_creator_add_plugin_credits', 1000); // be the last in the footer
add_action('admin_notices', 'orbisius_child_theme_creator_admin_notice_message');
add_action('network_admin_notices', 'orbisius_child_theme_creator_admin_notice_message');

add_action('wp_before_admin_bar_render', 'orbisius_child_theme_creator_admin_bar_render', 100);

add_action( 'wp_ajax_orbisius_ctc_theme_editor_ajax', 'orbisius_ctc_theme_editor_ajax');
add_action( 'wp_ajax_nopriv_orbisius_ctc_theme_editor_ajax', 'orbisius_ctc_theme_editor_no_auth_ajax');


register_activation_hook( __FILE__, 'orbisius_child_theme_creator_on_activate' );

require_once( ORBISIUS_CHILD_THEME_CREATOR_BASE_DIR . '/lib/result.php' );
require_once( ORBISIUS_CHILD_THEME_CREATOR_BASE_DIR . '/lib/user.php' );

if (file_exists( ORBISIUS_CHILD_THEME_CREATOR_BASE_DIR . '/addons/init.php' ) ) {
    require_once( ORBISIUS_CHILD_THEME_CREATOR_BASE_DIR . '/addons/init.php' );
}

/**
 * Adds admin bar items for easy access to the theme creator and editor
 */
function orbisius_child_theme_creator_admin_bar_render() {
    orbisius_child_theme_creator_add_admin_bar('Orbisius');
    orbisius_child_theme_creator_add_admin_bar('Orbisius Child Theme Creator', orbisius_child_theme_creator_util::get_create_child_pages_link(), 'Orbisius');
    orbisius_child_theme_creator_add_admin_bar('Orbisius Theme Editor', orbisius_child_theme_creator_util::get_theme_editor_link(), 'Orbisius');
}

/**
 * 
 */
function orbisius_child_theme_creator_on_activate() {
    $opts = orbisius_child_theme_creator_get_options();

    // Let's set the activation time so we can hide the notice in the plugins area.
    if (empty($opts['setup_time'])) {
        $opts['setup_time'] = time();
        orbisius_child_theme_creator_set_options($opts);
    }
}

/**
 * Show a notice in the plugins area to let the user know how to work with the plugin.
 * On multisite the message is shown only on the network site.
 */
function orbisius_child_theme_creator_admin_notice_message() {
    global $pagenow;
    $opts = orbisius_child_theme_creator_get_options();
    
    $plugin_data = orbisius_child_theme_creator_get_plugin_data();
    $name = $plugin_data['Name'];

    // show notice only the first 24h
    $show_notice = empty($opts['setup_time']) || ( time() - $opts['setup_time'] < 24 * 3600 );

    if ($show_notice
            && ( stripos($pagenow, 'plugins.php') !== false )
            && ( !is_multisite() || ( is_multisite() && is_network_admin() ) ) ) {
        $just_link = orbisius_child_theme_creator_util::get_create_child_pages_link();
        echo "<div class='updated'><p>$name: to create a child theme go to
          <a href='$just_link'><strong>Appearance &rarr; $name</strong></a>. This message will automatically disappear within 24h.</p></div>";
    }
}

/**
 * @package Orbisius Child Theme Creator
 * @since 1.0
 */
function orbisius_child_theme_creator_admin_init() {
    if ( ! empty( $_REQUEST['orbisius_child_theme_creator_data']['cmd'] ) ) {
        try {
            $orbisius_child_theme_creator_data = $_REQUEST['orbisius_child_theme_creator_data'];
            
            if ( empty( $orbisius_child_theme_creator_data['theme'] ) ) {
                throw new Exception( "No theme" );
            }
            
            if ( empty( $orbisius_child_theme_creator_data['nonce'] ) 
                    || ! wp_verify_nonce( $orbisius_child_theme_creator_data['nonce'], 'orbisius_child_theme_creator_data' ) ) {
                throw new Exception( "No nonce or it's invalid." );
            }
            
            if ( ! orbisius_child_theme_creator_util::has_access() && isset($_GET['action'] ) ) {
                throw new Exception( "No access" );
            }
            
            $theme = wp_get_theme( $orbisius_child_theme_creator_data['theme'] );

            if ( ! $theme->exists() || ! $theme->is_allowed() ) {
                throw new Exception( "No theme or it's invalid." );
            }

            switch_theme( $theme->get_stylesheet() );
            wp_redirect( admin_url( 'themes.php?activated=true' ) );
            exit;
        } catch (Exception $e) {
            wp_die(
                '<h1>' . __( 'Error' ) . '</h1>' .
                '<p>' . __( $e->getMessage() ) . '</p>',
                200
            );
        }
    }      
}

function orbisius_child_theme_creator_is_pro_installed() {
    static $res = null;

    if ( is_null( $res ) ) {
        // is creator pro active?
        $res = in_array( 'orbisius-child-theme-creator-pro/orbisius-child-theme-creator-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
    }

    return $res;
}

/**
 * Add's menu parent or submenu item.
 * @param string $name the label of the menu item
 * @param string $href the link to the item (settings page or ext site)
 * @param string $parent Parent label (if creating a submenu item)
 *
 * @return void
 * @author Slavi Marinov <https://orbisius.com>
 * */
function orbisius_child_theme_creator_add_admin_bar($name, $href = '', $parent = '', $custom_meta = array()) {
    global $wp_admin_bar;

    if (!is_super_admin()
            || !is_admin_bar_showing()
            || !is_object($wp_admin_bar)
            || !function_exists('is_admin_bar_showing')) {
        return;
    }

    // Generate ID based on the current filename and the name supplied.
    $id = str_replace('.php', '', basename(__FILE__)) . '-' . $name;
    $id = preg_replace('#[^\w-]#si', '-', $id);
    $id = strtolower($id);
    $id = trim($id, '-');

    $parent = trim($parent);

    // Generate the ID of the parent.
    if (!empty($parent)) {
        $parent = str_replace('.php', '', basename(__FILE__)) . '-' . $parent;
        $parent = preg_replace('#[^\w-]#si', '-', $parent);
        $parent = strtolower($parent);
        $parent = trim($parent, '-');
    }

    // links from the current host will open in the current window
    $site_url = site_url();

    $meta_default = array();
    $meta_ext = array( 'target' => '_blank' ); // external links open in new tab/window

    $meta = (strpos($href, $site_url) !== false) ? $meta_default : $meta_ext;
    $meta = array_merge($meta, $custom_meta);

    $wp_admin_bar->add_node(array(
        'parent' => $parent,
        'id' => $id,
        'title' => $name,
        'href' => $href,
        'meta' => $meta,
    ));
}

/**
 * Sets the setting variables
 */
function orbisius_child_theme_creator_register_settings() { // whitelist options
    register_setting('orbisius_child_theme_creator_settings', 'orbisius_child_theme_creator_options',
        'orbisius_child_theme_creator_validate_settings');
}

/**
 * This is called by WP after the user hits the submit button.
 * The variables are trimmed first and then passed to the who ever wantsto filter them.
 * @param array the entered data from the settings page.
 * @return array the modified input array
 */
function orbisius_child_theme_creator_validate_settings($input) { // whitelist options
    $input = array_map('trim', $input);

    // let extensions do their thing
    $input_filtered = apply_filters('orbisius_child_theme_creator_ext_filter_settings', $input);

    // did the extension break stuff?
    $input = is_array($input_filtered) ? $input_filtered : $input;

    return $input;
}

/**
 * Retrieves the plugin options. It inserts some defaults.
 * The saving is handled by the settings page. Basically, we submit to WP and it takes
 * care of the saving.
 *
 * @return array
 */
function orbisius_child_theme_creator_get_options() {
    $defaults = array(
        'status' => 1,
        'setup_time' => '',
    );

    $opts = get_option('orbisius_child_theme_creator_options');

    $opts = (array) $opts;
    $opts = array_merge($defaults, $opts);

    return $opts;
}

/**
* Updates options but it merges them unless $override is set to 1
* that way we could just update one variable of the settings.
*/
function orbisius_child_theme_creator_set_options($opts = array(), $override = 0) {
    if (!$override) {
        $old_opts = orbisius_child_theme_creator_get_options();
        $opts = array_merge($old_opts, $opts);
    }

    update_option('orbisius_child_theme_creator_options', $opts);

    return $opts;
}

function orbisius_child_theme_creator_is_live_env() {
    return empty($_SERVER['DEV_ENV']);
}

add_filter('orbisius_child_theme_creator_filter_asset_src', 'orbisius_child_theme_creator_fix_asset_src', 10, 2);
function orbisius_child_theme_creator_fix_asset_src($src, $ctx = array()) {
    if (!preg_match('#^(?:https?:)?//#si', $src)) // not full urls.
            {
        $new_src = $src;

        // We might need to get last_mod for min files too.
        if (orbisius_child_theme_creator_is_live_env() && (stripos($src, '.min.') === false)) {
            $new_src = str_replace('.css', '.min.css', $new_src);
            $new_src = str_replace('.js', '.min.js', $new_src);
        }

        $local_file = plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . $new_src;
        
        // We check if .min file exists and if so use it.
        if (file_exists($local_file)) {
            if (!empty($ctx['last_mod'])) {
                $src = filemtime($local_file);
            } else {
                $full_new_src = plugins_url($new_src, ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE);
                $src = $full_new_src;
            }
        }
    }
    
    return $src;
}

/**
 * @package Orbisius Child Theme Creator
 * @since 1.0
 *
 * Loads plugin's JS/CSS files only on child theme creator pages in admin area.
 * Also searches tags
 */
function orbisius_child_theme_creator_admin_enqueue_scripts($current_page = '') {
    if (strpos($current_page, 'orbisius_child_theme_creator') === false) {
        return ;
    }
    
    $suffix = orbisius_child_theme_creator_is_live_env() ? '.min' : '';

    wp_register_style('orbisius_child_theme_creator', plugins_url("/assets/main{$suffix}.css", __FILE__), false,
            filemtime( plugin_dir_path( __FILE__ ) . "/assets/main{$suffix}.css" ) );
    wp_enqueue_style('orbisius_child_theme_creator');

    wp_enqueue_script( 'jquery' );
    wp_register_script( 'orbisius_child_theme_creator', plugins_url("/assets/main{$suffix}.js", __FILE__), array('jquery', ),
            filemtime( plugin_dir_path( __FILE__ ) . "/assets/main{$suffix}.js" ), true);

    if (strpos($current_page, 'orbisius_child_theme_creator_theme_editor_action') !== false) {
        wp_enqueue_script( 'orbisius_child_theme_creator' );
    }
    
    
    do_action( 'orbisius_child_theme_creator_admin_enqueue_scripts', array( 'suffix' => $suffix, ) );
}

/**
 * Set up administration
 *
 * @package Orbisius Child Theme Creator
 * @since 0.1
 */
function orbisius_child_theme_creator_setup_admin() {
    add_options_page('Orbisius Child Theme Creator', 'Orbisius Child Theme Creator', 'manage_options', 
            'orbisius_child_theme_creator_settings_page', 'orbisius_child_theme_creator_settings_page');

    add_theme_page('Orbisius Child Theme Creator', 'Orbisius Child Theme Creator', 'manage_options',
            'orbisius_child_theme_creator_themes_action', 'orbisius_child_theme_creator_tools_action');

    /*add_submenu_page('tools.php', 'Orbisius Child Theme Creator', 'Orbisius Child Theme Creator', 'manage_options',
            'orbisius_child_theme_creator_tools_action', 'orbisius_child_theme_creator_tools_action');*/

    // when plugins are show add a settings link near my plugin for a quick access to the settings page.
    add_filter('plugin_action_links', 'orbisius_child_theme_creator_add_plugin_settings_link', 10, 2);

    // Theme Editor
    add_theme_page( 'Orbisius Theme Editor', 'Orbisius Theme Editor', 'manage_options',
            'orbisius_child_theme_creator_theme_editor_action', 'orbisius_ctc_theme_editor' );
    add_filter('theme_action_links', 'orbisius_child_theme_creator_add_edit_theme_link', 50, 2);
}

// Add the ? settings link in Plugins page very good
function orbisius_child_theme_creator_add_plugin_settings_link($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $link = orbisius_child_theme_creator_util::get_settings_link();
        $link_html = "<a href='$link'>Settings</a>";
        array_unshift($links, $link_html);

        $link = orbisius_child_theme_creator_util::get_theme_editor_link();
        $link_html = "<a href='$link'>Edit Themes</a>";
        array_unshift($links, $link_html);

        $link = orbisius_child_theme_creator_util::get_create_child_pages_link();
        $link_html = "<a href='$link'>Create Child Theme</a>";
        array_unshift($links, $link_html);
    }

    return $links;
}

/**
 * This adds an edit button in Appearance under each theme.
 * @param array $actions
 * @param WP_Theme/string Obj $theme
 * @return array
 */
function orbisius_child_theme_creator_add_edit_theme_link($actions, $theme) {
    $link = orbisius_child_theme_creator_util::get_theme_editor_link( array( 'theme_1' => is_scalar($theme) ? $theme : $theme->get_template()) );
    $link_html = "<a href='$link' title='Opens this theme in Orbisius Theme Editor which features double textx editor.'>Orbisius: Edit</a>";

    $actions['orb_ctc_editor'] = $link_html;

    return $actions;
}

// Generates Options for the plugin
function orbisius_child_theme_creator_settings_page() {
    $just_link = orbisius_child_theme_creator_util::get_create_child_pages_link();
    ?>

    <div class="wrap orbisius_child_theme_creator_container">

        <div id="icon-options-general" class="icon32"></div>
        <h2>Orbisius Child Theme Creator</h2>

        <div class="updated0"><p>
                This plugin doesn't currently have any options. To use it go to
                <a href='<?php echo $just_link;?>'><strong>Appearance &rarr; Orbisius Child Theme Creator</strong></a>
        </p></div>

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <!-- main content -->
                <div id="post-body-content">

                    <div class="meta-box-sortables ui-sortable">


                        <div class="postbox">

                            <h3><span>Usage / Help</span> - <a href='<?php echo $just_link;?>'><strong>Appearance &rarr; Orbisius Child Theme Creator</strong></a></h3>
                            <div class="inside">

                                <ul>
                                    <li>Download/install a theme that you like</li>
                                    <li>Create a child theme based on it</li>
                                    <li>Activate the child theme</li>
                                    <li>Customize the child theme</li>
                                </ul>

                                <iframe width="560" height="315" src="https://youtube-nocookie.com/embed/BZUVq6ZTv-o" frameborder="0" allowfullscreen></iframe>

                            </div> <!-- .inside -->

                        </div> <!-- .postbox -->

                    </div> <!-- .meta-box-sortables .ui-sortable -->

                </div> <!-- post-body-content -->

                <!-- sidebar -->
                <div id="postbox-container-1" class="postbox-container">

                    <div class="meta-box-sortables">
                        <div class="postbox"> <!-- quick-contact -->
                            <?php
                            $current_user = wp_get_current_user();
                            $email = empty($current_user->user_email) ? '' : $current_user->user_email;
                            $quick_form_action = is_ssl()
                                    ? 'https://ssl.orbisius.com/apps/quick-contact/'
                                    : 'https://apps.orbisius.com/quick-contact/';

                            if (!empty($_SERVER['DEV_ENV'])) {
                                $quick_form_action = 'https://localhost/projects/quick-contact/';
                            }
                            ?>
                            <script>
                                var octc_quick_contact = {
                                    validate_form : function () {
                                        try {
                                            var msg = jQuery('#octc_msg').val().trim();
                                            var email = jQuery('#octc_email').val().trim();

                                            email = email.replace(/\s+/, '');
                                            email = email.replace(/\.+/, '.');
                                            email = email.replace(/\@+/, '@');

                                            if ( msg == '' ) {
                                                alert('Enter your message.');
                                                jQuery('#octc_msg').focus().val(msg).css('border', '1px solid red');
                                                return false;
                                            } else {
                                                // all is good clear borders
                                                jQuery('#octc_msg').css('border', '');
                                            }

                                            if ( email == '' || email.indexOf('@') <= 2 || email.indexOf('.') == -1) {
                                                alert('Enter your email and make sure it is valid.');
                                                jQuery('#octc_email').focus().val(email).css('border', '1px solid red');
                                                return false;
                                            } else {
                                                // all is good clear borders
                                                jQuery('#octc_email').css('border', '');
                                            }

                                            return true;
                                        } catch(e) {};
                                    }
                                };
                            </script>
                            <h3><span>Quick Question or Suggestion</span></h3>
                            <div class="inside">
                                <div>
                                    <form method="post" action="<?php echo $quick_form_action; ?>" target="_blank">
                                        <?php
                                            global $wp_version;
											$plugin_data = get_plugin_data(__FILE__);

                                            $hidden_data = array(
                                                'site_url' => site_url(),
                                                'wp_ver' => $wp_version,
                                                'first_name' => $current_user->first_name,
                                                'last_name' => $current_user->last_name,
                                                'product_name' => $plugin_data['Name'],
                                                'product_ver' => $plugin_data['Version'],
                                                'woocommerce_ver' => defined('WOOCOMMERCE_VERSION') ? WOOCOMMERCE_VERSION : 'n/a',
                                            );
                                            $hid_data = http_build_query($hidden_data);
                                            echo "<input type='hidden' name='data[sys_info]' value='$hid_data' />\n";
                                        ?>
                                        <textarea class="widefat" id='octc_msg' name='data[msg]' required="required"></textarea>
                                        <br/>Your Email: <input type="text" class=""
                                               id="octc_email" name='data[sender_email]' placeholder="Email" required="required"
                                               value="<?php echo esc_attr($email); ?>"
                                               />
                                        <br/><input type="submit" class="button-primary" value="<?php _e('Send Feedback') ?>"
                                                    onclick="return octc_quick_contact.validate_form();" />
                                        <br/>
                                        What data will be sent
                                        <a href='javascript:void(0);'
                                            onclick='jQuery(".octc_data_to_be_sent").toggle();'>(show/hide)</a>
                                        <div class="hide-is-js app-hide octc_data_to_be_sent">
                                            <textarea class="widefat0" rows="4" readonly="readonly" disabled="disabled"><?php
                                            foreach ($hidden_data as $key => $val) {
                                                if (is_array($val)) {
                                                    $val = var_export($val, 1);
                                                }

                                                echo "$key: $val\n";
                                            }
                                            ?></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox --> <!-- /quick-contact -->

                        <!-- Hire Us -->
                        <div class="postbox">
                            <h3><span>Need a test WordPress site?</span></h3>
                            <div class="inside">
                                Try <a
                                        href="https://qsandbox.com/?utm_source=orbisius-child-theme-creator&utm_medium=settings_screen&utm_campaign=product"
                                   target="_blank" title="[new window]">qSandbox.com</a> today (has a free plan)
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->
                        <!-- /Hire Us -->

                        <!-- Hire Us -->
                        <div class="postbox">
                            <h3><span>Hire Us</span></h3>
                            <div class="inside">
                                Hire us to create a plugin/web/SaaS app
                                <br/><a href="//orbisius.com/page/free-quote/?utm_source=<?php echo str_replace('.php', '', basename(__FILE__));?>&utm_medium=plugin-settings&utm_campaign=product"
                                   title="If you want a custom web/mobile app/plugin developed contact us. This opens in a new window/tab"
                                    class="button-primary" target="_blank">Get a Free Quote</a>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->
                        <!-- /Hire Us -->

                        <div class="postbox">
                            <h3><span>Newsletter</span></h3>
                            <div class="inside">
                                <!-- Begin MailChimp Signup Form -->
                                <div id="mc_embed_signup">
                                    <?php
                                        $current_user = wp_get_current_user();
                                        $email = empty($current_user->user_email) ? '' : $current_user->user_email;
                                    ?>

                                    <form action="https://WebWeb.us2.list-manage.com/subscribe/post?u=005070a78d0e52a7b567e96df&amp;id=1b83cd2093" method="post"
                                          id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                                        <input type="hidden" value="settings" name="SRC2" />
                                        <input type="hidden" value="orbisius-child-theme-creator" name="SRC" />

                                        <span>Get notified about cool plugins we release</span>
                                        <!--<div class="indicates-required"><span class="app_asterisk">*</span> indicates required
                                        </div>-->
                                        <div class="mc-field-group">
                                            <label for="mce-EMAIL">Email <span class="app_asterisk">*</span></label>
                                            <input type="email" value="<?php echo esc_attr($email); ?>" name="EMAIL" class="required email" id="mce-EMAIL">
                                        </div>
                                        <div id="mce-responses" class="clear">
                                            <div class="response" id="mce-error-response" style="display:none"></div>
                                            <div class="response" id="mce-success-response" style="display:none"></div>
                                        </div>	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button-primary"></div>
                                    </form>
                                </div>
                                <!--End mc_embed_signup-->
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                        <?php //orbisius_child_theme_creator_util::output_orb_widget(); ?>

                        <?php
                                        $plugin_data = get_plugin_data(__FILE__);
                                        $product_name = trim($plugin_data['Name']);
                                        $product_page = trim($plugin_data['PluginURI']);
                                        $product_descr = trim($plugin_data['Description']);
                                        $product_descr_short = substr($product_descr, 0, 50) . '...';

                                        $base_name_slug = basename(__FILE__);
                                        $base_name_slug = str_replace('.php', '', $base_name_slug);
                                        $product_page .= (strpos($product_page, '?') === false) ? '?' : '&';
                                        $product_page .= "utm_source=$base_name_slug&utm_medium=plugin-settings&utm_campaign=product";

                                        $product_page_tweet_link = $product_page;
                                        $product_page_tweet_link = str_replace('plugin-settings', 'tweet', $product_page_tweet_link);
                                    ?>

                        <div class="postbox">
                            <div class="inside">
                                <!-- Twitter: code -->
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                <!-- /Twitter: code -->

                                <!-- Twitter: Orbisius_Follow:js -->
                                    <a href="https://twitter.com/orbisius" class="twitter-follow-button"
                                       data-align="right" data-show-count="false">Follow @orbisius</a>
                                <!-- /Twitter: Orbisius_Follow:js -->

                                &nbsp;

                                <!-- Twitter: Tweet:js -->
                                <a href="//twitter.com/share" class="twitter-share-button"
                                   data-lang="en" data-text="Checkout Orbisius Child Theme Creator #WordPress #plugin.Create Child Themes in Seconds"
                                   data-count="none" data-via="orbisius" data-related="orbisius"
                                   data-url="<?php echo $product_page_tweet_link;?>">Tweet</a>
                                <!-- /Twitter: Tweet:js -->


                                <br/>
                                 <a href="<?php echo $product_page; ?>" target="_blank" title="[new window]">Product Page</a>
                                    |
                                <span>Support: <a href="//orbisius.com/forums/forum/community-support-forum/wordpress-plugins/orbisius-child-theme-creator/?utm_source=orbisius-child-theme-creator&utm_medium=plugin-settings&utm_campaign=product"
                                    target="_blank" title="[new window]">Forums</a>

                                    <!--|
                                     <a href="https://docs.google.com/viewer?url=https%3A%2F%2Fdl.dropboxusercontent.com%2Fs%2Fwz83vm9841lz3o9%2FOrbisius_LikeGate_Documentation.pdf" target="_blank">Documentation</a>
                                    -->
                                </span>
                            </div>

                            <h3><span>Troubleshooting</span></h3>
                            <div class="inside">
                                If your site becomes broken because of a child theme check:
                                <a href="//orbisius.com/products/wordpress-plugins/orbisius-theme-fixer/?utm_source=orbisius-child-theme-creator&utm_medium=settings_troubleshooting&utm_campaign=product"
                                target="_blank" title="[new window]">Orbisius Theme Fixer</a>
                            </div>
                        </div> <!-- .postbox -->
                        
                    </div> <!-- .meta-box-sortables -->

                </div> <!-- #postbox-container-1 .postbox-container sidebar -->

            </div> <!-- #post-body .metabox-holder .columns-2 -->

            <br class="clear">
        </div> <!-- #poststuff -->

    </div> <!-- .wrap -->

    <!--<h2>Support & Feature Requests</h2>
    <div class="updated"><p>
            ** NOTE: ** Support is handled on our site: <a href="//orbisius.com/forums/forum/community-support-forum/wordpress-plugins/orbisius-child-theme-creator/?utm_source=orbisius-child-theme-editor&utm_medium=action_screen&utm_campaign=product" target="_blank" title="[new window]">https://orbisius.com/support/</a>.
            Please do NOT use the WordPress forums or other places to seek support.
    </p></div>-->
    
    <?php
}

/**
 * Returns some plugin data such name and URL. This info is inserted as HTML
 * comment surrounding the embed code.
 * @return array
 */
function orbisius_child_theme_creator_top_links($slug_area = 'orbisius-child-theme-creator') {
    ob_start();
    $text_color = orbisius_child_theme_creator_is_pro_installed() ? 'green' : 'red';
    ?>
    <?php if ( $slug_area != 'orbisius-child-theme-creator' ) : ?>
        <style>
        .orbisius_child_theme_creator_container_res_wrapper {
            display: inline-block;
            text-align: right;
        }
        
        ul.orbisius_child_theme_creator_container_res_list {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        
        ul.orbisius_child_theme_creator_container_res_list li {
            display: inline-block;
            margin-left: 5px;
            margin-right: 5px;
            background: #eee;
            padding: 5px;
        }
        
        ul.orbisius_child_theme_creator_container_res_list li a {
            /*display: block;*/
        }
        </style>
    <?php endif; ?>
    
    <div class="orbisius_child_theme_creator_container_res_wrapper">
        <ul class="orbisius_child_theme_creator_container_res_list">
            <li>
                <a href="//qsandbox.com/?utm_source=<?php echo $slug_area; ?>&utm_medium=action_screen&utm_campaign=product"
                target="_blank" title="Opens in new tab/window. qSandbox is a service that allows you to setup a test/sandbox WordPress site in 2 seconds. No technical knowledge is required.
                Test themes and plugins before you actually put them on your site">Free Staging Site</a> <small>(quick set up)</small> by qSandbox
            </li>
            <li>
                <a href="//orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator-pro/?utm_source=<?php echo $slug_area; ?>&utm_medium=action_screen&utm_campaign=product"
                 target="_blank" title="[new window]" style="font-weight: bolder;color:<?php echo $text_color;?>">Pro Addon

                <?php if ( ! orbisius_child_theme_creator_is_pro_installed() ) : ?>

                <?php else : ?>
                    <sup>Installed!</sup>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="//orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator/?utm_source=<?php echo $slug_area; ?>&utm_medium=action_screen&utm_campaign=product" target="_blank" title="[new window]">Product Page</a>
            </li>
        </ul>
    </div>
    <?php
    $buff = ob_get_clean();

    return $buff;
}

/**
 * Returns some plugin data such name and URL. This info is inserted as HTML
 * comment surrounding the embed code.
 * @return array
 */
function orbisius_child_theme_creator_get_plugin_data() {
    // pull only these vars
    $default_headers = array(
        'Name' => 'Plugin Name',
        'PluginURI' => 'Plugin URI',
        'Description' => 'Description',
    );

    $plugin_data = get_file_data(__FILE__, $default_headers, 'plugin');

    $url = $plugin_data['PluginURI'];
    $name = $plugin_data['Name'];

    $data['name'] = $name;
    $data['url'] = $url;

    $data = array_merge($data, $plugin_data);

    return $data;
}

/**
 * Upload page.
 * Ask the user to upload a file
 * Preview
 * Process
 *
 * @package Permalinks to Category/Permalinks
 * @since 1.0
 */
function orbisius_child_theme_creator_tools_action() {
    // ACL checks *borrowed* from wp-admin/theme-install.php
    if ( ! orbisius_child_theme_creator_util::has_access() ) {
    	wp_die( __( 'You do not have sufficient permissions to install themes on this site.' ) );
    }

    $multi_site = is_multisite();

    if ( $multi_site && ! is_network_admin() ) {
        $next_url = orbisius_child_theme_creator_util::get_create_child_pages_link();

        if (headers_sent()) {
            $success = "In order to create a child theme in a multisite WordPress environment you must do it from Network Admin &gt; Appearance"
                    . "<br/><a href='$next_url' class='button button-primary'>Continue</a>";
            wp_die($success);
        } else {
            wp_redirect($next_url);
        }

        exit();
    }
    
    $msg = '';
    $errors = $success = array();
    $parent_theme_base_dirname = empty($_REQUEST['parent_theme_base_dirname']) ? '' : wp_kses($_REQUEST['parent_theme_base_dirname'], array());
    $orbisius_child_theme_creator_nonce = empty($_REQUEST['orbisius_child_theme_creator_nonce']) ? '' : $_REQUEST['orbisius_child_theme_creator_nonce'];
    $child_custom_info = empty($_REQUEST['child_custom_info']) ? array() : $_REQUEST['child_custom_info'];

    $parent_theme_base_dirname = trim($parent_theme_base_dirname);
    $parent_theme_base_dirname = preg_replace('#[^\w\-]#si', '-', $parent_theme_base_dirname);
    $parent_theme_base_dirname = preg_replace('#[_\-]+#si', '-', $parent_theme_base_dirname);
    $parent_theme_base_dirname = trim($parent_theme_base_dirname, '-');

    if (!empty($_POST) || !empty($parent_theme_base_dirname)) {
        if (!wp_verify_nonce($orbisius_child_theme_creator_nonce, basename(__FILE__) . '-action')) {
            $errors[] = "Invalid action";
        } elseif (empty($parent_theme_base_dirname) || !preg_match('#^[\w\-]+$#si', $parent_theme_base_dirname)) {
            $errors[] = "Parent theme's directory is invalid. May contain only [a-z0-9-]";
        } elseif (strlen($parent_theme_base_dirname) > 70) {
            $errors[] = "Parent theme's directory should be fewer than 70 characters long.";
        }

        if (empty($errors)) {
            try {
                $init_data = array(
                    'parent_theme_base_dirname' => $parent_theme_base_dirname,
                    'child_theme_name' => empty($child_custom_info['name']) ? '' : $child_custom_info['name'],
                );
                $installer = new orbisius_child_theme_creator();
                $installer->init($init_data);
                $theme_setup_params = $installer->custom_info($child_custom_info);

                $installer->check_permissions();
                $installer->copy_main_files();
                $installer->generate_style();
	            $installer->create_file( 'functions.php', $theme_setup_params );

	            if (!empty($_REQUEST['create_index'])) {
		            $installer->create_file( 'index.html', $theme_setup_params );
	            }

	            $installer->copy_parent_themes_options();

                // Does the user want to copy the functions.php?
                // This is dangerous and can crash the site.
                if (!empty($_REQUEST['copy_functions_php'])) {
                    $installer->add_files('functions.php');
                }

                $success[] = "The child theme has been successfully created.";
                $success[] = $installer->get_details();
                
                if (!$multi_site && !empty($_REQUEST['switch'])) {
                    $child_theme_base_dir = $installer->get_child_base_dir();
                    $theme = wp_get_theme($child_theme_base_dir);

                    if (!$theme->exists() || !$theme->is_allowed()) {
                        throw new Exception('Cannot switch to the new theme for some reason.');
                    }

                    switch_theme($theme->get_stylesheet());
                    $next_url = admin_url('themes.php?activated=true');
                    
                    if (headers_sent()) {
                        $success = "Child theme created and switched. <a href='$next_url'>Continue</a>";
                    } else {
                        wp_safe_redirect($next_url);
                        exit;
                    }
                } elseif ($multi_site && !empty($_REQUEST['orbisius_child_theme_creator_make_network_wide_available'])) {
                    // Make child theme an allowed theme (network enable theme)
                    $allowed_themes = get_site_option( 'allowedthemes' );
                    $new_theme_name = $installer->get_child_base_dir();
                    $allowed_themes[ $new_theme_name ] = true;
                    update_site_option( 'allowedthemes', $allowed_themes );
                }
            } catch (Exception $e) {
                $errors[] = "There was an error during the child theme creation.";
                $errors[] = $e->getMessage();

                if (is_object($installer->result)) {
                    $errors[] = var_export($installer->result);
                }
            }
        }
    }

    if (!empty($errors)) {
        $msg .= orbisius_child_theme_creator_util::msg($errors);
    }

    if (!empty($success)) {
        $msg .= orbisius_child_theme_creator_util::msg($success, 1);
    }
    ?>
    <div class="wrap orbisius_child_theme_creator_container">
        <h2 style="display:inline;">Orbisius Child Theme Creator</h2>
        
        <?php echo $msg; ?>

    <?php
    $buff = '';
    $buff .= "<h2>Available Parent Themes</h2>\n";

    // call to action.
    $buff .= "<div class='updated0'><p>\n";
    $buff .= "Pick a parent theme you want to use from the list below and then click on the <strong>Create Child Theme</strong> button.";
    $buff .= "</p></div>\n";
    
    $buff .= "<div id='availablethemes' class='theme_container'>\n";
    $nonce = wp_create_nonce(basename(__FILE__) . '-action');

    $args = array();
    $themes = wp_get_themes($args);

    $default_theme_thumbail = plugins_url('/assets/images/missing_theme_screenshot.jpg', ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE);

    // we use the same CSS as in WP's appearances but put only the buttons we want.
    foreach ($themes as $theme_basedir_name => $theme_obj) {
        $parent_theme = $theme_obj->get('Template');

        if (!empty($parent_theme)) {
            continue; // no kids allowed here.
        }
        
        // get the web uri for the current theme and go 1 level up
//        $src = dirname(get_template_directory_uri()) . "/$theme_basedir_name/screenshot.png";

        // get the web uri for the current theme and go 1 level up
        $web_dir = dirname(get_template_directory_uri());
        $local_dir = dirname(get_template_directory()) . "/$theme_basedir_name/";

        $src = $default_theme_thumbail;
        $src_png = $web_dir . "/$theme_basedir_name/screenshot.png";
        $src_jpg = $web_dir . "/$theme_basedir_name/screenshot.jpg";
        $src_jpg2 = $web_dir . "/$theme_basedir_name/screenshot.jpeg";

        if (file_exists($local_dir . basename($src_png))) {
            $src = $src_png;
        } elseif (file_exists($local_dir . basename($src_jpg))) {
            $src = $src_jpg;
        } elseif (file_exists($local_dir . basename($src_jpg2))) {
            $src = $src_jpg2;
        }

        $functions_file = dirname(get_template_directory()) . "/$theme_basedir_name/functions.php";
        $parent_theme_base_dirname_fmt = urlencode($theme_basedir_name);
        $create_url = $_SERVER['REQUEST_URI'];

        // cleanup old links or refreshes.
        $create_url = preg_replace('#&parent_theme_base_dirname=[\w-]+#si', '', $create_url);
        $create_url = preg_replace('#&orbisius_child_theme_creator_nonce=[\w-]+#si', '', $create_url);

        $create_url .= '&parent_theme_base_dirname=' . $parent_theme_base_dirname_fmt;
        $create_url .= '&orbisius_child_theme_creator_nonce=' . $nonce;

        /* $create_url2 = esc_url( add_query_arg(
          array( 'parent_theme_base_dirname' => $parent_theme_base_dirname_fmt,
          ), admin_url( 'themes.php' ) ) ); */

        $author_name = $theme_obj->get('Author');
        $author_name = orbisius_child_theme_creator_util::sanitize_data($author_name);
        $author_name = empty($author_name) ? 'n/a' : $author_name;

        $ver = $theme_obj->get('Version');
        $ver = orbisius_child_theme_creator_util::sanitize_data($ver);
        $ver_esc = esc_attr($ver);
        
        $theme_name = $theme_obj->get('Name');
        $theme_name = orbisius_child_theme_creator_util::sanitize_data($theme_name);

        $theme_uri = $theme_obj->get('ThemeURI');
        $theme_uri = orbisius_child_theme_creator_util::sanitize_data($theme_uri);

        $author_uri = $theme_obj->get('AuthorURI');
        $author_uri = orbisius_child_theme_creator_util::sanitize_data($author_uri);

        $author_line = empty($author_uri)
                ? $author_name
                : "<a title='Visit author homepage' href='$author_uri' target='_blank'>$author_name</a>";
        
        $author_line .= " | Ver.$ver_esc\n";

        $edit_theme_link = orbisius_child_theme_creator_util::get_theme_editor_link( array('theme_1' => $theme_basedir_name) );
        $author_line .= " | <a href='$edit_theme_link' title='Edit with Orbisius Theme Editor' class='button'>Edit</a>\n";
        
        $buff .= "<div class='available-theme'>\n";
        $buff .= "<form action='$create_url' method='post'>\n";
        $buff .= "<a href='$src' target='_blank' title='See larger version of the screenshot. [new window]'><img class='screenshot' src='$src' alt='' /></a>\n";
        $buff .= "<h3>$theme_name</h3>\n";
        $buff .= "<div class='theme-author'>By $author_line</div>\n";
        $buff .= "<div class='action-links'>\n";
        $buff .= "<ul>\n";

        if (isset($_REQUEST['orb_show_copy_functions']) && file_exists($functions_file)) {
            $adv_container_id = md5($src);

            $buff .= "
                <li>
                    <a href='javascript:void(0)' onclick='jQuery(\"#orbisius_ctc_act_adv_$adv_container_id\").slideToggle(\"slow\");'>+ Advanced</a> (show/hide)
                    <div id='orbisius_ctc_act_adv_$adv_container_id' class='app-hide'>";

            $buff .= "<label>
                                <input type='checkbox' id='orbisius_child_theme_creator_copy_functions_php' name='copy_functions_php' value='1' /> Copy functons.php
                                (<span class='app-serious-notice'><strong>Danger</strong>: if the theme doesn't support
                                <a href='https://wp.tutsplus.com/tutorials/creative-coding/understanding-wordpress-pluggable-functions-and-their-usage/'
                                    target='_blank'>pluggable functions</a> this <strong>will crash your site</strong>. Make a backup is highly recommended. In most cases you won't need to copy functions.php</span>)
                      </label>
                    ";

            $buff .= "
                    </div> <!-- /orbisius_ctc_act_adv_$adv_container_id -->
                </li>\n";
        }

        // Let's allow the user to make that theme network wide usable
        if ($multi_site) {
            $buff .= "<li>
                        <label>
                            <input type='checkbox' id='orbisius_child_theme_creator_make_network_wide_available'
                            name='orbisius_child_theme_creator_make_network_wide_available' value='1' /> Make the new theme network wide available
                        </label>
                    </li>\n";
        } else {
            $buff .= "<li><label><input type='checkbox' id='orbisius_child_theme_creator_switch' name='switch' value='1' /> "
                    . "Switch theme to the new theme after it is created</label></li>\n";
        }

	    $buff .= "<li><label><input type='checkbox' id='orbisius_child_theme_creator_create_index' name='create_index' value='1' checked='checked' /> "
	             . "Create index.html placeholder to prevent file listing in child theme directory</label></li>\n";

        // This allows the users to specify title and description of the target child theme
        $customize_info_container_id = 'orbisius_ctc_cust_info_' . md5($src);
        
        $buff .= "<li><label><input type='checkbox' id='orbisius_child_theme_creator_customize_info' name='customize_info' value='1'"
                . " onclick='jQuery(\"#$customize_info_container_id\").toggle(\"fast\");' /> "
                    . "Customize title, description etc.<br/></label></li>\n";

        $cust_info_name = 'Child of ' . $theme_name;
        $cust_info_name_esc = esc_attr($cust_info_name);

        $cust_info_descr = $theme_obj->Description;
        $cust_info_descr = wp_kses($cust_info_descr, array());
        $cust_info_descr_esc = esc_attr($cust_info_descr);

        $author_name_esc = esc_attr($author_name);
        $author_uri_esc = esc_attr($author_uri);
        $theme_uri_esc = esc_attr($theme_uri);

        $buff .= "<div id='$customize_info_container_id' class='app-hide'>
                  <table class='form-table'>
                    <tr>
                        <td>Title</td>
                        <td><input type='text' id='cust_child_theme_title_$customize_info_container_id' name='child_custom_info[name]' value='' placeholder='$cust_info_name_esc' /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea id='cust_child_theme_descr_$customize_info_container_id' name='child_custom_info[descr]' placeholder='$cust_info_descr_esc' rows='4'></textarea></td>
                    </tr>
                    <tr>
                        <td>Theme Site</td>
                        <td><input type='text' id='cust_child_theme_uri_$customize_info_container_id' name='child_custom_info[theme_uri]' value='' placeholder='$theme_uri_esc' /></td>
                    </tr>
                    <tr>
                        <td>Author Name</td>
                        <td><input type='text' id='cust_child_theme_author_$customize_info_container_id' name='child_custom_info[author]' value='' placeholder='$author_name_esc' /></td>
                    </tr>
                    <tr>
                        <td>Author Site</td>
                        <td><input type='text' id='cust_child_theme_author_site_$customize_info_container_id' name='child_custom_info[author_uri]' value='' placeholder='$author_uri_esc' /></td>
                    </tr>
                    <tr>
                        <td>Version</td>
                        <td><input type='text' id='cust_child_theme_ver_$customize_info_container_id' name='child_custom_info[ver]' value='' placeholder='$ver' /></td>
                    </tr>             
                  </table>
                </div> <!-- /$customize_info_container_id -->
        ";
        // /This allows the users to specify title and description of the target child theme

        $buff .= "<li> <button type='submit' class='button button-primary'>Create Child Theme</button> </li>\n";
    
        $buff .= "</ul>\n";
        $buff .= "</div> <!-- /action-links -->\n";
        $buff .= "</form> <!-- /form -->\n";
        $buff .= "</div> <!-- /available-theme -->\n";
    }

    $buff .= "</div> <!-- /availablethemes -->\n";

    $child_themes_cnt = 0;
    $buff_child_themes = '';
    $buff_child_themes .= "<div class='child_themes'>\n";
    $buff_child_themes .= "<h2>Child Themes</h2>\n";

    // list child themes
    // we use the same CSS as in WP's appearances but put only the buttons we want.
    foreach ($themes as $theme_basedir_name => $theme_obj) {
        $parent_theme = $theme_obj->get('Template');

        if (empty($parent_theme)) {
            continue; // no parents allowed here.
        }

        $child_themes_cnt++;

        // get the web uri for the current theme and go 1 level up
        $web_dir = dirname(get_template_directory_uri());
        $local_dir = dirname(get_template_directory()) . "/$theme_basedir_name/";

        $src = $default_theme_thumbail;
        $src_png = $web_dir . "/$theme_basedir_name/screenshot.png";
        $src_jpg = $web_dir . "/$theme_basedir_name/screenshot.jpg";
        $src_jpg2 = $web_dir . "/$theme_basedir_name/screenshot.jpeg";

        if (file_exists($local_dir . basename($src_png))) {
            $src = $src_png;
        } elseif (file_exists($local_dir . basename($src_jpg))) {
            $src = $src_jpg;
        } elseif (file_exists($local_dir . basename($src_jpg2))) {
            $src = $src_jpg2;
        }

        $author_name = $theme_obj->get('Author');
        $author_name = strip_tags($author_name);
        $author_name = empty($author_name) ? 'n/a' : $author_name;

        $author_uri = $theme_obj->get('AuthorURI');
        $author_line = empty($author_uri)
                ? $author_name
                : "<a title='Visit author homepage' href='$author_uri' target='_blank'>$author_name</a>";

//        $author_line .= " | Ver.$theme_obj->Version\n";

        if ( orbisius_child_theme_creator_util::has_access() ) {
            $activate_theme_link = orbisius_child_theme_creator_util::get_theme_activation_link( array('theme_1' => $theme_basedir_name) );
            $author_line .= " | <a href='$activate_theme_link' title='Activate this Child Theme. This will switch the site to the selected Child Theme' class='button'>Activate</a>\n";
        }
        
        $edit_theme_link = orbisius_child_theme_creator_util::get_theme_editor_link( array('theme_1' => $theme_basedir_name) );
        $author_line .= " | <a href='$edit_theme_link' title='Edit with Orbisius Theme Editor' class='button'>Edit</a>\n";

        $buff_child_themes .= "<div class='available-theme'>\n";
        $buff_child_themes .= "<img class='screenshot' src='$src' alt='' />\n";
        $buff_child_themes .= "<h3>$theme_obj->Name</h3>\n";
        $buff_child_themes .= "<div class='theme-author'>By $author_line</div>\n";
        $buff_child_themes .= "</div> <!-- /available-theme -->\n";
    }

    if ( $child_themes_cnt == 0 ) {
        $buff_child_themes .= "<div>No child themes found.</div>\n";
    }

    $buff_child_themes .= "</div> <!-- /child themes -->\n";
    
    ?>

    <div class="wrap orbisius_child_theme_creator_container">
        <div id="icon-options-general" class="icon32"></div>
        <!--<h2>Name String</h2>-->

        <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-2">

                <!-- main content -->
                <div id="post-body-content">

                    <div class="meta-box-sortables ui-sortable">

                        <div class="postbox">
                            <!--<h3><span>Main Content Header</span></h3>-->
                            <div class="inside">
                                <?php echo $buff; ?>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                        <div class="postbox">
                            <!--<h3><span>Main Content Header</span></h3>-->
                            <div class="inside">
                                <?php echo $buff_child_themes; ?>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                    </div> <!-- .meta-box-sortables .ui-sortable -->

                </div> <!-- post-body-content -->

                <!-- sidebar -->
                <div id="postbox-container-1" class="postbox-container">

                    <div class="meta-box-sortables">
                        <div class="postbox"> <!-- quick-contact -->
                            <?php
                            $current_user = wp_get_current_user();
                            $email = empty($current_user->user_email) ? '' : $current_user->user_email;
                            $quick_form_action = is_ssl()
                                    ? 'https://ssl.orbisius.com/apps/quick-contact/'
                                    : 'https://apps.orbisius.com/quick-contact/';

                            if (!empty($_SERVER['DEV_ENV'])) {
                                $quick_form_action = 'https://localhost/projects/quick-contact/';
                            }
                            ?>
                            <script>
                                var octc_quick_contact = {
                                    validate_form : function () {
                                        try {
                                            var msg = jQuery('#octc_msg').val().trim();
                                            var email = jQuery('#octc_email').val().trim();

                                            email = email.replace(/\s+/, '');
                                            email = email.replace(/\.+/, '.');
                                            email = email.replace(/\@+/, '@');

                                            if ( msg == '' ) {
                                                alert('Enter your message.');
                                                jQuery('#octc_msg').focus().val(msg).css('border', '1px solid red');
                                                return false;
                                            } else {
                                                // all is good clear borders
                                                jQuery('#octc_msg').css('border', '');
                                            }

                                            if ( email == '' || email.indexOf('@') <= 2 || email.indexOf('.') == -1) {
                                                alert('Enter your email and make sure it is valid.');
                                                jQuery('#octc_email').focus().val(email).css('border', '1px solid red');
                                                return false;
                                            } else {
                                                // all is good clear borders
                                                jQuery('#octc_email').css('border', '');
                                            }

                                            return true;
                                        } catch(e) {};
                                    }
                                };
                            </script>
                            <h3><span>Quick Question or Suggestion</span></h3>
                            <div class="inside">
                                <div>
                                    <form method="post" action="<?php echo $quick_form_action; ?>" target="_blank">
                                        <?php
                                            global $wp_version;
											$plugin_data = get_plugin_data(__FILE__);

                                            $hidden_data = array(
                                                'site_url' => site_url(),
                                                'wp_ver' => $wp_version,
                                                'first_name' => $current_user->first_name,
                                                'last_name' => $current_user->last_name,
                                                'product_name' => $plugin_data['Name'],
                                                'product_ver' => $plugin_data['Version'],
                                                'woocommerce_ver' => defined('WOOCOMMERCE_VERSION') ? WOOCOMMERCE_VERSION : 'n/a',
                                            );
                                            $hid_data = http_build_query($hidden_data);
                                            echo "<input type='hidden' name='data[sys_info]' value='$hid_data' />\n";
                                        ?>
                                        <textarea class="widefat" id='octc_msg' name='data[msg]' required="required"></textarea>
                                        <br/>Your Email: <input type="text" class=""
                                               id="octc_email" name='data[sender_email]' placeholder="Email" required="required"
                                               value="<?php echo esc_attr($email); ?>"
                                               />
                                        <br/><input type="submit" class="button-primary" value="<?php _e('Send Feedback') ?>"
                                                    onclick="return octc_quick_contact.validate_form();" />
                                        <br/>
                                        What data will be sent
                                        <a href='javascript:void(0);'
                                            onclick='jQuery(".octc_data_to_be_sent").toggle();'>(show/hide)</a>
                                        <div class="hide app-hide octc_data_to_be_sent">
                                            <textarea class="widefat" rows="4" readonly="readonly" disabled="disabled"><?php
                                            foreach ($hidden_data as $key => $val) {
                                                if (is_array($val)) {
                                                    $val = var_export($val, 1);
                                                }

                                                echo "$key: $val\n";
                                            }
                                            ?></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox --> <!-- /quick-contact -->

                        <div class="postbox">
                            <h3><span>Other products of ours</span></h3>
                            <div class="inside">
                                <?php echo orbisius_child_theme_creator_top_links('orbisius-child-theme-creator') ; ?>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                        <div class="postbox">
                            <h3><span>Hire Us</span></h3>
                            <div class="inside">
                                Hire us to create a plugin/web/mobile app for your business.
                                <br/><a href="//orbisius.com/page/free-quote/?utm_source=orbisius-child-theme-creator&utm_medium=plugin-settings&utm_campaign=product"
                                   title="If you want a custom web/mobile app/plugin developed contact us. This opens in a new window/tab"
                                    class="button-primary" target="_blank">Get a Free Quote</a>
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                        <div class="postbox">
                            <h3><span>Newsletter</span></h3>
                            <div class="inside">
                                <!-- Begin MailChimp Signup Form -->
                                <div id="mc_embed_signup">
                                    <?php
                                        $current_user = wp_get_current_user();
                                        $email = empty($current_user->user_email) ? '' : $current_user->user_email;
                                    ?>

                                    <form action="https://WebWeb.us2.list-manage.com/subscribe/post?u=005070a78d0e52a7b567e96df&amp;id=1b83cd2093" method="post"
                                          id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                                        <input type="hidden" value="settings" name="SRC2" />
                                        <input type="hidden" value="orbisius-child-theme-creator" name="SRC" />

                                        <span>Get notified about cool plugins we release</span>
                                        <!--<div class="indicates-required"><span class="app_asterisk">*</span> indicates required
                                        </div>-->
                                        <div class="mc-field-group">
                                            <label for="mce-EMAIL">Email <span class="app_asterisk">*</span></label>
                                            <input type="email" value="<?php echo esc_attr($email); ?>" name="EMAIL" class="required email" id="mce-EMAIL">
                                        </div>
                                        <div id="mce-responses" class="clear">
                                            <div class="response" id="mce-error-response" style="display:none"></div>
                                            <div class="response" id="mce-success-response" style="display:none"></div>
                                        </div>	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button-primary"></div>
                                    </form>
                                </div>
                                <!--End mc_embed_signup-->
                            </div> <!-- .inside -->
                        </div> <!-- .postbox -->

                        <?php //orbisius_child_theme_creator_util::output_orb_widget(); ?>

                        <?php
                                        $plugin_data = get_plugin_data(__FILE__);
                                        $product_name = trim($plugin_data['Name']);
                                        $product_page = trim($plugin_data['PluginURI']);
                                        $product_descr = trim($plugin_data['Description']);
                                        $product_descr_short = substr($product_descr, 0, 50) . '...';

                                        $base_name_slug = basename(__FILE__);
                                        $base_name_slug = str_replace('.php', '', $base_name_slug);
                                        $product_page .= (strpos($product_page, '?') === false) ? '?' : '&';
                                        $product_page .= "utm_source=$base_name_slug&utm_medium=plugin-settings&utm_campaign=product";

                                        $product_page_tweet_link = $product_page;
                                        $product_page_tweet_link = str_replace('plugin-settings', 'tweet', $product_page_tweet_link);
                                    ?>

                        <div class="postbox">
                            <div class="inside">
                                <!-- Twitter: code -->
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                <!-- /Twitter: code -->

                                <!-- Twitter: Orbisius_Follow:js -->
                                    <a href="//twitter.com/orbisius" class="twitter-follow-button"
                                       data-align="right" data-show-count="false">Follow @orbisius</a>
                                <!-- /Twitter: Orbisius_Follow:js -->

                                &nbsp;

                                <!-- Twitter: Tweet:js -->
                                <a href="//twitter.com/share" class="twitter-share-button"
                                   data-lang="en" data-text="Checkout Orbisius Child Theme Creator #WordPress #plugin.Create Child Themes in Seconds"
                                   data-count="none" data-via="orbisius" data-related="orbisius"
                                   data-url="<?php echo $product_page_tweet_link;?>">Tweet</a>
                                <!-- /Twitter: Tweet:js -->


                                <br/>
                                 <a href="<?php echo $product_page; ?>" target="_blank" title="[new window]">Product Page</a>
                                    |
                                <span>Support: <a href="//orbisius.com/forums/forum/community-support-forum/wordpress-plugins/orbisius-child-theme-creator/?utm_source=orbisius-child-theme-creator&utm_medium=plugin-settings&utm_campaign=product"
                                    target="_blank" title="[new window]">Forums</a>

                                    <!--|
                                     <a href="https://docs.google.com/viewer?url=https%3A%2F%2Fdl.dropboxusercontent.com%2Fs%2Fwz83vm9841lz3o9%2FOrbisius_LikeGate_Documentation.pdf" target="_blank">Documentation</a>
                                    -->
                                </span>
                            </div>

                            <h3><span>Troubleshooting</span></h3>
                            <div class="inside">
                                If your site becomes broken because of a child theme check:
                                <a href="//orbisius.com/products/wordpress-plugins/orbisius-theme-fixer/?utm_source=orbisius-child-theme-creator&utm_medium=settings_troubleshooting&utm_campaign=product"
                                target="_blank" title="[new window]">Orbisius Theme Fixer</a>
                            </div>
                        </div> <!-- .postbox -->
                        
                    </div> <!-- .meta-box-sortables -->

                </div> <!-- #postbox-container-1 .postbox-container sidebar -->

            </div> <!-- #post-body .metabox-holder .columns-2 -->

            <br class="clear">
        </div> <!-- #poststuff -->

        <?php //orbisius_child_theme_creator_util::output_orb_widget('author'); ?>
    </div> <!-- .wrap -->
    <?php
}

/**
 * It seems WP intentionally adds slashes for consistency with php.
 * Please note: WordPress Core and most plugins will still be expecting slashes, and the above code will confuse and break them.
 * If you must unslash, consider only doing it to your own data which isn't used by others:
 * @see https://codex.wordpress.org/Function_Reference/stripslashes_deep
 */
function orbisius_child_theme_creator_get_request($key = null, $default = '') {
    $req = $_REQUEST;
    $req = stripslashes_deep($req);

    if (!empty($key)) {
        $val = isset($req[$key]) ? $req[$key] : $default;
        return $val;
    }

    return $req;
}

/**
 * orbisius_child_theme_creator_get();
 * @param str $key
 * @param str $default
 * @return mixed
 */
function orbisius_child_theme_creator_get($key = null, $default = '') {
    $val = orbisius_child_theme_creator_get_request($key, $default);
    
    if (is_scalar($val)) {
        $val = wp_kses($val, array());
        $val = trim($val);
    } elseif (is_array($key)) {
        $val = array_map('orbisius_child_theme_creator_get', $key);
    }
    
    return $val;
}


/**
 * adds some HTML comments in the page so people would know that this plugin powers their site.
 */
function orbisius_child_theme_creator_add_plugin_credits() {
    // pull only these vars
    $default_headers = array(
        'Name' => 'Plugin Name',
        'PluginURI' => 'Plugin URI',
    );

    $plugin_data = get_file_data(__FILE__, $default_headers, 'plugin');

    $url = $plugin_data['PluginURI'];
    $name = $plugin_data['Name'];

    printf(PHP_EOL . PHP_EOL . '<!-- ' . "Powered by $name | URL: $url " . '-->' . PHP_EOL . PHP_EOL);
}

/**
 */
class orbisius_child_theme_creator {
    public $result = null;
    public $target_dir_path; // /var/www/vhosts/domain.com/www/wp-content/themes/Parent-Theme-child-01/

    /**
     * Sets up the params.
     * directories contain trailing slashes.
     * 
     * @param str $parent_theme_basedir
     */

    public function init($init_data = array()) {
        $all_themes_root = get_theme_root();
        $parent_theme_basedir = orbisius_child_theme_creator_util::sanitize_data( $init_data['parent_theme_base_dirname'] );

        $this->parent_theme_basedir = $parent_theme_basedir;
        $this->parent_theme_dir = $all_themes_root . '/' . $this->parent_theme_basedir . '/';

        if (empty($init_data['child_theme_name'])) {
            $child_theme_dir = $parent_theme_basedir . '-child-theme';
        } else { // own dir based on the name the user has entered
            $child_theme_dir = sanitize_title($init_data['child_theme_name']);
        }

        // Let's create multiple folders in case the script is run multiple times.
        $i = 0;
        
        do {
            $suff = empty($i) ? '' : '_' . sprintf('%02d', $i);
            $target_dir = $all_themes_root . '/' . $child_theme_dir . $suff . '/';
            $i++;
        } while (is_dir($target_dir));

        $this->target_dir_path = $target_dir;
        $this->target_base_dirname = basename($target_dir);

        // this is appended to the new theme's name
        $this->target_name_suffix = "Child theme of $parent_theme_basedir";
    }

    /**
     * @param void
     * @return string returns the dirname (not abs) of the child theme
     */
    public function get_child_base_dir() {
        return $this->target_base_dirname;
    }

    private $custom_info = array();

    /**
     * Get/sets custom info that is related to the child theme
     * It accepts array or key val or just get all of the custom data
     * @param void
     * @return string returns the dirname (not abs) of the child theme
     */
    public function custom_info($key = null, $value = null) {
        if (!is_null($key)) {
            if (is_array($key)) { // set array
                $this->custom_info = orbisius_child_theme_creator_util::sanitize_data($key);
            } else if (!is_null($value)) { // set scalar
                $this->custom_info[$key] = orbisius_child_theme_creator_util::sanitize_data($value);
            } else { // get for a key
                return $this->custom_info[$key];
            }
        }
        
        if ( empty( $this->custom_info['parent_theme_basedir'] ) ) {
            $this->custom_info['parent_theme_basedir'] = $this->parent_theme_basedir;
        }

        if ( empty( $this->custom_info['parent_theme_dir'] ) ) {
            $this->custom_info['parent_theme_dir'] = $this->parent_theme_dir;
        }

        return $this->custom_info; // all custom info requested
    }

    /**
     * Loads files from a directory but skips . and ..
     */
    public function load_files($dir) {
        $files = orbisius_child_theme_creator_util::load_files();
        return $files;
    }

    private $info_result = 'n/a';
    private $data_file = '.ht_orbisius_child_theme_creator.json';

    /**
     * Checks for correct permissions by trying to create a file in the target dir
     * Also it checks if there are files in the target directory in case it exists.
     */
    public function check_permissions() {
        $target_dir_path = $this->target_dir_path;

        if (!is_dir($target_dir_path)) {
            if (!mkdir($target_dir_path, 0775)) {
                throw new Exception("Target child theme directory cannot be created. This is probably a permission error. Cannot continue.");
            }
        } else { // let's see if there will be files in that folder.
            $files = $this->load_files($target_dir_path);

            if (count($files) > 0) {
                throw new Exception("Target folder already exists and has file(s) in it. Cannot continue. Files: ["
                . join(',', array_slice($files, 0, 5)) . ' ... ]');
            }
        }

        // test if we can create the folder and then delete it.
        if (!touch($target_dir_path . $this->data_file)) {
            throw new Exception("Target directory is not writable.");
        }
    }

    /**
     * What files do we have to copy from the parent theme.
     * @var array
     */
    private $main_files = array('screenshot.png', 'screenshot.jpg', 'screenshot.jpeg', 'header.php', 'footer.php', );

    /**
     * 
     */
    public function add_files($files) {
        $files = (array) $files;
        $this->main_files = array_merge($files, $this->main_files);
    }
    
    /**
     * Copy some files from the parent theme.
     * @return bool success
     */
    public function copy_main_files() {
        $stats = 0;

        $main_files = $this->main_files;

        foreach ($main_files as $file) {
            if (!file_exists($this->parent_theme_dir . $file)) {
                continue;
            }

            $stat = copy($this->parent_theme_dir . $file, $this->target_dir_path . $file);
            $stat = intval($stat);
            $stats += $stat;
        }

        // Some themes have admin files for control panel stuff. So Let's copy it as well.
        if (is_dir($this->parent_theme_dir . 'admin/')) {
            orbisius_child_theme_creator_util::copy($this->parent_theme_dir . 'admin/', $this->target_dir_path . 'admin/');
        }
    }

    /**
     *
     * @return bool success
     * @see https://codex.wordpress.org/Child_Themes
     */
    public function generate_style() {
        global $wp_version;

        $plugin_data = get_plugin_data(__FILE__);
        $app_link = $plugin_data['PluginURI'];
        $app_title = $plugin_data['Name'];

        $parent_theme_data = wp_get_theme($this->parent_theme_basedir);
        $theme_name = "$parent_theme_data->Name $this->target_name_suffix";
        $theme_uri = $parent_theme_data->ThemeURI;
        $theme_descr = "$this->target_name_suffix theme for the $parent_theme_data->Name theme";
        $theme_author = $parent_theme_data->Author;
        $theme_author_uri = $parent_theme_data->AuthorURI;
        $ver = $parent_theme_data->Version;

        $custom_info = $this->custom_info();

        if (!empty($custom_info['name'])) {
            $theme_name = $custom_info['name'];
        }

        if (!empty($custom_info['theme_uri'])) {
            $theme_uri = $custom_info['theme_uri'];
        }

        if (!empty($custom_info['descr'])) {
            $theme_descr = $custom_info['descr'];
        }

        if (!empty($custom_info['author'])) {
            $theme_author = $custom_info['author'];
        }

        if (!empty($custom_info['author_uri'])) {
            $theme_author_uri = $custom_info['author_uri'];
        }

        if (!empty($custom_info['ver'])) {
            $ver = $custom_info['ver'];
        }

        $buff = '';
        $buff .= "/*\n";
        $buff .= "Theme Name: $theme_name\n";
        $buff .= "Theme URI: $theme_uri\n";
        $buff .= "Description: $theme_descr\n";
        $buff .= "Author: $theme_author\n";
        $buff .= "Author URI: $theme_author_uri\n";
        $buff .= "Template: $this->parent_theme_basedir\n";
        $buff .= "Version: $ver\n";
        $buff .= "*/\n";

        $buff .= "\n/* Generated by $app_title ($app_link) on " . date('r') . " */ \n";
        $buff .= "/* The plugin now uses the recommended approach for loading the css files.*/\n";
        $buff .= "\n";
        //$buff .= "@import url('../$this->parent_theme_basedir/style.css');\n";

        file_put_contents($this->target_dir_path . 'style.css', $buff, LOCK_EX);

        // RTL langs; make rtl.css to point to the parent file as well
        if (file_exists($this->parent_theme_dir . 'rtl.css')) {
            $rtl_buff = '';
            $rtl_buff .= "/*\n";
            $rtl_buff .= "Theme Name: $theme_name\n";
            $rtl_buff .= "Template: $this->parent_theme_basedir\n";
            $rtl_buff .= "*/\n";

            $rtl_buff .= "\n/* Generated by $app_title ($app_link) on " . date('r') . " */ \n\n";

            $rtl_buff .= "@import url('../$this->parent_theme_basedir/rtl.css');\n";

            file_put_contents($this->target_dir_path . 'rtl.css', $rtl_buff, LOCK_EX);
        }

        $themes_url = admin_url('themes.php');
        $edit_new_theme_url = admin_url('themes.php?page=orbisius_child_theme_creator_theme_editor_action&theme_1=' 
                . urlencode($this->target_base_dirname));

        $target_dir_path_rel = $this->target_dir_path;
        $target_dir_path_rel = preg_replace( '#.*wp-content[\/\\\]#si', '', $target_dir_path_rel );
        $this->info_result = "$parent_theme_data->Name " . $this->target_name_suffix . ' has been created in ' . $target_dir_path_rel
                . ' based on ' . $parent_theme_data->Name . ' theme.'
                . "\n<br/>Next go to <a href='$themes_url'><strong>Appearance &gt; Themes</strong></a> and Activate the new theme "
                . "or <a href='$edit_new_theme_url'>edit the new theme</a>.";
    }

    /**
     *
     * @param str $parent_theme_slug
     * @return boolean
     */
    function get_parent_themes_options( $parent_theme_slug = '' ) {
       global $wpdb;
       $theme = wp_get_theme( $parent_theme_slug );

       // Do we have a theme? We should!
       if ( empty( $theme ) || ! $theme->exists() ) {
           return false;
       }

       // The parent theme's folder will be
       // e.g. twentysixteen and we'll use that to look in the db
       // for any settings (if any).
       $tpl_dir = get_template_directory();
       $theme_slug = basename( $tpl_dir );
       $text_domain = $theme->get( 'TextDomain' );

       $where_arr = $bind_params = array();
       $where_arr[] = " `option_name` = '%s' "; // exact match; twentysixteen
       $where_arr[] = " `option_name` LIKE '%%%s' "; // the match must be trailing theme_mods_twentysixteen
       $bind_params[] = $theme_slug;
       $bind_params[] = $theme_slug;

       if ( ! empty( $text_domain ) && $text_domain != $theme_slug ) {
           $where_arr[] = " `option_name` = '%s' "; // exact match; twentysixteen
           $where_arr[] = " `option_name` LIKE '%%%s'"; // the match must be trailing theme_mods_twentysixteen
           $bind_params[] = $text_domain;
           $bind_params[] = $text_domain;
       }

       // https://wordpress.stackexchange.com/questions/67292/how-to-use-wildcards-in-wpdb-queries-using-wpdb-get-results-wpdb-prepare
       $sql_prep = $wpdb->prepare("
           SELECT option_name
           FROM {$wpdb->prefix}options
           WHERE ( " . join( ' OR ', $where_arr ) . " )
           LIMIT 25",
           $bind_params
       );

       $opts = array();
       $results = $wpdb->get_results( $sql_prep, ARRAY_A );

       foreach ( $results as $rec ) {
           $option_name = $rec['option_name'];
           $option_val = get_option( $option_name );
           $opts[ $option_name ] = $option_val;
       }

       $result = array(
           'options' => $opts,
           'parent_theme_slug' => $theme_slug,
           'parent_theme_text_domain' => $text_domain,
       );

       return $result;
    }

    /**
    * Searches the options table for option names that match the slug of the current theme.
    * We'll prefix them with the child theme's folder so it has some data.
    * @global obj $wpdb
    * @param str $theme
    */
   function copy_parent_themes_options( $child_theme_slug = '' ) {
       $child_theme_slug = empty( $child_theme_slug ) ? $this->target_base_dirname : $child_theme_slug;
       $result = $this->get_parent_themes_options();

       foreach ( $result['options'] as $option_name => $option_val ) {
           // boxed-wp or theme_mods_boxed-wp
           if ( ! empty( $result['parent_theme_slug'] ) ) {
               $child_theme_option_name = str_ireplace( $result['parent_theme_slug'], $child_theme_slug, $option_name );
           }

           if ( ! empty( $result['parent_theme_text_domain'] ) ) {
               $child_theme_option_name = str_ireplace( $result['parent_theme_text_domain'], $child_theme_slug, $option_name );
           }

           $child_theme_val = get_option( $child_theme_option_name );
           
           if ( ( $child_theme_val === false ) && ( $option_val !== false ) ) {
               update_option( $child_theme_option_name, $option_val );
           }
       }

       return true;
   }

    /**
     *
     * @return string
     */
    public function get_details() {
        return $this->info_result;
    }

    /**
     *
     * @param type $filename
     */
    function log($msg) {
        error_log($msg . "\n", 3, ini_get('error_log'));
    }

    /**
     * 
     * @param str $file
     * @return bool
     */
    public function create_file($file, $params = array() ) {
        if (strpos($file, '.html') !== false) {
            $default_buff = <<<'BUFF_EOF'
<!DOCTYPE html>
<html>
	<title>Hello</title>
<body>
	<h3>Generated By Orbisius Child Theme Creator - your favorite plugin for WordPress Child Theme creation and editing :)</h3>

	<br />
	Plugin URL: <a href="https://orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator" 
	title="WordPress Plugin for Child Theme creation"
	target="_blank">Orbisius Child Theme Creator</a>
	<br />	
</body>
</html>
BUFF_EOF;

	        $file_tpl = empty($params['buff']) ? $default_buff : $params['buff'];
            $full_file = $this->target_dir_path . ltrim($file, '/\\');
	        $file_tpl = trim($file_tpl);

	        if (!file_exists($full_file) || !empty($params['override'])) {
		        $res = file_put_contents($full_file, $file_tpl, LOCK_EX);
		        return $res;
	        }

	        return true;
        } elseif ($file == 'functions.php') {
            $parent_base_dir = $params['parent_theme_basedir'];
            // this should be unique dir so use it for function
            $func_prefix = strtolower( $this->target_base_dirname );
            $func_prefix = 'orbisius_ct_' . preg_replace( '#[^\w]+#si', '_', $func_prefix );
            $func_prefix = trim( $func_prefix, '_' );

            $file_tpl = <<<'BUFF_EOF'
<?php
/*
* Generated By Orbisius Child Theme Creator - your favorite plugin for Child Theme creation and editing :)
* https://orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator
*
* Unlike style.css, the functions.php of a child theme does not override its counterpart from the parent.
* Instead, it is loaded in addition to the parent’s functions.php. (Specifically, it is loaded right before the parent theme's functions.php).
* Source: https://codex.wordpress.org/Child_Themes#Using_functions.php
*
* When copying functions from the parent theme make sure you use function_exists( 'put_the_function_name_here' ) calls.
* Otherwise having functions with the same name will crash the site.
* Also when adding new functions do put prefix before the function names to ensure uniqueness.
*/

/**
 * Loads parent theme's style first and then child theme's style.css so you can override parent styles
 */
function {$func_prefix}_child_theme_enqueue_styles() {
	global $wp_styles;

    $parent_style = '{$func_prefix}_parent_style';
    $parent_base_dir = '{$parent_base_dir}';
	$child_dir_id = basename(get_stylesheet_directory());

	// WP enqueues the child style automatically. We want to dequeue it so we can load parent first and child theme's css later
	// We'll also append the last modified times for versions and for better cache clean up.
	if ( ! empty( $wp_styles->queue ) ) {
		$srch_arr = [
			$parent_base_dir,
			$parent_base_dir . '-style',
			$parent_base_dir . '_style',
			$child_dir_id,
			$child_dir_id . '-style',
			$child_dir_id . '_style',
		];

		foreach ( $wp_styles->queue as $registered_style_id ) {
			if ( in_array( $registered_style_id, $srch_arr ) ) {
				wp_dequeue_style( $registered_style_id );
				wp_deregister_style( $registered_style_id );
			}
		}
	}

    // We use last modified as version as it's a reliable way to tell when the file was modified so
    // the browser can load the new file if necessary and not use the cached version.
    $parent_ver = time();
    $parent_style_css_file = get_template_directory() . '/style.css';

    if (file_exists($parent_style_css_file)) {
    	$parent_ver = filemtime($parent_style_css_file);
    } else {
    	$v = wp_get_theme( $parent_base_dir )->get('Version');

    	if (!empty($v)) {
		    $parent_ver = $v;
	    }
    }

    wp_enqueue_style( $parent_style,
        get_template_directory_uri() . '/style.css',
        array(),
	    $parent_ver
    );

    wp_enqueue_style( $parent_style . '_child_style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}

add_action( 'wp_enqueue_scripts', '{$func_prefix}_child_theme_enqueue_styles', 25 );

function {$func_prefix}_example_function() {
    // put some code here
}
BUFF_EOF;

            $file_tpl = ltrim( $file_tpl ); // we want some trailing space

            // It's Nowdoc so we have to replace php vars
            $file_tpl = str_replace('{$func_prefix}',  $func_prefix, $file_tpl );
            $file_tpl = str_replace('{$parent_base_dir}',  $parent_base_dir, $file_tpl );

            $file = $this->target_dir_path . $file;
            $res = file_put_contents($file, $file_tpl, LOCK_EX);
	        return $res;
        }

        return false;
    }
}

/**
 * Util funcs
 */
class orbisius_child_theme_creator_util {
    /**
     * orbisius_child_theme_creator_util::has_access()
     */
    public static function has_access() {
        return current_user_can( 'switch_themes' ) && current_user_can( 'install_themes' );
    }
    
    /**
     * Loads news from Club Orbsius Site.
     * <?php orbisius_child_theme_creator_util::output_orb_widget(); ?>
     */
    public static function output_orb_widget($obj = '', $return = 0) {
        $buff = '';
        ob_start();
        ?>
            <!-- Orbisius -->
            <div class="postbox">
                <h3><span>Curious about our other products?</span></h3>
                <div class="inside">
                    Visit <a href="//orbisius.com/products/" target="_blank">https://orbisius.com/products/</a>
                </div> <!-- .inside -->
            </div> <!-- .postbox -->
            <!-- /Orbisius -->
        <?php
        $buff = ob_get_clean();
        
        if ($return) {
            return $buff;
        } else {
            echo $buff;
        }
    }
    
    /**
     * This cleans filenames but leaves some of the / because some files can be dir1/file.txt.
     * $jail_root must be added because it will also prefix the path with a directory i.e. jail
     *
     * @param type $file_name
     * @param type $jail_root
     * @return string
     */
    public static function sanitize_file_name($file_name = null, $jail_root = '') {
        if (empty($jail_root)) {
            $file_name = sanitize_file_name($file_name); // wp func
        } else {
            $file_name = str_replace('/', '__SLASH__', $file_name);
            $file_name = sanitize_file_name($file_name); // wp func
            $file_name = str_replace('__SLASH__', '/', $file_name);
        }

        $file_name = preg_replace('#(?:\/+|\\+)#si', '/', $file_name);
        $file_name = ltrim($file_name, '/'); // rm leading /

        // it seems sanitize_file_name confuses .min the WP sanitizer.
        // /assets/css/boxicons.min_.css
        if (stripos($file_name, '.min_.') !== false) {
	        $file_name = str_replace('.min_.js', '.min.js', $file_name);
	        $file_name = str_replace('.min_.css', '.min.css', $file_name);
        }

        if (!empty($jail_root)) {
            $file_name = $jail_root . $file_name;
        }

        return $file_name;
    }

    /**
     * Uses wp_kses to sanitize the data
     * @param  string|array $value
     * @return mixed: str/array
     * @throws Exception
     */
    public static function sanitize_data($value = null) {
        if (is_scalar($value)) {
            $value = wp_kses($value, array());
            $value = preg_replace('#\s+#si', ' ', $value);
            $value = trim($value);
        } else if (is_array($value)) {
            $value = array_map(__METHOD__, $value);
        } else {
            throw new Exception(__METHOD__.  " Cannot sanitize because of invalid input data.");
        }

        return $value;
    }

    /**
     * Returns a link to appearance. Taking into account multisite.
     * 
     * @param array $params
     * @return string
     */
    static public function get_create_child_pages_link($params = array()) {
        $rel_path = 'themes.php?page=orbisius_child_theme_creator_themes_action';

        if (!empty($params)) {
            $rel_path = orbisius_child_theme_creator_html::add_url_params($rel_path, $params);
        }

        $create_child_themes_page_link = is_multisite()
                    ? network_admin_url($rel_path)
                    : admin_url($rel_path);

        return $create_child_themes_page_link;
    }

    /**
     * Returns the link to the Theme Editor e.g. when a theme_1 or theme_2 is supplied.
     * @param type $params
     * @return string
     */
    static public function get_theme_editor_link($params = array()) {
        $rel_path = 'themes.php?page=orbisius_child_theme_creator_theme_editor_action';

        if (!empty($params)) {
            $rel_path = orbisius_child_theme_creator_html::add_url_params($rel_path, $params);
        }

        $link = is_multisite()
                    ? network_admin_url($rel_path)
                    : admin_url($rel_path);

        return $link;
    }

    /**
     * Returns the link to the Theme Editor e.g. when a theme_1 or theme_2 is supplied.
     * @param type $params
     * @return string
     */
    static public function get_theme_activation_link($params = array()) {
        $nonce = wp_create_nonce( 'orbisius_child_theme_creator_data' );
        
        $url_params = array(
            'page' => 'orbisius_child_theme_creator_themes_action',
            'orbisius_child_theme_creator_data[cmd]' => 'theme.activate',
            'orbisius_child_theme_creator_data[theme]' => $params['theme_1'],
            'orbisius_child_theme_creator_data[nonce]' => $nonce,
        );
        
        $rel_path = 'themes.php?' . http_build_query( $url_params );
    
        if (!empty($params)) {
            $rel_path = orbisius_child_theme_creator_html::add_url_params($rel_path, $url_params);
        }

        $link = is_multisite()
                    ? network_admin_url($rel_path)
                    : admin_url($rel_path);

        return $link;
    }

    /**
     * Returns the link to the Theme Editor e.g. when a theme_1 or theme_2 is supplied.
     * @param type $params
     * @return string
     */
    static public function get_settings_link($params = array()) {
        $rel_path = 'options-general.php?page=orbisius_child_theme_creator_settings_page';

        if (!empty($params)) {
            $rel_path = orbisius_child_theme_creator_html::add_url_params($rel_path, $params);
        }

        $link = is_multisite()
                    ? network_admin_url($rel_path)
                    : admin_url($rel_path);

        return $link;
    }

    /**
     * Recursive function to copy (all subdirectories and contents).
     * It doesn't create folder in the target folder.
     * Note: this may be slow if there are a lot of files.
     * The native call might be quicker.
     *
     * Example: src: folder/1/ target: folder/2/
     * @see https://stackoverflow.com/questions/5707806/recursive-copy-of-directory
     */
    static public function copy($src, $dest, $perm = 0775) {
        if (!is_dir($dest)) {
            mkdir($dest, $perm, 1);
        }

        if (is_dir($src)) {
            $dir = opendir($src);

            while ( false !== ( $file = readdir($dir) ) ) {
                if ( $file == '.' || $file == '..' || $file == '.git'  || $file == '.svn' ) {
                    continue;
                }

                $new_src = rtrim($src, '/') . '/' . $file;
                $new_dest = rtrim($dest, '/') . '/' . $file;

                if ( is_dir( $new_src ) ) {
                    self::copy( $new_src, $new_dest );
                } else {
                    copy( $new_src, $new_dest );
                }
            }

            closedir($dir);
        } else { // can also handle simple copy commands
            copy($src, $dest);
        }
    }

    /**
     * Create an zip file. Requires ZipArchive class to exist.
     * Usage: $result = create_zip($files_to_zip, 'my-archive.zip', true, $prefix_to_strip, 'Slavi created this archive at ' . date('r') );
     *
     * @param array $files
     * @param str $destination zip file
     * @param str $overwrite
     * @param str $prefix_to_strip
     * @param str $comment
     * @return boolean
     */
    function create_zip($files = array(), $destination = '', $overwrite = false, $prefix_to_strip = '', $comment = '' ) {
        if ((file_exists($destination) && !$overwrite) || !class_exists('ZipArchive')) {
            return false;
        }

        $zip = new ZipArchive();

        if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            return false;
        }

        foreach ($files as $file) {
            // if we specify abs path to the dir we'll add a relative folder in the archive.
            $file_in_archive = str_ireplace($prefix_to_strip, '', $file);
            $zip->addFile($file, $file_in_archive);
        }

        if (!empty($comment)) {
            $zip->setArchiveComment($comment);
        }

        $zip->close();

        return file_exists($destination);
    }

    /**
     * Loads files from a directory and skips . and ..
     * By default it retuns files relativ to the theme's folder.
     * 
     * @since 1.1.3 it supports recusiveness
     * @param bool $ret_full_paths
     */
    public static function load_files($dir, $ret_full_paths = 0) {
        $files = array();

        $dir = rtrim($dir, '/') . '/';
        $all_files = scandir($dir);

        foreach ($all_files as $file) {
            if ($file == '.' || $file == '..' || substr($file, 0, 1) == '.') { // skip hidden files
                continue;
            }

            if (is_dir($dir . $file)) {
                $dir_in_themes_folder = $file;
                $sub_dir_files = self::load_files($dir . $dir_in_themes_folder, $ret_full_paths);
                
                foreach ($sub_dir_files as $sub_dir_file) {
                    $files[] = $ret_full_paths ? $sub_dir_file : $dir_in_themes_folder . '/' . $sub_dir_file;
                }
            } else {
                $files[] = ($ret_full_paths ? $dir : '') . $file;
            }
        }

        return $files;
    }

    /**
     * Outputs a message (adds some paragraphs).
     */
    static public function msg($msg, $status = 0) {
        $msg = join("<br/>\n", (array) $msg);

        if (empty($status)) {
            $cls = 'error app-alert-error00';
        } elseif ($status == 1) {
            $cls = 'updated app-alert-success00';
        } else {
            $cls = 'app-alert-notice00';
        }

        $str = "<div class='$cls'><p>$msg</p></div>";

        return $str;
    }

}

/**
 * HTML related methods
 */
class orbisius_child_theme_creator_html {

    /**
     *
     * Appends a parameter to an url; uses '?' or '&'. It's the reverse of parse_str().
     * If no URL is supplied no prefix is added (? or &)
     *
     * @param string $url
     * @param array $params
     * @return string
     */
    public static function add_url_params($url, $params = array()) {
        $str = $query_start = '';

        $params = (array) $params;

        if (empty($params)) {
            return $url;
        }

        if (!empty($url)) {
            $query_start = (strpos($url, '?') === false) ? '?' : '&';
        }

        $str = $url . $query_start . http_build_query($params);

        return $str;
    }

    // generates HTML select
    public static function html_select($name = '', $sel = null, $options = array(), $attr = '') {
        
        $name = trim($name);
        $elem_name = $name;
        $elem_name = strtolower($elem_name);
        $elem_name = preg_replace('#[^\w]#si', '_', $elem_name);
        $elem_name = trim($elem_name, '_');
        $cls = 'orb_ctc_html_select orb_ctc_html_select_' . $elem_name;

        $attr = apply_filters('orbisius_child_theme_creator_ext_filter_html_select_attr', $attr, $name, $sel, $options);
        $cls = apply_filters('orbisius_child_theme_creator_ext_filter_html_select_css', $cls, $name, $sel, $options, $attr);
        $html_css = " class='$cls' ";

        $html = "\n" . '<select id="' . esc_attr($elem_name) . '" name="' . esc_attr($name) . '" ' . $attr . $html_css . '>' . "\n";

        foreach ($options as $key => $label) {
            $selected = $sel == $key ? ' selected="selected"' : '';

            // if the key contains underscores that means these are labels
            // and should be readonly
            if (strpos($key, '__') !== false) {
                $selected .= ' disabled="disabled" ';
            }

            // This makes certain options to have certain CSS class
            // which can be used to highlight the row
            // the key must start with __sys_CLASS_NAME
            if (preg_match('#__sys_([\w\-]+)#si', $label, $matches)) {
                $label = str_replace($matches[0], '', $label);
                $selected .= " class='$matches[1]' ";
            }

            $html .= "\t<option value='$key' $selected>$label</option>\n";
        }

        $html .= '</select>';
        $html .= "\n";

        return $html;
    }

    public static function html_files_tree( $class = '', $files = array() ) {
        $html = '<ul class="orbisius_folder_list">';

        foreach ( $files as $item => $value ) {

            $is_folder = is_array($value) ? true : false;

            $folder_checkbox = $is_folder ? '<label class="orbisius_folder_label"><input type="checkbox"name="'.$class.'_folder_checkbox[]" value="'.$item.'" ><span class="dashicons dashicons-category"></span>'.$item.'</label>' : '';
            $list_class = $is_folder ? 'orbisius_folder' : 'orbisius_file';
            $html .= '<li class="'.$list_class.'">' .$folder_checkbox . ( $is_folder ? orbisius_child_theme_creator_html::html_files_tree($class, $value) : '<label class="orbisius_file_label"><input type="checkbox" class="orb_files" name="'.$class.'_files_checkbox[]" value="'.$value.'" ><span class="dashicons dashicons-text-page"></span>'.$item.'</label>' ) . '</li>';
        }

        $html .= '</ul>';

        return $html;
    }
}

/**
 * This method creates 2 panes that the user is able to use to edit theme files.
 * Everythin happens with AJAX
 */
function orbisius_ctc_theme_editor() {
    if ( is_multisite() && ! is_network_admin() ) {
        $next_url = orbisius_child_theme_creator_util::get_create_child_pages_link();

        if (headers_sent()) {
            $success = "In order to edit a theme in a multisite WordPress environment you must do it from Network Admin &gt; Appearance"
                    . "<br/><a href='$next_url' class='button button-primary'>Continue</a>";
            wp_die($success);
        } else {
            wp_redirect($next_url);
        }

        exit();
    }

    if (defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT) {
        wp_die('Theme editor is disabled due to DISALLOW_FILE_EDIT constant is set to true in wp-config.php', 'Orbisius Theme Editor disabled by config');
    }

    $msg = 'Pick any two themes and copy snippets from one to the other.';
    $msg .= '<span style="float:right;"> <a href="//qsandbox.com/?utm_source=orctc-ed&utm_medium=action_screen&utm_campaign=product"
                target="_blank" title="Opens in new tab/window. qSandbox is a service that allows you to setup a test/sandbox WordPress site in 2 seconds. No technical knowledge is required.
                Test themes and plugins before you actually put them on your site">Free Staging Site</a> <small>(quick set up)</small> by <a href="//qsandbox.com/?utm_source=orctc-ed&utm_medium=action_screen&utm_campaign=product"
                target="_blank">qSandbox</a></span>';

    $plugin_data = orbisius_child_theme_creator_get_plugin_data();
    
    ?>
    <div class="wrap orbisius_child_theme_creator_container orbisius_ctc_theme_editor_container">
        <h2 style="display:inline;">Orbisius Theme Editor <small>(Part of <a href='<?php echo $plugin_data['url'];?>' target="_blank">Orbisius Child Theme Creator</a>)</small></h2>

        <div class="updated"><p>
            <?php echo $msg; ?>
            <span class="loader app-alert-notice"></span>
        </p></div>

        <?php
            $buff = $theme_1_file = $theme_2_file = '';
            $req = orbisius_child_theme_creator_get_request();

            $current_theme = wp_get_theme();
            
            $html_dropdown_themes = array('' => '= SELECT THEME =');

            $theme_1 = empty($req['theme_1']) ? $current_theme->get_stylesheet() : $req['theme_1'];
            $theme_2 = empty($req['theme_2']) ? '' : $req['theme_2'];

            $theme_load_args = array();
            $themes = wp_get_themes( $theme_load_args );

            // we use the same CSS as in WP's appearances but put only the buttons we want.
            foreach ($themes as $theme_basedir_name => $theme_obj) {
                $theme_name = $theme_obj->Name;

                $theme_dir = $theme_basedir_name;

                $parent_theme = $theme_obj->get('Template');

                // Is this a child theme?
                if ( !empty($parent_theme) ) {
                    $theme_name .= " (child of $parent_theme)";
                }

                // Is this the current theme?
                if ($theme_basedir_name == $current_theme->get_stylesheet()) {
                    $theme_name .= ' (site theme) __sys_highlight';
                }

                $html_dropdown_themes[$theme_dir] = $theme_name;
            }

            $html_dropdown_theme_1_files = array(
                '' => '<= SELECT THEME =',
            );

        ?>

        <table class="widefat">
            <tr>
                <td width="50%">
                    <form id="orbisius_ctc_theme_editor_theme_1_form" class="orbisius_ctc_theme_editor_theme_1_form">

                        <?php wp_nonce_field( 'orbisius_ctc_nonce' ); ?>

                        <strong>Theme #1:</strong>
                        <?php echo orbisius_child_theme_creator_html::html_select('theme_1', $theme_1, $html_dropdown_themes); ?>

                        <span class="theme_1_file_container">
                            | <strong>File:</strong>
                            <?php echo orbisius_child_theme_creator_html::html_select('theme_1_file', $theme_1_file, $html_dropdown_theme_1_files); ?>
                        </span>

                        <span class="orbisius_ctc_theme_editor_theme_1_primary_buttons primary_buttons">
                            <button type='submit' class='button button-primary' id="theme_1_submit" name="theme_1_submit">Save</button>
                            <span class="status"></span>
                            <?php do_action('orbisius_child_theme_creator_editors_ext_action_left_primary_buttons', array( 'place' => 'left' ) ); ?>
                        </span>

                        <div id="theme_1_file_contents_container">
                            <textarea id="theme_1_file_contents" name="theme_1_file_contents" rows="16" class="widefat"></textarea>
                        </div>
                        

                        <div class="orbisius_ctc_theme_editor_theme_1_primary_buttons primary_buttons">
                            <button type='submit' class='button button-primary' id="theme_1_submit" name="theme_1_submit">Save Changes</button>
                            <span class="status"></span>
                        </div>

                    </form>

                    <form id="orbisius_ctc_copy_files_theme_1_form" class="orbisius_ctc_copy_files_theme_1_form">
                        <?php wp_nonce_field( 'orbisius_ctc_nonce' ); ?>
                        <div class="orbisius_ctc_theme_editor_theme_1_files_list" style="display:none">
                            <div class="orbisius_ctc_theme_editor_theme_1_files_list_container orbisius_files_list"></div>
                            <div id="orbisius_copy_response_theme_1" class="orbisius_copy_response"></div>
                            <button type='submit' class='button button-primary' id="theme_1_copy_files" name="theme_1_copy_files">Copy Files</button>
                            <button type='submit' class='button' id="theme_1_copy_files_cancel" name="theme_1_copy_files_cancel">Cancel</button>
                        </div>
                    </form>

                    <hr />
                    <div class="orbisius_ctc_theme_editor_theme_1_secondary_buttons secondary_buttons">
                        <button type="button" class='button' id="theme_1_new_file_btn" name="theme_1_new_file_btn">New File</button>
                        <button type="button" class='button' id="theme_1_copy_file_btn" name="theme_1_copy_file_btn">Browse file(s)</button>
                        <button type="button" class='button' id="theme_1_syntax_chk_btn" name="theme_1_syntax_chk_btn">PHP Syntax Check</button>
                        <button type="button" class='button' id="theme_1_send_btn" name="theme_1_send_btn">Send</button>
                        <a href="<?php echo site_url('/');?>" class='button' target="_blank" title="new tab/window"
                            id="theme_1_site_preview_btn" name="theme_1_site_preview_btn">View Site</a>

                        <?php do_action('orbisius_child_theme_creator_editors_ext_actions', 'theme_1'); ?>

                        <!--
                        <button type="button" class='button' id="theme_1_new_folder_btn" name="theme_1_new_folder_btn">New Folder</button>-->

                        <a href='javascript:void(0)' class='app-button-right app-button-negative' id="theme_1_delete_file_btn" name="theme_1_delete_file_btn">Delete File</a>

                        <div id='theme_1_new_file_container' class="theme_1_new_file_container app-hide">
                            <strong>New File</strong>
                            <input type="text" id="theme_1_new_file" name="theme_1_new_file" value="" />
                            <span>e.g. test.js, extra.css, headers/header-two.php etc</span>

                            <!--<br/>
                            <label>
                            <input type="checkbox" name="theme_1_new_file_type" value="folder" />
                            Create a folder Instead
                            </label>-->

                            <span class="status"></span>

                            <br/>
                            <button type='button' class='button button-primary' id="theme_1_new_file_btn_ok" name="theme_1_new_file_btn_ok">Save</button>
                            <a href='javascript:void(0)' class='app-button-negative00 button delete' id="theme_1_new_file_btn_cancel" name="theme_1_new_file_btn_cancel">Cancel</a>
                        </div>

                        <!-- send -->
                        <div id='theme_1_send_container' class="theme_1_send_container app-hide">
                            <p>
                                Email selected theme and parent theme (if any) to yourself or a colleague.
                                Separate multiple emails with commas.<br/>
                                <strong>To:</strong>
                                <input type="text" id="theme_1_send_to" name="email" value="" placeholder="Enter email" />

                                <button type='button' class='button button-primary' id="theme_1_send_btn_ok" name="theme_1_send_btn_ok">Send</button>
                                <a href='javascript:void(0)' class='app-button-negative00 button delete'
                                   id="theme_1_send_btn_cancel" name="theme_1_send_btn_cancel">Cancel</a>
                            </p>
                        </div>
                        <!-- /send -->

                        <?php do_action('orbisius_child_theme_creator_editors_ext_action_left_start', array( 'place' => 'left' ) ); ?>
                        <?php do_action('orbisius_child_theme_creator_editors_ext_action_left_end', array( 'place' => 'left' ) ); ?>

                        <div style="border:1px solid #ccc;margin:10px 0;padding:3px 5px;">
                            <h3>Pro Addon 
                                <?php if ( 0&&! orbisius_child_theme_creator_is_pro_installed() ) : ?>
                                <ul>
                                    <li>Syntax Highlighting</li>
                                    <li>Better dropdown for selecting themes and files</li>
                                </ul>
                                <?php endif; ?>
                            </h3>

                            <?php if ( orbisius_child_theme_creator_is_pro_installed() ) : ?>
                                <div class="app-alert-success">
                                    The <a href="//orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator-pro/?utm_source=orbisius-child-theme-editor&utm_medium=footer&utm_campaign=product"
                                        target="_blank" title="[new window]" style="font-weight: bolder;text-decoration: underline;">Pro Addon</a>
                                    is up and running. Thanks for supporting our <a
                                        href="//orbisius.com/products/wordpress-plugins/?utm_source=orbisius-child-theme-editor&utm_medium=footer&utm_campaign=product" target="_blank">work</a>!
                                </div>
                            <?php else : ?>
                                <span>Get more cool features by purchasing the </span>
                                <a href="//orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator-pro/?utm_source=orbisius-child-theme-editor&utm_medium=footer&utm_campaign=product"
                                    target="_blank" title="[new window]" style="font-weight: bolder;color:red;text-decoration: underline;">Pro Addon</a> 
                            <?php endif; ?>

                            <!--<ul>
                                <li><a href="//orbisius.com/products/wordpress-plugins/orbisius-theme-switcher/?utm_source=orbisius-child-theme-creator&utm_medium=editors&utm_campaign=product"
                                       target="_blank" title="Opens in a new tab/window">Orbisius Theme Switcher</a> - Allows you to preview any of the installed themes on your site.</li>
                            </ul>-->
                        </div>

                        <!-- new folder -->
                        <!--
                        <div id='theme_1_new_folder_container' class="theme_1_new_folder_container app-hide">
                            <strong>New Folder</strong>
                            <input type="text" id="theme_1_new_folder" name="theme_1_new_folder" value="" />
                            <span>e.g. includes, data</span>
                            <span class="status"></span>

                            <br/>
                            <button type='button' class='button button-primary' id="theme_1_new_folder_btn_ok" name="theme_1_new_folder_btn_ok">Save</button>
                            <a href='javascript:void(0)' class='app-button-negative00 button delete' id="theme_1_new_folder_btn_cancel" name="theme_1_new_folder_btn_cancel">Cancel</a>
                        </div>-->
                        <!-- /new folder -->
                    </div> <!-- /secondary_buttons -->
                </td>
                <td width="50%">
                    <form id="orbisius_ctc_theme_editor_theme_2_form" class="orbisius_ctc_theme_editor_theme_2_form">

                        <?php wp_nonce_field( 'orbisius_ctc_nonce' ); ?>

                        <strong>Theme #2:</strong>
                        <?php echo orbisius_child_theme_creator_html::html_select('theme_2', $theme_2, $html_dropdown_themes); ?>

                        <span class="theme_2_file_container">
                            | <strong>File:</strong>
                            <?php echo orbisius_child_theme_creator_html::html_select('theme_2_file', $theme_2_file, $html_dropdown_theme_1_files); ?>
                        </span>

                        <span class="orbisius_ctc_theme_editor_theme_2_primary_buttons primary_buttons">
                            <button type='submit' class='button button-primary' id="theme_2_submit" name="theme_2_submit">Save</button>
                            <?php do_action('orbisius_child_theme_creator_editors_ext_action_right_primary_buttons', array( 'place' => 'right' ) ); ?>
                            <span class="status"></span>
                        </span>

                        <div id="theme_2_file_contents_container">
                            <textarea id="theme_2_file_contents" name="theme_2_file_contents" rows="16" class="widefat"></textarea>
                        </div>

                        <div class="orbisius_ctc_theme_editor_theme_2_primary_buttons primary_buttons">
                            <button type='submit' class='button button-primary' id="theme_2_submit" name="theme_2_submit">Save Changes</button>
                            <span class="status"></span>
                        </div>
                    </form>

                    <form id="orbisius_ctc_copy_files_theme_2_form" class="orbisius_ctc_copy_files_theme_2_form">
                        <?php wp_nonce_field( 'orbisius_ctc_nonce' ); ?>
                        <div class="orbisius_ctc_theme_editor_theme_2_files_list" style="display:none">
                            <div class="orbisius_ctc_theme_editor_theme_2_files_list_container orbisius_files_list"></div>
                            <div id="orbisius_copy_response_theme_2" class="orbisius_copy_response"></div>
                            <button type='submit' class='button button-primary' id="theme_2_copy_files" name="theme_2_copy_files">Copy Files</button>
                            <button type='submit' class='button' id="theme_2_copy_files_cancel" name="theme_2_copy_files_cancel">Cancel</button>
                        </div>
                    </form>

                        <hr />
                        <div class="orbisius_ctc_theme_editor_theme_2_secondary_buttons secondary_buttons">
                            <!-- If you're looking at this code. Slavi says Hi to the curious developer! :) -->
                            
                            <button type="button" class='button' id="theme_2_new_file_btn" name="theme_2_new_file_btn">New File</button>
                            <button type="button" class='button' id="theme_2_copy_file_btn" name="theme_2_copy_file_btn">Browse file(s)</button>
                            <button type="button" class='button' id="theme_2_syntax_chk_btn" name="theme_2_syntax_chk_btn">PHP Syntax Check</button>
                            <button type="button" class='button' id="theme_2_send_btn" name="theme_2_send_btn">Send</button>
                            <a href="<?php echo site_url('/');?>" class='button' target="_blank" title="new tab/window"
                                id="theme_2_site_preview_btn" name="theme_2_site_preview_btn">View Site</a>

                            <?php do_action('orbisius_child_theme_creator_editors_ext_actions', 'theme_2'); ?>

                            <a href='javascript:void(0)' class='app-button-right app-button-negative' id="theme_2_delete_file_btn" name="theme_2_delete_file_btn">Delete File</a>

                            <div id='theme_2_new_file_container' class="theme_2_new_file_container app-hide">
                                <strong>New File</strong>
                                <input type="text" id="theme_2_new_file" name="theme_2_new_file" value="" />
                                <span>e.g. test.js, extra.css etc</span>
                                <span class="status"></span>

                                <br/>
                                <button type='button' class='button button-primary' id="theme_2_new_file_btn_ok" name="theme_2_new_file_btn_ok">Save</button>
                                <a href='javascript:void(0)' class='app-button-negative00 button delete' id="theme_2_new_file_btn_cancel" name="theme_2_new_file_btn_cancel">Cancel</a>
                            </div>

                            <!-- send -->
                            <div id='theme_2_send_container' class="theme_2_send_container app-hide">
                                <p>
                                    Email selected theme and parent theme (if any) to yourself or a colleague.
                                    Separate multiple emails with commas.<br/>
                                    <strong>To:</strong>
                                    <input type="text" id="theme_2_send_to" name="email" value="" placeholder="Enter email" />

                                    <button type='button' class='button button-primary' id="theme_2_send_btn_ok" name="theme_2_send_btn_ok">Send</button>
                                    <a href='javascript:void(0)' class='app-button-negative00 button delete'
                                       id="theme_2_send_btn_cancel" name="theme_2_send_btn_cancel">Cancel</a>
                                </p>
                            </div>
                            <!-- /send -->
                        </div>
                    <!-- </form> -->
                </td>
            </tr>
        </table>

        <?php do_action('orbisius_child_theme_creator_editors_ext_action_footer', array() ); ?>

        <?php //orbisius_child_theme_creator_util::output_orb_widget(); ?>
    <?php
}

function orbisius_ctc_theme_editor_no_auth_ajax() {
    wp_die('You must be logged in to call this method.');
}

/**
 * This is called via ajax. Depending on the sub_cmd param a different method will be called.
 */
function orbisius_ctc_theme_editor_ajax() {
    check_ajax_referer( 'orbisius_ctc_nonce' );
    
    $buff = 'INVALID AJAX SUB_CMD';
    
    $req = orbisius_child_theme_creator_get_request();
    $sub_cmd = empty($req['sub_cmd']) ? '' : $req['sub_cmd'];

    switch ($sub_cmd) {
        case 'generate_dropdown':
            $buff = orbisius_ctc_theme_editor_generate_dropdown();

            break;

        case 'load_file':
            $buff = orbisius_ctc_theme_editor_manage_file(1);
            break;

        case 'save_file':
            $buff = orbisius_ctc_theme_editor_manage_file(2);

            break;

        case 'delete_file':
            $buff = orbisius_ctc_theme_editor_manage_file(3);

            break;

        case 'syntax_check':
            $buff = orbisius_ctc_theme_editor_manage_file(4);

            break;

        case 'send_theme':
            $buff = orbisius_ctc_theme_editor_manage_file(5);

            break;

        case 'copy_files':
            $buff = orbisius_ctc_theme_editor_manage_file(6);

            break;

        case 'get_files':
            $buff = orbisius_ctc_theme_editor_generate_files_tree();
            break;

        default:
            break;
    }

    die($buff);
}

/**
 *
 * @param string $theme_base_dir
 */
function orbisius_ctc_theme_editor_zip_theme($theme_base_dir, $to) {
    $status_rec = array(
        'status' => 0,
        'msg' => '',
    );

    $status_rec['msg'] = 'Sent.';

    $theme_obj = wp_get_theme( $theme_base_dir ); // since 3.4

    $all_themes_root = get_theme_root();
    $theme_dir = get_theme_root() . "/$theme_base_dir/";

    if (empty($theme_base_dir) || empty($theme_obj) || !$theme_obj->exists() || !is_dir($theme_dir)) {
        $status_rec['msg'] = 'Selected theme is invalid.';
        return $status_rec;
    }

    $host = empty($_SERVER['HTTP_HOST']) ? '' : $_SERVER['HTTP_HOST'];
    $host = preg_replace('#^w+\.#si', '', $host);
    $host_suff = empty($host) ? '' : '' . $host . '_';

    $parent_theme_base_dir = $theme_obj->get('Template');

    $id = !empty($parent_theme_base_dir) ? 'child_theme_' : '';

    $theme_name = $theme_obj->get( 'Name' );
    $all_files = orbisius_child_theme_creator_util::load_files($theme_dir, 1);

    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['basedir'] . '/'; // C:\path\to\wordpress\wp-content\uploads
    $target_zip_file = $dir . $host_suff . $id . $theme_base_dir . '__' . date('Y-m-d__H_m_s') . '.zip';

    $prefix_to_strip = $all_themes_root . '/';
    $result = orbisius_child_theme_creator_util::create_zip($all_files, $target_zip_file, true,
                $prefix_to_strip, 'Created by Orbisius Child Theme Creator at ' . date('r') . "\nSite: " . site_url() );

    $site_str = "Site: " . site_url();

    if ($result) {
       $attachments = array( $target_zip_file );

       if (!empty($parent_theme_base_dir)) { // Parent theme Zipping
           $id = 'parent_theme_';
           $target_parent_zip_file = $dir . $host_suff . $id . $parent_theme_base_dir . '__' . date('Y-m-d__H_m_s') . '.zip';

           $theme_dir = get_theme_root() . "/$parent_theme_base_dir/";
           $all_files = orbisius_child_theme_creator_util::load_files($theme_dir, 1);
           $result = orbisius_child_theme_creator_util::create_zip($all_files, $target_parent_zip_file, true,
                $prefix_to_strip, 'Created by Orbisius Child Theme Creator at ' . date('r') . "\n" . $site_str);

           if ($result) {
               $attachments[] = $target_parent_zip_file;
           }
       }

       $host = empty($_SERVER['HTTP_HOST']) ? '' : str_ireplace('www.', '', $_SERVER['HTTP_HOST']);
       $subject = 'Theme (zip): ' . $theme_name;
       $headers = array();
       $message = "Hi,\n\nPlease find the attached theme file(s). \n" . $site_str . "\n\nSent from Orbisius Child Theme Creator.\n";
       $headers = "From: $host WordPress <wordpress@$host>" . "\r\n";

       $mail_sent = wp_mail($to, $subject, $message, $headers, $attachments );

       if ($mail_sent) {
           $status_rec['status'] = $result;
           
           foreach ($attachments as $attachment) {
              unlink($attachment);
           }
       } else {
          $prefix = $upload_dir['baseurl'] . '/';
          $status_rec['msg'] = "Couldn't send email but was able to create zip file(s). Download it/them from the link(s) below.";

          foreach ($attachments as $idx => $attatchment_abs_path) {
              $cnt = $idx + 1;
              $file = basename($attatchment_abs_path);
              $status_rec['msg'] .= "<br/>&nbsp;$cnt) <a href='$prefix$file'>$file</a>\n";
          }
       }
       
    } else {
        $status_rec['msg'] = "Couldn't create zip files.";
    }

    return $status_rec;
}

/**
 * Receives and argument (string) that will be checked by php for syntax errors.
 * A temp file is created and then php binary is called with -l (that's lowercase L).
 * With exec() we check the return status but with shell_exec() we parse the output
 * (not reliable due to locale).
 * 
 * @requires exec() or shell_exec() functions.
 * @param string $theme_file_contents
 * @return array
 */
function orbisius_ctc_theme_editor_check_syntax($theme_file_contents) {
	$ok = 0;
    $status_rec = array(
        'msg' => '',
        'status' => 0,
	    'syntax_check_ran' => 0,
    );

    // Not a php file so don't do a syntax check.
    if (stripos($theme_file_contents, '<?') === false) {
        $status_rec['msg'] = 'Syntax OK.';
        $status_rec['status'] = 1;
        $status_rec['non_php_file'] = 1;
        return $status_rec;
    }

	if (function_exists('shell_exec') || function_exists('exec')) {
	    // OK
	} else {
		$status_rec['msg'] = 'Syntax check: n/a. function: exec() and shell_exec() are not available.';
		return $status_rec;
	}

    $temp = tmpfile();
    fwrite($temp, $theme_file_contents);
    $meta_data = stream_get_meta_data($temp);
    $file = $meta_data['uri'];
    $file = escapeshellarg($file);
    $cmd = "php -l $file"; // what about different binaries (cpanel or other control panel)? some of them are slow or hang for 5sec

    // we're relying on exec's return value so we can tell
    // if the syntax is OK
    if (function_exists('exec')) {
        $exit_code = $output = 0;
        $last_line = exec($cmd, $output, $exit_code);
        $output = join('', $output); // this is an array with multiple lines including new lines
        $ok = empty($exit_code); // in linux 0 means success
    } elseif (function_exists('shell_exec')) { // this relies on parsing the php output but if a non-english locale is used this will fail.
        $output = shell_exec($cmd . " 2>&1");
        $ok = stripos($output, 'No syntax errors detected') !== false;
    }

    $error = $output;

    if ($ok) {
        $status_rec['status'] = 1;
        $status_rec['msg'] = 'Syntax OK.';
    } else {
        $status_rec['msg'] = 'Syntax check failed. Error: ' . $error;
    }

    $status_rec['syntax_check_ran'] = 1;

    fclose($temp); // this removes the file

    return $status_rec;
}

/**
 * This returns an HTML select with the selected theme's files.
 * the name/id of that select must be either theme_1_file or theme_2_file
 * @return string
 */
function orbisius_ctc_theme_editor_generate_dropdown() {
    $req = orbisius_child_theme_creator_get_request();
    $html_dropdown_theme_1_files = orbisius_ctc_generate_list_of_theme_files($req);
    $buff = orbisius_child_theme_creator_html::html_select('', null, $html_dropdown_theme_1_files);
    return $buff;
}

function orbisius_ctc_theme_editor_generate_files_tree() {
    $req = orbisius_child_theme_creator_get_request();
    $paths = orbisius_ctc_generate_list_of_theme_files($req);
    $tree = orbisius_ctc_explode_tree( $paths, "/" );

    if (!empty($req['theme_1'])) {
        $name = 'theme_1_files';
    } elseif (!empty($req['theme_2'])) {
        $name = 'theme_2_files';
    }

    $buff = orbisius_child_theme_creator_html::html_files_tree($name, $tree);

    return $buff;
}


// https://kvz.io/convert-anything-to-tree-structures-in-php.html
function orbisius_ctc_explode_tree($array, $delimiter = '_', $baseval = false) {
    if ( !is_array($array) ) {
        return false;
    }
    
	$split   = '/' . preg_quote($delimiter, '/') . '/';
	$return_array = array();

	foreach ($array as $key => $val) {
		// Get parent parts and the current leaf
		$parts	= preg_split($split, $key, -1, PREG_SPLIT_NO_EMPTY);
		$leaf = array_pop($parts);

		// Build parent structure
		// Might be slow for really deep and large structures
		$parent_arr = &$return_array;
		foreach ($parts as $part) {
			if (!isset($parent_arr[$part])) {
				$parent_arr[$part] = array();
			} elseif (!is_array($parent_arr[$part])) {
				if ($baseval) {
					$parent_arr[$part] = array('__base_val' => $parent_arr[$part]);
				} else {
					$parent_arr[$part] = array();
				}
			}
			$parent_arr = &$parent_arr[$part];
		}

		// Add the final part to the structure
		if (empty($parent_arr[$leaf])) {
			$parent_arr[$leaf] = $val;
		} elseif ($baseval && is_array($parent_arr[$leaf])) {
			$parent_arr[$leaf]['__base_val'] = $val;
		}
    }
    
	return $return_array;
}

$test = &$return_array;

/**
 * This returns array of theme files

 * @return array
 */
function orbisius_ctc_generate_list_of_theme_files($req) {
	$theme_1_file = '';
	$theme_base_dir = '';
	$select_name = 'theme_1_file';
    
    if (!empty($req['theme_1'])) {
        $theme_base_dir = empty($req['theme_1']) ? '' : preg_replace('#[^\w\-]#si', '', $req['theme_1']);
        $theme_1_file = empty($req['theme_1_file']) ? 'style.css' : $req['theme_1_file'];
    } elseif (!empty($req['theme_2'])) {
        $theme_base_dir = empty($req['theme_2']) ? '' : preg_replace('#[^\w\-]#si', '', $req['theme_2']);
        $theme_1_file = empty($req['theme_2_file']) ? 'style.css' : $req['theme_2_file'];
        $select_name = 'theme_2_file';
    } else {
        return 'Invalid params.';
    }

    $theme_dir = get_theme_root() . "/$theme_base_dir/";

    if (empty($theme_base_dir) || !is_dir($theme_dir)) {
        return 'Selected theme is invalid.';
    }

    $files = array();
    $all_files = orbisius_child_theme_creator_util::load_files($theme_dir);

    foreach ($all_files as $file) {
        if (preg_match('#\.(php|js|txt|css|sass|scss)(?:_error_.*)?$#si', $file)) {
            $files[] = $file;
        }
    }

    // we're going to make values to be keys as well.
    return array_combine($files, $files);
}

/**
 * Reads or writes contents to a file.
 * If the saving is not successfull it will return an empty buffer.
 * @param int $cmd_id : read - 1, write - 2, delete - 3
 * @return string
 */
function orbisius_ctc_theme_editor_manage_file( $cmd_id = 1 ) {
    if ( ! current_user_can( 'edit_themes' ) ) {
        return 'Missing data!';
    }

    $buff = '';
	$theme_dir = '';
	$theme_file = '';
	$theme_base_dir = '';

    $req = orbisius_child_theme_creator_get_request();
    $theme_root = trailingslashit( get_theme_root() );

    $theme_dir_regex = '#[^\w\-]#si';

    if (!empty($req['theme_1']) && !empty($req['theme_1_file'])) {
        $theme_base_dir = empty($req['theme_1']) ? '______________' : preg_replace( $theme_dir_regex, '', $req['theme_1']);
        $theme_dir = $theme_root . "$theme_base_dir/";
        $theme_file = empty($req['theme_1_file']) 
                ? $theme_dir . 'style.css'
                : orbisius_child_theme_creator_util::sanitize_file_name($req['theme_1_file'], $theme_dir);

        $theme_file_contents = empty($req['theme_1_file_contents']) ? '' : $req['theme_1_file_contents'];
    } elseif (!empty($req['theme_2']) && !empty($req['theme_2_file'])) {
        $theme_base_dir = empty($req['theme_2'])
                ? '______________'
                : preg_replace( $theme_dir_regex, '', $req['theme_2']);
        $theme_dir = $theme_root . "$theme_base_dir/";
        $theme_file = empty($req['theme_2_file']) 
                ? $theme_dir . 'style.css'
                : orbisius_child_theme_creator_util::sanitize_file_name($req['theme_2_file'], $theme_dir);
        $theme_file_contents = empty($req['theme_2_file_contents']) ? '' : $req['theme_2_file_contents'];
    } else {
        return 'Missing data!';
    }

    if (empty($theme_base_dir) || !is_dir($theme_dir)) {
        return 'Selected theme is invalid.';
    } elseif (!file_exists($theme_file) && $cmd_id == 1) {
        return 'Selected file is invalid.';
    }

    if ($cmd_id == 1) {
        $buff = file_get_contents($theme_file);
    } elseif ($cmd_id == 2) {
        $suff = '';

        // This should prevent people from crashing their WP by missing something.
        // The changes will be saved in another file.
        $syntax_check_rec = orbisius_ctc_theme_editor_check_syntax($theme_file_contents);

        if (!empty($syntax_check_rec['syntax_check_ran']) && empty($syntax_check_rec['status'])) {
            $suff = microtime(true);
            $suff = preg_replace('#[^\w-]#si', '_', $suff);
            $suff = '_error_' . date('Y-m-d') . '_' . $suff;
        }

        // This a case where the file resides in a new folder that doesn't exist yet.
        // e.g. headers/header-two.php
        $cur_file_parent_dir = dirname( $theme_file );

        if ( ! is_dir( $cur_file_parent_dir ) ) {
            if ( ! mkdir( $cur_file_parent_dir, 0755, 1 ) ) {
                trigger_error( "Cannot create folder: [$cur_file_parent_dir]. Please, check folder permissions.", E_USER_NOTICE );
            }
        }

        $status = file_put_contents($theme_file . $suff, $theme_file_contents, LOCK_EX);
        $buff = $theme_file_contents;
    } elseif ($cmd_id == 3 && (!empty($req['theme_1_file']) || !empty($req['theme_2_file']))) {
        $status = unlink($theme_file);
    }

    elseif ($cmd_id == 4) { // syntax check. create a tmp file and ask php to check it.
        $status_rec = orbisius_ctc_theme_editor_check_syntax($theme_file_contents);
        
        if (function_exists('wp_send_json')) { // since WP 3.5
            wp_send_json($status_rec);
        } else {
            @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
            $buff = json_encode($status_rec);
        }
    }

    elseif ($cmd_id == 5) { // zip
        $to = empty($req['email']) ? '' : preg_replace('#[^\w\-\.@,\'"]#si', '', $req['email']);
        $status_rec = orbisius_ctc_theme_editor_zip_theme($theme_base_dir, $to);

        if (function_exists('wp_send_json')) { // since WP 3.5
            wp_send_json($status_rec);
        } else {
            @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
            $buff = json_encode($status_rec);
        }
    }
    elseif ($cmd_id == 6) { // copy
        $status = array(
            'status' => 0,
            'message' => '',
            'files'    => array()
        );
        
        if ( $req['copy'] === '[]' ) {
            $status['message'] = 'No files selected!';
            return json_encode($status);
        }

        if ( empty($req['copy_to']) ) {
            $status['message'] = 'Please select destination Theme!';
            return json_encode($status);
        }
        
        $files = json_decode($req['copy'], true);

        $theme_2_base_dir = preg_replace( $theme_dir_regex, '', $req['copy_to']);
        $theme_2_dir = $theme_root . trailingslashit($theme_2_base_dir);

        foreach ( $files as $file ) {
            $src_file = $theme_dir . $file;
            $target_file = $theme_2_dir . $file;
            $target_dir = dirname($target_file);
            $stat = wp_mkdir_p($target_dir);

            if ( !copy($src_file, $target_file) ) {
                if ( $req['copy'] === '[]' ) {
                    $status['message'] = 'Cannot copy selected files!';
                    return json_encode($status);
                }
            }
        }

        $status = array(
            'status' => 1,
            'message' => 'All files have been successfully copied.',
            'files'    => $files
        );

        return json_encode($status);
    }
    
    else {
        
    }

    return $buff;
}

