<?php

class PGC_Known_Plugins {

    const VERSION_URL = 'https://storage.yandexcloud.net/database-cleanup/version.json';
    const SKIP_LIST_URL = 'https://storage.yandexcloud.net/database-cleanup/skip-list.json';
    const PLUGINS_URL = 'https://storage.yandexcloud.net/database-cleanup/plugins.json';
    const DB_TABLES_URL = 'https://storage.yandexcloud.net/database-cleanup/db-tables.json';
    const VERSION_PATH = PGC_PLUGIN_DIR .'/data/version.json';
    
    
    // List of plugins which create/use own database tables
    static private $plugins = null;    

    // List of plugins, which do not create own database tables
    static private $skip_list = null;

    // Database tables which belong to plugins and/or themes
    static private $db_tables = null;

    
    static private function get_data_local_version() {
        
        $version = 0;       
        $data = file_get_contents( self::VERSION_PATH );
        $object = json_decode( $data );
        if ( isset( $object->version ) ) {
            $version = $object->version;
        }        
        
        return $version;
    }
    // end of get_data_local_version()
    
    
    static private function get_data_remote_version() {

        $version = 0;
        $file_date = date("Ymd", filemtime( self::VERSION_PATH ) );
        $current_date = date("Ymd");
        if ( $file_date==$current_date ) {
            return $version;
        }
        
        $answer = wp_remote_get( self::VERSION_URL, array('timeout' => 5 ) );
        if ( is_wp_error( $answer ) ) {
            $error_message = $answer->get_error_message();
        } else {
            if ($answer['response']['code']==200) {
                $obj = json_decode( $answer['body'] );
                $version = $obj->version;                
            } else {
                $error_message = $answer['response']['code'] .' '. $answer['response']['message'];
            }
        }        
        
        return $version;
    }
    // end of get_data_local_version()
    
    
    static private function get_remote_data( $url, $file_name ) {
        
        $result = -1;
        $answer = wp_remote_get( $url, array('timeout' => 5 ) );
        if ( is_wp_error( $answer ) ) {
            $error_message = $answer->get_error_message();            
        } else {
            if ($answer['response']['code']==200) {
                unlink( $file_name );
                file_put_contents( $file_name, $answer['body'] );
                $result = 1;
            } else {
                $error_message = $answer['response']['code'] .' '. $answer['response']['message'];
            }
        }
        
        return $result;
    }
    // end of get_remote_data()
    
    
    static private function update_version( $version ) {
            
        unlink( self::VERSION_PATH );
        $object = new stdClass();
        $object->version = $version;
        $json_data = json_encode( $object );
        file_put_contents( self::VERSION_PATH, $json_data );
        
    }
    // end of update_version()
    
    
    static private function _refresh_data( $version ) {
        
        $result1 = self::get_remote_data( self::SKIP_LIST_URL, PGC_PLUGIN_DIR .'/data/skip-list.json');
        $result2 = self::get_remote_data( self::PLUGINS_URL, PGC_PLUGIN_DIR .'/data/plugins.json');
        $result3 = self::get_remote_data( self::DB_TABLES_URL, PGC_PLUGIN_DIR .'/data/db-tables.json');
        
        $result = $result1 + $result2 + $result3;
        if ( $result!=3 ) {    // Something is wrong. We will try again later.
            return;
        }
        
        self::update_version( $version );
        
    }
    // end of _refresh_data()
    
    
    static public function refresh_data() {
    
        $local_version = self::get_data_local_version();
        $remote_version = self::get_data_remote_version();
        if ( $local_version>=$remote_version ) {
            return;
        }
        
        self::_refresh_data( $remote_version );
        
    }
    // end of refresh_data()
    
        
    static private function init_skip_list() {
        
        if ( !empty( self::$skip_list ) ) {
            return;
        }
        
        $data = file_get_contents( PGC_PLUGIN_DIR .'/data/skip-list.json');
        self::$skip_list = json_decode( $data, true );
        
    }
    // end of init_skip_list()
    
    
    static private function init_plugins() {
        
        if ( !empty( self::$plugins ) ) {
            return;
        }
        
        $data = file_get_contents( PGC_PLUGIN_DIR .'/data/plugins.json' );
        self::$plugins = json_decode( $data, true );
        
    }
    // end of init_plugins
    
    static public function get_skip_list() {
        
        self::init_skip_list();
        self::init_plugins();
        
        $checked = self::$skip_list;
        foreach( self::$plugins as $plugin ) {
            $checked[] = $plugin['file'];
        }
        
        
        return $checked;
    }
    
    
    static private function init_db_tables() {
        
        if ( !empty( self::$db_tables ) ) {
            return;
        }
        self::init_plugins();
        
        $data = file_get_contents( PGC_PLUGIN_DIR .'/data/db-tables.json');
        self::$db_tables = json_decode( $data, true );
        if ( !is_multisite() ) {
            // Global WordPress table for multisite. It's created by BuddyPress for WP single site
            self::$db_tables['signups'] = 'buddypress';
        }
        
    }
    // end of init_db_tables()
    

    static public function fill_data( stdClass &$table ) {

        self::init_db_tables();
        $name_lc = strtolower( $table->name_without_prefix );
        if ( !isset( self::$db_tables[$name_lc] ) ) {
            return false;
        }
        
        $plugin = self::$plugins[self::$db_tables[$name_lc]];
        $table->plugin_name = $plugin['name'];
        $table->plugin_file = $plugin['file'];
        $table->state = 'have used';
        
        return true;
    }
    // end of fill_data()
    
}
// end of PGC_Known_Plugins class
