<?php
/**
 * Inits the admin dashboard side of things.
 * Main admin file which loads all settings panels and sets up admin menus.
 */
class EHSSL_Admin_Init
{
    public $main_menu_page;
    public $dashboard_menu;
    public $settings_menu;

    public function __construct()
    {
        $this->admin_includes();
        add_action('admin_print_scripts', array($this, 'admin_menu_page_scripts'));
        add_action('admin_print_styles', array($this, 'admin_menu_page_styles'));
        add_action('admin_menu', array($this, 'create_admin_menus'));
        add_action('admin_init', array($this, 'plugin_admin_init'));
        add_action('admin_enqueue_scripts', array($this, 'plugin_admin_head'));

        //Handle any admin notices.
        add_action('admin_notices', array($this, 'easy_https_plugin_admin_notices'));
    }

    public function admin_includes()
    {
        include_once 'ehssl-admin-menu.php';
        include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-rules-helper.php';

	    // TODO: Need to work on this later.
        // require_once EASY_HTTPS_SSL_PATH."/vendor/autoload.php";
        // include_once EASY_HTTPS_SSL_PATH . '/classes/ehssl-ssl-certificate.php';
    }

    public function admin_menu_page_scripts()
    {
        // Make sure we are on the appropriate menu page.
        if (isset($_GET['page']) && strpos($_GET['page'], EHSSL_MENU_SLUG_PREFIX) !== false) {
            wp_enqueue_script('postbox');
            wp_enqueue_script('dashboard');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('media-upload');
        }
    }

    public function admin_menu_page_styles()
    {
        // Make sure we are on the appropriate menu page.
        if (isset($_GET['page']) && strpos($_GET['page'], EHSSL_MENU_SLUG_PREFIX) !== false) {
            wp_enqueue_style('dashboard');
            wp_enqueue_style('thickbox');
            wp_enqueue_style('global');
            wp_enqueue_style('wp-admin');
            wp_enqueue_style('ehssl-admin-css', EASY_HTTPS_SSL_URL . '/css/ehssl-admin-styles.css');
        }
    }

