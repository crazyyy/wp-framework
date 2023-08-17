<?php

/*
Name:    Dev4Press\v42\Core\UI\Micromodal
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

namespace Dev4Press\v42\Core\UI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Micromodal {
	protected $defaults_args = array(
		'modal-class'          => 'dev4press',
		'modal-name'           => '',
		'modal-title'          => 'Modal Dialog',
		'modal-close-label'    => 'Close the Modal',
		'modal-content'        => '',
		'modal-button-primary' => 'OK',
		'modal-button-close'   => 'Close'
	);
	protected $defaults_settings = array(
		'show-action-button' => true,
		'close-by-overlay'   => true,
		'close-by-cross'     => true,
		'close-by-button'    => true
	);
	protected $args = array();
	protected $settings = array();

	public function __construct() {

	}

	public static function instance() : Micromodal {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new Micromodal();
		}

		return $instance;
	}

	public function init( array $args, array $settings = array() ) {
		$this->args     = wp_parse_args( $args, $this->defaults_args );
		$this->settings = wp_parse_args( $settings, $this->defaults_settings );
	}

	public function dialog() : string {
		$html = $this->_open();
		$html .= $this->_header();
		$html .= $this->_content();
		$html .= $this->_footer();
		$html .= $this->_close();

		return $this->_replace( $html );
	}

	public function dialog_pre() : string {
		$html = $this->_open();
		$html .= $this->_header();
		$html .= '<main class="{{modal-class}}-modal__content" id="{{modal-class}}-modal-{{modal-name}}-content">';

		return $this->_replace( $html );
	}

	public function dialog_post() : string {
		$html = '</main>';
		$html .= $this->_footer();
		$html .= $this->_close();

		return $this->_replace( $html );
	}

	protected function _replace( $html ) : string {
		foreach ( $this->args as $key => $value ) {
			$html = str_replace( '{{' . $key . '}}', $value, $html );
		}

		return $html;
	}

	protected function _open() : string {
		return '<div data-modal="{{modal-name}}" class="micromodal-dialog-wrapper {{modal-class}}-modal {{modal-class}}-modal-slide" id="{{modal-class}}-modal-{{modal-name}}" aria-hidden="true">
    <div class="{{modal-class}}-modal__overlay" tabindex="-1"' . ( $this->settings[ 'close-by-overlay' ] ? ' data-micromodal-close' : '' ) . '>
        <div class="{{modal-class}}-modal__container" role="dialog" aria-modal="true" aria-labelledby="{{modal-class}}-modal-{{modal-name}}-title">';
	}

	protected function _header() : string {
		return '<header class="{{modal-class}}-modal__header">
                <h2 class="{{modal-class}}-modal__title" id="{{modal-class}}-modal-{{modal-name}}-title">{{modal-title}}</h2>
                ' . ( $this->settings[ 'close-by-cross' ] ? '<button type="button" class="{{modal-class}}-modal__close" aria-label="{{modal-close-label}}" data-micromodal-close></button>' : '' ) . '
            </header>';
	}

	protected function _content() : string {
		return '<main class="{{modal-class}}-modal__content" id="{{modal-class}}-modal-{{modal-name}}-content">
                {{modal-content}}
            </main>';
	}

	protected function _footer() : string {
		return '<footer class="{{modal-class}}-modal__footer">
                ' . ( $this->settings[ 'show-action-button' ] ? '<button type="button" id="{{modal-class}}-modal-{{modal-name}}-submit" class="{{modal-class}}-modal__btn {{modal-class}}-modal__btn-primary">{{modal-button-primary}}</button>' : '' ) . '
                ' . ( $this->settings[ 'close-by-button' ] ? '<button type="button" class="{{modal-class}}-modal__btn" data-micromodal-close>{{modal-button-close}}</button>' : '' ) . '
            </footer>';
	}

	protected function _close() : string {
		return '        </div>
    </div>
</div>';
	}
}
