<?php

use function Dev4Press\v42\Functions\panel;

$_panel     = panel()->a()->panel_object();
$_subpanel  = panel()->a()->subpanel;
$_subpanels = panel()->subpanels();
$_features  = panel()->a()->plugin()->f();
$_beta      = $_features->is_beta( $_subpanel );

$_url_reset = panel()->a()->current_url();
$_url_reset = add_query_arg( array(
	'single-action'   => 'reset',
	panel()->a()->v() => 'getback',
	'_wpnonce'        => wp_create_nonce( 'coreseo-feature-reset-' . $_subpanel )
) );

?>
<div class="d4p-sidebar">
    <div class="d4p-panel-scroller d4p-scroll-active">
        <div class="d4p-panel-title">
            <div class="_icon">
				<?php echo panel()->r()->icon( $_panel->icon ); ?>
            </div>
            <h3><?php echo esc_html( $_panel->title ); ?></h3>
			<?php

			echo '<h4>' . panel()->r()->icon( $_subpanels[ $_subpanel ][ 'icon' ] ) . $_subpanels[ $_subpanel ][ 'title' ] . '</h4>';

			if ( $_beta ) {
				echo '<div class="_beta"><i class="d4p-icon d4p-ui-flask"></i> <span>' . esc_html__( "Beta Feature", "d4plib" ) . '</span></div>';
			}

			?>
            <div class="_info">
				<?php echo esc_html( $_subpanels[ $_subpanel ][ 'info' ] ); ?>
            </div>
        </div>

        <div class="d4p-panel-control">
            <button type="button" class="button-secondary d4p-feature-more-ctrl"><?php esc_html_e( "More Controls", "d4plib" ); ?></button>
            <div class="d4p-feature-more-ctrl-options" style="display: none">
                <p><?php esc_html_e( "If you want, you can reset all the settings for this Feature to default values.", "d4plib" ); ?></p>
                <a class="button-primary" href="<?php echo esc_url( $_url_reset ); ?>"><?php esc_html_e( "Reset Feature Settings", "d4plib" ); ?></a>
            </div>
            <div class="d4p-panel-buttons">
                <input type="submit" value="<?php esc_attr_e( "Save Settings", "d4plib" ); ?>" class="button-primary"/>
            </div>
        </div>
        <div class="d4p-return-to-top">
            <a href="#wpwrap"><?php esc_html_e( "Return to top", "d4plib" ); ?></a>
        </div>
    </div>
</div>
