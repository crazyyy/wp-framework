<?php

namespace Dev4Press\v42\WordPress\Walker;

use Walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CheckboxRadio extends Walker {
	public $tree_type = 'settings';

	public $db_fields = array( 'parent' => 'parent', 'id' => 'id' );

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class='children'>\n";
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		if ( $depth ) {
			$indent = str_repeat( "\t", $depth );
		} else {
			$indent = '';
		}

		$css_class = array(
			'option-item',
			'option-item-parent-' . $data_object->parent,
			'option-item' . $data_object->id
		);

		$css_classes = implode( ' ', $css_class );

		$args[ 'input' ] = empty( $args[ 'input' ] ) ? 'checkbox' : $args[ 'input' ];

		$selected = in_array( $data_object->id, $args[ 'selected' ] ) ? ' checked="checked"' : '';

		$output .= $indent . sprintf(
				'<li class="%s"><label><input type="%s" value="%s" name="%s%s"%s class="widefat" />%s</label>',
				esc_attr( $css_classes ),
				esc_attr( $args[ 'input' ] ),
				esc_attr( $data_object->id ),
				esc_attr( $args[ 'name' ] ),
				$args[ 'input' ] == 'checkbox' ? '[]' : '',
				$selected,
				$data_object->title
			);
	}

	public function end_el( &$output, $data_object, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
