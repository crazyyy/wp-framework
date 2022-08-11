<?php
// ACF Address field
// https://github.com/strickdj/acf-field-address

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$output_type = isset( $this->settings['output_type'] ) ? $this->settings['output_type'] : '';

if ( $output_type == 'html' ) {
	echo $this->indent . htmlspecialchars("<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
}

if ( $output_type == 'array' || $output_type == 'object' ) {
	echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
	echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");
}
