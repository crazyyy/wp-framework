<?php
// exit if accessed directly
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

		// actions
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 100 );
		add_action( 'rl_before_gallery', array( $this, 'before_gallery' ), 10, 2 );
		add_action( 'rl_after_gallery', array( $this, 'after_gallery' ), 10, 2 );
		add_action( 'after_setup_theme', array( $this, 'woocommerce_gallery_init' ), 1000 );

		// filters
		add_filter( 'rl_gallery_container_class', array( $this, 'gallery_container_class' ), 10, 3 );
		add_filter( 'the_content', array( $this, 'gallery_preview' ) );
		add_filter( 'the_content', array( $this, 'add_lightbox' ) );
		add_filter( 'wp_get_attachment_link', array( $this, 'wp_get_attachment_link' ), 1000, 6 );
		add_filter( 'get_comment_text', array( $this, 'get_comment_text' ) );
		add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_sidebar_params' ) );
		add_filter( 'rl_widget_output', array( $this, 'widget_output' ), 10, 3 );
		add_filter( 'post_gallery', array( $this, 'gallery_attributes' ), 1000, 2 );
		add_filter( 'post_gallery', array( $this, 'basic_grid_gallery_shortcode' ), 1001, 2 );
		add_filter( 'post_gallery', array( $this, 'basic_slider_gallery_shortcode' ), 1001, 2 );
		add_filter( 'post_gallery', array( $this, 'basic_masonry_gallery_shortcode' ), 1001, 2 );
		add_filter( 'post_gallery', array( $this, 'force_custom_gallery_lightbox' ), 2000 );

		// visual composer
		add_filter( 'vc_shortcode_content_filter_after', array( $this, 'vc_shortcode_content_filter_after' ), 10, 2 );

		// woocommerce
		add_filter( 'woocommerce_single_product_image_html', array( $this, 'woocommerce_single_product_image_html' ), 100 );
		add_filter( 'woocommerce_single_product_image_thumbnail_html', array( $this, 'woocommerce_single_product_image_thumbnail_html' ), 100 );
	}

	/**
	 * Add lightbox to images, galleries and videos.
	 *
	 * @param string $content HTML content
	 * @return string Changed HTML content
	 */
	public function add_lightbox( $content ) {
		// get current script
		$script = Responsive_Lightbox()->options['settings']['script'];

		// prepare arguments
		$args = array(
			'selector'	=> Responsive_Lightbox()->options['settings']['selector'],
			'script'	=> $script,
			'settings'	=> array(
				'script'	=> Responsive_Lightbox()->options['configuration'][$script],
				'plugin'	=> Responsive_Lightbox()->options['settings']
			),
			'supports'	=> Responsive_Lightbox()->settings->scripts[$script]['supports']
		);

		// workaround for builder galleries to bypass images_as_gallery option, applied only to rl_gallery posts
		if ( is_singular( 'rl_gallery' ) )
			$args['settings']['plugin']['images_as_gallery'] = true;

		// search for links containing data-rl_content attribute
		preg_match_all( '/<a.*?data-rl_content=(?:\'|")(.*?)(?:\'|").*?>/i', $content, $links );

		// found any links?
		if ( ! empty ( $links[0] ) ) {
			foreach ( $links[0] as $link_number => $link ) {
				// set content type
				$args['content'] = $links[1][$link_number];

				// set link number
				$args['link_number'] = $link_number;

				// update link
				$content = str_replace( $link, $this->lightbox_content_link( $link, $args ), $content );
			}
		}

		// images
		if ( $args['settings']['plugin']['image_links'] || $args['settings']['plugin']['images_as_gallery'] || $args['settings']['plugin']['force_custom_gallery'] ) {
			// search for image links
			preg_match_all( '/<a([^<]*?)href=(?:\'|")([^<]*?)\.(bmp|gif|jpeg|jpg|png|webp)(?:\'|")(.*?)>/is', $content, $links );

			// found any links?
			if ( ! empty ( $links[0] ) ) {
				// generate hash for single images gallery
				if ( $args['settings']['plugin']['images_as_gallery'] )
					$args['rel_hash'] = '-gallery-' . $this->generate_hash();
				else
					$args['rel_hash'] = '';

				foreach ( $links[0] as $link_number => $link ) {
					// get attachment id
					$args['image_id'] = $this->get_attachment_id_by_url( $links[2][$link_number] . '.' . $links[3][$link_number] );

					// set link number
					$args['link_number'] = $link_number;

					// link parts
					$args['link_parts'] = array( $links[1][$link_number], $links[2][$link_number], $links[3][$link_number], $links[4][$link_number] );

					// get title type
					$title_arg = $args['settings']['plugin']['force_custom_gallery'] ? $args['settings']['plugin']['gallery_image_title'] : $args['settings']['plugin']['image_title'];

					// update title if needed
					if ( $title_arg !== 'default' && $args['image_id'] )
						$args['title'] = $this->get_attachment_title( $args['image_id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $args['image_id'], $links[2][$link_number] . '.' . $links[3][$link_number] ) );
					else
						$args['title'] = '';

					// get caption type
					$caption_arg = $args['settings']['plugin']['force_custom_gallery'] ? $args['settings']['plugin']['gallery_image_caption'] : $args['settings']['plugin']['image_caption'];

					// update caption if needed
					if ( $caption_arg !== 'default' && $args['image_id'] )
						$args['caption'] = $this->get_attachment_title( $args['image_id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $caption_arg, $args['image_id'], $links[2][$link_number] . '.' . $links[3][$link_number] ) );
					else
						$args['caption'] = '';

					// update link
					$content = str_replace( $link, $this->lightbox_image_link( $link, $args ), $content );
				}
			}
		}

		// videos
		if ( $args['settings']['plugin']['videos'] ) {
			// search for video links
			preg_match_all('/<a(.*?)href=(?:\'|")((http|https)(?::\/\/|)(?:(?:(?:youtu\.be\/|(?:www\.)?youtube\.com\/)(?:embed\/|v\/|watch\?v=)?([\w-]{11})(?:\?)?([a-z0-9;:@#&%=+\/\$_.-]*))|(?:(?:www\.)?vimeo\.com\/([0-9]+)(?:\?)?([a-z0-9;:@#&%=+\/\$_.-]*))))(?:\'|")(.*?)>/i', $content, $links );

			// set empty video arguments
			$args['video_id'] = $args['video_type'] = $args['video_query'] = $args['video_protocol'] = '';

			// found any links?
			if ( ! empty ( $links[0] ) ) {
				foreach ( $links[0] as $link_number => $link ) {
					// youtube?
					if ( $links[4][$link_number] !== '' ) {
						$args['video_id'] = $links[4][$link_number];
						$args['video_type'] = 'youtube';
						$args['video_query'] = $links[5][$link_number];
					// vimeo?
					} elseif ( $links[6][$link_number] !== '' ) {
						$args['video_id'] = $links[6][$link_number];
						$args['video_type'] = 'vimeo';
						$args['video_query'] = $links[7][$link_number];
					}

					// set video protocol
					$args['video_protocol'] = $links[3][$link_number];

					// set link number
					$args['link_number'] = $link_number;

					// link parts
					$args['link_parts'] = array( $links[1][$link_number], $links[2][$link_number], $links[8][$link_number] );

					// update link
					$content = str_replace( $link, $this->lightbox_video_link( $link, $args ), $content );
				}
			}
		}

		return $content;
	}

	/**
	 * Add lightbox to video links.
	 *
	 * @param string $link Video link
	 * @param array $args Link arguments
	 * @return string Updated video link
	 */
	public function lightbox_video_link( $link, $args ) {
		// link already contains data-rel attribute?
		if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/is', $link, $result ) === 1 ) {
			// allow to modify link?
			if ( $result[1] !== 'norl' ) {
				// swipebox video fix
				if ( $args['script'] === 'swipebox' && $args['video_type'] === 'vimeo' )
					$link = str_replace( $args['link_parts'][1], add_query_arg( 'width', $args['settings']['script']['video_max_width'], $args['link_parts'][1] ), $link );

				// replace data-rel
				$link = preg_replace( '/data-rel=(\'|")(.*?)(\'|")/', 'data-rel="' . $args['selector'] . '-video-' . $args['link_number'] . '"', $link );

				if ( $args['script'] === 'magnific' )
					$link = preg_replace( '/(<a.*?)>/is', '$1 data-magnific_type="video">', $link );
			}
		} else {
			// swipebox video fix
			if ( $args['script'] === 'swipebox' && $args['video_type'] === 'vimeo' )
				$args['link_parts'][1] = add_query_arg( 'width', $args['settings']['script']['video_max_width'], $args['link_parts'][1] );

			// add data-rel
			$link = '<a' . $args['link_parts'][0] . 'href="' . $args['link_parts'][1] . '" data-rel="' . $args['selector'] . '-video-' . $args['link_number'] . '"' . $args['link_parts'][2] . '>';

			if ( $args['script'] === 'magnific' )
				$link = preg_replace( '/(<a.*?)>/is', '$1 data-magnific_type="video">', $link );
		}

		return apply_filters( 'rl_lightbox_video_link', $link, $args );
	}

	/**
	 * Add lightbox to image links.
	 *
	 * @param string $link Image link
	 * @param array $args Link arguments
	 * @return string Updated image link
	 */
	public function lightbox_image_link( $link, $args ) {
		if ( rl_current_lightbox_supports( 'html_caption' ) ) {
			$title = esc_attr( trim ( nl2br( $args['title'] ) ) );
			$caption = esc_attr( trim( nl2br( $args['caption'] ) ) );
		} else {
			$title = esc_attr( wp_strip_all_tags( trim ( nl2br( $args['title'] ) ), true ) );
			$caption = esc_attr( wp_strip_all_tags( trim( nl2br( $args['caption'] ) ), true ) );
		}

		if ( isset( $_GET['rl_gallery_no'], $_GET['rl_page'] ) )
			$this->gallery_no = (int) $_GET['rl_gallery_no'];

		// link already contains data-rel attribute?
		if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/is', $link, $result ) === 1 ) {
			// allow to modify link?
			if ( $result[1] !== 'norl' ) {
				// gallery?
				if ( $args['settings']['plugin']['images_as_gallery'] || $args['settings']['plugin']['force_custom_gallery'] )
					$link = preg_replace( '/data-rel=(\'|")(.*?)(\'|")/s', 'data-rel="' . $args['selector'] . '-gallery-' . $this->gallery_no . '" data-rl_title="__RL_IMAGE_TITLE__" data-rl_caption="__RL_IMAGE_CAPTION__"' . ( $args['script'] === 'magnific' ? ' data-magnific_type="gallery"' : '' ) . ( $args['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $args['link_number'] . '"' : '' ), $link );
				// single image
				else
					$link = preg_replace( '/data-rel=(\'|")(.*?)(\'|")/s', 'data-rel="' . $args['selector'] . '-image-' . base64_encode( $result[1] ) . '"' . ( $args['script'] === 'magnific' ? ' data-magnific_type="image"' : '' ) . ( $args['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $args['link_number'] . '"' : '' ) . ' data-rl_title="__RL_IMAGE_TITLE__" data-rl_caption="__RL_IMAGE_CAPTION__"', $link );
			}
		// link without data-rel
		} else {
			// force images?
			if ( $args['settings']['plugin']['force_custom_gallery'] ) {
				// link already contains rel attribute?
				if ( preg_match( '/<a.*?(?:rel)=(?:\'|")(.*?)(?:\'|").*?>/is', $link, $result ) === 1 ) {
					// allow to modify link?
					if ( $result[1] !== 'norl' )
						$link = preg_replace( '/rel=(\'|")(.*?)(\'|")/', 'data-rel="' . $args['selector'] . '-gallery-' . $this->gallery_no . '" data-rl_title="__RL_IMAGE_TITLE__" data-rl_caption="__RL_IMAGE_CAPTION__"' . ( $args['script'] === 'magnific' ? ' data-magnific_type="gallery"' : '' ) . ( $args['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $args['link_number'] . '"' : '' ), $link );
				} else
					$link = '<a' . $args['link_parts'][0] . ' href="' . $args['link_parts'][1] . '.' . $args['link_parts'][2] . '" data-rel="' . $args['selector'] . '-gallery-' . $this->gallery_no . '" data-rl_title="__RL_IMAGE_TITLE__" data-rl_caption="__RL_IMAGE_CAPTION__"' . ( $args['script'] === 'magnific' ? ' data-magnific_type="gallery"' : '' ) . ( $args['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $args['link_number'] . '"' : '' ) . $args['link_parts'][3] . '>';
			} else
				$link = '<a' . $args['link_parts'][0] . 'href="' . $args['link_parts'][1] . '.' . $args['link_parts'][2] . '"' . $args['link_parts'][3] . ' data-rel="' . $args['selector'] . ( $args['settings']['plugin']['images_as_gallery'] ? $args['rel_hash'] : '-image-' . $args['link_number'] ) . '"' . ( $args['script'] === 'magnific' ? ' data-magnific_type="image"' : '' ) . ( $args['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $args['link_number'] . '"' : '' ) . ' data-rl_title="__RL_IMAGE_TITLE__" data-rl_caption="__RL_IMAGE_CAPTION__">';
		}

		// use safe replacement
		$link = str_replace( '__RL_IMAGE_TITLE__', $title, str_replace( '__RL_IMAGE_CAPTION__', $caption, $link ) );

		// title exists?
		if ( preg_match( '/<a.*? title=(?:\'|").*?(?:\'|").*?>/is', $link ) === 1 ) {
			$link = preg_replace( '/(<a.*? title=(?:\'|")).*?((?:\'|").*?>)/s', '${1}__RL_IMAGE_TITLE__$2', $link );
		} else
			$link = preg_replace( '/(<a.*?)>/s', '$1 title="__RL_IMAGE_TITLE__">', $link );

		// last safe replacement
		$link = str_replace( '__RL_IMAGE_TITLE__', $title, $link );

		return apply_filters( 'rl_lightbox_image_link', $link, $args );
	}

	/**
	 * Add lightbox to gallery image links.
	 *
	 * @param string $link
	 * @param int $id
	 * @param string $size
	 * @param bool $permalink
	 * @param mixed $icon
	 * @param mixed $text
	 */
	public function wp_get_attachment_link( $link, $id, $size, $permalink, $icon, $text ) {
		if ( Responsive_Lightbox()->options['settings']['galleries'] && wp_attachment_is_image( $id ) ) {
			// deprecated filter
			$link = apply_filters( 'rl_lightbox_attachment_link', $link, $id, $size, $permalink, $icon, $text, array() );

			// get current script
			$script = Responsive_Lightbox()->options['settings']['script'];

			// prepare arguments
			$args = array(
				'selector'	=> Responsive_Lightbox()->options['settings']['selector'],
				'script'	=> $script,
				'settings'	=> array(
					'script'	=> Responsive_Lightbox()->options['configuration'][$script],
					'plugin'	=> Responsive_Lightbox()->options['settings']
				),
				'supports'	=> Responsive_Lightbox()->settings->scripts[$script]['supports'],
				'image_id'	=> $id,
				'title'		=> '',
				'caption'	=> '',
				'src'		=> array()
			);

			$link = $this->lightbox_gallery_link( $link, $args );
		}

		return $link;
	}

	/**
	 * Add lightbox to gallery image links.
	 *
	 * @param string $link Gallery image link
	 * @param array $args Gallery link arguments
	 * @return string Updated gallery image link
	 */
	public function lightbox_gallery_link( $link, $args ) {
		// gallery image title
		$title = ! empty( $args['title'] ) ? $args['title'] : '';

		// get title type
		$title_arg = $args['settings']['plugin']['gallery_image_title'];

		// update title if needed
		if ( ! empty( $args['image_id'] ) && $title_arg !== 'default' ) {
			// original title
			$args['title'] = $this->get_attachment_title( $args['image_id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $args['image_id'], $link ) );
		}

		// sanitize title
		if ( $html_caption = rl_current_lightbox_supports( 'html_caption' ) )
			$title = esc_attr( trim( nl2br( $args['title'] ) ) );
		else
			$title = esc_attr( wp_strip_all_tags( trim ( nl2br( $args['title'] ) ), true ) );

		// add title and rl_title if needed
		if ( preg_match( '/<a.*? title=(?:\'|").*?(?:\'|").*?>/is', $link ) === 1 )
			$link = str_replace( '__RL_IMAGE_TITLE__', $title, preg_replace( '/(<a.*? title=(?:\'|")).*?((?:\'|").*?>)/s', '$1__RL_IMAGE_TITLE__" data-rl_title="__RL_IMAGE_TITLE__$2', $link ) );
		else
			$link = str_replace( '__RL_IMAGE_TITLE__', $title, preg_replace( '/(<a.*?)>/s', '$1 title="__RL_IMAGE_TITLE__" data-rl_title="__RL_IMAGE_TITLE__">', $link ) );

		// add class if needed
		if ( preg_match( '/<a[^>]*? class=(?:\'|").*?(?:\'|").*?>/is', $link ) === 1 )
			$link = preg_replace( '/(<a.*?) class=(?:\'|")(.*?)(?:\'|")(.*?>)/s', '$1 class="$2 rl-gallery-link" $3', $link );
		else
			$link = preg_replace( '/(<a.*?)>/s', '$1 class="rl-gallery-link">', $link );

		// gallery image caption
		$caption = ! empty( $args['caption'] ) ? $args['caption'] : '';

		// get caption type
		$caption_arg = $args['settings']['plugin']['gallery_image_caption'];

		// update caption if needed
		if ( ! empty( $args['image_id'] ) && $caption_arg !== 'default' ) {
			// original caption
			$args['caption'] = $this->get_attachment_title( $args['image_id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $caption_arg, $args['image_id'], $link ) );
		}

		// sanitize caption
		if ( $html_caption )
			$caption = esc_attr( trim( nl2br( $args['caption'] ) ) );
		else
			$caption = esc_attr( wp_strip_all_tags( trim( nl2br( $args['caption'] ) ), true ) );

		// add rl_caption
		$link = str_replace( '__RL_IMAGE_CAPTION__', $caption, preg_replace( '/(<a.*?)>/s', '$1 data-rl_caption="__RL_IMAGE_CAPTION__">', $link ) );

		if ( isset( $_GET['rl_gallery_no'], $_GET['rl_page'] ) )
			$this->gallery_no = (int) $_GET['rl_gallery_no'];

		// link already contains data-rel attribute?
		if ( preg_match( '/<a.*?data-rel=(\'|")(.*?)(\'|").*?>/is', $link, $result ) === 1 ) {
			if ( $result[2] !== 'norl' )
				$link = preg_replace( '/(<a.*?data-rel=(?:\'|").*?)((?:\'|").*?>)/s', '${1}' . $args['selector'] . '-gallery-' . $this->gallery_no . '$2', $link );
		} else
			$link = preg_replace( '/(<a.*?)>/s', '$1 data-rel="' . $args['selector'] . '-gallery-' . $this->gallery_no . '">', $link );

		if ( ! ( isset( $args['link'] ) && $args['link'] != 'file' ) ) {
			// gallery image size
			if ( ! empty( $args['image_id'] ) ) {
				if ( $args['settings']['plugin']['gallery_image_size'] !== 'full' ) {
					$args['src'] = wp_get_attachment_image_src( $args['image_id'], $args['settings']['plugin']['gallery_image_size'] );

					if ( preg_match( '/<a.*? href=("|\').*?("|\').*?>/is', $link ) === 1 )
						$link = preg_replace( '/(<a.*? href=(?:"|\')).*?((?:"|\').*?>)/', '$1' . $args['src'][0] . '$2', $link );
					else
						$link = preg_replace( '/(<a.*?)>/', '$1 href="' . $args['src'][0] . '">', $link );
				} else {
					$args['src'] = wp_get_attachment_image_src( $args['image_id'], 'full' );

					if ( preg_match( '/<a.*? href=("|\').*?("|\').*?>/is', $link ) === 1 )
						$link = preg_replace( '/(<a.*? href=(?:"|\')).*?((?:"|\').*?>)/', '$1' . $args['src'][0] . '$2', $link );
					else
						$link = preg_replace( '/(<a.*?)>/', '$1 href="' . $args['src'][0] . '">', $link );
				}
			}

			if ( $args['script'] === 'magnific' )
				$link = preg_replace( '/(<a.*?)>/is', '$1 data-magnific_type="gallery">', $link );
		}

		return apply_filters( 'rl_lightbox_gallery_link', $link, $args );
	}

	/**
	 * Add lightbox to content links.
	 *
	 * @param string $link Content link
	 * @param array $args Content arguments
	 * @return string Updated content link
	 */
	public function lightbox_content_link( $link, $args ) {
		if ( in_array( $args['content'], $args['supports'], true ) ) {
			// link already contains data-rel attribute?
			if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/is', $link, $result ) === 1 )
				$link = preg_replace( '/data-rel=(\'|")(.*?)(\'|")/s', 'data-rel="' . $args['selector'] . '-content-' . base64_encode( $result[1] ) . '"', $link );
			else
				$link = preg_replace( '/(<a.*?)>/s', '$1 data-rel="' . $args['selector'] . '-content-' . $args['link_number'] . '">', $link );

			switch ( $args['script'] ) {
				case 'nivo':
					$link = preg_replace( '/(<a.*?)>/s', '$1 data-lightbox-type="' . $args['content'] . '">', $link );
					break;

				case 'featherlight':
					$link = preg_replace( '/(<a.*?)>/s', '$1 data-featherlight="' . $args['content'] . '">', $link );
					break;

				case 'fancybox':
					if ( $args['content'] === 'iframe' )
						$link = preg_replace( '/(<a.*?href=(?:\'|"))(.*?)((?:\'|").*?>)/is', '$1' . add_query_arg( 'iframe', '', '$2' ) . '$3', $link );
					break;

				case 'prettyphoto':
					if ( $args['content'] === 'iframe' )
						$link = preg_replace( '/(<a.*?href=(?:\'|"))(.*?)((?:\'|").*?>)/is', '$1' . add_query_arg( array( 'iframe' => 'true', 'width' => $args['settings']['width'], 'height' => $args['settings']['height'] ), '$2' ) . '$3', $link );
			}
		}

		return apply_filters( 'rl_lightbox_content_link', $link, $args );
	}

	/**
	 * Get gallery fields.
	 *
	 * @param string $type Gallery type
	 * @return array Gallery fields
	 */
	public function get_gallery_fields( $type ) {
		$rl = Responsive_Lightbox();

		// get gallery fields
		$gallery_fields = $rl->settings->settings[$type . '_gallery']['fields'];

		// assign settings and defaults
		$gallery_defaults = $rl->defaults[$type . '_gallery'];
		$gallery_values = $rl->options[$type . '_gallery'];

		// make a copy
		$fields_copy = $gallery_fields;

		foreach ( $fields_copy as $field_key => $field ) {
			if ( $field['type'] === 'multiple' ) {
				foreach ( $field['fields'] as $subfield_key => $subfield ) {
					$gallery_fields[$field_key]['fields'][$subfield_key]['default'] = $gallery_defaults[$subfield_key];
					$gallery_fields[$field_key]['fields'][$subfield_key]['value'] = array_key_exists( $subfield_key, $gallery_values ) ? $gallery_values[$subfield_key] : $gallery_defaults[$subfield_key];
				}
			} else {
				$gallery_fields[$field_key]['default'] = $gallery_defaults[$field_key];
				$gallery_fields[$field_key]['value'] = array_key_exists( $field_key, $gallery_values ) ? $gallery_values[$field_key] : $gallery_defaults[$field_key];
			}
		}

		// get shortcode gallery fields combined with defaults
		return apply_filters( 'rl_get_gallery_fields', $this->get_unique_fields( $this->get_default_gallery_fields(), $gallery_fields ) );
	}

	/**
     * Get unique gallery fields.
     *
	 * @param array $defaults Default gallery fields
	 * @param array $fields Custom gallery fields
     * @return array Unique fields
     */
	public function get_unique_fields( $defaults, $fields ) {
		// check duplicated fields
		$duplicates = array_intersect_key( $defaults, $fields );

		// any duplicated fields?
		if ( ! empty( $duplicates ) ) {
			foreach ( $duplicates as $field_id => $field ) {
				unset( $defaults[$field_id] );
			}
		}

		// get default and custom fields all together
		return $defaults + $fields;
	}

	/**
	 * Get gallery fields combined with shortcode attributes.
	 *
	 * @param array $fields Gallery fields
	 * @param array $shortcode_atts Gallery shortcode attributes
	 * @param bool $gallery Whether is it rl_gallery shortcode
	 * @return array All combined field attributes
	 */
	public function get_gallery_fields_atts( $fields, $shortcode_atts, $gallery = true ) {
		// prepare default values
		$field_atts = array();

		// get all default field values
		foreach ( $fields as $field_key => $field ) {
			if ( $field['type'] === 'multiple' ) {
				foreach ( $field['fields'] as $subfield_key => $subfield ) {
					$field_atts[$subfield_key] = array_key_exists( 'value', $subfield ) ? $subfield['value'] : $subfield['default'];
				}
			} else
				$field_atts[$field_key] = array_key_exists( 'value', $field ) ? $field['value'] : $field['default'];
		}

		// is it rl gallery?
		if ( $gallery ) {
			$tabs = Responsive_Lightbox()->galleries->tabs;

			if ( ! empty( $tabs ) ) {	
				foreach ( $tabs as $key => $args ) {
					if ( in_array( $key, array( 'images', 'config' ) ) )
						continue;

					// get additional fields
					$data = get_post_meta( $shortcode_atts['rl_gallery_id'], '_rl_' . $key, true );

					// add those fields
					if ( ! empty( $data['menu_item'] ) && is_array( $data[$data['menu_item']] ) )
						$field_atts += $data[$data['menu_item']];
				}
			}

			if ( $field_atts['hover_effect'] !== '0' )
				$field_atts['gallery_custom_class'] .= ' rl-hover-effect-' . $field_atts['hover_effect'];
			
			if ( $field_atts['show_icon'] !== '0' )
				$field_atts['gallery_custom_class'] .= ' rl-hover-icon-' . $field_atts['show_icon'];
		}

		return apply_filters( 'rl_get_gallery_fields_atts', $field_atts );
	}

	/**
     * Get default gallery fields.
     *
     * @return array Default gallery
     */
	public function get_default_gallery_fields() {
		$sizes = get_intermediate_image_sizes();
		$sizes['full'] = 'full';

		return array(
			'size' => array(
				'title' => __( 'Size', 'responsive-lightbox' ),
				'type' => 'select',
				'description' => __( 'Specify the image size to use for the thumbnail display.', 'responsive-lightbox' ),
				'default' => 'medium',
				'options' => array_combine( $sizes, $sizes )
			),
			'link' => array(
				'title' => __( 'Link To', 'responsive-lightbox' ),
				'type' => 'select',
				'description' => __( 'Specify where you want the image to link.', 'responsive-lightbox' ),
				'default' => 'file',
				'options' => array(
					'post'	=> __( 'Attachment Page', 'responsive-lightbox' ),
					'file'	=> __( 'Media File', 'responsive-lightbox' ),
					'none'	=> __( 'None', 'responsive-lightbox' ),
				)
			),
			'orderby' => array(
				'title' => __( 'Orderby', 'responsive-lightbox' ),
				'type' => 'select',
				'description' => __( 'Specify how to sort the display thumbnails.', 'responsive-lightbox' ),
				'default' => 'menu_order',
				'options' => array(
					'id'			=> __( 'ID', 'responsive-lightbox' ),
					'title'			=> __( 'Title', 'responsive-lightbox' ),
					'post_date'		=> __( 'Date', 'responsive-lightbox' ),
					'menu_order'	=> __( 'Menu Order', 'responsive-lightbox' ),
					'rand'			=> __( 'Random', 'responsive-lightbox' )
				)
			),
			'order' => array(
				'title' => __( 'Order', 'responsive-lightbox' ),
				'type' => 'radio',
				'description' => __( 'Specify the sort order.', 'responsive-lightbox' ),
				'default' => 'asc',
				'options' => array(
					'asc'	=> __( 'Ascending', 'responsive-lightbox' ),
					'desc'	=> __( 'Descending', 'responsive-lightbox' )
				)
			),
			'columns' => array(
				'title' => __( 'Columns', 'responsive-lightbox' ),
				'type' => 'number',
				'description' => __( 'Specify the number of columns.', 'responsive-lightbox' ),
				'default' => 3,
				'min' => 1,
				'max' => 12
			)
		);
	}

	/**
	 * Sanitize shortcode gallery arguments.
	 *
	 * @param array $atts Shortcode arguments
	 * @param array $fields Gallery fields
	 * @return array Sanitized shortcode arguments
	 */
	public function sanitize_shortcode_args( $atts, $fields ) {
		$rl = Responsive_Lightbox();

		// validate gallery fields
		foreach ( $fields as $field_key => $field ) {
			// checkbox field?
			if ( $field['type'] === 'checkbox' ) {
				// valid argument?
				if ( array_key_exists( $field_key, $atts ) )
					$atts[$field_key] = $rl->galleries->sanitize_field( $field_key, array_flip( explode( ',', $atts[$field_key] ) ), $field );
			// boolean field?
			} elseif ( $field['type'] === 'boolean' ) {
				// multiple field?
				if ( $field['type'] === 'multiple' ) {
					foreach ( $field['fields'] as $subfield_key => $subfield ) {
						// valid argument?
						if ( array_key_exists( $subfield_key, $atts ) ) {
							// true value?
							if ( $atts[$subfield_key] === true || $atts[$subfield_key] === 'true' || $atts[$subfield_key] === '1' )
								$atts[$subfield_key] = 1;
							// false value?
							elseif ( $atts[$subfield_key] === false || $atts[$subfield_key] === 'false' || $atts[$subfield_key] === '0' || $atts[$subfield_key] === '' )
								$atts[$subfield_key] = 0;
							// default value
							else
								$atts[$subfield_key] = (int) $field['default'];
						}
					}
				} else {
					// valid argument?
					if ( array_key_exists( $field_key, $atts ) ) {
						// true value?
						if ( $atts[$field_key] === true || $atts[$field_key] === 'true' || $atts[$field_key] === '1' )
							$atts[$field_key] = 1;
						// false value?
						elseif ( $atts[$field_key] === false || $atts[$field_key] === 'false' || $atts[$field_key] === '0' || $atts[$field_key] === '' )
							$atts[$field_key] = 0;
						// default value
						else
							$atts[$field_key] = (int) $field['default'];
					}
				}
			// multiple field?
			} elseif ( $field['type'] === 'multiple' ) {
				foreach ( $field['fields'] as $subfield_key => $subfield ) {
					// valid argument?
					if ( array_key_exists( $subfield_key, $atts ) )
						$atts[$subfield_key] = $rl->galleries->sanitize_field( $subfield_key, $atts[$subfield_key], $subfield );
				}
			// other field?
			} else {
				// valid argument?
				if ( array_key_exists( $field_key, $atts ) )
					$atts[$field_key] = $rl->galleries->sanitize_field( $field_key, $atts[$field_key], $field );
			}
		}

		return apply_filters( 'rl_sanitize_shortcode_args', $atts );
	}

	/**
	 * Get gallery images.
	 *
	 * @param array $args Gallery arguments
	 * @return array Gallery images
	 */
	public function get_gallery_shortcode_images( $shortcode_atts ) {
		if ( ! isset( $shortcode_atts['show_title'] ) || $shortcode_atts['show_title'] === 'global' )
			$shortcode_atts['show_title'] = Responsive_Lightbox()->options['settings']['gallery_image_title'];

		if ( ! isset( $shortcode_atts['show_caption'] ) || $shortcode_atts['show_caption'] === 'global' )
			$shortcode_atts['show_caption'] = Responsive_Lightbox()->options['settings']['gallery_image_caption'];

		$images = array();

		// get gallery id
		$gallery_id = ! empty( $shortcode_atts['rl_gallery_id'] ) ? absint( $shortcode_atts['rl_gallery_id'] ) : 0;

		// get images from gallery
		if ( $gallery_id ) {
			$images = Responsive_Lightbox()->galleries->get_gallery_images(
				$gallery_id,
				array(
					'exclude' => true,
					'image_size' => $shortcode_atts['src_size'],
					'thumbnail_size' => $shortcode_atts['size']
				)
			);
		// get images from shortcode atts
		} else {
			$ids = array();

			if ( ! empty( $shortcode_atts['include'] ) ) {
				// filter attachment IDs
				$include = array_unique( array_filter( array_map( 'intval', explode( ',', $shortcode_atts['include'] ) ) ) );

				// any attachments?
				if ( ! empty( $include ) ) {
					// get attachments
					$ids = get_posts(
						array(
							'include'			=> implode( ',', $include ),
							'post_status'		=> 'inherit',
							'post_type'			=> 'attachment',
							'post_mime_type'	=> 'image',
							'order'				=> $shortcode_atts['order'],
							'orderby'			=> ( $shortcode_atts['orderby'] === 'menu_order' || $shortcode_atts['orderby'] === '' ? 'post__in' : $shortcode_atts['orderby'] ),
							'fields'			=> 'ids'
						)
					);
				}
			} elseif ( ! empty( $exclude ) ) {
				// filter attachment IDs
				$exclude = array_unique( array_filter( array_map( 'intval', explode( ',', $shortcode_atts['exclude'] ) ) ) );

				// any attachments?
				if ( ! empty( $exclude ) ) {
					// get attachments
					$ids = get_children(
						array(
							'post_parent'		=> $shortcode_atts['id'],
							'exclude'			=> $exclude,
							'post_status'		=> 'inherit',
							'post_type'			=> 'attachment',
							'post_mime_type'	=> 'image',
							'order'				=> $shortcode_atts['order'],
							'orderby'			=> $shortcode_atts['orderby'],
							'fields'			=> 'ids'
						)
					);
				}
			} else {
				// get attachments
				$ids = get_children(
					array(
						'post_parent'		=> $shortcode_atts['id'],
						'post_status'		=> 'inherit',
						'post_type'			=> 'attachment',
						'post_mime_type'	=> 'image',
						'order'				=> $shortcode_atts['order'],
						'orderby'			=> $shortcode_atts['orderby'],
						'fields'			=> 'ids'
					)
				);
			}
			
			// any attachments?
			if ( ! empty( $ids ) ) {
				foreach ( $ids as $attachment_id ) {
					// get thumbnail image data
					$images[] = Responsive_Lightbox()->galleries->get_gallery_image_src( $attachment_id, $shortcode_atts['src_size'], $shortcode_atts['size'] );
				}
			}
		}

		// apply adjustments, as per settings
		if ( $images ) {
			// get current script
			$script = Responsive_Lightbox()->options['settings']['script'];

			// prepare arguments
			$args = array(
				'selector'	=> Responsive_Lightbox()->options['settings']['selector'],
				'script'	=> $script,
				'settings'	=> array(
					'script'	=> Responsive_Lightbox()->options['configuration'][$script],
					'plugin'	=> Responsive_Lightbox()->options['settings']
				),
				'supports'	=> Responsive_Lightbox()->settings->scripts[$script]['supports'],
				'image_id'	=> 0,
				'caption'	=> '',
				'title'		=> '',
				'src'		=> array()
			);

			// lightbox image title
			$args['settings']['plugin']['gallery_image_title'] = ! empty( $shortcode_atts['lightbox_image_title'] ) ? ( $shortcode_atts['lightbox_image_title'] === 'global' ? Responsive_Lightbox()->options['settings']['gallery_image_title'] : $shortcode_atts['lightbox_image_title'] ) : Responsive_Lightbox()->options['settings']['gallery_image_title'];

			// lightbox image caption
			$args['settings']['plugin']['gallery_image_caption'] = ! empty( $shortcode_atts['lightbox_image_caption'] ) ? ( $shortcode_atts['lightbox_image_caption'] === 'global' ? Responsive_Lightbox()->options['settings']['gallery_image_caption'] : $shortcode_atts['lightbox_image_caption'] ) : Responsive_Lightbox()->options['settings']['gallery_image_caption'];

			// get gallery image link
			$args['link'] = isset( $shortcode_atts['link'] ) ? $shortcode_atts['link'] : '';

			// copy images
			$images_tmp = $images;

			// apply adjustments, according to gallery settings
			foreach ( $images_tmp as $index => $image ) {
				// assign image
				$new_image = $images[$index] = array_merge( $image, Responsive_Lightbox()->galleries->get_gallery_image_src( $image, $shortcode_atts['src_size'], $shortcode_atts['size'] ) );

				// create image source data
				$args['src'] = array( $new_image['url'], $new_image['width'], $new_image['height'] );

				// set alt text
				$images[$index]['alt'] = ! empty( $new_image['alt'] ) ? esc_attr( $new_image['alt'] ) : ( ! empty( $new_image['id'] ) ? get_post_meta( $new_image['id'], '_wp_attachment_image_alt', true ) : '' );

				// set lightbox image title
				if ( $args['settings']['plugin']['gallery_image_title'] === 'default' )
					$images[$index]['title'] = $args['title'] = '';
				else
					$images[$index]['title'] = $args['title'] = ! empty( $new_image['id'] ) ? $this->get_attachment_title( $new_image['id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $args['settings']['plugin']['gallery_image_title'], $new_image['id'], $images[$index]['link'] ) ) : $new_image['title'];

				// set lightbox image caption
				if ( $args['settings']['plugin']['gallery_image_caption'] === 'default' )
					$images[$index]['caption'] = $args['caption'] = '';
				else
					$images[$index]['caption'] = $args['caption'] = ! empty( $new_image['id'] ) ? $this->get_attachment_title( $new_image['id'], apply_filters( 'rl_lightbox_attachment_image_title_arg', $args['settings']['plugin']['gallery_image_caption'], $images[$index]['link'] ) ) : $new_image['caption'];

				// set image gallery link
				$images[$index]['link'] = $this->lightbox_gallery_link( $this->get_gallery_image_link( $new_image['id'], $args['src'], array( $new_image['thumbnail_url'], $new_image['thumbnail_width'], $new_image['thumbnail_height'] ), $shortcode_atts ), $args );

				// is lightbox active?
				if ( isset( $shortcode_atts['lightbox_enable'] ) && $shortcode_atts['lightbox_enable'] === 0 )
					$images[$index]['link'] = preg_replace( '/data-rel=(\'|")(.*?)(\'|")/', 'data-rel="norl"', $images[$index]['link'] );
			}
		}

		return apply_filters( 'rl_get_gallery_shortcode_images', $images, $gallery_id, $shortcode_atts );
	}

	/**
	 * Get gallery image link.
	 *
	 * @param int $attachment_id Attachment ID
	 * @param array $image Source image data
	 * @param array $thumbnail Thumbnail image data
	 * @param array $args Arguments
	 * @return string Generated gallery image link
	 */
	function get_gallery_image_link( $attachment_id, $image, $thumbnail, $args ) {
		switch ( $args['link'] ) {
			case 'post':
				$link = '<a href="' . get_permalink( $attachment_id ) . '"><img src="' . $thumbnail[0] . '" width="' . $thumbnail[1] . '" height="' . $thumbnail[2] . '" />';
				break;

			case 'none':
				$link = '<a href="javascript:void(0)" style="cursor: default;"><img src="' . $thumbnail[0] . '" width="' . $thumbnail[1] . '" height="' . $thumbnail[2] . '" />';
				break;

			default:
			case 'file':
				$link = '<a href="' . $image[0] . '"><img src="' . $thumbnail[0] . '" width="' . $thumbnail[1] . '" height="' . $thumbnail[2] . '" />';
		}

		$title = ! empty( $args['show_title'] ) ? trim( $this->get_attachment_title( $attachment_id, $args['show_title'] ) ) : '';
		$caption = ! empty( $args['show_caption'] ) ? trim( $this->get_attachment_title( $attachment_id, $args['show_caption'] ) ) : '';

		if ( $title || $caption ) {
			$link .= '<span class="rl-gallery-caption">';

			if ( $title )
				$link .= '<span class="rl-gallery-item-title">' . esc_html( $title ) . '</span>';

			if ( $caption )
				$link .= '<span class="rl-gallery-item-caption">' . esc_html( $caption ) . '</span>';

			$link .= '</span>';
		}

		$link .= '</a>';

		return apply_filters( 'rl_gallery_image_link', $link, $attachment_id, $image, $thumbnail, $args );
	}

	/**
	 * Add lightbox to Jetpack tiled gallery.
	 *
	 * @param string $content
	 * @return string
	 */
	public function force_custom_gallery_lightbox( $content ) {
		if ( Responsive_Lightbox()->options['settings']['force_custom_gallery'] ) {
			// search for image links
			preg_match_all( '/<a(.*?)href=(?:\'|")([^<]*?)\.(bmp|gif|jpeg|jpg|png|webp)(?:\'|")(.*?)>/i', $content, $links );

			// found any links?
			if ( ! empty ( $links[0] ) ) {
				foreach ( $links[0] as $link_number => $link ) {
					// get attachment id
					$image_id = $this->get_attachment_id_by_url( $links[2][$link_number] . '.' . $links[3][$link_number] );

					// get title type
					$title_arg = Responsive_Lightbox()->options['settings']['gallery_image_title'];

					// update title if needed
					if ( $title_arg !== 'default' && $image_id )
						$title = esc_attr( wp_strip_all_tags( trim ( $this->get_attachment_title( $image_id, apply_filters( 'rl_lightbox_attachment_image_title_arg', $title_arg, $image_id, $links[2][$link_number] . '.' . $links[3][$link_number] ) ) ), true ) );
					else
						$title = '';

					// get caption type
					$caption_arg = Responsive_Lightbox()->options['settings']['gallery_image_caption'];

					// update caption if needed
					if ( $caption_arg !== 'default' )
						$caption = esc_attr( wp_strip_all_tags( trim ( $this->get_attachment_title( $image_id, apply_filters( 'rl_lightbox_attachment_image_title_arg', $caption_arg, $image_id, $links[2][$link_number] . '.' . $links[3][$link_number] ) ) ), true ) );
					else
						$caption = '';

					// link already contains data-rel attribute?
					if ( preg_match( '/<a.*?(?:data-rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {
						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						$content = str_replace( $link, preg_replace( '/data-rel=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $result[1] ) . '" data-rl_title="' . $title . '" data-rl_caption="' . $caption . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $link_number . '"' : '' ), $link ), $content );
					} elseif ( preg_match( '/<a.*?(?:rel)=(?:\'|")(.*?)(?:\'|").*?>/', $link, $result ) === 1 ) {
						// do not modify this link
						if ( $result[1] === 'norl' )
							continue;

						$content = str_replace( $link, preg_replace( '/rel=(?:\'|")(.*?)(?:\'|")/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $result[1] ) . '" data-rl_title="' . $title . '" data-rl_caption="' . $caption . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $link_number . '"' : '' ), $link ), $content );
					} else
						$content = str_replace( $link, '<a' . $links[1][$link_number] . ' href="' . $links[2][$link_number] . '.' . $links[3][$link_number] . '" data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . base64_encode( $this->gallery_no ) . '" data-rl_title="' . $title . '" data-rl_caption="' . $caption . '"' . ( Responsive_Lightbox()->options['settings']['script'] === 'imagelightbox' ? ' data-imagelightbox="' . $link_number . '"' : '' ) . $links[4][$link_number] . '>', $content );
				}
			}
		}

		return $content;
	}

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
		if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] )
			$html = preg_replace( '/data-rel=\"(.*?)\"/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"', $html );

		return $html;
	}

	/**
	 * Apply lightbox to WooCommerce product gallery.
	 * 
	 * @param mixed $html
	 * @return mixed
	 */
	public function woocommerce_single_product_image_thumbnail_html( $html ) {
		if ( Responsive_Lightbox()->options['settings']['woocommerce_gallery_lightbox'] ) {
			$html = preg_replace( '/data-rel=\"(.*?)\"/', 'data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '"', $html );

			preg_match( '/<a(.*?)((?:data-rel)=(?:\'|").*?(?:\'|"))(.*?)>/i', $html, $result );

			// no data-rel?
			if ( empty( $result ) ) {
				preg_match( '/^(.*?)<a(.*?)((?:href)=(?:\'|").*?(?:\'|"))(.*?)>(.*?)$/i', $html, $result );

				// found valid link?
				if ( ! empty( $result ) )
					$html = $result[1] . '<a' . $result[2] . ' data-rel="' . Responsive_Lightbox()->options['settings']['selector'] . '-gallery-' . $this->gallery_no . '" ' . $result[3] . $result[4] . '>' . $result[5];
			}
		}

		return $html;
	}
	
	/**
	 * WooCommerce gallery init.
	 */
	public function woocommerce_gallery_init() {
		if ( ( $priority = has_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails' ) ) != false && ! empty( Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] ) ) {
			// remove default gallery
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', $priority );

			// handle product gallery
			add_action( 'woocommerce_product_thumbnails', array( $this, 'woocommerce_gallery' ), $priority );
		}
	}
	
	/**
	 * WooCommerce gallery support.
	 * 
	 * @global object $product
	 * @return mixed
	 */
	public function woocommerce_gallery() {
		global $product;
		
		$attachment_ids = array();

		// WooCommerce 3.x
		if ( method_exists( $product, 'get_gallery_image_ids' ) ) {
			$attachment_ids = $product->get_gallery_image_ids();
		// WooCommerce 2.x
		} elseif ( method_exists( $product, 'get_gallery_attachment_ids' ) ) {
			$attachment_ids = $product->get_gallery_attachment_ids();
		}

		if ( ! empty( $attachment_ids ) && is_array( $attachment_ids ) )
			echo do_shortcode( '[gallery type="' . Responsive_Lightbox()->options['settings']['default_woocommerce_gallery'] . '" size="' . apply_filters( 'single_product_small_thumbnail_size', 'medium' ) . '" ids="' . implode( ',', $attachment_ids ) . '"]' );
	}

	/**
	 * Get attachment title function
	 * 
	 * @param int $id
	 * @param string $title_arg
	 * @return string
	 */
	public function get_attachment_title( $id, $title_arg ) {
		if ( empty( $title_arg ) || empty( $id ) )
			return false;

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
		$post_ids = get_transient( 'rl-attachment_ids_by_url' );
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

			set_transient( 'rl-attachment_ids_by_url', $post_ids, $expire );
		// cached url found
		} elseif ( ! empty( $post_ids[$url] ) )
			$post_id = absint( $post_ids[$url] );

	    return (int) apply_filters( 'rl_get_attachment_id_by_url', $post_id, $url );
	}

	/**
	 * Get image size by URL.
	 *
	 * @param string $url Image URL
	 * @return array
	 */
	public function get_image_size_by_url( $url ) {
		$url = ! empty( $url ) ? esc_url( $url ) : '';
		$size = array( 0, 0 );

		if ( ! empty( $url ) ) {
			// get cached data
			$image_sizes = get_transient( 'rl-image_sizes_by_url' );

			// cached url not found?
			if ( $image_sizes === false || ! in_array( $url, array_keys( $image_sizes ) ) || empty( $image_sizes[$url] ) ) {
				if ( class_exists( 'Responsive_Lightbox_Fast_Image' ) ) {
					// loading image
					$image = new Responsive_Lightbox_Fast_Image( $url );

					// get size
					$size = $image->get_size();
				} else {
					// get size using php
					$size = getimagesize( $url );
				}

				// set the cache expiration, 24 hours by default
				$expire = absint( apply_filters( 'rl_object_cache_expire', DAY_IN_SECONDS ) );

				$image_sizes[$url] = $size;

				set_transient( 'rl-image_sizes_by_url', $image_sizes, $expire );
			// cached url found
			} elseif ( ! empty( $image_sizes[$url] ) )
				$size = array_map( 'absint', $image_sizes[$url] );
		}

		return apply_filters( 'rl_get_image_size_by_url', $size, $url );
	}

	/**
	 * Add gallery shortcode to gallery post content.
	 * 
	 * @param string $content
	 * @return string Updated content
	 */
	public function gallery_preview( $content ) {
		if ( get_post_type() === 'rl_gallery' && ! ( is_archive() && is_main_query() ) )
			$content .= do_shortcode( '[rl_gallery id="' . get_the_ID() . '"]' );

		return $content;
	}

	/**
	 * Helper: gallery number function
	 * 
	 * @param mixed $content
	 * @return mixed
	 */
	public function gallery_attributes( $content, $shortcode_atts ) {
		++$this->gallery_no;
		
		// add inline style, to our galleries only
		if ( isset( $shortcode_atts['type'] ) ) {
			// gallery style
			wp_enqueue_style( 'responsive-lightbox-gallery' );

			// is there rl_gallery ID?
			$rl_gallery_id = ! empty( $shortcode_atts['rl_gallery_id'] ) ? (int) $shortcode_atts['rl_gallery_id'] : 0;

			// is it rl gallery?
			$rl_gallery = Responsive_Lightbox()->options['builder']['gallery_builder'] && $rl_gallery_id && get_post_type( $rl_gallery_id ) === 'rl_gallery';

			// is it rl gallery? add design options
			if ( $rl_gallery ) {
				$fields = Responsive_Lightbox()->galleries->fields['design']['options'];

				// get gallery fields attributes
				$field_atts = rl_get_gallery_fields_atts( $fields, $shortcode_atts, $rl_gallery );

				// get only valid arguments
				$atts = shortcode_atts( $field_atts, array_merge( $field_atts, $shortcode_atts ), 'gallery' );

				// sanitize gallery fields
				$atts = $this->sanitize_shortcode_args( $atts, $fields );

				// add inline style
				$inline_css = '
					.rl-gallery .rl-gallery-link {
						border: ' . $atts['border_width'] . 'px solid ' . $atts['border_color'] . ';
					}
					.rl-gallery .rl-gallery-link .rl-gallery-item-title {
						color: ' . $atts['title_color'] . ';
					}
					.rl-gallery .rl-gallery-link .rl-gallery-item-caption {
						color: ' . $atts['caption_color'] . ';
					}
					.rl-gallery .rl-gallery-link .rl-gallery-caption,
					.rl-gallery .rl-gallery-link:after {
						background-color: rgba( ' . implode( ', ', Responsive_Lightbox()->hex2rgb( $atts['background_color'] ) ) . ', ' . round( $atts['background_opacity'] / 100, 2 ) . ' );
					}
					[class^="rl-hover-icon-"] .rl-gallery-link:before,
					[class*=" rl-hover-icon-"] .rl-gallery-link:before {
						color: ' . $atts['title_color'] . ';
						background-color: rgba( ' . implode( ', ', Responsive_Lightbox()->hex2rgb( $atts['background_color'] ) ) . ', ' . round( $atts['background_opacity'] / 100, 2 ) . ' );
					}
				';

				wp_add_inline_style( 'responsive-lightbox-gallery', $inline_css );
			}
		}

		return $content;
	}

	/**
	 * Generate unique hash.
	 *
	 * @param int $length
	 * @return string
	*/
	private function generate_hash( $length = 8 ) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$hash = '';

		for( $i = 0; $i < $length; $i++ ) {
			$hash .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
		}

		return $hash;
	}

	/**
	 * Replace widget callback function.
	 * 
	 * @global array $wp_registered_widgets
	 * @param array $sidebar_params
	 * @return type
	 */
	public function dynamic_sidebar_params( $sidebar_params ) {
		if ( ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) || Responsive_Lightbox()->options['settings']['widgets'] != true )
			return $sidebar_params;

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
	public function widget_output( $content, $widget_id_base, $widget_id ) {
		return $this->add_lightbox( $content );
	}

	/**
	 * Filter comment content.
	 * 
	 * @param mixed $comment_content
	 * @return mixed
	 */
	public function get_comment_text( $content ) {
		if ( ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) || Responsive_Lightbox()->options['settings']['comments'] != true )
			return $content;

		return $this->add_lightbox( $content );
	}

	/**
	 * Modify gallery container class.
	 *
	 * @param string $class
	 * @param array $args
	 * @param int $gallery_id
	 * @return void
	 */
	public function gallery_container_class( $class, $args, $gallery_id ) {
		if ( $gallery_id ) {
			$class .= ' rl-loading';

			if ( $args['pagination'] )
				$class .= ' rl-pagination-' . $args['pagination_type'];
		}

		return $class;
	}

	/**
	 * Display content before the gallery.
	 * 
	 * @param array $args
	 * @param int $gallery_id
	 * @return void
	 */
	public function before_gallery( $args, $gallery_id ) {
		// if ( $gallery_id && ! ( isset( $_POST['action'] ) && $_POST['action'] === 'rl-get-gallery-page-content' ) ) {
		if ( $gallery_id ) {
			if ( isset( $args['gallery_title_position'] ) && $args['gallery_title_position'] === 'top' && get_post_type() !== 'rl_gallery' )
				echo '<div class="rl-gallery-title">' . esc_html( get_the_title( $gallery_id ) ) . '</div>';

			if ( isset( $args['gallery_description_position'] ) && $args['gallery_description_position'] === 'top' )
				echo '<div class="rl-gallery-description">' . nl2br( esc_html( $args['gallery_description'] ) ) . '</div>';
		}
	}

	/**
	 * Display content after the gallery.
	 * 
	 * @param array $args
	 * @param int $gallery_id
	 * @return void
	 */
	public function after_gallery( $args, $gallery_id ) {
		if ( $gallery_id ) {
			if ( isset( $args['gallery_title_position'] ) && $args['gallery_title_position'] === 'bottom' && get_post_type() !== 'rl_gallery' )
				echo '<div class="rl-gallery-title">' . esc_html( get_the_title( $gallery_id ) ) . '</div>';

			if ( isset( $args['gallery_description_position'] ) && $args['gallery_description_position'] === 'bottom' )
				echo '<div class="rl-gallery-description">' . nl2br( esc_html( $args['gallery_description'] ) ) . '</div>';
		}
	}

	/**
	 * Add lightbox to Visual Composer shortcodes.
	 *
	 * @param string $content HTML content
	 * @param string $shortcode Shortcode type
	 * @return string Changed HTML content
	 */
	public function vc_shortcode_content_filter_after( $content, $shortcode ) {
		if ( in_array( $shortcode, apply_filters( 'rl_lightbox_vc_allowed_shortcode', array( 'vc_gallery', 'vc_single_image', 'vc_images_carousel' ) ), true ) )
			$content = $this->add_lightbox( $content );

		return $content;
	}

	/**
	 * Render Basic Grid gallery shortcode.
	 *
	 * @global object $post Post object
	 * @param mixed $output HTML output
	 * @param array $shortcode_atts Shortcode attributes
	 * @return string HTML output
	 */
	public function basic_grid_gallery_shortcode( $output, $shortcode_atts ) {
		if ( ! empty( $output ) )
			return $output;

		global $post;

		$defaults = array(
			'rl_gallery_id'	 => 0,
			'id'			 => isset( $post->ID ) ? (int) $post->ID : 0,
			'class'			 => '',
			'include'		 => '',
			'exclude'		 => '',
			'urls'			 => '',
			'type'			 => '',
			'order'			 => 'asc',
			'orderby'		 => 'menu_order',
			'size'			 => 'medium',
			'link'			 => 'file',
			'columns'		 => 3
		);

		// get main instance
		$rl = Responsive_Lightbox();

		// is there rl_gallery ID?
		$rl_gallery_id = $defaults['rl_gallery_id'] = ! empty( $shortcode_atts['rl_gallery_id'] ) ? (int) $shortcode_atts['rl_gallery_id'] : 0;

		// is it rl gallery?
		$rl_gallery = $rl->options['builder']['gallery_builder'] && $rl_gallery_id && get_post_type( $rl_gallery_id ) === 'rl_gallery';

		if ( ! array_key_exists( 'type', $shortcode_atts ) )
			$shortcode_atts['type'] = '';

		// break if it is not basic grid gallery - first check
		if ( ! ( $shortcode_atts['type'] === 'basicgrid' || ( $shortcode_atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicgrid' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicgrid' ) ) ) ) )
			return $output;

		// get shortcode gallery fields combined with defaults
		$fields = rl_get_gallery_fields( 'basicgrid' );

		// get gallery fields attributes
		$field_atts = rl_get_gallery_fields_atts( $fields, $shortcode_atts, $rl_gallery );

		// is it rl gallery? add misc and lightbox fields
		if ( $rl_gallery )
			$fields += $rl->galleries->fields['lightbox']['options'] + $rl->galleries->fields['misc']['options'];

		// get only valid arguments
		$atts = shortcode_atts( array_merge( $defaults, $field_atts ), $shortcode_atts, 'gallery' );

		// sanitize gallery fields
		$atts = $this->sanitize_shortcode_args( $atts, $fields );

		// break if it is not basic grid gallery
		if ( ! ( $atts['type'] === 'basicgrid' || ( $atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicgrid' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicgrid' ) ) ) ) )
			return $output;

		// ID
		$atts['id'] = (int) $atts['id'];

		// add custom classes if needed
		if ( $rl_gallery )
			$atts['class'] .= ' ' . $atts['gallery_custom_class'];

		// any classes?
		if ( $atts['class'] !== '' ) {
			$atts['class'] = trim( $atts['class'] );

			// more than 1 class?
			if ( strpos( $atts['class'], ' '  ) !== false ) {
				// get unique valid HTML classes
				$atts['class'] = array_unique( array_filter( array_map( 'sanitize_html_class', explode( ' ', $atts['class'] ) ) ) );

				if ( ! empty( $atts['class'] ) )
					$atts['class'] = implode( ' ', $atts['class'] );
				else
					$atts['class'] = '';
			// single class
			} else
				$atts['class'] = sanitize_html_class( $atts['class'] );
		}

		// orderby
		if ( empty( $atts['orderby'] ) ) {
			$atts['orderby'] = sanitize_sql_orderby( $atts['orderby'] );

			if ( empty( $atts['orderby'] ) )
				$atts['orderby'] = $defaults['orderby'];
		}

		// order
		if ( strtolower( $atts['order'] ) === 'rand' )
			$atts['orderby'] = 'rand';

		// check columns
		if ( $atts['columns_lg'] === 0 )
			$atts['columns_lg'] = $atts['columns'];

		if ( $atts['columns_md'] === 0 )
			$atts['columns_md'] = $atts['columns'];

		if ( $atts['columns_sm'] === 0 )
			$atts['columns_sm'] = $atts['columns'];

		if ( $atts['columns_xs'] === 0 )
			$atts['columns_xs'] = $atts['columns'];

		// gallery lightbox source size
		if ( ! empty( $atts['lightbox_image_size'] ) ) {
			if ( $atts['lightbox_image_size'] === 'global' )
				$atts['src_size'] = $rl->options['settings']['gallery_image_size'];
			elseif ( $atts['lightbox_image_size'] === 'lightbox_custom_size' && isset( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] ) )
				$atts['src_size'] = array( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] );
			else
				$atts['src_size'] = $atts['lightbox_image_size'];
		} else
			$atts['src_size'] = $rl->options['settings']['gallery_image_size'];

		// filter all shortcode arguments
		$atts = apply_filters( 'rl_gallery_shortcode_atts', $atts, $rl_gallery_id );

		// get gallery images
		$images = rl_get_gallery_shortcode_images( $atts );

		if ( empty( $images ) || is_feed() || defined( 'IS_HTML_EMAIL' ) )
			return $output;

		$gallery_no = $this->gallery_no;

		ob_start(); ?>

		<div class="rl-gallery-container<?php echo apply_filters( 'rl_gallery_container_class', '', $atts, $rl_gallery_id ); ?>" id="rl-gallery-container-<?php echo $gallery_no; ?>" data-gallery_id="<?php echo $rl_gallery_id; ?>">

			<?php do_action( 'rl_before_gallery', $atts, $rl_gallery_id ); ?>

			<div class="rl-gallery rl-basicgrid-gallery <?php echo $atts['class']; ?>" id="rl-gallery-<?php echo $gallery_no; ?>" data-gallery_no="<?php echo $gallery_no; ?>">

			<?php foreach ( $images as $image ) {
				echo '<div class="rl-gallery-item">' . $image['link'] . '</div>';
			} ?>

			</div>

			<?php do_action( 'rl_after_gallery', $atts, $rl_gallery_id ); ?>

		</div>

		<?php $gallery_html = ob_get_contents();

		ob_end_clean();

		// styles
		wp_enqueue_style( 'responsive-lightbox-basicgrid-gallery', plugins_url( 'css/gallery-basicgrid.css', dirname( __FILE__ ) ), array(), $rl->defaults['version'] );
		
		// add inline style
		$inline_css = '
			#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery {
				padding: ' . ( -$atts['gutter'] ) . 'px;
			}
			#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
				width: calc(' . ( 100 / $atts['columns'] ) . '% - ' . $atts['gutter'] . 'px);
				margin: ' . ( $atts['gutter'] / 2 ) . 'px;
			}
			@media all and (min-width: 1200px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
					width: calc(' . ( 100 / $atts['columns_lg'] ) . '% - ' . $atts['gutter'] . 'px);
				}
			}
			@media all and (min-width: 992px) and (max-width: 1200px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
					width: calc(' . ( 100 / $atts['columns_md'] ) . '% - ' . $atts['gutter'] . 'px);
				}
			}
			@media all and (min-width: 768px) and (max-width: 992px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
					width: calc(' . ( 100 / $atts['columns_sm'] ) . '% - ' . $atts['gutter'] . 'px);
				}
			}
			@media all and (max-width: 768px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
					width: calc(' . ( 100 / $atts['columns_xs'] ) . '% - ' . $atts['gutter'] . 'px);
				}
			}
		';
		
		if ( $atts['force_height'] ) {
			$inline_css .= '
			#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item {
				height: ' . ( $atts['row_height'] ) . 'px;
			}
			#rl-gallery-container-' . $gallery_no . ' .rl-basicgrid-gallery .rl-gallery-item img {
				height: ' . ( $atts['row_height'] ) . 'px;
				object-fit: cover;
				max-width: 100%;
				min-width: 100%;
			}';
		}
		
        wp_add_inline_style( 'responsive-lightbox-basicgrid-gallery', $inline_css );

		// remove any new lines from the output so that the reader parses it better
		return apply_filters( 'rl_gallery_shortcode_html', trim( preg_replace( '/\s+/', ' ', $gallery_html ) ), $atts, $rl_gallery_id );
	}

	/**
	 * Render Basic Slider gallery shortcode.
	 *
	 * @global object $post Post object
	 * @param mixed $output HTML output
	 * @param array $shortcode_atts Shortcode attributes
	 * @return string HTML output
	 */
	public function basic_slider_gallery_shortcode( $output, $shortcode_atts ) {
		if ( ! empty( $output ) )
			return $output;

		global $post;

		$defaults = array(
			'rl_gallery_id'	 => 0,
			'id'			 => isset( $post->ID ) ? (int) $post->ID : 0,
			'class'			 => '',
			'include'		 => '',
			'exclude'		 => '',
			'urls'			 => '',
			'type'			 => '',
			'order'			 => 'asc',
			'orderby'		 => 'menu_order',
			'size'			 => 'medium',
			'link'			 => 'file',
			'columns'		 => 3
		);

		// get main instance
		$rl = Responsive_Lightbox();

		// is there rl_gallery ID?
		$rl_gallery_id = $defaults['rl_gallery_id'] = ! empty( $shortcode_atts['rl_gallery_id'] ) ? (int) $shortcode_atts['rl_gallery_id'] : 0;

		// is it rl gallery?
		$rl_gallery = $rl->options['builder']['gallery_builder'] && $rl_gallery_id && get_post_type( $rl_gallery_id ) === 'rl_gallery';

		if ( ! array_key_exists( 'type', $shortcode_atts ) )
			$shortcode_atts['type'] = '';

		// break if it is not basic slider gallery - first check
		if ( ! ( $shortcode_atts['type'] === 'basicslider' || ( $shortcode_atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicslider' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicslider' ) ) ) ) )
			return $output;

		// get shortcode gallery fields combined with defaults
		$fields = rl_get_gallery_fields( 'basicslider' );

		// get gallery fields attributes
		$field_atts = rl_get_gallery_fields_atts( $fields, $shortcode_atts, $rl_gallery );

		// is it rl gallery? add misc and lightbox fields
		if ( $rl_gallery )
			$fields += $rl->galleries->fields['lightbox']['options'] + $rl->galleries->fields['misc']['options'];

		// get only valid arguments
		$atts = shortcode_atts( array_merge( $defaults, $field_atts ), $shortcode_atts, 'gallery' );

		// sanitize gallery fields
		$atts = $this->sanitize_shortcode_args( $atts, $fields );

		// break if it is not basic slider gallery
		if ( ! ( $atts['type'] === 'basicslider' || ( $atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicslider' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicslider' ) ) ) ) )
			return $output;

		// ID
		$atts['id'] = (int) $atts['id'];

		// add custom classes if needed
		if ( $rl_gallery )
			$atts['class'] .= ' ' . $atts['gallery_custom_class'];

		// any classes?
		if ( $atts['class'] !== '' ) {
			$atts['class'] = trim( $atts['class'] );

			// more than 1 class?
			if ( strpos( $atts['class'], ' '  ) !== false ) {
				// get unique valid HTML classes
				$atts['class'] = array_unique( array_filter( array_map( 'sanitize_html_class', explode( ' ', $atts['class'] ) ) ) );

				if ( ! empty( $atts['class'] ) )
					$atts['class'] = implode( ' ', $atts['class'] );
				else
					$atts['class'] = '';
			// single class
			} else
				$atts['class'] = sanitize_html_class( $atts['class'] );
		}

		// orderby
		if ( empty( $atts['orderby'] ) ) {
			$atts['orderby'] = sanitize_sql_orderby( $atts['orderby'] );

			if ( empty( $atts['orderby'] ) )
				$atts['orderby'] = $defaults['orderby'];
		}

		// order
		if ( strtolower( $atts['order'] ) === 'rand' )
			$atts['orderby'] = 'rand';

		// gallery lightbox source size
		if ( ! empty( $atts['lightbox_image_size'] ) ) {
			if ( $atts['lightbox_image_size'] === 'global' )
				$atts['src_size'] = $rl->options['settings']['gallery_image_size'];
			elseif ( $atts['lightbox_image_size'] === 'lightbox_custom_size' && isset( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] ) )
				$atts['src_size'] = array( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] );
			else
				$atts['src_size'] = $atts['lightbox_image_size'];
		} else
			$atts['src_size'] = $rl->options['settings']['gallery_image_size'];

		// filter all shortcode arguments
		$atts = apply_filters( 'rl_gallery_shortcode_atts', $atts, $rl_gallery_id );

		// get gallery images
		$images = rl_get_gallery_shortcode_images( $atts );

		if ( empty( $images ) || is_feed() || defined( 'IS_HTML_EMAIL' ) )
			return $output;

		$gallery_no = $this->gallery_no;

		ob_start(); ?>

		<div class="rl-gallery-container<?php echo apply_filters( 'rl_gallery_container_class', '', $atts, $rl_gallery_id ); ?>" id="rl-gallery-container-<?php echo $gallery_no; ?>" data-gallery_id="<?php echo $rl_gallery_id; ?>">

			<?php do_action( 'rl_before_gallery', $atts, $rl_gallery_id ); ?>

			<ul class="rl-gallery rl-basicslider-gallery <?php echo $atts['class']; ?>" id="rl-gallery-<?php echo $gallery_no; ?>" data-gallery_no="<?php echo $gallery_no; ?>">
 
			<?php foreach ( $images as $image ) {
				echo '<li class="rl-gallery-item">' . $image['link'] . '</li>';
			} ?>

			</ul>

			<?php do_action( 'rl_after_gallery', $atts, $rl_gallery_id ); ?>

		</div>

		<?php $gallery_html = ob_get_contents();

		ob_end_clean();

		// scripts
		wp_register_script( 'responsive-lightbox-basicslider-gallery-js', plugins_url( 'assets/slippry/slippry' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.js', dirname( __FILE__ ) ), array( 'jquery' ), $rl->defaults['version'], ( $rl->options['settings']['loading_place'] === 'footer' ) );
		wp_enqueue_script( 'responsive-lightbox-basicslider-gallery', plugins_url( 'js/front-basicslider.js', dirname( __FILE__ ) ), array( 'jquery', 'responsive-lightbox-basicslider-gallery-js' ), $rl->defaults['version'], ( $rl->options['settings']['loading_place'] === 'footer' ) );

		// styles
		wp_enqueue_style( 'responsive-lightbox-basicslider-gallery', plugins_url( 'assets/slippry/slippry' . ( ! ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '' ) . '.css', dirname( __FILE__ ) ), array(), $rl->defaults['version'] );

		wp_localize_script(
			'responsive-lightbox-basicslider-gallery',
			'rlArgsBasicSliderGallery' . ( $gallery_no + 1 ),
			json_encode(
				array(
					'adaptive_height'		=> $atts['adaptive_height'],
					'loop'					=> $atts['loop'],
					'captions'				=> $atts['captions'],
					'init_single'			=> $atts['init_single'],
					'responsive'			=> $atts['responsive'],
					'preload'				=> $atts['preload'],
					'pager'					=> $atts['pager'],
					'controls'				=> $atts['controls'],
					'hide_on_end'			=> $atts['hide_on_end'],
					'slide_margin'			=> $atts['slide_margin'],
					'transition'			=> $atts['transition'],
					'kenburns_zoom'			=> $atts['kenburns_zoom'],
					'speed'					=> $atts['speed'],
					'easing'				=> $atts['easing'],
					'continuous'			=> $atts['continuous'],
					'use_css'				=> $atts['use_css'],
					'slideshow'				=> $atts['slideshow'],
					'slideshow_direction'	=> $atts['slideshow_direction'],
					'slideshow_hover'		=> $atts['slideshow_hover'],
					'slideshow_hover_delay'	=> $atts['slideshow_hover_delay'],
					'slideshow_delay'		=> $atts['slideshow_delay'],
					'slideshow_pause'		=> $atts['slideshow_pause']
				)
			)
		);

		// remove any new lines from the output so that the reader parses it better
		return apply_filters( 'rl_gallery_shortcode_html', trim( preg_replace( '/\s+/', ' ', $gallery_html ) ), $atts, $rl_gallery_id );
	}

	/**
	 * Render Basic Masonry gallery shortcode.
	 *
	 * @global object $post Post object
	 * @param mixed $output HTML output
	 * @param array $shortcode_atts Shortcode attributes
	 * @return string HTML output
	 */
	public function basic_masonry_gallery_shortcode( $output, $shortcode_atts ) {
		if ( ! empty( $output ) )
			return $output;

		global $post;

		$defaults = array(
			'rl_gallery_id'	 => 0,
			'id'			 => isset( $post->ID ) ? (int) $post->ID : 0,
			'class'			 => '',
			'include'		 => '',
			'exclude'		 => '',
			'urls'			 => '',
			'type'			 => '',
			'order'			 => 'asc',
			'orderby'		 => 'menu_order',
			'size'			 => 'medium',
			'link'			 => 'file',
			'columns'		 => 3
		);

		// get main instance
		$rl = Responsive_Lightbox();

		// is there rl_gallery ID?
		$rl_gallery_id = $defaults['rl_gallery_id'] = ! empty( $shortcode_atts['rl_gallery_id'] ) ? (int) $shortcode_atts['rl_gallery_id'] : 0;

		// is it rl gallery?
		$rl_gallery = $rl->options['builder']['gallery_builder'] && $rl_gallery_id && get_post_type( $rl_gallery_id ) === 'rl_gallery';

		if ( ! array_key_exists( 'type', $shortcode_atts ) )
			$shortcode_atts['type'] = '';

		// break if it is not basic masonry gallery - first check
		if ( ! ( $shortcode_atts['type'] === 'basicmasonry' || ( $shortcode_atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicmasonry' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicmasonry' ) ) ) ) )
			return $output;

		// get shortcode gallery fields combined with defaults
		$fields = rl_get_gallery_fields( 'basicmasonry' );

		// get gallery fields attributes
		$field_atts = rl_get_gallery_fields_atts( $fields, $shortcode_atts, $rl_gallery );

		// is it rl gallery? add misc and lightbox fields
		if ( $rl_gallery )
			$fields += $rl->galleries->fields['lightbox']['options'] + $rl->galleries->fields['misc']['options'];

		// get only valid arguments
		$atts = shortcode_atts( array_merge( $defaults, $field_atts ), $shortcode_atts, 'gallery' );

		// sanitize gallery fields
		$atts = $this->sanitize_shortcode_args( $atts, $fields );

		// break if it is not basic masonry gallery
		if ( ! ( $atts['type'] === 'basicmasonry' || ( $atts['type'] === '' && ( ( $rl_gallery && $rl->options['settings']['builder_gallery'] === 'basicmasonry' ) || ( ! $rl_gallery && $rl->options['settings']['default_gallery'] === 'basicmasonry' ) ) ) ) )
			return $output;

		// ID
		$atts['id'] = (int) $atts['id'];

		// add custom classes if needed
		if ( $rl_gallery )
			$atts['class'] .= ' ' . $atts['gallery_custom_class'];

		// any classes?
		if ( $atts['class'] !== '' ) {
			$atts['class'] = trim( $atts['class'] );

			// more than 1 class?
			if ( strpos( $atts['class'], ' '  ) !== false ) {
				// get unique valid HTML classes
				$atts['class'] = array_unique( array_filter( array_map( 'sanitize_html_class', explode( ' ', $atts['class'] ) ) ) );

				if ( ! empty( $atts['class'] ) )
					$atts['class'] = implode( ' ', $atts['class'] );
				else
					$atts['class'] = '';
			// single class
			} else
				$atts['class'] = sanitize_html_class( $atts['class'] );
		}

		// orderby
		if ( empty( $atts['orderby'] ) ) {
			$atts['orderby'] = sanitize_sql_orderby( $atts['orderby'] );

			if ( empty( $atts['orderby'] ) )
				$atts['orderby'] = $defaults['orderby'];
		}

		// order
		if ( strtolower( $atts['order'] ) === 'rand' )
			$atts['orderby'] = 'rand';

		// check columns
		if ( $atts['columns_lg'] === 0 )
			$atts['columns_lg'] = $atts['columns'];

		if ( $atts['columns_md'] === 0 )
			$atts['columns_md'] = $atts['columns'];

		if ( $atts['columns_sm'] === 0 )
			$atts['columns_sm'] = $atts['columns'];

		if ( $atts['columns_xs'] === 0 )
			$atts['columns_xs'] = $atts['columns'];

		// gallery lightbox source size
		if ( ! empty( $atts['lightbox_image_size'] ) ) {
			if ( $atts['lightbox_image_size'] === 'global' )
				$atts['src_size'] = $rl->options['settings']['gallery_image_size'];
			elseif ( $atts['lightbox_image_size'] === 'lightbox_custom_size' && isset( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] ) )
				$atts['src_size'] = array( $atts['lightbox_custom_size_width'], $atts['lightbox_custom_size_height'] );
			else
				$atts['src_size'] = $atts['lightbox_image_size'];
		} else
			$atts['src_size'] = $rl->options['settings']['gallery_image_size'];

		// filter all shortcode arguments
		$atts = apply_filters( 'rl_gallery_shortcode_atts', $atts, $rl_gallery_id );

		// get gallery images
		$images = rl_get_gallery_shortcode_images( $atts );

		if ( empty( $images ) || is_feed() || defined( 'IS_HTML_EMAIL' ) )
			return $output;

		$gallery_no = $this->gallery_no;

		ob_start(); ?>

		<div class="rl-gallery-container<?php echo apply_filters( 'rl_gallery_container_class', '', $atts, $rl_gallery_id ); ?>" id="rl-gallery-container-<?php echo $gallery_no; ?>" data-gallery_id="<?php echo $rl_gallery_id; ?>">

			<?php do_action( 'rl_before_gallery', $atts, $rl_gallery_id ); ?>

			<div class="rl-gallery rl-basicmasonry-gallery <?php echo $atts['class']; ?>" id="rl-gallery-<?php echo $gallery_no; ?>" data-gallery_no="<?php echo $gallery_no; ?>">

			<?php
			$count = 0;

			if ( $count === 0 )
				echo '<div class="rl-gutter-sizer"></div><div class="rl-grid-sizer"></div>';

			foreach ( $images as $image ) {
				echo '
				<div class="rl-gallery-item' . ( $count === 0 ? ' rl-gallery-item-width-4' : '' ) . '" ' . implode( ' ', apply_filters( 'rl_gallery_item_extra_args', array(), $atts, $image ) ) . '>
					<div class="rl-gallery-item-content">
						' . $image['link'] . '
					</div>
				</div>';

				$count++;
			} ?>

			</div>

			<?php do_action( 'rl_after_gallery', $atts, $rl_gallery_id ); ?>

		</div>

		<?php $gallery_html = ob_get_contents();

		ob_clean();

		// scripts
		wp_enqueue_script( 'responsive-lightbox-basicmasonry-gallery', plugins_url( 'js/front-basicmasonry.js', dirname( __FILE__ ) ), array( 'jquery', 'responsive-lightbox-masonry', 'responsive-lightbox-images-loaded' ), $rl->defaults['version'], ( $rl->options['settings']['loading_place'] === 'footer' ) );

		// styles
		wp_enqueue_style( 'responsive-lightbox-basicmasonry-gallery', plugins_url( 'css/gallery-basicmasonry.css', dirname( __FILE__ ) ), array(), $rl->defaults['version'] );

		// add inline style
        wp_add_inline_style( 'responsive-lightbox-basicmasonry-gallery', '
			#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery {
				margin: ' . -( $atts['margin'] / 2 ) . 'px ' . -( $atts['gutter'] / 2 ) . 'px;
				padding: ' . $atts['margin'] . 'px 0;
			}
			#rl-gallery-container-' . $gallery_no . ' .rl-pagination-bottom {
				margin-top: ' . ( $atts['margin'] / 2 ) . 'px
			}
			#rl-gallery-container-' . $gallery_no . ' .rl-pagination-top {
				margin-bottom: ' . ( $atts['margin'] / 2 ) . 'px
			}
			#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-gallery-item,
			#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-grid-sizer {
				width: calc(' . ( 100 / $atts['columns'] ) . '% - ' . $atts['gutter'] . 'px);
				margin: ' . ( $atts['margin'] / 2 ) . 'px ' . ( $atts['gutter'] / 2 ) . 'px;
			}
			@media all and (min-width: 1200px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-gallery-item,
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-grid-sizer {
					width: calc(' . ( 100 / $atts['columns_lg'] ) . '% - ' . $atts['gutter'] . 'px);
					margin: ' . ( $atts['margin'] / 2 ) . 'px ' . ( $atts['gutter'] / 2 ) . 'px;
				}
			}
			@media all and (min-width: 992px) and (max-width: 1200px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-gallery-item,
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-grid-sizer {
					width: calc(' . ( 100 / $atts['columns_md'] ) . '% - ' . $atts['gutter'] . 'px);
					margin: ' . ( $atts['margin'] / 2 ) . 'px ' . ( $atts['gutter'] / 2 ) . 'px;
				}
			}
			@media all and (min-width: 768px) and (max-width: 992px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-gallery-item,
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-grid-sizer {
					width: calc(' . ( 100 / $atts['columns_sm'] ) . '% - ' . $atts['gutter'] . 'px);
					margin: ' . ( $atts['margin'] / 2 ) . 'px ' . ( $atts['gutter'] / 2 ) . 'px;
				}
			}
			@media all and (max-width: 768px) {
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-gallery-item,
				#rl-gallery-container-' . $gallery_no . ' .rl-basicmasonry-gallery .rl-grid-sizer {
					width: calc(' . ( 100 / $atts['columns_xs'] ) . '% - ' . $atts['gutter'] . 'px);
					margin: ' . ( $atts['margin'] / 2 ) . 'px ' . ( $atts['gutter'] / 2 ) . 'px;
				}
			}'
		);

		wp_localize_script(
			'responsive-lightbox-basicmasonry-gallery',
			'rlArgsBasicMasonryGallery' . ( $gallery_no + 1 ),
			json_encode(
				array(
					'originLeft'	=> $atts['origin_left'],
					'originTop'		=> $atts['origin_top']
				)
			)
		);

		// remove any new lines from the output so that the reader parses it better
		return apply_filters( 'rl_gallery_shortcode_html', trim( preg_replace( '/\s+/', ' ', $gallery_html ) ), $atts, $rl_gallery_id );
	}
}