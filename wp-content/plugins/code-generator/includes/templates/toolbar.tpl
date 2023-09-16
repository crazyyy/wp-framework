// Add Toolbar Menus
function {{function_name}}() {
	global $wp_admin_bar;
<?php if ( ! empty ( $wpg_id1 ) ) { ?>

	$args = array(
		'id'     => '{{id1}}',
<?php if ( ! empty ( $wpg_parent1 ) ) { ?>
		'parent' => '{{parent1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title1 ) ) { ?>
		'title'  => __( '{{title1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_href1 ) ) { ?>
		'href'   => '{{href1}}',
<?php } ?>
		'group'   => <?php if ( ! empty ( $wpg_group1 ) && 'true' === $wpg_group1 ) { ?>'true'<?php } else { ?>'false'<?php } ?>,
<?php if ( ! empty ( $wpg_html1 ) || ! empty ( $wpg_class_attr1 ) || ! empty ( $wpg_target_attr1 ) || ! empty ( $wpg_onclick_attr1 ) || ! empty ( $wpg_title_attr1 ) || ! empty ( $wpg_tabindex_attr1 )  ) { ?>
		'meta'   => array(
<?php if ( ! empty ( $wpg_html1 ) ) { ?>
			'html'     => '{{html1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_class_attr1 ) ) { ?>
			'class'    => '{{class_attr1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_target_attr1 ) ) { ?>
			'target'   => '{{target_attr1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_onclick_attr1 ) ) { ?>
			'onclick'  => '{{onclick_attr1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title_attr1 ) ) { ?>
			'title'    => '{{title_attr1}}',
<?php } ?>
<?php if ( ! empty ( $wpg_tabindex_attr1 ) ) { ?>
			'tabindex' => '{{tabindex_attr1}}',
<?php } ?>
		),
<?php } ?>
	);
	$wp_admin_bar->add_menu( $args );
<?php } ?>
<?php if ( ! empty ( $wpg_id2 ) ) { ?>

	$args = array(
		'id'     => '{{id2}}',
<?php if ( ! empty ( $wpg_parent2 ) ) { ?>
		'parent' => '{{parent2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title2 ) ) { ?>
		'title'  => __( '{{title2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_href2 ) ) { ?>
		'href'   => '{{href2}}',
<?php } ?>
		'group'   => <?php if ( ! empty ( $wpg_group2 ) && 'true' === $wpg_group2 ) { ?>'true'<?php } else { ?>'false'<?php } ?>,
<?php if ( ! empty ( $wpg_html2 ) || ! empty ( $wpg_class_attr2 ) || ! empty ( $wpg_target_attr2 ) || ! empty ( $wpg_onclick_attr2 ) || ! empty ( $wpg_title_attr2 ) || ! empty ( $wpg_tabindex_attr2 )  ) { ?>
		'meta'   => array(
<?php if ( ! empty ( $wpg_html2 ) ) { ?>
			'html'     => '{{html2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_class_attr2 ) ) { ?>
			'class'    => '{{class_attr2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_target_attr2 ) ) { ?>
			'target'   => '{{target_attr2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_onclick_attr2 ) ) { ?>
			'onclick'  => '{{onclick_attr2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title_attr2 ) ) { ?>
			'title'    => '{{title_attr2}}',
<?php } ?>
<?php if ( ! empty ( $wpg_tabindex_attr2 ) ) { ?>
			'tabindex' => '{{tabindex_attr2}}',
<?php } ?>
		),
<?php } ?>
	);
	$wp_admin_bar->add_menu( $args );
<?php } ?>
<?php if ( ! empty ( $wpg_id3 ) ) { ?>

	$args = array(
		'id'     => '{{id3}}',
<?php if ( ! empty ( $wpg_parent3 ) ) { ?>
		'parent' => '{{parent3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title3 ) ) { ?>
		'title'  => __( '{{title3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_href3 ) ) { ?>
		'href'   => '{{href3}}',
<?php } ?>
		'group'   => <?php if ( ! empty ( $wpg_group3 ) && 'true' === $wpg_group3 ) { ?>'true'<?php } else { ?>'false'<?php } ?>,
<?php if ( ! empty ( $wpg_html3 ) || ! empty ( $wpg_class_attr3 ) || ! empty ( $wpg_target_attr3 ) || ! empty ( $wpg_onclick_attr3 ) || ! empty ( $wpg_title_attr3 ) || ! empty ( $wpg_tabindex_attr3 )  ) { ?>
		'meta'   => array(
<?php if ( ! empty ( $wpg_html3 ) ) { ?>
			'html'     => '{{html3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_class_attr3 ) ) { ?>
			'class'    => '{{class_attr3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_target_attr3 ) ) { ?>
			'target'   => '{{target_attr3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_onclick_attr3 ) ) { ?>
			'onclick'  => '{{onclick_attr3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title_attr3 ) ) { ?>
			'title'    => '{{title_attr3}}',
<?php } ?>
<?php if ( ! empty ( $wpg_tabindex_attr3 ) ) { ?>
			'tabindex' => '{{tabindex_attr3}}',
<?php } ?>
		),
<?php } ?>
	);
	$wp_admin_bar->add_menu( $args );
<?php } ?>
<?php if ( ! empty ( $wpg_id4 ) ) { ?>

	$args = array(
		'id'     => '{{id4}}',
<?php if ( ! empty ( $wpg_parent4 ) ) { ?>
		'parent' => '{{parent4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title4 ) ) { ?>
		'title'  => __( '{{title4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_href4 ) ) { ?>
		'href'   => '{{href4}}',
<?php } ?>
		'group'   => <?php if ( ! empty ( $wpg_group4 ) && 'true' === $wpg_group4 ) { ?>'true'<?php } else { ?>'false'<?php } ?>,
<?php if ( ! empty ( $wpg_html4 ) || ! empty ( $wpg_class_attr4 ) || ! empty ( $wpg_target_attr4 ) || ! empty ( $wpg_onclick_attr4 ) || ! empty ( $wpg_title_attr4 ) || ! empty ( $wpg_tabindex_attr4 )  ) { ?>
		'meta'   => array(
<?php if ( ! empty ( $wpg_html4 ) ) { ?>
			'html'     => '{{html4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_class_attr4 ) ) { ?>
			'class'    => '{{class_attr4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_target_attr4 ) ) { ?>
			'target'   => '{{target_attr4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_onclick_attr4 ) ) { ?>
			'onclick'  => '{{onclick_attr4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title_attr4 ) ) { ?>
			'title'    => '{{title_attr4}}',
<?php } ?>
<?php if ( ! empty ( $wpg_tabindex_attr4 ) ) { ?>
			'tabindex' => '{{tabindex_attr4}}',
<?php } ?>
		),
<?php } ?>
	);
	$wp_admin_bar->add_menu( $args );
<?php } ?>
<?php if ( ! empty ( $wpg_id5 ) ) { ?>

	$args = array(
		'id'     => '{{id5}}',
<?php if ( ! empty ( $wpg_parent5 ) ) { ?>
		'parent' => '{{parent5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title5 ) ) { ?>
		'title'  => __( '{{title5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> ),
<?php } ?>
<?php if ( ! empty ( $wpg_href5 ) ) { ?>
		'href'   => '{{href5}}',
<?php } ?>
		'group'   => <?php if ( ! empty ( $wpg_group5 ) && 'true' === $wpg_group5 ) { ?>'true'<?php } else { ?>'false'<?php } ?>,
<?php if ( ! empty ( $wpg_html5 ) || ! empty ( $wpg_class_attr5 ) || ! empty ( $wpg_target_attr5 ) || ! empty ( $wpg_onclick_attr5 ) || ! empty ( $wpg_title_attr5 ) || ! empty ( $wpg_tabindex_attr5 )  ) { ?>
		'meta'   => array(
<?php if ( ! empty ( $wpg_html5 ) ) { ?>
			'html'     => '{{html5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_class_attr5 ) ) { ?>
			'class'    => '{{class_attr5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_target_attr5 ) ) { ?>
			'target'   => '{{target_attr5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_onclick_attr5 ) ) { ?>
			'onclick'  => '{{onclick_attr5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_title_attr5 ) ) { ?>
			'title'    => '{{title_attr5}}',
<?php } ?>
<?php if ( ! empty ( $wpg_tabindex_attr5 ) ) { ?>
			'tabindex' => '{{tabindex_attr5}}',
<?php } ?>
		),
<?php } ?>
	);
	$wp_admin_bar->add_menu( $args );
<?php } ?>

}
add_action( 'wp_before_admin_bar_render', '{{function_name}}', 999 );