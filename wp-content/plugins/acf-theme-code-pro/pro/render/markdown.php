<?php
// Markdown field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Basic support for the markdown field
echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
