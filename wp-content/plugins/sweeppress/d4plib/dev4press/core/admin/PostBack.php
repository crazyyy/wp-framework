<?php

/*
Name:    Dev4Press\v42\Core\Admin\PostBack
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

namespace Dev4Press\v42\Core\Admin;

use Dev4Press\v42\Core\Options\Process;
use Dev4Press\v42\Core\Quick\Sanitize;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class PostBack {
	protected $admin;
	protected $page;

	public function __construct( $admin ) {
		$this->admin = $admin;

		$this->page = isset( $_POST[ 'option_page' ] ) ? Sanitize::key( $_POST[ 'option_page' ] ) : false;

		if ( $this->page !== false ) {
			$this->process();
		}
	}

	/** @return \Dev4Press\v42\Core\Admin\Plugin|\Dev4Press\v42\Core\Admin\Menu\Plugin|\Dev4Press\v42\Core\Admin\Submenu\Plugin */
	public function a() {
		return $this->admin;
	}

	public function p() {
		return $this->page;
	}

	protected function get_page_name( $name ) : string {
		return $this->a()->plugin . '-' . $name;
	}

	protected function check_referer( $name ) {
		check_admin_referer( $this->get_page_name( $name ) . '-options' );
	}

	protected function process() {
		if ( $this->p() == $this->get_page_name( 'tools' ) ) {
			$this->check_referer( 'tools' );

			$this->tools();
		}

		if ( $this->p() == $this->get_page_name( 'settings' ) ) {
			$this->check_referer( 'settings' );

			$this->settings();
		}

		if ( $this->p() == $this->get_page_name( 'features' ) ) {
			$this->check_referer( 'features' );

			$this->features();
		}
	}

	protected function tools() {
		if ( $this->a()->subpanel == 'remove' ) {
			$this->remove();
		} else if ( $this->a()->subpanel == 'import' ) {
			$this->import();
		}
	}

	protected function settings() {
		$base = $this->a()->settings_definitions()->settings( $this->a()->subpanel );
		$this->_process_save_data( $base );

		$filter = $this->a()->h( 'settings_saved_for_' . $this->a()->subpanel );

		do_action( $filter );

		wp_redirect( $this->a()->current_url() . '&message=saved' );
		exit;
	}

	protected function features() {
		$base = $this->a()->features_definitions( $this->a()->subpanel )->settings();
		$this->_process_save_data( $base );

		$filter = $this->a()->h( 'settings_saved_for_feature_' . $this->a()->subpanel );

		do_action( $filter );

		wp_redirect( $this->a()->current_url() . '&message=saved' );
		exit;
	}

	protected function import() {
		$url = $this->a()->current_url();

		$message = 'import-failed';

		if ( is_uploaded_file( $_FILES[ 'import_file' ][ 'tmp_name' ] ) ) {
			$raw  = file_get_contents( $_FILES[ 'import_file' ][ 'tmp_name' ] );
			$data = json_decode( $raw, true );

			if ( is_array( $data ) && ! empty( $data ) ) {
				$result = $this->a()->settings()->import_from_secure_json( $data );

				if ( $result === true ) {
					$message = 'imported';
				}
			}
		}

		wp_redirect( $url . '&message=' . $message );
		exit;
	}

	protected function _process_save_data( $base ) {
		$data   = Process::instance( $this->a()->n(), $this->a()->plugin_prefix )->prepare( $base )->process();
		$filter = $this->a()->h( 'settings_save_settings_value' );

		foreach ( $data as $group => $values ) {
			if ( ! empty( $group ) ) {
				foreach ( $values as $name => $value ) {
					$value = apply_filters( $filter, $value, $name, $group );

					$this->a()->settings()->set( $name, $value, $group );
				}

				$this->a()->settings()->save( $group );
			}
		}
	}

	abstract protected function remove();
}
