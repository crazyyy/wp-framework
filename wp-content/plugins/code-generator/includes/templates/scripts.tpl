// Register Script
function {{function_name}}() {
<?php if ( ! empty ( $wpg_handle1 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister1 ) && 'true' === $wpg_deregister1  ) { ?>
	wp_deregister_script( '{{handle1}}' );
<?php } ?>
	wp_register_script( '{{handle1}}', '{{src1}}', array( {{deps1}} ), '{{ver1}}', <?php if ( ! empty ( $wpg_in_footer1 ) && 'true' === $wpg_in_footer1 ) { ?>true<?php } else { ?>false<?php } ?> );
<?php if ( ! empty ( $wpg_enqueue1 ) && 'true' === $wpg_enqueue1 ) { ?>
	wp_enqueue_script( '{{handle1}}' );
<?php } ?>
<?php } ?>
<?php if ( ! empty ( $wpg_handle2 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister2 ) && 'true' === $wpg_deregister2  ) { ?>
	wp_deregister_script( '{{handle2}}' );
<?php } ?>
	wp_register_script( '{{handle2}}', '{{src2}}', array( {{deps2}} ), '{{ver2}}', <?php if ( ! empty ( $wpg_in_footer2 ) && 'true' === $wpg_in_footer2 ) { ?>true<?php } else { ?>false<?php } ?> );
<?php if ( ! empty ( $wpg_enqueue2 ) && 'true' === $wpg_enqueue2 ) { ?>
	wp_enqueue_script( '{{handle2}}' );
<?php } ?>
<?php } ?>
<?php if ( ! empty ( $wpg_handle3 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister3 ) && 'true' === $wpg_deregister3  ) { ?>
	wp_deregister_script( '{{handle3}}' );
<?php } ?>
	wp_register_script( '{{handle3}}', '{{src3}}', array( {{deps3}} ), '{{ver3}}', <?php if ( ! empty ( $wpg_in_footer3 ) && 'true' === $wpg_in_footer3 ) { ?>true<?php } else { ?>false<?php } ?> );
<?php if ( ! empty ( $wpg_enqueue3 ) && 'true' === $wpg_enqueue3 ) { ?>
	wp_enqueue_script( '{{handle3}}' );
<?php } ?>
<?php } ?>
<?php if ( ! empty ( $wpg_handle4 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister4 ) && 'true' === $wpg_deregister4  ) { ?>
	wp_deregister_script( '{{handle4}}' );
<?php } ?>
	wp_register_script( '{{handle4}}', '{{src4}}', array( {{deps4}} ), '{{ver4}}', <?php if ( ! empty ( $wpg_in_footer4 ) && 'true' === $wpg_in_footer4 ) { ?>true<?php } else { ?>false<?php } ?> );
<?php if ( ! empty ( $wpg_enqueue4 ) && 'true' === $wpg_enqueue4 ) { ?>
	wp_enqueue_script( '{{handle4}}' );
<?php } ?>
<?php } ?>
<?php if ( ! empty ( $wpg_handle5 ) ) { ?>

<?php if ( ! empty ( $wpg_deregister5 ) && 'true' === $wpg_deregister5  ) { ?>
	wp_deregister_script( '{{handle5}}' );
<?php } ?>
	wp_register_script( '{{handle5}}', '{{src5}}', array( {{deps5}} ), '{{ver5}}', <?php if ( ! empty ( $wpg_in_footer5 ) && 'true' === $wpg_in_footer5 ) { ?>true<?php } else { ?>false<?php } ?> );
<?php if ( ! empty ( $wpg_enqueue5 ) && 'true' === $wpg_enqueue5 ) { ?>
	wp_enqueue_script( '{{handle5}}' );
<?php } ?>
<?php } ?>
}
add_action( 'wp_enqueue_scripts', '{{function_name}}' );