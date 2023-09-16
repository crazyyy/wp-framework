// Register Default Headers
function {{function_name}}() {

	$headers = array(
<?php if ( ! empty ( $wpg_name1 ) ) { ?>
		'{{name1}}' => array(
			'description'   => __( '{{description1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
			'url'           => '{{url1}}',
			'thumbnail_url' => '{{thumbnail_url1}}',
		),
<?php } ?>
<?php if ( ! empty ( $wpg_name2 ) ) { ?>
		'{{name2}}' => array(
			'description'   => __( '{{description2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
			'url'           => '{{url2}}',
			'thumbnail_url' => '{{thumbnail_url2}}',
		),
<?php } ?>
<?php if ( ! empty ( $wpg_name3 ) ) { ?>
		'{{name3}}' => array(
			'description'   => __( '{{description3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
			'url'           => '{{url3}}',
			'thumbnail_url' => '{{thumbnail_url3}}',
		),
<?php } ?>
<?php if ( ! empty ( $wpg_name4 ) ) { ?>
		'{{name4}}' => array(
			'description'   => __( '{{description4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
			'url'           => '{{url4}}',
			'thumbnail_url' => '{{thumbnail_url4}}',
		),
<?php } ?>
<?php if ( ! empty ( $wpg_name5 ) ) { ?>
		'{{name5}}' => array(
			'description'   => __( '{{description5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
			'url'           => '{{url5}}',
			'thumbnail_url' => '{{thumbnail_url5}}',
		),
<?php } ?>
	);
	register_default_headers( $headers );

}
add_action( 'after_setup_theme', '{{function_name}}' );