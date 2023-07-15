<?php

class HTTPSRDRCTN_RULES {

    function __construct() {
	
    }

    function write_to_htaccess() {
	//clean up old rules first
	if ( $this->delete_from_htaccess() == -1 ) {
	    return -1; //unable to write to the file
	}

	$htaccess	 = ABSPATH . '.htaccess';
	//get the subdirectory if it is installed in one
	$siteurl	 = explode( '/', get_option( 'siteurl' ) );
	if ( isset( $siteurl[ 3 ] ) ) {
	    $dir = '/' . $siteurl[ 3 ] . '/';
	} else {
	    $dir = '/';
	}

	if ( ! $f = @fopen( $htaccess, 'a+' ) ) {
	    @chmod( $htaccess, 0644 );
	    if ( ! $f = @fopen( $htaccess, 'a+' ) ) {
		return -1;
	    }
	}

	//backup_a_file($htaccess); //TODO - should we back up htaccess file?

	@ini_set( 'auto_detect_line_endings', true );
	$ht = explode( PHP_EOL, implode( '', file( $htaccess ) ) ); //parse each line of file into array

	$rules = $this->getrules();
	if ( $rules == -1 ) {
	    return -1;
	}

	$rulesarray	 = explode( PHP_EOL, $rules );
	$contents	 = array_merge( $rulesarray, $ht );

	if ( ! $f = @fopen( $htaccess, 'w+' ) ) {
	    return -1; //we can't write to the file
	}

	$blank = false;

	//write each line to file
	foreach ( $contents as $insertline ) {
	    if ( trim( $insertline ) == '' ) {
		if ( $blank == false ) {
		    fwrite( $f, PHP_EOL . trim( $insertline ) );
		}
		$blank = true;
	    } else {
		$blank = false;
		fwrite( $f, PHP_EOL . trim( $insertline ) );
	    }
	}
	@fclose( $f );
	return 1; //success
    }

    function getrules() {
	@ini_set( 'auto_detect_line_endings', true );

	//figure out what server they're using
	if ( strstr( strtolower( filter_var( $_SERVER[ 'SERVER_SOFTWARE' ], FILTER_SANITIZE_STRING ) ), 'apache' ) ) {
	    $server_type = 'apache';
	} else if ( strstr( strtolower( filter_var( $_SERVER[ 'SERVER_SOFTWARE' ], FILTER_SANITIZE_STRING ) ), 'nginx' ) ) {
	    $server_type = 'nginx';
	} else if ( strstr( strtolower( filter_var( $_SERVER[ 'SERVER_SOFTWARE' ], FILTER_SANITIZE_STRING ) ), 'litespeed' ) ) {
	    $server_type = 'litespeed';
	} else { //unsupported server
	    return -1;
	}

	//check if some plugins are active to avoid incompatability issues
	// WP Fastest Cache
	if ( isset( $GLOBALS[ "wp_fastest_cache" ] ) ) {
	    $wpfc		 = true;
	    $wpfc_rules	 = '# WP Fastest Cache compatability' . PHP_EOL;
	    $wpfc_rules	 .= 'RewriteCond %{REQUEST_URI} !wp-content\/cache\/(all|wpfc-mobile-cache)' . PHP_EOL;
	} else {
	    $wpfc = false;
	}

	$rules			 = '';
	$httpsrdrctn_options	 = get_option( 'httpsrdrctn_options' );
	$https_full_domain	 = $httpsrdrctn_options[ 'https_domain' ];
	$auto_redirect_enabled	 = $httpsrdrctn_options[ 'https' ];

	if ( $auto_redirect_enabled != '1' ) {
	    //HTTPS Redirection is NOT enabled
	    return $rules;
	}

	if ( $https_full_domain == '1' ) {//HTTPS Redirection on Full Site
	    $rules	 .= '<IfModule mod_rewrite.c>' . PHP_EOL;
	    $rules	 .= 'RewriteEngine On' . PHP_EOL;

            $rules .= 'RewriteCond %{HTTP:X-Forwarded-Proto} !https' . PHP_EOL; //Handle traffic connecting to your proxy or load balancer
            $rules .= 'RewriteCond %{HTTPS} off' . PHP_EOL; //Alternative is to use RewriteCond %{SERVER_PORT} !^443$
	    if ( $wpfc ) {
		$rules .= $wpfc_rules;
	    }
	    $rules .= 'RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]' . PHP_EOL;

	    $rules .= '</IfModule>' . PHP_EOL;
	} else {//HTTPS Redirection on a Few Pages ONLY
	    if ( empty( $httpsrdrctn_options[ 'https_pages_array' ] ) ) {
		//No specific page has been configured
		return '';
	    }

	    $rules	 .= '<IfModule mod_rewrite.c>' . PHP_EOL;
	    $rules	 .= 'RewriteEngine On' . PHP_EOL;

            $rules .= 'RewriteCond %{HTTP:X-Forwarded-Proto} !https' . PHP_EOL; //Handle traffic connecting to your proxy or load balancer
            $rules .= 'RewriteCond %{HTTPS} off' . PHP_EOL; //Alternative is to use RewriteCond %{SERVER_PORT} !^443$
	    if ( $wpfc ) {
		$rules .= $wpfc_rules;
	    }
	    $count		 = 0;
	    $total_pages	 = count( $httpsrdrctn_options[ 'https_pages_array' ] );
	    foreach ( $httpsrdrctn_options[ 'https_pages_array' ] as $https_page ) {
		//Add a RewriteCond line for each of the individual pages

		$count ++;

		if ( empty( $https_page ) ) {
		    continue;
		}

		$rules .= 'RewriteCond %{REQUEST_URI} ' . trim( $https_page );
		if ( $total_pages != $count ) {//This is not the last page so join them with an OR condition
		    $rules .= ' [OR]';
		}
		$rules .= PHP_EOL;
	    }

	    $rules .= 'RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]' . PHP_EOL;

	    $rules .= '</IfModule>' . PHP_EOL;
	}

	//Add outer markers if we have rules
	if ( $rules != '' ) {
	    $rules = "# BEGIN HTTPS Redirection Plugin" . PHP_EOL . $rules . "# END HTTPS Redirection Plugin" . PHP_EOL;
	}

	return $rules;
    }

    function delete_from_htaccess( $section = 'HTTPS Redirection Plugin' ) {
	$htaccess = ABSPATH . '.htaccess';

	@ini_set( 'auto_detect_line_endings', true );
	if ( ! file_exists( $htaccess ) ) {
	    $ht = @fopen( $htaccess, 'a+' );
	    @fclose( $ht );
	}
	$ht_contents = explode( PHP_EOL, implode( '', file( $htaccess ) ) ); //parse each line of file into array
	if ( $ht_contents ) { //as long as there are lines in the file
	    $state	 = true;
	    if ( ! $f	 = @fopen( $htaccess, 'w+' ) ) {
		@chmod( $htaccess, 0644 );
		if ( ! $f = @fopen( $htaccess, 'w+' ) ) {
		    return -1;
		}
	    }

	    foreach ( $ht_contents as $n => $markerline ) { //for each line in the file
		if ( strpos( $markerline, '# BEGIN ' . $section ) !== false ) { //if we're at the beginning of the section
		    $state = false;
		}
		if ( $state == true ) { //as long as we're not in the section keep writing
		    fwrite( $f, trim( $markerline ) . PHP_EOL );
		}
		if ( strpos( $markerline, '# END ' . $section ) !== false ) { //see if we're at the end of the section
		    $state = true;
		}
	    }
	    @fclose( $f );
	    return 1;
	}
	return 1;
    }

}
