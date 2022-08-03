<?php 
/*
Plugin Name: Theme Inspector
Plugin URI: https://wordpress.org/plugins/theme-inspector
Description:  Displays useful technical information on pages and posts to aid in developing WordPress Classic Themes. Only visible to administrators via the Admin Toolbar.
Author: Melissa Cabral
Version: 4.0.0
Author URI: http://melissacabral.com/
*/
/**
 * Configure: Debug mode will show ALL the $GLOBALS at the bottom of the page
 * @since ver 3.0.3
 */
define('ADMINHELPER_DEBUG_MODE', false);
/**
 * Display Theme Inspector as Toolbar (Admin Bar) Item
 * @since ver 2.0
 */
add_action( 'admin_bar_menu', 'mmc_toolbar_link', 999 );
function mmc_toolbar_link( $wp_admin_bar ) {	
	if (current_user_can('install_themes') && !is_admin()) {
		$html = mmc_generate_output();
		$args = array(
			'id'    => 'theme-helper',
			'title' => 'Theme Inspector',
			'parent' => 'top-secondary',		
			'meta'  => array( 
				'class' => 'theme-helper',
				'html' => $html,
				),
			);
		$wp_admin_bar->add_node( $args );
	}
}
/**
 * function to generate output HTML
 * @since 1.0
 */
function mmc_generate_output(){		
	//make sure user is logged in
	if (current_user_can('install_themes')) {
		global $post;
		//begin Table Output
		ob_start();
		?>
		<!-- WordPress Theme Inspector by Melissa Cabral-->
		<div id="theme-helper-toolbar">
			<table>
				<?php if(is_admin()){ ?>
				<tr>					
					<td colspan="2"><a style="text-align:center" href="<?php echo home_url('/'); ?>">View your site to see Theme Inspector in action!</a></td>
				</tr>
				<?php }else{  ?>
				<tr>
					<th>Content Type:</th>
					<td><?php echo adminhelper_content_type()?></td>
				</tr>
				<?php if(is_singular()){ ?>
				<tr>
					<th>Post ID:</th>
					<td><?php echo adminhelper_post_id()?></td>
				</tr>
				<?php }	?>
				<tr>
					<th>True Condition(s):</th>
					<td><?php echo adminhelper_true_conditions()?></td>
				</tr>
				<?php if( !is_404() && ! is_search() &&  get_post_type() ) { ?>
				<tr>
					<th>Post Type:</th>
					<td><?php  echo  get_post_type();  ?></td>
				</tr>
				<?php } ?>
				<?php 
				if( is_category() || is_tax() || is_tag() ){ ?>
				<tr>
					<th>Taxonomy:</th>
					<td><?php 
						echo adminhelper_taxonomy()?>
					</td>
				</tr>
				<?php }		?>			
				<?php
				if (isset($post->ID) && is_page() ) {
				?>				
				<tr>
					<th>Order:</th>
					<td><?php echo $post->menu_order ?></td>
				</tr>		
				<?php 
				}	
				?>
			<tr class="file-loaded">
				<th>Template File Loaded:</th>
				<td>
					<?php echo adminhelper_get_current_template() ?>
					<a href="javascript:;" title="<?php echo adminhelper_get_template_path(); ?>">[Source]</a>  						
				</td>
			</tr>
			<?php if( adminhelper_special_cases() ){				
			?>
			<tr class="special-cases">				
				<td colspan="2">
					<?php echo adminhelper_special_cases(); ?>						
				</td>
			</tr>
			<?php } //end special cases ?>				
			<tr>
				<td colspan="2" class="hierarchy">
				<i>Template Hierarchy for this screen:</i><br>
				<?php echo adminhelper_hierarchy()?>
				</td>
			</tr>
			<?php } //end not admin ?>
			<tr class="credits">
				<td colspan="2">Theme Inspector Plugin by <a href="https://wordpress.org/plugins/theme-inspector">Melissa Cabral</a>.</td>
			</tr>
			<tr class="credits usewith">
				<td colspan="2">Use with the WordPress <a target="_blank" href="https://docs.google.com/drawings/d/1hJ0MpHO3HKBT5KsTpGtc_gDYZ5pi-HyxNcRtmPBBULE">Hierarchy Diagram</a></td>
			</tr>
		</table>
	</div><!-- End Theme Inspector -->
	<?php 	
	return ob_get_clean();			
	} //end is user logged in
}
/**
 * helper functions
 */
