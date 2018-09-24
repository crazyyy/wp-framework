<?php
/**
 * Finds the dimensions or filetype of an image given its uri by fetching as little as needed 
 * 
 * Based on the FastImage class (https://github.com/tommoor/fastimage)
 * 
 * @version 0.1
 */
class Responsive_Lightbox_Fast_Image {

	private $strpos = 0;
	private $str;
	private $type;
	private $handle;

	public function __construct( $uri = null ) {
		if ( $uri )
			$this->load( $uri );
	}

	public function load( $uri ) {
		if ( $this->handle )
			$this->close();

		$this->handle = fopen( $uri, 'r' );
	}

	public function close() {
		if ( $this->handle ) {
			fclose( $this->handle );

			$this->handle = null;
			$this->type = null;
			$this->str = null;
		}
	}

	public function get_size() {
		$this->strpos = 0;

		if ( $this->get_type() )
			return array_values( $this->parse_size() );

		return false;
	}

	public function get_type() {
		$this->strpos = 0;

		if ( ! $this->type ) {
			switch ( $this->get_chars( 2 ) ) {
				case "BM":
					return $this->type = 'bmp';

				case "GI":
					return $this->type = 'gif';

				case chr( 0xFF ) . chr( 0xd8 ):
					return $this->type = 'jpeg';

				case chr( 0x89 ) . 'P':
					return $this->type = 'png';

				default:
					return false;
			}
		}

		return $this->type;
	}

	private function parse_size() {
		$this->strpos = 0;

		switch ( $this->type ) {
			case 'png':
				return $this->parse_size_png();

			case 'gif':
				return $this->parse_size_gif();

			case 'bmp':
				return $this->parse_size_bmp();

			case 'jpeg':
				return $this->parse_size_jpeg();
		}

		return null;
	}

	private function parse_size_png() {
		$chars = $this->get_chars( 25 );

		return unpack( "N*", substr( $chars, 16, 8 ) );
	}

	private function parse_size_gif() {
		$chars = $this->get_chars( 11 );

		return unpack( "S*", substr( $chars, 6, 4 ) );
	}

	private function parse_size_bmp() {
		$chars = $this->get_chars( 29 );
		$chars = substr( $chars, 14, 14 );
		$type = unpack( 'C', $chars );

		return ( reset( $type ) == 40 ) ? unpack( 'L*', substr( $chars, 4 ) ) : unpack( 'L*', substr( $chars, 4, 8 ) );
	}

	private function parse_size_jpeg() {
		$state = null;
		$i = 0;

		while ( true ) {
			switch ( $state ) {
				default:
					$this->get_chars( 2 );
					$state = 'started';
					break;

				case 'started':
					$b = $this->get_byte();
					if ( $b === false )
						return false;

					$state = $b == 0xFF ? 'sof' : 'started';
					break;

				case 'sof':
					$b = $this->get_byte();
					if ( in_array( $b, range( 0xe0, 0xef ) ) )
						$state = 'skipframe';
					elseif ( in_array( $b, array_merge( range( 0xC0, 0xC3 ), range( 0xC5, 0xC7 ), range( 0xC9, 0xCB ), range( 0xCD, 0xCF ) ) ) )
						$state = 'readsize';
					elseif ( $b == 0xFF )
						$state = 'sof';
					else
						$state = 'skipframe';
					break;

				case 'skipframe':
					$skip = $this->read_int( $this->get_chars( 2 ) ) - 2;
					$state = 'doskip';
					break;

				case 'doskip':
					$this->get_chars( $skip );
					$state = 'started';
					break;

				case 'readsize':
					$c = $this->get_chars( 7 );

					return array( $this->read_int( substr( $c, 5, 2 ) ), $this->read_int( substr( $c, 3, 2 ) ) );
			}
		}
	}

	private function get_chars( $n ) {
		$response = null;

		// do we need more data?		
		if ( $this->strpos + $n - 1 >= strlen( $this->str ) ) {
			$end = ( $this->strpos + $n );

			while ( strlen( $this->str ) < $end && $response !== false ) {
				// read more from the file handle
				$need = $end - ftell( $this->handle );

				if ( $response = fread( $this->handle, $need ) )
					$this->str .= $response;
				else
					return false;
			}
		}

		$result = substr( $this->str, $this->strpos, $n );
		$this->strpos += $n;

		return $result;
	}

	private function get_byte() {
		$c = $this->get_chars( 1 );
		$b = unpack( "C", $c );

		return reset( $b );
	}

	private function read_int( $str ) {
		$size = unpack( "C*", $str );

		return ( $size[1] << 8 ) + $size[2];
	}

	public function __destruct() {
		$this->close();
	}
}