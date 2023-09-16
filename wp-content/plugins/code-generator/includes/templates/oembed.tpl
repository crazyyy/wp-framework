// Register oEmbed providers
function {{function_name}}() {
<?php if ( ! empty ( $wpg_format1 ) || ! empty ( $wpg_provider1 ) ) { ?>
	wp_oembed_add_provider( '{{format1}}', '{{provider1}}', false );
<?php } ?>
<?php if ( ! empty ( $wpg_format2 ) || ! empty ( $wpg_provider2 ) ) { ?>
	wp_oembed_add_provider( '{{format2}}', '{{provider2}}', false );
<?php } ?>
<?php if ( ! empty ( $wpg_format3 ) || ! empty ( $wpg_provider3 ) ) { ?>
	wp_oembed_add_provider( '{{format3}}', '{{provider3}}', false );
<?php } ?>
<?php if ( ! empty ( $wpg_format4 ) || ! empty ( $wpg_provider4 ) ) { ?>
	wp_oembed_add_provider( '{{format4}}', '{{provider4}}', false );
<?php } ?>
<?php if ( ! empty ( $wpg_format5 ) || ! empty ( $wpg_provider5 ) ) { ?>
	wp_oembed_add_provider( '{{format5}}', '{{provider5}}', false );
<?php } ?>
}
add_action( 'init', '{{function_name}}' );