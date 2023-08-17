<?php

/*
Name:    Dev4Press\v42\Service\Media\Pixabay\Video
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

namespace Dev4Press\v42\Service\Media\Pixabay;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Video {
	public $id;
	public $type;
	public $url;
	public $likes;
	public $views;
	public $downloads;
	public $favorites;
	public $comments;
	public $tags;
	public $name;

	public $vimeo_id;

	public $user;

	public function __construct( $response ) {
		$this->id        = $response->id;
		$this->vimeo_id  = $response->picture_id;
		$this->type      = $response->type;
		$this->url       = $response->pageURL;
		$this->likes     = $response->likes;
		$this->views     = $response->views;
		$this->downloads = $response->downloads;
		$this->favorites = $response->favorites;
		$this->comments  = $response->comments;

		$this->user = (object) array(
			'id'    => $response->user_id,
			'name'  => $response->user,
			'image' => (object) array( 'url' => $response->userImageURL )
		);

		$this->tags = explode( ',', $response->tags );
		$this->tags = array_map( 'trim', $this->tags );

		$this->name = ucwords( join( ' ', $this->tags ) );

		foreach ( $response->videos as $key => $video ) {
			$video->preview = 'https://i.vimeocdn.com/video/' . $this->vimeo_id . '_' . $video->width . 'x' . $video->height . '.jpg';

			$this->$key = $video;
		}
	}
}
