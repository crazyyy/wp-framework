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
 * Class WHTM_PluginBase
 */
abstract class WHTM_PluginBase
{
    /**
     * Holds content being processed (html, scripts, styles)
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
	 * WHTM_PluginBase constructor.
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
     * Returns the content
     *
     * @return string
     */
    abstract public function getContent();

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
        $marker = '%%' . $name . WHTM_HASH . '%%' . base64_encode( $data );

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
     * contents using `WHTM_PluginBase::restoreMarkedContent()`.
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
                    return WHTM_PluginBase::buildMarker( $marker, $matches[0] );
                },
                $content
            );
        }

        return $content;
    }

    /**
     * Complements `WHTM_PluginBase::replaceContentsWithMarkerIfExists()`.
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
                '#%%' . $marker . WHTM_HASH . '%%(.*?)%%' . $marker . '%%#is',
                function ( $matches ) {
                    return base64_decode( $matches[1] );
                },
                $content
            );
        }

        return $content;
    }

}
