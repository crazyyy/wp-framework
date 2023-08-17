<?php

/*
Name:    Dev4Press\v42\Core\Options\Type
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

class Type {
	public const INFO = 'info';
	public const CUSTOM = 'custom';
	public const DATE = 'date';
	public const TIME = 'time';
	public const DATETIME = 'datetime';
	public const MONTH = 'month';
	public const IMAGE = 'image';
	public const IMAGES = 'images';
	public const BOOLEAN = 'bool';
	public const TEXT = 'text';
	public const TEXTAREA = 'textarea';
	public const SLUG = 'slug';
	public const SLUG_EXT = 'slug_ext';
	public const SLUG_SLASH = 'slug_slash';
	public const PASSWORD = 'password';
	public const FILE = 'file';
	public const TEXT_HTML = 'text_html';
	public const COLOR = 'color';
	public const RICH = 'rich';
	public const BLOCK = 'block';
	public const HTML = 'html';
	public const CODE = 'code';
	public const EMAIL = 'email';
	public const LINK = 'link';
	public const CHECKBOXES = 'checkboxes';
	public const CHECKBOXES_GROUP = 'checkboxes_group';
	public const CHECKBOXES_HIERARCHY = 'checkboxes_hierarchy';
	public const RADIOS = 'radios';
	public const RADIOS_HIERARCHY = 'radios_hierarchy';
	public const SELECT = 'select';
	public const SELECT_MULTI = 'select_multi';
	public const DROPDOWN_PAGES = 'dropdown_pages';
	public const DROPDOWN_CATEGORIES = 'dropdown_categories';
	public const GROUP = 'group';
	public const GROUP_MULTI = 'group_multi';
	public const NUMBER = 'number';
	public const INTEGER = 'integer';
	public const ABSINT = 'absint';
	public const RANGE_INTEGER = 'range_integer';
	public const RANGE_ABSINT = 'range_absint';
	public const CSS_SIZE = 'css_size';
	public const HIDDEN = 'hidden';
	public const LISTING = 'listing';
	public const X_BY_Y = 'x_by_y';
	public const EXPANDABLE_PAIRS = 'expandable_pairs';
	public const EXPANDABLE_TEXT = 'expandable_text';
	public const EXPANDABLE_RAW = 'expandable_raw';

	public static $_values = array(
		'info'                 => self::INFO,
		'custom'               => self::CUSTOM,
		'date'                 => self::DATE,
		'time'                 => self::TIME,
		'datetime'             => self::DATETIME,
		'month'                => self::MONTH,
		'image'                => self::IMAGE,
		'images'               => self::IMAGES,
		'bool'                 => self::BOOLEAN,
		'text'                 => self::TEXT,
		'textarea'             => self::TEXTAREA,
		'slug'                 => self::SLUG,
		'slug_ext'             => self::SLUG_EXT,
		'slug_slash'           => self::SLUG_SLASH,
		'password'             => self::PASSWORD,
		'file'                 => self::FILE,
		'text_html'            => self::TEXT_HTML,
		'color'                => self::COLOR,
		'rich'                 => self::RICH,
		'block'                => self::BLOCK,
		'html'                 => self::HTML,
		'code'                 => self::CODE,
		'email'                => self::EMAIL,
		'link'                 => self::LINK,
		'checkboxes'           => self::CHECKBOXES,
		'checkboxes_group'     => self::CHECKBOXES_GROUP,
		'checkboxes_hierarchy' => self::CHECKBOXES_HIERARCHY,
		'radios'               => self::RADIOS,
		'radios_hierarchy'     => self::RADIOS_HIERARCHY,
		'select'               => self::SELECT,
		'select_multi'         => self::SELECT_MULTI,
		'dropdown_pages'       => self::DROPDOWN_PAGES,
		'dropdown_categories'  => self::DROPDOWN_CATEGORIES,
		'group'                => self::GROUP,
		'group_multi'          => self::GROUP_MULTI,
		'number'               => self::NUMBER,
		'integer'              => self::INTEGER,
		'absint'               => self::ABSINT,
		'range_integer'        => self::RANGE_INTEGER,
		'range_absint'         => self::RANGE_ABSINT,
		'css_size'             => self::CSS_SIZE,
		'listing'              => self::LISTING,
		'hidden'               => self::HIDDEN,
		'x_by_y'               => self::X_BY_Y,
		'expandable_pairs'     => self::EXPANDABLE_PAIRS,
		'expandable_text'      => self::EXPANDABLE_TEXT,
		'expandable_raw'       => self::EXPANDABLE_RAW
	);

	public static function to_string( $value ) {
		if ( is_null( $value ) ) {
			return null;
		}

		if ( array_key_exists( $value, self::$_values ) ) {
			return self::$_values[ $value ];
		}

		return 'UNKNOWN';
	}
}
