<?php

/*
Name:    Dev4Press\v42\Core\Helpers\HTAccess
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

namespace Dev4Press\v42\Core\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class HTAccess {
	public $begin = 'BEGIN';
	public $end = 'END';

	public $path = '';

	public function __construct( $path = '' ) {
		$this->path = $path == '' ? ABSPATH . '.htaccess' : $path;
	}

	public function is_writable() : bool {
		return is_writable( $this->path );
	}

	public function file_exists() : bool {
		return file_exists( $this->path );
	}

	public function load() {
		if ( $this->file_exists() ) {
			return explode( "\n", implode( '', file( $this->path ) ) );
		} else {
			return array();
		}
	}

	public function remove( $marker ) : bool {
		return $this->insert( $marker );
	}

	public function insert( $marker, $insertion = array(), $location = 'end', $cleanup = false ) : bool {
		if ( ! $this->file_exists() || $this->is_writable() ) {
			if ( ! $this->file_exists() ) {
				$markerdata = '';
			} else {
				$markerdata = $this->load();
			}

			if ( ! $f = @fopen( $this->path, 'w' ) ) {
				return false;
			}

			if ( $location == 'start' ) {
				$this->write( $f, $marker, $insertion );

				$insertion = array();
			}

			if ( $markerdata ) {
				$state = true;
				foreach ( $markerdata as $markerline ) {
					if ( strpos( $markerline, '# ' . $this->begin . ' ' . $marker ) !== false ) {
						$state = false;
					}

					if ( $state ) {
						fwrite( $f, "{$markerline}\n" );
					}

					if ( strpos( $markerline, '# ' . $this->end . ' ' . $marker ) !== false ) {
						$state = true;
					}
				}
			}

			if ( $location == 'end' ) {
				$this->write( $f, $marker, $insertion );
			}

			fclose( $f );

			if ( $cleanup ) {
				$this->cleanup();
			}

			return true;
		} else {
			return false;
		}
	}

	public function write( $f, $marker, $insertion = array() ) {
		if ( is_array( $insertion ) && ! empty( $insertion ) ) {
			fwrite( $f, "\n# BEGIN {$marker}\n" );

			foreach ( $insertion as $insertline ) {
				fwrite( $f, "{$insertline}\n" );
			}

			fwrite( $f, "# END {$marker}\n" );
		}
	}

	public function cleanup() {
		if ( $this->file_exists() && $this->is_writable() ) {
			$markerdata = $this->load();

			if ( ! $f = @fopen( $this->path, 'w' ) ) {
				return false;
			}

			$moddeddata = array();

			$line_start = 0;
			$line_end   = 0;

			for ( $i = 0; $i < count( $markerdata ); $i ++ ) {
				if ( ! empty( $markerdata[ $i ] ) ) {
					$line_start = $i;
					break;
				}
			}

			for ( $i = count( $markerdata ) - 1; $i > 0; $i -- ) {
				if ( ! empty( $markerdata[ $i ] ) ) {
					$line_end = $i;
					break;
				}
			}

			$blocked = false;
			for ( $i = $line_start; $i < $line_end + 1; $i ++ ) {
				$addline = true;
				$endline = false;

				$markerline = $markerdata[ $i ];

				if ( $blocked ) {
					if ( ! empty( $markerline ) ) {
						$blocked = false;
					} else {
						$addline = false;
					}
				}

				if ( substr( $markerline, 0, 5 ) == '# END' ) {
					$endline = true;
					$blocked = true;
				}

				if ( $addline ) {
					$moddeddata[] = $markerline;

					if ( $endline ) {
						$moddeddata[] = '';
					}
				}
			}

			foreach ( $moddeddata as $markerline ) {
				fwrite( $f, "{$markerline}\n" );
			}

			fclose( $f );

			return true;
		}

		return false;
	}
}
