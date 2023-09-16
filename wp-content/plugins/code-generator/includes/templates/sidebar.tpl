<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>
if ( ! function_exists( '{{function_name}}' ) ) {

<?php } ?>
// Register Sidebars
function {{function_name}}() {
<?php if ( ! empty ( $wpg_id1 ) ) { ?>

	$args = array(
		'id'            => '{{id1}}',
<?php if ( ! empty ( $wpg_class1 ) ) { ?>
		'class'         => '{{class1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_name1 ) ) { ?>
		'name'          => __( '{{name1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_description1 ) ) { ?>
		'description'   => __( '{{description1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_before_title1 ) ) { ?>
		'before_title'  => '{{before_title1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_title1 ) ) { ?>
		'after_title'   => '{{after_title1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_before_widget1 ) ) { ?>
		'before_widget' => '{{before_widget1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_widget1 ) ) { ?>
		'after_widget'  => '{{after_widget1}}',
<?php } ?>
	);
	register_sidebar( $args );

<?php } ?>
<?php if ( ! empty ( $wpg_id2 ) ) { ?>
	$args = array(
		'id'            => '{{id2}}',
<?php if ( ! empty ( $wpg_class2 ) ) { ?>
		'class'         => '{{class2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_name2 ) ) { ?>
		'name'          => __( '{{name2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_description2 ) ) { ?>
		'description'   => __( '{{description2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_before_title2 ) ) { ?>
		'before_title'  => '{{before_title2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_title2 ) ) { ?>
		'after_title'   => '{{after_title2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_before_widget2 ) ) { ?>
		'before_widget' => '{{before_widget2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_widget2 ) ) { ?>
		'after_widget'  => '{{after_widget2}}',
<?php } ?>
	);
	register_sidebar( $args );

<?php } ?>
<?php if ( ! empty ( $wpg_id3 ) ) { ?>
	$args = array(
		'id'            => '{{id3}}',
<?php if ( ! empty ( $wpg_class3 ) ) { ?>
		'class'         => '{{class3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_name3 ) ) { ?>
		'name'          => __( '{{name3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_description3 ) ) { ?>
		'description'   => __( '{{description3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_before_title3 ) ) { ?>
		'before_title'  => '{{before_title3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_title3 ) ) { ?>
		'after_title'   => '{{after_title3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_before_widget3 ) ) { ?>
		'before_widget' => '{{before_widget3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_widget3 ) ) { ?>
		'after_widget'  => '{{after_widget3}}',
<?php } ?>
	);
	register_sidebar( $args );

<?php } ?>
<?php if ( ! empty ( $wpg_id4 ) ) { ?>
	$args = array(
		'id'            => '{{id4}}',
<?php if ( ! empty ( $wpg_class4 ) ) { ?>
		'class'         => '{{class4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_name4 ) ) { ?>
		'name'          => __( '{{name4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_description4 ) ) { ?>
		'description'   => __( '{{description4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_before_title4 ) ) { ?>
		'before_title'  => '{{before_title4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_title4 ) ) { ?>
		'after_title'   => '{{after_title4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_before_widget4 ) ) { ?>
		'before_widget' => '{{before_widget4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_widget4 ) ) { ?>
		'after_widget'  => '{{after_widget4}}',
<?php } ?>
	);
	register_sidebar( $args );

<?php } ?>
<?php if ( ! empty ( $wpg_id5 ) ) { ?>
	$args = array(
		'id'            => '{{id5}}',
<?php if ( ! empty ( $wpg_class5 ) ) { ?>
		'class'         => '{{class5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_name5 ) ) { ?>
		'name'          => __( '{{name5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_description5 ) ) { ?>
		'description'   => __( '{{description5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_before_title5 ) ) { ?>
		'before_title'  => '{{before_title5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_title5 ) ) { ?>
		'after_title'   => '{{after_title5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_before_widget5 ) ) { ?>
		'before_widget' => '{{before_widget5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_after_widget5 ) ) { ?>
		'after_widget'  => '{{after_widget5}}',
<?php } ?>
	);
	register_sidebar( $args );

<?php } ?>
}
add_action( 'widgets_init', '{{function_name}}' );
<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>

}
<?php }