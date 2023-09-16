<?php
/**
 * Post Snippets
 *
 * @package         PS
 * @author          Postsnippets <support@wpexperts.io>
 * @license         GPL-2.0+
 * @link            https://www.postsnippets.com
 *
 * @wordpress-plugin
 * Plugin Name: Post Snippets (free)
 * Plugin URI: https://www.postsnippets.com
 * Description: Create a library of reusable content and insert it into your posts and pages. Navigate to "Settings > Post Snippets" to get started.
 * Version: 4.0.4
 * Author: Postsnippets
 * Author URI: https://www.postsnippets.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: post-snippets
 * Domain Path: /lang
 *
 * @fs_premium_only /assets-pro/
 */

if ( !function_exists( 'postsnippets_fs' ) ) {
    // Create a helper function for easy SDK access.
    function postsnippets_fs()
    {
        global  $postsnippets_fs ;

        if ( !isset( $postsnippets_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $postsnippets_fs = fs_dynamic_init( array(
                'id'             => '1576',
                'slug'           => 'post-snippets',
                'type'           => 'plugin',
                'public_key'     => 'pk_58a2ec84c44485a459aae07bfaf5f',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => false,
                'trial'          => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'menu'           => array(
                'slug'    => 'post-snippets',
                'contact' => false,
                'support' => false,
            ),
                'is_live'        => true,
            ) );
        }

        return $postsnippets_fs;
    }






    // Init Freemius.
    postsnippets_fs();
    // Signal that SDK was initiated.
    do_action( 'postsnippets_fs_loaded' );
    function postsnippets_fs_settings_url()
    {
        return admin_url( 'admin.php?page=post-snippets' );
    }


    postsnippets_fs()->add_action( 'after_uninstall', 'postsnippets_fs_uninstall_cleanup' );


        function postsnippets_fs_uninstall_cleanup() {
            $settings = get_option("post_snippets");
            $complete_uninstall = isset($settings['complete_uninstall']) ? $settings['complete_uninstall'] : false;

            if ($complete_uninstall) {

                global $wpdb;

                $wild = '%';
                $find = "post_snippets";
                $option_search = $wild . $wpdb->esc_like( $find ) . $wild;

                $option_names = $wpdb->get_results($wpdb->prepare("SELECT option_name FROM {$wpdb->prefix}options WHERE option_name LIKE %s", $option_search), ARRAY_A );

                if( !empty($option_names) ){
                    $option_names = array_column($option_names, 'option_name');
                    foreach ($option_names as $option_name) {

                        delete_option($option_name);

                        // for site options in Multisite
                        delete_site_option($option_name);

                    }
                }
                $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pspro_snippets");
                $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pspro_groups");
            }
        }

  //  postsnippets_fs()->add_filter( 'connect_url', 'postsnippets_fs_settings_url' );
  //  postsnippets_fs()->add_filter( 'after_skip_url', 'postsnippets_fs_settings_url' );
  //  postsnippets_fs()->add_filter( 'after_connect_url', 'postsnippets_fs_settings_url' );
  //  postsnippets_fs()->add_filter( 'after_pending_connect_url', 'postsnippets_fs_settings_url' );
    /**
     * Only show Post Snippets submenu when PS is open, not on all Settings pages
     */
    function postsnippets_show_submenu( $is_visible )
    {
        if ( isset( $_REQUEST['page'] ) ) {
            if ( $is_visible && false !== strpos( $_REQUEST['page'], 'post-snippets' ) ) {
                return true;
            }
        }
        return false;
    }

    postsnippets_fs()->add_filter(
        'is_submenu_visible',
        'postsnippets_show_submenu',
        10,
        2
    );
    if ( !defined( 'PS_MAIN_FILE' ) ) {
        define( 'PS_MAIN_FILE', basename( __FILE__ ) );
    }
    if ( !defined( 'PS_VERSION' ) ) {
        define( 'PS_VERSION', '4.0.4' );
    }
    if ( !defined( 'PS_MAIN_FILE_PATH' ) ) {
        define( 'PS_MAIN_FILE_PATH', __FILE__ );
    }
    if ( !defined( 'PS_DIRECTORY' ) ) {
        define( 'PS_DIRECTORY', plugin_basename( dirname( __FILE__ ) ) );
    }
    if ( !defined( 'PS_PATH' ) ) {
        define( 'PS_PATH', plugin_dir_path( __FILE__ ) );
    }
    if ( !defined( 'PS_URL' ) ) {
        define( 'PS_URL', plugins_url( '', __FILE__ ) . '/' );
    }
    if ( !defined( 'PS_MAIN_PAGE_URL' ) ) {
        define( 'PS_MAIN_PAGE_URL', esc_url( admin_url( 'admin.php?page=post-snippets' ) ) );
    }
    class PostSnippets
    {
        /** Holds the plugin instance */
        private static  $instance = false ;
        /** Define plugin constants */
        const  MIN_PHP_VERSION      = '7.1' ;
        const  MIN_WP_VERSION       = '5.3' ;
        const  SETTINGS             = 'post_snippets' ;
        const  VERSION_KEY          = 'post_snippets_version' ;
        const  OPTION_KEY           = 'post_snippets_options' ;
        const  PS_ENABLE_REST       = 'post_snippets_enable_rest' ;
        const  USER_META_KEY        = 'post_snippets' ;
        const  FILE                 = __FILE__ ;

        const  TABLE_NAME           = 'pspro_snippets';
        const  GROUP_TABLE_NAME     = 'pspro_groups';
        const  GROUP_CLASS          = 'PostSnippets\Group';
        const  EDIT_CLASS           = 'PostSnippets\Edit';

        const  DUPLICATE_SETTINGS   = 'duplicate_option' ;

        /**
         * Singleton class
         */
        public static function getInstance()
        {
            if ( !self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Initializes the plugin.
         */
        private function __construct()
        {
            if ( !$this->testHost() ) {
                return;
            }
            load_plugin_textdomain( 'post-snippets', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
            add_action( 'after_setup_theme', array( &$this, 'phpExecState' ) );
            // add_action( 'admin_enqueue_scripts', array($this, 'enqueue_hide_seek_search_library') );

            //requiring PS functions file
            require_once 'src/PS_functions.php';

            new \PostSnippets\Admin();
            new \PostSnippets\WPEditor();
            new \PostSnippets\Shortcode();

            if (postsnippets_fs()->can_use_premium_code() && file_exists(plugin_dir_path( self::FILE ).'/src/PostSnippets/PSRestAdmin.php')) {

                new \PostSnippets\PSRestAdmin();

                if ( 'yes' == get_option( self::PS_ENABLE_REST) && file_exists(plugin_dir_path( self::FILE ).'/src/PostSnippets/PSRestFunctions.php')) {

                    new \PostSnippets\PSRestFunctions();

                }

            }

        }

        /**
         * PSR-0 compliant autoloader to load classes as needed.
         *
         * @param  string $classname
         *
         * @return void
         */
        public static function autoload( $className )
        {
            if ( __CLASS__ !== mb_substr( $className, 0, strlen( __CLASS__ ) ) ) {
                return;
            }

            $className = ltrim( $className, '\\' );
            $fileName = '';
            $namespace = '';

            if ( $lastNsPos = strrpos( $className, '\\' ) ) {
                $namespace = substr( $className, 0, $lastNsPos );
                $className = substr( $className, $lastNsPos + 1 );
                $fileName = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace );
                $fileName .= DIRECTORY_SEPARATOR;
            }

            $fileName .= str_replace( '_', DIRECTORY_SEPARATOR, $className );

            require 'src' . DIRECTORY_SEPARATOR . $fileName . '.php';
        }

        // -------------------------------------------------------------------------
        // Helpers
        // -------------------------------------------------------------------------
        /**
         * Allow snippets to be retrieved directly from PHP.
         *
         * @since   Post Snippets 1.8.9.1
         *
         * @param  string       $name      The name of the snippet to retrieve
         * @param  string|array $variables The variables to pass to the snippet,
         *                                 formatted as a query string or an associative array.
         *
         * @return string  The Snippet
         */
        public static function getSnippet( $name = '', $variables = '' )
        {

            if( empty($name) ){
                return;
            }

            global $wpdb;
            $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;

            $wild = '%';
            $find = $name;
            $snippet_title_like = $wild . $wpdb->esc_like( $find ) . $wild;

            $particular_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title LIKE %s", $snippet_title_like), ARRAY_A );

            if( empty($particular_snippets) ){
                return;
            }

            foreach($particular_snippets as $particular_snippet){   /**Multiple Snippets of Similar Name (Case Sensitive) */

                if( strcmp($particular_snippet['snippet_title'], $name) == 0  && !empty($particular_snippet) ){
                    $snippet = $particular_snippet;
                    break;
                }
            }

            if( empty( $snippet ) || empty( $snippet['snippet_content'] ) ){
                return;
            }

            $snippet_content =  $snippet['snippet_content'];
            if ( !is_array( $variables ) ) {
                parse_str( htmlspecialchars_decode( $variables ), $variables );
            }

            $default_atts = \PostSnippets\Shortcode::filterVars( $snippet['snippet_vars'] );
            $short_atts = shortcode_atts( $default_atts, $variables );

            if( !empty($short_atts) ){
                foreach ($short_atts as $key => $val) {
                    if( !empty($val) ){
                        $snippet_content = str_replace( "{" . $key . "}", $val, $snippet_content );
                    }
                }
            }

            return do_shortcode( $snippet_content );
        }

        // -------------------------------------------------------------------------
        // Environment Checks
        // -------------------------------------------------------------------------
        /**
         * Checks PHP and WordPress versions.
         */
        private function testHost()
        {
            // Check if PHP is too old

            if ( version_compare( PHP_VERSION, self::MIN_PHP_VERSION, '<' ) ) {
                // Display notice
                add_action( 'admin_notices', array( &$this, 'phpVersionError' ) );
                return false;
            }

            // Check if WordPress is too old
            global  $wp_version ;

            if ( version_compare( $wp_version, self::MIN_WP_VERSION, '<' ) ) {
                add_action( 'admin_notices', array( &$this, 'wpVersionError' ) );
                return false;
            }

            return true;
        }

        /**
         * Displays a warning when installed on an old PHP version.
         */
        public function phpVersionError()
        {
            echo  '<div class="error"><p><strong>' ;
            printf(
                'Error: %3$s requires PHP version %1$s or greater.<br/>' . 'Your installed PHP version: %2$s',
                self::MIN_PHP_VERSION,
                PHP_VERSION,
                $this->getPluginName()
            );
            echo  '</strong></p></div>' ;
        }

        /**
         * Displays a warning when installed in an old WordPress version.
         */
        public function wpVersionError()
        {
            echo  '<div class="error"><p><strong>' ;
            printf( 'Error: %2$s requires WordPress version %1$s or greater.', self::MIN_WP_VERSION, $this->getPluginName() );
            echo  '</strong></p></div>' ;
        }

        /**
         * Get the name of this plugin.
         *
         * @return string The plugin name.
         */
        private function getPluginName()
        {
            $data = get_plugin_data( self::FILE );
            return $data['Name'];
        }

        // -------------------------------------------------------------------------
        // Deprecated methods
        // -------------------------------------------------------------------------
        /**
         * Allow plugins to disable the PHP Code execution feature with a filter.
         * Deprecated: Use the POST_SNIPPETS_DISABLE_PHP global constant to disable
         * PHP instead.
         *
         * @see        http://wordpress.org/extend/plugins/post-snippets/faq/
         * @since      2.1
         * @deprecated 2.3
         */
        public function phpExecState()
        {
            $filter = apply_filters( 'post_snippets_php_execution_enabled', true );

            if ( $filter == false and !defined( 'POST_SNIPPETS_DISABLE_PHP' ) ) {
                _deprecated_function( 'post_snippets_php_execution_enabled', '2.3', 'define(\'POST_SNIPPETS_DISABLE_PHP\', true);' );
                define( 'POST_SNIPPETS_DISABLE_PHP', true );
            }

        }

        /*
        public function enqueue_hide_seek_search_library() {
            wp_enqueue_script('jquery-hideseek', plugin_dir_url( __FILE__ ) . 'assets-pro/jquery.hideseek.js', array( 'jquery' ), '1.0.0', true  );
        }
        */



        /**
         * routines to run after the plugin is activated.
         */
        public static function post_snippet_pro_activated() {

            /**Create DB Table, if not already */
            new \PostSnippets\DBTable();


        }

        /**
         * routines to run to check whether the plugin is activated .
         */
        public static function post_snippet_pro_update_check() {

            $current_plugin_verion  = get_option( self::VERSION_KEY );

            if(!$current_plugin_verion){

                update_option( self::VERSION_KEY, PS_VERSION );

                /**Create DB Table, if not already */
                new \PostSnippets\DBTable();
            }

        }




    }
    add_action( 'plugins_loaded', array( 'PostSnippets', 'getInstance' ) );
    add_action( 'plugins_loaded', array( 'PostSnippets', 'post_snippet_pro_update_check' ) ); /**Check For Version and Update Accordingly */

    /**
     * Load all of the necessary class files for the plugin
     */
    spl_autoload_register( 'PostSnippets::autoload' );

    register_activation_hook( __FILE__, array( 'PostSnippets', 'post_snippet_pro_activated' ) );



}