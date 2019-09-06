<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

class Responsive_Lightbox_Folders_Walker extends Walker {

	var $tree_type = 'category';
	var $db_fields = array(
		'parent'	=> 'parent',
		'id'		=> 'term_id'
	);

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string	$output Passed by reference, used to append additional content
	 * @param int $depth Depth of the item
	 * @param array $args An array of additional arguments
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= str_repeat( "\t", $depth ) . "<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string $output Passed by reference, used to append additional content
	 * @param int $depth Depth of the item
	 * @param array $args An array of additional arguments
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= str_repeat( "\t", $depth ) . "</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @param string $output Passed by reference, used to append additional content
	 * @param object $category The current term object
	 * @param int $depth Depth of the item
	 * @param array $args An array of additional arguments
	 * @param int $id ID of the current item
	 */
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract( $args );

		if ( empty( $taxonomy ) )
			$taxonomy = Visual_Folders()->options['general']['media_taxonomy'];

		$class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';

		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->slug . '" type="checkbox" name="' . $taxonomy . '_terms[' . $category->slug . ']" id="in-' . $taxonomy . '-' . $category->term_id . '" ' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . ' ' . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string $output Passed by reference, used to append additional content
	 * @param object $category The current term object
	 * @param int $depth Depth of the item
	 * @param array $args An array of additional arguments
	 */
	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
