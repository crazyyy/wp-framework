<?php

/**
 * The public-facing functionality of the plugin.
 *
 * PHP version 7
 *
 * @category   WP-Plugin
 * @package    Jerc
 * @subpackage Jerc/public
 * @author     James Amner <jdamner@me.com>
 * @license    TBC https://example.com
 * @link       https://amner.me
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @category   WP-Plugin
 * @package    Jerc
 * @subpackage Jerc/public
 * @author     James Amner <jdamner@me.com>
 * @license    TBC https://example.com
 * @link       https://amner.me
 * @since      1.0.0
 */
class JercPublic
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string   $_plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since   1.0.0
     * @access   private
     * @var   string    $_version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     *
     * @since 1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function enqueueScripts()
    {
        if (!is_admin()) {
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url(__FILE__) . 'js/jerc.js',
                array(),
                $this->version,
                false
            );
            wp_localize_script(
                $this->plugin_name,
                'jerc',
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce($this->plugin_name),
                    'action' => $this->plugin_name,
                )
            );
        }
    }

    /**
     * Handles the ajax request from end user
     *
     * @return void Exits
     */
    public function handleAjax()
    {
        // Using XHR for the JS, so json comes in via php://input
        $request = json_decode(urldecode(file_get_contents('php://input')), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            wp_send_json_error(
                array(
                    "error" => "Encoding Error",
                    "message" => json_last_error_msg(),
                ),
                400
            );
        }
        if (!wp_verify_nonce($request['nonce'], $this->plugin_name)) {
            wp_send_json_error(
                array(
                    "error" => "CSRF Error",
                ),
                401
            );
        }

        global $wpdb;
        $table_name = $wpdb->prefix . $this->plugin_name . "_data";

        // No need to escape SQL input;
        // @see https://developer.wordpress.org/reference/classes/wpdb/insert/
        $data = array(
            "message" => $request['message'],
            "script" => $request['script'] . ":" . $request['lineNo'] . ":" . $request['columnNo'],
            "userId" => get_current_user_id(),
            "userIp" => $_SERVER['REMOTE_ADDR'] ?: null,
            "pageUrl" => $request['pageUrl'] ?: null,
            "agent" => $_SERVER['HTTP_USER_AGENT'] ?: null,
        );

        $insert = $wpdb->insert($table_name, $data);

        if ($insert !== false && $insert > 0) {
            wp_send_json_success($insert);
        }

        /**
         * If we're here and we haven't exited already probably should just error out.
         */
        wp_send_json_error($insert);
    }
}
