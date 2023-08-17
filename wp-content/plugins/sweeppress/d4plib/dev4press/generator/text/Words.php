<?php

/*
Name:    Dev4Press\v42\Generator\Text\Words
Version: v4.2
Author:  Milan Petrovic
Email:   support@dev4press.com
Website: https://www.dev4press.com/

== Notice ==
Based on the LoremIpsum script by Josh Sherman
https://github.com/joshtronic/php-loremipsum

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

namespace Dev4Press\v42\Generator\Text;

abstract class Words extends Generator {
	protected $first = false;
	protected $first_count = 0;

	protected $words = array();

	public function words( $count = 1, $tags = false, $array = false ) {
		$words      = array();
		$word_count = 0;

		while ( $word_count < $count ) {
			$shuffle = true;

			while ( $shuffle ) {
				$this->shuffle();

				if ( ! $word_count || $words[ $word_count - 1 ] != $this->words[ 0 ] ) {
					$words      = array_merge( $words, $this->words );
					$word_count = count( $words );
					$shuffle    = false;
				}
			}
		}

		$words = array_slice( $words, 0, $count );

		return $this->output( $words, $tags, $array );
	}

	public function protected_first( $count = 0 ) {
		if ( $count == 0 ) {
			$this->first       = false;
			$this->first_count = 0;
		} else {
			$this->first       = true;
			$this->first_count = $count;
		}

		return $this;
	}

	private function shuffle() {
		if ( $this->first && $this->first_count > 0 ) {
			$this->first = array_slice( $this->words, 0, $this->first_count );
			$this->words = array_slice( $this->words, $this->first_count );

			shuffle( $this->words );

			$this->words = $this->first + $this->words;

			$this->first = false;
		} else {
			shuffle( $this->words );
		}
	}
}
