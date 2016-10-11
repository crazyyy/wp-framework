<?php
defined( 'ABSPATH' ) or	die( 'Cheatin&#8217; uh?' );

/**
 * Launch the Robot
 *
 * @since 2.6.4 Don't preload localhost & .dev domains
 * @since 1.0
 *
 * @param string $spider (default: 'cache-preload') The spider name: cache-preload or cache-json
 * @param string $lang (default: '') The language code to preload
 * @return void
 */
function run_rocket_bot( $spider = 'cache-preload', $lang = '' ) {
	$domain = parse_url( home_url(), PHP_URL_HOST );
	if ( 'localhost' == $domain || pathinfo( $domain, PATHINFO_EXTENSION ) == 'dev' ) {
		return false;
	}

	/**
	 * Filter to manage the bot job
	 *
	 * @since 2.1
	 *
	 * @param bool 	 		 Do the job or not
	 * @param string $spider The spider name
	 * @param string $lang 	 The language code to preload
	*/
	if ( ! apply_filters( 'do_run_rocket_bot', true, $spider, $lang ) ) {
		return false;
	}

	$urls = array();

	switch ( $spider ) {
		case 'cache-preload' :
		    if ( ! get_rocket_option( 'manual_preload', true ) ) {
    		    return false;
		    }

			if ( ! $lang ) {
				$urls = get_rocket_i18n_uri();
			} else {
				$urls[] = get_rocket_i18n_home_url( $lang );
			}
		break;
		case 'cache-json' :
		    if ( ! get_rocket_option( 'automatic_preload', true ) ) {
    		    return false;
		    }

			$urls[] = WP_ROCKET_URL . 'cache.json';
		break;
		default :
			return false;
		break;
	}

	foreach ( $urls as $start_url ) {
		/**
		 * Fires before WP Rocket Bot is called
		 *
		 * @since 1.1.0
		 *
		 * @param string $spider 	The spider name
		 * @param string $start_url URL that crawl by the bot
		*/
		do_action( 'before_run_rocket_bot', $spider, $start_url );

		wp_remote_get(
			WP_ROCKET_BOT_URL . '?spider=' . $spider . '&start_url=' . $start_url,
			array(
				'timeout'   => 2,
				'blocking'  => false,
				'sslverify' => false,
			)
		);

		/**
		 * Fires after WP Rocket Bot was called
		 *
		 * @since 1.1.0
		 *
		 * @param string $spider 	The spider name
		 * @param string $start_url URL that crawl by the bot
		*/
		do_action( 'after_run_rocket_bot', $spider, $start_url );
	}
}

/**
 * Launches the preload
 *
 * @since 2.8
 * @author Remy Perona
 *
 * @param string $spider The spider name
 * @param bool $do_sitemap_preload Do the sitemap preload
 *
 * @return void
 */
function run_rocket_preload_cache( $spider, $do_sitemap_preload = true ) {
	// Preload cache
 	run_rocket_bot( $spider );

    if ( $do_sitemap_preload & get_rocket_option( 'sitemap_preload', false ) ) {
        run_rocket_sitemap_preload();
    }
}

/**
 * Launches the sitemap preload
 *
 * @since 2.8
 * @author Remy Perona
 *
 * @return void
 */
function run_rocket_sitemap_preload() {
    /*
     * Filters the sitemaps list to preload
     *
     * @since 2.8
     *
     * @param array Array of sitemaps URL
     */
    $sitemaps = apply_filters( 'rocket_sitemap_preload_list', get_rocket_option( 'sitemaps', false ) );

    if ( ! $sitemaps ) {
        return false;
    }

    $sitemaps                  = array_flip( array_flip( $sitemaps ) );
    $urls_group                = array();
    $rocket_background_process = $GLOBALS['rocket_sitemap_background_process'];

    foreach ( $sitemaps as $sitemap_type => $sitemap_url ) {
        /**
		 * Fires before WP Rocket sitemap preload is called for a sitemap URL
		 *
		 * @since 2.8
		 *
		 * @param string $sitemap_type 	the sitemap identifier
		 * @param string $sitemap_url sitemap URL to be crawler
		*/
		do_action( 'before_run_rocket_sitemap_preload', $sitemap_type, $sitemap_url );

        $urls_group[] = rocket_process_sitemap( $sitemap_url );

        /**
		 * Fires after WP Rocket sitemap preload was called for a sitemap URL
		 *
		 * @since 2.8
		 *
		 * @param string $sitemap_type 	the sitemap identifier
		 * @param string $sitemap_url sitemap URL crawled
		*/
		do_action( 'after_run_rocket_sitemap_preload', $sitemap_type, $sitemap_url );
    }

    foreach ( $urls_group as $k => $urls ) {
        if ( empty( $urls ) ) {
            continue;
        }

        $urls = array_flip( array_flip( $urls ) );
        foreach( $urls as $url ) {
            $rocket_background_process->push_to_queue( $url );
        }
    }

    $rocket_background_process->save()->dispatch();
}

/**
 * Processes the sitemaps recursively 
 *
 * @since 2.8
 * @author Remy Perona
 *
 * @return void
 */
function rocket_process_sitemap( $sitemap_url, $urls = array() ) {
    $tmp_urls = array();

    $args = array(
        'timeout'    => 0.01,
        'blocking'   => false,
        'user-agent' => 'wprocketbot',
        'sslverify'  => false
    );

    $sitemap = wp_remote_get( esc_url_raw( $sitemap_url ) );

    if ( is_wp_error( $sitemap ) ) {
        return array();
    }

    $xml_data = wp_remote_retrieve_body( $sitemap );

    if ( empty( $xml_data ) ) {
        return array();
    }

    libxml_use_internal_errors( true );

    $xml = simplexml_load_string( $xml_data );

    if ( false === $xml ) {
        libxml_clear_errors();
        return array();
    }

    $url_count = count( $xml->url );

    if ( $url_count > 0 ) {
        for ( $i = 0; $i < $url_count; $i++ ) {
            $page_url = (string) $xml->url[ $i ]->loc;
            $tmp_urls[] = $page_url;
        }
    } else {
        // Sub sitemap?
        $sitemap_children = count( $xml->sitemap ); 
        if ( $sitemap_children > 0 ) {
        	for ( $i = 0; $i < $sitemap_children; $i++ ) {
        		$sub_sitemap_url = (string) $xml->sitemap[$i]->loc;
        		$urls = rocket_process_sitemap( $sub_sitemap_url, $urls );
        	}
        }
    }

    $urls = array_merge( $urls, $tmp_urls );
    return $urls;
}