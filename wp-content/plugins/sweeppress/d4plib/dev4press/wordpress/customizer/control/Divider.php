<?php

/*
Name:    Dev4Press\v42\WordPress\Customizer\Control\Divider
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

use Dev4Press\v42\Core\Quick\KSES;
use Dev4Press\v42\WordPress\Customizer\Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Divider extends Control {
	public $type = 'd4p-ctrl-divider';

	protected function render_content() {
		$show_hr = true;

		if ( isset( $this->input_attrs[ 'hide_line' ] ) && $this->input_attrs[ 'hide_line' ] === true ) {
			$show_hr = false;
		}

		if ( $show_hr ) {
			echo '<hr/>';
		}

		?>

		<?php if ( ! empty( $this->label ) ) : ?>
            <label for="_customize-input-<?php echo esc_attr( $this->id ); ?>"
                    class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
		<?php endif;
		if ( ! empty( $this->description ) ) : ?>
            <span id="_customize-description-<?php echo esc_attr( $this->id ); ?>"
                    class="description customize-control-description"><?php echo KSES::post( $this->description ); ?></span>
		<?php endif;
	}
}
