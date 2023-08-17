<?php

use Dev4Press\v42\Core\Quick\Sanitize;
use function Dev4Press\v42\Functions\panel;

$_panels    = panel()->a()->panels();
$_subpanels = panel()->subpanels();
$_subpanel  = panel()->current_subpanel();
$_classes   = panel()->wrapper_class();

$_plugin_title = sprintf(
	__( "Welcome to %s%s %s", "d4plib" ),
	panel()->a()->title(),
	panel()->a()->settings()->i()->is_pro() ? ' Pro' : '',
	panel()->a()->settings()->i()->version
);

?>
<div class="<?php echo Sanitize::html_classes( $_classes ); ?>">
    <div class="d4p-about-head-wrapper">
        <div class="d4p-about-information">
            <h1><?php echo esc_html( $_plugin_title ); ?></h1>
            <p class="d4p-about-text">
				<?php echo panel()->a()->settings()->i()->description(); ?>
            </p>
        </div>
        <div class="d4p-about-badge">
            <div class="d4p-about-badge-inner" style="background-color: <?php echo esc_attr( panel()->a()->settings()->i()->color() ); ?>;">
				<?php echo panel()->r()->icon( 'plugin-' . panel()->a()->plugin ); ?>
				<?php printf( __( "Version %s", "d4plib" ), panel()->a()->settings()->i()->version ); ?>
            </div>
        </div>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
		<?php

		if ( panel()->a()->variant == 'submenu' ) {
			echo '<a href="' . esc_url( panel()->a()->panel_url() ) . '" class="nav-tab"><i class="d4p-icon d4p-ui-home"></i></a>';
		}

		foreach ( $_subpanels as $_tab => $obj ) {
			echo '<a href="' . esc_url( panel()->a()->panel_url( 'about', $_tab ) ) . '" class="nav-tab' . ( $_tab == $_subpanel ? ' nav-tab-active' : '' ) . '">' . esc_html( $obj[ 'title' ] ) . '</a>';
		}

		?>
    </h2>

    <div class="d4p-about-inner">
