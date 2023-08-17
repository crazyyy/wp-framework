<?php

/*
Name:    Dev4Press\v42\API\Languages
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

namespace Dev4Press\v42\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Languages {
	private static $_current_instance = null;

	public $list = array(
		'bg_BG' => array( 'native' => 'Български', 'english' => 'Bulgarian' ),
		'cs_CZ' => array( 'native' => 'Čeština', 'english' => 'Czech' ),
		'da_DK' => array( 'native' => 'Dansk', 'english' => 'Danish' ),
		'de_AT' => array( 'native' => 'Deutsch Österreich', 'english' => 'German Austria' ),
		'de_CH' => array( 'native' => 'Deutsch Schweiz', 'english' => 'German Switzerland' ),
		'de_DE' => array( 'native' => 'Deutsch', 'english' => 'German' ),
		'es_AR' => array( 'native' => 'Español de Argentina', 'english' => 'Spanish Argentina' ),
		'es_ES' => array( 'native' => 'Español', 'english' => 'Spanish' ),
		'es_MX' => array( 'native' => 'Español de México', 'english' => 'Spanish Mexico' ),
		'et'    => array( 'native' => 'Eesti', 'english' => 'Estonian' ),
		'fi'    => array( 'native' => 'Suomi', 'english' => 'Finnish' ),
		'fr_BE' => array( 'native' => 'Français de Belgique', 'english' => 'French Belgian' ),
		'fr_CA' => array( 'native' => 'Français Canadien', 'english' => 'French Canadian' ),
		'fr_FR' => array( 'native' => 'Français', 'english' => 'French' ),
		'hr'    => array( 'native' => 'Hrvatski', 'english' => 'Croatian' ),
		'hu_HU' => array( 'native' => 'Magyar', 'english' => 'Hungarian' ),
		'it_IT' => array( 'native' => 'Italiano', 'english' => 'Italian' ),
		'ja'    => array( 'native' => '日本語', 'english' => 'Japanese' ),
		'lt_LT' => array( 'native' => 'Lietuvių kalba', 'english' => 'Lithuanian' ),
		'lv_LV' => array( 'native' => 'Latviešu valoda', 'english' => 'Latvian' ),
		'nl_NL' => array( 'native' => 'Nederlands', 'english' => 'Dutch' ),
		'pl_PL' => array( 'native' => 'Polski', 'english' => 'Polish' ),
		'pt_BR' => array( 'native' => 'Português do Brasil', 'english' => 'Brazilian Portuguese' ),
		'pt_PT' => array( 'native' => 'Português', 'english' => 'Portuguese' ),
		'ro_RO' => array( 'native' => 'Română', 'english' => 'Romanian' ),
		'ru_RU' => array( 'native' => 'Русский', 'english' => 'Russian' ),
		'sl_SI' => array( 'native' => 'Slovenščina', 'english' => 'Slovenian' ),
		'sr_RS' => array( 'native' => 'Српски', 'english' => 'Serbian' ),
		'sv_SE' => array( 'native' => 'Svenska', 'english' => 'Swedish' )
	);

	public function __construct() {
	}

	public static function instance() : Languages {
		if ( is_null( self::$_current_instance ) ) {
			self::$_current_instance = new Languages();
		}

		return self::$_current_instance;
	}

	public function plugin_translations( $translations ) : array {
		$list = array();

		foreach ( $translations as $code => $obj ) {
			if ( isset( $this->list[ $code ] ) ) {
				$list[ $code ] = array_merge( $this->list[ $code ] + $obj );

				if ( ! isset( $list[ $code ][ 'contributors' ] ) ) {
					$list[ $code ] += array( 'contributors' => array() );
				}
			}
		}

		return $list;
	}
}
