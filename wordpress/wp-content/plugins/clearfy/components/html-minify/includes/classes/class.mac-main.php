<?php
/**
 * Main class
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WHTM_PluginMain
 */
class WHTM_PluginMain
{
    const INIT_EARLIER_PRIORITY = -1;
    const DEFAULT_HOOK_PRIORITY = 2;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Start processing
	 */
	public function start()
	{
		$this->setup();
		$this->hook();
		$this->run();
	}

	/**
	 * Initialization hooks
	 */
	public function hook() {
		if ( WHTM_Plugin::app()->getPopulateOption('html_optimize') ) {
			add_action( 'wp_loaded', array( $this, 'removeCacheMessage' ) );
		}
	}

	/**
	 * Setting the parameters
	 */
    public function setup()
    {
        // These can be overridden by specifying them in wp-config.php or such.
        if ( ! defined( 'WHTM_WP_CONTENT_NAME' ) ) {
            define( 'WHTM_WP_CONTENT_NAME', '/' . wp_basename( WP_CONTENT_DIR ) );
        }

        define( 'WHTM_ROOT_DIR', substr( WP_CONTENT_DIR, 0, strlen( WP_CONTENT_DIR ) - strlen( WHTM_WP_CONTENT_NAME ) ) );

        if ( ! defined( 'WHTM_WP_SITE_URL' ) ) {
        	// domain_mapping_siteurl функция из плагина, который позволяет задавать свой домен для подсайта
            if ( function_exists( 'domain_mapping_siteurl' ) ) {
                define( 'WHTM_WP_SITE_URL', domain_mapping_siteurl( get_current_blog_id() ) );
            } else {
                define( 'WHTM_WP_SITE_URL', site_url() );
            }
        }

        if ( ! defined( 'WHTM_WP_CONTENT_URL' ) ) {
	        // get_original_url функция из плагина, который позволяет задавать свой домен для подсайта
            if ( function_exists( 'get_original_url' ) ) {
                define( 'WHTM_WP_CONTENT_URL', str_replace( get_original_url( WHTM_WP_SITE_URL ), WHTM_WP_SITE_URL, content_url() ) );
            } else {
                define( 'WHTM_WP_CONTENT_URL', content_url() );
            }
        }

        if ( ! defined( 'WHTM_WP_ROOT_URL' ) ) {
            define( 'WHTM_WP_ROOT_URL', str_replace( WHTM_WP_CONTENT_NAME, '', WHTM_WP_CONTENT_URL ) );
        }

        if ( ! defined( 'WHTM_HASH' ) ) {
            define( 'WHTM_HASH', wp_hash( time() ) );
        }
    }

	/**
	 * Run
	 */
    public function run()
    {
        if ( WHTM_Plugin::app()->getPopulateOption('html_optimize') ) {
            // Hook into WordPress frontend.
            if ( defined( 'WHTM_INIT_EARLIER' ) ) {
                add_action( 'init', array( $this, 'startBuffering' ), self::INIT_EARLIER_PRIORITY );
            } else {
                if ( ! defined( 'WHTM_HOOK_INTO' ) ) {
                    define( 'WHTM_HOOK_INTO', 'template_redirect' );
                }
                add_action(
                    constant( 'WHTM_HOOK_INTO' ),
                    array( $this, 'startBuffering' ),
                    self::DEFAULT_HOOK_PRIORITY
                );
            }
        }
    }

    /**
     * Setup output buffering if needed.
     *
     * @return void
     */
    public function startBuffering()
    {
        if ( $this->shouldBuffer() ) {

	        if ( apply_filters( 'whm_filter_obkiller', false ) ) {
		        while ( ob_get_level() > 0 ) {
			        ob_end_clean();
		        }
	        }

            // Now, start the real thing!
            ob_start( array( $this, 'endBuffering' ) );
        }
    }

