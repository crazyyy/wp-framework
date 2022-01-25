<?php
// Form field
// Basic supports both the following plugins
// http://www.wordpress.org/plugins/acf-ninjaforms-add-on
// https://wordpress.org/plugins/acf-gravityforms-add-on/

// Becuase of the name clash only basic support is possible at the moment

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Get the return format
$return_format = isset( $this->settings['return_format'] ) ? $this->settings['return_format'] : '';

// If return format is ID
if ( $return_format == 'id' ) {
	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name."_id = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
}

// If return format is Object 
if ( $return_format == 'post_object' ) {
	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name."_object = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
}
