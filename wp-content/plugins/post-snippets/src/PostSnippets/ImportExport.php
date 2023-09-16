<?php
namespace PostSnippets;

/**
 * Post Snippets I/O.
 *
 * Class to handle import and export of Snippets.
 *
 */
class ImportExport
{
    protected static $FILE_ZIP;
    const FILE_CFG = 'post-snippets-export.cfg';

    private $downloadUrl;

    /**
     * Export Snippets.
     *
     * Check if an export file shall be created, or if a download url should be
     * pushed to the footer. Also checks for old export files laying around and
     * deletes them (for security).
     *
     * @return void
     */
    public function exportSnippets($snippets_ids)
    {
        self::set_export_name();

        $url = $this->createExportFile($snippets_ids);
        if ($url) {

            $this->downloadUrl = $url;

            add_action(
                'admin_footer',
                array(&$this, 'psnippetsFooter'),
                10000
            );

            return true;
        } else {
            return false;
        }    
    
    }

    /**
     * Export All Snippets.
     *
     * Check if an export file shall be created, or if a download url should be
     * pushed to the footer. Also checks for old export files laying around and
     * deletes them (for security).
     *
     * @return void
     */
    public function exportAllSnippets()
    {
        self::set_export_name();
        if (isset($_POST['postsnippets_export'])) {
            $url = $this->createExportFile();
            if ($url) {
                $this->downloadUrl = $url;
                add_action(
                    'admin_footer',
                    array(&$this, 'psnippetsFooter'),
                    10000
                );
            } else {
                echo __('Error: ', 'post-snippets').$url;
            }
        } else {
            // Check if there is any old export files to delete
            $dir = wp_upload_dir();
            $upload_dir = $dir['basedir'] . '/';
            chdir($upload_dir);
            if (file_exists('./'.self::$FILE_ZIP)) {
                unlink('./'.self::$FILE_ZIP);
            }
        }
    }

    /**
     * Handles uploading of post snippets archive and import the snippets.
     *
     * @uses   wp_handle_upload() in wp-admin/includes/file.php
     * @return string HTML to handle the import
     */
    public function importSnippets()
    {
        $import =
        '<br/><br/><strong>'.
        __('Import', 'post-snippets').
        '</strong><br/>';
        if (!isset($_FILES['postsnippets_import_file'])
            || empty($_FILES['postsnippets_import_file'])
        ) {
            $import .=
            '<p>'.__('Import snippets from a post-snippets-export.zip file. Imported sinppets will get added at the bottom.', 'post-snippets').
            '</p>';
            $import .=
            '<p>'.__('Please make sure no snippets have duplicate titles.', 'post-snippets').
            '</p>';
            $import .= '<form method="post" enctype="multipart/form-data">';
            $import .= '<input type="file" name="postsnippets_import_file"/>';
            $import .= '<input type="hidden" name="action" value="wp_handle_upload"/>';
            $import .=
            '<input type="submit" class="button" value="'.
            __('Import Snippets', 'post-snippets').'"/>';
            $import .= '</form>';
        } else {

            if (file_exists('./'.self::FILE_CFG)) {    /**Overwriting Existing File */
                unlink('./'.self::FILE_CFG);
            }

            $file = wp_handle_upload($_FILES['postsnippets_import_file']);

            if (isset($file['file']) && !is_wp_error($file)) {
                require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
                $zip = new \PclZip($file['file']);
                $dir = wp_upload_dir();
                $upload_dir = $dir['basedir'] . '/';
                chdir($upload_dir);

                if ($zip->listContent() == 0) {
                    $import .=
                    '<p><strong>'.
                    __('Unsupported File Type:', 'post-snippets').
                    ' '.
                    __('Unzipping failed.', 'post-snippets').
                    '</strong></p>';
                    return $import;
                }

                $unzipped = $zip->extract();

                if ($unzipped[0]['stored_filename'] == self::FILE_CFG
                    && $unzipped[0]['status'] == 'ok'
                    || $unzipped[0]['status'] == 'newer_exist'
                ) {
                    // Delete the uploaded archive
                    unlink($file['file']);

                    $snippets = file_get_contents(
                        $upload_dir.self::FILE_CFG
                    );

                    if ($snippets) {

                        $snippets = apply_filters(
                            'post_snippets_import',
                            $snippets
                        );
                        
                        $imported_snippets = maybe_unserialize($snippets);

                        if( !empty($imported_snippets) ){

                            $import .= $this->importAllSnippets($imported_snippets);
                        }
                        else{
                            $import .=
                            '<p><strong>'.
                            __('Empty Snippets.', 'post-snippets').
                            '</strong></p>'; 
                        }
                    }

                    // Delete the snippet file
                    unlink('./'.self::FILE_CFG);

                } else {
                    $import .=
                    '<p><strong>'.
                    __('Snippets could not be imported:', 'post-snippets').
                    ' '.
                    __('Unzipping failed.', 'post-snippets').
                    '</strong></p>';
                }
            } else {
                if ($file['error'] || is_wp_error($file)) {
                    $import .=
                    '<p><strong>'.
                    __('Snippets could not be imported:', 'post-snippets').
                    ' '.
                    $file['error'].'</strong></p>';
                } else {
                    $import .=
                    '<p><strong>'.
                    __('Snippets could not be imported:', 'post-snippets').
                    ' '.
                    __('Upload failed.', 'post-snippets').
                    '</strong></p>';
                }
            }
        }
        return $import;
    }


