<?php
// Post Type Select Field for Advanced Custom Fields
// https://wordpress.org/plugins/post-type-select-for-advanced-custom-fields/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Same code is rendered for single and mulitple values.
// Single returns a string, multiple returns an array.
echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");
