<?php
/**
 * Plugin Name: Remove Category URL
 * Plugin URI: http://valeriosouza.com.br/portfolio/remove-category-url/
 * Description: This plugin removes '/category' from your category permalinks. (e.g. `/category/my-category/` to `/my-category/`)
 * Version: 1.1.2
 * Author: Valerio Souza
 * Author URI: http://valeriosouza.com.br/
 * Text Domain: remove-category-url
 * Domain Path: /languages
 */

/* hooks */
register_activation_hook( __FILE__,   'remove_category_url_refresh_rules' );
register_deactivation_hook( __FILE__, 'remove_category_url_deactivate' );

/* actions */
add_action( 'created_category', 'remove_category_url_refresh_rules' );
add_action( 'delete_category',  'remove_category_url_refresh_rules' );
add_action( 'edited_category',  'remove_category_url_refresh_rules' );
add_action( 'init',             'remove_category_url_permastruct' );

/* filters */
add_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' );
add_filter( 'query_vars',             'remove_category_url_query_vars' );    // Adds 'category_redirect' query variable
add_filter( 'request',                'remove_category_url_request' );       // Redirects if 'category_redirect' is set
add_filter( 'plugin_row_meta', 		  'remove_category_url_plugin_row_meta', 10, 4 );

function remove_category_url_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

function remove_category_url_deactivate() {
	remove_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' ); // We don't want to insert our custom rules again
	remove_category_url_refresh_rules();
}

/**
 * Removes category base.
 *
 * @return void
 */
function remove_category_url_permastruct() {
	global $wp_rewrite, $wp_version;

	if ( 3.4 <= $wp_version ) {
		$wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
	} else {
		$wp_rewrite->extra_permastructs['category'][0] = '%category%';
	}
}

/**
 * Adds our custom category rewrite rules.
 *
 * @param  array $category_rewrite Category rewrite rules.
 *
 * @return array
 */
function remove_category_url_rewrite_rules( $category_rewrite ) {
	global $wp_rewrite;

	$category_rewrite = array();

	/* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
	if ( class_exists( 'Sitepress' ) ) {
		global $sitepress;

		remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
		$categories = get_categories( array( 'hide_empty' => false, '_icl_show_all_langs' => true ) );
		add_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
	} else {
		$categories = get_categories( array( 'hide_empty' => false ) );
	}

	foreach ( $categories as $category ) {
		$category_nicename = $category->slug;
		if (  $category->parent == $category->cat_ID ) {
			$category->parent = 0;
		} elseif ( 0 != $category->parent ) {
			$category_nicename = get_category_parents(  $category->parent, false, '/', true  ) . $category_nicename;
		}
		$category_rewrite[ '(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/page/?([0-9]{1,})/?$' ] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/?$' ] = 'index.php?category_name=$matches[1]';
	}

	// Redirect support from Old Category Base
	$old_category_base = get_option( 'category_base' ) ? get_option( 'category_base' ) : 'category';
	$old_category_base = trim( $old_category_base, '/' );
	$category_rewrite[ $old_category_base . '/(.*)$' ] = 'index.php?category_redirect=$matches[1]';

	return $category_rewrite;
}

function remove_category_url_query_vars( $public_query_vars ) {
	$public_query_vars[] = 'category_redirect';

	return $public_query_vars;
}

/**
 * Handles category redirects.
 *
 * @param $query_vars Current query vars.
 *
 * @return array $query_vars, or void if category_redirect is present.
 */
function remove_category_url_request( $query_vars ) {
	if ( isset( $query_vars['category_redirect'] ) ) {
		$catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
		status_header( 301 );
		header( "Location: $catlink" );
		exit;
	}

	return $query_vars;
}

function remove_category_url_plugin_row_meta( $links, $file ) {
		if( plugin_basename( __FILE__ ) === $file ) {
			$links[] = sprintf(
				'<a target="_blank" href="%s">%s</a>',
				esc_url('http://wordlab.com.br/donate/'),
				__( 'Donate', 'remove_category_url' )
			);
		}
		return $links;
	}