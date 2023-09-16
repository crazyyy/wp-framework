<?php
/**
 * @return  gutenbergBlocks
 * removing post-snippet-block from gutenberg Editor for custom post type when exclude form custom editor is unchecked.
 * @since post-snippet 4.0
 */
function ps_block_remove_from_gutenbergEditor( $allowed_blocks, $editor_context ) {
    
   
        $blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
        unset($blocks['greentreelabs/post-snippets-block']);
 
        return array_keys( $blocks );
    
}


add_filter('post_snippets_snippets_list','remove_inActiveSnippets');

function remove_inActiveSnippets($snippets) {
	$active_snippets = array();
	foreach($snippets as $key => $snippet) {
		
	        if($snippet['snippet_status']==true) {
				
			array_push($active_snippets, $snippets[$key]);

		}
	}
	
	return $active_snippets;

}

// Adding the ps update notification
add_action('admin_notices', 'ps_plugin_update_notification');
function ps_plugin_update_notification() {
	$ps_prvious_version = 'https://downloads.wordpress.org/plugin/post-snippets.3.1.7.zip';
    if ( is_admin() ) {
		
		if(isset($_REQUEST['ps_update_msg']) && !empty($_REQUEST['ps_update_msg'])) {
		  update_option('ps_update_msg', 'dismissed');
		}

		if(empty(get_option('ps_update_msg')) || 'dismissed' != get_option('ps_update_msg')) {

			echo '<div style = "background-color:#CFD2CF; color:black" class="notice notice-success">
					<p>Thank you to updating Post Snippets v 4.0, we have recoded the entire plugin please check your all snippets if there is any issue you can download the previous version from <a href='."$ps_prvious_version".' style="color:blue"> here </a></p>
					<form action="" method="post">
						<input type="submit" name="ps_update_msg" value="dismiss"> 
					</form>
				  </div>';
		}
	}
}