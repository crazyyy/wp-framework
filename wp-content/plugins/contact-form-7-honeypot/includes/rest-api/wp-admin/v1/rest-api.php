<?php

class CF7Apps_Rest_API_WP_Admin_V1 extends CF7Apps_Base_Rest_API {

    /**
     * Constructor
     * 
     * @since 3.0.0
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register Routes | Action Callback
     * 
     * @since 3.0.0
     */
    public function register_routes() {
        register_rest_route( 'cf7apps/v1', '/get-menu-items', array(
            'methods'               => 'GET',
            'callback'              => array( $this, 'get_menu_items' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/get-apps(?:/(?P<id>[\w-]+))?', array(
            'methods'               => 'GET',
            'callback'              => array( $this, 'get_apps' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/save-app-settings', array(
            'methods'               => 'POST',
            'callback'              => array( $this, 'save_app_settings' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/get-app-settings', array(
            'methods'               => 'POST',
            'callback'              => array( $this, 'get_app_settings' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/get-cf7-forms', array(
            'methods'               => 'GET',
            'callback'              => array( $this, 'get_cf7_forms' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/has-migrated', array(
            'methods'               => 'GET',
            'callback'              => array( $this, 'has_migrated' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );

        register_rest_route( 'cf7apps/v1', '/migrate', array(
            'methods'               => 'POST',
            'callback'              => array( $this, 'migrate' ),
            'permission_callback'   => array( $this, 'authenticate' ),
        ) );
    }

    /**
     * Get Menu Items | Callback
     * 
     * @since 3.0.0
     */
    public function get_menu_items( $request ) {
        $registered_apps = $this->get_registered_apps();
        $menu_items = array();

        // First, collect all apps with their priorities
        $apps_with_priority = array();
        
        foreach( $registered_apps as $app ) {
            if( class_exists( $app ) ) {
                $app_instance = new $app;

                if( $app_instance->has_admin_settings ) {
                    $apps_with_priority[] = array(
                        'id' => $app_instance->id,
                        'title' => $app_instance->title,
                        'parent_menu' => $app_instance->parent_menu,
                        'priority' => property_exists($app_instance, 'priority') ? $app_instance->priority : 999
                    );
                }
            }
        }

        // Sort by priority
        usort($apps_with_priority, function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        // Now organize by parent menu while maintaining the sorted order
        foreach($apps_with_priority as $app) {
            $menu_items[$app['parent_menu']][$app['id']] = $app['title'];
        }

        wp_send_json_success( $menu_items );
    }

    /**
     * Get Apps | Callback
     * 
     * @since 3.0.0
     */
    public function get_apps( $request ) {
        $id = $request->get_param( 'id' );

        $registered_apps = $this->get_registered_apps();
        $apps = array();
        $apps_with_priority = array();

        // First, collect all apps with their priorities
        foreach( $registered_apps as $key => $app ) {
            if( class_exists( $app ) ) {
                $app_instance = new $app;
                $apps_with_priority[] = array(
                    'app_instance' => $app_instance,
                    'priority' => property_exists($app_instance, 'priority') ? $app_instance->priority : 999
                );

                // If specific ID is requested, return immediately
                if( ! empty( $id ) && $app_instance->id == $id ) {
                    wp_send_json_success( $app_instance->get_settings() );
                }
            }
        }

        // Sort by priority
        usort($apps_with_priority, function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        // Extract the sorted app settings
        foreach($apps_with_priority as $app_data) {
            $apps[] = $app_data['app_instance']->get_settings();
        }

        wp_send_json_success( $apps );
    }

    /**
     * Save Settings | Callback
     * 
     * @since 3.0.0
     */
    public function save_app_settings( $request ) {
        $settings = $request->get_body(); 
        $settings = json_decode( $settings, true );

        if( ! $settings || empty( $settings ) || ! isset( $settings['app_settings'] ) ) {
            wp_send_json_error( 
                'Invalid Request', 
                500 
            );
        }

        foreach( $settings['app_settings'] as $key => $value ) { 
            $settings[$key] = sanitize_text_field( $value );
        }

        $response = cf7apps_save_app_settings( $settings['id'], $settings['app_settings'] );

        if( $response ) {
            wp_send_json_success( 'Settings Saved' );
        }
        else {
            wp_send_json_error( 
                'Error Saving Settings',
                500
            );
        }
    }

    /**
     * Get Contact form 7 forms | Callback
     * 
     * @since 3.0.0
     */
    public function get_cf7_forms( $request ) {
        $data = array();
        $cf7_forms = get_posts( array(
            'post_type'      => 'wpcf7_contact_form',
            'posts_per_page' => -1
        ) );

        foreach ( $cf7_forms as $cf7_form ) {
            $hash = substr( get_post_meta( $cf7_form->ID, '_hash', true ), 0, 7 );
            $form = get_post_meta( $cf7_form->ID, '_form', true );
            $regx = '/\[honeypot [a-zA-Z]/i';
            preg_match_all( $regx, $form, $matches );
            $is_honeypot_enabled = ! empty( $matches[0] ) ? __( 'Yes', 'cf7apps' ) : __( 'No', 'cf7apps' );

            $data[] = array(
                'id'        => $cf7_form->ID,
                'title'     => $cf7_form->post_title,
                'shortcode' => '[contact-form-7 id="'.$hash.'" title="'.get_the_title( $cf7_form->ID ).'"]',
                'honeypot'  => $is_honeypot_enabled,
                'date'      => get_the_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $cf7_form->ID ),
                'action'    => admin_url( 'post.php?page=wpcf7&post='.$cf7_form->ID.'&action=edit' )
            );
        }

        wp_send_json_success( $data );
    }

    /**
     * Has Migrated | Callback
     * 
     * @since 3.0.0
     */
    public function has_migrated( $request ) {
        $honeypot4cf7_config = get_option( 'honeypot4cf7_config' );

        if( $honeypot4cf7_config ) {
            wp_send_json_success( array( 'has_migrated' => false ) );
        }

        wp_send_json_success( array( 'has_migrated' => true ) );
    }

    /**
     * Migrate Settings | Callback
     * 
     * @since 3.0.0
     */
    public function migrate() { 
        try {
            cf7apps_migrate_legacy_settings();

            wp_send_json_success( 'Migration completed.' );
        } catch( Exception $e ) {
            wp_send_json_error( 
                "Migration not completed, Something went wrong {$e->getMessage()}", 
                500 
            );
        }
    }
}

new CF7Apps_Rest_API_WP_Admin_V1();