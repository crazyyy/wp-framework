<?php

/*
Name:    Dev4Press\v42\WordPress\Customizer\Section\Link
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

namespace Dev4Press\v42\WordPress\Customizer\Section;

use WP_Customize_Section;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Link extends WP_Customize_Section {
	public $type = 'd4p-section-link';

	public $url = '';
	public $backcolor = '';
	public $textcolor = '';

	protected function render() {
		$_back = ! empty( $this->backcolor ) ? esc_attr( $this->backcolor ) : '#ffffff';
		$_text = ! empty( $this->textcolor ) ? esc_attr( $this->textcolor ) : '#555d66';

		?>
        <li id="accordion-section-<?php echo esc_attr( $this->type ); ?>"
                class="d4p-link-section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
            <h3 class="d4p-link-section-title" <?php echo ' style="color:' . esc_attr( $_text ) . ';border-left-color:' . esc_attr( $_back ) . ';border-right-color:' . esc_attr( $_back ) . ';"'; ?>>
                <a href="<?php echo esc_url( $this->url ); ?>" rel="noopener"
                        target="_blank"<?php echo ' style="background-color:' . esc_attr( $_back ) . ';color:' . esc_attr( $_text ) . ';"'; ?>><?php echo esc_html( $this->title ); ?></a>
            </h3>
        </li>
		<?php

	}
}