    function importAllSnippets($imported_snippets){

        global $wpdb;
        $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;
        $group_table_name   = $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME;
        $snippet_added      = false;

        if( empty( array_column($imported_snippets, 'ID') ) ){  /**Old Exported Files, Backward Compatibility */

            $current_snippets_titles    = $wpdb->get_results($wpdb->prepare("SELECT snippet_title from %1s", $table_name ), ARRAY_A );
            $current_snippets_titles    = array_column($current_snippets_titles, "snippet_title");

            if( !empty($current_snippets_titles) ){     /**If there are any Existing Snippets */

                foreach ($imported_snippets as $imported_snippet) {
                
                    if( in_array($imported_snippet['title'],  $current_snippets_titles) ){
                        //duplicate according to settings
                        $snippet_added = $this->duplicateSnippet($imported_snippet);

                    }
                    else{   /**No Duplicate */
                        DBTable::update_db_table_previous(array($imported_snippet), true);
                        $snippet_added = true;
                    }
                }
            
            }
            else{ /**There aren't any Existing Snippets */
            
                DBTable::update_db_table_previous($imported_snippets, true);
                $snippet_added = true;

            }

            if($snippet_added){
                return
                    '<p><strong>'.
                    __('Snippets Added Successfully.', 'post-snippets').
                    '</strong></p>'; 
            }else{
                return
                    '<p><strong>'.
                    __('Snippets Not Added.', 'post-snippets').
                    '</strong></p>';
            }

        }

        $current_snippets_titles    = $wpdb->get_results($wpdb->prepare("SELECT snippet_title from %1s", $table_name ), ARRAY_A );
        $imported_snippets_titles   = array_column($imported_snippets, 'snippet_title');
        $current_snippets_titles    = array_column($current_snippets_titles, "snippet_title");

        $group_details  = $imported_snippets['group_details']?? array();

        if( !empty($group_details) ){
            unset($imported_snippets['group_details']);
        }
        
        if( !empty($current_snippets_titles) ){     /**If there are any Existing Snippets */

            foreach ($imported_snippets as $imported_snippet) {
            
                if( in_array($imported_snippet['snippet_title'],  $current_snippets_titles) ){
                    //duplicate according to settings
                    $imported_snippet   = $this->updateGroupDetails($imported_snippet, $group_details);
                    $snippet_added      = $this->duplicateSnippet($imported_snippet);
                }

                else{   /**No Duplicate */

                    $imported_snippet   = $this->updateGroupDetails($imported_snippet, $group_details);
                    $snippet_added      = Edit::addImportedSnippet($imported_snippet);

                }
            }
        }

        else{ /**There aren't any Existing Snippets */

            foreach ($imported_snippets as $imported_snippet) {

                $imported_snippet   = $this->updateGroupDetails($imported_snippet, $group_details);
                $snippet_added      = Edit::addImportedSnippet($imported_snippet);

            }            
        }

        if($snippet_added){

            return            
                '<p><strong>'.
                __('Snippets Added Successfully.', 'post-snippets').
                '</strong></p>';

        }
        else{
            return            
                '<p><strong>'.
                __('Snippets Not Added.', 'post-snippets').
                '</strong></p>';

        }
    }

