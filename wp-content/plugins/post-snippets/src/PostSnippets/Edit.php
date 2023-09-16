<?php

namespace PostSnippets;

/**
 * Add or Edit Post Snippets.
 *
 * Class that renders out the HTML for Edit/Add snippet page.
 *
 */
class Edit {

    private static $snippet_id = '';

    public static $editSnippetPage = false;

    protected $snippet_data;


    function __construct() {

        self::prepare();

        $this->save_data();

        $this->perform_actions_response();

        $this->setup_code_editor();

         $this->edit_snippets_meta_boxes();

        $this->setup_sections();

        $this->editPage();


    }

    public static function prepare(){

        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit' && isset($_REQUEST['snippet']) ){

            self::$snippet_id = intval($_REQUEST['snippet']);

            check_admin_referer( 'ps-snippets-hover-trigger_'.self::$snippet_id );

            global $wpdb;

            if( !$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix.\PostSnippets::TABLE_NAME." WHERE ID = %d", self::$snippet_id) ) ){

                self::$snippet_id = '';

                wp_safe_redirect( admin_url('admin.php?page=post-snippets' ) );

            }

            if( !empty(self::$snippet_id) ){
                self::$editSnippetPage = true;
            }

        }
    }

    public static function change_edit_snippet_page_title($admin_title, $title){


        self::prepare();

        if(self::$editSnippetPage){
            $admin_title = str_replace( __("Add New", "post-snippets"), __("Edit Snippet", "post-snippets"), $admin_title);
            return $admin_title;
        }

        return $admin_title;
    }

    function editPage(){


        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>

                <?php

                    $edit_page = '';

                    if( self::$editSnippetPage ){
                        $page = self::get_snippet_page();
                        if( $page == 'post-snippets-edit-js' ){
                            $edit_page = "JS ";
                        }
                        elseif( $page == 'post-snippets-edit-css' ){
                            $edit_page = "CSS ";
                        }
                        ?>
                            <h1 class="wp-heading-inline"><?php echo $edit_page; esc_html_e( 'Edit', 'post-snippets' ); ?> Snippet</h1>
                            <a href="<?php echo esc_url("?page=$page") ?>" class="page-title-action"><?php esc_html_e( 'Add New', 'post-snippets' ); ?></a>
                        <?php
                    }
                    else{
                        ?>
                            <h1 class="wp-heading-inline"><?php echo $edit_page; esc_html_e( 'Add', 'post-snippets' ); ?> Snippet</h1>
                        <?php
                    }

                ?>

                <hr class="wp-header-end">
                <form id="ps_edit_snippets" method="post">
                    <?php

                        wp_nonce_field( 'pspro_edit_snippet', 'pspro_edit_snippet_nonce', false );

                        // Pro

                        // wp_nonce_field('sync_up', 'sync_up');
                        // wp_nonce_field('sync_down', 'sync_down');

                        /* Used to save closed meta boxes and their order */
                        wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
                        wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );

                    ?>

                    <div id="poststuff">
                        <!-- #post-body .metabox-holder goes here -->
                        <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
                            <!-- meta box containers here -->
                            <div id="post-body-content">
                                <!-- #post-body-content -->
                                <?php $this->body_content_cb(); ?>
                            </div>

                            <div id="postbox-container-1" class="postbox-container">
                                <?php
                                        /**Add Meta Box to Side Bar */
                                        do_meta_boxes('','side',null);

                                ?>

                                <div class ="save-button-area">

                                        <?php

                                                submit_button(__('Save','post-snippets'));

                                        ?>

                                </div>

                            </div>

                            <div id="postbox-container-2" class="postbox-container">
                                <?php
                                    /**Add Full witdh meta-boxes to bottom of Fixed content */
                                    do_meta_boxes('','normal',null);
                                    // do_meta_boxes('','advanced',null);

                                ?>
                            </div>


                        </div>
                    </div>



                </form>

            </div><!--/wrap -->

        <?php

        if( isset($_REQUEST['message']) && $_REQUEST['message'] == 1 ){

            printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Added Successfully', 'post-snippets' ) );

        }
    }


    /**
	 * Prints the jQuery script to initiliase the metaboxes
	 * Called on admin_footer-*
	*/
	public static function footer_scripts(){
		?>
		<script> postboxes.add_postbox_toggles(pagenow);</script>
		<?php
	}

	/*
	* Actions to be taken prior to page loading. This is after headers have been set.
    * call on load-$hook
	* This calls the add_meta_boxes hooks, adds screen options and enqueues the postbox.js script.
	*/
	public static function page_actions(){

		/* User can choose between 1 or 2 columns (default 2) */
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );

		/* Enqueue WordPress' script for handling the metaboxes */
		wp_enqueue_script('postbox');
	}

    public static function edit_snippets_meta_boxes(){

        add_meta_box(
            'ps_action_meta_box', //Meta box ID
            __('Actions','post-snippets'), //Meta box Title
            array(\PostSnippets::EDIT_CLASS, 'actions_metabox_content'), //Callback defining the metabox's innards
            NULL, // Screen to which to add the meta box, blank means current screen
            'side' // Context
        );

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-js' || $_REQUEST['page'] === 'post-snippets-edit-css'){

            add_meta_box(
                'ps_option_meta_box', //Meta box ID
                __('Options','post-snippets'), //Meta box Title
                array(\PostSnippets::EDIT_CLASS, 'options_metabox_content'), //Callback defining the metabox's innards
                NULL, // Screen to which to add the meta box, blank means current screen
                'side' // Context
            );

            add_meta_box(
                'ps_preview_meta_box', //Meta box ID
                __('Preview','post-snippets'), //Meta box Title
                array(\PostSnippets::EDIT_CLASS, 'preview_metabox_content'), //Callback defining the metabox's innards
                NULL, // Screen to which to add the meta box, blank means current screen
                'normal' // Context
            );

            add_meta_box(
                'ps_pages_meta_box', //Meta box ID
                __('Apply only on these URLs','post-snippets'), //Meta box Title
                array(\PostSnippets::EDIT_CLASS, 'pages_metabox_content'), //Callback defining the metabox's innards
                NULL, // Screen to which to add the meta box, blank means current screen
                'normal' // Context
            );

        }


    }

    function body_content_cb(){
        $this->snippetTitle();
        $this->codeEditor();
        // $this->setup_sections();
        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit'){
            do_settings_sections( 'post-snippets-edit' );
        }
        $this->description();
        // submit_button(__('Save','post-snippets'));
    }

    static function actions_metabox_content(){

        if( !self::$editSnippetPage ){
            $disabled_action = "style = opacity:40%";
            $disabled_action_cursor = "style = cursor:not-allowed";
        }
        else{
            $disabled_action = '';
            $disabled_action_cursor = '';
        }

        ?>

            <div id="sync-up-confirm" title="<?php _e( 'Confirm', 'post-snippets' ) ?>" style="display:none;">
            <p><span class="dashicons dashicons-warning" style="float:left; margin-right:12px;"></span>
            <?php _e( 'Do you want to upload the current snippet to the cloud', 'post-snippets' ) ?>
            </div>


            <div id="sync-down-confirm" title="<?php _e( 'Confirm', 'post-snippets' ) ?>" style="display:none;">
            <p><span class="dashicons dashicons-warning" style="float:left; margin-right:12px;"></span>
            <?php _e( 'Replace Current Snippet From Cloud', 'post-snippets' ) ?>
            </div>


            <div id="sync-up-success" title="<?php _e( 'Success', 'post-snippets' ) ?>" style="display:none;">
            <p><span class="dashicons dashicons-thumbs-up" style="float:left; margin-right:12px;"></span>
            <p upload-success></p>
            </div>

            <div id="sync-up-error" title="<?php _e( 'Error', 'post-snippets' ) ?>" style="display:none;">
            <p><span class="dashicons dashicons-warning" style="float:left; margin-right:12px;"></span>
            <p data-error></p>
            </div>

            <div id="sp-loading" style="display:none;">
                <span></span>
            </div>



            <div class="pspro_edit_duplicate_snippet" <?php echo esc_attr( $disabled_action ) ?>>

                <span class="dashicons dashicons-admin-page" style="width:30px; height:30px; font-size:25px;"></span>
                <button <?php echo esc_attr( $disabled_action_cursor ) ?> class="link_style_button" type="<?php echo (self::$editSnippetPage) ? esc_attr( "submit" ) : esc_attr( "button" )  ?>" name="duplicate" value><?php esc_html_e( "Duplicate Snippet", 'post-snippets' ) ?></button>

            </div>

            <?php       /**Shortcode Option only on PHP code page */

                if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit'){
                    ?>
                        <div class="pspro_edit_copy_shortcode" style="margin-top:1rem; text-align:center;"><?php

                            if(self::$editSnippetPage){?>

                                <div id="pspro_edit_shortcode_copied">
                                    <span id="pspro_edit_shortcode_copied_text"><?php esc_html_e( "Shortcode Copied", "post-snippets" ) ?></span>
                                </div>

                            <input type="text" name="" id="pspro_edit_shotcode_text" disabled value = "<?php echo (esc_attr( self::generate_shortcode_text() ))  ?>" style="width:100%;<?php echo self::get_data('snippet_shortcode')?'':'display:none;'; ?>">

                            <?php
                            }
                            ?>

                            <button type = "button" class="button"
                                <?php   echo self::$editSnippetPage ? ( ( self::get_data('snippet_shortcode') == 0 )?( esc_attr( 'disabled' ) ):'') : ( esc_attr( 'disabled' ) ) ?>>
                                <?php   esc_html_e( "Copy Shortcode", 'post-snippets' ) ?>
                            </button>
                        </div>
                    <?php
                }
            ?>

            <div class="pspro_edit_snippet_status" style="margin-top:1rem;">
                <label for="pspro_edit_snippet_status" style="font-size:17px;"><?php esc_html_e( "Status", 'post-snippets' ) ?><br>
                    <select name="snippet_status" id="pspro_select_snippet_status" style="width:100%;">
                        <option value="1" <?php echo ( self::get_data('snippet_status') == 1 )?( esc_attr( 'selected' ) ):'' ?>><?php esc_html_e( "Active", 'post-snippets' ) ?></option>
                        <option value="0" <?php echo ( self::get_data('snippet_status') == 0 )?( esc_attr( 'selected' ) ):'' ?>><?php esc_html_e( "InActive", 'post-snippets' ) ?></option>
                    </select>
                </label>
            </div>
        <?php
    }


    static function groups_meta_box_content(){

        global $wpdb;
        $table_name = $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME;

        $all_groups = $wpdb->get_results($wpdb->prepare("SELECT * FROM %1s", $table_name), ARRAY_A );
        ?>

            <div id="pspro_group_list" class="categorydiv">

                    <ul id="pspro_group-tabs" class="category-tabs">
                        <li class="tabs"> <?php esc_html_e( 'All Groups', 'post-snippets' ) ?></li>
                    </ul>

                    <div id="pspro-group-all" class="tabs-panel">

                        <ul id="pspro_group_checklist" data-wp-lists="list:pspro_group" class="categorychecklist form-no-clear">
                            <?php

                                $checked = '';  /** Preventing Further warning of undefind variable below */

                                foreach ($all_groups as $group_key => $group_value) {

                                    if(self::$editSnippetPage){
                                        $group_list = maybe_unserialize( self::get_data('snippet_group') );
                                        $checked = in_array($group_value['ID'], $group_list)?"checked":"";
                                    }

                                    else{
                                        $ungrouped_checked = (!strcmp($group_value['group_slug'], __('ungrouped','post-snippets') ))?"checked ":"";
                                    }

                            ?>
                                <li id="pspro_group_<?php echo esc_attr( $group_value['ID'] )?>">
                                    <label class="selectit">
                                        <input value="<?php echo esc_attr( $group_value['ID'] )?>" type="checkbox" name="pspro_group_list[]" id="in_pspro_group_<?php echo esc_attr( $group_value['ID'] )?>"
                                        <?php   echo ( esc_attr( $ungrouped_checked?? '' ) );
                                                echo ( esc_attr( $checked ) );
                                        ?>/>
                                        <?php
                                            echo esc_html( $group_value['group_name'] );
                                        ?>
                                    </label>
                                </li>
                            <?php

                                }

                            ?>

                        </ul>
                    </div>
                </div>
        <?php
    }

    static function options_metabox_content(){

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-js'){


            $jsLocation = self::getLocation('js');
            if( empty($jsLocation) ){
                $jsLocation = 'header';
            }

            ?>

                <div id="pspro_edit_options_where">

                    <h3 id = "pspro_edit_js_where_on_page"><?php esc_html_e( "Where on page", "post-snippets" ) ?></h3>

                    <input type="radio" name="pspro_edit_js_where" id="pspro_edit_js_header" class="pspro_edit_js_radio" value="header" <?php echo ( $jsLocation == 'header' ) ? ( esc_attr( 'checked' ) ) : '' ?> >
                    <label for="pspro_edit_js_header" class="pspro_edit_js_label"><?php esc_html_e( "Header", "post-snippets" ) ?></label><br>

                    <input type="radio" name="pspro_edit_js_where" id="pspro_edit_js_footer" class="pspro_edit_js_radio" value="footer" <?php echo ( $jsLocation == 'footer' ) ? ( esc_attr( 'checked' ) ) : '' ?> >
                    <label for="pspro_edit_js_footer" class="pspro_edit_js_label"><?php esc_html_e( "Footer", "post-snippets" ) ?></label><br>

                </div>


            <?php
        }

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-js' || $_REQUEST['page'] === 'post-snippets-edit-css'){

            $location = self::getLocation('site');
            if( empty($location) ){
                $location = 'admin';
            }
            $available_site_locations = Edit::availableSiteLocations();

            ?>

                <div id="pspro_edit_options_where_in_site">

                    <h3 id = "pspro_edit_where_in_site"><?php esc_html_e( "Where in Site", "post-snippets" ) ?></h3>


                    <?php

                        foreach ($available_site_locations as $available_site_location_slug => $available_site_location) {
                            ?>
                                <input

                                    type="radio" name="pspro_edit_where_site"
                                    id="pspro_edit_<?php echo esc_attr( $available_site_location_slug ) ?>"
                                    class="pspro_edit_js_radio"
                                    value="<?php echo esc_attr( $available_site_location_slug ) ?>"
                                    <?php echo ( $location == $available_site_location_slug ) ? ( esc_attr( 'checked' ) ) : '' ?>
                                >

                                <label

                                    for="pspro_edit_<?php echo esc_attr( $available_site_location_slug ) ?>"
                                    class="pspro_edit_js_label"><?php esc_html_e( $available_site_location, "post-snippets" )

                                ?></label><br>

                            <?php
                        }

                    ?>

                </div>


            <?php


        }

    }

    static function preview_metabox_content(){

        $pageLocation   = self::getLocation('page');
        $url            = '';
        if( is_array($pageLocation) && isset( $pageLocation['specific_page'] ) ){
            $selected_page = $pageLocation['specific_page'];    /**page_or_post_id */
            $url = get_permalink( $selected_page );
        }

        ?>

            <div id="pspro_edit_preview_page" class="pspro_edit_display_flex">

                <input type="text" name="pspro_edit_preview_text" id="pspro_edit_preview_text" disabled
                    placeholder="<?php esc_attr_e( 'Full URL on which to preview the changes ...', 'post-snippets' )?>"
                    value = "<?php echo esc_url( $url )?>"
                >

                <button type="button" id="pspro_edit_preview_button" class="button button-primary" disabled><?php esc_html_e( 'Preview Changes', 'post-snippets' ) ?></button>

            </div>

        <?php


    }

    static function pages_metabox_content(){

        $pages                  = self::getAllPagesAndPosts();
        $pageLocation           = self::getLocation('page');
        $available_locations    = Edit::availablePageLocations();
        $disabled               = 'disabled';
        $selected_page          = false;

        if( empty($pageLocation) ){
            $pageLocation = 'all_website';
        }

        if( is_array($pageLocation) && isset( $pageLocation['specific_page'] ) ){
            $selected_page  = $pageLocation['specific_page'];
            $pageLocation   = 'specific_page';
            $disabled       = '';
        }

        ?>
            <div id="pspro_edit_select_location" class="pspro_edit_display_flex">

                <select name="pspro_edit_location_select" id="pspro_edit_location_select">

                    <?php

                        foreach ($available_locations as $available_location_slug => $available_location) {
                            ?>
                                <option value="<?php echo esc_attr( $available_location_slug ) ?>" <?php echo ( $available_location_slug == $pageLocation ? 'selected' : '') ?>

                                ><?php esc_html_e( $available_location, 'post-snippets' ) ?></option>

                            <?php
                        }

                    ?>

                </select>

                <select name="pspro_edit_page_select" id="pspro_edit_page_select" <?php echo esc_attr( $disabled ) ?>>
                    <?php

                        foreach ($pages as $page) {
                            ?>
                                <option value="<?php echo esc_attr( $page->ID ) ?>" data-url = "<?php echo esc_attr( get_permalink($page->ID) ) ?>"
                                    <?php echo ( $selected_page == $page->ID ? 'selected' : '' ) ?>

                                ><?php echo esc_attr( ( !empty($page->post_title) ) ? $page->post_title : $page->post_name ) ?></option>

                            <?php
                        }

                    ?>
                </select>

                <button type="button" id="pspro_edit_add_selection" class="button button-primary" disabled><?php esc_html_e( 'Add', 'post-snippets' ) ?></button>

            </div>


        <?php

    }

    static function getLocation($type = ''){

        if( empty( $type ) ){
            return '';
        }

        $location = Shortcode::filterVars( self::get_data('snippet_vars') );

        if( $type === 'js' ){

            if( !empty($location) ){

                $location = array_keys($location);

                if( !empty( $location[1] ) ){
                    $location = $location[1];
                    if($location !== 'header' && $location !== 'footer'){
                        $location = '';
                    }
                }
                else{
                    $location = '';
                }
            }
            else{
                $location = '';
            }

            return $location;
        }
        elseif( $type === 'site' ){

            if( !empty($location) ){

                $location = array_keys($location);

                if( !empty( $location[2] ) ){
                    $location                   = $location[2];
                    $available_site_locations   = array_keys( Edit::availableSiteLocations() );
                    if( !in_array($location, $available_site_locations) ){
                        $location = '';
                    }
                }
                else{
                    $location = '';
                }
            }
            else{
                $location = '';
            }

            return $location;
        }
        elseif( $type === 'page' ){

            if( !empty($location) ){

                $location_keys = array_keys($location);

                if( !empty( $location_keys[0] ) ){

                    $location_type              = $location_keys[0];
                    $available_locations        = Edit::availablePageLocations();
                    $available_locations_slugs  = array_keys($available_locations);

                    if($location_type === 'specific_page'){
                        $location_page = $location['specific_page'];

                        if( empty($location_page) || !Edit::isPageOrPost($location_page) ){
                            return '';
                        }

                        return array($location_type => $location_page);
                    }

                    if( !in_array( $location_type, $available_locations_slugs, true ) ){
                        return '';
                    }

                    return $location_type;
                }
                else{
                    $location = '';
                }
            }
            else{
                $location = '';
            }

            return $location;

        }

        return '';

    }

    static function getAllPagesAndPosts(){

        $args = array(
            'post_type'     => array( 'page', 'post' ),
            'numberposts'   => -1
        );

        $pages = get_posts($args);

        return $pages;

    }

    static function isPageOrPost( $id = '' ){

        if( empty($id) ){
            return false;
        }

        $pagesAndPosts = self::getAllPagesAndPosts();

        if( !empty( $pagesAndPosts ) ){

            foreach ($pagesAndPosts as $pageAndPost) {
                if($id == $pageAndPost->ID){
                    return true;
                }
                continue;
            }

            return false;
        }

        return false;

    }


    function snippetTitle(){

        ?>

        <div id="titlediv">
            <div id="titlewrap">
                <?php
                    $title_placeholder = apply_filters( 'snippet_title_input', __( 'Enter Snippet Title' ) );
                    $snippet_title = self::get_data('snippet_title');
                ?>
                <label class="screen-reader-text" id="title-prompt-text" for="title"><?php echo esc_html($title_placeholder) ; ?></label>
                <input type="text" name="snippet_title" size="30" value="<?php echo esc_attr( $snippet_title ); ?>" id="title" spellcheck="true" autocomplete="off" placeholder = "<?php echo esc_html($title_placeholder); ?>"/>

            </div>

        </div><!-- /titlediv -->

        <?php

    }

    function setup_code_editor(){

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-js' || $_REQUEST['page'] === 'post-snippets-edit-css'){

            if( $_REQUEST['page'] === 'post-snippets-edit-js' ){
                $type = 'text/javascript';
            }
            elseif( $_REQUEST['page'] === 'post-snippets-edit-css' ){
                $type = 'text/css';
            }

            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                // 'type'          => 'application/x-httpd-php',
                // 'type'          => 'text/javascript',
                'type'          => $type,
                'codemirror'    =>  array(
                    // 'value'     =>  '<script>',
                    'gutters'   =>  array("CodeMirror-lint-markers", "CodeMirror-foldgutter"/*, "CodeMirror-markergutter"*/),
                    // 'theme'     =>  'dracula.css'
                    // 'lineNumbers'   => false
                    // 'mode'      => array(
                    //     'name'      => "php",
                    //     'startOpen' => true
                    // ),
                    // 'mode'      => "text/x-php",
                    'foldGutter'    => true,
                    // 'markerGutter'  => true,
                    'lint'      => true
                    // 'htmllint'      => true

                )
            ));

            wp_localize_script('post-snippets', 'cm_settings', $cm_settings);

            wp_enqueue_script('wp-theme-plugin-editor');
            wp_enqueue_style('wp-codemirror');
            wp_enqueue_style(   'post-snippets-edit',       plugin_dir_url( PS_MAIN_FILE_PATH ) .  "assets/edit.css");
            wp_enqueue_script(  'post-snippets-edit-menu',  plugin_dir_url( PS_MAIN_FILE_PATH ) .  'assets/edit.js');

            return;
        }

	    wp_enqueue_style(  'post-snippets-editor', plugin_dir_url( PS_MAIN_FILE_PATH ) . 'assets/editor.css' );
        wp_enqueue_script( 'post-snippets-editor', plugin_dir_url( PS_MAIN_FILE_PATH ) . 'assets/editor.js'   );

        wp_enqueue_style(   'post-snippets-edit',       plugin_dir_url( PS_MAIN_FILE_PATH ) .  "assets/edit.css");
        wp_enqueue_script(  'post-snippets-edit-menu',  plugin_dir_url( PS_MAIN_FILE_PATH ) .  'assets/edit.js');
    }

    function codeEditor(){

        $snippet_content = self::get_data('snippet_content');

        ?>
            <style>
                #ps_snippet_code_editor textarea{

                    width: 100%;
                    min-height: 60vh;
                    height: calc(100vh - 295px);
                    border: 1px solid #dcdcde;
                    box-sizing: border-box;

                    font-family: Consolas, Monaco, monospace;
                    font-size:13px;
                    background:#f6f7f7;
                    -moz-tab-size:4;
                    -o-tab-size:4;
                    tab-size:4;

                }

                .pspro_codeEditor_heading{

                    margin-top: 1.5rem !important;
                    margin-bottom: 1rem !important;

                }
                div#ps_snippet_code_editor{
                    margin-bottom: 1rem;
                }
            </style>
            <input type="hidden" name="pspro-edit-code-editor-page" value="<?php echo esc_attr( self::get_snippet_page() ) ?>">
            <div id="ps_snippet_code_editor">
                <h1 class="pspro_codeEditor_heading wp-heading"> <?php esc_html_e( 'Code Editor:', 'post-snippets' ) ?> </h1>
                <textarea name="snippet_content" id="ps_code_editor"><?php echo esc_html(  stripslashes( $snippet_content ) ) ?></textarea>
            </div>
    <?php

    }

    public static function setup_sections(){


        add_settings_section(   'pspro_edit_snippet',
                                '',
                                '',
                                'post-snippets-edit' );

        add_settings_field( 'snippet_vars',   //unique_name
                            __('Variables:','post-snippets'),    //Label
                            array( \PostSnippets::EDIT_CLASS, 'add_section_fields' ),  //Callback Func
                            'post-snippets-edit',     //page slug
                            'pspro_edit_snippet',      //section slug
                            // 'snippet_vars'
                            array(
                                'id'          => 'snippet_vars',
                                'label_for'   => 'pspro_snippet_vars',
                                'description' => __( 'Enter Variables For This Snippet', 'post-snippets' )
                            )
                        );  //value to pass to callback function

        add_settings_field( 'snippet_shortcode',
                            __('Shortcode:','post-snippets'),
                            array( \PostSnippets::EDIT_CLASS, 'add_section_fields' ),
                            'post-snippets-edit',
                            'pspro_edit_snippet',
                            // 'snippet_shortcode'
                            array(
                                'id'          => 'snippet_shortcode',
                                'label_for'   => 'pspro_snippet_shortcode',
                                'description' => __( 'Enable Shortcode For This Snippet', 'post-snippets' )
                            )
                        );

        add_settings_field( 'snippet_php',
                            __('PHP Code:','post-snippets'),
                            array( \PostSnippets::EDIT_CLASS, 'add_section_fields' ),
                            'post-snippets-edit',
                            'pspro_edit_snippet',
                            // 'snippet_php'
                            array(
                                'id'          => 'snippet_php',
                                'label_for'   => 'pspro_snippet_php',
                                'description' => __( 'Enable PHP Rendering For This Snippet', 'post-snippets' )
                            )
                        );


        add_settings_field( 'snippet_wptexturize',
                            __('WPtexturize:','post-snippets'),
                            array( \PostSnippets::EDIT_CLASS, 'add_section_fields' ),
                            'post-snippets-edit',
                            'pspro_edit_snippet',
                            // 'snippet_wptexturize'
                            array(
                                'id'          => 'snippet_wptexturize',
                                'label_for'   => 'pspro_snippet_wptexturize',
                                'description' => __( 'Enable WP_Texturize For This Snippet', 'post-snippets' )
                            )
                        );
    }

    public static function add_section_fields( $arguments ) {

        if($arguments['id'] == 'snippet_vars'){

            $snippet_vars = self::get_data($arguments['id']);

            ?>

                <textarea
                            name="<?php echo esc_attr( $arguments['id'] )  ?>"
                            id="pspro_<?php echo esc_attr( $arguments['id'] ) ?>"
                            cols="55" rows="4"
                            ><?php echo esc_html( $snippet_vars ) ?></textarea>

            <?php

            return;
        }
        if($arguments['id'] == 'snippet_wptexturize'){
            $is_checked = self::get_data($arguments['id']);

            ?>

                <input  type="checkbox"
                        name="<?php echo esc_attr( $arguments['id'] )  ?>"
                        id="pspro_<?php echo esc_attr( $arguments['id'] ) ?>"
                        value = "1"
                        <?php echo ( ($is_checked)?esc_attr( 'checked' ):'' ) ?>

                />

            <?php
            echo '<label>';
            echo esc_html('Text enclosed in the tags <pre> <code>, <kbd>, <style>, <script>, and <tt> will be skipped.');
            echo 'For more details please visit <a href="https://developer.wordpress.org/reference/functions/wptexturize/" target="_blank">WPtexturize</a>.';
            echo '</label>';
        }
        else
        {

        $is_checked = self::get_data($arguments['id']);

        ?>

            <input  type="checkbox"
                    name="<?php echo esc_attr( $arguments['id'] )  ?>"
                    id="pspro_<?php echo esc_attr( $arguments['id'] ) ?>"
                    value = "1"
                    <?php echo ( ($is_checked)?esc_attr( 'checked' ):'' ) ?>

            />

        <?php
        }


    }


    function description(){

        $snippet_desc = self::get_data('snippet_desc');
        if ( isset( $snippet_desc ) && ! empty( $snippet_desc ) ) {
            $snippet_desc = stripslashes( $snippet_desc );
        }
        else{
            $snippet_desc ='';
        }

        ?>
            <h1 class="ps_description_heading wp-heading" style="margin-top:1.5rem; margin-bottom:1.5rem"> <?php esc_html_e( 'Description:', 'post-snippets' ) ?> </h1>

        <?php

        wp_editor(stripslashes($snippet_desc), 'ps_snippet_description', array(

            'textarea_name' => 'snippet_desc',

            // 'wpautop'       => true,
            // 'media_buttons' => false,
            // 'editor_class'  => 'my_custom_class',
            // 'textarea_rows' => 10

        ) );


    }

    static function get_data($column){

        $column = sanitize_key( $column );

        if(self::$editSnippetPage){

            global $wpdb;

            $data = $wpdb->get_var($wpdb->prepare("SELECT $column FROM ".$wpdb->prefix.\PostSnippets::TABLE_NAME." WHERE ID = %d", self::$snippet_id));
        }

        else{

            if($column == "snippet_title"){
                $pattern = '/[\s]/i';   /**remove any WhiteSpaces */
                $replacement = '';
                $snippet_title =  preg_replace($pattern, $replacement, $_REQUEST[$column]?? '');
                return $snippet_title;
            }

            $data = $_REQUEST[$column]?? '';

        }

        return $data;
    }


    /**
     * Change Group Count When any Snippet group changes
     * or when a snippet is deleted or duplicated.
     *
     * @param  Array  $group_list   - Group List
     * @param  String $method       - Whether to Increment or Decrement
     *
     * @return Void
     *
     */
    public static function change_group_count($group_list, $method){

        global $wpdb;

        if( !strcmp($method, 'increment') ){

            foreach ($group_list as $key => $group_id) {

                $group_count = $wpdb->get_var( $wpdb->prepare("SELECT group_count FROM ".$wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME." WHERE ID = %d", $group_id) );
                $group_count = $group_count + 1;

                $group_count_updated = $wpdb->update(

                    $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME,
                    array(                      /**Data to update */
                        'group_count'   => $group_count
                    ),
                    array(                      /**Where Coulum = ? */
                        'ID'            => $group_id
                    ),
                    array(                      /**Data Format, %d or %s */
                        '%d'
                    ),
                    array(                      /**Where Format, %d or %s */
                        '%d'
                    )
                );
            }
        }

        elseif( !strcmp($method, 'decrement') ){

            foreach ($group_list as $key => $group_id) {

                $group_count = $wpdb->get_var( $wpdb->prepare("SELECT group_count FROM ".$wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME." WHERE ID = %d", $group_id) );

                if($group_count == 0){      /**if there is no snippet in a group but a snippet is deleted, this condition would never met but just in case*/

                    continue;
                }

                $group_count = $group_count - 1;    /**Decrement Group Count */

                $wpdb->update(
                    $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME,
                    array(                      /**Data to update */
                        'group_count'   => $group_count
                    ),
                    array(                      /**Where Coulum = ? */
                        'ID'            => $group_id
                    ),
                    array(                      /**Data Format, %d or %s */
                        '%d'
                    ),
                    array(                      /**Where Format, %d or %s */
                        '%d'
                    )
                );
            }
        }
    }

    function is_JS(){

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-js' /*&& isset($_REQUEST['pspro_edit_location_select'])*/ ){

            return true;
        }
        else{
            return false;
        }
    }

    function JS_location(){

        if( $this->is_JS() && isset( $_REQUEST['pspro_edit_js_where'] ) && ( $_REQUEST['pspro_edit_js_where'] === 'header' || $_REQUEST['pspro_edit_js_where'] === 'footer' ) ){

            return $_REQUEST['pspro_edit_js_where'];
        }
        elseif( $this->is_JS() ){
            return 'header';
        }
        elseif( $this->is_CSS() ){
            return 'css';
        }
        else{
            return '';
        }

    }

    function is_CSS(){

        if( isset($_REQUEST['page']) && $_REQUEST['page'] === 'post-snippets-edit-css' /*&& isset($_REQUEST['pspro_edit_location_select'])*/ ){

            return true;
        }
        else{
            return false;
        }
    }

    function codeLocation(){

        if( ( $this->is_JS() || $this->is_CSS() ) && isset( $_REQUEST['pspro_edit_location_select'] ) && $this->siteLocation() != 'admin'){

            $selected_location          = $_REQUEST['pspro_edit_location_select'];
            $available_locations        = Edit::availablePageLocations();
            $available_locations_slugs  = array_keys($available_locations);

            if( $selected_location === 'specific_page'){

                if( isset( $_REQUEST['pspro_edit_page_select'] ) && is_numeric( $_REQUEST['pspro_edit_page_select'] ) ){

                    $specific_page_exist = Edit::isPageOrPost( $_REQUEST['pspro_edit_page_select'] );

                    if( $specific_page_exist ){
                        return 'specific_page='.$_REQUEST['pspro_edit_page_select'];
                    }
                    else{
                        return '';
                    }
                }

                return '';

            }

            elseif( in_array($selected_location, $available_locations_slugs, true) ){

                return $selected_location;
            }

            return '';
        }
        elseif( $this->siteLocation() == 'admin' ){
            return 'all_website';
        }
        else{
            return '';
        }
    }

    function siteLocation(){

        if( ( $this->is_JS() || $this->is_CSS() ) && isset( $_REQUEST['pspro_edit_where_site'] ) ){

            $selected_location          = $_REQUEST['pspro_edit_where_site'];
            $available_site_locations   = array_keys( Edit::availableSiteLocations() );

            if( in_array($selected_location, $available_site_locations) ){
                return $selected_location;
            }
            return 'admin';
        }
        return '';
    }

    static function availablePageLocations(){

        return array(
            'all_website'   => 'All Website',
            'homepage'      => 'Homepage',
            'all_pages'     => 'All Pages',
            'all_posts'     => 'All Posts',
            'specific_page' => 'Specific page / post'
        );
    }

    static function availableSiteLocations(){

        return array(
            'frontend'      => 'In Front-End',
            'admin'         => 'In Admin',
        );

    }

    function save_data(){

        if( isset($_REQUEST['submit']) ){

            check_admin_referer( 'pspro_edit_snippet', 'pspro_edit_snippet_nonce' );

            global $wpdb;
            $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;



            //******************** Preparing Group List ************************* */

                $upgrouped_id = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM ".$wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME." WHERE group_slug = %s", __('ungrouped','post-snippets') ) );
                $group_list = $_REQUEST['pspro_group_list'] ?? array($upgrouped_id); /**If no group is selected */

            //*************************** END ****************************** */



            //******************** Preparing Snippet Title ************************* */

                $snippet_title = self::filter_snippet_title( $_REQUEST['snippet_title'] );


            //****************************** END *********************************** */


            //******************** Preparing Snippet vars ************************* */

                if( isset($_REQUEST['snippet_vars']) && !empty( $_REQUEST['snippet_vars'] ) ){

                    $snippet_vars = self::filter_snippet_vars( $_REQUEST['snippet_vars'] );

                }
                elseif( isset($_REQUEST['snippet_vars']) && empty( $_REQUEST['snippet_vars'] ) ){

                    $snippet_vars = '';

                }
                elseif( !isset($_REQUEST['snippet_vars']) && ( $this->is_JS() || $this->is_CSS() ) ){

                    $codeLocation   = $this->codeLocation();
                    $jsLocation     = $this->JS_location();
                    $siteLocation   = $this->siteLocation();

                    if( !empty($codeLocation) && !empty($jsLocation) && !empty($siteLocation) ){
                        $snippet_vars = $codeLocation.','.$jsLocation.','.$siteLocation;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }

            //****************************** END *********************************** */



            //******************** Preparing Snippet Content ************************* */

                $snippet_content = $_REQUEST['snippet_content'];
                if ($this->is_CSS()) {
                    // validate that the css snippet contains only css code
                    //$snippet_content = wp_strip_all_tags($snippet_content);
                      $snippet_content = wp_kses($snippet_content, array( 'style' => array() ));
                }
                // if( !empty($snippet_content) && $this->is_JS() ){

                //     $start  = '<script type=\"text/javascript\">';
                //     $end    = '</script>';

                //     $snippet_content = $start.'\n'.$snippet_content.'\n'.$end;

                // }

            //****************************** END *********************************** */



            //******************** Preparing Snippet Description ************************* */

                $snippet_desc = sanitize_textarea_field( $_REQUEST['snippet_desc'] ?? '' );

            //****************************** END *********************************** */



            //******************** Preparing Snippet PHP ************************* */

                if( isset($_REQUEST['snippet_php']) ){
                    $snippet_php = ( ($_REQUEST['snippet_php']?? 0 ) == 1) ? 1 : 0;
                }
                else{
                    /**As this variable is not used in JS and CSS pages, they
                     * can be used to save those pages. so new DB entry
                     * doesn't need to be created.
                     * 2 for JS and 3 for CSS.
                     */
                    if( $this->is_JS() ){
                        $snippet_php = 2;
                    }
                    elseif( $this->is_CSS() ){
                        $snippet_php = 3;
                    }
                    else{
                        // return false;
                        $snippet_php = '0';
                    }

                }

            //****************************** END *********************************** */


            if( !empty($snippet_title)  ){

                if(self::$editSnippetPage){    /**This is a edit page of Previous Snippet */

                    $current_snippet_title = $wpdb->get_var( $wpdb->prepare("SELECT snippet_title FROM $table_name WHERE ID = %d", self::$snippet_id) );

                    if( $snippet_title != $current_snippet_title && $this->duplicate_title_check($snippet_title) ){

                        printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'Duplicate Titles are Not Allowed', 'post-snippets' ) );
                        return;

                    }

                    else{

                        $current_group_list  = $group_list;
                        $previous_group_list = maybe_unserialize( $wpdb->get_var( $wpdb->prepare("SELECT snippet_group FROM $table_name WHERE ID = %d", self::$snippet_id) ) );

                        $increment_count = array_diff($current_group_list, $previous_group_list);

                        $decrement_count = array_diff($previous_group_list, $current_group_list);

                        $snippet_updated = $wpdb->update(
                                                $table_name,
                                                array(
                                                    'snippet_group'         => maybe_serialize( $group_list ),
                                                    'snippet_title'         => $snippet_title,
                                                    'snippet_content'       => $snippet_content,
                                                    'snippet_date'          => current_time( 'mysql' ),
                                                    'snippet_vars'          => $snippet_vars,
                                                    'snippet_desc'          => $snippet_desc,
                                                    'snippet_status'        => ( ($_REQUEST['snippet_status']?? 0 ) == 1) ? 1 : 0,     //Disable by default
                                                    'snippet_shortcode'     => ( ($_REQUEST['snippet_shortcode']?? 0 ) == 1) ? 1 : 0,
                                                    'snippet_php'           => $snippet_php,
                                                    'snippet_wptexturize'   => ( ($_REQUEST['snippet_wptexturize']?? 0 ) == 1) ? 1 : 0,
                                                ),
                                                array(                      /**Where Coulum = ? */
                                                    'ID'                    => self::$snippet_id,
                                                ),
                                                array(                      /**Data Format, %d or %s */
                                                    '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'
                                                ),
                                                array(                      /**Where Format, %d or %s */
                                                    '%d'
                                                )
                                            );


                        if($snippet_updated){

                            printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Updated', 'post-snippets' ) );
                            // return;
                        }

                        elseif(!$snippet_updated){

                            printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Update Failed', 'post-snippets' ) );
                            // return;
                        }

                        if( !empty($increment_count) || !empty($decrement_count) ){

                            //change group count here
                            if( !empty($increment_count) ){     /**Increment Count of these groups */

                                self::change_group_count($increment_count, 'increment');

                            }

                            if( !empty($decrement_count) ){     /**Decrement Count of these groups */

                                self::change_group_count($decrement_count, 'decrement');

                            }

                        }
                    }
                }

                elseif( !self::$editSnippetPage && !$this->duplicate_title_check($snippet_title) ){       /**Adding New Snippet here */

                    $snippet_added = $wpdb->insert(
                                        $table_name,
                                        array(
                                            'snippet_group'         => maybe_serialize( $group_list ),
                                            'snippet_title'         => $snippet_title,
                                            'snippet_content'       => $snippet_content,
                                            'snippet_date'          => current_time( 'mysql' ),
                                            'snippet_vars'          => $snippet_vars,
                                            'snippet_desc'          => $snippet_desc,
                                            'snippet_status'        => ( ($_REQUEST['snippet_status']?? 0 ) == 1) ?         1 : 0,     //Disable by default
                                            'snippet_shortcode'     => ( ($_REQUEST['snippet_shortcode']?? 0 ) == 1) ?      1 : 0,
                                            'snippet_php'           => $snippet_php,
                                            'snippet_wptexturize'   => ( ($_REQUEST['snippet_wptexturize']?? 0 ) == 1) ?    1 : 0,
                                        )
                    );

                    if( $snippet_added ){

                        self::change_group_count($group_list, 'increment');

                        $page = self::get_snippet_page();
                        $url = admin_url( sprintf('admin.php?page=%s&action=edit&snippet=%s&message=%s&_wpnonce=%s', $page, $wpdb->insert_id, 1, wp_create_nonce('ps-snippets-hover-trigger_'.$wpdb->insert_id) ) );

                        ?> <script> <?php echo("location.href = '".$url."';"); ?> </script> <?php

                    }

                    elseif(!$snippet_added){

                        printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Not Added', 'post-snippets' ) );

                    }
                }

                else{

                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'Duplicate Titles are Not Allowed', 'post-snippets' ) );

                }
            }

            else{

                printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'Empty Title is Not Allowed', 'post-snippets' ) );

            }
        }
    }

    public static function get_snippet_page($id=''){

        if(empty($id)){

            if( isset($_REQUEST['page']) && ( $_REQUEST['page'] === 'post-snippets-edit' || $_REQUEST['page'] === 'post-snippets-edit-js' || $_REQUEST['page'] === 'post-snippets-edit-css' ) ){
                return $_REQUEST['page'];
            }

            return 'post-snippets-edit';
        }else{

            if($id == 2){
                return 'post-snippets-edit-js';
            }
            elseif($id == 3){
                return 'post-snippets-edit-css';
            }
            elseif($id == 0 || $id == 1){
                return 'post-snippets-edit';
            }

            return 'post-snippets-edit';

        }

    }

    public static function duplicate_title_check($snippet_title){

        global $wpdb;

        $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;

        $all_snippets_titles    = $wpdb->get_results( $wpdb->prepare("SELECT snippet_title FROM %1s", $table_name), ARRAY_A );

        $all_snippets_titles    = array_column($all_snippets_titles, 'snippet_title');

        $duplicate_title_exist  = in_array($snippet_title, $all_snippets_titles);

        if( $duplicate_title_exist ){
            /**Cause This function is also used to Increment
             * Title Count by number_duplicate_snippet_title,
             * otherwise, above written code would have to be
             * repeated.
            **/

            return $all_snippets_titles;

        }
        else{

            return false;

        }

    }


    public static function number_duplicate_snippet_title($snippet_title){

        if( empty($snippet_title) || !is_string($snippet_title) ){
            //redundancy
            $snippet_title = __('Untitled', 'post-snippets');

        }

        $all_snippets_titles = self::duplicate_title_check($snippet_title);

        if(!$all_snippets_titles){
            return $snippet_title;
        }


        return self::increment_snippet_title( $all_snippets_titles, $snippet_title );


    }


    public static function increment_snippet_title( $all_snippets_titles, $snippet_title ){

        /**Searching For Similar Titles */
        $same_titles = array();
        foreach ($all_snippets_titles as $title) {
            if( strpos( $title, $snippet_title ) === 0 ){
                $same_titles[] = $title;
            }
        }


        /**Incrementing Said Title */
        $counter = 1;
        while($counter){

            if( in_array($snippet_title.'_'.$counter, $same_titles) ){
                $counter++;
            }
            else{
                break;
            }
        }

        $new_snippet_title = $snippet_title.'_'.$counter;

        return $new_snippet_title;

    }


    static function generate_shortcode_text(){

        if(self::$editSnippetPage){

            $snippet_vars = Shortcode::filterVars( self::get_data('snippet_vars') );

            $snippet_vars_text = '';
            foreach ($snippet_vars as $var => $value) {
                $snippet_vars_text .= ' '. $var . (!empty($value)?'=':'') . $value;
            }

            $shortcode = '['.self::get_data('snippet_title') . $snippet_vars_text . ']';

            return $shortcode;
        }


    }


    function perform_actions_response(){

        if(self::$editSnippetPage){

            if( isset($_REQUEST['download']) ){

                check_admin_referer( 'pspro_edit_snippet', 'pspro_edit_snippet_nonce' );

                $ie = new ImportExport();

                $download_succeed = $ie->exportSnippets("(".self::$snippet_id.")");

                if($download_succeed){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippets Downloaded', 'post-snippets' ) );

                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }

            }


            if( isset($_REQUEST['upload']) ){

                check_admin_referer( 'pspro_edit_snippet', 'pspro_edit_snippet_nonce' );


            }


            if( isset($_REQUEST['duplicate']) ){

                check_admin_referer( 'pspro_edit_snippet', 'pspro_edit_snippet_nonce' );

                if( PSallSnippets::duplicate_snippet(self::$snippet_id) ){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Duplicated', 'post-snippets' ) );
                    return;
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }

            }


        }


    }


    public static function addImportedSnippet( $imported_snippet = array() ){

        if( !empty($imported_snippet) ){

            global $wpdb;
            $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $snippet_php = PSallSnippets::get_snippet_php($imported_snippet['snippet_php']);

            $snippet_added = $wpdb->insert(
                $table_name,
                array(
                    'snippet_group'         => $imported_snippet['snippet_group'],
                    'snippet_title'         => self::filter_snippet_title( $imported_snippet['snippet_title'] ),
                    'snippet_content'       => $imported_snippet['snippet_content'],
                    'snippet_date'          => current_time( 'mysql' ),
                    'snippet_vars'          => self::filter_snippet_vars( $imported_snippet['snippet_vars'] ),
                    'snippet_desc'          => $imported_snippet['snippet_desc'],
                    'snippet_status'        => (($imported_snippet['snippet_status']?? 0)       == 1) ? : 0,     //Disable by default
                    'snippet_shortcode'     => (($imported_snippet['snippet_shortcode']?? 0)    == 1) ? : 0,
                    'snippet_php'           => $snippet_php,
                    'snippet_wptexturize'   => (($imported_snippet['snippet_wptexturize']?? 0)  == 1) ? : 0,
                )
            );

            if($snippet_added){
                self::change_group_count( maybe_unserialize( $imported_snippet['snippet_group'] ), 'increment');
                return true;
            }
            else{
                return false;
            }

        }
        else{
            return false;
        }


    }


    public static function filter_snippet_vars($vars = ''){

        if( !empty($vars) ){

            $string = $vars;
            $pattern = '/([^A-Za-z,=_\d])/i';   /**remove any character from vars that are not Letters, Numbers or digits or Illegal php variable name */
            $replacement = '';
            $snippet_vars =  preg_replace($pattern, $replacement, $string);

            return $snippet_vars;
        }
        else{
            return $vars;
        }
    }

    public static function filter_snippet_title($title = ''){

        $title = sanitize_text_field( $title );

        if( !isset($title) || empty($title) ){
            // $snippet_title = __( 'Untitled', 'post-snippets' );
            $snippet_title = self::number_duplicate_snippet_title(__('Untitled', 'post-snippets'));
        }
        else{
            $snippet_title = sanitize_text_field( $title );
        }

        $pattern = '/[\s]/i';   /**remove any WhiteSpaces */
        $replacement = '';
        $snippet_title =  preg_replace($pattern, $replacement, $snippet_title);

        return $snippet_title;
    }


}
