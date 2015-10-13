<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

new Responsive_Lightbox_Frontend();

/**
 * Responsive Lightbox frontend class.
 *
 * @class Responsive_Lightbox_Frontend
 */
class Responsive_Lightbox_Frontend {

	public $gallery_no = 0;

	public function __construct() {
		// set instance
		Responsive_Lightbox()->frontend = $this;

		// filters
		add_filter( 'post_gallery', array( $this, 'gallery_attributes' ), 1000, 10, 2 );
		add_filter( 'post_gallery', array( $this, 'add_custom_gallery_lightbox_selector' ), 2000, 10, 2 );
		add_filter( 'wp_get_attachment_link', array( $this, 'add_gallery_lightbox_selector' ), 1000, 6 );
		add_filter( 'the_content', array( $this, 'add_videos_lightbox_selector' ) );
		add_filter( 'the_content', array( $this, 'add_links_lightbox_selector' ) );
	}

	/**
	 * Add lightbox to videos
	 * 
	 * @param mixed $content
	 * @return mixed
	 */
	public function add_videos_lightbox_selector( $content ) {
		
		if ( Responsive_Lightbox()->options['settings']['videos'] === true ) {

			// search for image-links
			preg_match_all( '/<a(.*?)href=(?:\'|")((?:http|https|)(?::\/\/|)(?:www.|)(?:(?:(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))(?:[\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*)|(?:vimeo\.com\/[0-9]+)))(?:\'|")(.*?)>/i', $content, $links );

			// found?
			if ( ! empty ( $links[0] ) ) {
				foreach ( $links[0] as $id => $link ) {
					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {

						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						// swipebox video fix
						if ( Responsive_Lightbox()->options['settings']['script'] === 'swipebox' && strpos( $links[2][$id], 'vimeo.com') !== false )
							$content = str_replace( $link, str_replace( $links[2][$id], $links[2][$id] . '?width=' . Responsive_Lightbox()->options['configuration']['swipebox']['video_max_width'], $link ), $content );

						// replace data-rel
						$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-video-' . $id . '"', $link ), $content );
					} else {
						// swipebox video fix
						if ( Responsive_Lightbox()->options['settings']['script'] === 'swipebox' && strpos( $links[2][$id], 'vimeo.com') !== false )
							$links[2][$id] = $links[2][$id] . '?width=' . Responsive_Lightbox()->options['configuration']['swipebox']['video_max_width'];

						// replace data-rel
						$content = str_replace( $link, '<a' . $links[1][$id] . 'href="' . $links[2][$id] . '" data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-video-' . $id . '"' . $links[3][$id] . '>', $content );
					}
				}
			}

		}

		return $content;
	}

