<?php

use Dev4Press\v42\Core\Quick\KSES;
use function Dev4Press\v42\Functions\panel;

?>
<div class="d4p-sidebar">
    <div class="d4p-dashboard-badge" style="background-color: <?php echo esc_attr( panel()->a()->settings()->i()->color() ); ?>;">
        <div class="_icon">
			<?php echo panel()->r()->icon( 'plugin-' . panel()->a()->plugin, '9x' ); ?>
        </div>
        <h3>
			<?php echo esc_html( panel()->a()->title() ); ?>
        </h3>
        <div class="_version-wrapper">
            <span class="_edition"><?php echo esc_html( ucfirst( panel()->a()->settings()->i()->edition ) ); ?></span>
            <span class="_version"><?php echo KSES::strong( sprintf( __( "Version: %s", "d4plib" ), '<strong>' . esc_html( panel()->a()->settings()->i()->version_full() ) . '</strong>' ) ); ?></span>
        </div>
    </div>

	<?php

	if ( panel()->a()->buy_me_a_coffee ) {
		?>

        <div class="d4p-links-group buy-me-a-coffee">
            <a href="https://www.buymeacoffee.com/millan" target="_blank" rel="noopener">
                <img alt="BuyMeACoffee" src="<?php echo esc_url( panel()->a()->url . 'd4plib/resources/gfx/buy_me_a_coffee.png' ); ?>"/>
            </a>
        </div>

		<?php
	}

	foreach ( panel()->sidebar_links as $group ) {
		if ( ! empty( $group ) ) {
			echo '<div class="d4p-links-group">';

			foreach ( $group as $link ) {
				echo '<a class="' . esc_attr( $link[ 'class' ] ) . '" href="' . esc_url( $link[ 'url' ] ) . '">' . panel()->r()->icon( $link[ 'icon' ] ) . '<span>' . $link[ 'label' ] . '</span></a>';
			}

			echo '</div>';
		}
	}

	?>
</div>
