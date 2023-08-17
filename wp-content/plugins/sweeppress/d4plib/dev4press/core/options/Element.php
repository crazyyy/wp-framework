<?php

/*
Name:    Dev4Press\v42\Core\Options\Element
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

namespace Dev4Press\v42\Core\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Element {
	public $type;
	public $name;
	public $title;
	public $notice;
	public $input;
	public $value;
	public $source;

	public $data;
	public $args;
	public $switch;

	public function __construct( $type, $name, $title = '', $notice = '', $input = 'text', $value = '' ) {
		$this->type   = $type;
		$this->name   = $name;
		$this->title  = $title;
		$this->notice = $notice;
		$this->input  = $input;
		$this->value  = $value;
	}

	public static function i( $type, $name, $title = '', $notice = '', $input = 'text', $value = '' ) : Element {
		return new Element( $type, $name, $title, $notice, $input, $value );
	}

	public static function f( $name, $title = '', $notice = '', $input = '', $value = '' ) : Element {
		return new Element( 'features', $name, $title, $notice, $input, $value );
	}

	public static function s( $name, $title = '', $notice = '', $input = '', $value = '' ) : Element {
		return new Element( 'settings', $name, $title, $notice, $input, $value );
	}

	public static function l( $type, $name, $title = '', $notice = '', $input = 'text', $value = '', $source = '', $data = '', $args = array() ) : Element {
		return Element::i( $type, $name, $title, $notice, $input, $value )->data( $source, $data )->args( $args );
	}

	public static function info( $title = '', $notice = '' ) : Element {
		return Element::i( '', '', $title, $notice, Type::INFO );
	}

	public function data( $source = '', $data = '' ) : Element {
		$this->source = $source;
		$this->data   = $data;

		return $this;
	}

	public function args( $args = array() ) : Element {
		$this->args = $args;

		return $this;
	}

	public function switch( $args = array() ) : Element {
		$default = array(
			'type'  => 'option',
			'role'  => '',
			'value' => '',
			'ref'   => ''
		);

		$this->switch = wp_parse_args( $args, $default );

		return $this;
	}
}