	/**
	 * Add lightbox to to image links
	 * 
	 * @param mixed $content
	 * @return mixed
	 */
	public function add_links_lightbox_selector( $content ) {
		if ( Responsive_Lightbox()->options['settings']['image_links'] === true || Responsive_Lightbox()->options['settings']['images_as_gallery'] === true ) {

			// search for image-links
			preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png)(?:\'|")(.*?)>/i', $content, $links );

			// found?
			if ( ! empty ( $links[0] ) ) {
				// generate hash for single images gallery
				if ( Responsive_Lightbox()->options['settings']['images_as_gallery'] === true )
					$rel_hash = '-gallery-' . $this->generate_password( 4 );

				foreach ( $links[0] as $id => $link ) {

					// single image title
					$title = '';

					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['image_title'] ) !== 'default' ) {
						$image_id = (int) $this->get_attachment_id_by_url( $links[2][$id] . '.' . $links[3][$id] );

						if ( $image_id )
							$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] ) ) ) );
					}

					// link contains data-rel attribute
					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {

						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						// single images gallery
						if ( Responsive_Lightbox()->options['settings']['images_as_gallery'] === true )
							$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(?:.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . $rel_hash . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . $title . '"', $link ), $content );
						// single image
						else {
							$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(?:.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-' . $id . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . $title . '"', $link ), $content );
						}
					// link without data-rel
					} else {
						$content = str_replace( $link, '<a' . $links[1][$id] . 'href="' . $links[2][$id] . '.' . $links[3][$id] . '"' . $links[4][$id] . ' data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . ( Responsive_Lightbox()->options['settings']['images_as_gallery'] === true ? $rel_hash : '-' . $id ) . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . $title . '">', $content );
					}
				}
			}
		}

		return $content;
	}

	/**
	 * Add lightbox to gallery
	 */
	public function add_gallery_lightbox_selector( $link, $id, $size, $permalink, $icon, $text ) {

		if ( Responsive_Lightbox()->options['settings']['galleries'] === true && wp_attachment_is_image( $id ) ) {
			
			// gallery link target image
			$src = array();

			// gallery image title
			$title = '';
			
			if ( ( $title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'] ) !== 'default' ) {
				$title_arg = apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $link, $id );
				$title = wp_strip_all_tags( trim( $this->get_attachment_title( $id, $title_arg ) ) );
			}

			if ( $title )
				$link = str_replace( '<a href', '<a title="'. $title .'" href', $link );

			$link = ( preg_match( '/<a.*? (?:data-rel)=("|\').*?("|\')>/', $link ) === 1 ? preg_replace( '/(<a.*? data-rel=(?:"|\').*?)((?:"|\').*?>)/', '$1 ' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '$2', $link ) : preg_replace( '/(<a.*?)>/', '$1 data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '">', $link ) );
			
			// gallery image size
			if ( Responsive_Lightbox()->options['settings']['gallery_image_size'] != 'full' ) {
				$src = wp_get_attachment_image_src( $id, Responsive_Lightbox()->options['settings']['gallery_image_size'] );
				
				$link = ( preg_match( '/<a.*? href=("|\').*?("|\')>/', $link ) === 1 ? preg_replace( '/(<a.*? href=(?:"|\')).*?((?:"|\').*?>)/', '$1' . $src[0] . '$2', $link ) : preg_replace( '/(<a.*?)>/', '$1 href="' . $src[0] . '">', $link ) );
			} else {
				$src = wp_get_attachment_image_src( $id, 'full' );
				
				$link = ( preg_match( '/<a.*? href=("|\').*?("|\')>/', $link ) === 1 ? preg_replace( '/(<a.*? href=(?:"|\')).*?((?:"|\').*?>)/', '$1' . $src[0] . '$2', $link ) : preg_replace( '/(<a.*?)>/', '$1 href="' . $src[0] . '">', $link ) );
			}
			
			return apply_filters( 'rl_lightbox_attachment_link', $link, $id, $size, $permalink, $icon, $text, $src );
		
		}

		return $link;
	}

	/**
	 * Add lightbox to Jetpack tiled gallery
	 * 
	 * @param mixed $content
	 * @param array $attr
	 * @return mixed
	 */
	public function add_custom_gallery_lightbox_selector( $content, $attr ) {

		if ( Responsive_Lightbox()->options['settings']['force_custom_gallery'] === true ) {

			preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png)(?:\'|")(.*?)>/i', $content, $links );

			if ( isset( $links[0] ) ) {

				foreach ( $links[0] as $id => $link ) {

					// gallery image title
					$title = '';

					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'] ) !== 'default' ) {

						$image_id = (int) $this->get_attachment_id_by_url( $links[2][$id] . '.' . $links[3][$id] );

						if ( $image_id ) {
							$title_arg = apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] );
							$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, $title_arg ) ) );
						}
					}

					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {
						$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"' . ( ! empty ( $title ) ? ' title="' . $title . '"' : '' ) . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ), $link ), $content );
					} else {
						$content = str_replace( $link, '<a' . $links[1][$id] . 'href="' . $links[2][$id] . '.' . $links[3][$id] . '"' . $links[4][$id] . ' data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ( ! empty ( $title ) ? ' title="' . $title . '"' : '' ) . '>', $content );
					}
				}
			}

		}

		return $content;
	}

	/**
	 * Get attachment title function
	 * 
	 * @param int $id
	 * @param string $title_arg
	 * @return string
	 */
	public function get_attachment_title( $id, $title_arg ) {
		
		if ( empty( $title_arg ) || empty( $id ) ) {
			return false;
		}
		
		switch( $title_arg ) {
			case 'title':
				$title = get_the_title( $id );
				break;
			case 'caption':
				$title = get_post_field( 'post_excerpt', $id ) ;
				break;
			case 'alt':
				$title = get_post_meta( $id, '_wp_attachment_image_alt', true );
				break;
			case 'description':
				$title = get_post_field( 'post_content', $id ) ;
				break;
			default:
				$title = '';
				break;
		}
		
		return apply_filters( 'rl_get_attachment_title', $title, $id, $title_arg );
		
	}
	
	/**
	 * Get attachment id by url function, adjusted to work cropped images
	 * 
	 * @param string $url
	 * @return int
	 */
	public function get_attachment_id_by_url( $url ) {
		$post_id = attachment_url_to_postid( $url );

	    if ( ! $post_id ) {
	        $dir = wp_upload_dir();
	        $path = $url;
			
	        if ( 0 === strpos( $path, $dir['baseurl'] . '/' ) ) {
	            $path = substr( $path, strlen( $dir['baseurl'] . '/' ) );
	        }
	
	        if ( preg_match( '/^(.*)(\-\d*x\d*)(\.\w{1,})/i', $path, $matches ) ){
	            $url = $dir['baseurl'] . '/' . $matches[1] . $matches[3];
	            $post_id = attachment_url_to_postid( $url );
	        }
	    }
	
	    return (int) $post_id;
	}
	
	/**
	 * Helper: generate password without wp_rand() and DB call it uses
	 * 
	 * @param int $length
	 * @return string
	*/
	private function generate_password( $length = 64 ) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$password = '';

		for( $i = 0; $i < $length; $i++ ) {
			$password .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
		}

		return $password;
	}
	
	/**
	 * Helper: gallery number function
	 * 
	 * @param mixed $content
	 * @param array $attr
	 * @return mixed
	 */
	public function gallery_attributes( $content, $attr ) {

		++ $this->gallery_no;

		return $content;
	}

}