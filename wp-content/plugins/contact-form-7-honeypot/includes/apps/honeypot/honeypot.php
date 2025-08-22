<?php

class CF7Apps_Honeypot_App extends CF7Apps_App {

    /**
     * Constructor
     * 
     * @since 3.0.0
     */
    public function __construct() {
        $this->id = 'honeypot';
        $this->priority = 1;
        $this->title = __( 'Honeypot', 'cf7apps' );
        $this->description = __( 'Add invisible honeypot fields to your forms to trap spambots, ensuring spam-free form submission.', 'cf7apps' );
        $this->icon = plugin_dir_url( __FILE__ ) . 'assets/images/logo.png';
        $this->has_admin_settings = true;
        $this->is_pro = false;
        $this->by_default_enabled = true;
        $this->documentation_url = 'https://cf7apps.com/docs/spam-protection/contact-form-7-honeypot/';
        $this->parent_menu = __( 'Spam Protection', 'cf7apps' );
        $this->setting_tabs = array(
            'general'   => __( 'General', 'cf7apps' ),
            'forms'     => __( 'Forms', 'cf7apps' ),
        );

        add_filter( 'register_post_type_args', array( $this, 'register_post_type_args' ), 10, 2 );
    }
    
    /**
     * Register Admin Settings
     * 
     * @since 3.0.0
     */
    public function admin_settings() {
        return array(
            'general'   => array(
                'fields'        => array(
                    'general'       =>  array(
                        'title'         => __( 'Honeypot Settings' ),
                        'description'   => __( 'Below are global settings for the Honeypot plugin. Many of these settings can be overridden when inserting the Honeypot field shortcode when creating your CF7 contact form.', 'cf7apps' ),
                        'is_enabled'    => array(
                            'title'         => __( 'Enable Honeypot App', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => false,
                        ),
                        'store_value'  => array(
                            'title'         => __( 'Store Honeypot Value', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => true,
                            'help'          => __( '(Recommended) By default the Honeypot field is not stored with other fields in form-saving plugins like Flamingo. However, saving the field can be useful to see what spam bots are leaving behind to help you improve your spam stopping superpowers. If you\'d like to store the value of the field, simply check this box (and install Flamingo).', 'cf7apps' )
                        ),
                        'global_placeholder'   => array(
                            'title'         => __( 'Global Placeholder', 'cf7apps' ),
                            'type'          => 'text',
                            'description'   => __( 'If using placeholders on other fields, this can help honeypot mimic a "real" field. This can be overridden in the contact form. If you\'re unsure, leave blank.', 'cf7apps' ),
                            'class'         => 'xl'
                        ), 
                        'accessibility_msg'    => array(
                            'title'         => __( 'Accessibility Message', 'cf7apps' ),
                            'type'          => 'text',
                            'description'   => __( 'You can customize the (hidden) accessibility message, or just leave it the default value: Please leave this field empty.', 'cf7apps' ),
                            'class'         => 'xl'
                        ),
                        'standard_auto_complete'   => array(
                            'title'         => __( 'Use Standard Autocomplete Value', 'cf7apps' ),
                            'description'   => __( 'To assure the honeypot isn\'t auto-completed by a browser, we add an atypical "autocomplete" attribute value. If you have any problems with this, you can switch it to the more standard (but less effective) "off" value. If you\'re unsure, leave this unchecked.', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => false,
                            'help'          => __( 'To assure the honeypot isn\'t auto-completed by a browser, we add an atypical "autocomplete" .', 'cf7apps' )
                        ),
                        'inline_css'   => array(
                            'title'         => __( 'Move Inline CSS', 'cf7apps' ),
                            'description'   => __( 'By default Honeypot uses inline CSS on the honeypot field to hide it. Checking this box moves that CSS to the footer of the page. It may help confuse bots.', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => false,
                            'help'          => __( 'By default Honeypot uses inline CSS on the honeypot field to hide it. Checking this box moves.', 'cf7apps' )
                        ),
                        'accessibility_label'    => array(
                            'title'         => __( 'Disable Accessibility Label', 'cf7apps' ),
                            'description'   => __( 'If checked, the accessibility label will not be generated. This is not recommended, but may improve spam blocking. If you\'re unsure, leave this unchecked.', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => false,
                            'help'          => __( 'If checked, the accessibility label will not be generated. This is not recommended, but may improve.', 'cf7apps' )
                        ),
                        'enable_time_check'   => array(
                            'title'         => __( 'Enable Time Check', 'cf7apps' ),
                            'description'   => __( 'If enabled, this will perform an additional check for spam bots using the time it takes to submit the form under the idea that bots submit forms faster than people. The value is set to 4 seconds by default, but adjust based on your needs. If you\'re not sure, leave this unchecked.', 'cf7apps' ),
                            'type'          => 'checkbox',
                            'default'       => false
                        ),
                        'time_check'   => array(
                            'title'         => __( 'Time Check Value (Seconds)', 'cf7apps' ),
                            'description'   => __( 'If enabled, this will perform an additional check for spam bots using the time it takes to submit the form under the idea that bots submit forms faster than people. The value is set to 4 seconds by default, but adjust based on your needs. If you\'re not sure, leave this unchecked.', 'cf7apps' ),
                            'type'          => 'number',
                            'default'       => 4,
                            'class'         => 'xs'
                        ),
                        'save_settings'  => array(
                            'type'          => 'save_button',
                            'text'          => __( 'Save Settings', 'cf7apps' ),
                            'class'         => 'button-primary'
                        )
                    ),
                    'forms'     => array(
                        'template'      => 'HoneypotForms',
                    )
                )
            )
        );
    }

    /**
     * Register Post Type Args | Filter Callback
     * 
     * @since 3.0.0
     */
    public function register_post_type_args( $args, $post_type ) {
        if ( 'wpcf7_contact_form' === $post_type ) {
            $args['show_in_rest'] = true;
        }

        return $args;
    }
}

/**
 * Register Honeypot App
 * 
 * @since 3.0.0
 */
if( ! function_exists( 'cf7apps_register_honeypot' ) ):
function cf7apps_register_honeypot( $apps ) {
    $apps[] = 'CF7Apps_Honeypot_App';

    return $apps;
}
endif;

add_filter( 'cf7apps_apps', 'cf7apps_register_honeypot' );