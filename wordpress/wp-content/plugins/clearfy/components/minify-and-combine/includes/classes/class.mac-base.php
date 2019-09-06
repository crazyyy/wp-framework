<?php
/**
 * Base class
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WMAC_PluginBase
 */
abstract class WMAC_PluginBase
{
    /**
     * Holds content being processed (scripts, styles)
     *
     * @var string
     */
    protected $content = '';

    /**
     * Controls debug logging.
     *
     * @var bool
     */
    public $debug_log = false;

	/**
	 * WMAC_PluginBase constructor.
	 *
	 * @param $content
	 */
    public function __construct( $content )
    {
        $this->content = $content;
    }

    /**
     * Reads the page and collects tags.
     *
     * @param array $options Options.
     *
     * @return bool
     */
    abstract public function read( $options );

    /**
     * Joins and optimizes collected things.
     *
     * @return bool
     */
    abstract public function minify();

    /**
     * Caches the things.
     *
     * @return void
     */
    abstract public function cache();

    /**
     * Returns the content
     *
     * @return string
     */
    abstract public function getContent();

    /**
     * Tranfsorms a given URL to a full local filepath if possible.
     * Returns local filepath or false.
     *
     * @param string $url URL to transform.
     *
     * @return bool|string
     */
    public function getPath( $url )
    {
        $url = apply_filters( 'wmac_filter_cssjs_alter_url', $url );

        if ( false !== strpos( $url, '%' ) ) {
            $url = urldecode( $url );
        }

	    $site_url     = WMAC_PluginMain::getSiteUrl();
        $site_host    = parse_url( $site_url, PHP_URL_HOST );
        $content_host = parse_url( WMAC_WP_ROOT_URL, PHP_URL_HOST );

        // Normalizing attempts...
        $double_slash_position = strpos( $url, '//' );
        if ( 0 === $double_slash_position ) {
            if ( is_ssl() ) {
                $url = 'https:' . $url;
            } else {
                $url = 'http:' . $url;
            }
        } elseif ( ( false === $double_slash_position ) && ( false === strpos( $url, $site_host ) ) ) {
            if ( $site_url === $site_host ) {
                $url = $site_url . $url;
            } else {
                $url = $site_url . WMAC_PluginHelper::pathCanonicalize( $url );
            }
        }

        if ( $site_host !== $content_host ) {
            $url = str_replace( WMAC_PluginMain::getContentUrl(), $site_url . WMAC_WP_CONTENT_NAME, $url );
        }

        // First check; hostname wp site should be hostname of url!
        $url_host = @parse_url( $url, PHP_URL_HOST ); // @codingStandardsIgnoreLine
        if ( $url_host !== $site_host ) {
            /**
             * First try to get all domains from WPML (if available)
             * then apply own filter wmac_filter_cssjs_multidomain takes an array of hostnames
             * each item in that array will be considered part of the same WP multisite installation
             */
            $multidomains = array();

            $multidomains_wpml = apply_filters( 'wpml_setting', array(), 'language_domains' );
            if ( ! empty( $multidomains_wpml ) ) {
                $multidomains = array_map( array( $this, 'getUrlHostname' ), $multidomains_wpml );
            }

            $multidomains = apply_filters( 'wmac_filter_cssjs_multidomain', $multidomains );

            if ( ! empty( $multidomains ) ) {
                if ( in_array( $url_host, $multidomains ) ) {
                    $url = str_replace( $url_host, $site_host, $url );
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        // Try to remove "wp root url" from url while not minding http<>https.
        $tmp_ao_root = preg_replace( '/https?:/', '', WMAC_WP_ROOT_URL );

        if ( $site_host !== $content_host ) {
            // As we replaced the content-domain with the site-domain, we should match against that.
            $tmp_ao_root = preg_replace( '/https?:/', '', $site_url );
        }

        $tmp_url = preg_replace( '/https?:/', '', $url );
        $path    = str_replace( $tmp_ao_root, '', $tmp_url );

        // If path starts with :// or //, this is not a URL in the WP context and
        // we have to assume we can't aggregate.
        if ( preg_match( '#^:?//#', $path ) ) {
            // External script/css (adsense, etc).
            return false;
        }

        // Prepend with WMAC_ROOT_DIR to have full path to file.
        $path = str_replace( '//', '/', WMAC_ROOT_DIR . $path );

        // Final check: does file exist and is it readable?
        if ( file_exists( $path ) && is_file( $path ) && is_readable( $path ) ) {
            return $path;
        } else {
            return false;
        }
    }

    /**
     * Returns the hostname part of a given $url if we're able to parse it.
     * If not, it returns the original url (prefixed with http:// scheme in case
     * it was missing).
     * Used as callback for WPML multidomains filter.
     *
     * @param string $url URL.
     *
     * @return string
     */
    protected function getUrlHostname( $url )
    {
        // Checking that the url starts with something vaguely resembling a protocol.
        if ( ( 0 !== strpos( $url, 'http' ) ) && ( 0 !== strpos( $url, '//' ) ) ) {
            $url = 'http://' . $url;
        }

        // Grab the hostname.
        $hostname = parse_url( $url, PHP_URL_HOST );

        // Fallback when parse_url() fails.
        if ( empty( $hostname ) ) {
            $hostname = $url;
        }

        return $hostname;
    }

    /**
     * Hides everything between noptimize-comment tags.
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function hideNoptimize( $markup )
    {
        return $this->replaceContentsWithMarkerIfExists(
            'NOPTIMIZE',
            '/<!--\s?noptimize\s?-->/',
            '#<!--\s?noptimize\s?-->.*?<!--\s?/\s?noptimize\s?-->#is',
            $markup
        );
    }

    /**
     * Unhide noptimize-tags.
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function restoreNoptimize( $markup )
    {
        return $this->restoreMarkedContent( 'NOPTIMIZE', $markup );
    }

    /**
     * Hides "iehacks" content.
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function hideIEhacks( $markup )
    {
        return $this->replaceContentsWithMarkerIfExists(
            'IEHACK', // Marker name...
            '<!--[if', // Invalid regex, will fallback to search using strpos()...
            '#<!--\[if.*?\[endif\]-->#is', // Replacement regex...
            $markup
        );
    }

    /**
     * Restores "hidden" iehacks content.
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function restoreIEhacks( $markup )
    {
        return $this->restoreMarkedContent( 'IEHACK', $markup );
    }

    /**
     * "Hides" content within HTML comments using a regex-based replacement
     * if HTML comment markers are found.
     * `<!--example-->` becomes `%%COMMENTS%%ZXhhbXBsZQ==%%COMMENTS%%`
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function hideComments( $markup )
    {
        return $this->replaceContentsWithMarkerIfExists(
            'COMMENTS',
            '<!--',
            '#<!--.*?-->#is',
            $markup
        );
    }

    /**
     * Restores original HTML comment markers inside a string whose HTML
     * comments have been "hidden" by using `hideComments()`.
     *
     * @param string $markup Markup to process.
     *
     * @return string
     */
    protected function restoreComments( $markup )
    {
        return $this->restoreMarkedContent( 'COMMENTS', $markup );
    }

    /**
     * Injects/replaces the given payload markup into `$this->content`
     * at the specified location.
     * If the specified tag cannot be found, the payload is appended into
     * $this->content along with a warning wrapped inside <!--noptimize--> tags.
     *
     * @param string $payload Markup to inject.
     * @param array  $where   Array specifying the tag name and method of injection.
     *                        Index 0 is the tag name (i.e., `</body>`).
     *                        Index 1 specifies ˛'before', 'after' or 'replace'. Defaults to 'before'.
     *
     * @return void
     */
    protected function injectInHtml( $payload, $where )
    {
        $warned   = false;
        $position = WMAC_PluginHelper::strpos( $this->content, $where[0] );
        if ( false !== $position ) {
            // Found the tag, setup content/injection as specified.
            if ( 'after' === $where[1] ) {
                $content = $where[0] . $payload;
            } elseif ( 'replace' === $where[1] ) {
                $content = $payload;
            } else {
                $content = $payload . $where[0];
            }
            // Place where specified.
            $this->content = WMAC_PluginHelper::substrReplace(
                $this->content,
                $content,
                $position,
                // Using plain strlen() should be safe here for now, since
                // we're not searching for multibyte chars here still...
                strlen( $where[0] )
            );
        } else {
            // Couldn't find what was specified, just append and add a warning.
            $this->content .= $payload;
            if ( ! $warned ) {
                $tag_display    = str_replace( array( '<', '>' ), '', $where[0] );
                $this->content .= '<!--noptimize--><!-- Мinify And Combine found a problem with the HTML in your Theme, tag `' . $tag_display . '` missing --><!--/noptimize-->';
            }
        }
    }

    /**
     * Returns true if given `$tag` is found in the list of `$removables`.
     *
     * @param string $tag Tag to search for.
     * @param array  $removables List of things considered completely removable.
     *
     * @return bool
     */
    protected function isremovable( $tag, $removables )
    {
        foreach ( $removables as $match ) {
            if ( false !== strpos( $tag, $match ) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Callback used in `self::injectMinified()`.
     *
     * @param array $matches Regex matches.
     *
     * @return string
     */
    public function injectMinifiedCallback( $matches )
    {
        /**
         * $matches[1] holds the whole match caught by regex in self::injectMinified(),
         * so we take that and split the string on `|`.
         * First element is the filepath, second is the md5 hash of contents
         * the filepath had when it was being processed.
         * If we don't have those, we'll bail out early.
        */
        $filepath = null;
        $filehash = null;

        // Grab the parts we need.
	    $parts = explode( '|', $matches[1] );
        if ( ! empty( $parts ) ) {
	        $filepath = isset( $parts[0] ) ? base64_decode($parts[0]) : null;
            $filehash = isset( $parts[1] ) ? $parts[1] : null;
        }

        // Bail early if something's not right...
        if ( ! $filepath || ! $filehash ) {
            return "\n";
        }

        $filecontent = file_get_contents( $filepath );

        // Some things are differently handled for css/js...
        $is_js_file = ( '.js' === substr( $filepath, -3, 3 ) );

        $is_css_file = false;
        if ( ! $is_js_file ) {
            $is_css_file = ( '.css' === substr( $filepath, -4, 4 ) );
        }

        // BOMs being nuked here unconditionally (regardless of where they are)!
        $filecontent = preg_replace( "#\x{EF}\x{BB}\x{BF}#", '', $filecontent );

        // Remove comments and blank lines.
        if ( $is_js_file ) {
            $filecontent = preg_replace( '#^\s*\/\/.*$#Um', '', $filecontent );
        }

        // Nuke un-important comments.
        $filecontent = preg_replace( '#^\s*\/\*[^!].*\*\/\s?#Um', '', $filecontent );

        // Normalize newlines.
        $filecontent = preg_replace( '#(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+#', "\n", $filecontent );

        // JS specifics.
        if ( $is_js_file ) {
            // Append a semicolon at the end of js files if it's missing.
            $last_char = substr( $filecontent, -1, 1 );
            if ( ';' !== $last_char && '}' !== $last_char ) {
                $filecontent .= ';';
            }
            // Check if try/catch should be used.
            $opt_js_try_catch = WMAC_Plugin::app()->getPopulateOption('js_trycatch');
            if ( $opt_js_try_catch ) {
                // It should, wrap in try/catch.
                $filecontent = 'try{' . $filecontent . '}catch(e){}';
            }
        } elseif ( $is_css_file ) {
            $filecontent = WMAC_PluginStyles::fixurls( $filepath, $filecontent );
        } else {
            $filecontent = '';
        }

        // Return modified (or empty!) code/content.
        return "\n" . $filecontent;
    }

    /**
     * Inject already minified code in optimized JS/CSS.
     *
     * @param string $in Markup.
     *
     * @return string
     */
    protected function injectMinified( $in )
    {
        $out = $in;

        if ( false !== strpos( $in, '%%INJECTLATER%%' ) ) {
            $out = preg_replace_callback(
                '#\/\*\!%%INJECTLATER' . WMAC_HASH . '%%(.*?)%%INJECTLATER%%\*\/#is',
                array( $this, 'injectMinifiedCallback' ),
                $in
            );
        }

        return $out;
    }

    /**
     * Specialized method to create the INJECTLATER marker.
     * These are somewhat "special", in the sense that they're additionally wrapped
     * within an "exclamation mark style" comment, so that they're not stripped
     * out by minifiers.
     * They also currently contain the hash of the file's contents too (unlike other markers).
     *
     * @param string $filepath Filepath.
     * @param string $hash Hash.
     *
     * @return string
     */
    public static function buildInjectlaterMarker( $filepath, $hash )
    {
        $contents = '/*!' . self::buildMarker( 'INJECTLATER', $filepath, $hash ) . '*/';

        return $contents;
    }

    /**
     * Creates and returns a `%%`-style named marker which holds
     * the base64 encoded `$data`.
     * If `$hash` is provided, it's appended to the base64 encoded string
     * using `|` as the separator (in order to support building the
     * somewhat special/different INJECTLATER marker).
     *
     * @param string      $name Marker name.
     * @param string      $data Marker data which will be base64-encoded.
     * @param string|null $hash Optional.
     *
     * @return string
     */
    public static function buildMarker( $name, $data, $hash = null )
    {
        // Start the marker, add the data.
        $marker = '%%' . $name . WMAC_HASH . '%%' . base64_encode( $data );

        // Add the hash if provided.
        if ( null !== $hash ) {
            $marker .= '|' . $hash;
        }

        // Close the marker.
        $marker .= '%%' . $name . '%%';

        return $marker;
    }

    /**
     * Returns true if the string is a valid regex.
     *
     * @param string $string String, duh.
     *
     * @return bool
     */
    protected function strIsValidRegex( $string )
    {
        set_error_handler( function() {}, E_WARNING );
        $is_regex = ( false !== preg_match( $string, '' ) );
        restore_error_handler();

        return $is_regex;
    }

    /**
     * Searches for `$search` in `$content` (using either `preg_match()`
     * or `strpos()`, depending on whether `$search` is a valid regex pattern or not).
     * If something is found, it replaces `$content` using `$re_replace_pattern`,
     * effectively creating our named markers (`%%{$marker}%%`.
     * These are then at some point replaced back to their actual/original/modified
     * contents using `WMAC_PluginBase::restoreMarkedContent()`.
     *
     * @param string $marker Marker name (without percent characters).
     * @param string $search A string or full blown regex pattern to search for in $content. Uses `strpos()` or `preg_match()`.
     * @param string $re_replace_pattern Regex pattern to use when replacing contents.
     * @param string $content Content to work on.
     *
     * @return string
     */
    protected function replaceContentsWithMarkerIfExists( $marker, $search, $re_replace_pattern, $content )
    {
        $is_regex = $this->strIsValidRegex( $search );
        if ( $is_regex ) {
            $found = preg_match( $search, $content );
        } else {
            $found = ( false !== strpos( $content, $search ) );
        }

        if ( $found ) {
            $content = preg_replace_callback(
                $re_replace_pattern,
                function( $matches ) use ( $marker ) {
                    return WMAC_PluginBase::buildMarker( $marker, $matches[0] );
                },
                $content
            );
        }

        return $content;
    }

    /**
     * Complements `WMAC_PluginBase::replaceContentsWithMarkerIfExists()`.
     *
     * @param string $marker Marker.
     * @param string $content Markup.
     *
     * @return string
     */
    protected function restoreMarkedContent( $marker, $content )
    {
        if ( false !== strpos( $content, $marker ) ) {
            $content = preg_replace_callback(
                '#%%' . $marker . WMAC_HASH . '%%(.*?)%%' . $marker . '%%#is',
                function ( $matches ) {
                    return base64_decode( $matches[1] );
                },
                $content
            );
        }

        return $content;
    }

    /**
     * Logs given `$data` for debugging purposes (when debug logging is on).
     *
     * @param mixed $data Data to log.
     *
     * @return void
     */
    protected function debugLog( $data )
    {
        if ( ! isset( $this->debug_log ) || ! $this->debug_log ) {
            return;
        }

        if ( ! is_string( $data ) && ! is_resource( $data ) ) {
            $data = var_export( $data, true );
        }

        error_log( $data );
    }

    /**
     * Checks if a single local css/js file can be minified and returns source if so.
     *
     * @param string $filepath Filepath.
     *
     * @return bool|string to be minified code or false.
     */
    protected function prepareMinifySingle( $filepath )
    {
        // Decide what we're dealing with, return false if we don't know.
        if ( $this->strEndsIn( $filepath, '.js' ) ) {
            $type = 'js';
        } elseif ( $this->strEndsIn( $filepath, '.css' ) ) {
            $type = 'css';
        } else {
            return false;
        }

        // Bail if it looks like its already minifed (by having -min or .min
        // in filename) or if it looks like WP jquery.js (which is minified).
        $minified_variants = apply_filters('wmac_minified_variants',array(
            '-min.' . $type,
            '.min.' . $type,
            'js/jquery/jquery.js',
        ));


        foreach ( $minified_variants as $ending ) {
            if ( $this->strEndsIn( $filepath, $ending ) ) {
                return false;
            }
        }

        // Get file contents, bail if empty.
        $contents = file_get_contents( $filepath );

        return $contents;
    }

    /**
     * Given an WMAC_PluginCache instance returns the url of
     * the cached file.
     *
     * @param WMAC_PluginCache $cache WMAC_PluginCache instance.
     *
     * @return string
     */
    protected function buildMinifySingleUrl( WMAC_PluginCache $cache )
    {
        $url = WMAC_PluginCache::getCacheUrl() . $cache->getname();

        return $url;
    }

    /**
     * Returns true if given $str ends with given $test.
     *
     * @param string $str String to check.
     * @param string $test Ending to match.
     *
     * @return bool
     */
    protected function strEndsIn( $str, $test )
    {
        // @codingStandardsIgnoreStart
        // substr_compare() is bugged on 5.5.11: https://3v4l.org/qGYBH
        // return ( 0 === substr_compare( $str, $test, -strlen( $test ) ) );
        // @codingStandardsIgnoreEnd

        $length = strlen( $test );

        return ( substr( $str, -$length, $length ) === $test );
    }
}
