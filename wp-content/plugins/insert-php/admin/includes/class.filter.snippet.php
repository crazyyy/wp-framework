<?php
/**
 * Filter for snippet list
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 16.11.2018, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_Filter_List {

	/**
	 * WINP_Filter_List constructor.
	 */
	public function __construct() {
		add_action( 'restrict_manage_posts', [ $this, 'restrictManagePosts' ] );
		add_filter( 'parse_query', [ $this, 'parseQuery' ] );
	}

	/**
	 * Create the dropdown
	 */
	function restrictManagePosts() {
		$type = WINP_Plugin::app()->request->get( 'post_type', 'post' );

		$terms = get_terms( [
			'taxonomy'   => WINP_SNIPPETS_TAXONOMY,
			'hide_empty' => true,
		] );

		if ( WINP_SNIPPETS_POST_TYPE == $type && ! empty( $terms ) ) { ?>
            <select name="winp_filter_tag">
                <option value=""><?php _e( 'Filter by tag:', 'insert-php' ); ?></option>
				<?php
				$current_filter = WINP_Plugin::app()->request->get( 'winp_filter_tag', '' );
				foreach ( $terms as $term ) {
					if ( is_object( $term ) && isset( $term->slug ) ) {
						printf( '<option value="%s"%s>%s</option>', $term->slug, $term->slug == $current_filter ? ' selected="selected"' : '', $term->name );
					}
				}
				?>
            </select>
			<?php
		}

		$types = [
			'PHP',
			'HTML',
			'CSS',
			'JS',
			'Universal',
			'Text',
			'Advertisement',
		];

		if ( WINP_SNIPPETS_POST_TYPE == $type && ! empty( $types ) ) { ?>
            <select name="winp_filter_type">
                <option value=""><?php _e( 'Filter by type:', 'insert-php' ); ?></option>
				<?php
				$current_type = WINP_Plugin::app()->request->get( 'winp_filter_type', '' );
				foreach ( $types as $t ) {
					if ( is_string( $t ) ) {
						printf( '<option value="%s"%s>%s</option>', strtolower( $t ), strtolower( $t ) == $current_type ? ' selected="selected"' : '', $t );
					}
				}
				?>
            </select>
			<?php
		}
	}

	/**
	 * If submitted filter by tag
	 *
	 * @param $query WP_Query
	 */
	function parseQuery( $query ) {
		global $pagenow;

		$type = WINP_Plugin::app()->request->get( 'post_type' );

		if ( WINP_SNIPPETS_POST_TYPE == $type && is_admin() && 'edit.php' == $pagenow && WINP_Plugin::app()->request->get( 'winp_filter_tag', '' ) ) {
			$taxquery = [
				[
					'taxonomy' => WINP_SNIPPETS_TAXONOMY,
					'field'    => 'slug',
					'terms'    => [ WINP_Plugin::app()->request->get( 'winp_filter_tag', '' ) ],
					'operator' => 'IN',
				],
			];
			$query->set( 'tax_query', $taxquery );
		}

		if ( WINP_SNIPPETS_POST_TYPE == $type && is_admin() && 'edit.php' == $pagenow && WINP_Plugin::app()->request->get( 'winp_filter_type', '' ) ) {
			$meta_query = [
				[
					'key'     => 'wbcr_inp_snippet_type',
					'value'   => WINP_Plugin::app()->request->get( 'winp_filter_type', '' ),
					'compare' => '=',
				]
			];
			$query->set( 'meta_query', $meta_query );
		}
	}

}
