<?php
//Default Options
function wsio_default_options_data()
{
$default_options_data = array (
    'wsio_override_alt_value' => 'on',
	'wsio_override_title_value' => 'on',
	'wsio_alt_attribute_value' => '',	
	'wsio_title_tag_value' => '',
	'wsio_override_alt_custom_value' => '',
	'wsio_override_title_custom_value' => '',
	'wsio_image_width' => '1200',
	'wsio_image_height' => '1200',
	'wsio_image_quality' => '90',
	'wsio_image_quality_total' => '100',
	'wsio_image_resize_yesno' => 'on',
	'wsio_image_recompress_yesno' => 'on',
  ); 
 return apply_filters( 'weblizar_wsio_options', $default_options_data );
}  

// Options API
function weblizar_wsio_get_options() {
    // Options API Settings
    return wp_parse_args( get_option( 'weblizar_wsio_options', array() ), wsio_default_options_data() );    
}

//General Options Setting
function wsio_general_setting() {
	$wsio_options_values = get_option('weblizar_wsio_options');
	$wsio_options_values['wsio_override_alt_value'] = 'on';
	$wsio_options_values['wsio_override_title_value'] = 'on';
	$wsio_options_values['wsio_alt_attribute_value'] = '';	
	$wsio_options_values['wsio_title_tag_value'] = '';
	$wsio_options_values['wsio_override_alt_custom_value'] = '';
	$wsio_options_values['wsio_override_title_custom_value'] = '';
	update_option('weblizar_wsio_options', $wsio_options_values);
}

//Image Size Options Setting
function wsio_image_setting() {
	$wsio_options_values = get_option('weblizar_wsio_options');
	$wsio_options_values['wsio_image_width'] = '1200';
	$wsio_options_values['wsio_image_height'] = '1200';
	$wsio_options_values['wsio_image_quality'] = '90';
	$wsio_options_values['wsio_image_quality_total'] = '100';
	$wsio_options_values['wsio_image_resize_yesno'] = 'on';
	$wsio_options_values['wsio_image_recompress_yesno'] = 'on';
	update_option('weblizar_wsio_options', $wsio_options_values);
}
?>