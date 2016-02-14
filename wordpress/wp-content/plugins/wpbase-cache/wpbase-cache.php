<?php
/*
  Plugin Name: WPBase-Cache
  Plugin URI: https://github.com/baseapp/wpbase-cache
  Description: A wordpress plugin for using all caches on varnish, nginx, php-fpm stack with php-apc. This plugin includes db-cache-reloaded-fix for dbcache.
  Version: 4.0
  Author: Vikrant Datta
  Author URI: http://blog.wpoven.com
  License: GPL2

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
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

defined('ABSPATH') or die();
define('WPBASE_CACHE_DIR', WP_PLUGIN_DIR . '/wpbase-cache');
define('WPBASE_CACHE_INC_DIR', WP_PLUGIN_DIR . '/wpbase-cache/inc');
add_action('admin_enqueue_scripts', function() {
    wp_register_style('style', plugin_dir_url(__FILE__) . '/style.css', false);
    wp_enqueue_style('style');
});

//$path = dirname(dirname(dirname(__FILE__)));
//if(is_file($path.'/db.php')){
//   rename($path.'/db.php',$path.'/db_old.php');
//}
function upon_activation() {
    $path = dirname(dirname(dirname(__FILE__)));
    if (is_file($path . '/db.php')) {
        rename($path . '/db.php', $path . '/db_old.php');
    }
}

function is_wpoven_site() {
    $file = ABSPATH . 'wp-config.php';
    $content = file_get_contents($file);
    $match = '';
    preg_match('/define.*DB_NAME.*\'(.*)\'/', $content, $match);
    $dbname = $match[1];
    $sitename = substr($dbname, 2);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_URL, "https://wpoven.com/sites/check/wpbasecachecheck/" . $sitename);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

function check_wpoven_site() {

    $check_site = is_wpoven_site();
    if ($check_site == "1") {

        function custom_button_example($wp_admin_bar) {
            $file = ABSPATH . 'wp-config.php';
            $content = file_get_contents($file);
            $match = '';
            preg_match('/define.*DB_NAME.*\'(.*)\'/', $content, $match);
            $dbname = $match[1];
            $sitename = substr($dbname, 2);
            $req_cache = get_option('wpbase_req_cache');
            $req_cache = json_decode($req_cache, true);
            if (!get_option('wpbase_req_cache')) {
                //echo "here";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_URL, "https://wpoven.com/sites/checksiteinfo/" . $sitename);
                $content = curl_exec($ch);
                curl_close($ch);
                //var_dump($content);
                //$return_array = explode(",", $content);
                $return_array = json_decode($content, true);
                update_option('wpbase_req_cache', $content);
            } else {
                $return_array = $req_cache;
            }
            //var_dump($return_array);
            if ($return_array['status'] == "true") {
                $args = array(
                    'id' => 'Dashboard-button',
                    'title' => $return_array['panel_title'] . ' Dashboard',
                    'href' => $return_array['hostname'] . '/sites/view/' . $return_array['siteuid'],
                    'meta' => array(
                        'class' => 'dashboard-button-class'
                    )
                );
                $wp_admin_bar->add_node($args);
            } else if ($return_array['status'] == "false") {
                $args = array(
                    'id' => 'WPOven-button',
                    'title' => 'WPOven Site Dashboard',
                    'href' => 'https://wpoven.com/sites/edit/' . $sitename,
                    'meta' => array(
                        'class' => 'dashboard-button-class'
                    )
                );
                $wp_admin_bar->add_node($args);
            }
        }

        add_action('admin_bar_menu', 'custom_button_example', 100);
    }
}

$options = get_option('wpbase_cache_options');
if ($options['admin_bar_button'] == '1')
    add_action('init', 'check_wpoven_site');

register_activation_hook(__FILE__, 'upon_activation');

class WPBase_Cache {

    public $wp_db_cache_reloaded = null;

    public function __construct() {

        $this->load_plugins();

        register_activation_hook(WPBASE_CACHE_DIR . '/wpbase-cache.php', array($this, 'activate'));
        register_deactivation_hook(WPBASE_CACHE_DIR . '/wpbase-cache.php', array($this, 'deactivate'));

        // add flush hooks
        $this->add_flush_actions();

        if (is_admin()) {
            require_once(WPBASE_CACHE_DIR . '/wpbase-cache-admin.php');
        }
    }

    public function activate() {
        $options = array(
            'db_cache' => '0',
            'varnish_cache' => '1',
            'send_as' => 'noreply',
            'admin_bar_button' => '1'
                //'reject_url' => '',
                //'reject_cookie' => '',
        );

        update_option('wpbase_cache_options', $options);

        // activate and enable db-cache-reloaded-fix
        // $this->activate_db_cache();
    }

    public function deactivate() {
        //$this->deactivate_db_cache();
        $options = array(
            'db_cache' => '0',
            'varnish_cache' => '0',
            'send_as' => '0',
            'admin_bar_button' => ''
                //'reject_url' => '',
                //'reject_cookie' => '',
        );

        update_option('wpbase_cache_options', $options);
        //delete_option('wpbase_cache_options');
    }

    public function activate_db_cache() {
        /*    require_once(WPBASE_CACHE_INC_DIR.'/db-cache-reloaded-fix/db-cache-reloaded.php');
          $this->wp_db_cache_reloaded = new DBCacheReloaded();
          $options = array(
          'enabled' => true,
          'filter' => '_posts|_postmeta',
          'loadstat' => '',
          'wrapper' => false,
          'save' => 1
          );
          $this->wp_db_cache_reloaded->options_page($options); */
    }

    public function deactivate_db_cache() {
        /*  if($this->wp_db_cache_reloaded != null){
          $this->wp_db_cache_reloaded->dbcr_uninstall();
          } */
    }

    public function load_plugins() {
        $options = get_option('wpbase_cache_options');

        require_once(WPBASE_CACHE_INC_DIR . '/nginx-compatibility/nginx-compatibility.php');

        /*    if(isset($options['db_cache']) && $options['db_cache'] == '1'){
          require_once(WPBASE_CACHE_INC_DIR.'/db-cache-reloaded-fix/db-cache-reloaded.php');
          $this->wp_db_cache_reloaded = new DBCacheReloaded();
          } */

        if (!isset($options['varnish_cache']) || $options['varnish_cache'] != '1') {
            add_action('init', array($this, 'set_cookie'));
        }
    }

    public function set_cookie() {
        if (!isset($_COOKIE['wpoven-no-cache'])) {
            setcookie('wpoven-no-cache', 1, time() + 120);
        }
    }

    public function add_flush_actions() {
        add_action('switch_theme', array($this, 'flush_all_cache'));
        add_action('publish_phone', array($this, 'flush_all_cache'));
        add_action('publish_post', array($this, 'flush_all_cache'));
        add_action('edit_post', array($this, 'flush_all_cache'));
        add_action('save_post', array($this, 'flush_all_cache'));
        add_action('wp_trash_post', array($this, 'flush_all_cache'));
        add_action('delete_post', array($this, 'flush_all_cache'));
        add_action('trackback_post', array($this, 'flush_all_cache'));
        add_action('pingback_postt', array($this, 'flush_all_cache'));
        add_action('comment_post', array($this, 'flush_all_cache'));
        add_action('edit_comment', array($this, 'flush_all_cache'));
        add_action('wp_set_comment_status', array($this, 'flush_all_cache'));
        add_action('delete_comment', array($this, 'flush_all_cache'));
        add_action('comment_cookie_lifetime', array($this, 'flush_all_cache'));
        add_action('wp_update_nav_menu', array($this, 'flush_all_cache'));
        add_action('edit_user_profile_update', array($this, 'flush_all_cache'));
    }

    public function flush_all_cache() {
        $url = get_site_url();
        $url = $url . '/';
        $this->flush_varnish_cache($url);

        /* if($this->wp_db_cache_reloaded != null){
          $this->wp_db_cache_reloaded->dbcr_clear();
          } */
    }

    public function flush_varnish_cache($url) {
        if (!(defined('WPBASE_CACHE_SANDBOX') && WPBASE_CACHE_SANDBOX)) {
            //echo $url;
            wp_remote_request($url, array('method' => 'PURGE'));
        }
    }

}

