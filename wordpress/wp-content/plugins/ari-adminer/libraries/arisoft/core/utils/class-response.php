<?php
namespace Ari\Utils;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

class Response {
    public static function redirect( $url, $status = 302 ) {
        wp_redirect( $url, $status );

        exit();
    }
}