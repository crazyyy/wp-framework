<?php
/*
 * Main class of Plugins Garbage Collector WordPress plugin
 * Author: Vladimir Garagulya
 * Author email: vladimir@shinephp.com
 * Author URI: http://shinephp.com
 * License: GPL v2+
 * 
*/

class Plugins_Garbage_Collector {
    
    public function __construct() {
        
        //register_activation_hook( PGC_PLUGIN_FILE, array($this, 'install') );
        
        add_action( 'admin_init', array($this, 'plugin_init'), 1);

        // Add the translation function after the plugins loaded hook.
        add_action( 'plugins_loaded', array($this, 'load_translation') );

        // add menu item
        add_action( 'admin_menu', array($this, 'plugin_menu') );
        
        // set AJAX requests processing hook
        add_action( 'wp_ajax_plugins_garbage_collector', 'plugins_garbage_collector_ajax' );
        
    }
    // end of __construct()
    
    
    public function plugin_init() {
        
        if ( !is_admin() ) {
            return;
        }
                        
        // add a Settings link in the installed plugins page
        add_filter( 'plugin_action_links', array($this, 'plugin_action_links'), 10, 2 );
        add_filter( 'plugin_row_meta', array($this, 'plugin_row_meta'), 10, 2 ); 
        
        register_setting( 'pgc_options', 'pgc_options' );
        
    }
    // end of plugin_init()
    
    
    public function load_translation() {
        
        load_plugin_textdomain( 'plugins-garbage-collector', false, basename(dirname(PGC_PLUGIN_FILE)) .'/lang/' );
        
    }
    // end of load_translation()
    
/*    
    public function install() {
        
    }
    // end of install()
*/    
    
    public function plugin_action_links( $links, $file ) {
        
        if ( $file == plugin_basename( PGC_PLUGIN_FILE ) ) {
            $settings_link = '<a href="tools.php?page=plugins-garbage-collector.php">'. esc_html__('Scan','plugins-garbage-collector') .'</a>';
            array_unshift( $links, $settings_link );
        }
        
        return $links;
        
    }
    // end of plugin_action_links()
    
    
    public function plugin_row_meta( $links, $file ) {
    
        if ( $file == plugin_basename( PGC_PLUGIN_FILE ) ) {
            $links[] = '<a target="_blank" href="http://www.shinephp.com/plugins-garbage-collector-wordpress-plugin/#changelog">'. esc_html__('Changelog', 'plugins-garbage-collector').'</a>';
        }
        
        return $links;
        
    }
    // end of plugin_row_meta()
    
    
    private function process_post_actions() {
                        
        if ( isset( $_POST['drop_table_action'] ) ) {
            $mess = pgc_delete_unused_db_tables();
        } else if ( isset( $_POST['delete_extra_columns_action'] ) ) {
            $mess = pgc_delete_extra_columns_from_wp_tables();
        } else {
            $mess = '';
        }

        return $mess;
        
    }
    // end of process_post_actions()
    
    
    public function actions_page() {

        if ( !current_user_can( 'activate_plugins' ) ) {
            wp_die( 'You do not have sufficient permissions.' );
        }                               

        PGC_Known_Plugins::refresh_data();
        
        $mess = $this->process_post_actions();
        
        require_once( PGC_PLUGIN_DIR . 'includes/options.php' );

    }
    // end of actions_page()
        
    
    public function admin_css() {

        wp_enqueue_style( 'pgc_jquery_ui', PGC_PLUGIN_URL.'/css/vendors/jquery-ui/jquery-ui.min.css', array(), false, 'screen' );
        wp_enqueue_style( 'pgc_admin_css', PGC_PLUGIN_URL.'/css/pgc-admin.css', array(), false, 'screen' );

    }
    // end of admin_css()

    
    function admin_scripts() {

        wp_enqueue_script( 'pgc_js_script', PGC_PLUGIN_URL . '/js/pgc.js', array('jquery', 'jquery-form', 'jquery-ui-core', 'jquery-ui-progressbar'), PGC_VERSION );
        wp_localize_script(
                'pgc_js_script', 'pgcSettings', array('plugin_url' => PGC_PLUGIN_URL,
            'ajax_nonce' => wp_create_nonce('plugins-garbage-collector'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'redirect_url' => admin_url('/tools.php?page=plugins-garbage-collector.php&action='),
            'turn_on_cb_before_scan' => esc_html__('Turn on at least one Search checkbox before start Scan process!', 'plugins-garbage-collector'),
            'receive_plugins_list' => esc_html__('Receive plugins list', 'plugins-garbage-collector'),
            'scanning' => esc_html__('Scanning', 'plugins-garbage-collector'),
            'checking_plugin' => esc_html__('Checking plugin', 'plugins-garbage-collector'),
            'take_some_time' => esc_html__('will take some time. Please confirm to continue', 'plugins-garbage-collector'),
            'select_table_before_delete' => esc_html__('Select at least one table before click on Delete button', 'plugins-garbage-collector'),
            'confirm_before_tables_deletion1' => esc_html__('These tables will be permanently deleted. Continue?', 'plugins-garbage-collector'),
            'confirm_before_tables_deletion2' => esc_html__('Delete database tables last confirmation: Click "Cancel" if you have any doubt.', 'plugins-garbage-collector'),
            'work_done' => esc_html('Done', 'plugins-garbage-collector')
        ));
        
    }
    // end of admin_scripts()


    public function plugin_menu() {
        

        if ( !function_exists( 'add_management_page' ) ) {
            return;
        }
        
        $pgc_page = add_management_page( PGC_PLUGIN_NAME, PGC_PLUGIN_NAME, 'activate_plugins', basename( __FILE__), array($this, 'actions_page') );
        add_action( "admin_print_styles-$pgc_page", array($this, 'admin_css') );
        add_action( "admin_print_scripts-$pgc_page", array($this, 'admin_scripts') );
    
    }
    // end of plugin_menu()
     

}
// end of Plugins_Garbage_Collector
