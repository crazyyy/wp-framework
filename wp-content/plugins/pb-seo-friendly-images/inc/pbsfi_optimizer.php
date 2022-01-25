<?php
/* Security-Check */
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class pbsfi_optimizer
{
	protected $settings = array();
	protected $defaults = array();

	/** @var DOMDocument  */
	protected $document;

	public function __construct( $settings=array() )
	{
		// check WP charset or set default to utf-8
		$charset = ( (defined('DB_CHARSET') ) ? DB_CHARSET : 'utf-8' );

		// default settings
		$this->defaults = array(
			'encoding' => $charset,
			'encoding_mode' => 'off',
			'create_domdocument' => true
		);

		// merge defaults and custom settings
		$this->settings = array_merge(
			$this->defaults,
			$settings
		);

		// settings filter
		$this->settings = apply_filters('pbsfi_optimizer_settings', $this->settings);

		if( class_exists('DOMDocument') && false !== $this->settings['create_domdocument'] ) {

			$this->document = new DOMDocument( '1.0', $this->settings['encoding'] );

			$this->document = apply_filters(
				'pbsfi_optimizer_domdocument', // filter name
				$this->document, // create DOMDocument
				$this->settings // settings
			);
		}
	}

	/**
	 * Check if content could be optimized
	 *
	 * @param array $data data for the optimization check
	 *
	 * @return bool
	 */
	public function is_optimization_allowed( $data=array() )
	{
		if(
			! class_exists('DOMDocument') || // do not run optimization, DOMDocument not available
			get_post_type() == 'tribe_events' || // exclude for Events Calendar
			is_feed() || // exclude for feeds
			strstr( strtolower($data['content']), 'arforms') || // exclude for ARForms
			strstr( strtolower($data['content']), 'arf_form') || // exclude for ARForms
			strstr( strtolower($data['content']), 'spb_gallery') || // exclude for spb_gallery_widget
			isset($_GET['dslc']) // exclude for LiveComposer
		) {
			return apply_filters( 'is_optimization_allowed', false, $data );
		}

		return apply_filters( 'is_optimization_allowed', true, $data );
	}

	/**
	 * get array key
	 *
	 * @param $key
	 * @param $array
	 * @return bool
	 */
	public function get_array_key($key, $array)
	{
		if( array_key_exists($key, $array) ) {
			return $array[$key];
		} else {
			return false;
		}
	}

	/**
	 * get image id by url
	 *
	 * @param $url
	 *
	 * @return bool|int
	 */
	public function get_image_id($url)
	{
		global $wpdb;

		$transient_name = sanitize_title( $url );
		$transient = get_transient( $transient_name );

		// return numeric transient
		if( false !== $transient && is_numeric($transient) ) {
			return (int) $transient;
		}

		// transient with false string (details below)
		if( false !== $transient && 'false' === $transient ) {
			return false;
		}

		$sql = $wpdb->prepare(
			'SELECT `ID` FROM `'.$wpdb->posts.'` WHERE `guid` = \'%s\';',
			esc_sql($url)
		);

		$attachment = $wpdb->get_col($sql);

		if( is_numeric( $this->get_array_key(0, $attachment) ) ) {

			// set transient
			set_transient( $transient_name, $attachment[0], YEAR_IN_SECONDS );

			return (int) $attachment[0];
		}

		// set transient => false as string because transients can't deal with boolean values
		set_transient( $transient_name, 'false', YEAR_IN_SECONDS );

		return false;
	}

	public function convert_replacements( $content, $data=array() )
	{

		$post = get_post();
		$imageID = ( (isset($data['image_id'])) ? $data['image_id'] : '' );
		$src = ( (isset($data['src'])) ? $data['src'] : '');

		$cats = '';
		if ( strrpos( $content, '%category' ) !== false ) {

			if( get_post_type($post) == 'product' ) {
				$categories = get_the_terms( $post->ID, 'product_cat' );
				if ( ! $categories || is_wp_error( $categories ) ) {
					$categories = array();
				}

				$categories = array_values( $categories );

				foreach ( array_keys( $categories ) as $key ) {
					_make_cat_compat( $categories[$key] );
				}
			} else {
				$categories = get_the_category();
			}

			if ( $categories ) {
				$i = 0;
				foreach ( $categories as $cat ) {
					if ( $i == 0 ) {
						$cats = $cat->slug . $cats;
					} else {
						$cats = $cat->slug . ', ' . $cats;
					}
					++$i;
				}
			}
		}

		$tags = '';
		if ( strrpos( $content, '%tags' ) !== false ) {
			$posttags = get_the_tags();

			if ( $posttags ) {
				$i = 0;
				foreach ( $posttags as $tag ) {
					if ( $i == 0 ) {
						$tags = $tag->name . $tags;
					} else {
						$tags = $tag->name . ', ' . $tags;
					}
					++$i;
				}
			}
		}

		if( $src ) {
			$info = @pathinfo($src);
			$src = @basename($src,'.'.$info['extension']);

			$src = str_replace('-', ' ', $src);
			$src = str_replace('_', ' ', $src);
		} else {
			$src = '';
		}

		if( is_numeric($imageID) ) {
			$attachment = wp_prepare_attachment_for_js($imageID);

			if( is_array($attachment) ) {
				$content = str_replace('%media_title', $attachment['title'], $content );
				$content = str_replace('%media_alt', $attachment['alt'], $content );
				$content = str_replace('%media_caption', $attachment['caption'], $content );
				$content = str_replace('%media_description', $attachment['description'], $content );
			}
		}

		$content = str_replace('%media_title', $post->post_title, $content );
		$content = str_replace('%media_alt', $post->post_title, $content );
		$content = str_replace('%media_caption', $post->post_title, $content );
		$content = str_replace('%media_description', $post->post_title, $content );

		$content = str_replace('%name', $src, $content );
		$content = str_replace('%title', $post->post_title, $content );
		$content = str_replace('%category', $cats, $content );
		$content = str_replace('%tags', $tags, $content );
		$content = str_replace('%desc', $post->post_excerpt, $content);

		return $content;
	}

	public function optimize_html( $content, $force_optimization = false )
	{
		$is_optimization_allowed = $this->is_optimization_allowed([
			'post_id'       => get_the_ID(),
			'post_type'     => get_post_type(),
			'content'       => $content
		]);

		// filter for $is_optimization_allowed
		$is_optimization_allowed = apply_filters( 'optimize_html__is_optimization_allowed', $is_optimization_allowed );

		// Check if content could be optimized and if optimization is allowed
		if( false === $is_optimization_allowed && true !== $force_optimization ) {
			return $content;
		}

		// Do not optimize empty content
        $content_trim = trim($content);
		if( empty($content_trim) ) {
		    return $content;
        }

		// check again if DOMDocument is really available in case of force_optimization setting
		if( ! is_a($this->document, 'DOMDocument') ) {
			return $content;
		}

        $encoding_declaration = sprintf('<?xml encoding="%s" ?>', $this->settings['encoding']);

		// Optimize encoding
		if( function_exists('mb_convert_encoding') && $this->settings['encoding_mode'] != 'off' ) {
			//$content = @mb_convert_encoding( $content, 'utf-8', $this->settings['encoding'] );
			$content = @mb_convert_encoding( $content, 'HTML-ENTITIES', $this->settings['encoding'] );
		} else {
            $content = $encoding_declaration.$content;
        }

        @$this->document->loadHTML( $content ); // LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD


		if( ! $this->document ) return $content;

		/*
		 * Use WooCommerce settings if is pro and WC page
		 */
        if( function_exists('is_woocommerce') && is_woocommerce() && $this->settings['proVersion'] ) {
            if( isset($this->settings['wc_sync_method']) ) {
                $this->settings['sync_method']          = $this->settings['wc_sync_method'];
            }

            if( isset($this->settings['wc_title_scheme']) ) {
                $this->settings['title_scheme'] = $this->settings['wc_title_scheme'];
            }

            if( isset($this->settings['wc_alt_scheme']) ) {
                $this->settings['alt_scheme'] = $this->settings['wc_alt_scheme'];
            }

            if( isset($this->settings['wc_override_title']) ) {
                $this->settings['override_title'] = $this->settings['wc_override_title'];
            }

            if( isset($this->settings['wc_override_alt']) ) {
                $this->settings['override_alt'] = $this->settings['wc_override_alt'];
            }
        }

		/*
		 * Optimize Figure
		 *
         * Recommendation by BasTaller
         * @url https://wordpress.org/support/topic/proposal-for-best-replacement/
         */
		$figTags = $this->document->getElementsByTagName('figure');

		if( $figTags->length ) {
			foreach ($figTags as $tag){
				$caption = $tag->nodeValue;
				$imgTags = $tag->getElementsByTagName('img');

				if( empty($caption) )
					continue;

				foreach ($imgTags as $tag) {
					$tag->setAttribute('title', $caption);
				}
			}
		}

		// check for image tags
		$imgTags = $this->document->getElementsByTagName('img');

		// return $content if there are no image tags in $content
		if( $imgTags->length ) {

            // check all image tags
            foreach ($imgTags as $tag) {
                $data_src = trim($tag->getAttribute('data-src'));
                $src = trim($tag->getAttribute('src'));

                if( !empty($data_src) ) {
                    $src = $data_src;
                }

                $imageID = $this->get_image_id($src);

                /**
                 * Override Area
                 */
                if( isset($this->settings['override_alt']) ) {
                    $alt = trim($this->convert_replacements(
                        $this->settings['alt_scheme'],
                        array(
                            'src' => $src,
                            'image_id' => $imageID
                        )
                    ));

                    $alt = apply_filters('pbsfi-alt', $alt);

                    $tag->setAttribute('alt', $alt);
                } else {
                    $alt = trim($tag->getAttribute('alt'));
                    $alt = apply_filters('pbsfi-alt', $alt);
                }

                if( isset($this->settings['override_title']) ) {

                    $title = trim($this->convert_replacements(
                        $this->settings['title_scheme'],
                        array(
                            'src' => $src,
                            'image_id' => $imageID
                        )
                    ));

                    $title = apply_filters('pbsfi-title', $title);

                    $tag->setAttribute('title', $title);
                } else {
                    $title = trim($tag->getAttribute('title'));
                    $title = apply_filters('pbsfi-title', $title);
                }

                /**
                 * Check attributes
                 */
                if( !empty($alt) && empty($title) && ($this->settings['sync_method'] == 'both' || $this->settings['sync_method'] == 'alt' ) ) {

                    $alt = apply_filters('pbsfi-title', $alt);
                    $tag->setAttribute('title', $alt);
                    $title = $alt;

                } else if( empty($alt) && !empty($title)  && ($this->settings['sync_method'] == 'both' || $this->settings['sync_method'] == 'title' ) ) {

                    $title = apply_filters('pbsfi-alt', $title);
                    $tag->setAttribute('alt', $title);
                    $alt = $title;

                }

                /**
                 * set if empty after sync
                 */
                if( empty($alt) ) {
                    $alt = trim($this->convert_replacements(
                        $this->settings['alt_scheme'],
                        array(
                            'src' => $src,
                            'image_id' => $imageID
                        )
                    ));

                    $alt = apply_filters('pbsfi-alt', $alt);
                    $tag->setAttribute('alt', $alt);
                }

                if( empty($title) ) {
                    $title = trim($this->convert_replacements(
                        $this->settings['title_scheme'],
                        array(
                            'src' => $src,
                            'image_id' => $imageID
                        )
                    ));

                    $title = apply_filters('pbsfi-title', $title);
                    $tag->setAttribute('title', $title);
                }
            }

        }

        $aTags = $this->document->getElementsByTagName('a');
		
        if( $this->settings['proVersion'] && isset($this->settings['link_title']) && $this->settings['link_title'] && $aTags->length ) {

            foreach ($aTags as $tag) {
                $title = trim( $tag->getAttribute('title') );

                if( empty($title) ) {

                    $newTitle = '';

                    if( ! empty( $tag->textContent ) ) {

                        $newTitle = $tag->textContent;

                    } elseif( $tag->hasChildNodes() ) {
                        $childNodes = $tag->childNodes;

                        if( ! $childNodes->length || $childNodes->length == 0 )
                            continue;

                        foreach( $childNodes as $subChildNodes ) {
                            if( ! empty( $subChildNodes->textContent ) ) {

                                $newTitle = $subChildNodes->textContent;
                                break;

                            } elseif( $subChildNodes->tagName == 'img' ) {
                                $title = trim( $subChildNodes->getAttribute('title') );

                                if( !empty($title) ) {
                                    $newTitle = $title;
                                    break;
                                }
                            }
                        }
                    }

                    $tag->setAttribute('title', $newTitle);
                }
            }

        }

		$return = $this->document->saveHTML();
		$return = str_replace($encoding_declaration, '', $return);
		$return = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $return));

		return $return;
	}

	/**
	 * Add image title and alt to post thumbnails
	 *
	 * @param array $attr
	 * @param WP_Post $attachment
	 * @return array
	 */
	public function optimize_image_attributes( $attr, $attachment = null )
	{
        if( function_exists('is_woocommerce') && is_woocommerce() && $this->settings['proVersion'] ) {
            $title_scheme   = (isset($this->settings['wc_title_scheme']) ? $this->settings['wc_title_scheme'] : '');
            $alt_scheme     = (isset($this->settings['wc_title_scheme']) ? $this->settings['wc_alt_scheme'] : '');
            $sync_method    = (isset($this->settings['wc_title_scheme']) ? $this->settings['wc_sync_method'] : '');
        } else {
            $title_scheme   = (isset($this->settings['wc_title_scheme']) ? $this->settings['title_scheme'] : '');
            $alt_scheme     = (isset($this->settings['wc_title_scheme']) ? $this->settings['alt_scheme'] : '');
            $sync_method    = (isset($this->settings['wc_title_scheme']) ? $this->settings['sync_method'] : '');
        }

		if( empty($attr['alt']) ) {

			$attr['title'] = trim($this->convert_replacements(
                $title_scheme,
				array(
					'src' => $attr['src']
				)
			));

			$attr['alt'] = trim($this->convert_replacements(
                $alt_scheme,
				array(
					'src' => $attr['src']
				)
			));

		} else {

			if( $sync_method == 'both' || $sync_method == 'alt' ) {
				$attr['title'] = trim( strip_tags($attachment->post_title) );
			} else {
				$attr['title'] = trim($this->convert_replacements(
                    $title_scheme,
					array(
						'src' => $attr['src']
					)
				));
			}

		}

        if( function_exists('is_woocommerce') && is_woocommerce() && isset($this->settings['wc_title']) && $this->settings['wc_title'] && $this->settings['proVersion'] ) {
            $attr['alt']    = get_the_title();
            $attr['title']  = get_the_title();
        }

		$attr['alt']    = apply_filters('pbsfi-alt', $attr['alt']);
		$attr['title']  = apply_filters('pbsfi-title', $attr['title']);

		return $attr;
	}
}