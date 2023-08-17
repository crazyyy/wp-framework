<?php

use function Dev4Press\v42\Functions\panel;

$_panel     = panel()->a()->panel_object();
$_subpanel  = panel()->a()->subpanel;
$_subpanels = panel()->subpanels();
$counters   = panel()->get_filter_counters();

?>
<div class="d4p-sidebar">
    <div class="d4p-panel-scroller d4p-scroll-active">
        <div class="d4p-panel-title">
            <div class="_icon">
				<?php echo panel()->r()->icon( $_panel->icon ); ?>
            </div>
            <h3><?php echo esc_html( $_panel->title ); ?></h3>
            <div class="_info">
				<?php echo esc_html( $_subpanels[ $_subpanel ][ 'info' ] ); ?>
            </div>
        </div>

        <div class="d4p-panel-features-counts">
			<?php

			foreach ( $counters as $code => $counter ) {
				echo '<div data-selector="' . $counter[ 'selector' ] . '">' . $counter[ 'label' ] . '<span>0</span></div>';
			}

			?>
        </div>

        <div class="d4p-panel-control">
            <button type="button" class="button-primary d4p-features-bulk-ctrl"><?php esc_html_e( "Bulk Control", "d4plib" ); ?></button>
            <div class="d4p-features-bulk-ctrl-options" style="display: none">
                <p><?php esc_html_e( "You can enable or disable all the features at once.", "d4plib" ); ?></p>
                <div>
                    <button class="button-primary" type="button" data-action="enable"><?php esc_html_e( "Enable All", "d4plib" ); ?></button>
                    <button class="button-secondary" type="button" data-action="disable"><?php esc_html_e( "Disable All", "d4plib" ); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
