<?php

use Dev4Press\v42\Core\Quick\Sanitize;
use function Dev4Press\v42\Functions\panel;

?>
<div class="d4p-content">
    <div class="d4p-features-wrapper">
		<?php

		foreach ( panel()->subpanels() as $subpanel => $obj ) {
			if ( $subpanel == 'index' || $subpanel == 'full' ) {
				continue;
			}

			$_classes = array(
				'd4p-feature-box',
				'settings-' . $subpanel,
				'_is-settings'
			);

			$url = panel()->a()->panel_url( 'settings', $subpanel );

			if ( isset( $obj[ 'break' ] ) ) {
				echo panel()->r()->settings_break( $obj[ 'break' ], $obj[ 'break-icon' ] );
			}

			?>

            <div class="<?php echo Sanitize::html_classes( $_classes ); ?>">
                <div class="_info">
                    <div class="_icon"><i class="d4p-icon d4p-<?php echo esc_attr( $obj[ 'icon' ] ); ?>"></i></div>
                    <h4 class="_title"><?php echo esc_html( $obj[ 'title' ] ); ?></h4>
                    <p class="_description"><?php echo esc_html( $obj[ 'info' ] ); ?></p>
                </div>
                <div class="_ctrl">
                    <div class="_open">
                        <a class="button-primary" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( "Open", "d4plib" ); ?></a>
                    </div>
                </div>
            </div>

			<?php

		}

		?>
    </div>
</div>
