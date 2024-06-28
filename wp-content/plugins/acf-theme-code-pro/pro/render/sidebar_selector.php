<?php
// ACF: Sidebar Selector
// https://wordpress.org/plugins/acf-sidebar-selector-field/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
echo $this->indent . htmlspecialchars("<?php dynamic_sidebar( \$".$this->var_name. " ); ?>")."\n";
