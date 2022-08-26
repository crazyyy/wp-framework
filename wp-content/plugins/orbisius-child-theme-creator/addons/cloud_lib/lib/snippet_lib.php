<?php

define('ORBISIUS_CHILD_THEME_CREATOR_EXT_CLOUD_LIB_MAX_ITEMS', 25);

/**
 * Autocomplete
 * Search for a snippet
 * Add a snippet
 * 
 */
class orbisius_ctc_cloud_lib {
    /**
     * @var string	Url of remote API. The plugin will dynamically pick one
     */
    public $api_url	= '';
    public $live_api_url = 'https://orbisius.com/cloud-lib/';
//    public $dev_api_url	= 'http://orb-ctc.qsandbox.com/';
    public $dev_api_url	= 'http://orbclub.com.clients.com/';
    public $staging_api_url = 'http://orb-ctc.qsandbox.com/';
    private $tabs = array();

    public function __construct() {
        if ( !empty( $_SERVER['DEV_ENV'])) {
            $this->api_url = $this->dev_api_url;
        } elseif ( !empty($_SERVER['HTTP_HOST'])
                && 1) { // (stripos($_SERVER['HTTP_HOST'], '.clients.com') !== false)
            $this->api_url = $this->staging_api_url;
        } elseif ( !empty($_SERVER['HTTP_HOST'])
                && (stripos($_SERVER['HTTP_HOST'], '.qsandbox.com') !== false)) {
            $this->api_url = $this->staging_api_url;
        } else {
            $this->api_url = $this->live_api_url;
        }
//$this->api_url = $this->live_api_url; // on dev
        // We need to initialize the tabs here because we're using __ method
        // for future internationalization.
        $tabs = array(
            array(
                'id' => 'orb_ctc_ext_cloud_lib_manage',
                'label' => __( 'Manage', 'orbisius-child-theme-creator' ),
            ),
            // Turning off the search for now. The users will use manage tab instead.
//           array(
//                'id' => 'orb_ctc_ext_cloud_lib_search',
//                'label' => __( 'Search', 'orbisius-child-theme-creator' ),
//            ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_add',
                'label' => __( 'Add', 'orbisius-child-theme-creator' ),
           ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_signup',
                'label' => __( 'Sign Up', 'orbisius-child-theme-creator' ),
           ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_login',
                'label' => __( 'Login', 'orbisius-child-theme-creator' ),
           ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_account',
                'label' => __( 'Account', 'orbisius-child-theme-creator' ),
           ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_contact',
                'label' => __( 'Contact', 'orbisius-child-theme-creator' ),
           ),
           array(
                'id' => 'orb_ctc_ext_cloud_lib_about',
                'label' => __( 'About', 'orbisius-child-theme-creator' ),
           ),            
        );
        
