<?php
namespace PostSnippets;

/**
 * Post Snippets All Snippets Table.
 *
 * Class to view list of all Snippets extending WP_List_Table class.
 *
 */
if(class_exists('PostSnippets')){

    if( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    class PSallSnippets extends \WP_List_Table{

        /**
         * Generates the table navigation above or bellow the table 
         * 
         * @param string $which 
         * @return void
         */

        
        function display_tablenav( $which ) 
        {
            ?>
            <div class="tablenav <?php echo esc_attr( $which ); ?>">

                <div class="alignleft actions bulkactions">
                    <?php $this->bulk_actions( $which ); ?>
                </div>
                <?php
                $this->extra_tablenav( $which );
                $this->pagination( $which );
                ?>
                <br class="clear" />
            </div>
            <?php

        }

        
        
        function column_snippet_title($item) {  //function name is array key of the column

            $snippet_status = ($item['snippet_status']==esc_attr__('Active','post-snippets')?esc_attr__('Deactivate','post-snippets'):esc_attr__('Activate','post-snippets'));
            
            $action_nonce = wp_create_nonce( 'ps-snippets-hover-trigger_'.$item['ID'] );

            $page = Edit::get_snippet_page($item['snippet_php']);

            $actions = array(
                        'edit'      => sprintf('<a href="?page=%s&action=%s&snippet=%s&_wpnonce=%s">%s</a>', esc_attr($page), 'edit', $item['ID'], $action_nonce, esc_attr__('Edit','post-snippets')),
                        'delete'    => sprintf('<button class="link_style_button red" type=%s name=%s value=%s>%s</button>', esc_attr( 'submit' ), 'delete', $item['ID'], esc_attr__('Delete','post-snippets') ),
                        'status'    => sprintf('<button class="link_style_button" type=%s name=%s value=%s>%s</button>', esc_attr( 'submit' ), sanitize_title($snippet_status), $item['ID'], $snippet_status ),
                        'duplicate' => sprintf('<button class="link_style_button" type=%s name=%s value=%s>%s</button>', esc_attr( 'submit' ), 'duplicate', $item['ID'], esc_attr__('Duplicate','post-snippets') ),
                    );
          
            return sprintf('%1$s %2$s', $item['snippet_title'], $this->row_actions($actions) );
          }
        

        function get_bulk_actions() {   //Bulk Action Dropdown
        $actions = array(
            'enable'     => 'Enable',
            'disable'    => 'Disable'
        );
        return $actions;
        }

        function column_cb($item) {     //Checkbox column
            return sprintf(
                '<input type="checkbox" name="snippets[]" value="%s" class="post-snippet-table-individual-checkbox"/>', $item['ID']
            );    
        }
        
        /**This will add vals to table class */
        function __construct() {
            parent::__construct( array(
           'singular'=> 'psp_all_snippet', //Singular label
           'plural' => 'psp_all_snippets', //plural label, also this well be one of the table css class
        //    'ajax'   => false //We won't support Ajax for this table
           ) );
         }
        
        
        /**
         * Add extra markup in the toolbars before or after the list
         * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
         */
        function extra_tablenav( $which ) {
            
            if ( $which == "top" ){
            //The code that goes before the table is here
            ?>
            
            <div class="alignleft actions">
                <label class="screen-reader-text" for="filter_by_status"><?php esc_html_e( 'Filter by status', 'post-snippets' ) ?></label>
                <select name="status" id="filter_by_status" class="postform">
                    <option value="-1"> <?php esc_html_e( 'Select Status', 'post-snippets' ) ?></option>                    
                    <option value="1" <?php echo esc_attr( (1 == ($_REQUEST['status']??'') )?" selected":'' ); ?>>  <?php esc_html_e( 'Active', 'post-snippets' ) ?></option>                    
                    <option value="0" <?php echo esc_attr( (0 == ($_REQUEST['status']??'') )?" selected":'' ); ?>>  <?php esc_html_e( 'Inactive', 'post-snippets' ) ?></option>                
                </select>
                <input type="submit" name="status_filter_action" id="doaction" class="button action" value="<?php esc_html_e( 'Filter', 'post-snippets' ) ?>">
            
            </div>

         

             
            </div>

            <?php
            }
        }
        
    
        /**
         * Prepare the items for the table to process
         *
         * @return Void
         */
        public function prepare_items(){

            $this->trigger_hover_action();
            $this->process_bulk_action();
            $this->process_bulk_upload();
            $this->process_bulk_download();

            global $wpdb;
        
            $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;
            $group_table_name = $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME;

            // $snippets_query = $this->process_bulk_filter($table_name);
            
            // $snippets = $wpdb->get_results($wpdb->prepare($snippets_query, NULL), ARRAY_A );

            $snippets = $this->process_bulk_filter($table_name);
            
            if(!empty($snippets) && $snippets != NULL){

                $data = $snippets;

                foreach ($data as $key => $value) { /**Changing group name and status and date*/

                    $data[$key]['snippet_status'] = ($data[$key]['snippet_status']==1?esc_attr__('Active','post-snippets'):esc_attr__('InActive','post-snippets'));
                    $date = $data[$key]['snippet_date'];
                    $createDate = new \DateTime($date);
                    $data[$key]['snippet_date'] = $createDate->format('d-m-Y');

                    unset( $data[$key]['snippet_content'] );    /**No need for Snippet Content */
                    unset( $data[$key]['snippet_vars'] );    /**No need for Snippet Vars on List Table */

                    $data[$key]['snippet_desc'] = esc_html( stripslashes($data[$key]['snippet_desc']) );
                }

                usort( $data, array( &$this, 'sort_data' ) );   //sort_data is a function, use database related function
                
                $perPage        = $this->get_items_per_page('psp_snippets_per_page', 10);
                $currentPage    = $this->get_pagenum();
                $totalItems     = count($data);

                $this->set_pagination_args( array(
                    'total_items' => $totalItems,
                    'per_page'    => $perPage
                ) );

                $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

                $this->items = $data;
            
            }

            $columns    = $this->get_columns();
            $hidden     = $this->get_hidden_columns();
            $sortable   = $this->get_sortable_columns();

            $this->_column_headers = array($columns, $hidden, $sortable);

        }

        /**
         * Override the parent columns method. Defines the columns to use in your listing table
         *
         * @return Array
         */
        public function get_columns()
        {
            $columns = array(
                'cb'          => '<input type="checkbox" />',
                // 'id'          => 'ID',
                'snippet_title'         => esc_attr__( 'Title', 'post-snippets' ),
                'snippet_desc'          => esc_attr__( 'Description', 'post-snippets' ),
                'snippet_status'        => esc_attr__( 'Status', 'post-snippets' ),
                'snippet_date'          => esc_attr__( 'Date', 'post-snippets' ),
                
            );

            return $columns;
        }

        /**
         * Define which columns are hidden
         *
         * @return Array
         */
        public function get_hidden_columns()
        {
            return array();
        }

        /**
         * Define the sortable columns
         *
         * @return Array
         */
        public function get_sortable_columns()
        {
            return array('snippet_title' => array('snippet_title', false));
        }

        /**
         * Define what data to show on each column of the table
         *
         * @param  Array $item        Data
         * @param  String $column_name - Current column name
         *
         * @return Mixed
         */
        public function column_default( $item, $column_name )
        {
            switch( $column_name ) {
                case 'ID':
                case 'snippet_title':
                case 'snippet_desc':
                case 'snippet_status':
                case 'snippet_group':
                case 'snippet_date':
                    return $item[ $column_name ];

                default:
                    return print_r( $item, true ) ;
            }
        }

        /**
         * Allows you to sort the data by the variables set in the $_GET
         *
         * @return Mixed
         */
        private function sort_data( $a, $b )
        {
            // Set defaults
            $orderby = 'snippet_title';
            $order = 'asc';

            // If orderby is set, use this as the sort column
            if(!empty($_GET['orderby']))
            {
                $orderby = $_GET['orderby'];
            }

            // If order is set use this as the order
            if(!empty($_GET['order']))
            {
                $order = $_GET['order'];
            }


            $result = strcmp( $a[$orderby], $b[$orderby] );

            if($order === 'asc')
            {
                return $result;
            }

            return -$result;
        }


        /**
         * Trigger Actions from the Hovering Actions section
         *
         * @return NULL
         */
        private function trigger_hover_action(){

            if( isset( $_REQUEST['delete'] ) ){

                check_admin_referer( 'pspro_all_snippets', 'pspro_all_snippets_nonce' );

                $snippet_id = intval($_REQUEST['delete']);

                if( $this->delete_snippet($snippet_id) ){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Deleted', 'post-snippets' ) );
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }

            }

            elseif( isset( $_REQUEST['deactivate'] ) ){    /**if it needs to be deactivate */

                $snippet_id = intval($_REQUEST['deactivate']);

                if( $this->change_snippet_status($snippet_id, 0) ){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Deactivated', 'post-snippets' ) );
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }
            }            
            
            elseif( isset( $_REQUEST['activate'] ) ){    /**if it needs to be activated */

                $snippet_id = intval($_REQUEST['activate']);

                if( $this->change_snippet_status($snippet_id, 1) ){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Activated', 'post-snippets' ) );
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }
            }

            elseif( isset( $_REQUEST['duplicate'] ) ){      /**If duplicate is clicked */

                $snippet_id = intval($_REQUEST['duplicate']);
                
                if( $this->duplicate_snippet($snippet_id) ){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippet Duplicated', 'post-snippets' ) );
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }
            }
        }

        /**
         * Delete Snippet from the Hovering Actions section
         *
         * @return NULL
         */
        private function delete_snippet($snippet_id){

            global $wpdb;
            $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $snippet_groups = maybe_unserialize( $wpdb->get_var($wpdb->prepare("SELECT snippet_group FROM $table_name WHERE ID = %d", $snippet_id)) );
        
            if( $wpdb->delete( $table_name, array('ID' => $snippet_id), array('%d') ) ){

                if( !empty($snippet_groups) ){  /**It should have atleast one group, the default group, but just in case */

                    Edit::change_group_count($snippet_groups, 'decrement');

                }
                return true;
            }
        
        }


        
        /**
         * Change Snippet Status from the Hovering Actions section
         * 
         * @param  Array|Int    $snippet_ids     Snippets ID Array or Int
         * @param  Int          $action         Whether to activate(1) or deactivate(0)
         *
         * @return Boolean
         */
        private function change_snippet_status($snippet_ids, $action){

            global $wpdb;
            $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            if( !is_array($snippet_ids) ){

                $snippet_ids = array($snippet_ids);

            }

            foreach ($snippet_ids as $key => $snippet_id) {
                
                $snippet_status = $wpdb->get_var( $wpdb->prepare("SELECT snippet_status FROM $table_name WHERE ID = %d", $snippet_id) );       /**Getting It's Status */

                if($action == 1 && $snippet_status != 1 ){    /**If its Already Active, Skip */
                                        
                    $status_updated = $this->update_snippet_status($snippet_id, $action, $table_name, $wpdb);
                }                
                elseif($action == 0 && $snippet_status != 0 ){    /**If its Already InActive, Skip */
                    
                    $status_updated = $this->update_snippet_status($snippet_id, $action, $table_name, $wpdb);
                }
                else{
                    $status_updated = true;
                }
            }

            if( $status_updated ){
                return true;
            }            
        }

        
        /**
         * Change Snippet Status from the Hovering Actions section
         * 
         * @param  Int    $snippet_id     Snippets ID
         * @param  Int    $action         Whether to activate(1) or deactivate(0)
         *
         * @return Int|Bool
         */
        private function update_snippet_status($snippet_id, $action, $table_name, $wpdb){
            
            $status_updated = $wpdb->update(
                $table_name,
                array(              /**Data to be updated */
                    'snippet_status'        => $action,
                ),
                array(                      /**Where Coulum = ? */
                    'ID'                    => $snippet_id,
                ),
                array(                      /**Data Format, %d or %s */
                    '%d'
                ),
                array(                      /**Where Format, %d or %s */
                    '%d'
                )
            );

            return $status_updated;

        }
        
        
        /**
         * Duplicate Snippet from the Hovering Actions section
         *
         * @return NULL
         */
        public static function duplicate_snippet($snippet_id){

            global $wpdb;
            $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $current_time =  ( current_time( 'mysql' ) );

            $snippet_title = $wpdb->get_var($wpdb->prepare("SELECT snippet_title FROM $table_name WHERE ID = %d", $snippet_id));
            $snippet_title = Edit::number_duplicate_snippet_title($snippet_title);
            $snippet_title = trim($snippet_title);

            $data = $wpdb->query( $wpdb->prepare("INSERT INTO $table_name
                    (snippet_group,
                     snippet_title,
                     snippet_content,
                     snippet_date,
                     snippet_vars,
                     snippet_desc,
                     snippet_status,
                     snippet_shortcode,
                     snippet_php,
                     snippet_wptexturize) 
                     SELECT 
                     snippet_group,
                     '$snippet_title',
                     snippet_content,
                     '$current_time',
                     snippet_vars,
                     snippet_desc,
                     snippet_status,
                     snippet_shortcode,
                     snippet_php,
                     snippet_wptexturize
                     FROM $table_name WHERE ID = %d", $snippet_id) );


            if($data){
                
                $snippet_groups = maybe_unserialize( $wpdb->get_var($wpdb->prepare("SELECT snippet_group FROM $table_name WHERE ID = %d", $wpdb->insert_id)) );

                Edit::change_group_count($snippet_groups, 'increment');

                return true;
            }
            
        }

        /**
         * Process Bulk Action
         *
         * @return NULL
         */
        private function process_bulk_action(){

            $action = $this->current_action();

            if( $action && !empty($_REQUEST['snippets']) && is_array($_REQUEST['snippets']) ){

                check_admin_referer( 'pspro_all_snippets', 'pspro_all_snippets_nonce' );                

                if($action == 'enable'){

                    if( $this->change_snippet_status($_REQUEST['snippets'], 1) ){      //$_REQUEST is taken here directly cuz it will be an array             
                        printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippets Activated', 'post-snippets' ) );
                    }
                    else{
                        printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                    }
                
                }

                elseif ($action == 'disable') {

                    if( $this->change_snippet_status($_REQUEST['snippets'], 0) ){                   
                        printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippets Deactivated', 'post-snippets' ) );
                    }
                    else{
                        printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                    }
                    
                }

            }

        }

        /**
         * Process Bulk Filter
         * 
         *
         * @return NULL
         */
        private function process_bulk_filter($table_name){

            global $wpdb;

            if( isset($_REQUEST['status_filter_action']) ){

                check_admin_referer( 'pspro_all_snippets', 'pspro_all_snippets_nonce' );

                $group_filter = intval( $_REQUEST['group'] ?? 0 );
                $status_filter = intval( $_REQUEST['status'] ?? 0 );

                $wildB = '%\"';
                $wildE = '\"%';
                $find = $group_filter;
                $like = $wildB . $wpdb->esc_like( $find ) . $wildE;

                if($group_filter > 0 && $status_filter >= 0){      //if Both group and Status are selected
                    
                    // return (sprintf( "SELECT * FROM $table_name WHERE snippet_group LIKE '%s' AND snippet_status = $status_filter", $like ) );
                    return $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table_name WHERE snippet_group LIKE '%s' AND snippet_status = $status_filter", $like ), ARRAY_A);

                }

                elseif($status_filter >= 0){
                    
                    // return ( ( "SELECT * FROM $table_name WHERE snippet_status = $status_filter") );
                    return $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table_name WHERE snippet_status = %d", $status_filter), ARRAY_A );

                }

                elseif($group_filter > 0 ){
                    // return (sprintf( "SELECT * FROM $table_name WHERE snippet_group LIKE '%s'", $like ) );
                    return $wpdb->get_results($wpdb->prepare( "SELECT * FROM $table_name WHERE snippet_group LIKE '%s'", $like ), ARRAY_A );
                }

                else{                    
                    // return "SELECT * FROM $table_name";                
                    return $wpdb->get_results($wpdb->prepare("SELECT * FROM %1s", $table_name), ARRAY_A);                
                }
            }
            else{
                // return "SELECT * FROM $table_name";     //Get all Snippets
                return $wpdb->get_results($wpdb->prepare("SELECT * FROM %1s", $table_name), ARRAY_A);     //Get all Snippets
            }
        }



        /**
         * Process Bulk Download
         * 
         *
         * @return NULL
         */
        private function process_bulk_download(){

            if( isset($_REQUEST['psp_download_selected']) && isset($_REQUEST['snippets']) && is_array($_REQUEST['snippets']) && !empty($_REQUEST['snippets']) ){

                check_admin_referer( 'pspro_all_snippets', 'pspro_all_snippets_nonce' );

                $snippets_ids = $_REQUEST['snippets'];

                $snippets_ids = implode(',', $snippets_ids);

                $snippets_ids = "($snippets_ids)";

                $ie = new ImportExport();

                $download_succeed = $ie->exportSnippets($snippets_ids);

                if($download_succeed){
                    printf('<div class="notice notice-success is-dismissible"><p>%s..</p></div>', esc_html__( 'Snippets Downloaded', 'post-snippets' ) );
                }
                else{
                    printf('<div class="notice notice-error is-dismissible"><p>%s..</p></div>', esc_html__( 'There has been an Error', 'post-snippets' ) );
                }
            }
        }
        
        
        /**
         * Process Bulk Upload
         * 
         *
         * @return NULL
         */
        private function process_bulk_upload(){

            if( isset($_REQUEST['psp_upload_selected']) && isset($_REQUEST['snippets']) && is_array($_REQUEST['snippets']) && !empty($_REQUEST['snippets']) ){

                check_admin_referer( 'pspro_all_snippets', 'pspro_all_snippets_nonce' );
            
            }
        }

        public static function get_all_snippets_gutenberg(){
    
            global $wpdb;
    
            $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;
    
            $all_snippets = $wpdb->get_results($wpdb->prepare("SELECT ID, snippet_title, snippet_vars FROM $table_name WHERE snippet_status = %d AND snippet_php != %d AND snippet_php != %d", 1, 2, 3), ARRAY_A );
    
            if( !empty($all_snippets) ){
    
                $snippet_list = array();
                foreach($all_snippets as $snippet){
                    if( array_key_exists("ID", $snippet) && array_key_exists("snippet_title", $snippet)){
                        $snippet_list[$snippet["ID"]] = 
                            array(
                            'snippet_title' => $snippet["snippet_title"],
                            'snippet_vars'  => Shortcode::filterVars($snippet["snippet_vars"])                        
                        );
                    }
                }

                return rest_ensure_response($snippet_list);            
            }
    
            return rest_ensure_response(array());
    
        }

        public static function render_block_content($attributes){

            if( empty($attributes) ){
                return;
            }

            global $wpdb;
            $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;
            $atts = array();
            $snippet = '';

            //Backward Compatibility, getting Snippet ID From Name
            if( !isset($attributes["snippetID"]) && isset($attributes["snippet"]) ){
                
                $particular_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title = %s AND snippet_status = 1", $attributes["snippet"] ), ARRAY_A );

                if( !empty($particular_snippets) ){
                    
                    $snippet = array();
                    foreach($particular_snippets as $particular_snippet){   /**Multiple Snippets of Similar Name (Case Sensitive) */

                        if( strcmp($particular_snippet['snippet_title'], $attributes["snippet"] ) == 0  && !empty($particular_snippet) ){
                            $snippet = $particular_snippet;
                            if(isset($attributes['vars']) && !empty($attributes['vars']) )  {
                                //for backward compatibility for variables
                                $atts_value = explode("=",$attributes['vars']);
                                if( isset($atts_value[0]) && isset($atts_value[1])) {
                                    $atts[$atts_value[0]] = $atts_value[1];
                                }
                            }
                            break;
                        }
                    }
                }
            }
            elseif( isset($attributes["snippetID"]) && is_numeric( $attributes["snippetID"] ) ){

                $snippet_id = intval( $attributes["snippetID"] );

                $snippet = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d AND snippet_status = 1", $snippet_id), ARRAY_A );

                if( !empty($snippet) ){
                    $snippet = $snippet[0];
                }

                $atts = $attributes["snippetVars"];

                if( !empty($atts) || is_array($atts) ){     /**Removing Empty Arrays, so that they get default Vals(snippet_vars) */
                    foreach($atts as $key=>$att) {
                        if( empty($att) ){
                            unset( $atts[$key] );
                        }
                    }
                }

            }
            else{
                return;
            }

            return Shortcode::evaluateSnippet( $snippet, $atts );

        }

        public static function get_all_snippets_rest(){

            global $wpdb;
    
            $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;
    
            $all_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM %1s", $table_name), ARRAY_A );
    
            if( !empty($all_snippets) ){

                foreach ($all_snippets as $snippet) {

                    $all_snippets_backward[] = array(
                        
                        'title'       => $snippet['snippet_title'],
                        'vars'        => $snippet['snippet_vars'],
                        'description' => $snippet['snippet_desc'],
                        'shortcode'   => $snippet['snippet_shortcode'],
                        'php'         => $snippet['snippet_php'],
                        'wptexturize' => $snippet['snippet_wptexturize'],
                        'snippet'     => $snippet['snippet_content'],
                        'ID'          => $snippet['ID'],
                        'status'      => $snippet['snippet_status'],
                        'group'       => $snippet['snippet_group'],
                        'date'        => $snippet['snippet_date'], 

                    );

                }

                return rest_ensure_response($all_snippets_backward);
            
            }
    
            return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Not Found.', 'post-snippets') ) );
    
        }
        
        
        public static function get_particular_snippets_rest($snippet_title){

            if( !empty($snippet_title) ){

                global $wpdb;
        
                $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;

                $wild = '%';
                $find = $snippet_title;
                $snippet_title_like = $wild . $wpdb->esc_like( $find ) . $wild;
        
                $particular_snippets_all = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title LIKE %s", $snippet_title_like), ARRAY_A );

                foreach($particular_snippets_all as $particular_snippets) {
                
                    if( strcmp($particular_snippets['snippet_title'], $snippet_title) == 0 && !empty($particular_snippets) ){

                        $particular_snippet['title']        = $particular_snippets['snippet_title'];
                        $particular_snippet['vars']         = $particular_snippets['snippet_vars'];
                        $particular_snippet['description']  = $particular_snippets['snippet_desc'];
                        $particular_snippet['shortcode']    = $particular_snippets['snippet_shortcode'];
                        $particular_snippet['php']          = $particular_snippets['snippet_php'];
                        $particular_snippet['wptexturize']  = $particular_snippets['snippet_wptexturize'];
                        $particular_snippet['snippet']      = $particular_snippets['snippet_content'];
                        $particular_snippet['ID']           = $particular_snippets['ID'];
                        $particular_snippet['status']       = $particular_snippets['snippet_status'];
                        $particular_snippet['group']        = $particular_snippets['snippet_group'];
                        $particular_snippet['date']         = $particular_snippets['snippet_date'];

                        return rest_ensure_response($particular_snippet);
                    
                    }
                }
        
                return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Not Found.', 'post-snippets') ) );
            }

            else{

                return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Title Required.', 'post-snippets') ) );

            }
    
        }
        
        
        
        public static function delete_snippets_rest($snippet_titles){

            if( !empty($snippet_titles) ){

                global $wpdb;
                $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

                $snippet_titles = explode(",", $snippet_titles);

                $snippet_deleted = false;

                foreach ($snippet_titles as $snippet_title){

                    $wild = '%';
                    $find = $snippet_title;
                    $snippet_title_like = $wild . $wpdb->esc_like( $find ) . $wild;
            
                    $particular_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title LIKE %s", $snippet_title_like), ARRAY_A );

                    foreach($particular_snippets as $particular_snippet){

                        if( strcmp($particular_snippet['snippet_title'], $snippet_title) == 0 && !empty($particular_snippet) ){

                            $snippet_groups = maybe_unserialize( $particular_snippet['snippet_group'] );

                            $snippet_deleted = $wpdb->delete( $table_name, array('ID' => $particular_snippet['ID'] ), array('%d') );
                        
                            if( $snippet_deleted ){
        
                                if( !empty($snippet_groups) ){  /**It should have atleast one group, the default group, but just in case */
        
                                    Edit::change_group_count($snippet_groups, 'decrement');
        
                                }
                            }
                        }
                    }
                    
                }

                if($snippet_deleted){
                    return rest_ensure_response( array( 'success' => true, 'message' => __('Snippet Successfully Deleted.', 'post-snippets') ) );
                }
                else{
                    return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Not Found.', 'post-snippets') ) );
                }
            }

            else{
                return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Title Required', 'post-snippets') ) );
            }
    
        }


        public static function create_snippet_rest($request){

            global $wpdb;
            $table_name     = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            
            $upgrouped_id   = $wpdb->get_var( $wpdb->prepare("SELECT ID FROM ".$wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME." WHERE group_slug = %s", __('ungrouped','post-snippets') ) );               
            $group_list     = array($upgrouped_id);
            
            
            $snippet_title  = $request['title'];
            $pattern        = '/[\s]/i';   /**remove any WhiteSpaces */
            $replacement    = '';
            $snippet_title  =  preg_replace($pattern, $replacement, $snippet_title);
            $snippet_title  = sanitize_text_field($snippet_title);
            
            $current_snippets_titles    = $wpdb->get_results($wpdb->prepare("SELECT snippet_title from %1s", $table_name ), ARRAY_A );
            $current_snippets_titles    = array_column($current_snippets_titles, "snippet_title");
            if( in_array($snippet_title,  $current_snippets_titles) ){
                //duplicate according to settings
                return rest_ensure_response( array( 'success' => false, 'message' => __('Duplicate Titles are currently not allowed.', 'post-snippets') ) );

                $snippet_added = true;
            }

            $snippet_added = $wpdb->insert( 
                $table_name,
                array(
                    'snippet_group'         => maybe_serialize( $group_list ),
                    'snippet_title'         => $snippet_title,
                    'snippet_content'       => addslashes( $request['snippet_code'] ),
                    'snippet_date'          => current_time( 'mysql' ),
                    'snippet_vars'          => $request['vars'],    /**already filtered in rest parameters */
                    'snippet_desc'          => sanitize_textarea_field( $request['description'] ),
                    'snippet_status'        => 1,
                    'snippet_shortcode'     => $request['shortcode'],
                    'snippet_php'           => $request['php'],
                    'snippet_wptexturize'   => $request['wptexturize'],
                ) 
            );

            if($snippet_added){

                return rest_ensure_response( array( 'success' => true, 'message' => __('Snippet Successfully Added.', 'post-snippets') ) );

            }
            else{
                return rest_ensure_response( array( 'success' => false, 'message' => __('Could not Add Snippet.', 'post-snippets') ) );
            }



        }
        
        
        public static function update_snippet_rest($request){

            global $wpdb;
            $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $wild = '%';
            $find = $request['title'];
            $snippet_title_like = $wild . $wpdb->esc_like( $find ) . $wild;
    
            $particular_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title LIKE %s", $snippet_title_like), ARRAY_A );

            if( empty($particular_snippets) ){
                return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Not Found.', 'post-snippets') ) );
            }

            foreach ($particular_snippets as $particular_snippet) {

                if( strcmp($particular_snippet['snippet_title'], $request['title']) == 0 && !empty($particular_snippet) ){
                    $snippet_found = $particular_snippet;
                }
                else{
                    return rest_ensure_response( array( 'success' => false, 'message' => __('Snippet Not Found.', 'post-snippets') ) );
                }

            }

            $snippet_updated = $wpdb->update(
                $table_name,
                array(
                    // 'snippet_group'         => maybe_serialize( $group_list ),
                    // 'snippet_title'         => $snippet_title,
                    // 'snippet_status'        => $request['snippet_status']      ?? 0,     //Disable by default
                    'snippet_content'       => addslashes( $request['snippet_code'] ),
                    'snippet_date'          => current_time( 'mysql' ),
                    'snippet_vars'          => $request['vars'],
                    'snippet_desc'          => sanitize_textarea_field( $request['description'] ),
                    'snippet_shortcode'     => $request['shortcode']   ?? 0,
                    'snippet_php'           => $request['php']         ?? 0,
                    'snippet_wptexturize'   => $request['wptexturize'] ?? 0,
                ),
                array(                      /**Where Coulum = ? */
                    'ID'                    => $snippet_found['ID'],
                ),
                array(                      /**Data Format, %d or %s */
                    /*'%s', '%s', '%d',*/ '%s', '%s', '%s', '%s', '%d', '%d', '%d'
                ),
                array(                      /**Where Format, %d or %s */
                    '%d'
                )
            );


            if($snippet_updated){

                return rest_ensure_response( array( 'success' => true, 'message' => __('Snippet Successfully Updated.', 'post-snippets') ) );

            }
            else{
                return rest_ensure_response( array( 'success' => false, 'message' => __('Could not Update Snippet.', 'post-snippets') ) );
            }
        }

        public static function get_snippet_php($php){

            if( empty($php) ){
                return 0;
            }

            if( in_array($php, array(0, 1, 2, 3) ) ){
                return $php;
            }

            return 0;

        }



        public static function run_snippets($snippets){

            if( empty($snippets) ){
                return;
            }

            $script_pattern = "/\<script[\w\s]*\>/i";
            $style_pattern  = "/\<style[\w\s]*\>/i";

            foreach ($snippets as $snippet) {
                
                if( $snippet['snippet_php'] == 2 && !empty( $snippet['snippet_content'] ) ){
                    $snippet_content = stripslashes($snippet['snippet_content']);

                    $tag_exists = preg_match($script_pattern, $snippet_content);

                    if(!$tag_exists){

                        ?>

                            <script><?php echo $snippet_content; ?></script>

                        <?php
                    }else{
                        echo $snippet_content;
                    }
                }
                
                elseif( $snippet['snippet_php'] == 3 && !empty( $snippet['snippet_content'] ) ){
                    $snippet_content = stripslashes($snippet['snippet_content']);
                   // $snippet_content = wp_kses($snippet_content, array( 'style' => array() ));
                    $tag_exists = preg_match($style_pattern, $snippet_content);
                    
                    if(!$tag_exists){

                        ?>

                            <style><?php echo $snippet_content; ?></style>

                        <?php
                    }else{
                        echo $snippet_content;
                    }
                }

            }


        }

        public static function run_admin_js_css(){

            if( wp_doing_ajax() || isset( $_REQUEST['_fs_blog_admin'] ) ){
                return true;
            }

            global $wpdb;
            $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            if( is_admin() ){

                $wild = '%';
                $find = 'admin';
                $snippet_var_like = $wild . $wpdb->esc_like( $find ) . $wild;

                $snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE (snippet_php = %d OR snippet_php = %d) AND snippet_vars LIKE %s AND snippet_status = 1", 2, 3, $snippet_var_like), ARRAY_A );
            
            }
            
            if( empty($snippets) || empty( array_filter($snippets) ) ){
                return;
            }

            self::run_snippets($snippets);


        }

        public static function run_frontend_header_js(){

            global $wpdb;
            $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $wild                   = '%';
            $find                   = 'frontend';
            $snippet_var_like       = $wild . $wpdb->esc_like( $find )      . $wild;
            $location_not_like      = 'footer';
            $snippet_var_not_like   = $wild . $wpdb->esc_like( $location_not_like )   . $wild;

            $snippets = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE (snippet_php = %d) AND snippet_status = 1 AND snippet_vars LIKE %s AND snippet_vars NOT LIKE %s", 2, $snippet_var_like, $snippet_var_not_like), ARRAY_A );

            $updated_snippets = self::filter_snippets_for_page($snippets, $location_not_like);

            // echo "<pre>";
            // print_r($updated_snippets);
            // echo "</pre>";

            // die("Debugging");

            self::run_snippets($updated_snippets);
            
        }
        
        public static function run_frontend_footer_js_css(){

            global $wpdb;
            $table_name = $wpdb->prefix.\PostSnippets::TABLE_NAME;

            $wild                   = '%';
            $find                   = 'frontend';
            $snippet_var_like       = $wild . $wpdb->esc_like( $find )      . $wild;
            $location_not_like      = 'header';
            $snippet_var_not_like   = $wild . $wpdb->esc_like( $location_not_like )   . $wild;

            $snippets = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $table_name WHERE (snippet_php = %d OR snippet_php = %d) AND snippet_status = 1 AND snippet_vars LIKE %s AND snippet_vars NOT LIKE %s", 2, 3, $snippet_var_like, $snippet_var_not_like), ARRAY_A );
            
            $updated_snippets = self::filter_snippets_for_page($snippets, $location_not_like);

            // echo "<pre>";
            // print_r($updated_snippets);
            // echo "</pre>";

            // die("Debugging");

            self::run_snippets($updated_snippets);

            
        }


        public static function filter_snippets_for_page($snippets, $location = 'header'){

            if( empty($snippets) ){
                return;
            }

            $updated_snippets = array();
            
            foreach ($snippets as $snippet) {

                $snippets_vars      = Shortcode::filterVars( $snippet["snippet_vars"] );
                $snippets_vars_keys = array_keys($snippets_vars);

                if( in_array($location, $snippets_vars_keys) || !in_array('frontend', $snippets_vars_keys) ){
                    continue;
                }

                if( in_array('all_website', $snippets_vars_keys) ){
                    $updated_snippets[] = $snippet;
                } 

                if( is_front_page() || is_home() ){

                    if( in_array('homepage', $snippets_vars_keys) ){
                        $updated_snippets[] = $snippet;
                    } 
                }
    
                if( is_page() ){
                    if( in_array('all_pages', $snippets_vars_keys) ){
                        $updated_snippets[] = $snippet;
                    } 
                }
                
                if( is_single() ){
                    if( in_array('all_posts', $snippets_vars_keys) ){
                        $updated_snippets[] = $snippet;
                    } 
                }

                if( in_array('specific_page', $snippets_vars_keys) ){

                    $specific_page = $snippets_vars['specific_page']?? '';

                    if( !empty($specific_page) && is_numeric($specific_page) && ( is_page( $specific_page ) || is_single( $specific_page ) ) ){

                        $updated_snippets[] = $snippet;

                    }
                }

            }

            return $updated_snippets;
        }
    }
}