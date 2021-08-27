<?php
// Focal Point Field
// https://en-au.wordpress.org/plugins/acf-focal-point/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


// get the return format
$return_format = isset( $this->settings['save_format'] ) ? $this->settings['save_format'] : '';

// if reutruning a single number
if ( $return_format == 'tag' ) {
	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name." = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name." ) { ?>")."\n";
	echo $this->indent . htmlspecialchars("	<?php echo \$".$this->var_name ."; ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php } ?>\n");

}

if ( $return_format == 'object' ) {
	echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. " = " .  $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php if ( \$".$this->var_name." ) { ?>")."\n";
	echo $this->indent . htmlspecialchars("	<?php // var_dump( \$".$this->var_name." ); ?>")."\n";
	echo $this->indent . htmlspecialchars("<?php } ?>\n");
}