        $this->tabs = $tabs;
    }
    
    public function get_api_url() {
        return $this->api_url;
    }
    
    /**
     * Add snippet librabry actions
     */
    public function enqueue_assets() {
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script('jquery-ui-tabs');

        // We want to load the current jquiery_ui version's style.
        $current_jquiery_ui_ver = '1.12.1';

        if (function_exists('wp_scripts')) { // since WP 4.2
            $wp_scripts = wp_scripts();

            if (!empty($wp_scripts->registered['jquery-ui-core']->ver)) {
                $current_jquiery_ui_ver = $wp_scripts->registered['jquery-ui-core']->ver;
            }
        }

        wp_enqueue_style('orbisius_ctc_cloud_lib_jquery_ui',
            '//ajax.googleapis.com/ajax/libs/jqueryui/' . $current_jquiery_ui_ver . '/themes/smoothness/jquery-ui.min.css',
            false,
            $current_jquiery_ui_ver,
            false
        );

        wp_register_script( 'orbisius_ctc_cloud_lib', 
            apply_filters('orbisius_child_theme_creator_filter_asset_src', "/addons/cloud_lib/assets/custom.js" ), 
            array('jquery', ),
            apply_filters('orbisius_child_theme_creator_filter_asset_src', 
                "/addons/cloud_lib/assets/custom.js",
               array( 'last_mod' => 1) 
            ),
            true
        );
        wp_enqueue_script( 'orbisius_ctc_cloud_lib' );

        //Custom styles for snippet library
        wp_register_style('orbisius_ctc_cloud_lib', 
            apply_filters('orbisius_child_theme_creator_filter_asset_src', "/addons/cloud_lib/assets/custom.css" ), 
            null,
            apply_filters('orbisius_child_theme_creator_filter_asset_src', 
                "/addons/cloud_lib/assets/custom.css",
               array( 'last_mod' => 1 ) 
            ), 
            false
        );
        wp_enqueue_style('orbisius_ctc_cloud_lib');
    }
    
    /**
     * Add snippet librabry actions
     */
    public function admin_init() {
        add_action( 'orbisius_child_theme_creator_admin_enqueue_scripts',array($this, 'enqueue_assets' ) );
        
         // Snippet search ajax hook
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_signup',array($this, 'process_signup' ) );
//        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_signup',array($this, 'process_signup' ) );
        
         // Log in
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_login',array($this, 'process_login' ) );
//        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_login',array($this, 'process_login' ) );
        
         // Log out
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_log_out',array($this, 'process_log_out' ) );
        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_log_out',array($this, 'process_log_out' ) );
        
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_autocomplete',array($this, 'cloud_autocomplete' ) );
//        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_autocomplete',array($this, 'cloud_autocomplete' ) );
        
        // Snippet search ajax hook
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_search',array($this, 'cloud_search' ) );
//        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_search',array($this, 'cloud_search' ) );
        
        // Update a Snippet ajax hook
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_cloud_update',array($this, 'cloud_update' ) );
//        add_action( 'wp_ajax_nopriv_cloud_update',array($this, 'cloud_update' ) );
        
        // Delete a Snippet ajax hook
        add_action( 'wp_ajax_orb_ctc_addon_cloud_lib_delete',array($this, 'cloud_delete' ) );
//        add_action( 'wp_ajax_nopriv_orb_ctc_addon_cloud_lib_delete',array($this, 'cloud_delete' ) );
//        
        add_action( 'orbisius_child_theme_creator_addon_cloud_lib_action_auth_success',array($this, 'process_successful_auth' ) );
    }

    /**
     * Makes a request to API and get response
     * @return JSON array	response from the api
     */
    public function call($url, $req_params = array()) {
        // Prepend user's api key if any.
        if (empty($req_params['orb_cloud_lib_data']['api_key'])) {
            $user_api = orbisius_child_theme_creator_user::get_instance();
            $api_key = $user_api->api_key();
            
            if (!empty($api_key)) {
                $req_params['orb_cloud_lib_data']['api_key'] = $api_key;
            }
        }
        
        $res = new orbisius_child_theme_creator_result();
        
        $wp_req_params =array(
            'method' => 'POST',
            'timeout' => 20,
            'redirection' => 5,
            'blocking' => true,
            'sslverify' => false,
            //'sslverify' => false,
            'body' => $req_params,
        );
        
        $response = wp_remote_post($url, $wp_req_params);
        
        if ( is_wp_error( $response ) ) {
           $res->msg( $response->get_error_message() );
        } else {
            $json_str = wp_remote_retrieve_body($response);
            $api_res = new orbisius_child_theme_creator_result($json_str);
            $res->status(1); // current connection is OK.
            $res->data('result', $api_res);  // this is what API said. This could be status:0
        }

        return $res;
    }

    /**
     * Signs up the user.
     */
    public function process_login() {
        $pass = orbisius_child_theme_creator_get('orb_ctc_pass');
        $email = orbisius_child_theme_creator_get('orb_ctc_email');
        
        $params =array(
            'orb_cloud_lib_data' => array(
                'cmd' => 'user.login',
                'pass' => $pass,
                'email' => $email,
            )
        );

        $req_res = $this->call($this->api_url, $params);

        if ($req_res->is_success()) {
            $api_res = $req_res->data('result');

            $ctx = array(
                'api_res' => $api_res,
            );
            
            if ($api_res->is_success()) {
                do_action('orbisius_child_theme_creator_addon_cloud_lib_action_auth_success', $ctx);
            } else {
                do_action('orbisius_child_theme_creator_addon_cloud_lib_action_auth_error', $ctx);
            }
        }
        
        wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
    }

    /**
     * This is called after login and register to update some meta info about plan & api key
     * @param array $ctx
     */
    public function process_successful_auth($ctx) {
        $api_res = $ctx['api_res'];
        $user_api = orbisius_child_theme_creator_user::get_instance();

        $api_key = $api_res->data('api_key');

        if (!empty($api_key)) {
            $user_api->api_key($api_key);
        }

        $email = $api_res->data('email');

        if ( !empty($email)) {
            $user_api->email($email);
        }
        
        $plan_data = $api_res->data('plan_data');
        
        if (!empty($plan_data)) {
            $plan_data = $user_api->plan($plan_data);
        }
    }
    
    /**
     * Deletes the api key saved in the current user's meta
     */
    public function process_log_out() {
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $user_api->clear_account_data();

        $req_res = new orbisius_child_theme_creator_result();
        $req_res->status(1);
        $req_res->data('result', new orbisius_child_theme_creator_result(1));
        
        wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
    }

    /**
     * Signs up the user.
     */
    public function process_signup() {
        $pass = orbisius_child_theme_creator_get('orb_ctc_pass');
        $email = orbisius_child_theme_creator_get('orb_ctc_email');
        
        $params = array(
            'orb_cloud_lib_data' => array(
                'cmd' => 'user.register',
                'pass' => $pass,
                'email' => $email,
            )
        );

        $req_res = $this->call($this->api_url, $params);
        
        if ($req_res->is_success()) {
            $api_res = $req_res->data('result');

            $ctx = array(
                'api_res' => $api_res,
            );
            
            if ($api_res->is_success()) {
                do_action('orbisius_child_theme_creator_addon_cloud_lib_action_auth_success', $ctx);
            } else {
                do_action('orbisius_child_theme_creator_addon_cloud_lib_action_auth_error', $ctx);
            }
        }
        
        wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
    }

    /**
     * Gets autocomplete suggestions from API based on data sent to the API
     * @return	JSON API's response
     */
    public function cloud_autocomplete() {
        if (!empty($_REQUEST['term'])) {
            $search_for = sanitize_text_field($_REQUEST['term']);
            
            $params = array(
                'orb_cloud_lib_data' => array(
                    'cmd' => 'item.list',
                    'query' => $search_for,
                )
            );

            $req_res = $this->call($this->api_url, $params);
            wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
        }
    }

    /**
     * Sends search request to API
     *@return	JSON API's response
    */
    public function cloud_search() {
        if (!empty($_REQUEST['search'])) {
            $search_for	= sanitize_text_field($_REQUEST['search']);

            $params = array(
                'orb_cloud_lib_data' => array(
                    'cmd' => 'item.list',
                    'query' => $search_for,
                )
            );

            $req_res = $this->call($this->api_url, $params);
            wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
        }
    }

    /**
     * Updates a snippet by ID
     * MUST send an ID to the API
     * @return	JSON array with API's response
     */
    public function cloud_update() {
        $snippet_id = (int) orbisius_child_theme_creator_get('id');
        $snippet_title = orbisius_child_theme_creator_get('title');
        $snippet_text = orbisius_child_theme_creator_get('text');

        $params = array(
            'orb_cloud_lib_data' => array(
                'cmd' => $snippet_id ? 'item.update' : 'item.add',
                'id' => $snippet_id,
                'title' => $snippet_title,
                'content' => $snippet_text,
            )
        );

        $req_res = $this->call($this->api_url, $params);
        wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res->to_array());
    }

    /**
     * Deletes snippet by id
     * 
     * MUST send an ID to the API
     */
    public function cloud_delete() {
    	if (!empty($_REQUEST['id'])) {
            $id	= sanitize_text_field($_REQUEST['id']);
            $params = array(
                'orb_cloud_lib_data' => array(
                    'cmd' => 'item.delete',
                    'id' => $id,
                )
            );

            $req_res = $this->call($this->api_url, $params);
            wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res);
    	}
    }

    /**
     * 
     * @return string
     */
    public function get_current_tab_id() {
        // $this->tabs[0]['id']
        $cur_tab_id = empty($_REQUEST['tab']) ? '' : wp_kses( $_REQUEST['tab'], array() );
 
        if (empty($cur_tab_id)) {
            $user_api = orbisius_child_theme_creator_user::get_instance();
            $api_key = $user_api->api_key();
            
            if (empty($api_key)) {
                $cur_tab_id = 'orb_ctc_ext_cloud_lib_about';
            } else {
                $cur_tab_id = 'orb_ctc_ext_cloud_lib_manage';
            }
        }
        
        return $cur_tab_id;
    }
    
    /**
     * 
     */
    public function render_tabs() {
        $url = admin_url( 'themes.php?page=orbisius_child_theme_creator_theme_editor_action' );
        $cur_tab_id = $this->get_current_tab_id();
        ?>
        <div id="orb_ctc_addon_cloud_lib_tabs" class="orb_ctc_addon_cloud_lib_tabs">
             <div class="nav-tab-wrapper"> 
                <ul>
                    <?php foreach ( $this->tabs as $tab_rec ) : ?>
                        <?php
                        if (!$this->should_render_tab($tab_rec)) {
                            continue;
                        }
                        
                        $tab_url = add_query_arg( 'tab', $tab_rec['id'], $url );
                        $extra_tab_css = $tab_rec['id'] == $cur_tab_id ? 'ui-state-default ui-tabs-active' : ''; // nav-tab-active 
                        ?>
                        <li class="nav-tab2 <?php echo $extra_tab_css;?>"><a href="<?php echo '#' . $tab_rec['id']; ?>"><?php echo $tab_rec['label'];?></a></li>
                    <?php endforeach; ?>
                </ul>
             </div>
        <?php
    }
    
    /**
     * 
     * @param str $tab_id
     */    
    public function render_tab_content( $tab_id = '' ) {
    	$tab_id = empty($tab_id) ? $this->get_current_tab_id() : $tab_id; 
        
        $method_name = 'render_tab_content_' . $tab_id;
        
        if (method_exists( $this, $method_name)) {
            $this->$method_name();
        } else {
            echo "<!-- OCTC:Error: Invalid tab method. -->";
        }
    }
    
    public function render_tab_content_orb_ctc_ext_cloud_lib_search() {
        ?>
        <!-- Search Snippets -->
        <div id="orb_ctc_ext_cloud_lib_search" class="tabcontent orb_ctc_ext_cloud_lib_search">
            <span class="descr">Start typing the title of your snippet to see suggestions</span>
            <br />
            <input class="selector" id="search_text"></input>
            <input class="button button-primary" type="button" id="snippet_search_btn" value="Search" />

            <div class="found_snippet app_hide">
                <span class="label">Title:</span>
                <input class="widefat" type="text" id="found_snippet_title"></textarea>
                <br />
                <span class="label">Snippet:</span>
                <textarea class="widefat" id="found_snippet_text"></textarea>
            </div>
        </div>
        
        <!-- /Search Snippets -->
        <?php
    }
    
    /**
     * 
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_add() {
        ?>
        <!-- New Snippet --> 
        <div id="orb_ctc_ext_cloud_lib_add" class="tabcontent orb_ctc_ext_cloud_lib_add">
            <div id="new_snippet_wrapper" class="new_snippet_wrapper">
                <form method="POST" id="orb_ctc_ext_cloud_lib_add_new_snippet_form" class="orb_ctc_ext_cloud_lib_add_new_snippet_form">
                    Title/label<br/>
                    <input type="text" id="add_snippet_title" 
                           required=""
                           class="add_snippet_title widefat" 
                           autocomplete="off"
                           value=""
                           placeholder="Title" />
                    <br /><br />
                    Code/license key/content<br/>
                    <textarea id="add_snippet_text" class="widefat add_snippet_text" 
                              required="" placeholder="Snippet content"></textarea>
                    <br /><br />
                    <input type="submit" id="snippet_save_btn" 
                           class="button button-primary snippet_save_btn" value="Save Changes" /> 
                </form>
                
                <div class="result"></div>
            </div>
            <!-- /New Snippet -->

            <!-- Confirm dialog save snippet -->
            <div id="snippet_confirm_dialog" title="" class="snippet_confirm_dialog app_hide">
                <p>Are you sure you want to save a snippet without any content?</p>
            </div>
            <!-- /Confirm dialog save snippet -->
        </div>
        <?php
    }
    
    /**
     * Manage snippets tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_manage() {
         $all_snippets = $this->get_user_snippets();
         
         ?>
         <div id="orb_ctc_ext_cloud_lib_manage" class="tabcontent orb_ctc_ext_cloud_lib_manage">
         <!-- Manage snippets -->
         <div class="manage_snippets">
            <!--<h3>My Snippets</h3>-->
            <div class="manage_snippets_table_wrapper">
                <table id="manage_snippets_table" class="widefat manage_snippets_table">
                    <?php
                    $no_items_css = '';
                    
                    if (empty($all_snippets)) {
                        $all_snippets = array();
                    } else {
                        $no_items_css = 'app_hide'; 
                    }
                    
                    // We prepend a blan row which will be hidden if the ID is 0.
                    // It will used when adding a new item. The row will be cloned.
                    $all_snippets = array_merge( array( $this->get_blank_snippet() ), $all_snippets);
                    ?>
                    
                    <tr id="no_snippets_row" class="no_snippets_row no_snippets_alert <?php echo $no_items_css;?>">
                        <td colspan="2">
                            <span id="no_snippets_alert">You don't haven any snippets.</span>
                        </td>
                    </tr>

                    <?php foreach( $all_snippets as $idx => $rec) : ?>
                       <tr id="snippet_<?php echo esc_attr($rec['id']); ?>"
                            class="hover_row snippet_row snippet_row_<?php echo esc_attr($rec['id']); ?> 
                            <?php echo $idx % 2 == 1 ? 'alt_row' : ''; ?>
                                <?php echo empty($rec['id']) ? 'app_hide' :''; ?>"
                            data-id="<?php echo esc_attr($rec['id']); ?>">
                          <td id="td_title" class="title_cell">
                              <div class="snippet_title truncate">
                                  <?php echo esc_attr($rec['title']); ?>
                              </div>
                              <div id="snippet_content_<?php echo esc_attr($rec['id']);?>"
                                    class="truncate snippet_content snippet_content_<?php echo esc_attr($rec['id']);?>"><?php 
                                    echo esc_attr($rec['content']); 
                              ?></div>
                          </td>
                          <td class="cmd_row">
                              <button class="button orb_ctc_copy_btn" 
                                      data-clipboard-action="copy"
                                      data-clipboard-target="#snippet_content_<?php echo esc_attr($rec['id']);?>"
                                >Copy</button>
                              <input class="button snippet_edit_view_btn" type="button" value="Edit">
                              <input class="button snippet_delete_btn" type="button" value="X">
                          </td>
                       </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div id="orb_ctc_ext_cloud_lib_edit" class="tabcontent orb_ctc_ext_cloud_lib_edit">
                <div id="edit_snippet_wrapper" class="edit_snippet_wrapper">
                    <form method="POST" id="orb_ctc_ext_cloud_lib_edit_snippet_form" class="orb_ctc_ext_cloud_lib_edit_snippet_form">
                        <!-- Edit snippet window -->
                        <div id="edit_snippet" class="edit_snippet app_hide" title="Edit Snippet">
                            <input type="hidden" id="edit_id" class="edit_id" name="id" value="0"/>
                            <input type="text" id="edit_title" class="edit_title" name="title" autocomplete="off" />
                            <br />
                            <textarea id="edit_content" class="edit_content" name="content"></textarea>
                            <br />
                            <br />
                        </div>
                     </form>
                </div>
            </div>
             <!-- /Edit snippet window -->

            <!-- View snippet window -->
            <div id="view_snippet" class="view_snippet app_hide">
                <h3>View Snippet</h3>
                <input class="view_title">
                <br />
                <textarea class="view_content"></textarea>
                <br />
                <br />
               <!-- /View snippet window -->
            </div>
            <!-- /View snippet window -->
        </div>
        <!-- /Manage snippets -->  
         
         <!-- Delete snippet confirm dialog -->
         <div id="snippet_confirm_dialog_delete" class="snippet_confirm_dialog_delete app_hide" title="Delete">
            <p>Are you sure you want to delete this snippet with title <span class="delete_snippet_title"></span>?</p>
        </div>
        <!-- /Delete snippet confirm dialog -->
        </div>
         <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_signup() {
        ?>
         <div id="orb_ctc_ext_cloud_lib_signup" class="tabcontent">
            <div id="orb_ctc_ext_cloud_lib_signup_wrapper" class="orb_ctc_ext_cloud_lib_signup_wrapper">
                <!--<h3>Sign Up</h3>-->
                <div class="">
                    <form name="orb_ctc_signup_form" id="orb_ctc_signup_form" class="orb_ctc_signup_form" method="post">
                        <p>
                            <label for="orb_ctc_email">Email Address<br />
                                <input type="email" name="orb_ctc_email" id="orb_ctc_email" class="input orb_ctc_email" value="" size="42" required="" /></label>
                        </p>
                        <p>
                            <label for="orb_ctc_pass">Password<br />
                                <input type="password" name="orb_ctc_pass" id="orb_ctc_pass" 
                                       class="input orb_ctc_pass" value="" size="42" required="" /></label>
                        </p>
                        <p>
                            <label for="orb_ctc_pass">Password (repeat)<br />
                                <input type="password" name="orb_ctc_pass2" id="orb_ctc_pass2"
                                       class="input orb_ctc_pass2" value="" size="42" required="" /></label>
                        </p>
                        <p class="submit">
                            <input type="submit" name="orb_ctc_signup_submit" id="orb_ctc_signup_submit"
                                   class="button button-primary button-large" value="Sign Up" />
                        </p>
                    </form>
                    
                    <div class="result">

                    </div>
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_signup_wrapper -->  
        </div>
        <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_login() {
        ?>
         <div id="orb_ctc_ext_cloud_lib_login" class="tabcontent">
            <div id="orb_ctc_ext_cloud_lib_login_wrapper" class="orb_ctc_ext_cloud_lib_login_wrapper">
                <!--<h3>Log in</h3>-->
                <div class="">
                    <form name="orb_ctc_login_form" id="orb_ctc_login_form" class="orb_ctc_login_form" method="post">
                        <p>
                            <label for="orb_ctc_login_email">Email Address<br />
                                <input type="email" name="orb_ctc_email" id="orb_ctc_login_email" class="input" value="" size="42" required="" /></label>
                        </p>
                        <p>
                            <label for="orb_ctc_login_pass">Password<br />
                                <input type="password" name="orb_ctc_pass" id="orb_ctc_login_pass" 
                                       class="input" value="" size="42" required="" /></label>
                        </p>
                        <p class="submit">
                            <input type="submit" name="orb_ctc_login_submit" id="orb_ctc_login_submit"
                                   class="button button-primary button-large" value="Log in" />
                        </p>
                    </form>
                    
                    <div class="result">

                    </div>
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_login_wrapper -->  
        </div>
        <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_account() {
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $email = $user_api->email();
        $api_key = '';
        
        if (isset($_REQUEST['load_orb_cloud_api_key'])) {
            $api_key = $user_api->api_key();
        }
        $plan_data = $user_api->plan();
        
        ?>
         <div id="orb_ctc_ext_cloud_lib_account" class="tabcontent orb_ctc_ext_cloud_lib_account">
            <div class="orb_ctc_ext_cloud_lib_account_wrapper">
                <!--<h3>Account</h3>-->
                <div class="email_wrapper">
                    Email: <?php echo $email; ?>
                </div>
                
                <?php if (0&&!empty($api_key)) : ?>
                <div class="api_key_wrapper">
                    Orbisius API Key: <?php echo $api_key; ?>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($plan_data)) : ?>
                <div class="api_orb_plan">
                    <?php foreach ($plan_data as $key => $value) {
                        $val_fmt = $value;
                        
                        if ($key == 'price') {
                            $val_fmt = $value <= 0 ? 'Free plan' : $value;
                        }
                        
                        if ($key == 'max_items') {
                            $val_fmt = $this->get_max_snippets();
                        }
                        
                        $key_fmt = preg_replace('#[\-\_]+#si',  ' ', $key);
                        $key_fmt = ucwords($key_fmt);
                        echo esc_attr($key_fmt) . ": <span id='$key' class='$key'>" . esc_attr($val_fmt) . "</span><br />\n";
                    }
                    ?>
                    Orbisius API URL (system): <?php echo $this->get_api_url(); ?>
                </div> <!-- /api_orb_plan -->
                <?php endif; ?>

                <hr/>
                <div class="api_orb_pricing">
                    <a href="//orbisius.com/plans/?utm_source=ctc&utm_medium=cloud_lib" 
                       target="_blank" 
                       title="See plans [new window/tab]"
                       class="button button-primary">Upgrade / See plans</a>
                    |
                    <?php
                    
                    // This info is passed to the content link.
                    // See the title of the contact link so the user doesn't have to re-enter that info.
                    $e = array(
                        'site' => site_url(),
                        'email' => $email,
                        'api_key' => $api_key,
                    );
                    ?>
                    <a href="//orbisius.com/contact/quick-contact/?utm_source=ctc&utm_medium=cloud_lib&<?php echo http_build_query($e);?>" 
                       target="_blank" 
                       title="Contact us with a suggestion, bug report etc. This link includes your email, API key, site url so you don't have to enter it again to get support. [new window/tab]"
                       class="button">Contact Us</a>
                    |
                    <a href='#' id='orb_ctc_ext_cloud_lib_account_log_out' 
                       title="Logs you out and remove Orbisius cloud account data from ths WordPress installation."
                       class="button orb_ctc_ext_cloud_lib_account_log_out"> Log out</a>
                </div>
                
                <div class="result">
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_account_wrapper -->  
        </div>
        <?php
    }
    
    public function get_max_snippets() {
        return ORBISIUS_CHILD_THEME_CREATOR_EXT_CLOUD_LIB_MAX_ITEMS;
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_about() {
         ?>
         <div id="orb_ctc_ext_cloud_lib_about" class="tabcontent">
            <div class="orb_ctc_ext_cloud_lib_about_wrapper">
                <!--<h3>About</h3>-->
                <div class="">
                    Orbisius Cloud library enables you to store your snippets, license keys etc in the Orbisius Cloud Library.
                    You can access those snippets from other WordPress installations.
                    With your free Orbisius account and you can store up to 
                        <?php echo $this->get_max_snippets();?> snippets for free.
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_about_wrapper -->  
        </div>
         <?php
    }
    
    /**
     * Contact tab view
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_contact() {
        $e = array(
            'tab' => 'contact',
        );
        ?>
         <div id="orb_ctc_ext_cloud_lib_contact" class="tabcontent">
            <div class="orb_ctc_ext_cloud_lib_contact_wrapper">
                <!--<h3>About</h3>-->
                <div class="">
                    Please, report any glitches you may find. We'd really appreciate it.
                    <a href="//orbisius.com/contact/quick-contact/?utm_source=ctc&utm_medium=cloud_lib&<?php echo http_build_query($e);?>" 
                       target="_blank" 
                       title="Contact us with a suggestion, bug report etc. This link includes your email, API key, site url so you don't have to enter it again to get support. [new window/tab]"
                       class="button-primary">Contact Us</a>
                    
                    you can also email us at: <a href="mailto:help@orbisius.com?subject=ctc cloud lib feedback" class="">help@orbisius.com</a>
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_contact_wrapper -->  
        </div>
         <?php
    }
    
    /**
     * 
     * @return array
     */
    public function get_blank_snippet() {
        $arr = array(
            'id' => 0,
            'title' => '',
            'content' => '',
        );
        
        return $arr;
    }
    
    /**
     * Manage snippets tab
     * Displays all present snippets
     * 
     * @return array	decoded response from API
     */
    public function get_user_snippets() {
        $params = array(
            'orb_cloud_lib_data' => array(
                'cmd' => 'item.list',
            )
        );

        $req_res = $this->call($this->api_url, $params);
        $snippets = array();

        if ( $req_res->is_success() ) {
            $api_result = $req_res->data('result');
            $snippets = $api_result->data();
        }
        
        $snippets = empty($snippets) ? array() : $snippets;

        return $snippets;
    }
    
    /**
     * 
     * @param str $json_api_response
     * @return array
     */
    public function decode_response($json_api_response) {
        $def_res = new orbisius_child_theme_creator_result();
        $json = empty($json_api_response) || ! is_scalar($json_api_response)
                ? $def_res->to_array()
                : json_decode( $json_api_response, true );
        return $json;
    }
    
    /**
     * Performs some checks to decide which tabs to show when the user hasn't
     * joined Orbisius.
     * if the api key exists skip signup tab if it doesn't leave only about & signup tabs
     * @param array $tab_rec
     */
    public function should_render_tab($tab_rec = array()) {
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $api_key = $user_api->api_key();
        $render = 1;
        
        if (!empty($api_key)) {
            if (preg_match('#signup|login#si', $tab_rec['id'])) {
                $render = 0;
            }
        } else {
            if (!preg_match('#signup|login|about|contact#si', $tab_rec['id'])) {
                $render = 0;
            }
        }
        
        return $render;
    }
    
    /**
     * 
     * @param array $ctx
     */
    public function render_ui($ctx = array()) {
        $place = empty($ctx['place']) ? 'left' : $ctx['place'];
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $api_key = $user_api->api_key();
        ?>
        <br/>
        <br/>
        <div id="orb_cloud_lib_wrapper_<?php echo $place;?>" class="orb_cloud_lib_wrapper orb_cloud_lib_wrapper_<?php echo $place;?>">
            <div class="snippet_wrapper">
                <h3>Orbisius Cloud Library</h3>
                <?php $this->render_tabs(); ?>
                <?php
                    foreach ( $this->tabs as $tab_rec ) {
                        if (!$this->should_render_tab($tab_rec)) {
                            continue;
                        }
                        
                        $this->render_tab_content( $tab_rec['id'] );
                    }
                ?>
            </div>
        </div> <!-- /Snippet Library Wrapper -->
        <?php
    }
}