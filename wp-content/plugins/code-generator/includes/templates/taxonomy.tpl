<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>
if ( ! function_exists( '{{function_name}}' ) ) {

<?php } ?>
// Register Custom Taxonomy
function {{function_name}}() {

	$labels = array(
<?php if ( ! empty ( $wpg_plural_name ) ) { ?>
		'name'                       => _x( '{{plural_name}}', 'Taxonomy General Name'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_singular_name ) ) { ?>
		'singular_name'              => _x( '{{singular_name}}', 'Taxonomy Singular Name'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_menu_name ) ) { ?>
		'menu_name'                  => __( '{{menu_name}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_all_items ) ) { ?>
		'all_items'                  => __( '{{all_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_parent_item ) ) { ?>
		'parent_item'                => __( '{{parent_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_parent_item_colon ) ) { ?>
		'parent_item_colon'          => __( '{{parent_item_colon}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_new_item_name ) ) { ?>
		'new_item_name'              => __( '{{new_item_name}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_add_new_item ) ) { ?>
		'add_new_item'               => __( '{{add_new_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_edit_item ) ) { ?>
		'edit_item'                  => __( '{{edit_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_update_item ) ) { ?>
		'update_item'                => __( '{{update_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_view_item ) ) { ?>
		'view_item'                  => __( '{{view_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_separate_items_with_commas ) ) { ?>
		'separate_items_with_commas' => __( '{{separate_items_with_commas}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_add_or_remove_items ) ) { ?>
		'add_or_remove_items'        => __( '{{add_or_remove_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_choose_from_most_used ) ) { ?>
		'choose_from_most_used'      => __( '{{choose_from_most_used}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_popular_items ) ) { ?>
		'popular_items'              => __( '{{popular_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_search_items ) ) { ?>
		'search_items'               => __( '{{search_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_not_found ) ) { ?>
		'not_found'                  => __( '{{not_found}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_no_terms ) ) { ?>
		'no_terms'                   => __( '{{no_terms}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_items_list ) ) { ?>
		'items_list'                 => __( '{{items_list}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_items_list_navigation ) ) { ?>
		'items_list_navigation'      => __( '{{items_list_navigation}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
	);
<?php if ( ! empty ( $wpg_rewrite ) && 'custom' === $wpg_rewrite ) { ?>

	$rewrite = array(
		'slug'                  => '{{rewrite_slug}}',
		'with_front'            => {{rewrite_with_front}},
		'hierarchical'          => {{rewrite_hierarchical}},
	);
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities ) ) { ?>

	$capabilities = array(
<?php if ( ! empty ( $wpg_capabilities_edit_terms ) ) { ?>
		'edit_terms'                 => '{{capabilities_edit_terms}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_delete_terms ) ) { ?>
		'delete_terms'               => '{{capabilities_delete_terms}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_manage_terms ) ) { ?>
		'manage_terms'               => '{{capabilities_manage_terms}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_assign_terms ) ) { ?>
		'assign_terms'               => '{{capabilities_assign_terms}}',
<?php } ?>
	);
<?php } ?>

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => {{hierarchical}},
		'public'                     => {{public}},
		'show_ui'                    => {{show_ui}},
		'show_admin_column'          => {{show_admin_column}},
		'show_in_nav_menus'          => {{show_in_nav_menus}},
		'show_tagcloud'              => {{show_tagcloud}},
<?php if ( ! empty ( $wpg_query_var ) ) { ?>
		'query_var'                  => '{{query_var_slug}}',
<?php } ?>
<?php if ( ! empty ( $wpg_rewrite ) ) { ?>
		'rewrite'                    => <?php if ( ! empty ( $wpg_rewrite ) && 'custom' === $wpg_rewrite ) { ?>$rewrite<?php } else { ?>{{rewrite}}<?php } ?>,
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities ) ) { ?>
		'capabilities'               => $capabilities,
<?php } ?>
<?php if ( ! empty ( $wpg_show_in_rest ) ) { ?>
		'show_in_rest'               => '{{show_in_rest}}',
<?php } ?>
<?php if ( ! empty ( $wpg_rest_base ) ) { ?>
		'rest_base'                  => '{{rest_base}}',
<?php } ?>
<?php if ( ! empty ( $wpg_rest_controller_class ) ) { ?>
		'rest_controller_class'      => '{{rest_controller_class}}',
<?php } ?>
<?php if ( ! empty ( $wpg_update_count_callback ) ) { ?>
		'update_count_callback'      => '{{update_count_callback}}',
<?php } ?>
	);
	register_taxonomy( '{{taxonomy}}', array( {{object_type}} ), $args );

}
add_action( 'init', '{{function_name}}', 0 );
<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>

}
<?php }