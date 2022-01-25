<?php
// rgba_color

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Set return value
// NOTE: Value is a string
$return_format = isset( $this->settings['return_value'] ) ? $this->settings['return_value'] : '';

// Return format 'css rgba'
if ( $return_format == '0' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php echo \$".$this->var_name."; ?>")."\n";
}

// Return format 'css rgba'
if ( $return_format == '1' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php echo \$".$this->var_name."['hex']; ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php echo \$".$this->var_name."['opacity']; ?>")."\n";
}