    public function create_admin_menus() {
        //Going to use the lock dashicon for the menu icon for now.
        $menu_icon_url = 'dashicons-lock';
        //$menu_icon_url = EASY_HTTPS_SSL_URL . '/images/plugin-icon.png';

        $this->main_menu_page = add_menu_page(__('Easy HTTPS & SSL', 'https-redirection'), __('Easy HTTPS & SSL', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, EHSSL_MAIN_MENU_SLUG, array($this, 'handle_dashboard_menu_rendering'), $menu_icon_url);
        add_submenu_page(EHSSL_MAIN_MENU_SLUG, __('Dashboard', 'https-redirection'), __('Dashboard', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, EHSSL_MAIN_MENU_SLUG, array($this, 'handle_dashboard_menu_rendering'));
        add_submenu_page(EHSSL_MAIN_MENU_SLUG, __('Settings', 'https-redirection'), __('Settings', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, EHSSL_SETTINGS_MENU_SLUG, array($this, 'handle_settings_menu_rendering'));
        add_submenu_page(EHSSL_MAIN_MENU_SLUG, __('Certificate Expiry', 'https-redirection'), __('Certificate Expiry', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, EHSSL_CERTIFICATE_EXPIRY_MENU_SLUG, array($this, 'handle_certificate_expiry_menu_rendering'));

		// TODO: Need to work on this menu.
		// add_submenu_page(EHSSL_MAIN_MENU_SLUG, __('SSL Management', 'https-redirection'), __('SSL Management', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, EHSSL_SSL_MGMT_MENU_SLUG, array($this, 'handle_ssl_mgmt_menu_rendering'));
        
        //Keeping the old settings menu for now for backwards compatibility. There is a link to the new settings page in the old settings menu.
        add_submenu_page('options-general.php', __('HTTPS Redirection', 'https-redirection'), __('HTTPS Redirection', 'https-redirection'), EHSSL_MANAGEMENT_PERMISSION, 'https-redirection', array($this, 'handle_settings_menu_rendering_old'));

        //Trigger the action for the menu creation.
        do_action('ehssl_admin_menu_created');
    }

    public function handle_dashboard_menu_rendering()
    {
        include_once EASY_HTTPS_SSL_PATH . '/admin/ehssl-dashboard-menu.php';
        $this->dashboard_menu = new EHSSL_Dashboard_Menu();
    }

    public function handle_settings_menu_rendering()
    {
        include_once EASY_HTTPS_SSL_PATH . '/admin/ehssl-settings-menu.php';
        $this->settings_menu = new EHSSL_Settings_Menu();
    }

    public function handle_certificate_expiry_menu_rendering()
    {
        include_once EASY_HTTPS_SSL_PATH . '/admin/ehssl-certificate-expiry-menu.php';
        $this->settings_menu = new EHSSL_Certificate_Expiry_Menu();
    }

    public function handle_settings_menu_rendering_old()
    {
        include_once EASY_HTTPS_SSL_PATH . '/admin/ehssl-settings-menu-old.php';
        $this->settings_menu = new EHSSL_Settings_Menu_Old();
    }

    public function handle_ssl_mgmt_menu_rendering()
    {
        include_once EASY_HTTPS_SSL_PATH . '/admin/ehssl-ssl-management-menu.php';
        $this->settings_menu = new EHSSL_SSL_MGMT_Menu();
    }

    public function plugin_admin_init()
    {
        global $httpsrdrctn_plugin_info;

        $httpsrdrctn_plugin_info = get_plugin_data(__FILE__, false);

        /* Call register settings function */
        if (isset($_GET['page']) && "ehssl_settings" == $_GET['page']) {
            $this->register_httpsrdrctn_settings();
        }

        $this->handle_log_file_action();

        add_action( 'wp_ajax_ehssl_reset_log', array( $this, 'handle_reset_log' ) );
        add_action('wp_ajax_ehssl_save_dashboard_order', array($this, 'handle_save_dashboard_sorting_order'));
    }

    /**
     * Register settings function
     */
    public function register_httpsrdrctn_settings()
    {
        global $wpmu, $httpsrdrctn_options, $httpsrdrctn_plugin_info;

        $httpsrdrctn_option_defaults = array(
            'https' => 0,
            'https_domain' => 1,
            'https_pages_array' => array(),
            'force_resources' => 0,
            'plugin_option_version' => $httpsrdrctn_plugin_info["Version"],
        );

        // Install the option defaults.
        if (1 == $wpmu) {
            if (!get_site_option('httpsrdrctn_options')) {
                add_site_option('httpsrdrctn_options', $httpsrdrctn_option_defaults, '', 'yes');
            }

        } else {
            if (!get_option('httpsrdrctn_options')) {
                add_option('httpsrdrctn_options', $httpsrdrctn_option_defaults, '', 'yes');
            }
        }

        // Get options from the database.
        if (1 == $wpmu) {
            $httpsrdrctn_options = get_site_option('httpsrdrctn_options');
        } else {
            $httpsrdrctn_options = get_option('httpsrdrctn_options');
        }

        // Array merge incase this version has added new options.
        if (!isset($httpsrdrctn_options['plugin_option_version']) || $httpsrdrctn_options['plugin_option_version'] != $httpsrdrctn_plugin_info["Version"]) {
            $httpsrdrctn_options = array_merge($httpsrdrctn_option_defaults, $httpsrdrctn_options);
            $httpsrdrctn_options['plugin_option_version'] = $httpsrdrctn_plugin_info["Version"];
            update_option('httpsrdrctn_options', $httpsrdrctn_options);
        }
    }

    public function plugin_admin_head()
    {
         wp_enqueue_script('ehssl_script', EASY_HTTPS_SSL_URL . '/js/script.js', array('jquery'), EASY_HTTPS_SSL_VERSION);
    }

    public function handle_log_file_action()
    {
        if (isset($_GET['ehssl-debug-action']) && esc_attr($_GET['ehssl-debug-action']) === 'view_log') {
            if ( ! user_can( wp_get_current_user(), 'administrator' ) ) {
                // User is not an admin
                return;
            }
            $this->handle_view_log();
        }
    }

    public function handle_view_log()
    {
        if (!check_admin_referer('ehssl_view_log_nonce')) {
            //The nonce check failed
            echo 'Error! Nonce security check failed. Could not reset the log file.';
            wp_die(0);
        }

        $filename = EHSSL_Logger::get_log_file();
        if (file_exists($filename)) {
            $logfile = fopen(EHSSL_Logger::get_log_file(), 'rb');
            header('Content-Type: text/plain');
            fpassthru($logfile);
        }
        die;
    }

    public function handle_reset_log()
    {
        if (!current_user_can('manage_options')) {
            EHSSL_Logger::log("Error! No permission to reset log file.");
            //No permission for the current user to do this operation.
            wp_die(0);
        }

        if (!check_ajax_referer('ehssl_settings_ajax_nonce', 'nonce', false)) {
            //The nonce check failed
            echo 'Error! Nonce security check failed. Could not reset the log file.';
            wp_die(0);
        }

        $file_name = EHSSL_Logger::get_log_file_name();

        EHSSL_Logger::reset_log_file($file_name);

        echo '1';
		wp_die();
    }

    public function handle_save_dashboard_sorting_order(){
        global $httpsrdrctn_options;

        if (isset($_POST['ehssl_sort_order']) && ! empty($_POST['ehssl_sort_order'])) {
            $sorting_data = $_POST['ehssl_sort_order'];
            $httpsrdrctn_options['dashboard_widget_sort_order'] = json_encode($sorting_data);
            update_option('httpsrdrctn_options', $httpsrdrctn_options);
            wp_send_json_success( $httpsrdrctn_options['dashboard_widget_sort_order'] );
          } else {
            wp_send_json_error("Invalid request");
          }

          // Always exit to avoid further execution
          wp_die();
    }

    public function easy_https_plugin_admin_notices() {
        $missing_extensions = EHSSL_Utils::get_missing_extensions();
        if (!empty($missing_extensions)){
            $output = '<div class="notice notice-error">';
            $output .= '<p><b>'.__('NOTE:', 'https-redirection').'</b> ';
            $output .= __('The following php extensions are missing which is required by this plugin to work properly. Contact you hosting provider enable this.', 'https-redirection');
            $output .= '<ol>';
            foreach ($missing_extensions as $ext){
                $output .= '<li>'. $ext .'</li>';
            }
            $output .= '</ol>';
            $output .= '</p>';
            $output .= '</div>';

            echo $output;
        }
    }

} //End of class
