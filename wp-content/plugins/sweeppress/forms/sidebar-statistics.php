<?php

use Dev4Press\v42\Core\Quick\Sanitize;
use Dev4Press\v42\Core\UI\Elements;
use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$_panel     = panel()->a()->panel_object();
$_subpanel  = panel()->a()->subpanel;
$_subpanels = panel()->subpanels();

$list   = sweeppress_settings()->list_statistics();
$period = isset( $_GET['period'] ) ? Sanitize::slug( $_GET['period'] ) : '';

if ( ! isset( $list[ $period ] ) ) {
	$period = '';
}

?>
<div class="d4p-sidebar">
    <div class="d4p-panel-scroller d4p-scroll-active">
        <div class="d4p-panel-title">
            <div class="_icon">
				<?php echo panel()->r()->icon( $_panel->icon ); ?>
            </div>
            <h3><?php echo esc_html( $_panel->title ); ?></h3>
            <div class="_info">
				<?php esc_html_e( "Overview of the statistics gathered by the plugin with all time and monthly statistics.", "sweeppress" ); ?>
            </div>
        </div>
        <div class="d4p-panel-buttons">
            <form method="get">
                <input type="hidden" name="page" value="sweeppress-statistics"/>
                <label style="margin: 0 0 1em; display: block;">
                    <span><?php esc_html_e( "Choose Period", "sweeppress" ); ?>:</span>
					<?php Elements::instance()->select( $list, array(
						'selected' => $period,
						'class'    => 'widefat',
						'name'     => 'period',
					) ); ?>
                </label>
                <input type="submit" value="<?php esc_attr_e( "Load Data", "sweeppress" ); ?>" class="button-primary"/>
            </form>
        </div>
        <div class="d4p-return-to-top">
            <a href="#wpwrap"><?php esc_html_e( "Return to top", "sweeppress" ); ?></a>
        </div>
    </div>
</div>
