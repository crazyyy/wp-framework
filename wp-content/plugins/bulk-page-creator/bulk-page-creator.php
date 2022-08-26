<?php
/*
Plugin Name: Bulk Page Creator
Plugin URI: https://solid-code.co.uk/
Description: Allows you to create multiple pages in a batch/bulk manner saving time when initially setting up your WordPress site.
Version: 1.1.4
Author: Dagan Lev
Author URI: https://solid-code.co.uk

Copyright 2011 Solid Code  (email : dagan@solid-code.co.uk)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit('no access'); // disable direct access
}

if (!class_exists("sc_bulk_page_creator")) {
	class sc_bulk_page_creator{
		//Empty class
	}
	
	//initialize the class to a variable
	$sc_bpc_var = new sc_bulk_page_creator();
	
	//Actions and Filters	
	if (isset($sc_bpc_var)) {
		//Add Actions
		add_action('admin_menu', 'sc_bpc_page');
		if(isset($_GET['page'])&&$_GET['page']=='sc_bpc_page'){
			add_action('admin_print_scripts', 'sc_bpc_scripts');
			add_action('admin_print_styles', 'sc_bpc_styles');
		}
	}
	
	function sc_bpc_page(){
		//add the options page for this plugin
		add_options_page('Bulk Page Creator','Bulk Page Creator','manage_options','sc_bpc_page','sc_bpc_page_create');
	}
	
	function sc_bpc_scripts(){
		wp_register_script('sc-bpc-js', plugins_url('my-script.js', __FILE__), array('jquery'));
		wp_enqueue_script('sc-bpc-js');
	}
	
	function sc_bpc_styles(){
		wp_register_style('sc-bpc-css',plugins_url('my-style.css', __FILE__));
		wp_enqueue_style('sc-bpc-css');
	}
	
	function sc_bpc_page_create(){
		if(!current_user_can('manage_options')) exit('Restricted');

		if(isset($_POST['sc-pages'])&&$_POST['sc-pages']!=''){
			
			check_admin_referer('sc-bulkpagecreator'); //check nonce

			//form submitted
			if(preg_match_all('/(\d+\|(-|new)?\d+\|[^\|]*\|[^\n]*)/',$_POST['sc-pages'],$match_pg)){
				$newpage = array();
				foreach($match_pg[0] as $pg_res){
					if(preg_match('/((\d+)\|((-|new)?\d+)\|([^\|]*)\|(.*))/',$pg_res,$rres)){
						$parent = -1;
						if($rres[4]=='new'){
							$parent = $newpage[str_ireplace('new','',$rres[3])];
						}else{
							$parent = $rres[3];
						}
						if($parent==-1) $parent = 0;
						
						$pcontent = '';
						if($_POST['pcontent']=='2'){
							$pcontent = str_ireplace('[pagetitle]','<h1>' . sanitize_text_field(htmlentities($rres[5])) . '</h1>',sanitize_textarea_field($_POST['sc-pages-content']));
						}
						
						//sanitize type
						$posttype = 'publish';
						if(isset($_POST['posttype']) && preg_match('#^(draft|publish)$#', $_POST['posttype'])){
							$posttype = $_POST['posttype'];
						}

						$params = array( 
							'post_type' => 'page',
							'post_status' => $posttype,
							'post_parent' => $parent,
							'post_title' => sanitize_text_field(rtrim($rres[5])),
							'page_template' => sanitize_text_field(rtrim($rres[6])),
							'post_content' => $pcontent);
						
						global $wpdb;
						$params['menu_order'] = $wpdb->get_var("SELECT MAX(menu_order)+1 AS menu_order FROM {$wpdb->posts} WHERE post_type='page'");
						$wpdb->flush();

						$newpage[$rres[2]] = wp_insert_post($params);
					}
				}
				
				echo '<script type="text/javascript">window.location=\'options-general.php?page=sc_bpc_page&saved=1\';</script>';
			}
		}
		?>
		<div class="wrap" id="sc-bpc-div">
			<?php if(isset($_GET['saved']) && $_GET['saved']=='1'){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>
			<?php } ?>
			<h2>Bulk Page Creator</h2>
			<p>Use the form below to add pages to the site, you can also remove pages you added and eventually just click on "Update Site" to bulk execute and create all pages on site.</p>
			<h3>Site Pages</h3>
			<ul class="sc-pages">
			<?php
				echo preg_replace('/<a[^>]*>([^<]*)<\/a>/','\\1',wp_list_pages('title_li=&echo=0&post_status=draft,publish'));
			?>
			</ul>
			<h3>Add pages</h3>
			<p>
			<input type="checkbox" id="multiPages" name="multiPages" checked="checked" /> Multiple Pages mode<br />
			<small>allows you to create multiple pages by seperating them with a comma; I.E. test1,test2,test3 - will create three pages (do not leave any spaces).</small>
			</p>
			<?php $templates = get_page_templates(); ?>
			<table>
				<tr>
					<td>Page Name</td>
					<td>Parent</td>
					<?php echo($templates ? '<td>Template</td>' : ''); ?>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><input size="50" type="text" id="sc-page-name" name="sc-page-name" /></td>
					<td id="page_ids">
						<?php wp_dropdown_pages('sort_column=menu_order&post_status=draft,publish&show_option_none=(No Parent)'); ?>
					</td>
					<?php
						if($templates){
							echo '<td>
								<select id="page_template" name="page_template">
									<option value="">Default</option>';
							foreach ( $templates as $template_name => $template_filename ) {
								echo "<option value=\"$template_filename\">$template_name</option>";
							}
							echo '</select></td>';
						}
					?>
					<td><input onclick="sc_add_page();" type="button" class="button-secondary" value="Add Page" /></td>
				</tr>
			</table>
			
			<form id="sc-add-pages" name="sc-add-pages" method="post" action="?page=sc_bpc_page">
				<?php wp_nonce_field( 'sc-bulkpagecreator' ); ?>
				<textarea id="sc-pages" name="sc-pages" style="display:none;"></textarea>
				<p>When you are ready to commit your changes to the site just click the button below...</p>
				<select id="pcontent" name="pcontent">
					<option value="1">Create Empty Pages</option>
					<option value="2">Set Pages Content</option>
				</select><br /><br />
				Pages Status: <select id="posttype" name="posttype">
					<option value="publish">published</option>
					<option value="draft">draft</option>
				</select><br /><br />
				<div id="sc-pages-content-div" style="display:none;">
					<p>
						You can specify default content for all the pages in the text area below.<br />
						You can also use the [pagetitle] short code to add a H1 (header) tag with the individual page title...
					</p>
					<textarea cols="60" rows="5" id="sc-pages-content" name="sc-pages-content"></textarea><br /><br />
				</div>
				<input type="submit" class="button-primary" value="Update Site" />
			</form>
		</div>
		<input type="hidden" id="pagesDraft" name="pagesDraft" value="<?php
					$tmpDrafts = '';
					$drafts = get_pages('post_status=draft&post_type=page&hierarchical=0');
					foreach($drafts as $draft){
						if($tmpDrafts==''){
							$tmpDrafts = $draft->ID;
						}else{
							$tmpDrafts .= ',' . $draft->ID;
						}
					}
					echo $tmpDrafts;
		?>" />
		<?php
	}
}
?>