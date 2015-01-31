<?php
/*
Plugin Name: .htm on PAGES
Plugin URI: http://www.introsites.co.uk/33~html-wordpress-permalink-on-pages-plugin.htm
Description: Adds .htm to pages.
Author: IntroSites
Version: 1.1
Author URI: http://www.introsites.co.uk/
*/

add_action('init', 'html_page_permalink', -1);
register_activation_hook(__FILE__, 'active');
register_deactivation_hook(__FILE__, 'deactive');


function html_page_permalink() {
	global $wp_rewrite;
 if ( !strpos($wp_rewrite->get_page_permastruct(), '.htm')){
		$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.htm';
 }
}
add_filter('user_trailingslashit', 'no_page_slash',66,2);
function no_page_slash($string, $type){
   global $wp_rewrite;
	if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes==true && $type == 'page'){
		return untrailingslashit($string);
  }else{
   return $string;
  }
}

function active() {
	global $wp_rewrite;
	if ( !strpos($wp_rewrite->get_page_permastruct(), '.htm')){
		$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.htm';
 }
  $wp_rewrite->flush_rules();
}	
	function deactive() {
		global $wp_rewrite;
		$wp_rewrite->page_structure = str_replace(".htm","",$wp_rewrite->page_structure);
		$wp_rewrite->flush_rules();
	}
?>