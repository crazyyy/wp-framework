<?php

use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-content d4p-setup-wrapper">
    <div class="d4p-update-info">
		<?php

		sweeppress_settings()->set( 'install', false, 'info' );
		sweeppress_settings()->set( 'update', false, 'info', true );

		?>

        <div class="d4p-install-block">
            <h4>
				<?php esc_html_e( "All Done", "sweeppress" ); ?>
            </h4>
            <div>
				<?php esc_html_e( "Installation completed.", "sweeppress" ); ?>
            </div>
        </div>

        <div class="d4p-install-confirm">
            <a class="button-primary" href="<?php echo esc_url( panel()->a()->panel_url( 'about' ) ); ?>&install"><?php esc_html_e( "Click here to continue", "sweeppress" ); ?></a>
        </div>
    </div>
</div>