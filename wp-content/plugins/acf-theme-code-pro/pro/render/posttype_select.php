<?php
// Post Type Select field
// https://wordpress.org/plugins/acf-code-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Return the field
echo $this->indent . htmlspecialchars("<?php " . $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