    /**
     * Returns true if all the conditions to start output buffering are satisfied.
     *
     * @param bool $doing_tests Allows overriding the optimization of only
     *                          deciding once per request (for use in tests).
     * @return bool
     */
    public function shouldBuffer( $doing_tests = false )
    {
        static $do_buffering = null;

        // Only check once in case we're called multiple times by others but
        // still allows multiple calls when doing tests.
        if ( null === $do_buffering || $doing_tests ) {
            $whm_noptimize = false;

            // Checking for DONOTMINIFY constant as used by e.g. WooCommerce POS.
            if (
            	defined( 'DONOTMINIFY' )
	            && ( constant( 'DONOTMINIFY' ) === true || constant( 'DONOTMINIFY' ) === 'true' )
            ) {
                $whm_noptimize = true;
            }

            // Skip checking query strings if they're disabled.
            if ( apply_filters( 'whm_filter_honor_qs_noptimize', true ) ) {
                // Check for `whm_noptimize` (and other) keys in the query string
                // to get non-optimized page for debugging.
                $keys = array(
                    'whm_noptimize',
                    'whm_noptirocket',
                );
                foreach ( $keys as $key ) {
                    if ( array_key_exists( $key, $_GET ) && '1' === $_GET[ $key ] ) {
                        $whm_noptimize = true;
                        break;
                    }
                }
            }

            // Allows blocking of auto optimization on your own terms regardless of above decisions.
            $whm_noptimize = (bool) apply_filters( 'whm_filter_noptimize', $whm_noptimize );

            // Check for site being previewed in the Customizer (available since WP 4.0).
            $is_customize_preview = false;
            if ( function_exists( 'is_customize_preview' ) && is_customize_preview() ) {
                $is_customize_preview = is_customize_preview();
            }

            /**
             * We only buffer the frontend requests (and then only if not a feed
             * and not turned off explicitly and not when being previewed in Customizer)!
             * NOTE: Tests throw a notice here due to is_feed() being called
             * while the main query hasn't been ran yet. Thats why we use
             * WHTM_INIT_EARLIER in tests.
             */
            $do_buffering = ( ! is_admin() && ! is_feed() && ! $whm_noptimize && ! $is_customize_preview );
        }

        return $do_buffering;
    }

    /**
     * Returns true if given markup is considered valid/processable/optimizable.
     *
     * @param string $content Markup.
     *
     * @return bool
     */
    public function isValidBuffer( $content )
    {
        // Defaults to true.
        $valid = true;

        $has_no_html_tag    = ( false === stripos( $content, '<html' ) );
        $has_xsl_stylesheet = ( false !== stripos( $content, '<xsl:stylesheet' ) );
        $has_html5_doctype  = ( preg_match( '/^<!DOCTYPE.+html>/i', $content ) > 0 );

        if ( $has_no_html_tag ) {
            // Can't be valid amp markup without an html tag preceding it.
            $is_amp_markup = false;
        } else {
            $is_amp_markup = self::isAmpMarkup( $content );
        }

        // If it's not html, or if it's amp or contains xsl stylesheets we don't touch it.
        if ( $has_no_html_tag && ! $has_html5_doctype || $is_amp_markup || $has_xsl_stylesheet ) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * Returns true if given $content is considered to be AMP markup.
     * This is far from actual validation against AMP spec, but it'll do for now.
     *
     * @param string $content Markup to check.
     *
     * @return bool
     */
    public static function isAmpMarkup( $content )
    {
        $is_amp_markup = preg_match( '/<html[^>]*(?:amp|⚡)/i', $content );

        return (bool) $is_amp_markup;
    }

    /**
     * Processes/optimizes the output-buffered content and returns it.
     * If the content is not processable, it is returned unmodified.
     *
     * @param string $content Buffered content.
     *
     * @return string
     */
    public function endBuffering( $content )
    {
        // Bail early without modifying anything if we can't handle the content.
        if ( ! $this->isValidBuffer( $content ) ) {
            return $content;
        }

        // Determine what needs to be ran.
        $classes = array();
	    if ( WHTM_Plugin::app()->getPopulateOption( 'html_optimize' ) ) {
		    $classes[] = 'WHTM_PluginHTML';
	    }

	    $classoptions = array(
		    'WHTM_PluginHTML'    => array(
			    'keepcomments' => WHTM_Plugin::app()->getPopulateOption( 'html_keepcomments' ),
		    ),
	    );

        $content = apply_filters( 'whm_filter_html_before_minify', $content );

        // Run the classes!
        foreach ( $classes as $name ) {
            $instance = new $name( $content );
            if ( $instance->read( $classoptions[ $name ] ) ) {
                $instance->minify();
                $content = $instance->getContent();
            }
            unset( $instance );
        }

        $content = apply_filters( 'whm_html_after_minify', $content );

        return $content;
    }

	/**
	 * Remove Cache Status Messages
	 */
	public function removeCacheMessage()
	{
		// For WP Super Cache
		if ( file_exists( WP_CONTENT_DIR . '/wp-cache-config.php' ) && function_exists( 'prune_super_cache' ) ) {
			global $wp_super_cache_comments;
			$wp_super_cache_comments = 0;
		}

		// For WP Fastest Cache
		if ( class_exists( 'WpFastestCache' ) ) {
			define( 'WPFC_REMOVE_FOOTER_COMMENT', true );
		}

		// For WP Total Cache
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			add_filter( 'w3tc_footer_comment', '__return_empty_array' );
		}
	}

}
