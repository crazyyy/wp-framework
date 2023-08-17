<?php

use Dev4Press\v42\Core\Quick\KSES;
use Dev4Press\v42\Core\Quick\Sanitize;
use function Dev4Press\v42\Functions\panel;

$_scope_labels = array(
	'global' => __( "Global", "d4plib" ),
	'front'  => __( "Frontend", "d4plib" ),
	'admin'  => __( "Admin", "d4plib" )
);

$_scope_icons = array(
	'global' => 'd4p-ui-globe',
	'front'  => 'd4p-ui-desktop',
	'admin'  => 'd4p-ui-dashboard'
);

?>
<div class="d4p-content">
	<?php include( "content-features-index-filter.php" ); ?>

    <div class="d4p-features-wrapper">
		<?php

		foreach ( panel()->subpanels() as $subpanel => $obj ) {
			if ( $subpanel == 'index' ) {
				continue;
			}

			$_checked = '';
			$_classes = array(
				'd4p-feature-box',
				'feature-' . $subpanel,
				'scope-' . $obj[ 'scope' ],
				'_is-feature'
			);

			if ( $obj[ 'active' ] ) {
				$_classes[] = '_is-active';
				$_checked   = ' checked="checked"';
			}

			if ( $obj[ 'always_on' ] ) {
				$_classes[] = '_is-always-on';
			}

			if ( $obj[ 'hidden' ] ) {
				$_classes[] = '_is-hidden';
			}

			if ( $obj[ 'beta' ] ) {
				$_classes[] = '_is-beta';
			}

			if ( $obj[ 'settings' ] ) {
				$_classes[] = '_has-settings';
			}

			if ( $obj[ 'panel' ] ) {
				$_classes[] = '_has-panel';
			}

			$url = panel()->a()->panel_url( 'features', $subpanel );

			?>

            <div data-feature="<?php echo esc_attr( $subpanel ); ?>" class="<?php echo Sanitize::html_classes( $_classes ); ?>">
                <div class="_info">
                    <div class="_icon"><i class="d4p-icon d4p-<?php echo esc_attr( $obj[ 'icon' ] ); ?>"></i></div>
                    <h4 class="_title"><?php echo esc_html( $obj[ 'title' ] ); ?></h4>
                    <p class="_description"><?php echo esc_html( $obj[ 'info' ] ); ?></p>
                </div>
                <div class="_ctrl">
                    <div class="_activation">
						<?php if ( ! $obj[ 'always_on' ] && ! $obj[ 'hidden' ] ) { ?>
                            <input<?php echo $_checked; ?> data-feature="<?php echo esc_attr( $subpanel ); ?>" id="d4p-feature-toggle-<?php echo esc_attr( $subpanel ); ?>" type="checkbox"/>
                            <label for="d4p-feature-toggle-<?php echo esc_attr( $subpanel ); ?>"><span class="d4p-accessibility-show-for-sr"><?php esc_html_e( "Active", "d4plib" ); ?></span></label>
						<?php }
						if ( $obj[ 'hidden' ] ) { ?>
                            <span title="<?php esc_html_e( "This feature can't be enabled because of the missing prerequisites.", "d4plib" ); ?>"><i class="d4p-icon d4p-ui-toggle-slash"></i></span>
						<?php } ?>
                    </div>
                    <div class="_settings">
						<?php if ( $obj[ 'hidden' ] ) { ?>
                            <span title="<?php esc_html_e( "This feature can't be enabled at this time.", "d4plib" ); ?>"><i class="d4p-icon d4p-ui-cog-slash"></i></span>
						<?php } else {
							if ( $obj[ 'settings' ] ) { ?>
                                <a title="<?php echo KSES::standard( sprintf( __( "Settings for '%s'", "d4plib" ), $obj[ 'title' ] ) ); ?>" href="<?php echo esc_url( $url ); ?>"><i class="d4p-icon d4p-ui-cog"></i></a>
							<?php } else { ?>
                                <span title="<?php esc_html_e( "This feature has no settings", "d4plib" ); ?>"><i class="d4p-icon d4p-ui-cog-slash"></i></span>
							<?php }
						} ?>
                    </div>
					<?php if ( $obj[ 'panel' ] ) { ?>
                        <div class="_scope">
                            <span title="<?php esc_html_e( "This feature adds a new panel", "d4plib" ); ?>"><i class="d4p-icon d4p-ui-folder"></i></span>
                        </div>
					<?php } ?>
					<?php if ( $obj[ 'beta' ] ) { ?>
                        <div class="_scope">
                            <span title="<?php esc_attr_e( "This is a Beta feature, and it can be unstable!", "d4plib" ); ?>"><i class="d4p-icon d4p-ui-flask"></i></span>
                        </div>
					<?php } ?>
                    <div class="_scope">
                        <span title="<?php echo esc_attr( $_scope_labels[ $obj[ 'scope' ] ] ); ?>"><i class="d4p-icon <?php echo esc_attr( $_scope_icons[ $obj[ 'scope' ] ] ); ?>"></i></span>
                    </div>
                </div>
            </div>

			<?php

		}

		?>
    </div>
</div>
