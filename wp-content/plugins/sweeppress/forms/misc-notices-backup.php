<?php

use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( sweeppress_settings()->show_notice() ) {
	$disable = panel()->a()->getback_url( array(
		'action'   => 'disable-backups-notice',
		'_wpnonce' => wp_create_nonce( 'sweeppress-disable-backups-notice' ),
	) );

	?>

    <div class="d4p-group d4p-dashboard-card d4p-card-double sweeppress-notice-group sweeppress-notice-backups">
        <h3>
			<?php esc_html_e( "Backup your database", "sweeppress" ); ?>
            <a class="button-secondary" href="<?php echo esc_url( $disable ); ?>" title="<?php esc_attr_e( "Disable Backup notice display.", "sweeppress" ); ?>"><?php esc_html_e( "hide", "sweeppress" ); ?></a>
        </h3>
        <div class="d4p-group-inner">
            <p>
                <strong><?php esc_html_e( "All the sweeping operations will remove data from the database, and these operations are not reversible!", "sweeppress" ); ?></strong>
            </p>
            <p><?php esc_html_e( "Sweeping operations are considered safe and are designed to remove the data that is actually not used by WordPress. But, to be extra safe, it is highly recommended to backup your database before you use any of the sweepers.", "sweeppress" ); ?></p>
        </div>
    </div>

	<?php

}