function adminhelper_taxonomy(){
	global $post;
	$queried_object = get_queried_object();
	$term_id = $queried_object->term_id;
	$tax_name = $queried_object->taxonomy;
	$term = single_cat_title('', false );
	$output = '';
	$output .= $tax_name .' > ';
	$output .= $term ;					
	$output .= ' (ID: '. $term_id .')'; 
	return $output;
}
function adminhelper_content_type(){
	global $post;
	$output = '';
	if (is_admin()) { $output .= "Admin Panel"; }
	if (is_home()) { $output .= "Home (blog) "; }
	elseif (is_front_page()) { $output .= "Front Page "; }	
	if (is_single()) { $output .= "Single Post "; }
	if (is_page() && !is_front_page()) { $output .= "Page "; }
	if (is_category()) { $output .= "Category "; }
	if (is_tag()) { $output .= "Tag "; }
	if (is_tax()) { $output .= "Taxonomy "; }
	if (is_author()) { $output .= "Author "; }		
	if (is_archive()) { $output .= "Archive "; }
	if (is_date()) { $output .= " - Date "; }
	if (is_year()) { $output .= " (year) "; }
	if (is_month()) { $output .= " (monthly) "; }
	if (is_day()) { $output .= " (daily) "; }
	if (is_time()) { $output .= " (time) "; }		
	if (is_search()) { $output .= "Search "; }
	if (is_404()) { $output .= "404 "; }
	if (is_paged()) { $output .= " (Paged) "; }
	return $output;
}
function adminhelper_post_id(){
	global $post;
	if( isset($post) ){
		$post_id = $post->ID;
	}else{
		$post_id = 'no post defined';
	}
	return $post_id;
}
function adminhelper_true_conditions(){
	global $post;
	$conditions = array();	
	$output = '';
	$count = 0;
	if (is_admin()) { $conditions[] = "is_admin()"; }
	if (is_front_page()) { $conditions[] = "is_front_page()"; }	
	if (is_home()) { $conditions[] = "is_home()"; }	
	if (is_attachment() ){ $conditions[] = "is_attachment()"; }
	if (is_single()) { $conditions[] = "is_single()"; }
	if (is_page()) { $conditions[] = "is_page()"; }
	if (is_singular()) { $conditions[] = "is_singular() "; }
	if (is_category()) { $conditions[] = "is_category()"; }
	if (is_tag()) { $conditions[] = "is_tag()"; }
	if (is_tax()) { $conditions[] = "is_tax()"; }
	if (is_author()) { $conditions[] = "is_author()"; }
	if (is_post_type_archive()){ $conditions[] = "is_post_type_archive()"; }
	if (is_date()) { $conditions[] = "is_date()"; }
	if (is_year()) { $conditions[] = "is_year()"; }
	if (is_month()) { $conditions[] = " is_month()"; }
	if (is_day()) { $conditions[] = " is_day()"; }
	if (is_time()) { $conditions[] = " is_time()"; }	
	if (is_archive()) { $conditions[] = " is_archive() "; }	
	if (is_search()) { $conditions[] = "is_search() "; }
	if (is_404()) { $conditions[] = "is_404() "; }
	if (is_paged()) { $conditions[] = "is_paged() "; }
	foreach($conditions as $condition){
		if($count == 0)
			$output.= '<span class="first condition">'.$condition.'</span>';
		else
			$output.= '<span class="condition">, '.$condition.'</span>';	
		$count ++;
	}	
	return $output;
}
/**
 * Display the current hierarchy chain for this page
 * @return mixed HTML output
 * @since  3.0 Added this functionality
 */