$wpbase_cache = new WPBase_Cache();
//------------------- wpbase-cache update ------------------

$cache_options = get_option('wpbase_cache_options');

if (!isset($cache_options['varnish_cache']) || $cache_options['varnish_cache'] != '1') {
    $site = site_url();
    //global $wpbase_cache;
    $wpbase_cache->flush_varnish_cache($site);
}

add_action('admin_notices', 'warn_admin_notice');

function warn_admin_notice() {
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if (is_admin() && strpos($url, ':8080') !== false) {
        ?>
        <div class="updated">
            <p><?php echo '<font color="red">WPBase-Cache Warning! </font>:  You are accessing the site through the server IP. It is recommended that you do not make any changes to the site while accessing through the server IP.'; ?></p>
        </div><?php
    }
}

$options = get_option('wpbase_cache_options');
$send_as = $options['send_as'];
if ($send_as != NULL) {
    add_filter('wp_mail_from', 'mail_from_wpoven');
    add_filter('wp_mail_from_name', 'mail_from_name_wpoven');
}

function mail_from_wpoven($email) {

    $options = get_option('wpbase_cache_options');
    $send_as = $options['send_as'];
    if ($send_as != NULL) {
        // $sitename = strtolower($_SERVER['SERVER_NAME']);
        // $sitename = str_replace('www.','',$sitename);
        global $wpdb;
        $table_name = $wpdb->prefix . "options";
        $result = $wpdb->get_results('SELECT option_value FROM ' . $table_name . ' WHERE option_name = "siteurl";', ARRAY_N);
        $sitename = parse_url($result[0][0]);
        $host = $sitename['host'];
        $domain = str_replace('www.', '', $host);
        if (strpos($domain, '8080') !== false) {
            $dom = explode('/', $_SERVER['REQUEST_URI']);
            return $send_as . '@' . $dom[1];
        } else {
            return $send_as . '@' . $domain;
        }

        //$sitename = substr($sitename,0,4)=='www.' ? substr($sitename, 4) : $sitename;
    }
}

function mail_from_name_wpoven($name) {
    $options = get_option('wpbase_cache_options');
    $send_as = $options['send_as'];
    if ($send_as != NULL) {
        return $send_as;
    }
}
