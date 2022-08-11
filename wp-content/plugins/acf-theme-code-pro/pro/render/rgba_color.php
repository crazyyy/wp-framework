<?php
// Advanced Custom Fields: RGBA Color Field
// https://github.com/reyhoun/acf-rgba-color

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Note: return format value is a string
$return_format = isset( $this->settings['return_value'] ) ? $this->settings['return_value'] : '';

// Return format 'hex and opacity'
if ( $return_format == '1' ) {
    echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
    echo $this->indent . htmlspecialchars("<?php echo esc_html( \${$this->var_name}['hex'] ); ?>\n");
    echo $this->indent . htmlspecialchars("<?php echo esc_html( \${$this->var_name}['opacity'] ); ?>\n");
}

// Return format 'css rgba'
if ( $return_format == '0' ) {
    echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
    echo $this->indent . htmlspecialchars("<?php echo esc_html( \${$this->var_name} ); ?>\n");
}
