<?php $_tab = $instance[ '_tab' ]; ?>

<div class="d4plib-widget <?php echo esc_attr( $this->widget_base ); ?>-wrapper">
    <div class="d4plib-widget-tabs" role="tablist">
        <input class="d4plib-widget-active-tab" value="<?php echo esc_attr( $_tab ); ?>" id="<?php echo $this->get_field_id( '_tab' ); ?>" name="<?php echo $this->get_field_name( '_tab' ); ?>" type="hidden"/>
		<?php

		foreach ( $tabs as $tab => $obj ) {
			$tabkey = $this->get_tabkey( $tab );

			$class    = 'd4plib-widget-tab d4plib-tabname-' . $tabkey;
			$class    .= ' d4plib-tab-' . $tab;
			$selected = 'false';

			if ( isset( $obj[ 'class' ] ) ) {
				$class .= ' ' . $obj[ 'class' ];
			}

			if ( $tab == $_tab ) {
				$class    .= ' d4plib-tab-active';
				$selected = 'true';
			}

			echo '<a tabindex="0" id="' . esc_attr( $tabkey ) . '-tab" aria-controls="' . esc_attr( $tabkey ) . '" aria-selected="' . esc_attr( $selected ) . '" role="tab" data-tabname="' . esc_attr( $tab ) . '" href="#' . esc_attr( $tabkey ) . '" class="' . esc_attr( $class ) . '">' . $obj[ 'name' ] . '</a>';
		}

		?>
    </div>
    <div class="d4plib-widget-tabs-content">
		<?php

		foreach ( $tabs as $tab => $obj ) {
			$tabkey = $this->get_tabkey( $tab );

			$class    = 'd4plib-tab-content d4plib-tabname-' . $tabkey;
			$class    .= ' d4plib-content-for-' . $tab;
			$selected = 'true';

			if ( isset( $obj[ 'class' ] ) ) {
				$class .= ' ' . $obj[ 'class' ];
			}

			if ( $tab == $_tab ) {
				$class    .= ' d4plib-content-active';
				$selected = 'false';
			}

			echo '<div id="' . esc_attr( $tabkey ) . '" aria-hidden="' . esc_attr( $selected ) . '" role="tabpanel" class="' . esc_attr( $class ) . '" aria-labelledby="' . esc_attr( $tabkey ) . '-tab">';

			foreach ( $obj[ 'include' ] as $inc ) {
				$template = $this->widgets_render->find( $inc . '.php' );

				include( $template );
			}

			echo '</div>';
		}

		?>
    </div>
</div>