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

		register_rest_route(
			'cf7apps/v1',
			'get-cf7-entries',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_cf7_entries' ),
				'permission_callback' => array( $this, 'authenticate' ),
			)
		);

		register_rest_route(
			'cf7apps/v1/',
			'delete-cf7-entries',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'delete_cf7_entries' ),
				'permission_callback' => array( $this, 'authenticate' ),
			)
		);

		register_rest_route(
			'cf7apps/v1/',
			'get-all-cf7-forms',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_all_cf7_forms' ),
				'permission_callback' => array( $this, 'authenticate' ),
			)
		);
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

	/**
	 * Get Contact Form 7 Entries | Callback
	 *
	 * @since 3.1.0
	 * @param WP_REST_Request $request The REST request object.
	 *
	 * @return WP_REST_Response
	 */
	public function get_cf7_entries( $request ) {
		$entries_module_enabled = get_option( 'cf7apps_settings' );
		$entries                = array();
		$total_entries          = 0;

		if ( is_array( $entries_module_enabled ) && isset( $entries_module_enabled['cf7-entries']['is_enabled'] ) && $entries_module_enabled['cf7-entries']['is_enabled'] ) {
			$page       = $request->get_param( 'page' );
			$per_page   = $request->get_param( 'per-page' );
			$search     = $request->get_param( 'search' );
			$form_id    = $request->get_param( 'form-id' );
			$start_date = $request->get_param( 'start-date' );
			$end_date   = $request->get_param( 'end-date' );

			if ( ! is_numeric( $page ) || $page < 1 ) {
				$page = 1;
			}

			if ( ! is_numeric( $per_page ) || $per_page < 1 ) {
				$per_page = 10; // Default to 10 entries per page
			}

			if ( ! empty( $start_date ) ) {
				// currently the date picker returns date -1 we need to add one day
				$start_date  = date( 'Y-m-d H:i:s', strtotime( $start_date . ' +1 day' ) );
				$start_date  = strtotime( $start_date );
			}

			if ( ! empty( $end_date ) ) {
				// currently the date picker returns date -1 we need to add one day
				$end_date    = date( 'Y-m-d H:i:s', strtotime( $end_date . ' +1 day' ) );
				$end_date  = strtotime( $end_date );
			}

			if ( ! empty( $start_date ) && ! empty( $end_date ) && $start_date === $end_date ) {
				$end_date = strtotime( date( 'Y-m-d H:i:s', $end_date ) . ' +1 day' );
			}

			// offset
			$offset = ( $page - 1 ) * $per_page;

			$entries       = CF7Apps_Form_Entries::get_all_entries( $per_page, $offset, $form_id, $search, $start_date, $end_date, array( 'orderby' => 'id', 'order' => 'DESC' ) );
			$total_entries = CF7Apps_Form_Entries::get_total_entries( $form_id, $search, $start_date, $end_date );

			if ( empty( $entries ) ) {
				wp_send_json_error( 'No entries found.', 404 );
			}
		}

		return rest_ensure_response(
			array(
				'success' => true,
				'data'    => $entries,
				'total'   => $total_entries,
			)
		);
	}

	/**
	 * Delete Contact Form 7 Entries | Callback
	 *
	 * @since 3.1.0
	 * @param WP_REST_Request $request The REST request object.
	 *
	 * @return WP_REST_Response
	 */
	public function delete_cf7_entries( $request ) {
		$entry_ids = $request->get_param( 'entry_ids' );
		CF7Apps_Form_Entries::delete_entries( $entry_ids );

		wp_send_json_success( 'Entries deleted successfully.' );
	}

	/**
	 * Get All Contact Form 7 Forms | Callback
	 *
	 * @since 3.1.0
	 *
	 */
	public function get_all_cf7_forms() {
		$cf7_forms = get_posts( array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => -1,
			'post_status'    => 'publish'
		) );

		if ( empty( $cf7_forms ) ) {
			wp_send_json_error( 'No forms found.', 404 );
		}

		$cf7_forms = wp_list_pluck( $cf7_forms, 'post_title', 'ID' );
		$cf7_forms[0] = __( 'All Forms', 'cf7apps' );

		wp_send_json_success( $cf7_forms );
	}
}

new CF7Apps_Rest_API_WP_Admin_V1();