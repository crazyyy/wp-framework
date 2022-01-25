<?php
// Number Slider field
// https://wordpress.org/plugins/advanced-custom-fields-number-slider/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Return the field wrapped in markup for a code block
echo $this->indent . htmlspecialchars("<?php " . $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
