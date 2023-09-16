<?php

    class Nevma_Base_Plugin {

        protected $version;
        protected $title;
        protected $slug;

        protected $settings;

        protected $name;
        protected $path;
        protected $url;



        public function get_version () {

            return $this->version;

        }



        public function get_title () {

            return $this->title;

        }



        public function get_slug () {

            return $this->slug;

        }



        public function get_settings () {
            
            return $this->settings;
        }



        public function get_name () {

            return $this->name;

        }



        public function get_url () {

            return $this->url;

        }



        public function get_path () {

            return $this->path;

        }



        public function get_file () {

            return $this->get_path() . '/' . $this->get_slug() . '.php';

        }



        public function add_settings_page_link ( $links ) {

            $links[] = '<a href = "options-general.php?page=' . $this->get_slug() . '">' . 'Settings' . '</a>';
            return $links;

        }



        public function add_external_links ( $links, $file ) {

            if ( $file != $this->get_name() ) {

                return $links;

            }
            
            $links[] = '<a href = "https://wordpress.org/plugins/' . $this->get_slug() . '/">Plugin page</a>';
            $links[] = '<a href = "http://wordpress.org/support/plugin/' . $this->get_slug() . '/">Support page</a>';

            return $links;

        }



        public function add_settings_page () {

            // Adds the plugin's options page as a submenu of the admin settings.
            
            $hook_name = add_options_page( 
                $this->get_title(),                   // Page title.
                $this->get_title(),                   // Menu title.
                'manage_options',                     // Capability.
                $this->get_slug(),                    // Menu slug.
                array( $this, 'print_settings_page' ) // Print function callback.
            );

            // Adds the action which adds the plugin admin actions.

            add_action( 'admin_head-' . $hook_name, array( $this, 'settings_page_actions' ) ); 

        }



        public function register_settings () {

            // Registers the plugin settings field.

            register_setting( 
                $this->get_slug(),  // Option group.
                $this->get_slug(),  // Option name.
                'settings_sanitize' // Function validator callback.
            );

            // Adds the plugin main settings section.

            add_settings_section(
                $this->get_slug(), // ID.
                '',                // Title.
                '',                // Print function callback.
                $this->get_slug()  // Plugin page.
            ); 

        }



        public function is_settings_screen () {
        
            $screen = get_current_screen();

            return $screen->id == 'settings_page_' . $this->get_slug();

        }



        public function add_settings_css () { 

            if ( ! $this->is_settings_screen() ) {

                return;

            } 

            wp_enqueue_style( $this->get_slug() . '-css', $this->get_url() . '/assets/css/admin.css' );
            
        }



        public function print_settings_page () {

            include $this->get_path() . '/views/index.php';

        }



        public function load_settings () {

            $this->settings = array_merge( $this->settings, get_option( $this->get_slug() ) );

        }



        public function add_head_message ( $title, $message, $type='updated' ) {

            add_settings_error( 
               $this->get_slug(), 
               $this->get_slug(), 
               $this->get_title() . ' &mdash; ' . $title . ' <hr />' . $message,
               $type 
            );

        }

    }

?>