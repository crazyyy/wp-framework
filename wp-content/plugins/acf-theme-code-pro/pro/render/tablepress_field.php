<?php
// TablePress field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Support for table press field
echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " );")."\n";
echo $this->indent . htmlspecialchars("if ( \$".$this->var_name." ) { ")."\n";
echo $this->indent . htmlspecialchars("    tablepress_print_table( array( ")."\n";
echo $this->indent . htmlspecialchars("        'id' => \$".$this->var_name.", ")."\n";
echo $this->indent . htmlspecialchars("        'use_datatables' => true, ")."\n";
echo $this->indent . htmlspecialchars("        'print_name' => false ")."\n";
echo $this->indent . htmlspecialchars("     ) );")."\n";
echo $this->indent . htmlspecialchars("} ?> ")."\n";