    public function duplicateSnippet($imported_snippet){

        $duplicate_option = get_option(\PostSnippets::SETTINGS);

        if( !isset( $duplicate_option['duplicate_option'] ) ){
            return true;    /**If duplicate option doesn't exist.. maybe due to version difference */
        }

        if( $duplicate_option['duplicate_option'] == 'allow_duplicate' ){

            if( isset($imported_snippet['ID']) ){   /**Revamped Version */
                $imported_snippet['snippet_title'] = Edit::number_duplicate_snippet_title( $imported_snippet['snippet_title'] );
                return Edit::addImportedSnippet($imported_snippet);
            }
            else{   /**Old Version, without ID */
                $imported_snippet["title"] = Edit::number_duplicate_snippet_title( $imported_snippet["title"] );
                DBTable::update_db_table_previous(array($imported_snippet), true);
                return true;
            }
        }
        
        if( $duplicate_option['duplicate_option'] == 'replace_duplicate' ){

            return $this->replaceSnippet($imported_snippet);

        }
        
        if( $duplicate_option['duplicate_option'] == 'skip_duplicate' ){
            return true;
        }

        return true;

    }

    public function replaceSnippet($imported_snippet){

        global $wpdb;
        $table_name = $wpdb->prefix . \PostSnippets::TABLE_NAME;
        $table_name_group = $wpdb->prefix . \PostSnippets::GROUP_TABLE_NAME;


        // $wild = '%';
        $find = isset($imported_snippet['ID']) ? $imported_snippet['snippet_title'] : $imported_snippet['title'];
        // $snippet_title_like = $wild . $wpdb->esc_like( $find ) . $wild;

        $particular_snippets = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE snippet_title = %s", $find), ARRAY_A );

        foreach ($particular_snippets as $particular_snippet) { /**DB query may return multiple snippets of same case-insensitive name */

            if( !empty($particular_snippet) && strcmp($particular_snippet['snippet_title'], $find) == 0 ){  /**Filtering case-sensitively, cause DB is insensitive */
                $snippet_found = $particular_snippet;
                break;
            }
            else{
                continue;
            }

        }

        if( isset( $imported_snippet['snippet_group'] ) ){

            /**
             * change group ids, if they are different 
             * from imported
            */

            $current_snippet_group_ids      = $snippet_found['snippet_group'];

            $snippet_group                  = $imported_snippet['snippet_group'];

            $group_ids_to_increase_count    = array_diff( maybe_unserialize( $imported_snippet['snippet_group'] ), maybe_unserialize( $current_snippet_group_ids ) );
            
            $group_ids_to_decrease_count    = array_diff( maybe_unserialize( $current_snippet_group_ids ), maybe_unserialize( $imported_snippet['snippet_group'] ) );

        }

        if( !empty( $snippet_group ) && !is_serialized( $snippet_group ) ){

            $snippet_group = maybe_serialize($snippet_group);

        }

        $snippet_php = PSallSnippets::get_snippet_php( $imported_snippet['snippet_php']?? $imported_snippet['php'] );

        $snippet_updated = $wpdb->update(
            $table_name,
            array(
                'snippet_group'         => $imported_snippet['snippet_group']??         $snippet_found['snippet_group'],
                // 'snippet_title'         => $snippet_title,
                'snippet_content'       => $imported_snippet['snippet_content']??       addslashes( $imported_snippet['snippet'] ),
                'snippet_date'          => current_time( 'mysql' ),
                'snippet_vars'          => $imported_snippet['snippet_vars']??          Edit::filter_snippet_vars( $imported_snippet['vars'] ),
                'snippet_desc'          => $imported_snippet['snippet_desc']??          sanitize_textarea_field( $imported_snippet['description'] ),
                'snippet_status'        => ( $imported_snippet['snippet_status']??        $snippet_found['snippet_status'] )    == 1 ? 1 : 0,
                'snippet_shortcode'     => ( $imported_snippet['snippet_shortcode']??     $imported_snippet['shortcode'] )      == 1 ? 1 : 0,
                'snippet_php'           => $snippet_php,
                'snippet_wptexturize'   => ( $imported_snippet['snippet_wptexturize']??   $imported_snippet['wptexturize'] )    == 1 ? 1 : 0,
            ),
            array(                      /**Where Coulum = ? */
                'ID'                    => $snippet_found['ID'],
            ),
            array(                      /**Data Format, %d or %s */
                '%s', /*'%s',*/ '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d'
            ),
            array(                      /**Where Format, %d or %s */
                '%d'
            )
        );

        if($snippet_updated){

            if( isset($group_ids_to_increase_count) && !empty($group_ids_to_increase_count) ){

                Edit::change_group_count($group_ids_to_increase_count, 'increment');
            }
            
            if( isset($group_ids_to_decrease_count) && !empty($group_ids_to_decrease_count) ){

                Edit::change_group_count($group_ids_to_decrease_count, 'decrement');
            }

            return true;
        }

    }

