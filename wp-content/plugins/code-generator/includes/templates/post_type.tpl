<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>
if ( ! function_exists( '{{function_name}}' ) ) {

<?php } ?>
// Register Custom Post Type
function {{function_name}}() {

	$labels = array(
<?php if ( ! empty ( $wpg_plural_name ) ) { ?>
		'name'                  => _x( '{{plural_name}}', 'Post Type General Name'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_singular_name ) ) { ?>
		'singular_name'         => _x( '{{singular_name}}', 'Post Type Singular Name'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_menu_name ) ) { ?>
		'menu_name'             => __( '{{menu_name}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_name_admin_bar ) ) { ?>
		'name_admin_bar'        => __( '{{name_admin_bar}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_archives ) ) { ?>
		'archives'              => __( '{{archives}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_attributes ) ) { ?>
		'attributes'            => __( '{{attributes}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_parent_item_colon ) ) { ?>
		'parent_item_colon'     => __( '{{parent_item_colon}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_all_items ) ) { ?>
		'all_items'             => __( '{{all_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_add_new_item ) ) { ?>
		'add_new_item'          => __( '{{add_new_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_add_new ) ) { ?>
		'add_new'               => __( '{{add_new}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_new_item ) ) { ?>
		'new_item'              => __( '{{new_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_edit_item ) ) { ?>
		'edit_item'             => __( '{{edit_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_update_item ) ) { ?>
		'update_item'           => __( '{{update_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_view_item ) ) { ?>
		'view_item'             => __( '{{view_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_view_items ) ) { ?>
		'view_items'            => __( '{{view_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_search_items ) ) { ?>
		'search_items'          => __( '{{search_items}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_not_found ) ) { ?>
		'not_found'             => __( '{{not_found}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_not_found_in_trash ) ) { ?>
		'not_found_in_trash'    => __( '{{not_found_in_trash}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_featured_image ) ) { ?>
		'featured_image'        => __( '{{featured_image}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_set_featured_image ) ) { ?>
		'set_featured_image'    => __( '{{set_featured_image}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_remove_featured_image ) ) { ?>
		'remove_featured_image' => __( '{{remove_featured_image}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_use_featured_image ) ) { ?>
		'use_featured_image'    => __( '{{use_featured_image}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_insert_into_item ) ) { ?>
		'insert_into_item'      => __( '{{insert_into_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_uploaded_to_this_item ) ) { ?>
		'uploaded_to_this_item' => __( '{{uploaded_to_this_item}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_items_list ) ) { ?>
		'items_list'            => __( '{{items_list}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_items_list_navigation ) ) { ?>
		'items_list_navigation' => __( '{{items_list_navigation}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_filter_items_list ) ) { ?>
		'filter_items_list'     => __( '{{filter_items_list}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
	);
<?php if ( ! empty ( $wpg_rewrite ) && 'custom' === $wpg_rewrite ) { ?>

	$rewrite = array(
		'slug'                  => '{{rewrite_slug}}',
		'with_front'            => {{rewrite_with_front}},
		'pages'                 => {{rewrite_pages}},
		'feeds'                 => {{rewrite_feeds}},
	);
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities ) && 'custom' === $wpg_capabilities ) { ?>

	$capabilities = array(
<?php if ( ! empty ( $wpg_capabilities_edit_post ) ) { ?>
		'edit_post'             => '{{capabilities_edit_post}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_read_post ) ) { ?>
		'read_post'             => '{{capabilities_read_post}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_delete_post ) ) { ?>
		'delete_post'           => '{{capabilities_delete_post}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_edit_posts ) ) { ?>
		'edit_posts'            => '{{capabilities_edit_posts}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_edit_others_posts ) ) { ?>
		'edit_others_posts'     => '{{capabilities_edit_others_posts}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_publish_posts ) ) { ?>
		'publish_posts'         => '{{capabilities_publish_posts}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities_read_private_posts ) ) { ?>
		'read_private_posts'    => '{{capabilities_read_private_posts}}',
<?php } ?>
	);
<?php } ?>

	$args = array(
		'label'                 => __( '{{singular_name}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php if ( ! empty ( $wpg_description ) ) { ?>
		'description'           => __( '{{description}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
		'labels'                => $labels,
		'supports'              => <?php if ( ! empty ( $wpg_supports ) ) { ?>array( {{supports}} )<?php } else { ?>false<?php } ?>,
<?php if ( ! empty ( $wpg_taxonomies ) ) { ?>
		'taxonomies'            => array( {{taxonomies}} ),
<?php } ?>
		'hierarchical'          => {{hierarchical}},
		'public'                => {{public}},
		'show_ui'               => {{show_ui}},
		'show_in_menu'          => {{show_in_menu}},
<?php if ( ! empty ( $wpg_show_in_menu ) && 'true' === $wpg_show_in_menu ) { ?>
		'menu_position'         => {{menu_position}},
<?php } ?>
<?php if ( ! empty ( $wpg_menu_icon ) ) { ?>
		'menu_icon'             => '{{menu_icon}}',
<?php } ?>
		'show_in_admin_bar'     => {{show_in_admin_bar}},
		'show_in_nav_menus'     => {{show_in_nav_menus}},
		'can_export'            => {{can_export}},
		'has_archive'           => <?php if ( ! empty ( $wpg_has_archive ) && 'custom' === $wpg_has_archive ) { ?>'{{custom_archive_slug}}'<?php } else { ?>{{has_archive}}<?php } ?>,
		'exclude_from_search'   => {{exclude_from_search}},
		'publicly_queryable'    => {{publicly_queryable}},
<?php if ( ! empty ( $wpg_rewrite ) ) { ?>
		'rewrite'               => <?php if ( ! empty ( $wpg_rewrite ) && 'custom' === $wpg_rewrite ) { ?>$rewrite<?php } else { ?>{{rewrite}}<?php } ?>,
<?php } ?>
<?php if ( ! empty ( $wpg_query_var ) ) { ?>
		'query_var'             => '{{custom_query_variable}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities ) && 'base' === $wpg_capabilities ) { ?>
		'capability_type'       => '{{capability_type}}',
<?php } ?>
<?php if ( ! empty ( $wpg_capabilities ) && 'custom' === $wpg_capabilities ) { ?>
		'capabilities'          => $capabilities,
<?php } ?>
<?php if ( ! empty ( $wpg_show_in_rest ) ) { ?>
		'show_in_rest'          => '{{show_in_rest}}',
<?php } ?>
<?php if ( ! empty ( $wpg_rest_base ) ) { ?>
		'rest_base'             => '{{rest_base}}',
<?php } ?>
<?php if ( ! empty ( $wpg_rest_controller_class ) ) { ?>
		'rest_controller_class' => '{{rest_controller_class}}',
<?php } ?>
	);
	register_post_type( '{{post_type}}', $args );

}
add_action( 'init', '{{function_name}}', 0 );
<?php if ( ! empty ( $wpg_child_themes ) && 'true' === $wpg_child_themes ) { ?>

}
<?php }