function adminhelper_hierarchy(){
	global $post;
	$output = '';
	$hierarchy = array();
	//current post info
	if (isset($post)){
		$slug = $post->post_name;
		$id = $post->ID;
		$type = get_post_type();	
	}
	if( is_404() ){
		$hierarchy[] = '404.php';
	}elseif( is_search() ){
		$hierarchy[] = 'search.php';
	}elseif( is_front_page() ){ 
		if( is_page() ){
			$hierarchy = array('front-page.php', '<i>custom template</i>', "page-$slug.php",  "page-$id.php", 'page.php', 'singular.php') ;
		}else{
			$hierarchy = array('front-page.php', 'home.php') ;
		}
	}elseif( is_home() ){
		$hierarchy[] = 'home.php';
	}elseif( is_archive() ){
		if( is_author() ){			
			$author_id = $post->post_author;
			$nicename = get_the_author_meta('nicename');
			$hierarchy = array( "author-$nicename.php", "author-$author_id.php", 'author.php' );
		}elseif( is_category() ){
			$cat = get_category( get_query_var( 'cat' ) );
			$cat_slug = $cat->slug;
			$cat_id = $cat->cat_ID;
			$hierarchy = array( "category-$cat_slug.php", "category-$cat_id.php", 'category.php' );
		}elseif(is_tag()){
			$tag = get_queried_object();
   			$tag_slug =  $tag->slug;		
			$tag_id = $tag->term_id;
			$hierarchy = array( "tag-$tag_slug.php", "tag-$tag_id.php", 'tag.php' );
		}elseif(is_tax()){
			$tax = get_queried_object();
			$tax_name = $tax->taxonomy;
   			$term =  $tax->slug;	
			$hierarchy = array( "taxonomy-$tax_name-$term.php", "taxonomy-$tax_name.php", 'taxonomy.php' );
		}elseif( is_post_type_archive()  ){			
			$hierarchy = array( "archive-$type.php" );
		}elseif( is_date() ){
			$hierarchy = array( "date.php" );
		}
		$hierarchy[] = 'archive.php';
	}elseif(is_singular()){
		if(is_page()){			
			$hierarchy = array( '<i>custom template</i>', "page-$slug.php",  "page-$id.php", 'page.php' );
		}elseif(is_attachment()){
			$mime = get_post_mime_type();
			$type = explode( '/', $mime );
			$hierarchy = array( "$type[0]-$type[1].php", "$type[1].php",  "$type[0].php", 'attachment', 'single.php' );
		}elseif( is_singular('post') ){
			$hierarchy = array('<i>custom template</i>', 'single-post.php', 'single.php');
		}else{
			//single custom post			
			$hierarchy = array('<i>custom template</i>', "single-$type-$slug.php", "single-$type.php", 'single.php');
		}
		$hierarchy[] = 'singular.php';
	}
	//default template:
	$hierarchy[] = 'index.php';
	$sep = '';
	foreach($hierarchy as $value){
		$class = 'template';
		$current_template = $GLOBALS['current_theme_template'];
		//if custom template applied	
		if(isset($post) && get_post_meta($post->ID,'_wp_page_template',true) != 'default' && get_post_meta($post->ID,'_wp_page_template',true) != ''){
			$current_template = '<i>custom template</i>';
		}
		if( $current_template == $value ){
			$class .= ' current-template';
		}
		$output.=  $sep .  '<span class="' . $class . '">' . $value . '</span>';
		$sep = ' &rarr; ';
	}
	return $output;
}
function adminhelper_get_current_template(  ) {
	if( !isset( $GLOBALS['current_theme_template'] ) ){
		return false;
	}
	return $GLOBALS['current_theme_template'];
}
/**
 * Display a more complete File Path to the template
 * @since ver 3.0.3
 */
function adminhelper_get_template_path(){
	if( !isset( $GLOBALS['template'] ) ){
		return false;
	}
	$template = $GLOBALS['template'];
	$path = ABSPATH;
	$template = str_replace($path, '', $template);
	return $template;
}
//Added to Fetch the template file being used
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
	$GLOBALS['current_theme_template'] = basename($t);
	return $t;
}
/**
 * Enqueue the stylesheet
 * @since ver 2.0
 */
add_action('wp_enqueue_scripts', 'adminhelper_enqueue_stylesheet');
add_action('admin_enqueue_scripts', 'adminhelper_enqueue_stylesheet');
function adminhelper_enqueue_stylesheet(){
	if(is_user_logged_in() && is_admin_bar_showing()){
		$src = plugins_url( 'theme-inspector.css', __FILE__ );
		wp_register_style( 'themehelper-style', $src, '', '', 'screen' );
		wp_enqueue_style( 'themehelper-style' );
	}
}
/**
 * Check for special cases (plugin incompatibility) to flag an alert
 * @since ver 4.0.0
 */
function adminhelper_special_cases(){	
	$known_special_cases = array(
		'wp_is_block_theme' => '<a target="_blank" href="https://developer.wordpress.org/block-editor/how-to-guides/themes/block-theme-overview/">This is a block theme (FSE)</a>',
		'is_woocommerce' => '<a target="_blank" href="https://docs.woocommerce.com/document/template-structure/">WooCommerce is Active on this screen. </a>',
		'is_bbpress' 	=> '<a target="_blank" href="https://codex.bbpress.org/themes/theme-compatibility/">BBPress is Active on this screen.</a>',
		'is_buddypress' => 'BuddyPress is active on this screen<a href="https://codex.buddypress.org/themes/theme-compatibility-1-7/theme-compatibility-2/"></a>',
	);
	$active_special_cases = array();
	foreach ($known_special_cases as $function => $message){
		if (function_exists($function)) {
			if( call_user_func($function) ){
				$active_special_cases[$function] = $message;
			}
		}
	}
	if (empty($active_special_cases)) {
		return false;
	}else{
		$output = '<h3>The following cases affect the template hierarchy.</h3>';
		foreach ($active_special_cases as $key => $value) {
			$output .= "<div class='$key'>$value</div>";
		}
		return $output;
	}
}
/**
 * If in debug mode, show ALL the $GLOBALS at the bottom of the page
 * @since ver 3.0.3
 */
if(ADMINHELPER_DEBUG_MODE){
add_action( 'shutdown', 'adminhelper_print_them_globals' );
}
function adminhelper_print_them_globals() {
	if(! is_admin() ){
	    ksort( $GLOBALS );
	    echo '<pre>';
	    echo htmlspecialchars(print_r( $GLOBALS, true ));
	    echo '</pre>';
	}
}