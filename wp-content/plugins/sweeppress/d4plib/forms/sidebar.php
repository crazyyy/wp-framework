<?php

use function Dev4Press\v42\Functions\panel;

$_panel = panel()->object();

?>

<div class="d4p-sidebar">
    <div class="d4p-panel-title">
        <div class="_icon">
			<?php echo panel()->r()->icon( $_panel->icon ); ?>
        </div>
        <h3><?php echo esc_html( $_panel->title ); ?></h3>

        <div class="_info">
			<?php

			echo esc_html( $_panel->info );

			if ( isset( $_panel->kb ) ) {
				$url   = $_panel->kb[ 'url' ];
				$label = $_panel->kb[ 'label' ] ?? __( "Knowledge Base", "d4plib" );

				?>

                <div class="_kb">
                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $label ); ?></a>
                </div>

				<?php
			}

			?>
        </div>
    </div>
</div>
