<?php
// Address field
// From https://github.com/strickdj/acf-field-address

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Output format
$output_type = isset( $this->settings['output_type'] ) ? $this->settings['output_type'] : '';

// If html return the field
if ( $output_type == 'html' ) {
	echo $this->indent . htmlspecialchars("<?php " . $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
}

// If array or ojbect return a get field and a variable with a var dump
if ( $output_type == 'array' || $output_type == 'object' ) {
	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name." = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " );")."\n";
	echo $this->indent . htmlspecialchars("// var_dump( \$".$this->var_name." ); ?>")."\n";
}
