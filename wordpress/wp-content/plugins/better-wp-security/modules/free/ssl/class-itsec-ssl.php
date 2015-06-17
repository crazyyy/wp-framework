<?php

class ITSEC_SSL {

	private $settings;

	function run() {

		$this->settings = get_site_option( 'itsec_ssl' );

		//Don't redirect any SSL if SSL is turned off.
		if ( isset( $this->settings['frontend'] ) && $this->settings['frontend'] >= 1 ) {

			add_action( 'template_redirect', array( $this, 'ssl_redirect' ) );
			add_filter( 'the_content', array( $this, 'replace_content_urls' ) );
			add_filter( 'script_loader_src', array( $this, 'script_loader_src' ) );
			add_filter( 'style_loader_src', array( $this, 'style_loader_src' ) );
			add_filter( 'upload_dir', array( $this, 'upload_dir' ) );

		}

	}

	/**
	 * Check if current url is using SSL
	 *
	 * @since 4.0
	 *
	 * @return bool true if ssl false if not
	 *
	 */
	private function is_ssl() {

		//modified logic courtesy of "Good Samaritan"
		if ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) {
			return true;
		}

		return false;

	}

	/**
	 * Redirects to or from SSL where appropriate
	 *
	 * @since 4.0
	 *
	 * @return void
	 */
	public function ssl_redirect() {

		global $post;

		$hide_options = get_site_option( 'itsec_hide_backend' );

		if ( isset( $hide_options['enabled'] ) && $hide_options['enabled'] === true && $_SERVER['REQUEST_URI'] == ITSEC_Lib::get_home_root() . $hide_options['slug'] ) {
			return;
		}

		if ( is_singular() && $this->settings['frontend'] == 1 ) {

			$require_ssl = get_post_meta( $post->ID, 'itsec_enable_ssl', true );
			$bwps_ssl    = get_post_meta( $post->ID, 'bwps_enable_ssl', true );

			if ( $bwps_ssl == 1 ) {

				$require_ssl = 1;
				delete_post_meta( $post->ID, 'bwps_enable_ssl' );
				update_post_meta( $post->ID, 'itsec_enable_ssl', true );

			} elseif ( $bwps_ssl != 1 ) {

				delete_post_meta( $post->ID, 'bwps_enable_ssl' );

				if ( $require_ssl != 1 ) {
					delete_post_meta( $post->ID, 'itsec_enable_ssl' );
				}

			}

			if ( ( $require_ssl == 1 && $this->is_ssl() === false ) || ( $require_ssl != 1 && $this->is_ssl() === true ) ) {

				$href = ( $_SERVER['SERVER_PORT'] == '443' ? 'http' : 'https' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				wp_redirect( esc_url( $href ), 302 );
				exit();

			}

		} else {

			if ( ( $this->settings['frontend'] == 2 && ! $this->is_ssl() ) || ( ( $this->settings['frontend'] == 0 || $this->settings['frontend'] == 1 ) && $this->is_ssl() ) ) {

				$href = ( $_SERVER['SERVER_PORT'] == '443' ? 'http' : 'https' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				wp_redirect( esc_url( $href ), 302 );
				exit();

			}

		}

	}

	/**
	 * Replace urls in content with ssl
	 *
	 * @since 4.1
	 *
	 * @param string $content the content
	 *
	 * @return string the content
	 */
	public function replace_content_urls( $content ) {

		if ( $this->is_ssl() ) {
			$content = str_replace( site_url( '', 'http:' ), site_url( '', 'https:' ), $content );
		}

		return $content;
	}

	/**
	 * Replace urls in scripts with ssl
	 *
	 * @since 4.4
	 *
	 * @param string $script_loader_src the url
	 *
	 * @return string the url
	 */
	public function script_loader_src( $script_loader_src ) {

		return str_replace( site_url( '', 'http:' ), site_url( '', 'https:' ), $script_loader_src );;

	}

	/**
	 * Replace urls in styles with ssl
	 *
	 * @since 4.4
	 *
	 * @param string $style_loader_src the url
	 *
	 * @return string the url
	 */
	public function style_loader_src( $style_loader_src ) {

		return str_replace( site_url( '', 'http:' ), site_url( '', 'https:' ), $style_loader_src );;

	}

	/**
	 * filter uploads dir so that plugins using it to determine upload URL also work
	 *
	 * @since 4.0
	 *
	 * @param array $uploads
	 *
	 * @return array
	 */
	public static function upload_dir( $upload_dir ) {

		$upload_dir['url']     = str_replace( site_url( '', 'http:' ), site_url( '', 'https:' ), $upload_dir['url'] );
		$upload_dir['baseurl'] = str_replace( site_url( '', 'http:' ), site_url( '', 'https:' ), $upload_dir['baseurl'] );

		return $upload_dir;
	}

}
