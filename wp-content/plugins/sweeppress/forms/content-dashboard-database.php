<?php

use Dev4Press\Plugin\SweepPress\Basic\Database;
use Dev4Press\v42\Core\Quick\File;
use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-group d4p-dashboard-card sweeper-dashboard-database">
    <h3>
		<?php esc_html_e( "Database Status", "sweeppress" ); ?>
    </h3>
    <div class="d4p-group-inner">
        <div class="sweeppress-data-block">
            <h4><?php esc_html_e( "All Database Tables" ); ?></h4>
            <dl>
                <dt><?php esc_html_e( "Total Tables", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( Database::instance()->total( 'tables' ) ); ?></dd>
                <dt><?php esc_html_e( "Total Records", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( number_format_i18n( Database::instance()->total( 'rows' ) ) ); ?></dd>
                <dt><?php esc_html_e( "Total Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total( 'total' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Data Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total( 'size' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Data Free", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total( 'free' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Index Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total( 'index' ), 2, ' ', false ) ); ?></dd>
            </dl>
            <h4><?php esc_html_e( "WordPress Core Tables" ); ?></h4>
            <dl style="border-bottom: none;">
                <dt><?php esc_html_e( "Total Tables", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( Database::instance()->total_wp( 'tables' ) ); ?></dd>
                <dt><?php esc_html_e( "Total Records", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( number_format_i18n( Database::instance()->total_wp( 'rows' ) ) ); ?></dd>
                <dt><?php esc_html_e( "Total Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total_wp( 'total' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Data Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total_wp( 'size' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Data Free", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total_wp( 'free' ), 2, ' ', false ) ); ?></dd>
                <dt><?php esc_html_e( "Index Size", "sweeppress" ); ?>:</dt>
                <dd><?php echo esc_html( File::size_format( Database::instance()->total_wp( 'index' ), 2, ' ', false ) ); ?></dd>
            </dl>
        </div>
    </div>
    <div class="d4p-group-footer">
        <?php esc_html_e( "Upgrade to Pro version to get full Database Panel" ); ?>
    </div>
</div>
