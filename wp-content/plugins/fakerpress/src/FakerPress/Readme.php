<?php
namespace FakerPress;

Class Readme {
	public function parse_readme( $file, $version = null ) {
		$file_contents = @implode( '', @file( $file ) );
		return $this->parse_readme_contents( $file_contents, $version );
	}

	public function parse_readme_contents( $file_contents, $version = false ) {
		$file_contents = str_replace( [ "\r\n", "\r" ], "\n", $file_contents );
		$file_contents = trim( $file_contents );
		if ( 0 === strpos( $file_contents, "\xEF\xBB\xBF" ) )
			$file_contents = substr( $file_contents, 3 );

		// Markdown transformations
		$file_contents = preg_replace( "|^###([^#]+)#*?\s*?\n|im", '=$1='."\n",     $file_contents );
		$file_contents = preg_replace( "|^##([^#]+)#*?\s*?\n|im",  '==$1=='."\n",   $file_contents );
		$file_contents = preg_replace( "|^#([^#]+)#*?\s*?\n|im",   '===$1==='."\n", $file_contents );

		// === Plugin Name ===
		// Must be the very first thing.
		if ( ! preg_match_all('/^([=]*) ([^=]*) ([=]*)/im', $file_contents, $search_sections_name ) ) {
			return [];
		}

		$valid_section_indexes = array_keys( array_filter(
			$search_sections_name[1],
			static function ( $value ) {
				return '==' === $value;
			}
		) );

		$content = $file_contents;

		$sections['headers'] = [
			'name' => 'headers',
			'content' => null,
		];

		foreach ( $valid_section_indexes as  $index ) {
			$name = $search_sections_name[2][ $index ];
			$sections[ strtolower( $name ) ] = $section = [
				'name' => $name,
				'content' => '',
			];

			$parts = explode( '== ' . $name . ' ==', $content );

			if ( ! $sections['headers']['content'] ) {
				$sections['headers']['content'] = $parts[0];
			} elseif ( isset( $last_name ) ) {
				$sections[ strtolower( $last_name ) ]['content'] = $parts[0];
			}

			if ( ! empty( $parts[1] )  ) {
				$content = $parts[1];
			}

			$last_name = $name;
		}

		$sections[ strtolower( $last_name ) ]['content'] = $content;

		if ( isset( $sections['changelog'] ) ) {
			$sections['changelog']['versions'] = $this->parse_changelog_section( $sections['changelog']['content'], $version );
		}

		return $sections;
	}

	protected static function str_replace_first( $search, $replace, $subject ) {
		$pos = strpos( $subject, $search );
		if ( false !== $pos ) {
			return substr_replace( $subject, $replace, $pos, strlen( $search ) );
		}

		return $subject;
	}

	public function parse_changelog_section( $content, $only_version = null ) {
		$versions = [];

		if ( ! preg_match_all('/^(?:[=]*) ([^=]*) (?:[=]*)/im', $content, $versions_search ) ) {
			return [];
		}

		$versions_titles = $versions_search[1];
		$count = 0;

		foreach ( $versions_titles as $versions_title ) {
			$separator = false;
			if ( false !== strpos( $versions_title, '&mdash;' ) ) {
				$separator = '&mdash;';
			} elseif ( false !== strpos( $versions_title, '-' ) ) {
				$separator = '-';
			}

			if ( ! $separator ) {
				continue;
			}

			$version_title_parts = explode( $separator, $versions_title );
			$version_number = trim( $version_title_parts[0] );
			$version_content_parts = explode( '= ' . $versions_title . ' =', $content );

			$version = [
				'number' => $version_number,
				'date'    => trim( $version_title_parts[1] ),
				'content' => null,
			];

			if ( isset( $last_version ) ) {
				$versions[ $last_version ]['content'] = trim( $version_content_parts[0] );
			}

			if ( ! empty( $version_content_parts[1] )  ) {
				$content = $version_content_parts[1];
			}

			$last_version = $version['number'];

			$versions[ $version['number'] ] = $version;
			$count++;
		}

		$versions[ $last_version ]['content'] = $content;

		// Dont parse headers.
		Utils\Slimdown::remove_rule( '/(#+)(.*)/' );

		foreach ( $versions as &$version ) {
			if ( ! is_null( $only_version ) && ! in_array( $version['number'], (array) $only_version ) ) {
				continue;
			}

			$contents = explode( "\n", $version['content'] );
			$html = [
				'<ul>',
			];
			foreach ( $contents as $change ) {
				$change = trim( $change );
				if ( empty( $change ) ) {
					continue;
				}
				$piece = '<li>' . Utils\Slimdown::render( static::str_replace_first( '*', '', $change ) ) . '</li>';

				$html[] = $piece;
			}

			$html[] = '</ul>';

			$version['html'] = implode( "\n", $html );
		}

		$versions = array_filter( $versions, static function( $version ) {
			return ! empty( $version['html'] );
		} );

		return $versions;
	}
}
