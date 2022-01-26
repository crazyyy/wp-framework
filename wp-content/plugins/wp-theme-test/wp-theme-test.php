<?php
/*
Plugin Name: WP Theme Test
Plugin URI: https://github.com/kanakogi/WP-Theme-Test
Description: The theme can be changed and displayed to only logged in users.
Author: Nakashima Masahiro
Version: 1.1.3
Author URI: http://www.kigurumi.asia
Text Domain: wptt
Domain Path: /languages/
*/
define('WPTT_VERSION', '1.1.3');
define('WPTT_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('WPTT_PLUGIN_NAME', trim(dirname(WPTT_PLUGIN_BASENAME), '/'));
define('WPTT_PLUGIN_DIR', untrailingslashit(dirname(__FILE__)));
define('WPTT_PLUGIN_URL', untrailingslashit(plugins_url('', __FILE__)));
define('WPTT_TEXT_DOMAIN', 'wptt');

require_once WPTT_PLUGIN_DIR . '/classes/class.core.php';

class WP_Theme_Test extends WPTT_Core
{

    /**
     * __construct
     */
    public function __construct()
    {
        //他言語化
        load_plugin_textdomain(WPTT_TEXT_DOMAIN, false, basename(dirname(__FILE__)) . '/languages/');
        //actions
        add_action('init', array($this, 'load_files'));
        //filters
        add_filter('template', array($this, 'template_filter'));
        add_filter('stylesheet', array($this, 'stylesheet_filter'));
        // プラグインが有効・無効化されたとき
        // register_activation_hook(__FILE__, array($this, 'activation_hook'));
        // register_deactivation_hook(__FILE__, array($this, 'deactivation_hook'));
        // register_uninstall_hook(__FILE__, array($this, 'uninstall_hook'));
    }

    /**
     * load_files
     */
    public function load_files()
    {
        // Classes
        include_once WPTT_PLUGIN_DIR . '/classes/class.admin.php';
    }

    /**
     * apply_test_theme
     */
    function apply_test_theme()
    {
        //GETでも変えれるようにする
        if (isset($_GET['theme']) && $this->get_parameter()) {
            $theme_object = wp_get_theme(esc_html($_GET['theme']));
            return $theme_object;
        }

        //IPアドレスでも変えれるようにする
        if ($this->get_ip_list()) {
            $ip_list = $this->get_ip_list();
            $ip_list = str_replace(array("\r\n", "\n", "\r"), "\n", $ip_list); //改行を\nに統一
            $ip_list = explode("\n", $ip_list);
            if (in_array($_SERVER['REMOTE_ADDR'], $ip_list)) {
                return wp_get_theme($this->get_theme());
            }
        }

        // ログイン状態とレベルをチェック
        if ($this->has_capability() && $this->is_test_enabled()) {

            // 現在の設定されているテーマを取得
            if (!$theme = $this->get_theme()) {
                return false;
            }

            // 設定されているテーマがあれば取得する
            $theme_object = wp_get_theme($theme);
            if (!empty($theme_object)) {
                if (isset($theme_object->Status) && $theme_object->Status != 'publish') {
                    return false;
                }
                return $theme_object;
            }

            return false;
        }

        return false;
    }


    /**
     * テンプレートを設定
     */
    function template_filter($template)
    {
        $theme = $this->apply_test_theme();
        if ($theme === false) {
            return $template;
        }
        return $theme->get_template();
    }


    /**
     * スタイルシートを設定
     */
    function stylesheet_filter($stylesheet)
    {
        $theme = $this->apply_test_theme();
        if ($theme === false) {
            return $stylesheet;
        }
        return $theme->get_stylesheet();
    }
}
$wp_theme_test = new WP_Theme_Test();
