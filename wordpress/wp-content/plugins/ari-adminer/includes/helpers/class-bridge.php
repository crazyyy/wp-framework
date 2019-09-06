<?php
namespace Ari_Adminer\Helpers;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

define( 'ARIADMINER_BRIDGE_SESSION_KEY', 'adminer_shared' );

use Ari\Utils\Request as Request;

class Bridge {
    private $config;

    function __construct( $config ) {
        $this->config = $config;
    }

    public function prepare_output( $content, $app_type ) {
        $content = preg_replace_callback(
            '/(<html[^>]*>)(.+)(<body)/is',
            function( $matches ) use ( $app_type) {
                $head_content = $matches[2];

                $head_content = str_replace(
                    array(
                        '../adminer/static/',

                        '"static/',

                        '\'static/',

                        '../externals/',
                    ),
                    array(
                        'adminer/adminer/static/',

                        '"adminer/' . $app_type . '/static/',

                        '\'adminer/' . $app_type . '/static/',

                        'adminer/externals/'
                    ),
                    $head_content
                );

                if ( $this->config->theme_url ) {
                    $head_content .= '<link rel="stylesheet" type="text/css" href="' . $this->config->theme_url . '">';
                }

                return $matches[1] . $head_content . $matches[3];
            },
            $content,
            1
        );

        $content = preg_replace_callback(
            '/<script[^>]*>/i',
            function( $matches ) {
                return str_replace(
                    array(
                        '../externals/',
                    ),
                    array(
                        'adminer/externals/',
                    ),
                    $matches[0]
                );
            },
            $content
        );

        $content = preg_replace_callback(
            '/<input [^>]*>/i',
            function( $matches ) {
                return str_replace(
                    array(
                        '../adminer/static/',
                    ),
                    array(
                        'adminer/adminer/static/',
                    ),
                    $matches[0]
                );
            },
            $content
        );

        $content = preg_replace_callback(
            '/<a[\s]+[^>]*?(href[\s]?=[\s\"\']*(.*?)[\"\'])*.*?>([^<]+|.*?)?<\/a>/i',
            function( $matches ) {
                $url = $matches[2];
                if ( false !== strpos( $url, '__wp_nonce' ) ) {
                    return $matches[0];
                }

                $insertPos = strpos( $url, '?' );
                $insertAmp = strpos( $url, '&' ) !== false;
                if ( false === $insertPos ) {
                    $insertPos = strpos( $url, '#' );

                    if ( false === $insertPos ) {
                        $url .= '?';
                        $insertPos = strlen( $url );
                    }
                } else {
                    $insertAmp = true;
                    $insertPos += 1;
                }

                $url = substr( $url, 0, $insertPos)
                    . '__wp_nonce=' . $this->config->nonce . ( $insertAmp ? '&amp;' : '' )
                    . substr( $url, $insertPos );

                return str_replace(
                    $matches[1],
                    'href="' . $url . '"',
                    $matches[0]
                );
            },
            $content
        );

        $content = preg_replace_callback(
            '/<\/form>/i',
            function( $matches ) {
                return sprintf(
                    '<input type="hidden" name="__wp_nonce" value="%s" />%s',
                    htmlspecialchars( $this->config->nonce ),
                    $matches[0]
                );
            },
            $content
        );

        $content = preg_replace_callback(
            '/<body[^>]*>/i',
            function( $matches ) {
                return script(
                        'if (typeof(ajax) !== "undefined" && !ajax.__patched) {' .
                        'const originalAjax = ajax;' .
                        'ajax = function(url, callback, data, message) {
                        if (!/__wp_nonce=/.test(url)) url += "&__wp_nonce=" + "' . $this->config->nonce . '";
                        console.log(url); 
                        return originalAjax(url, callback, data, message);
                    };ajax.__patched = true;' .
                        '}') . $matches[0];
            },
            $content,
            1
        );

        return $content;
    }

    static public function is_ajax_request() {
        return ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'XMLHttpRequest' == $_SERVER['HTTP_X_REQUESTED_WITH'] );
    }

    static public function is_resource_request() {
        $is_post = ! empty( $_POST );

        return
            Request::exists( 'file' ) ||
            ( $is_post && isset( $_GET['dump'] ) ) ||
            ( $is_post && isset( $_GET['select'] ) && isset( $_POST['export'] ) ) ||
            ( $is_post && isset( $_GET['sql'] ) && isset( $_POST['export'] ) );
    }

    static public function get_terminated_message( $login_url ) {
        $login_url = self::sanitize_url( $login_url );

        $message = null;
        if ( $login_url ) {
            $message = sprintf(
                'Your session has been terminated. <a href="%1$s" target="_top" style="font-weight:900;">Run</a> the application again from WordPress.',
                $login_url
            );
        } else {
            $message = 'Your session has been terminated. Run the application again from WordPress.';
        }

        return $message;
    }

    static public function sanitize_url( $url ) {
        $root_url = Request::root_url();

        if ( empty( $root_url ) || empty( $url ) || strpos( $url, $root_url ) !== 0 )
            return '';

        return $url;
    }

    static protected function ensure_session_start() {
        if ( ! session_id() )
            @session_start();
    }

    static public function set_shared_param( $key, $val ) {
        self::ensure_session_start();

        if ( ! isset( $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY] ) || ! is_array( $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY] ) )
            $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY] = array();

        $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY][$key] = $val;
    }

    static public function get_shared_param( $key, $default_val = null ) {
        self::ensure_session_start();

        return isset( $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY][$key] ) ? $_SESSION[ARIADMINER_BRIDGE_SESSION_KEY][$key] : $default_val;
    }
}
