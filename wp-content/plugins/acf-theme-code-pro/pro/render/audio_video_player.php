<?php
// Advanced Custom Field: Audio/Video Player
// https://github.com/virgo79/acf-audio-video-player

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$return_format = isset( $this->settings['return_format'] ) ? $this->settings['return_format'] : '';

if ( 'html' == $return_format || 'url' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php {$this->the_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
}

if ( 'shortcode' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
	echo $this->indent . htmlspecialchars("<?php if ( \${$this->var_name} ) : ?>\n");
	echo $this->indent . htmlspecialchars("	<?php echo do_shortcode( \${$this->var_name} ); ?> \n");
	echo $this->indent . htmlspecialchars("<?php endif; ?>\n");
}

if ( 'array' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
	echo $this->indent . htmlspecialchars("<?php // var_dump( \${$this->var_name} ); ?>\n");
}

if ( 'id' == $return_format ) {
	echo $this->indent . htmlspecialchars("<?php \${$this->var_name} = {$this->get_field_method}( '{$this->name}'{$this->location_rendered_param} ); ?>\n");
}
