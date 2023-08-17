<?php

/*
Name:    Dev4Press\v42\Generator\Text\Generator
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Generator {
	protected $sentence_mean = 24.46;
	protected $sentence_dev = 5.08;

	protected $paragraph_mean = 5.8;
	protected $paragraph_dev = 1.93;

	public function __construct() {
	}

	public function word( $tags = false ) {
		return $this->words( 1, $tags );
	}

	public function sentence( $tags = false ) {
		return $this->sentences( 1, $tags );
	}

	public function sentences( $count = 1, $tags = false, $array = false ) {
		$sentences = array();

		for ( $i = 0; $i < $count; $i ++ ) {
			$sentences[] = $this->words( $this->gauss( $this->sentence_mean, $this->sentence_dev ), false, true );
		}

		$this->punctuate( $sentences );

		return $this->output( $sentences, $tags, $array );
	}

	public function set_sentence_gauss( $mean = 24.46, $dev = 5.08 ) {
		$this->sentence_mean = floatval( $mean );
		$this->sentence_dev  = floatval( $dev );

		return $this;
	}

	public function set_paragraph_gauss( $mean = 5.8, $dev = 1.93 ) {
		$this->paragraph_mean = floatval( $mean );
		$this->paragraph_dev  = floatval( $dev );

		return $this;
	}

	public function paragraph( $tags = false ) {
		return $this->paragraphs( 1, $tags );
	}

	public function paragraphs( $count = 1, $tags = false, $array = false ) {
		$paragraphs = array();

		for ( $i = 0; $i < $count; $i ++ ) {
			$paragraphs[] = $this->sentences( $this->gauss( $this->paragraph_mean, $this->paragraph_dev ) );
		}

		return $this->output( $paragraphs, $tags, $array, "\n\n" );
	}

	public function html( $paragraphs = 1, $settings = array(), $block_formatted = false, $array = false ) {
		$items = array();

		for ( $i = 0; $i < $paragraphs; $i ++ ) {
			$p = $this->paragraph();

			if ( in_array( 'decorate', $settings ) ) {
				$p = $this->random_tagify( $p );
				$p = $this->random_tagify( $p, 'i' );
			}

			if ( in_array( 'link', $settings ) ) {
				$p = $this->random_tagify( $p, 'a', .05 );
			}

			if ( $block_formatted ) {
				$items[] = '<!-- wp:paragraph -->' . PHP_EOL . '<p>' . $p . '</p>' . PHP_EOL . '<!-- /wp:paragraph -->' . PHP_EOL;
			} else {
				$items[] = '<p>' . $p . '</p>';
			}
		}

		if ( in_array( 'bq', $settings ) ) {
			$max = mt_rand( 1, $paragraphs );

			for ( $i = 0; $i < $max; $i ++ ) {
				$item = $this->sentence( array( 'p' ) );

				if ( $block_formatted ) {
					$items[] = '<!-- wp:quote -->' . PHP_EOL . '<blockquote class="wp-block-quote">' . $item . '</blockquote>' . PHP_EOL . '<!-- /wp:quote -->' . PHP_EOL;
				} else {
					$items[] = $item;
				}
			}
		}

		if ( in_array( 'code', $settings ) ) {
			$max = mt_rand( 1, $paragraphs );

			for ( $i = 0; $i < $max; $i ++ ) {
				$item = $this->sentence( array( 'code' ) );

				if ( $block_formatted ) {
					$items[] = '<!-- wp:code -->' . PHP_EOL . '<pre class="wp-block-code">' . $item . '</pre>' . PHP_EOL . '<!-- /wp:code -->' . PHP_EOL;
				} else {
					$items[] = $item;
				}
			}
		}

		if ( in_array( 'dl', $settings ) && ! $block_formatted ) {
			$max = mt_rand( 1, $paragraphs ) * 3;

			$list = array();

			$list[] = '<dl>';
			for ( $i = 0; $i < $max; $i ++ ) {
				$list[] = '<dt>' . ucfirst( $this->words( 2 ) ) . '</dt>';
				$list[] = $this->sentences( 1, array( 'dd' ) );
			}
			$list[] = '</dl>';

			$items[] = join( '', $list );
		}

		if ( in_array( 'ul', $settings ) ) {
			$max = mt_rand( 1, $paragraphs ) * 3;

			$list = array();

			$list[] = '<ul>';
			for ( $i = 0; $i < $max; $i ++ ) {
				$list[] = $this->sentences( 1, array( 'li' ) );
			}
			$list[] = '</ul>';

			if ( $block_formatted ) {
				$items[] = '<!-- wp:list -->' . PHP_EOL . join( '', $list ) . PHP_EOL . '<!-- /wp:list -->' . PHP_EOL;
			} else {
				$items[] = join( '', $list );
			}
		}

		if ( in_array( 'ol', $settings ) ) {
			$max = mt_rand( 1, $paragraphs ) * 3;

			$list = array();

			$list[] = '<ol>';
			for ( $i = 0; $i < $max; $i ++ ) {
				$list[] = $this->sentences( 1, array( 'li' ) );
			}
			$list[] = '</ol>';

			if ( $block_formatted ) {
				$items[] = '<!-- wp:list {"ordered":true} -->' . PHP_EOL . join( '', $list ) . PHP_EOL . '<!-- /wp:list -->' . PHP_EOL;
			} else {
				$items[] = join( '', $list );
			}
		}

		if ( in_array( 'headers', $settings ) ) {
			$this->set_sentence_gauss( 5, 1 );
			$max  = mt_rand( 1, $paragraphs );
			$head = mt_rand( 2, 6 );

			for ( $i = 0; $i < $max; $i ++ ) {
				$item = $this->sentence( array( 'h' . $head ) );

				if ( $block_formatted ) {
					$items[] = '<!-- wp:heading {"level":' . $head . '} -->' . PHP_EOL . $item . PHP_EOL . '<!-- /wp:heading -->' . PHP_EOL;
				} else {
					$items[] = $item;
				}
			}
		}

		$this->set_paragraph_gauss();

		shuffle( $items );

		if ( ! $array ) {
			$items = join( '', $items );
		}

		return $items;
	}

	public function change_sentence_gauss( $method = 'medium' ) {
		switch ( $method ) {
			case 'short':
				$this->set_sentence_gauss( 5.21, 1.28 );
				break;
			case 'medium':
				$this->set_sentence_gauss( 14.27, 2.92 );
				break;
			case 'long':
				$this->set_sentence_gauss();
				break;
		}

		return $this;
	}

	public function change_paragraph_gauss( $method = 'medium' ) {
		switch ( $method ) {
			case 'short':
				$this->set_paragraph_gauss( 2.1, 1.1 );
				break;
			case 'medium':
				$this->set_paragraph_gauss( 3.8, 1.4 );
				break;
			case 'long':
				$this->set_paragraph_gauss();
				break;
		}

		return $this;
	}

	protected function gauss( $mean, $std_dev ) {
		$x = mt_rand() / mt_getrandmax();
		$y = mt_rand() / mt_getrandmax();

		$z = sqrt( - 2 * log( $x ) ) * cos( 2 * pi() * $y );

		$value = $z * $std_dev + $mean;

		return max( $value, 1 );
	}

	protected function punctuate( &$sentences ) {
		foreach ( $sentences as $key => $sentence ) {
			$words = count( $sentence );

			if ( $words > 4 ) {
				$mean    = log( $words, 6 );
				$std_dev = $mean / 6;
				$commas  = round( $this->gauss( $mean, $std_dev ) );

				for ( $i = 1; $i <= $commas; $i ++ ) {
					$word = round( $i * $words / ( $commas + 1 ) );

					if ( $word < ( $words - 1 ) && $word > 0 ) {
						$sentence[ $word ] .= ',';
					}
				}
			}

			$sentences[ $key ] = ucfirst( implode( ' ', $sentence ) . '.' );
		}
	}

	protected function output( $strings, $tags = false, $array = false, $delimiter = ' ' ) {
		if ( $tags ) {
			if ( ! is_array( $tags ) ) {
				$tags = array( $tags );
			} else {
				$tags = array_reverse( $tags );
			}
			$delimiter = '';

			foreach ( $strings as $key => $string ) {
				foreach ( $tags as $tag ) {
					if ( $tag[ 0 ] == '<' ) {
						$string = str_replace( '$1', $string, $tag );
					} else {
						$string = sprintf( '<%1$s>%2$s</%1$s>', $tag, $string );
					}

					$strings[ $key ] = $string;
				}
			}
		}

		if ( ! $array ) {
			$strings = implode( $delimiter, $strings );
		}

		return $strings;
	}

	protected function random_tagify( $content, $tag = 'strong', $frequency = .2 ) {
		$result = array();

		$items = explode( ' ', $content );
		$total = count( $items );
		$range = floor( $total * $frequency );
		$range = $range < 1 ? 1 : $range;
		$max   = mt_rand( 1, $range );

		$pick = $max > 0 ? (array) array_rand( $items, $max ) : array();

		foreach ( $items as $id => $word ) {
			if ( in_array( $id, $pick ) ) {
				if ( $tag == 'a' ) {
					$result[] = '<a href="#">' . $word . '</a>';
				} else {
					$result[] = '<' . $tag . '>' . $word . '</' . $tag . '>';
				}
			} else {
				$result[] = $word;
			}
		}

		return join( ' ', $result );
	}

	public abstract function words( $count = 1, $tags = false, $array = false );
}
