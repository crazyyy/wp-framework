<?php

    class Nevma_Performance_Profiler_Plugin extends Nevma_Base_Plugin {

        private static $instance = null;

        private $db;



        public static function get_instance () {

            if ( null == self::$instance ) {

                self::$instance = new self();

            }

            return self::$instance;
            
        }



        private function __construct () {

            $this->db = Nevma_Performance_Profiler_Plugin_DB::get_instance();

            $this->version = '0.1.0';
            $this->title   = 'Performance Profiler Plugin';
            $this->slug    = 'performance-profiler';

            $this->settings = array(
                'enabled'  => TRUE, 
                'frontend' => TRUE, 
                'backend'  => TRUE
            );

            $this->name = $this->get_slug() . '/' . $this->get_slug() . '.php';
            $this->path = dirname( plugin_dir_path( __FILE__ ) );
            $this->url  = dirname( plugin_dir_url( __FILE__ ) );

        }



        public function initialize () {

            register_activation_hook( $this->get_file(), array( $this, 'activate' ) );
            register_deactivation_hook( $this->get_file(), array( $this, 'deactivate' ) );

            if ( is_admin() ) {

                add_filter( 'plugin_action_links_' . $this->get_name(), array( $this, 'add_settings_page_link' ) );
                add_filter( 'plugin_row_meta',                          array( $this, 'add_external_links' ), 10, 2 );

                add_action( 'admin_init', array( $this, 'register_settings' ) );
                add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
                add_action( 'admin_menu', array( $this, 'add_settings_fields' ) );

                add_action( 'admin_enqueue_scripts', array( $this, 'add_settings_css' ) );
                
            }

            if ( ! $this->isEnabled() ) {

                return;

            }

            register_shutdown_function( array( $this, 'shutdown_callback' ) );

        }



        public function activate () {

            $this->db->create_table();

            $this->add_head_message( 'Plugin activated', 'The plugin has been successfully activated!' );

        }



        public function deactivate () {

            $this->add_head_message( 'Plugin deactivated', 'The plugin has been successfully deactivated!' );

        }



        public function uninstall () {

            $this->db->drop_table();

            $this->add_head_message( 'Plugin uninstalled', 'The plugin has been successfully uninstalled!' );

        }



        public function add_settings_fields () {

            add_settings_field( 
               'enabled',                             // ID.
               'Monitoring enabled',                  // Title.
               array( $this, 'print_enabled_field' ), // Print function callback.
               $this->get_slug(),                     // Plugin page.
               $this->get_slug()                      // Section.
            );

        }



        public function print_enabled_field () { 

            $settings = $this->get_settings(); ?>

            <label for = "<?php echo $this->get_slug(); ?>[enabled]">
                
                <input type = "checkbox" id = "<?php echo $this->get_slug(); ?>[enabled]" name = "<?php echo $this->get_slug(); ?>[enabled]" <?php echo $settings['enebled'] ? 'checked="checked"' : ''; ?> /> 

                Check to enable the plugin resource monitoring. If not checked, the plugin remains active, but resource monitoring is disabled.
                
            </label> <?php

        }



        public function settings_sanitize () {

            if ( ! isset( $_GET['action'] ) ) {

                return;

            }

        }



        public function settings_page_actions () {

            if ( ! isset( $_GET['action'] ) ) {

                return;

            }

            if ( $_GET['action'] == 'cleanup' ) {

                $this->db->truncate_table();
                
                $this->add_head_message( 'Database cleanup', '<p>The plugin database table has been successfully emptied and all its data have been deleted.</p>' );

            }

        }



        public function isEnabled () {

            $settings = $this->get_settings();

            return $settings['enabled'];

        }



        public function doRunOnFrontend () {

            $settings = $this->get_settings();
            
            return $settings['frontend'];

        }



        public function doRunOnBackend () {

            $settings = $this->get_settings();

            return $settings['backend'];

        }



        function shutdown_callback () {

            $duration  = intval( timer_stop( 0, 3 ) * 1000 ); 
            $RAM       = round( memory_get_peak_usage() / 1024 / 1024, 0 );
            $queries   = get_num_queries();
            $logged_in = false;
            $username  = NULL;

            if ( is_user_logged_in() ) {

                $current_user = wp_get_current_user();
                $logged_in = true;
                $username  = $current_user->user_login;

            }

            if ( is_admin() ) {
                $type = 'admin';
            } else if ( defined('DOING_CRON') && DOING_CRON ) {
                $type = 'cron';
            } else {
                $type = 'theme';
            }

            $this->db->insert_row(
                array( 
                    'timestamp'        => date_i18n( 'Y-m-d H:i:s', time() ),
                    'type'             => $type,
                    'ajax'             => defined('DOING_AJAX') && DOING_AJAX ? TRUE : FALSE,
                    'url'              => $_SERVER['REQUEST_URI'] . ( $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '' ),
                    'method'           => $_SERVER['REQUEST_METHOD'],
                    'loggedIn'         => $logged_in,
                    'user'             => $username,
                    'referer'          => $_SERVER['HTTP_REFERER'],
                    'userAgent'        => $_SERVER['HTTP_USER_AGENT'],
                    'duration'         => $duration,
                    'RAM'              => $RAM,
                    'queries'          => $queries,
                    'timeToFirstByte'  => isset( $data['timeToFirstByte'] )  ? $data['timeToFirstByte']  : NULL,
                    'DOMContentLoaded' => isset( $data['DOMContentLoaded'] ) ? $data['DOMContentLoaded'] : NULL,
                    'load'             => isset( $data['load'] )             ? $data['load']             : NULL,
                    'requests'         => isset( $data['requests'] )         ? $data['requests']         : NULL
                )
            );

        }

    }

?>