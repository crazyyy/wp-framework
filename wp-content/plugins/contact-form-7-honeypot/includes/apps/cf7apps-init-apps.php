<?php

class CF7Apps_Init_Apps {
    /**
     * Instance
     * 
     * @since 3.0.0
     */
    private static $instance;

    /**
     * Apps
     * 
     * @since 3.0.0
     */
    private $apps = array();

    /**
     * Initialize the class
     * 
     * @since 3.0.0
     */
    public static function instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CF7Apps_Init_Apps ) ) {
            self::$instance = new CF7Apps_Init_Apps;
        }

        return self::$instance;
    }

    /**
     * Constructor
     * 
     * @since 3.0.0
     */
    public function __construct() {
        $this->init_apps();
    }

    /**
     * Initialize the plugin
     * 
     * @since 3.0.0
     */
    public function init_apps() {
        foreach( new DirectoryIterator( CF7APPS_PLUGIN_DIR . '/includes/apps' ) as $file ) {
            if( $file->isDir() && ! $file->isDot() ) {
                $app_name = $file->getBasename();
                $app_file = "{$app_name}/{$app_name}.php";

                require_once $app_file;
            }
        }

        /**
         * Filter to Register App
         * 
         * @since 3.0.0
         */
        $this->apps = apply_filters( 'cf7apps_apps', $this->apps );

        // Run code globally for each app.
        foreach( $this->apps as $app ) {
            if( class_exists( $app ) ) {
                new $app;
            }
        }
    }
}

CF7Apps_Init_Apps::instance();