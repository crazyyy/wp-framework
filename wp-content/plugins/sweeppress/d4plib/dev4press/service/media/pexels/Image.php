<?php

/*
Name:    Dev4Press\v42\Service\Media\Pexels\Image
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

namespace Dev4Press\v42\Service\Media\Pexels;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image {
	public $id;
	public $url;
	public $name;
	public $slug;
	public $extension;

	public $width;
	public $height;

	public $images;

	public $photographer;

	public function __construct( $response ) {
		$this->id  = $response->id;
		$this->url = $response->url;

		$this->width  = $response->width;
		$this->height = $response->height;

		$this->photographer = (object) array(
			'id'   => $response->photographer_id,
			'name' => $response->photographer,
			'url'  => $response->photographer_url
		);

		$this->images = $response->src;

		preg_match( '/pexels\.com\/photo\/(.+?)-\d+?\//', $this->url, $output );

		if ( ! empty( $output ) && isset( $output[ 1 ] ) ) {
			$this->slug = $output[ 1 ];
			$this->name = str_replace( '-', ' ', $output[ 1 ] );
			$this->name = ucfirst( $this->name );
		}

		$this->extension = pathinfo( $this->images->original, PATHINFO_EXTENSION );
	}

	public function custom( $width, $height ) {
		$url = $this->images->original;

		$url = add_query_arg( 'auto', 'compress', $url );
		$url = add_query_arg( 'cs', 'tinysrgb', $url );
		$url = add_query_arg( 'fit', 'crop', $url );
		$url = add_query_arg( 'h', absint( $height ), $url );

		return add_query_arg( 'w', absint( $width ), $url );
	}
}
