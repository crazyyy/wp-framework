<?php

/**
 * Save App Settings
 * 
 * @param int $id
 * @param array $settings
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'cf7apps_save_app_settings' ) ):
function cf7apps_save_app_settings( $id, $settings ) {
    $existing_settings = get_option( 'cf7apps_settings', false );

    if( $existing_settings ) {
        if( isset( $existing_settings[$id] ) ) {
            $existing_settings[$id] = array_merge( $existing_settings[$id], $settings );
        }
        else {
            $existing_settings[$id] = $settings;
        }
    }
    else {
        $existing_settings = array(
            $id => $settings
        );
    }
    
    update_option( 'cf7apps_settings', $existing_settings );

    return true;
}
endif;

/**
 * Migrate Legacy Settings
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'cf7apps_migrate_legacy_settings' ) ):
function cf7apps_migrate_legacy_settings() {
    $honeypot4cf7_config = get_option( 'honeypot4cf7_config' );
    $cf7apps_settings = array();

    if( $honeypot4cf7_config ) {
        $cf7apps_settings['is_enabled'] = 1;
        $cf7apps_settings['store_value'] = ! empty( $honeypot4cf7_config['store_honeypot'] ) ? $honeypot4cf7_config['store_honeypot'] : '';
        $cf7apps_settings['global_placeholder'] = ! empty( $honeypot4cf7_config['placeholder'] ) ? $honeypot4cf7_config['placeholder'] : '';
        $cf7apps_settings['accessibility_msg'] = ! empty( $honeypot4cf7_config['accessibility_message'] ) ? $honeypot4cf7_config['accessibility_message'] : '';
        $cf7apps_settings['inline_css'] = ( ! empty( $honeypot4cf7_config['move_inline_css'][0] ) && $honeypot4cf7_config['move_inline_css'][0] == 'true' ) ? 1 : 0;
        $cf7apps_settings['enable_time_check'] = ( ! empty( $honeypot4cf7_config['timecheck_enabled'][0] ) && $honeypot4cf7_config['timecheck_enabled'][0] == 'true' ) ? 1 : 0;
        $cf7apps_settings['time_check'] = ! empty( $honeypot4cf7_config['timecheck_value'] ) ? $honeypot4cf7_config['timecheck_value'] : '';
        $cf7apps_settings['standard_auto_complete'] = ( ! empty( $honeypot4cf7_config['w3c_valid_autocomplete'][0] ) && $honeypot4cf7_config['w3c_valid_autocomplete'][0] == 'true' ) ? 1 : 0;
        $cf7apps_settings['accessibility_label'] = ( ! empty( $honeypot4cf7_config['nomessage'][0] && $honeypot4cf7_config['nomessage'][0] == 'true' ) ) ? 1 : 0;
        $cf7apps_settings['honeypot_count'] = ! empty( $honeypot4cf7_config['honeypot_count'] ) ? $honeypot4cf7_config['honeypot_count'] : 0;
        $cf7apps_settings['honeypot_install_date'] = ! empty( $honeypot4cf7_config['honeypot_install_date'] ) ? $honeypot4cf7_config['honeypot_install_date'] : time();
        $cf7apps_settings['honeypot_cf7_req_msg_dismissed'] = ! empty( $honeypot4cf7_config['honeypot_cf7_req_msg_dismissed'] ) ? $honeypot4cf7_config['honeypot_cf7_req_msg_dismissed'] : 0;
        $cf7apps_settings['honeypot4cf7_version'] = ! empty( $honeypot4cf7_config['honeypot4cf7_version'] ) ? $honeypot4cf7_config['honeypot4cf7_version'] : CF7APPS_VERSION;

        cf7apps_save_app_settings( 'honeypot', $cf7apps_settings );
        
        delete_option( 'honeypot4cf7_config' );
    }
}
endif;

/**
 * Get Default Settings
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'cf7apps_get_default_settings' ) ):
function cf7apps_get_default_settings() {
    return array(
        'is_enabled'                        => 1,
        'store_value'                       => 0,
        'global_placeholder'                => '',
        'accessibility_msg'                 => '',
        'inline_css'                        => 0,
        'enable_time_check'                 => 0,
        'time_check'                        => 4,
        'standard_auto_complete'            => 0,
        'accessibility_label'               => 0,
        'honeypot_count'                    => 0,
        'honeypot_install_date'             => time(),
        'honeypot_cf7_req_msg_dismissed'    => 0,
        'honeypot4cf7_version'              => CF7APPS_VERSION
    );
}
endif;