<?php
// Nav Menu field
// https://wordpress.org/plugins/advanced-custom-fields-nav-menu-field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// get return format
$return_format = isset( $this->settings['save_format'] ) ? $this->settings['save_format'] : '';

// Basic support for the nav menu field
if ( $return_format == 'id' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " );")."\n";
    echo $this->indent . htmlspecialchars("wp_nav_menu( array(")."\n";
    echo $this->indent . htmlspecialchars(" 'menu' => \$".$this->var_name)."\n";
    echo $this->indent . htmlspecialchars(") ); ?>")."\n";
}

if ( $return_format == 'menu' ) {
    echo $this->indent . htmlspecialchars("<?php ". $this->the_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
}

if ( $return_format == 'object' ) {
    echo $this->indent . htmlspecialchars("<?php \$".$this->var_name. ' = ' . $this->get_field_method . "( '" . $this->name ."'". $this->location_rendered_param . " ); ?>")."\n";
    echo $this->indent . htmlspecialchars("<?php // var_dump( \$".$this->var_name. " ); ?>")."\n";
}
