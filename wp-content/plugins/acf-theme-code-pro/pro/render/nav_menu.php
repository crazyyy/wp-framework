<?php
// Advanced Custom Fields: Nav Menu Field
// https://wordpress.org/plugins/advanced-custom-fields-nav-menu-field

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = isset( $this->settings['save_format'] ) ? $this->settings['save_format'] : '';

if ( $return_format == 'object' ) {
    echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
    echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");
}

if ( $return_format == 'menu' ) { // "Nav Menu HTML"
    echo $this->indent . htmlspecialchars("<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
}

if ( $return_format == 'id' ) {
    echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
    echo $this->indent . htmlspecialchars("<?php wp_nav_menu( array(\n");
    echo $this->indent . htmlspecialchars("	'menu' => \${$this->var_name}\n");
    echo $this->indent . htmlspecialchars(") ); ?>\n");
}