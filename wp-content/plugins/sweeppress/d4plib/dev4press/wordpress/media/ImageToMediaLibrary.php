<?php

/*
Name:    Dev4Press\v42\WordPress\Media\ImageToMediaLibrary
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

namespace Dev4Press\v42\WordPress\Media;

use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait ImageToMediaLibrary {
	public $url;
	public $path;

	public $ext;
	public $name;
	public $file;

	public $data = array();

	protected $_test_type = true;
	protected $_title_for_name = false;
	protected $_mimes = false;

	protected function _sideload( $temp ) {
		clearstatcache();

		$mime_type = wp_check_filetype( $this->file, $this->_mimes );

		$file = array(
			'name'     => $this->_title_for_name ?
				$this->data[ 'slug' ] . '.' . $this->ext : $this->file,
			'type'     => $mime_type[ 'type' ],
			'tmp_name' => $temp,
			'error'    => 0,
			'size'     => filesize( $temp )
		);

		$overrides = array(
			'action'      => 'd4p_image_sideload',
			'test_form'   => false,
			'test_size'   => true,
			'test_upload' => true,
			'test_type'   => $this->_test_type
		);

		$attr = wp_handle_sideload( $file, $overrides );

		if ( isset( $attr[ 'error' ] ) ) {
			return new WP_Error( 'sideload_error', $attr[ 'error' ] );
		}

		return $attr;
	}

	protected function _attach( $file, $post_parent = 0 ) {
		$wp_upload_dir = wp_upload_dir();

		$path = str_replace( $wp_upload_dir[ 'basedir' ] . '/', '', $file[ 'file' ] );

		$attachment_id = wp_insert_attachment( array(
			'guid'           => $file[ 'url' ],
			'post_mime_type' => $file[ 'type' ],
			'post_title'     => ! empty( $this->data[ 'title' ] ) ?
				$this->data[ 'title' ] : preg_replace( '/\.[^.]+$/', '', basename( $file[ 'file' ] ) ),
			'post_name'      => $this->data[ 'slug' ],
			'post_content'   => $this->data[ 'description' ],
			'post_excerpt'   => $this->data[ 'caption' ],
			'post_status'    => 'inherit'
		), $path, $post_parent );

		if ( is_wp_error( $attachment_id ) ) {
			return $attachment_id;
		}

		$attach_data = wp_generate_attachment_metadata( $attachment_id, $file[ 'file' ] );
		wp_update_attachment_metadata( $attachment_id, $attach_data );

		if ( ! empty( $this->data[ 'alt' ] ) ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $this->data[ 'alt' ] );
		}

		return $attachment_id;
	}

	protected function _init() {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	}

	protected function _prepare( $args ) {
		$this->name = sanitize_title( pathinfo( $this->data[ 'name' ], PATHINFO_FILENAME ) );
		$this->ext  = pathinfo( $this->data[ 'name' ], PATHINFO_EXTENSION );

		if ( $this->ext == 'jpeg' ) {
			$this->ext = 'jpg';
		}

		if ( empty( $this->data[ 'slug' ] ) ) {
			if ( ! empty( $this->data[ 'title' ] ) ) {
				$this->data[ 'slug' ] = sanitize_title( $this->data[ 'title' ] );
			} else {
				$this->data[ 'slug' ] = sanitize_title( $this->name );
			}
		}

		if ( empty( $this->data[ 'alt' ] ) && ! empty( $this->data[ 'title' ] ) ) {
			$this->data[ 'alt' ] = $this->data[ 'title' ];
		}

		$this->file = $this->name . '.' . $this->ext;

		if ( is_array( $args[ 'mimes' ] ) && ! empty( $args[ 'mimes' ] ) ) {
			$this->_mimes = $args[ 'mimes' ];
		}

		if ( isset( $args[ 'test_type' ] ) && $args[ 'test_type' ] == false ) {
			$this->_test_type = false;
		}

		if ( isset( $args[ 'title_for_name' ] ) && $args[ 'title_for_name' ] == true ) {
			$this->_title_for_name = true;
		}
	}
}
