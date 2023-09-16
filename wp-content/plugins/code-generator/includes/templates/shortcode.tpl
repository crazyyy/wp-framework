// Add Shortcode
function {{function_name}}( $atts <?php if ( ! empty ( $wpg_type ) && 'enclosing' === $wpg_type ) { ?>, $content = null <?php } ?>) {

<?php if ( ! empty ( $wpg_attributes ) ) { ?>
	// Attributes
	$atts = shortcode_atts(
		array(
<?php if ( ! empty ( $wpg_attr_1_name ) ) { ?>
			'{{attr_1_name}}' => '{{attr_1_value}}',
<?php } ?>
<?php if ( ! empty ( $wpg_attr_2_name ) ) { ?>
			'{{attr_2_name}}' => '{{attr_2_value}}',
<?php } ?>
<?php if ( ! empty ( $wpg_attr_3_name ) ) { ?>
			'{{attr_3_name}}' => '{{attr_3_value}}',
<?php } ?>
		),
		$atts<?php if ( ! empty ( $wpg_attributes_filter ) && 'yes_tag_name' === $wpg_attributes_filter ) { ?>,
		'{{tag}}'<?php } ?><?php if ( ! empty ( $wpg_attributes_filter ) && 'yes_custom_name' === $wpg_attributes_filter ) { ?>,
		'{{attributes_filter_name}}'<?php } ?>

	);
<?php } ?>

	{{code}}

}
add_shortcode( '{{tag}}', '{{function_name}}' );