    public function updateGroupDetails($imported_snippet, $group_details){

        global $wpdb;
        $group_table_name   = $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME;

        $group_ids          = maybe_unserialize( $imported_snippet['snippet_group'] );

        $all_group_ids      = array_column($group_details, 'ID');

        foreach ($group_ids as $key => $group_id) {     /**Getting groups who has same group ID as in exported snippet_groups */

            $group_details[$key] = $group_details[ array_search($group_id, $all_group_ids, true) ];

        }


        foreach ($group_details as $group) {    /**getting group IDs from group DB by slug, if exists, else creating new group */

            $group_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $group_table_name WHERE group_slug = %s", $group['group_slug'] ) );

            if($group_id == NULL){

                $group_added_status = $wpdb->insert(
                    $group_table_name, 
                    array( 
                        'group_name'    => $group['group_name'],
                        'group_slug'    => $group['group_slug'],
                        'group_desc'    => $group['group_desc'],
                        'group_count'   => 0
                    ) 
                );

                $imported_snippet = $this->changeGroupId($imported_snippet, $group['ID'], $wpdb->insert_id);
            }
            else{

                $imported_snippet = $this->changeGroupId($imported_snippet, $group['ID'], $group_id);

            }
        }      
 
        return $imported_snippet;
    }

    private function changeGroupId($imported_snippet, $old_id, $new_id){

        $imported_snippet_groups = maybe_unserialize( $imported_snippet['snippet_group'] );
        
        if( in_array($old_id, $imported_snippet_groups, true) && ( $old_id != $new_id) ){

            $imported_snippet_groups[ array_search($old_id, $imported_snippet_groups, true) ] = strval( $new_id );

            $imported_snippet['snippet_group'] = maybe_serialize( $imported_snippet_groups  );

        }

        return $imported_snippet;
    }

    /**
     * Create a zipped filed containing all Post Snippets, for export.
     *
     * @return string URL to the exported snippets
     */
    private function createExportFile($snippets_ids = '')
    {
        $dir = wp_upload_dir();
        $upload_dir = $dir['basedir'] . '/';
        $upload_url = $dir['baseurl'] . '/';        

        global $wpdb;

        $table_name         = $wpdb->prefix.\PostSnippets::TABLE_NAME;

        if( empty($snippets_ids) ){

            $snippets = $wpdb->get_results($wpdb->prepare("SELECT * from %1s", $table_name ), ARRAY_A );

        }else{
            
            $snippets = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name WHERE ID IN %1s", $snippets_ids ), ARRAY_A );
        }

        $snippets = $this->addGroupDetails($snippets);

        $snippets = maybe_serialize( $snippets );
        
        $snippets = apply_filters('post_snippets_export', $snippets);


        // Open a file stream and write the serialized options to it.
        if (!$handle = fopen($upload_dir.'./'.self::FILE_CFG, 'w')) {
            die();
        }
        if (!fwrite($handle, $snippets)) {
            die();
        }
        fclose($handle);

        // Create a zip archive
        require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
        chdir($upload_dir);
        $zip = new \PclZip('./'.self::$FILE_ZIP);
        $zipped = $zip->create('./'.self::FILE_CFG);

        // Delete the snippet file
        unlink('./'.self::FILE_CFG);

        if (!$zipped) {
            return false;
        }

        return $upload_url.'./'.self::$FILE_ZIP;
    }

    private function addGroupDetails($snippets){

        global $wpdb;

        $table_name     = $wpdb->prefix.\PostSnippets::GROUP_TABLE_NAME;

        $group_details  = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name WHERE group_count > %d", 0 ), ARRAY_A );

        $snippets['group_details'] = $group_details;

        return $snippets;        
    }

    /**
     * Set export file name
     */
    public static function set_export_name(){
        $date_part = date('Y-m-d');
        self::$FILE_ZIP =  "post-snippets-export-{$date_part}.zip";
    }

    /**
     * Generates the javascript to trigger the download of the file.
     *
     * @return void
     */
    public function psnippetsFooter()
    {
        $export = '<script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            document.location = \''.$this->downloadUrl.'\';
                        });
                   </script>';
        echo $export;
    }
}
