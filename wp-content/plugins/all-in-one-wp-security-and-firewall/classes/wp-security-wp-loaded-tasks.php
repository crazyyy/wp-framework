<?php

/*** This class handles tasks that need to be executed at wp-loaded time ***/
class AIOWPSecurity_WP_Loaded_Tasks {

    function __construct() {
        //Add tasks that need to be executed at wp-loaded time

        global $aio_wp_security;

        //Handle the rename login page feature
        if ($aio_wp_security->configs->get_value('aiowps_enable_rename_login_page') == '1') {
            include_once(AIO_WP_SECURITY_PATH . '/classes/wp-security-process-renamed-login-page.php');
            $login_object = new AIOWPSecurity_Process_Renamed_Login_Page();
            AIOWPSecurity_Process_Renamed_Login_Page::renamed_login_init_tasks();
        }
        
        //For site lockout feature (ie, maintenance mode). It needs to be checked after the rename login page
        if($aio_wp_security->configs->get_value('aiowps_site_lockout') == '1'){
            if (!is_user_logged_in() && !current_user_can('administrator') && !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ))) {
                $this->site_lockout_tasks();
            }
        }
        
    }
    
    function site_lockout_tasks(){
        nocache_headers();
        header("HTTP/1.0 503 Service Unavailable");
        remove_action('wp_head','head_addons',7);
        include_once(AIO_WP_SECURITY_PATH.'/other-includes/wp-security-visitor-lockout-page.php');
        exit();
    }
    

}