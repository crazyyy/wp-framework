<?php

class AIOWPSecurity_Process_Renamed_Login_Page
{

    function __construct() 
    {
        add_action('login_init', array(&$this, 'aiowps_login_init'));
        add_filter('site_url', array(&$this, 'aiowps_site_url'), 10, 2);
        add_filter('network_site_url', array(&$this, 'aiowps_site_url'), 10, 2);
        add_filter('wp_redirect', array(&$this, 'aiowps_wp_redirect'), 10, 2);
        remove_action('template_redirect', 'wp_redirect_admin_locations', 1000); //To prevent redirect to login page when people type "login" at end of home URL
        
    }
    
    function aiowps_login_init() 
    {
        if (strpos($_SERVER['REQUEST_URI'], 'wp-login') !== false){
            $referer = wp_get_referer();
            if($referer && strpos($referer, 'wp-activate.php') !== false){
                $parsed_referer = parse_url($referer);
                if($parsed_referer && !empty($parsed_referer['query'])){
                    parse_str($parsed_referer['query'], $referer);
                    if (!empty($parsed_referer['key'])){
                        $result = wpmu_activate_signup($parsed_referer['key']); //MS site creation
                        if($result && is_wp_error($result) && ($result->get_error_code() === 'already_active' || $result->get_error_code() === 'blog_taken')){
                            $aiowps_new_login_url = AIOWPSecurity_Process_Renamed_Login_Page::new_login_url();
                            wp_safe_redirect($aiowps_new_login_url . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
                            die;
                        }
                    }
                }                
            }
            AIOWPSecurity_Process_Renamed_Login_Page::aiowps_set_404();
        }

    }
    
    function aiowps_site_url($url, $path) 
    {
        return $this->aiowps_filter_wp_login_file($url);
    }

    function aiowps_wp_redirect($location, $status)
    {
        return $this->aiowps_filter_wp_login_file($location);
    }

    //Filter all login url strings on the login page
    function aiowps_filter_wp_login_file($url)
    {
        if (strpos($url, 'wp-login.php') !== false){
            $args = explode( '?', $url );
            if (isset($args[1])){
                parse_str($args[1], $args);
                $url = add_query_arg($args, AIOWPSecurity_Process_Renamed_Login_Page::new_login_url());
            }else{
                $url = AIOWPSecurity_Process_Renamed_Login_Page::new_login_url();
            }
        }
        return $url;
    }
    
    static function renamed_login_init_tasks()
    {
        global $aio_wp_security;
        if (is_admin() && !is_user_logged_in() && !defined('DOING_AJAX')){
            wp_die( __( 'Please log in to access the WordPress admin area.', 'aiowpsecurity') );
        }
        
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $login_slug = $aio_wp_security->configs->get_value('aiowps_login_page_slug');
        if(untrailingslashit($parsed_url['path']) === home_url($login_slug, 'relative')
                || (!get_option('permalink_structure') && isset($_GET[$login_slug]))){
            status_header( 200 );
            require_once(AIO_WP_SECURITY_PATH . '/other-includes/wp-security-rename-login-feature.php' );
            die;
        }        
    }
    
    static function new_login_url()
    {
        global $aio_wp_security;
        $login_slug = $aio_wp_security->configs->get_value('aiowps_login_page_slug');
        if(get_option('permalink_structure')){
            return trailingslashit(trailingslashit(home_url()) . $login_slug);
        }else{
            return trailingslashit(home_url()) . '?' . $login_slug;
        }
    }

    static function aiowps_set_404() 
    {
        global $wp_query;
        status_header(404);
        $wp_query->set_404();
        if ((($template = get_404_template()) || ($template = get_index_template()))
            && ($template = apply_filters('template_include', $template))){
            include($template);
        }
        die;
    }
    
}