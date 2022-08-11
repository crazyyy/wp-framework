<?php
// Advanced Custom Fields: Font Awesome Field
// https://wordpress.org/plugins/advanced-custom-fields-font-awesome/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$save_format = isset( $this->settings['save_format'] ) ? $this->settings['save_format'] : '';

if ( $save_format == 'element' ) {

	echo $this->indent . htmlspecialchars("<?php " . $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";

} elseif ( $save_format == 'class' ) {

	echo $this->indent . htmlspecialchars("<i class=\"fa <?php " . $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>\"></i>"). "\n";

} elseif ( $save_format == 'unicode' || $save_format == 'object' ) {

	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name." = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " );")."\n";
	echo $this->indent . htmlspecialchars("// var_dump( \$".$this->var_name." ); ?>")."\n";

}
