// Register Style
function {{function_name}}() {
<?php if ( ! empty ( $wpg_handle1 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister1 ) && 'true' === $wpg_deregister1  ) { ?>
	wp_deregister_style( '{{handle1}}' );
<?php } ?>
	wp_register_style( '{{handle1}}', '{{src1}}', array( {{deps1}} ), '{{ver1}}', '{{media1}}' );
<?php if ( ! empty ( $wpg_enqueue1 ) && 'true' === $wpg_enqueue1 ) { ?>
	wp_enqueue_style( '{{handle1}}' );
<?php } ?>
<?php } ?>
<?php if ( ! empty ( $wpg_handle2 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister2 ) && 'true' === $wpg_deregister2 ) { ?>
	wp_deregister_style( '{{handle2}}' );
<?php } ?>
	wp_register_style( '{{handle2}}', '{{src2}}', array( {{deps2}} ), '{{ver2}}', '{{media2}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_enqueue2 ) && 'true' === $wpg_enqueue2 ) { ?>
	wp_enqueue_style( '{{handle2}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_handle3 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister3 ) && 'true' === $wpg_deregister3 ) { ?>
	wp_deregister_style( '{{handle3}}' );
<?php } ?>
	wp_register_style( '{{handle3}}', '{{src3}}', array( {{deps3}} ), '{{ver3}}', '{{media3}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_enqueue3 ) && 'true' === $wpg_enqueue3 ) { ?>
	wp_enqueue_style( '{{handle3}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_handle4 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister4 ) && 'true' === $wpg_deregister4 ) { ?>
	wp_deregister_style( '{{handle4}}' );
<?php } ?>
	wp_register_style( '{{handle4}}', '{{src4}}', array( {{deps4}} ), '{{ver4}}', '{{media4}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_enqueue4 ) && 'true' === $wpg_enqueue4 ) { ?>
	wp_enqueue_style( '{{handle4}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_handle5 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister5 ) && 'true' === $wpg_deregister5 ) { ?>
	wp_deregister_style( '{{handle5}}' );
<?php } ?>
	wp_register_style( '{{handle5}}', '{{src5}}', array( {{deps5}} ), '{{ver5}}', '{{media5}}' );
<?php } ?>
<?php if ( ! empty ( $wpg_enqueue5 ) && 'true' === $wpg_enqueue5 ) { ?>
	wp_enqueue_style( '{{handle5}}' );
<?php } ?>
}
add_action( 'wp_enqueue_scripts', '{{function_name}}' );