<?php

/**
 * This class configures the parameters seo
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2017 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_ConfigSeo extends Wbcr_FactoryClearfy206_Configurate {

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

	public function registerActionsAndFilters() {
		if ( ! is_admin() ) {
			if ( $this->getPopulateOption( 'content_image_auto_alt' ) ) {
				add_filter( 'the_content', [ $this, 'contentImageAutoAlt' ], 9999 );
				add_filter( 'wp_get_attachment_image_attributes', [
					$this,
					'changeAttachementImageAttributes'
				], 20, 2 );
			}

			if ( $this->getPopulateOption( 'right_robots_txt' ) ) {
				add_filter( 'robots_txt', [ $this, 'rightRobotsTxt' ], 9999 );
			}

			if ( $this->getPopulateOption( 'remove_last_item_breadcrumb_yoast' ) ) {
				add_filter( 'wpseo_breadcrumb_single_link', [ $this, 'removeLastItemBreadcrumbYoast' ] );
			}

			if ( $this->getPopulateOption( 'attachment_pages_redirect' ) ) {
				add_action( 'template_redirect', [ $this, 'attachmentPagesRedirect' ] );
			}

			if ( $this->getPopulateOption( 'remove_single_pagination_duplicate' ) ) {
				add_action( 'template_redirect', [ $this, 'removeSinglePaginationDuplicate' ] );
			}

			if ( $this->getPopulateOption( 'remove_replytocom' ) ) {
				add_action( 'template_redirect', [ $this, 'removeReplytocomRedirect' ], 1 );
				add_filter( 'comment_reply_link', [ $this, 'removeReplytocomLink' ] );
			}

			add_action( 'wp', [ $this, 'redirectArchives' ] );
		}

		if ( $this->getPopulateOption( 'set_last_modified_headers' ) ) {
			if ( ! is_admin() ) {
				add_action( 'template_redirect', [ $this, 'setLastModifiedHeaders' ] );
			}
			add_action( 'wp_logout', [ $this, 'lastModifedFlushCookie' ] );
		}

		if ( $this->plugin->isActivateComponent( 'yoast_seo' ) && defined( 'WPSEO_VERSION' ) ) {
			if ( ! is_admin() ) {
				if ( $this->getPopulateOption( 'yoast_remove_json_ld_search' ) ) {
					add_filter( 'disable_wpseo_json_ld_search', '__return_true' );
				}

				if ( $this->getPopulateOption( 'yoast_remove_json_ld_output' ) ) {
					add_filter( 'wpseo_json_ld_output', [ $this, 'removeYoastJson' ], 10, 1 );
				}
				if ( $this->getPopulateOption( 'yoast_remove_head_comment' ) ) {
					add_action( 'init', [ $this, 'yoastRemoveHeadComment' ] );
				}
				/*if( $this->getPopulateOption('yoast_canonical_pagination') ) {
					add_filter('wpseo_canonical', array($this, 'yoastCanonicalPagination'));
				}*/
			}
			if ( $this->getPopulateOption( 'yoast_remove_image_from_xml_sitemap' ) ) {
				$this->yoastRemoveImageFromXmlSitemap();
			}
		}
	}

	/**
	 * @param $data
	 *
	 * @return array
	 */
	public function removeYoastJson( $data ) {
		$data = [];

		return $data;
	}

	/**
	 * Add post title in image alt attribute
	 *
	 * @param $content
	 *
	 * @return mixed
	 */

	public function contentImageAutoAlt( $content ) {
		global $post;

		if ( empty( $post ) ) {
			return $content;
		}

		$old_content = $content;

		preg_match_all( '/<img[^>]+>/', $content, $images );

		if ( ! is_null( $images ) ) {
			foreach ( $images[0] as $index => $value ) {
				if ( ! preg_match( '/alt=/', $value ) ) {
					$new_img = str_replace( '<img', '<img alt="' . esc_attr( $post->post_title ) . '"', $images[0][ $index ] );
					$content = str_replace( $images[0][ $index ], $new_img, $content );
				} else if ( preg_match( '/alt=[\s"\']{2,3}/', $value ) ) {
					$new_img = preg_replace( '/alt=[\s"\']{2,3}/', 'alt="' . esc_attr( $post->post_title ) . '"', $images[0][ $index ] );
					$content = str_replace( $images[0][ $index ], $new_img, $content );
				}
			}
		}

		if ( empty( $content ) ) {
			return $old_content;
		}

		return $content;
	}

	/**
	 * Setting attributes for post thumnails
	 *
	 * @param $attr
	 * @param $attachment
	 *
	 * @return mixed
	 */
	public function changeAttachementImageAttributes( $attr, $attachment ) {
		// Get post parent
		$parent = get_post_field( 'post_parent', $attachment );

		// Get post type to check if it's product
		//$type = get_post_field('post_type', $parent);

		/*if( $type != 'product' ) {
			return $attr;
		}*/

		/// Get title
		$title = get_post_field( 'post_title', $parent );
		if ( '' === $attr['alt'] ) {
			$attr['alt'] = $title;
		}
		$attr['title'] = $title;

		return $attr;
	}

	/**
	 * Add directories to virtual robots.txt file
	 *
	 * @param string $output
	 *
	 * @return mixed|string|void
	 */
	public function rightRobotsTxt( $output ) {
		if ( $this->getPopulateOption( 'robots_txt_text' ) ) {
			return $this->getPopulateOption( 'robots_txt_text' );
		}

		return WCL_Helper::getRightRobotTxt();
	}

	/**
	 * Attachment pages redirect
	 */
	public function attachmentPagesRedirect() {
		global $post;

		if ( is_attachment() ) {
			if ( isset( $post->post_parent ) && ( $post->post_parent != 0 ) ) {
				wp_redirect( get_permalink( $post->post_parent ), 301 );
			} else {
				wp_redirect( home_url(), 301 );
			}
			exit;
		}
	}

	/**
	 * Remove single pagination duplicate
	 */

	public function removeSinglePaginationDuplicate() {
		global $post, $page;

		if ( is_singular() && ! is_front_page() ) {

			// #CLRF-125 issue fix bug for buddy press
			if ( function_exists( 'bp_is_my_profile' ) ) {
				if ( bp_is_my_profile() ) {
					return;
				}
			}

			// if woocommerce just return
			if ( class_exists( 'woocommerce' ) && function_exists( 'is_cart' ) && function_exists( 'is_checkout' ) && function_exists( 'is_woocommerce' ) && function_exists( 'is_account_page' ) && ( is_cart() || is_checkout() || is_woocommerce() || is_account_page() ) ) {
				return;
			}

			$num_pages = substr_count( $post->post_content, '<!--nextpage-->' ) + 1;

			if ( $page > $num_pages ) {
				wp_safe_redirect( get_permalink( $post->ID ), 301 );
				exit();
			}
		}
	}


	/**
	 * Remove last item from breadcrumbs SEO by YOAST
	 * http://www.wpdiv.com/remove-post-title-yoast-seo-plugin-breadcrumb/
	 *
	 * @param $link_output
	 *
	 * @return string
	 */
	public function removeLastItemBreadcrumbYoast( $link_output ) {

		if ( strpos( $link_output, 'breadcrumb_last' ) !== false ) {
			$link_output = '';
		}

		return $link_output;
	}

	/**
	 * Remove yoast comment
	 */
	public function yoastRemoveHeadComment() {
		add_action( 'get_header', [ $this, 'yoastRemoveHeadCommentStart' ] );
		add_action( 'wp_head', [ $this, 'yoastRemoveHeadCommentEnd' ], 999 );
	}

	public function yoastRemoveHeadCommentStart() {
		ob_start( [ $this, 'yoastRemoveHeadCommentRemove' ] );
	}

	public function yoastRemoveHeadCommentEnd() {
		ob_end_flush();
	}

	public function yoastRemoveHeadCommentRemove( $html ) {
		return preg_replace( '/^<!--.*?[Yy]oast.*?-->$/mi', '', $html );
	}


	/**
	 * Remove <image:image> from sitemap
	 */
	public function yoastRemoveImageFromXmlSitemap() {
		add_filter( 'wpseo_xml_sitemap_img', '__return_false' );
		add_filter( 'wpseo_sitemap_url', [ $this, 'yoastRemoveImageFromXmlClean' ], 10, 2 );
	}

	public function yoastRemoveImageFromXmlClean( $output, $url ) {
		$output = preg_replace( '/<image:image[^>]*?>.*?<\/image:image>/si', '', $output );

		return $output;
	}

	/**
	 * Canonical link in pagination Yoast
	 *
	 * @param $canonical
	 *
	 * @return string
	 */
	/*public function yoastCanonicalPagination( $canonical ) {
		if ( is_category() && is_paged() ) {
			$cat = get_category( get_query_var( 'cat' ) );
			$cat_id = $cat->cat_ID;
			return get_category_link( $cat_id );
		}
		if ( is_home() && is_paged() ) {
			return home_url('/');
		}
		return $canonical;
	}*/

	/**
	 * Redirect archives author, date, tags
	 */

	public function redirectArchives() {
		if ( $this->getPopulateOption( 'redirect_archives_author' ) ) {
			if ( is_author() ) {
				wp_redirect( home_url(), 301 );

				die();
			}
		}

		if ( $this->getPopulateOption( 'redirect_archives_date' ) ) {
			if ( is_date() ) {
				wp_redirect( home_url(), 301 );

				die();
			}
		}

		if ( $this->getPopulateOption( 'redirect_archives_tag' ) ) {
			if ( is_tag() ) {
				wp_redirect( home_url(), 301 );

				die();
			}
		}
	}

	/**
	 * Remove replytocom
	 */
	public function removeReplytocomRedirect() {
		global $post;

		if ( ! empty( $post ) && isset( $_GET['replytocom'] ) && is_singular() ) {
			$post_url     = get_permalink( $post->ID );
			$comment_id   = sanitize_text_field( $_GET['replytocom'] );
			$query_string = remove_query_arg( 'replytocom', sanitize_text_field( $_SERVER['QUERY_STRING'] ) );

			if ( ! empty( $query_string ) ) {
				$post_url .= '?' . $query_string;
			}
			$post_url .= '#comment-' . $comment_id;

			wp_safe_redirect( $post_url, 301 );
			die();
		}

		return false;
	}

	public function removeReplytocomLink( $link ) {
		return preg_replace( '`href=(["\'])(?:.*(?:\?|&|&#038;)replytocom=(\d+)#respond)`', 'href=$1#comment-$2', $link );
	}

	public function setLastModifiedHeaders() {
		if ( is_user_logged_in() && ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
			return;
		}

		if ( class_exists( 'woocommerce' ) && function_exists( 'is_cart' ) && function_exists( 'is_checkout' ) && function_exists( 'is_account_page' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
			return;
		}

		if ( is_front_page() ) {
			$last_modified_exclude_frontpage = $this->getPopulateOption( 'disable_frontpage_last_modified_headers' );
			if ( $last_modified_exclude_frontpage ) {
				return;
			}
		}

		$last_modified_flush = isset( $_COOKIE['wbcr_lastmodifed_flush'] );

		global $wp;
		$last_modified_exclude     = $this->getPopulateOption( 'last_modified_exclude' );
		$last_modified_exclude_exp = explode( PHP_EOL, $last_modified_exclude );

		$current_url = home_url( add_query_arg( [], $wp->request ) );

		foreach ( $last_modified_exclude_exp as $expr ) {
			if ( ! empty( $expr ) && strpos( urldecode( $current_url ), $expr ) !== false ) {
				return;
			}
		}

		/**
		 * if Search - just return
		 */
		if ( is_search() ) {
			return;
		}

		$last_modified = '';
		/**
		 * If posts, pages, custom post types
		 */
		if ( is_singular() ) {
			global $post;
			if ( ! isset( $post->post_modified_gmt ) ) {
				return;
			}
			$post_time     = strtotime( $post->post_modified_gmt );
			$modified_time = $post_time;
			/**
			 * If we have comment set new modified date
			 */
			if ( (int) $post->comment_count > 0 ) {
				$comments = get_comments( [
					'post_id' => $post->ID,
					'number'  => '1',
					'status'  => 'approve',
					'orderby' => 'comment_date_gmt',
				] );
				if ( ! empty( $comments ) && isset( $comments[0] ) ) {
					$comment_time = strtotime( $comments[0]->comment_date_gmt );
					if ( $comment_time > $post_time ) {
						$modified_time = $comment_time;
					}
				}
			}
			$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
		}
		/**
		 * If any archives: categories, tags, taxonomy terms, post type archives
		 */
		if ( is_archive() || is_home() ) {
			global $posts;
			if ( empty( $posts ) ) {
				return;
			}
			$post = $posts[0];
			if ( ! isset( $post->post_modified_gmt ) ) {
				return;
			}
			$post_time     = strtotime( $post->post_modified_gmt );
			$modified_time = $post_time;
			$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
		}

		/**
		 * If headers already sent - do nothing
		 */

		if ( headers_sent() ) {
			return;
		}

		if ( ! empty( $last_modified ) && ! empty( $modified_time ) ) {

			//todo: Fix bug, admin bar is not hidden after logout
			if ( $last_modified_flush ) {
				$modified_time += rand( 1, 99 );
			}

			header( 'Last-Modified: ' . $last_modified );

			if ( $this->getPopulateOption( 'if_modified_since_headers' ) && ! is_user_logged_in() ) {

				if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) >= $modified_time ) {

					$protocol = ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' );

					header( $protocol . ' 304 Not Modified' );
				}
			}
		}
	}

	function lastModifedFlushCookie() {
		if ( ! isset( $_COOKIE['wbcr_lastmodifed_flush'] ) ) {
			setcookie( "wbcr_lastmodifed_flush", 1, time() + 3600 );
		}
	}
}
