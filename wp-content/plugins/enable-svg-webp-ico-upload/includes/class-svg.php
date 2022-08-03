<?php
class ITC_SVG_Upload_Svg{
    function __construct(){
		
	}

	function fl_module_upload_regex( $regex, $type, $ext, $file ){
		if( $ext == "svg" || $ext == "svgz" ){
			$regex['photo'] = str_replace( '|png|', '|png|svgz?|', $regex['photo'] );
		}
		return $regex;
	}

	function fix_svg_thumbnail_size(){
		echo '<style>.attachment-info .thumbnail img[src$=".svg"],#postimagediv .inside img[src$=".svg"]{width:100%}</style>';
	}

	function wp_generate_attachment_metadata( $metadata, $attachment_id ){
		if( get_post_mime_type( $attachment_id ) == 'image/svg+xml' ){
			$svg_path = get_attached_file( $attachment_id );
			$dimensions = $this->svg_dimensions( $svg_path );
			$metadata['width'] = $dimensions->width;
			$metadata['height'] = $dimensions->height;
		}
		return $metadata;
	}

	function wp_check_filetype_and_ext( $filetype_ext_data, $file, $filename, $mimes ){
		if( substr( $filename, -4 ) == '.svg' ){
			$filetype_ext_data['ext'] = 'svg';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}
		if( substr( $filename, -5 ) == '.svgz' ){
			$filetype_ext_data['ext'] = 'svgz';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}
		return $filetype_ext_data;
	}

	public function add_svg_support(){

		function svg_thumbs( $content ){
			return apply_filters( 'final_output', $content );
		}

		ob_start( 'svg_thumbs' );

		add_filter( 'final_output', array( $this, 'final_output' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'wp_prepare_attachment_for_js' ), 10, 3 );
	}

	function final_output( $content ){
		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<img class="details-image" src="{{ data.url }}" draggable="false" />
			<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			$content
		);

		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<div class="centered">
					<img src="{{ data.url }}" class="thumbnail" draggable="false" />
				</div>
			<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			$content
		);

		return $content;
	}

	public function add_svg_mime( $mimes = array() ){
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		return $mimes;
	}

	function wp_prepare_attachment_for_js( $response, $attachment, $meta ){
		if( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ){
			$svg_path = get_attached_file( $attachment->ID );
			if( ! file_exists( $svg_path ) ){
				$svg_path = $response['url'];
			}
			$dimensions = $this->svg_dimensions( $svg_path );
			$response['sizes'] = array(
				'full' => array(
					'url' => $response['url'],
					'width' => $dimensions->width,
					'height' => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
				)
			);
		}
		return $response;
	}

	function svg_dimensions( $svg ){
		$svg = simplexml_load_file( $svg );
		$width = 0;
		$height = 0;
		if( $svg ){
			$attributes = $svg->attributes();
			if( isset( $attributes->width, $attributes->height ) ){
				$width = floatval( $attributes->width );
				$height = floatval( $attributes->height );
			}elseif( isset( $attributes->viewBox ) ){
				$sizes = explode( " ", $attributes->viewBox );
				if( isset( $sizes[2], $sizes[3] ) ){
					$width = floatval( $sizes[2] );
					$height = floatval( $sizes[3] );
				}
			}
		}
		return (object)array( 'width' => $width, 'height' => $height );
	}
}