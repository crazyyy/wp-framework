// Register User Contact Methods
function {{function_name}}( $user_contact_method ) {

<?php if ( ! empty ( $wpg_method1 ) ) { ?>
	$user_contact_method['{{method1}}'] = __( '{{label1}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> );
<?php } ?>
<?php if ( ! empty ( $wpg_method2 ) ) { ?>
	$user_contact_method['{{method2}}'] = __( '{{label2}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> );
<?php } ?>
<?php if ( ! empty ( $wpg_method3 ) ) { ?>
	$user_contact_method['{{method3}}'] = __( '{{label3}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> );
<?php } ?>
<?php if ( ! empty ( $wpg_method4 ) ) { ?>
	$user_contact_method['{{method4}}'] = __( '{{label4}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> );
<?php } ?>
<?php if ( ! empty ( $wpg_method5 ) ) { ?>
	$user_contact_method['{{method5}}'] = __( '{{label5}}'<?php if ( ! empty( $wpg_text_domain ) ) { ?>, '{{text_domain}}'<?php } ?> );
<?php } ?>

	return $user_contact_method;

}
add_filter( 'user_contactmethods', '{{function_name}}' );