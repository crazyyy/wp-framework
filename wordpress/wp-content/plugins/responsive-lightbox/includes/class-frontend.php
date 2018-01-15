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
		add_filter( 'post_gallery', array( $this, 'gallery_attributes' ), 1000 );
		add_filter( 'the_content', array( $this, 'add_links_lightbox_selector' ) );
		add_filter( 'the_content', array( $this, 'add_videos_lightbox_selector' ) );
		add_filter( 'the_content', array( $this, 'add_custom_gallery_lightbox_selector' ), 2000 );
		add_filter( 'post_gallery', array( $this, 'add_custom_gallery_lightbox_selector' ), 2000 );
		add_filter( 'wp_get_attachment_link', array( $this, 'add_gallery_lightbox_selector' ), 1000, 6 );
		add_filter( 'woocommerce_single_product_image_html', array( $this, 'woocommerce_single_product_image_html' ), 100 );
		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'woocommerce_single_product_image_thumbnail_html' ), 100 );
		add_filter( 'get_comment_text', array( $this, 'get_comment_text' ) );
		add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_sidebar_params' ) );
		add_filter( 'rl_widget_output', array( $this, 'widget_output' ), 10, 3 );
		
		// actions
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 100 );
	}

	/**
	 * Add lightbox to to image links
	 * 
	 * @param mixed $content
	 * @return mixed
	 */
	public function add_links_lightbox_selector( $content ) {
		if ( Responsive_Lightbox()->options['settings']['image_links'] || Responsive_Lightbox()->options['settings']['images_as_gallery'] ) {

			// search for image-links
			preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png)(?:\'|")(.*?)>/is', $content, $links );

			// found?
			if ( ! empty ( $links[0] ) ) {
				// generate hash for single images gallery
				if ( Responsive_Lightbox()->options['settings']['images_as_gallery'] )
					$rel_hash = '-gallery-' . $this->generate_password( 4 );

				foreach ( $links[0] as $id => $link ) {
					// single image title
					$title = '';

					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['image_title'] ) !== 'default' ) {
						// get attachment id
						$image_id = (int) $this->get_attachment_id_by_url( $links[2][$id] . '.' . $links[3][$id] );

						if ( $image_id )
							$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] ) ) ) );
					}

					// update title if needed
					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['image_title'] ) !== 'default' && $image_id )
						$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] ) ) ) );

					// link contains data-rel attribute
					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/s', $link, $result ) === 1 ) {

						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						// single images gallery
						if ( Responsive_Lightbox()->options['settings']['images_as_gallery'] )
							$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(?:.*?)(?:\'|")/s', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $result[1] ) . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . esc_attr( $title ) . '"', $link ), $content );
						// single image
						else {
							$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(?:.*?)(?:\'|")/s', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-' . base64_encode( $result[1] ) . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . esc_attr( $title ) . '"', $link ), $content );
						}
					// link without data-rel
					} else {
						$content = str_replace( $link, '<a' . $links[1][$id] . 'href="' . $links[2][$id] . '.' . $links[3][$id] . '"' . $links[4][$id] . ' data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . ( Responsive_Lightbox()->options['settings']['images_as_gallery'] ? $rel_hash : '-' . $id ) . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . ' title="' . esc_attr( $title ) . '">', $content );
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

		if ( Responsive_Lightbox()->options['settings']['galleries'] && wp_attachment_is_image( $id ) ) {
			// gallery link target image
			$src = array();

			// gallery image title
			$title = '';

			if ( ( $title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'] ) !== 'default' ) {
				$title_arg = apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $link, $id );
				$title = wp_strip_all_tags( trim( $this->get_attachment_title( $id, $title_arg ) ) );
			}

			if ( $title )
				$link = str_replace( '<a href', '<a title="'. esc_attr( $title ) .'" href', $link );

			$link = ( preg_match( '/<a.*? (?:data-rel)=("|\').*?("|\')>/s', $link ) === 1 ? preg_replace( '/(<a.*? data-rel=(?:"|\').*?)((?:"|\').*?>)/s', '$1 ' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '$2', $link ) : preg_replace( '/(<a.*?)>/s', '$1 data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '">', $link ) );

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
	public function add_custom_gallery_lightbox_selector( $content ) {
		if ( Responsive_Lightbox()->options['settings']['force_custom_gallery'] ) {
			preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?).(bmp|gif|jpeg|jpg|png)(?:\'|")(.*?)>/i', $content, $links );

			if ( isset( $links[0] ) ) {
				foreach ( $links[0] as $id => $link ) {
					// gallery image title
					$title = '';

					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'] ) !== 'default' ) {
						// get attachment id
						$image_id = (int) $this->get_attachment_id_by_url( $links[2][$id] . '.' . $links[3][$id] );

						if ( $image_id ) {
							$title_arg = apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] );
							$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, $title_arg ) ) );
						}
					}

					// get attachment id
					$image_id = (int) $this->get_attachment_id_by_url( $links[2][$id] . '.' . $links[3][$id] );

					if ( ( $title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'] ) !== 'default' && $image_id ) {
						$title_arg = apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$id] . '.' . $links[3][$id] );
						$title = wp_strip_all_tags( trim( $this->get_attachment_title( $image_id, $title_arg ) ) );
					}

					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {
						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						$content = str_replace( $link, preg_replace( '/(?:data-rel)=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $result[1] ) . '"' . ( ! empty ( $title ) ? ' title="' . esc_attr( $title ) . '"' : '' ) . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ), $link ), $content );
					} elseif ( preg_match( '/<a.*?(?:rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {
						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						$content = str_replace( $link, preg_replace( '/(?:rel)=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $result[1] ) . '"' . ( ! empty ( $title ) ? ' title="' . esc_attr( $title ) . '"' : '' ) . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ), $link ), $content );
					} else {
						$content = str_replace( $link, '<a' . $links[1][$id] . ' href="' . $links[2][$id] . '.' . $links[3][$id] . '" data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $this->gallery_no ) . '"' . ( ! empty ( $title ) ? ' title="' . esc_attr( $title ) . '"' : '' ) . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $id . '"' : '' ) . $links[4][$id] . '>', $content );
					}
				}
			}

		}

		return $content;
	}
	
	/**
	 * Add lightbox to videos
	 * 
	 * @param mixed $content
	 * @return mixed
	 */
	public function add_videos_lightbox_selector( $content ) {
		if ( Responsive_Lightbox()->options['settings']['videos'] ) {
			// search for video-links
			preg_match_all('/<a(.*?)href=(?:\'|")((?:http|https)(?::\/\/|)(?:www\.)?(?:(?:(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=))(?:[\w\-]{11})[a-z0-9;:@#?&%=+\/\$_.-]*)|(?:vimeo\.com\/[0-9]+[a-z0-9;:@#?&%=+\/\$_.-]*)))(?:\'|")(.*?)>/i', $content, $links );

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

// zaktualizuj photo swipe

	/**
	 * Remove WooCommerce prettyPhoto lightbox styles and scripts.
	 */
	public function wp_enqueue_scripts() {
		if ( class_exists( 'WooCommerce' ) ) {
			global $woocommerce;

			// specific WooCommerce gallery?
			if ( ! empty( Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] ) && Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] !== 'default' ) {
				// replace default WooCommerce lightbox?
				if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
					if ( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
						// dequeue scripts
						wp_dequeue_script( 'flexslider' );
						wp_dequeue_script( 'photoswipe' );
						wp_dequeue_script( 'photoswipe-ui-default' );

						// dequeue styles
						wp_dequeue_style( 'photoswipe' );
						wp_dequeue_style( 'photoswipe-default-skin' );

						// remove theme supports
						remove_theme_support( 'wc-product-gallery-lightbox' );
						// remove_theme_support( 'wc-product-gallery-zoom' );
						remove_theme_support( 'wc-product-gallery-slider' );
					} else {
						// remove styles
						wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

						// remove scripts
						wp_dequeue_script( 'prettyPhoto' );
						wp_dequeue_script( 'prettyPhoto-init' );
						wp_dequeue_script( 'fancybox' );
						wp_dequeue_script( 'enable-lightbox' );
					}
				} else {
					if ( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
						// dequeue scripts
						wp_dequeue_script( 'flexslider' );
					}
				}
			// default gallery?
			} else {
				// replace default WooCommerce lightbox?
				if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
					if ( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
						// dequeue scripts
						wp_dequeue_script( 'photoswipe' );
						wp_dequeue_script( 'photoswipe-ui-default' );

						// dequeue styles
						wp_dequeue_style( 'photoswipe' );
						wp_dequeue_style( 'photoswipe-default-skin' );

						// remove theme supports
						remove_theme_support( 'wc-product-gallery-lightbox' );
					} else {
						// remove styles
						wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

						// remove scripts
						wp_dequeue_script( 'prettyPhoto' );
						wp_dequeue_script( 'prettyPhoto-init' );
						wp_dequeue_script( 'fancybox' );
						wp_dequeue_script( 'enable-lightbox' );
					}
				}
			}
		}

		// Visual Composer lightbox
		if ( class_exists( 'Vc_Manager' ) ) {
			wp_dequeue_script( 'prettyphoto' );
			wp_deregister_script( 'prettyphoto' );
			wp_dequeue_style( 'prettyphoto' );
			wp_deregister_style( 'prettyphoto' );
		}
	}
	
	/**
	 * Apply lightbox to WooCommerce product image.
	 * 
	 * @param mixed $html
	 * @return mixed
	 */
	public function woocommerce_single_product_image_html( $html ) {
		if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
			$html = preg_replace( '/data-rel=\"(.*?)\"/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"', $html );
		}

		return $html;
	}
	
	/**
	 * Apply lightbox to WooCommerce product gallery.
	 * 
	 * @param mixed $html
	 * @return mixed
	 */
	public function woocommerce_single_product_image_thumbnail_html( $html ) {
		if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] === true ) {
			$html = preg_replace( '/data-rel=\"(.*?)\"/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"', $html );

			preg_match( '/<a(.*?)((?:data-rel)=(?:\'|").*?(?:\'|"))(.*?)>/', $html, $result );

			// no data-rel?
			if ( empty( $result ) ) {
				preg_match( '/^(.*?)<a(.*?)((?:href)=(?:\'|").*?(?:\'|"))(.*?)>(.*?)$/', $html, $result );

				// found valid link?
				if ( ! empty( $result ) )
					$html = $result[1] . '<a' . $result[2] . ' data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '" ' . $result[3] . $result[4] . '>' . $result[5];
			}
		}

		return $html;
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
	 * Get attachment id by url function, adjusted to work for cropped images
	 * 
	 * @param string $url
	 * @return int
	 */
	public function get_attachment_id_by_url( $url ) {
		$url = ! empty( $url ) ? esc_url( $url ) : '';
		
		// get cached data
		// $post_id = wp_cache_get( md5( $url ), 'rl-attachment_id_by_url' );
		$post_ids = get_transient( 'rl-attachment_ids' );
		$post_id = 0;
		
		// cached url not found?
		if ( $post_ids === false || ! in_array( $url, array_keys( $post_ids ) ) ) {
			$post_id = attachment_url_to_postid( $url );

			if ( ! $post_id ) {
				$dir = wp_upload_dir();
				$path = $url;

				if ( strpos( $path, $dir['baseurl'] . '/' ) === 0 )
					$path = substr( $path, strlen( $dir['baseurl'] . '/' ) );

				if ( preg_match( '/^(.*)(\-\d*x\d*)(\.\w{1,})/i', $path, $matches ) )
					$post_id = attachment_url_to_postid( $dir['baseurl'] . '/' . $matches[1] . $matches[3] );
			}
			
			// set the cache expiration, 24 hours by default
			$expire = absint( apply_filters( 'rl_object_cache_expire', DAY_IN_SECONDS ) );

			// wp_cache_add( md5( $url ), $post_id, 'rl-attachment_id_by_url', $expire );
			
			$post_ids[$url] = $post_id;
			
			set_transient( 'rl-attachment_ids', $post_ids, $expire );
		// cached url found
		} elseif ( ! empty( $post_ids[$url] ) ) {
			$post_id = absint( $post_ids[$url] );
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
	 * @return mixed
	 */
	public function gallery_attributes( $content ) {
		++$this->gallery_no;

		return $content;
	}
	
	/**
	 * Replace widget callback function.
	 * 
	 * @global array $wp_registered_widgets
	 * @param array $sidebar_params
	 * @return type
	 */
	public function dynamic_sidebar_params( $sidebar_params ) {
		if ( ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) || Responsive_Lightbox()->options['settings']['widgets'] != true ) {
			return $sidebar_params;
		}

		global $wp_registered_widgets;
		
		$widget_id = $sidebar_params[0]['widget_id'];

		$wp_registered_widgets[ $widget_id ]['original_callback'] = $wp_registered_widgets[ $widget_id ]['callback'];
		$wp_registered_widgets[ $widget_id ]['callback'] = array( $this, 'widget_callback_function' );

		return $sidebar_params;
	}
	
	/**
	 * Widget callback function.
	 * 
	 * @global array $wp_registered_widgets
	 */
	public function widget_callback_function() {
 
		global $wp_registered_widgets;
		$original_callback_params = func_get_args();
		$widget_id = $original_callback_params[0]['widget_id'];

		$original_callback = $wp_registered_widgets[ $widget_id ]['original_callback'];
		$wp_registered_widgets[ $widget_id ]['callback'] = $original_callback;

		$widget_id_base = $wp_registered_widgets[ $widget_id ]['callback'][0]->id_base;

		if ( is_callable( $original_callback ) ) {

			ob_start();
			call_user_func_array( $original_callback, $original_callback_params );
			$widget_output = ob_get_clean();

			echo apply_filters( 'rl_widget_output', $widget_output, $widget_id_base, $widget_id );

		}

	}
	
	/**
	 * Filter widget output.
	 * 
	 * @param mixed $widget_output
	 * @param string $widget_id_base
	 * @param id $widget_id
	 * @return mixed
	 */
	public function widget_output( $widget_output, $widget_id_base, $widget_id ) {
		// filter galleries
		$widget_output = $this->add_custom_gallery_lightbox_selector( $widget_output );
		// filter image links
		$widget_output = $this->add_links_lightbox_selector( $widget_output );
		// filter videos
		$widget_output = $this->add_videos_lightbox_selector( $widget_output );
		
		return $widget_output;
	}
	
	/**
	 * Filter comment content.
	 * 
	 * @param mixed $comment_content
	 * @return mixed
	 */
	public function get_comment_text( $comment_content ) {
		if ( ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) || Responsive_Lightbox()->options['settings']['comments'] != true ) {
			return $comment_content;
		}
		
		// filter galleries
		$comment_content = $this->add_custom_gallery_lightbox_selector( $comment_content );
		// filter image links
		$comment_content = $this->add_links_lightbox_selector( $comment_content );
		// filter videos
		$comment_content = $this->add_videos_lightbox_selector( $comment_content );
		
		return $comment_content;
	}

}