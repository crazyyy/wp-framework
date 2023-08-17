<?php

namespace Dev4Press\v42\Generator\Text;

class Randomizer extends Generator {
	protected $word_mean = 6.16;
	protected $word_dev = 3.32;

	private $vowels = array(
		'a',
		'e',
		'i',
		'o',
		'u'
	);

	private $consonants = array(
		'b',
		'c',
		'd',
		'f',
		'g',
		'h',
		'j',
		'k',
		'l',
		'm',
		'n',
		'p',
		'r',
		's',
		't',
		'v',
		'w',
		'x',
		'y',
		'z'
	);

	public function words( $count = 1, $tags = false, $array = false ) {
		$words = array();

		for ( $i = 0; $i < $count; $i ++ ) {
			$words[] = $this->random();
		}

		return $this->output( $words, $tags, $array );
	}

	public function set_word_gauss( $mean = 6.16, $dev = 3.32 ) {
		$this->word_mean = floatval( $mean );
		$this->word_dev  = floatval( $dev );

		return $this;
	}

	public function random( $length = true ) {
		$length = $length === true ? $this->gauss( $this->word_mean, $this->word_dev ) : $length;

		if ( $length < 2 ) {
			$length = 2;
		}

		$max = $length / 2;

		$string = '';

		for ( $i = 1; $i <= $max; $i ++ ) {
			$string .= $this->consonants[ mt_rand( 0, count( $this->consonants ) - 1 ) ];
			$string .= $this->vowels[ mt_rand( 0, count( $this->vowels ) - 1 ) ];
		}

		return $string;
	}
}