<?php

if ( !class_exists('Easy_HTTPS_SSL') ) {
    class Easy_HTTPS_SSL
    {
        public $plugin_url;
        public $plugin_path;
        public $plugin_configs;//TODO - does it need to be static?
        public $admin_init;
        public $debug_logger;

        public function __construct() {
            $this->load_configs();
            $this->define_constants();
            $this->includes();
            $this->initialize_and_run_classes();

            // Register action hooks.
            add_action('plugins_loaded', array($this, 'plugins_loaded_handler'));
            // Note:  There is a init time tasks class which will do other init time tasks.
            add_action('init', array($this, 'ehssl_load_language'));

            // Trigger EHSSL plugin loaded action.
            do_action('ehssl_loaded');
        }

        public function plugin_url() {
            if ($this->plugin_url) {
                return $this->plugin_url;
            }

            return $this->plugin_url = plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__));
        }

        public function plugin_path() {
            if ($this->plugin_path) {
                return $this->plugin_path;
            }

            return $this->plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
        }

        public function load_configs() {
            include_once 'classes/ehssl-config.php';
            $this->plugin_configs = EHSSL_Config::get_instance();
        }

        public function define_constants() {
            define('EASY_HTTPS_SSL_URL', $this->plugin_url());
            define('EASY_HTTPS_SSL_PATH', $this->plugin_path());
            define('EHSSL_MANAGEMENT_PERMISSION', 'add_users');
            define('EHSSL_MENU_SLUG_PREFIX', 'ehssl');
            define('EHSSL_MAIN_MENU_SLUG', 'ehssl');
            define('EHSSL_SETTINGS_MENU_SLUG', 'ehssl_settings');
            define('EHSSL_CERTIFICATE_EXPIRY_MENU_SLUG', 'ehssl_certificate_expiry');
            define('EHSSL_SSL_MGMT_MENU_SLUG', 'ehssl-ssl-mgmt');
        }

        public function includes() {
            //Load common files for everywhere
            include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-debug-logger.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/utilities/ehssl-utils.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/utilities/ehssl-ssl-utils.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-cronjob.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-custom-post-types.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-email-handler.php';
            include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-init-time-tasks.php';

            if (is_admin()) { //Load admin side only files
                include_once EASY_HTTPS_SSL_PATH. '/admin/ehssl-admin-init.php';
            } else { 
                //Load front end side only files
            }
        }

        public function initialize_and_run_classes() {
            //Initialize the various classes and start running.

            //Common classes.
            $this->debug_logger = new EHSSL_Logger();
            new EHSSL_Init_Time_Tasks();// This will register the init time tasks.

            if (is_admin()) {
                // Admin side only classes.
                $this->admin_init = new EHSSL_Admin_Init();
            }
        }

        public static function plugin_activate_handler() {
	        wp_schedule_event(time(), 'daily', 'ehssl_daily_cron_event');
        }

        public static function plugin_deactivate_handler() {
	        wp_clear_scheduled_hook('ehssl_daily_cron_event');
        }

        public static function plugin_uninstall_handler() {
            //NOP.
        }

        public function ehssl_load_language() {
            // Internationalization.
            // A better practice for text domain is to use dashes instead of underscores.
            load_plugin_textdomain('https-redirection', false, EASY_HTTPS_SSL_PATH . '/languages/');
        }

        public function plugins_loaded_handler() { 
            // Runs when plugins_loaded action gets fired
            if (is_admin()) { 
                // Do admin side plugins_loaded operations
                $this->do_db_upgrade_check();
            }
        }

        public function do_db_upgrade_check() {
            //Check if DB needs to be updated
            // if (is_admin()) { 
            //     if (get_option('ehssl_db_version') != EASY_HTTPS_SSL_DB_VERSION) {
            //         //include_once ('file-name-installer.php');
            //         //easy_https_run_db_upgrade();
            //     }
            // }
        }        

    } // End of class.

} // End of class not exists check.

$GLOBALS['ehssl'] = new Easy_HTTPS_SSL();
