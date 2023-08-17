<?php

/*
Name:    Dev4Press\v42\Core\Blocks\Register
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

namespace Dev4Press\v42\Core\Blocks;

use Dev4Press\v42\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Register {
	public function __construct() {
		add_action( 'init', array( $this, 'blocks' ), 20 );

		if ( WordPress::instance()->is_version_equal_or_higher( '5.8', 'wp' ) ) {
			add_filter( 'block_categories_all', array( $this, 'categories' ) );
		} else {
			add_filter( 'block_categories', array( $this, 'categories' ) );
		}

		add_filter( 'widget_types_to_hide_from_legacy_widget_block', array( $this, 'hide_equivalent_widgets' ) );
	}

	public function is_editor() : bool {
		return WordPress::instance()->is_rest() && isset( $_GET[ 'context' ] ) && $_GET[ 'context' ] === 'edit';
	}

	public function categories( array $categories ) : array {
		return $categories;
	}

	public function hide_equivalent_widgets( $widgets ) : array {
		return $widgets;
	}

	public function blocks() {

	}

	protected function _register_script() {

	}

	protected function _register_style() {

	}
}