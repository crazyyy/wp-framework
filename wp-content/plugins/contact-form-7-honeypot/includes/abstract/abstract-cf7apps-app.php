<?php

abstract class CF7Apps_App {

    /**
     * App ID
     * 
     * @since 3.0.0
     */
    public $id;

    /**
     * Priority
     * 
     * @since 3.0.0
     */
    public $priority = 999;

    /**
     * App Title
     * 
     * @since 3.0.0
     */
    public $title;

    /**
     * App Description
     * 
     * @since 3.0.0
     */
    public $description;

    /**
     * App Icon
     * 
     * @since 3.0.0
     */
    public $icon;

    /**
     * Has Settings
     * 
     * @since 3.0.0
     */
    public $has_admin_settings = false;

    /**
     * Is Pro
     * 
     * @since 3.0.0
     */
    public $is_pro = false;

    /**
     * Is enabled by default
     * 
     * @since 3.0.0
     */
    public $by_default_enabled = false;

    /**
     * Documentation URL
     * 
     * @since 3.0.0
     */
    public $documentation_url;

    /**
     * Parent Menu
     * 
     * @since 3.0.0
     */
    public $parent_menu = false;

    /**
     * Setting Tabs
     * 
     * @since 3.0.0
     */
    public $setting_tabs = array();

    /**
     * Admin Settings
     * 
     * @since 3.0.0
     */
    public function admin_settings() {
        return array();
    }

    /**
     * Saved Settings
     * 
     * @since 3.0.0
     */
    public $options = false;

    /**
     * Get Option
     * 
     * @param string $key Option key to get
     * 
     * @since 3.0.0
     */
    public function get_option( $key = false ) {
        $default_settings = array();
        $default_settings['is_enabled'] = $this->by_default_enabled;
        
        $options = get_option( 'cf7apps_settings', $default_settings );

        if( $options && ! empty( $options[$this->id] ) ) {
            if( $key ) {
                return isset( $options[$this->id][$key] ) ? $options[$this->id][$key] : false;
            }
            else {
                return $options[$this->id];
            }
        }

        return false;
    }

    /**
     * Get Settings
     * 
     * @since 3.0.0
     */
    public function get_settings() {
        $default_settings = array();
        $default_settings['is_enabled'] = $this->by_default_enabled;
        
        $this->options = get_option( 'cf7apps_settings', $default_settings );

        $settings = new StdClass;
        $settings->id = $this->id;
        $settings->priority = $this->priority;
        $settings->title = $this->title;
        $settings->description = $this->description;
        $settings->icon = $this->icon;
        $settings->has_admin_settings = $this->has_admin_settings;
        $settings->is_pro = $this->is_pro;
        $settings->by_default_enabled = $this->by_default_enabled;
        $settings->documentation_url = $this->documentation_url;
        $settings->parent_menu = $this->parent_menu;
        $settings->setting_tabs = $this->setting_tabs;
        $settings = (array)$settings;

        if( $this->has_admin_settings ) {
            $settings['admin_settings'] = $this->admin_settings();
            
            if( isset( $this->options[$this->id] ) ) {
                
                if( empty( $this->setting_tabs ) ) {
                    $setting_fields = $settings['admin_settings']['general']['fields'];
                        
                    foreach( $setting_fields as $field_key => $field ) {
                        if( array_key_exists( $field_key, $this->options[$this->id] ) ) {
                            // If data is saved, set the value
                            if ( ( $field['type'] == 'checkbox' || $field['type'] == 'radio' ) && $this->options[$this->id][$field_key] == '1' ) {
                                $settings['admin_settings']['general']['fields'][$field_key]['checked'] = true;
                            } 
                            elseif ( $field['type'] == 'select' ) {
                                $settings['admin_settings']['general']['fields'][$field_key]['selected'] = $this->options[$this->id][$field_key];
                            } 
                            else {
                                $settings['admin_settings']['general']['fields'][$field_key]['value'] = $this->options[$this->id][$field_key];
                            }
                        }
                        else {
                            // Set default value
                            $_field = $settings['admin_settings']['general']['fields'][$field_key];

                            if( isset( $field['type'] ) ) {
                                if ( $field['type'] == 'checkbox' ) {
                                    $settings['admin_settings']['general']['fields'][$field_key]['checked'] = ( isset( $_field['default'] ) && $_field['default'] ) ? true : false;
                                }
                                elseif ( $field['type'] == 'select' ) {
                                    $settings['admin_settings']['general']['fields'][$field_key]['selected'] = ( isset( $_field['default'] ) ) ? $_field['default'] : '';
                                }
                                else {
                                    $settings['admin_settings']['general']['fields'][$field_key]['value'] = ( isset( $_field['default'] ) ) ? $_field['default'] : '';
                                }
                            }
                        }
                    }
                }
                else {
                    foreach( $this->setting_tabs as $tab_key => $tab_title ) {
                        $settings_tab_fields = $settings['admin_settings']['general']['fields'][$tab_key];

                        // Templates are managed in React
                        if( array_key_exists( 'template', $settings_tab_fields ) ) {
                            continue;
                        }
                        
                        foreach( $settings_tab_fields as $field_key => $field ) {
                            if( array_key_exists( $field_key, $this->options[$this->id] ) ) {
                                // If data is saved, set the value
                                if ( ( $field['type'] == 'checkbox' || $field['type'] == 'radio' ) && $this->options[$this->id][$field_key] == '1' ) {
                                    $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['checked'] = true;
                                } 
                                elseif ( $field['type'] == 'select' ) {
                                    $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['selected'] = $this->options[$this->id][$field_key];
                                } 
                                else {
                                    $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['value'] = $this->options[$this->id][$field_key];
                                }
                            }
                            else {
                                // Set default value
                                $_field = $settings['admin_settings']['general']['fields'][$tab_key][$field_key];

                                if( isset( $field['type'] ) ) {
                                    if ( $field['type'] == 'checkbox' ) {
                                        $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['checked'] = ( isset( $_field['default'] ) && $_field['default'] ) ? true : false;
                                    }
                                    elseif ( $field['type'] == 'select' ) {
                                        $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['selected'] = ( isset( $_field['default'] ) ) ? $_field['default'] : '';
                                    }
                                    else {
                                        $settings['admin_settings']['general']['fields'][$tab_key][$field_key]['value'] = ( isset( $_field['default'] ) ) ? $_field['default'] : '';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $is_enabled = isset( $this->options[$this->id] ) ? array( 'is_enabled' => $this->options[$this->id]['is_enabled'] ) : $default_settings;
        $settings = array_merge( $settings, $is_enabled );
        
        return $settings;
    }
}