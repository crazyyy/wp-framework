<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>
if ( ! function_exists( '{{function_name}}' ) ) {

<?php } ?>
// Register Custom Status
function {{function_name}}() {
<?php if ( ! empty ( $wpg_post_status ) ) { ?>

	$args = array(
<?php if ( ! empty ( $wpg_label_count_singular ) ) { ?>
		'label'                     => _x( '{{label_count_singular}}', 'Status General Name'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_label_count_singular ) ) { ?>
		'label_count'               => _n_noop( '{{label_count_singular}} (%s)',  '{{label_count_plural}} (%s)'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_public ) ) { ?>
		'public'                    => {{public}},
<?php } ?>
<?php if ( ! empty ( $wpg_show_in_admin_all_list ) ) { ?>
		'show_in_admin_all_list'    => {{show_in_admin_all_list}},
<?php } ?>
<?php if ( ! empty ( $wpg_show_in_admin_status_list ) ) { ?>
		'show_in_admin_status_list' => {{show_in_admin_status_list}},
<?php } ?>
<?php if ( ! empty ( $wpg_exclude_from_search ) ) { ?>
		'exclude_from_search'       => {{exclude_from_search}},
<?php } ?>
	);
	register_post_status( '{{post_status}}', $args );

<?php } ?>
}
add_action( 'init', '{{function_name}}', 0 );
<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>

}
<?php }