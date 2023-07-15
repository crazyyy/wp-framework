<?php

function httpsrdrctn_force_https_embeds( $content ) {
    $files_to_check = array( 'jpg', 'jpeg', 'gif', 'png', 'js', 'css' );

    if ( strpos( home_url(), 'https' ) !== false ) {
	$http_domain = str_replace( 'https', 'http', home_url() );
    } else {
	$http_domain = home_url();
    }

    $matches = array();
    $pattern = '/' . str_replace( '/', '\/', quotemeta( $http_domain ) ) . '\/[^\"\']*\.[' . implode( "|", $files_to_check ) . ']+/';

    preg_match_all( $pattern, $content, $matches );

    if ( ! empty( $matches ) ) {
	foreach ( $matches[ 0 ] as $match ) {
	    $match_https	 = str_replace( 'http', 'https', $match );
	    $content	 = str_replace( $match, $match_https, $content );
	}
    }

    return $content;
}

/*** 
 * Test Code
 */
/*
echo httpsrdrctn_force_https_embeds( '<img src="http://test.com/image.jpg" />
    <a href="http://test.com/image.jpeg"></a>
    "http://test.com/image.gif"
    <img src="http://test.com/image.png" />
    <link rel="javascript" type="text/javascript" href="http://test.com/somescript.js" />
    <link rel="stylesheet" type="text/css" href="http://test.com/somestyles.css" />
    http://test.com/somescript.bmp' );
*/
