<?php
/**
 * This class configures the google performance settings
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_ConfigGooglePerformance extends Wbcr_FactoryClearfy206_Configurate {

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

	public function registerActionsAndFilters() {
		if ( $this->getPopulateOption( 'disable_google_fonts' ) ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'disableAllGoogleFonts' ], 999 );
		}

		if ( ! is_admin() ) {
			$load_google_fonts = $this->getPopulateOption( 'lazy_load_google_fonts' );
			$load_font_awesome = $this->getPopulateOption( 'lazy_load_font_awesome' );

			if ( $load_google_fonts || $load_font_awesome ) {
				add_action( 'wp_print_styles', [ $this, 'enqueueScripts' ], - 1 );
			}

			if ( $this->getPopulateOption( 'disable_google_maps' ) ) {
				add_action( "wp_loaded", [ $this, 'disableGoogleMapsObStart' ] );
			}
		}
	}

	/** ======================================================================== */
	//                        Disable google maps
	/** ======================================================================== */

	public function disableGoogleMapsObStart() {
		ob_start( [ $this, 'disableGoogleMapsObEnd' ] );
	}

	/**
	 * @param string $html
	 *
	 * @return mixed
	 */
	public function disableGoogleMapsObEnd( $html ) {
		global $post;

		$exclude_ids                      = [];
		$exclude_from_disable_google_maps = $this->getPopulateOption( 'exclude_from_disable_google_maps' );

		if ( '' !== $exclude_from_disable_google_maps ) {
			$exclude_ids = array_map( 'intval', explode( ',', $exclude_from_disable_google_maps ) );
		}
		if ( $post && ! in_array( $post->ID, $exclude_ids, true ) ) {
			$html = preg_replace( '/<script[^<>]*\/\/maps.(googleapis|google|gstatic).com\/[^<>]*><\/script>/i', '', $html );

			if ( $this->getPopulateOption( 'remove_iframe_google_maps' ) ) {
				$html = preg_replace( '/<iframe[^<>]*\/\/(www\.)?google\.com(\.\w*)?\/maps\/[^<>]*><\/iframe>/i', '', $html );
			}
		}

		return $html;
	}

	/** ======================================================================== */
	//                         End disable google maps
	/** ======================================================================== */

	public function disableAllGoogleFonts() {
		global $wp_styles;

		//	multiple patterns hook
		$regex = '/fonts\.googleapis\.com\/css\?family/i';

		if ( ! empty( $wp_styles->registered ) && is_array( $wp_styles->registered ) ) {
			foreach ( $wp_styles->registered as $registered ) {
				if ( preg_match( $regex, $registered->src ) ) {
					wp_dequeue_style( $registered->handle );
				}
			}
		}
	}

	/** ======================================================================== */
	//                         Lazy load fonts
	/** ======================================================================== */

	public function enqueueScripts() {
		$async_links = $this->checkGooglefontsFontawesomeStyles();

		if ( ! empty( $async_links ) ) {
			wp_enqueue_script( $this->plugin->getPluginName() . '-css-lazy-load', WCL_PLUGIN_URL . '/assets/js/css-lazy-load.min.js', [ 'jquery' ], $this->plugin->getPluginVersion() );
			wp_localize_script( $this->plugin->getPluginName() . '-css-lazy-load', 'wbcr_clearfy_async_links', $async_links );
		}
	}

	private function checkGooglefontsFontawesomeStyles() {
		global $wp_styles;

		$ret = [];

		if ( isset( $wp_styles ) && ! empty( $wp_styles ) ) {

			$load_google_fonts = $this->getPopulateOption( 'lazy_load_google_fonts', false );
			$load_font_awesome = $this->getPopulateOption( 'lazy_load_font_awesome', false );

			if ( $load_google_fonts || $load_font_awesome ) {

				$gfonts_base_url = 'fonts.googleapis.com/css';
				$gfonts_links    = [];

				$font_awesome_slug     = 'font-awesome';
				$font_awesome_slug_alt = 'fontawesome';
				$font_awesome_links    = [
					'external' => [],
					'internal' => [],
				];

				foreach ( $wp_styles->queue as $handle ) {
					if ( ! isset( $wp_styles->registered[ $handle ] ) ) {
						continue;
					}

					$style     = $wp_styles->registered[ $handle ];
					$style_src = isset( $style ) ? $style->src : null;
					$style_ver = isset( $style ) ? $style->ver : false;

					if ( $load_google_fonts && false !== strpos( $style_src, $gfonts_base_url ) ) {
						$gfonts_links[] = urldecode( str_replace( [ '&amp;' ], [ '&' ], $style_src ) );

						wp_dequeue_style( $handle );
					} else if ( $load_font_awesome && ( false !== strpos( $style_src, $font_awesome_slug ) || false !== strpos( $style_src, $font_awesome_slug_alt ) ) ) {

						wp_dequeue_style( $handle );

						$font_awesome_links[ false !== strpos( $style_src, site_url() ) ? 'internal' : 'external' ][] = [
							'ver'  => $style_ver,
							'link' => $style_src,
						];
					}
				}

				if ( $load_font_awesome && ( ! empty( $font_awesome_links['internal'] ) || ! empty( $font_awesome_links['external'] ) ) ) {

					// @note: Prioritize external links.
					$fa_links = ! empty( $font_awesome_links['external'] ) ? $font_awesome_links['external'] : $font_awesome_links['internal'];

					$selected_fa_link = $fa_links[0];

					$links_count = count( $fa_links );
					if ( 1 < $links_count ) {
						for ( $i = 1; $i < $links_count; $i ++ ) {
							if ( false !== $fa_links[ $i ]['ver'] && ( false === $selected_fa_link['ver'] || version_compare( $selected_fa_link['ver'], $fa_links[ $i ]['ver'], '<' ) ) ) {
								$selected_fa_link = $fa_links[ $i ];
							}
						}
					}

					$ret[ $this->plugin->getPluginName() . '-font-awesome' ] = esc_url( $selected_fa_link['link'] );

					$this->updateSavedFontAwesomeRequests( count( $font_awesome_links['internal'] ) + count( $font_awesome_links['external'] ) );
				} else {
					$this->updateSavedFontAwesomeRequests( 0 );
				}

				if ( $load_google_fonts && ! empty( $gfonts_links ) ) {

					$ret[ $this->plugin->getPluginName() . '-google-fonts' ] = esc_url( $this->combineGoogleFontsLinks( $gfonts_links ) );

					$this->updateSavedGoogleFontsRequest( count( $gfonts_links ) );
				} else {
					$this->updateSavedGoogleFontsRequest( 0 );
				}
			} else {
				$this->updateSavedFontAwesomeRequests( 0 );
				$this->updateSavedGoogleFontsRequest( 0 );
			}
		}

		return $ret;
	}

	private function updateSavedGoogleFontsRequest( $count ) {
		$count = ! isset( $count ) ? 0 : (int) $count;

		$old_val = $this->getPopulateOption( 'combined_font_awesome_requests_number' );

		if ( false === $old_val || ( false !== $old_val && $count > (int) $old_val ) ) {
			$this->updatePopulateOption( 'combined_font_awesome_requests_number', $count );
		}
	}

	private function updateSavedFontAwesomeRequests( $count ) {
		$count = ! isset( $count ) ? 0 : (int) $count;

		$old_val = $this->getPopulateOption( 'combined_google_fonts_requests_number' );

		if ( false === $old_val || ( false !== $old_val && $count > (int) $old_val ) ) {
			$this->updatePopulateOption( 'combined_google_fonts_requests_number', $count );
		}
	}

	public static function saved_external_requests() {
		$google_fonts = (int) WCL_Plugin::app()->getPopulateOption( 'combined_google_fonts_requests_number' );
		$font_awesome = (int) WCL_Plugin::app()->getPopulateOption( 'combined_font_awesome_requests_number' );

		$google_fonts_saved = 1 < $google_fonts ? $google_fonts - 1 : 0;
		$font_awesome_saved = 1 < $font_awesome ? $font_awesome - 1 : 0;

		return $google_fonts_saved + $font_awesome_saved;
	}

	/**
	 * Combine multiple Google Fonts links into one.
	 *
	 * @param array $links   An array of the different Google Fonts links. Default array().
	 *
	 * @return string|array The compined Google Fonts link.
	 */
	private function combineGoogleFontsLinks( $links = [] ) {

		if ( ! is_array( $links ) ) {
			return $links;
		}

		$links = array_unique( $links );

		if ( 1 === count( $links ) ) {
			return $links[0];
		}

		$protocol   = 'https';
		$base_url   = '//fonts.googleapis.com/css';
		$family_arg = 'family';
		$subset_arg = 'subset';

		$base_url_len   = strlen( $base_url );
		$family_arg_len = strlen( $family_arg );

		$fonts = [];
		$cnt   = 0;

		$clean_links = [];
		foreach ( $links as $k => $v ) {

			$base_url_pos = strrpos( $v, $base_url );

			$args_str = trim( substr( $v, ( $base_url_len + $base_url_pos ), strlen( $v ) ) );

			if ( substr( $args_str, 0, $family_arg_len + 2 ) === '?' . $family_arg . '=' ) {
				$args_str = substr( $args_str, $family_arg_len + 2, strlen( $args_str ) );
			}

			$tmp       = explode( '|', $args_str );
			$tmp_count = count( $tmp );
			for ( $i = 0; $i < $tmp_count; $i ++ ) {
				$clean_links[] = $tmp[ $i ];
			}
		}

		foreach ( $clean_links as $k => $v ) {

			$expl = explode( '&' . $subset_arg, $v );

			if ( isset( $expl[0] ) && ! empty( $expl[0] ) ) {

				$tmp = explode( ':', $expl[0] );

				if ( isset( $tmp[0] ) && ! empty( $tmp[0] ) ) {

					// Has font family name.
					$font_name = str_replace( ' ', '+', $tmp[0] );

					if ( ! isset( $fonts[ $font_name ] ) ) {
						$fonts[ $font_name ] = [
							'sizes'   => [],
							'subsets' => [],
						];
					}

					if ( isset( $tmp[1] ) && ! empty( $tmp[1] ) ) {

						// Has font sizes.
						$x  = explode( ',', $tmp[1] );
						$xc = count( $x );

						foreach ( $x as $xk => $xv ) {
							if ( ! in_array( $xv, $fonts[ $font_name ]['sizes'], true ) && ( 400 !== (int) $xv || $xc > 1 ) ) {
								$fonts[ $font_name ]['sizes'][] = $xv;
							}
						}
					}

					if ( isset( $expl[1] ) && ! empty( $expl[1] ) ) {

						// Has subsets.
						$y  = explode( ',', $expl[1] );
						$yc = count( $y );

						foreach ( $y as $yk => $yv ) {

							if ( '=' === substr( $yv, 0, 1 ) ) {
								$yv = substr( $yv, 1, strlen( $yv ) );
							}

							if ( ! in_array( $yv, $fonts[ $font_name ]['subsets'], true ) && ( 'latin' !== $yv || $yc > 1 ) ) {
								$fonts[ $font_name ]['subsets'][] = $yv;
							}
						}
					}
				}// End if().
			}// End if().
		}// End foreach().

		$ret = '';

		if ( ! empty( $fonts ) ) {

			$ret     .= $protocol . ':' . $base_url;
			$i       = 0;
			$subsets = [];

			foreach ( $fonts as $key => $val ) {

				if ( 0 === $i ) {
					$ret .= '?' . $family_arg . '=';
				} else {
					$ret .= '|';
				}

				$ret .= $key;

				if ( ! empty( $val['sizes'] ) ) {
					$ret .= ':' . implode( ',', $val['sizes'] );
				}

				if ( ! empty( $val['subsets'] ) ) {
					$subsets = array_merge( $subsets, $val['subsets'] );
				}

				$i ++;
			}

			if ( ! empty( $subsets ) ) {
				$ret .= '&' . $subset_arg . '=' . implode( ',', $subsets );
			}
		}

		return $ret;
	}

	/** ======================================================================== */
	//                         End Lazy load fonts
	/** ======================================================================== */
}
