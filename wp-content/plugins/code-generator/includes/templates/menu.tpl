<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>
if ( ! function_exists( '{{function_name}}' ) ) {

<?php } ?>
// Register Navigation Menus
function {{function_name}}() {

	$locations = array(
<?php if ( ! empty ( $wpg_name1 ) ) { ?>
		'{{name1}}' => __( '{{description1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_name2 ) ) { ?>
		'{{name2}}' => __( '{{description2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_name3 ) ) { ?>
		'{{name3}}' => __( '{{description3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_name4 ) ) { ?>
		'{{name4}}' => __( '{{description4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_name5 ) ) { ?>
		'{{name5}}' => __( '{{description5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
	);
	register_nav_menus( $locations );

}
add_action( 'init', '{{function_name}}' );
<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>

}
<?php }