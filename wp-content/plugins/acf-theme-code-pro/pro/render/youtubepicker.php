<?php
// ACF YouTube Picker Field
// https://github.com/airesvsg/acf-youtubepicker
// https://wordpress.org/plugins/acf-youtube-picker/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Get field (array) and return a var dump
echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");
