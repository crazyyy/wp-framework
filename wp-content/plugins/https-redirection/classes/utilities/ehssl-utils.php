<?php

class EHSSL_Utils
{
    public static function httpsrdrctn_force_https_embeds($content)
    {
        $files_to_check = array('jpg', 'jpeg', 'gif', 'png', 'js', 'css');

        if (strpos(home_url(), 'https') !== false) {
            $http_domain = str_replace('https', 'http', home_url());
        } else {
            $http_domain = home_url();
        }

        $matches = array();
        $pattern = '/' . str_replace('/', '\/', quotemeta($http_domain)) . '\/[^\"\']*\.[' . implode("|", $files_to_check) . ']+/';

        preg_match_all($pattern, $content, $matches);

        if (!empty($matches)) {
            foreach ($matches[0] as $match) {
                $match_https = str_replace('http', 'https', $match);
                $content = str_replace($match, $match_https, $content);
            }
        }

        return $content;
    }

    public static function redirect_to_url( $url, $delay = '0', $exit = '1' ) {
		$url = apply_filters( 'wpec_before_redirect_to_url', $url );
		if ( empty( $url ) ) {
			echo '<strong>';
			_e( 'Error! The URL value is empty. Please specify a correct URL value to redirect to!', 'wp-express-checkout' );
			echo '</strong>';
			exit;
		}
		if ( ! headers_sent() ) {
			header( 'Location: ' . $url );
		} else {
			echo '<meta http-equiv="refresh" content="' . $delay . ';url=' . $url . '" />';
		}

		if ( $exit == '1' ) {//exit
			exit;
		}
	}

    /*
     * Get the current domain name. Example: example.com
     */
    public static function get_domain(){
        // Get the home URL
        $home_url = get_home_url();        

        // Parse the URL to extract components
        $parsed_url = parse_url($home_url);

        // Get the host part of the URL
        $domain = isset($parsed_url['host']) ? $parsed_url['host'] : '';

        return $domain;
    }

    //returns www domain if passed domain is without www
    //other wise return without domain
    public static function get_domain_variant($domain)
    {   
        // Check if the domain starts with 'www.'
        if (substr($domain, 0, 4) === 'www.') {
            // Remove 'www.' from the domain
            return substr($domain, 4);
        } else {
            // Add 'www.' to the domain
            return 'www.' . $domain;
        }
    }


    public static function is_domain_accessible($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpcode >= 200 && $httpcode < 400);
    }

	public static function parse_timestamp( $timestamp ) {
		$timestamp = intval($timestamp);

		$timezone_string = new DateTimeZone(wp_timezone_string());

		$dateTime = new DateTime();
		$dateTime->setTimestamp( $timestamp );
		$dateTime->setTimezone( $timezone_string );

		$formatted_date_time = $dateTime->format( get_option('date_format') . ' \a\t ' . get_option( 'time_format' ) );

		return $formatted_date_time;
	}

	public static function parse_date( $timestamp ) {
		$timestamp = intval($timestamp);

		$timezone_string = new DateTimeZone(wp_timezone_string());

		$dateTime = new DateTime();
		$dateTime->setTimestamp( $timestamp );
		$dateTime->setTimezone( $timezone_string );

		$formatted_date_time = $dateTime->format( get_option('date_format') );

		return $formatted_date_time;
	}

	public static function parse_time( $timestamp ) {
		$timestamp = intval($timestamp);

		$timezone_string = new DateTimeZone(wp_timezone_string());

		$dateTime = new DateTime();
		$dateTime->setTimestamp( $timestamp );
		$dateTime->setTimezone( $timezone_string );

		$formatted_date_time = $dateTime->format( get_option('time_format') );

		return $formatted_date_time;
	}

	public static function get_missing_extensions() {
		$required_extensions = array('curl', 'openssl');

		$missing_extensions = array();
		foreach ($required_extensions as $extension){
			if (! extension_loaded($extension)){
				$missing_extensions[] = $extension;
			}
		}

		return $missing_extensions;
	}
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