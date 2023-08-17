<?php

namespace Dev4Press\v42\Core\UI\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Render {
	public function __construct() {
	}

	/** @return Render */
	public static function instance() : Render {
		static $instance = null;

		if ( ! isset( $instance ) ) {
			$instance = new Render();
		}

		return $instance;
	}

	public function icon_class( $name, $modifiers = array(), $extra_class = '' ) : string {
		$dashicons = false;

		if ( substr( $name, 0, 9 ) == 'dashicons' ) {
			$dashicons = true;
			$class     = 'dashicons ' . $name;
		} else {
			$class = 'd4p-icon d4p-' . $name;
		}

		if ( ! empty( $modifiers ) && ! $dashicons ) {
			$modifiers = (array) $modifiers;

			foreach ( $modifiers as $key ) {
				$class .= ' ' . 'd4p-icon' . '-' . $key;
			}
		}

		if ( ! empty( $extra_class ) ) {
			$class .= ' ' . $extra_class;
		}

		return $class;
	}

	public function icon( $name = '', $modifiers = array(), $extra_class = '' ) : string {
		if ( empty( $name ) ) {
			return '';
		}

		$icon  = '<i aria-hidden="true" class="%s"></i> ';
		$class = $this->icon_class( $name, $modifiers, $extra_class );

		return sprintf( $icon, esc_attr( $class ) );
	}

	public function settings_group_break( $label, $icon = '' ) : string {
		$break = '<div class="d4p-feature-group-break">';
		$break .= '<h3 id="settings-group-break-' . sanitize_key( $label ) . '">' . $this->icon( $icon ) . $label . '</h2>';
		$break .= '</div>';

		return $break;
	}

	public function settings_break( $label, $icon = '' ) : string {
		$break = '<div class="d4p-feature-break">';
		$break .= '<h2 id="settings-break-' . sanitize_key( $label ) . '">' . $this->icon( $icon ) . $label . '</h3>';
		$break .= '</div>';

		return $break;
	}
}
