<?php

use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$_panel     = panel()->a()->panel_object();
$_subpanel  = panel()->a()->subpanel;
$_subpanels = panel()->subpanels();

?>
<div class="d4p-sidebar">
    <div class="d4p-panel-scroller d4p-scroll-active">
        <div class="d4p-panel-title">
            <div class="_icon">
				<?php echo panel()->r()->icon( $_panel->icon ); ?>
            </div>
            <h3><?php echo esc_html( $_panel->title ); ?></h3>
            <div class="_info">
				<?php esc_html_e( "Detailed view for all the available Sweeper tools with additional information about each tool.", "sweeppress" ); ?>
            </div>
        </div>
        <div class="d4p-panel-title">
            <div class="sweeppress-sweeper-counters">
                <h5><?php esc_html_e( "Selected Sweepers", "sweeppress" ); ?></h5>
                <dl>
                    <dt><?php esc_html_e( "Tasks", "sweeppress" ); ?>:</dt>
                    <dd class="sweeppress-sweep-tasks">0</dd>
                    <dt><?php esc_html_e( "Records", "sweeppress" ); ?>:</dt>
                    <dd class="sweeppress-sweep-records">0</dd>
                    <dt><?php esc_html_e( "Size", "sweeppress" ); ?>:</dt>
                    <dd class="sweeppress-sweep-size">0</dd>
                </dl>
            </div>
        </div>
        <div class="d4p-panel-buttons">
            <input id="sweeppress-sweep-run" disabled type="submit" value="<?php esc_attr_e( "Run Sweeper", "sweeppress" ); ?>" class="button-primary"/>
        </div>
        <div class="d4p-return-to-top">
            <a href="#wpwrap"><?php esc_html_e( "Return to top", "sweeppress" ); ?></a>
        </div>
    </div>
</div>
