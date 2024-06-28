<?php
// Advanced Custom Fields: TablePress
// https://github.com/tylerdigital/acf-tablepress

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = isset( $this->settings['return_format'] ) ? $this->settings['return_format'] : '';

if ( 'table_id' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
	echo $this->indent . htmlspecialchars("<?php echo do_shortcode( '[table id=\"' . \${$this->var_name} . '\"]' ); ?>\n");
}

if ( 'rendered_html' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
}

