<?php
// Advanced Custom Fields: Number Slider
// https://wordpress.org/plugins/advanced-custom-fields-number-slider/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

echo $this->indent . htmlspecialchars("<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
