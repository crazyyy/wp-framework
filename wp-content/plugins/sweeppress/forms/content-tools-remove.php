<?php

use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="d4p-content">
    <div class="d4p-group d4p-group-information">
        <h3><?php esc_html_e( "Important Information", "sweeppress" ); ?></h3>
        <div class="d4p-group-inner">
            <p>
				<?php esc_html_e( "This tool can remove plugin settings saved in the WordPress options table added by the plugin.", "sweeppress" ); ?>
            </p>
            <p>
				<?php esc_html_e( "Deletion operations are not reversible, and it is highly recommended to create database backup before proceeding with this tool.", "sweeppress" ); ?>
				<?php esc_html_e( "If you choose to remove plugin settings, once that is done, all settings will be reinitialized to default values if you choose to leave plugin active.", "sweeppress" ); ?>
            </p>
        </div>
    </div>

    <div class="d4p-group d4p-group-tools">
        <h3><?php esc_html_e( "Remove plugin settings", "sweeppress" ); ?></h3>
        <div class="d4p-group-inner">
            <label>
                <input type="checkbox" class="widefat" name="sweeppress-tools[remove][settings]" value="on"/> <?php esc_html_e( "Main Plugin Settings", "sweeppress" ); ?>
            </label>
            <label>
                <input type="checkbox" class="widefat" name="sweeppress-tools[remove][sweepers]" value="on"/> <?php esc_html_e( "Sweepers Settings", "sweeppress" ); ?>
            </label>
            <label>
                <input type="checkbox" class="widefat" name="sweeppress-tools[remove][statistics]" value="on"/> <?php esc_html_e( "Collected Statistics", "sweeppress" ); ?>
            </label>
        </div>
    </div>

    <div class="d4p-group d4p-group-tools">
        <h3><?php esc_html_e( "Disable Plugin", "sweeppress" ); ?></h3>
        <div class="d4p-group-inner">
            <label>
                <input type="checkbox" class="widefat" name="sweeppress-tools[remove][disable]" value="on"/> <?php esc_html_e( "Disable Plugin", "sweeppress" ); ?>
            </label>
        </div>
    </div>

	<?php panel()->include_accessibility_control(); ?>
</div>
