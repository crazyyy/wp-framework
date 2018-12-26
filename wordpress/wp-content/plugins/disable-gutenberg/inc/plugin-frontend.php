<?php // Frontend stuff..

function disable_gutenberg_wp_enqueue_scripts() {
	
	$options = get_option('disable_gutenberg_options');
	
	$enable = isset($options['styles-enable']) ? $options['styles-enable'] : false;
	
	if (!$enable) wp_dequeue_style('wp-block-library');
	
}
