<?php

/*
Name:    Dev4Press\v42\WordPress\Customizer\Control\Notice
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

class Notice extends Control {
	public $type = 'd4p-ctrl-notice';

	protected function render_content() {
		?>
        <div class="d4p-notice-ctrl">
			<?php if ( ! empty( $this->label ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<?php if ( ! empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo KSES::standard( $this->description ); ?></span>
			<?php } ?>
        </div>
		<?php

	}
}
