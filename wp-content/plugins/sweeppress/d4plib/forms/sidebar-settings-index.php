<?php

use function Dev4Press\v42\Functions\panel;

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
				<?php echo esc_html( $_subpanels[ $_subpanel ][ 'info' ] ); ?>
            </div>
        </div>
        <div class="d4p-panel-buttons">
            <a style="text-align: center" href="<?php echo esc_url( panel()->a()->panel_url( 'settings', 'full' ) ); ?>" class="button-secondary"><?php esc_html_e( "Show All Settings", "d4plib" ); ?></a>
        </div>
    </div>
</div>
