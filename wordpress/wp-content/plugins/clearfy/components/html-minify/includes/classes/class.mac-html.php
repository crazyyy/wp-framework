<?php
/**
 * Operations with HTML
 * 
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WHTM_PluginHTML
 */
class WHTM_PluginHTML extends WHTM_PluginBase
{
    /**
     * Force xhtml.
     *
     * @var bool
     */
    private $forcexhtml = false;

    /**
     * Whether HTML comments are kept.
     *
     * @var bool
     */
    private $keepcomments = false;

    /**
     * Things to exclude from being minifed.
     *
     * @var array
     */
    private $exclude = array(
        '<!-- ngg_resource_manager_marker -->',
        '<!--noindex-->',
        '<!--/noindex-->',
    );

    public function read( $options )
    {
        // Remove the HTML comments?
        $this->keepcomments = (bool) $options['keepcomments'];

        // Filter to force xhtml.
        $this->forcexhtml = (bool) apply_filters( 'whm_filter_html_forcexhtml', false );

        // Filterable strings to be excluded from HTML minification.
        $exclude = apply_filters( 'whm_filter_html_exclude', '' );
        if ( '' !== $exclude ) {
            $exclude_arr   = array_filter( array_map( 'trim', explode( ',', $exclude ) ) );
            $this->exclude = array_merge( $exclude_arr, $this->exclude );
        }

        return true;
    }

    /**
     * Minifies HTML.
     *
     * @return bool
     */
    public function minify()
    {
        $noptimize = apply_filters( 'whm_filter_html_noptimize', false, $this->content );
        if ( $noptimize ) {
            return false;
        }

        // Wrap the to-be-excluded strings in no optimize tags.
        foreach ( $this->exclude as $str ) {
            if ( false !== strpos( $this->content, $str ) ) {
                $replacement   = '<!--noptimize-->' . $str . '<!--/noptimize-->';
                $this->content = str_replace( $str, $replacement, $this->content );
            }
        }

        // No optimize.
        $this->content = $this->hideNoptimize( $this->content );

        // Preparing options for Minify_HTML.
        $options = array( 'keepComments' => $this->keepcomments );
        if ( $this->forcexhtml ) {
            $options['xhtml'] = true;
        }

        $tmp_content = Minify_HTML::minify( $this->content, $options );
        if ( ! empty( $tmp_content ) ) {
            $this->content = $tmp_content;
            unset( $tmp_content );
        }

        // Restore no optimize.
        $this->content = $this->restoreNoptimize( $this->content );

        // Remove the noptimize-wrapper from around the excluded strings.
        foreach ( $this->exclude as $str ) {
            $replacement = '<!--noptimize-->' . $str . '<!--/noptimize-->';
            if ( false !== strpos( $this->content, $replacement ) ) {
                $this->content = str_replace( $replacement, $str, $this->content );
            }
        }

        // Revslider data attribs somehow suffer from HTML optimization, this fixes that!
        if ( class_exists( 'RevSlider' ) && apply_filters( 'whm_filter_html_dataattrib_cleanup', false ) ) {
            $this->content = preg_replace( '#\n(data-.*$)\n#Um', ' $1 ', $this->content );
            $this->content = preg_replace( '#<[^>]*(=\"[^"\'<>\s]*\")(\w)#', '$1 $2', $this->content );
        }

        return true;
    }

    /**
     * Returns the HTML markup.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
