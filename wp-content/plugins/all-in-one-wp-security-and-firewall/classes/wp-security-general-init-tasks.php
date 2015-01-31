<?php

class AIOWPSecurity_General_Init_Tasks
{
    function __construct(){
        global $aio_wp_security;
        
        if($aio_wp_security->configs->get_value('aiowps_remove_wp_generator_meta_info') == '1'){
            add_filter('the_generator', array(&$this,'remove_wp_generator_meta_info'));
        }
        
        //For the cookie based brute force prevention feature
        $bfcf_secret_word = $aio_wp_security->configs->get_value('aiowps_brute_force_secret_word');
        if(isset($_GET[$bfcf_secret_word])){
            //If URL contains secret word in query param then set cookie and then redirect to the login page
            AIOWPSecurity_Utility::set_cookie_value($bfcf_secret_word, "1");
            AIOWPSecurity_Utility::redirect_to_url(AIOWPSEC_WP_URL."/wp-admin");
        }
        
        //For user unlock request feature
        if(isset($_POST['aiowps_unlock_request']) || isset($_POST['aiowps_wp_submit_unlock_request'])){
            nocache_headers();            
            remove_action('wp_head','head_addons',7);
            include_once(AIO_WP_SECURITY_PATH.'/other-includes/wp-security-unlock-request.php');
            exit();
        }
        
        if(isset($_GET['aiowps_auth_key'])){
            //If URL contains unlock key in query param then process the request
            $unlock_key = strip_tags($_GET['aiowps_auth_key']);
            AIOWPSecurity_User_Login::process_unlock_request($unlock_key);
        }
               
        //For 404 IP lockout feature
        if($aio_wp_security->configs->get_value('aiowps_enable_404_IP_lockout') == '1'){
            if (!is_user_logged_in() || !current_user_can('administrator')) {
                $this->do_404_lockout_tasks();
            }
        }

        //For login captcha feature
        if($aio_wp_security->configs->get_value('aiowps_enable_login_captcha') == '1'){
            if (!is_user_logged_in()) {
                add_action('login_form', array(&$this, 'insert_captcha_question_form'));
            }
        }

        //For lost password captcha feature
        if($aio_wp_security->configs->get_value('aiowps_enable_lost_password_captcha') == '1'){
            if (!is_user_logged_in()) {
                add_action('lostpassword_form', array(&$this, 'insert_captcha_question_form'));
                add_action('lostpassword_post', array(&$this, 'process_lost_password_form_post'));
            }
        }

        //For registration page captcha feature
        if($aio_wp_security->configs->get_value('aiowps_enable_registration_page_captcha') == '1'){
            if (!is_user_logged_in()) {
                add_action('register_form', array(&$this, 'insert_captcha_question_form'));
            }
        }

        //For comment captcha feature
        if (AIOWPSecurity_Utility::is_multisite_install()){
            $blog_id = get_current_blog_id();
            switch_to_blog($blog_id);
            if($aio_wp_security->configs->get_value('aiowps_enable_comment_captcha') == '1'){
                add_action( 'comment_form_after_fields', array(&$this, 'insert_captcha_question_form'), 1 );
                add_action( 'comment_form_logged_in_after', array(&$this, 'insert_captcha_question_form'), 1 );
                add_filter( 'preprocess_comment', array(&$this, 'process_comment_post') );
            }
            restore_current_blog();
        }else{
            if($aio_wp_security->configs->get_value('aiowps_enable_comment_captcha') == '1'){
                add_action( 'comment_form_after_fields', array(&$this, 'insert_captcha_question_form'), 1 );
                add_action( 'comment_form_logged_in_after', array(&$this, 'insert_captcha_question_form'), 1 );
                add_filter( 'preprocess_comment', array(&$this, 'process_comment_post') );
            }
        }
        
        //For feature which displays logged in users
        $this->update_logged_in_user_transient();
        
        //For block fake googlebots feature
        if($aio_wp_security->configs->get_value('aiowps_enable_block_fake_googlebots') == '1'){
            include_once(AIO_WP_SECURITY_PATH.'/classes/wp-security-bot-protection.php');
            AIOWPSecurity_Fake_Bot_Protection::block_fake_googlebots();
        }
        
        //For 404 event logging
        if($aio_wp_security->configs->get_value('aiowps_enable_404_logging') == '1'){
            add_action('wp_head', array(&$this, 'check_404_event'));
        }
        
        //Add more tasks that need to be executed at init time
        
    }
    
    function remove_wp_generator_meta_info()
    {
        return '';
    }

    function do_404_lockout_tasks(){
        global $aio_wp_security;
        $redirect_url = $aio_wp_security->configs->get_value('aiowps_404_lock_redirect_url'); //This is the redirect URL for blocked users
        
        $visitor_ip = AIOWPSecurity_Utility_IP::get_user_ip_address();
        
        $is_locked = AIOWPSecurity_Utility::check_locked_ip($visitor_ip);
        
        if($is_locked){
            //redirect blocked user to configured URL
            AIOWPSecurity_Utility::redirect_to_url($redirect_url);
        }else{
            //allow through
        }
    }

