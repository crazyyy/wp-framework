<?php
namespace Ari\Cache;

defined( 'ABSPATH' ) or die( 'Access forbidden!' );

class Persistence {
    public static function set( $key, $val, $lifetime ) {
        return set_transient( $key, $val, $lifetime );
    }

    public static function get( $key, $default = null ) {
        $val = get_transient( $key );

        if ( false === $val ) {
            $val = $default;
        }

        return $val;
    }

    public static function clear( $key ) {
        return delete_transient( $key );
    }
}
