<?php

// TODO : make this a child class of field group class ?

// Class for a layout in a flexible content field.
class ACFTC_Flexible_Content_Layout {

	public $name; // Used in flexible content layout render partial
	public $sub_fields; // Used in flexible content layout render partial

	/**
	 * $nesting_level
	 *
	 * 0 = not nested inside another field
	 * 1 = nested one level deep inside another field eg. repeater
	 * 2 = nested two levels deep inside other fields etc
	 */
	public $nesting_level;
	public $indent_count;
	public $location_rule_param;

	private $exclude_html_wrappers = false;

	/**
	 * Constructor
	 *
	 * @param array $args Array of arguments.
	 */
	function __construct( $args = array() ) {

		$default_args = array(
			'name' => '', // TODO Check this default is appropriate
			'nesting_level' => 0,
			'indent_count' => 0,
			'location_rule_param' => '',
			'layout_key' => null, // Used to get sub fields (ACF PRO)
			'parent_field_id' => null, // Used to get sub fields (ACF PRO)
			'sub_fields' => null, // Used to get sub fields (Flexi add on)
			'exclude_html_wrappers' => false // Change to true for debug
		);

		$args = array_merge( $default_args, $args ); 

		$this->name = $args['name'];
		$this->nesting_level = $args['nesting_level'];
		$this->indent_count = $args['indent_count'];
		$this->location_rule_param = $args['location_rule_param'];

		// If flexi add on is used
		if ( 'postmeta' == ACFTC_Core::$db_table ) {

			$this->sub_fields = $args['sub_fields'];

		}
		// Else ACF PRO is used
		elseif ( 'posts' == ACFTC_Core::$db_table ) {

			$this->sub_fields = $this->get_sub_fields_from_posts_table( $args['layout_key'], $args['parent_field_id'] );

		}

		$this->exclude_html_wrappers = $args['exclude_html_wrappers'];

	}

	/**
	* Get all sub fields in layout
	*
	* @param $layout_key
	* @param $parent_field_id
	*/
	private function get_sub_fields_from_posts_table( $layout_key, $parent_field_id ) {

		// get all sub fields of parent field
		$query_args = array(
			'post_type' =>  array( 'acf-field' , 'acf' ), // TODO should this be a conditional?
			'post_parent' => $parent_field_id,
			'posts_per_page' => '-1',
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);

		$fields_query = new WP_Query( $query_args );
		$all_sub_fields = $fields_query->posts;

		// get only fields that belong to layout
		$layout_sub_fields = array();

		foreach ( $all_sub_fields as $sub_field ) {

			$sub_field_content = unserialize( $sub_field->post_content );
			$sub_field_layout_key = $sub_field_content['parent_layout'];

			// if sub field belongs to layout, add it to the array of fields
			if ( $layout_key == $sub_field_layout_key ) {
				array_push( $layout_sub_fields, $sub_field );
			}

		}

		return $layout_sub_fields;

	}

	/**
	 * Get HTML for sub fields
	 *
	 * @return string
	 **/
	public function get_sub_fields_html() {

		$sub_fields_html = ''; 

		foreach ( $this->sub_fields as $sub_field ) {

			$args = array(
				'nesting_level' => $this->nesting_level,
				'indent_count' => $this->indent_count,
				'field_data_obj' => $sub_field,
				'exclude_html_wrappers' => $this->exclude_html_wrappers
			);

			$field_class_name = ACFTC_Core::$class_prefix . 'Field';
			$acftc_field = new $field_class_name( $args );

			$sub_fields_html .= $acftc_field->get_field_html();

		}

		return $sub_fields_html;

	}

}
