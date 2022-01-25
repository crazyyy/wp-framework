<?php
// YouTube Picker field
// https://wordpress.org/plugins/acf-code-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Get field (array) and return a var dump
echo $this->indent . htmlspecialchars("<?php $".$this->var_name." = " . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " );")."\n";
echo $this->indent . htmlspecialchars("// var_dump( $".$this->var_name." ); ?>")."\n";
