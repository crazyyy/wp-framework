<?php

use Dev4Press\v42\Core\Quick\Sanitize;
use function Dev4Press\v42\Functions\panel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$_panels    = panel()->a()->panels();
$_subpanels = panel()->subpanels();
$_plugin    = panel()->a()->plugin;
$_panel     = panel()->a()->panel;
$_subpanel  = panel()->a()->subpanel;

if ( ! empty( $_subpanels ) ) {
	$_available = array_keys( $_subpanels );

	if ( ! in_array( $_subpanel, $_available ) ) {
		$_subpanel = 'index';
	}
}

$_classes = array(
	'd4p-wrap',
	'd4p-plugin-' . $_plugin,
	'd4p-panel-' . ( $_panel == 'jobs' ? 'dashboard' : $_panel ),
);

if ( ! empty( $_subpanel ) ) {
	$_classes[] = 'd4p-subpanel-' . $_subpanel;
}

if ( panel()->has_sidebar() ) {
	$_classes[] = 'd4p-with-sidebar';
} else {
	$_classes[] = 'd4p-full-width';
}

if ( isset( $_panels[ $_panel ]['table'] ) && $_panels[ $_panel ]['table'] ) {
	$_classes[] = 'd4p-with-table';
}

if ( panel()->a()->auto_mod_interface_colors ) {

	?>
    <style>
        .<?php echo 'd4p-plugin-'.esc_html( $_plugin ); ?> {
            --d4p-color-layout-accent: <?php echo esc_html( panel()->a()->settings()->i()->color() ); ?>;
            --d4p-color-sidebar-icon-text: <?php echo esc_html( panel()->a()->settings()->i()->color() ); ?>;
        }
    </style>
	<?php

}

?>
<div class="<?php echo Sanitize::html_classes( $_classes ); ?>">
	<?php panel()->include_notices(); ?>

    <div class="d4p-header">
        <div class="d4p-navigator">
            <ul>
                <li class="d4p-nav-button">
                    <a href="#"><?php echo panel()->r()->icon( $_panels[ $_panel ]['icon'] ); ?><?php echo $_panels[ $_panel ]['title']; ?></a>
					<?php if ( $_panel != 'install' && $_panel != 'update' ) { ?>
                        <ul>
							<?php

							foreach ( $_panels as $panel => $obj ) {
								if ( ! isset( $obj['type'] ) ) {
									if ( $panel != $_panel ) {
										echo '<li><a href="' . esc_url( panel()->a()->panel_url( $panel ) ) . '">' . panel()->r()->icon( $obj['icon'], 'fw' ) . $obj['title'] . '</a></li>';
									} else {
										echo '<li class="d4p-nav-current">' . panel()->r()->icon( $obj['icon'], 'fw' ) . $obj['title'] . '</li>';
									}
								}
							}

							?>
                        </ul>
					<?php } ?>
                </li>
				<?php if ( ! empty( $_subpanels ) ) { ?>
                    <li class="d4p-nav-button">
                        <a href="#"><?php echo panel()->r()->icon( $_subpanels[ $_subpanel ]['icon'] ); ?><?php echo esc_html( $_subpanels[ $_subpanel ]['title'] ); ?></a>
                        <ul>
							<?php

							foreach ( $_subpanels as $subpanel => $obj ) {
								if ( $subpanel != $_subpanel ) {
									echo '<li><a href="' . esc_url( panel()->a()->panel_url( $_panel, $subpanel ) ) . '">' . panel()->r()->icon( $obj['icon'], 'fw' ) . esc_html( $obj['title'] ) . '</a></li>';
								} else {
									echo '<li class="d4p-nav-current">' . panel()->r()->icon( $obj['icon'], 'fw' ) . esc_html( $obj['title'] ) . '</li>';
								}
							}

							?>
                        </ul>
                    </li>
				<?php } ?>
            </ul>
        </div>
        <div class="d4p-plugin">
			<?php echo panel()->a()->title(); ?>
        </div>
    </div>
	<?php panel()->include_messages(); ?>
    <div class="d4p-main">
