<?php

/*
Name:    Dev4Press\v42\WordPress\Customizer\Control\Slider
Version: v4.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Copyright ==
Copyright 2008 - 2023 Milan Petrovic (email: support@dev4press.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>
*/

namespace Dev4Press\v42\WordPress\Customizer\Control;

use Dev4Press\v42\WordPress\Customizer\Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Slider extends Control {
	public $type = 'd4p-ctrl-slider';

	protected function render_content() {
		?>
        <div class="d4p-slider-ctrl">
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <input type="number"
                    id="<?php echo esc_attr( $this->id ); ?>"
                    name="<?php echo esc_attr( $this->id ); ?>"
                    value="<?php echo esc_attr( $this->value() ); ?>"
                    class="customize-control-slider-value" <?php $this->link(); ?> />
            <div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs[ 'min' ] ); ?>"
                    slider-max-value="<?php echo esc_attr( $this->input_attrs[ 'max' ] ); ?>"
                    slider-step-value="<?php echo esc_attr( $this->input_attrs[ 'step' ] ); ?>"></div>
            <span class="slider-reset dashicons dashicons-image-rotate"
                    slider-reset-value="<?php echo esc_attr( $this->default_value() ); ?>"></span>

			<?php if ( ! empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php } ?>
        </div>
		<?php

	}
}