    function update_logged_in_user_transient(){
        if(is_user_logged_in()){
            $current_user_ip = AIOWPSecurity_Utility_IP::get_user_ip_address();
            // get the logged in users list from transients entry
            $logged_in_users = (AIOWPSecurity_Utility::is_multisite_install() ? get_site_transient('users_online') : get_transient('users_online'));
//            $logged_in_users = get_transient('users_online');
            $current_user = wp_get_current_user();
            $current_user = $current_user->ID;  
            $current_time = current_time('timestamp');

            $current_user_info = array("user_id" => $current_user, "last_activity" => $current_time, "ip_address" => $current_user_ip); //We will store last activity time and ip address in transient entry

            if($logged_in_users === false || $logged_in_users == NULL){
                $logged_in_users = array();
                $logged_in_users[] = $current_user_info;
                AIOWPSecurity_Utility::is_multisite_install() ? set_site_transient('users_online', $logged_in_users, 30 * 60) : set_transient('users_online', $logged_in_users, 30 * 60);
//                set_transient('users_online', $logged_in_users, 30 * 60); //Set transient with the data obtained above and also set the expire to 30min
            }
            else
            {
                $key = 0;
                $do_nothing = false;
                $update_existing = false;
                $item_index = 0;
                foreach ($logged_in_users as $value)
                {
                    if($value['user_id'] == $current_user && strcmp($value['ip_address'], $current_user_ip) == 0)
                    {
                        if ($value['last_activity'] < ($current_time - (15 * 60)))
                        {
                            $update_existing = true;
                            $item_index = $key;
                            break;
                        }else{
                            $do_nothing = true;
                            break;
                        }
                    }
                    $key++;
                }

                if($update_existing)
                {
                    //Update transient if the last activity was less than 15 min ago for this user
                    $logged_in_users[$item_index] = $current_user_info;
                    AIOWPSecurity_Utility::is_multisite_install() ? set_site_transient('users_online', $logged_in_users, 30 * 60) : set_transient('users_online', $logged_in_users, 30 * 60);
                }else if($do_nothing){
                    //Do nothing
                }else{
                    $logged_in_users[] = $current_user_info;
                    AIOWPSecurity_Utility::is_multisite_install() ? set_site_transient('users_online', $logged_in_users, 30 * 60) : set_transient('users_online', $logged_in_users, 30 * 60);
                }
            }
        }
    }
    
    function insert_captcha_question_form(){
        global $aio_wp_security;
        $aio_wp_security->captcha_obj->display_captcha_form();
    }
    
    function process_comment_post( $comment ) 
    {
        global $aio_wp_security;
        if (is_user_logged_in()) {
                return $comment;
        }

        //Don't process captcha for comment replies inside admin menu
        if (isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'replyto-comment' &&
        (check_ajax_referer('replyto-comment', '_ajax_nonce', false) || check_ajax_referer('replyto-comment', '_ajax_nonce-replyto-comment', false))) {
            return $comment;
        }

        //Don't do captcha for pingback/trackback
        if ($comment['comment_type'] != '' && $comment['comment_type'] != 'comment') {
            return $comment;
        }

        if (isset($_REQUEST['aiowps-captcha-answer']))
        {
            // If answer is empty
            if ($_REQUEST['aiowps-captcha-answer'] == ''){
                wp_die( __('Please enter an answer in the CAPTCHA field.', 'aiowpsecurity' ) );
            }
            $captcha_answer = trim($_REQUEST['aiowps-captcha-answer']);
            $captcha_secret_string = $aio_wp_security->configs->get_value('aiowps_captcha_secret_key');
            $submitted_encoded_string = base64_encode($_POST['aiowps-captcha-temp-string'].$captcha_secret_string.$captcha_answer);
            if ($_REQUEST['aiowps-captcha-string-info'] === $submitted_encoded_string){
                //Correct answer given
                return($comment);
            }else{
                //Wrong answer
                wp_die( __('Error: You entered an incorrect CAPTCHA answer. Please go back and try again.', 'aiowpsecurity'));
            }
        }
    }
    
    function process_lost_password_form_post() 
    {
        global $aio_wp_security;
        //Check if captcha enabled
        if ($aio_wp_security->configs->get_value('aiowps_enable_lost_password_captcha') == '1')
        {
            if (array_key_exists('aiowps-captcha-answer', $_POST)) //If the lost pass form with captcha was submitted then do some processing
            {
                isset($_POST['aiowps-captcha-answer'])?($captcha_answer = strip_tags(trim($_POST['aiowps-captcha-answer']))):($captcha_answer = '');
                $captcha_secret_string = $aio_wp_security->configs->get_value('aiowps_captcha_secret_key');
                $submitted_encoded_string = base64_encode($_POST['aiowps-captcha-temp-string'].$captcha_secret_string.$captcha_answer);
                if($submitted_encoded_string !== $_POST['aiowps-captcha-string-info'])
                {
                    add_filter('allow_password_reset', array(&$this, 'add_lostpassword_captcha_error_msg'));
                }
            }
        }
        
    }
    
    function add_lostpassword_captcha_error_msg()
    {
        //Insert an error just before the password reset process kicks in
        return new WP_Error('aiowps_captcha_error',__('<strong>ERROR</strong>: Your answer was incorrect - please try again.', 'aiowpsecurity'));
    }
    
    function check_404_event()
    {
        if(is_404()){
            //This means a 404 event has occurred - let's log it!
            AIOWPSecurity_Utility::event_logger('404');
        }
        
    }
    
}