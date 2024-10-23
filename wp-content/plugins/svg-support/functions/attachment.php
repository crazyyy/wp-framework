<?php
/**
 * SVG Support in attachment modal
 *
 * This file contains functions to manage and manipulate SVG attachments in WordPress.
 * It includes functionality for displaying SVGs in the attachment modal, generating metadata,
 * sanitizing SVG files, and handling specific SVG-related scenarios.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add SVG dimensions and other details to the response for displaying in the attachment modal.
 *
 * @param array $response   The prepared attachment response data.
 * @param object $attachment The attachment object.
 * @param array $meta        The attachment meta data.
 *
 * @return array Modified response with SVG dimensions and URL.
 */
function bodhi_svgs_response_for_svg( $response, $attachment, $meta ) {

	if ( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) {

		$svg_path = get_attached_file( $attachment->ID );

		if ( ! file_exists( $svg_path ) ) {
			// If SVG is external, use the URL instead of the path
			$svg_path = $response['url'];
		}

		$dimensions = bodhi_svgs_get_dimensions( $svg_path );

		$response['sizes'] = array(
			'full' => array(
				'url' => $response['url'],
				'width' => $dimensions->width,
				'height' => $dimensions->height,
				'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
			)
		);

	}

	return $response;

}
add_filter( 'wp_prepare_attachment_for_js', 'bodhi_svgs_response_for_svg', 10, 3 );

/**
 * Get the dimensions of an SVG file.
 *
 * This function checks if the SVG is a local file or a remote URL, retrieves its content, and
 * parses the width and height from the SVG attributes.
 *
 * @param string $svg The file path or URL of the SVG.
 *
 * @return object An object containing the width and height of the SVG.
 */
function bodhi_svgs_get_dimensions( $svg ) {

	$svg_content = '';

	// Check if $svg is a URL or a local file path
	if ( filter_var( $svg, FILTER_VALIDATE_URL ) ) {
		// For remote SVGs, use wp_remote_get()
		$response = wp_remote_get( $svg );
		if ( is_wp_error( $response ) ) {
			return (object) array( 'width' => 0, 'height' => 0 );
		}
		$svg_content = wp_remote_retrieve_body( $response );
	} else {
		// For local files, use WP_Filesystem to read the file content
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		global $wp_filesystem;
		WP_Filesystem();
		$svg_content = $wp_filesystem->get_contents( $svg );
	}

	if ( empty( $svg_content ) ) {
		return (object) array( 'width' => 0, 'height' => 0 );
	}

	$svg = simplexml_load_string( $svg_content );

	if ( $svg === FALSE ) {
		$width = '0';
		$height = '0';
	} else {
		$attributes = $svg->attributes();
		$width = (string) $attributes->width;
		$height = (string) $attributes->height;
	}

	return (object) array( 'width' => $width, 'height' => $height );

}

/**
 * Generate attachment metadata for SVGs. (Thanks @surml)
 *
 * This function generates metadata for SVG attachments, including dimensions and file path.
 * It is used to fix warnings related to missing width and height metadata for SVGs.
 *
 * @param array $metadata       The attachment metadata.
 * @param int   $attachment_id  The attachment ID.
 *
 * @return array Modified metadata including SVG dimensions.
 */
function bodhi_svgs_generate_svg_attachment_metadata( $metadata, $attachment_id ) {

	$mime = get_post_mime_type( $attachment_id );

	if ( $mime == 'image/svg+xml' ) {

		$svg_path = get_attached_file( $attachment_id );
		$upload_dir = wp_upload_dir();
		// Get the path relative to /uploads/
		$relative_path = str_replace($upload_dir['basedir'], '', $svg_path);
		$filename = basename( $svg_path );

		$dimensions = bodhi_svgs_get_dimensions( $svg_path );

		$metadata = array(
			'width'		=> intval($dimensions->width),
			'height'	=> intval($dimensions->height),
			'file'		=> $filename
		);

		$height = intval($dimensions->height);
		$width = intval($dimensions->width);

		// Generate sizes array for future implementations, if needed
		$sizes = array();
		foreach ( get_intermediate_image_sizes() as $s ) {

			$sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => false );

			if ( $width !== 0 && $height !== 0 ) {

				if ( isset( $_wp_additional_image_sizes[$s]['width'] ) ) {
					$width_current_size = intval( $_wp_additional_image_sizes[$s]['width'] );
				} else {
					$width_current_size = get_option( "{$s}_size_w" );
				}

				if ( $width > $height ) {
					$ratio = round($width / $height, 2);
					$new_height = round($width_current_size / $ratio);
				} else {
					$ratio = round($height / $width, 2);
					$new_height = round($width_current_size * $ratio);
				}

				$sizes[$s]['width'] = $width_current_size;
				$sizes[$s]['height'] = $new_height;

				$sizes[$s]['crop'] = false;

			} else {

				if ( isset( $_wp_additional_image_sizes[$s]['width'] ) ) {
					$sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] );
				} else {
					$sizes[$s]['width'] = get_option( "{$s}_size_w" );
				}

				if ( isset( $_wp_additional_image_sizes[$s]['height'] ) ) {
					$sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] );
				} else {
					$sizes[$s]['height'] = get_option( "{$s}_size_h" );
				}

				if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) ) {
					$sizes[$s]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] );
				} else {
					$sizes[$s]['crop'] = get_option( "{$s}_crop" );
				}

			}

			$sizes[$s]['file'] = $filename;
			$sizes[$s]['mime-type'] = 'image/svg+xml';

		}

		$metadata['sizes'] = $sizes;

	}

	return $metadata;

}
add_filter( 'wp_generate_attachment_metadata', 'bodhi_svgs_generate_svg_attachment_metadata', 10, 3 );

/**
 * Sanitize SVG files.
 *
 * This function sanitizes SVG files by removing potentially harmful elements and attributes.
 * It also optionally minifies the SVG content and re-encodes it if it was originally gzipped.
 *
 * @param string $file The file path of the SVG to sanitize.
 *
 * @return bool True if the file was successfully sanitized, false otherwise.
 */
function bodhi_svgs_sanitize( $file ){

	global $sanitizer;

	$sanitizer->setAllowedTags( new bodhi_svg_tags() );
	$sanitizer->setAllowedAttrs( new bodhi_svg_attributes() );

	$dirty = '';

	// Using WP_Filesystem to read the SVG file content
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
	}
	global $wp_filesystem;
	WP_Filesystem();
	$dirty = $wp_filesystem->get_contents( $file );

	// Try to decode if gzipped is enabled
	if ( $is_zipped = bodhi_svgs_is_gzipped( $dirty ) ) {

		$dirty = gzdecode( $dirty );

		// Return on failure, since we can't read file
		if ( $dirty === false ) {
			return false;
		}

	}

	// Remove remote references since they are dangerous and lead to injection
	$sanitizer->removeRemoteReferences(true);

	// Enable minify in library if its enabled in admin panel
	bodhi_svgs_minify();

	$clean = $sanitizer->sanitize( $dirty );

	if ( $clean === false ) {
		return false;
	}

	// If the file was gzipped, we need to re-zip it
	if ( $is_zipped ) {
		$clean = gzencode( $clean );
	}

	// Use WP_Filesystem to write the sanitized content back
	if ( ! $wp_filesystem->put_contents( $file, $clean, FS_CHMOD_FILE ) ) {
		return false;
	}

	return true;

}

/**
 * Enable minification for SVG files.
 *
 * This function enables minification for SVG files if the option is set in the plugin settings.
 */
function bodhi_svgs_minify() {

	global $bodhi_svgs_options;
	global $sanitizer;

	if ( !empty($bodhi_svgs_options['minify_svg']) && $bodhi_svgs_options['minify_svg'] === 'on' ) {
		$sanitizer->minify(true);
	}

}

/**
 * Check if a string is gzipped.
 *
 * @param string $contents The contents to check.
 *
 * @return bool True if the contents are gzipped, false otherwise.
 */
function bodhi_svgs_is_gzipped( $contents ) {

	if ( function_exists( 'mb_strpos' ) ) {
		return 0 === mb_strpos( $contents, "\x1f" . "\x8b" . "\x08" );
	} else {
		return 0 === strpos( $contents, "\x1f" . "\x8b" . "\x08" );
	}

}

// /**
//  * Pre-filter for handling SVG uploads.
//  *
//  * This function checks if the uploaded file is an SVG and applies sanitization if required.
//  *
//  * @param array $file The uploaded file data.
//  *
//  * @return array The modified file data.
//  */
// function bodhi_svgs_sanitize_svg($file) {
// 	global $bodhi_svgs_options;

// 	$file_path = $file['tmp_name'];
// 	$file_name = $file['name'];

// 	// Check if the file has a .svg extension
// 	$is_svg_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)) === 'svg';

// 	// Check if the file contains SVG content
// 	$is_svg_content = false;
// 	if ($is_svg_extension && file_exists($file_path)) {
// 		// Use file_get_contents to read the file contents
// 		$file_content = file_get_contents($file_path);

// 		if ($file_content === false) {
// 			$file['error'] = __("There was an error reading the SVG file for sanitization.", 'svg-support');
// 			return $file;
// 		}

// 		$is_svg_content = preg_match('/<svg[^>]*xmlns="http:\/\/www\.w3\.org\/2000\/svg"/', $file_content);
// 	}

// 	// If the file is an SVG based on extension or content
// 	if ($is_svg_extension || $is_svg_content) {
// 		// Get the roles that do not require SVG sanitization
// 		$sanitize_on_upload_roles_array = (array) $bodhi_svgs_options['sanitize_on_upload_roles'];
// 		$user = wp_get_current_user();
// 		$current_user_roles = (array) $user->roles;

// 		// Check if the current user's roles intersect with the roles that do not need sanitization
// 		$no_sanitize_needed = array_intersect($sanitize_on_upload_roles_array, $current_user_roles);

// 		// Check if the user has the capability to upload SVGs
// 		$can_upload_files = current_user_can('upload_files');

// 		// Force sanitize unless user is in roles that bypass sanitization
// 		if ($can_upload_files && empty($no_sanitize_needed)) {
// 			if (!bodhi_svgs_sanitize($file_path)) {
// 				$file['error'] = __("Sorry, this file couldn't be sanitized for security reasons and wasn't uploaded.", 'svg-support');
// 				return $file;
// 			}
// 		}

// 		return $file;
// 	}

// 	return $file;
// }
// // Add filter to handle upload pre-filtering for sanitization
// add_filter('wp_handle_upload_prefilter', 'bodhi_svgs_sanitize_svg');

/**
 * Pre-filter for handling SVG uploads.
 *
 * This function checks if the uploaded file is an SVG and applies sanitization if required.
 *
 * @param array $file The uploaded file data.
 *
 * @return array The modified file data.
 */
function bodhi_svgs_sanitize_svg($file) {
	global $bodhi_svgs_options;

	$file_path = $file['tmp_name'];
	$file_name = $file['name'];

	// Check if the file has a .svg extension
	$is_svg_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)) === 'svg';

	// Check if the file contains SVG content
	$is_svg_content = false;
	if ($is_svg_extension && file_exists($file_path)) {
		// Check if the file is remote or local
		if (filter_var($file_path, FILTER_VALIDATE_URL)) {
			// For remote files, use wp_remote_get
			$response = wp_remote_get($file_path);
			if (is_wp_error($response)) {
				$file['error'] = __("There was an error reading the SVG file for sanitization.", 'svg-support');
				return $file;
			}
			$file_content = wp_remote_retrieve_body($response);
		} else {
			// For local files, use WP_Filesystem
			if (!function_exists('WP_Filesystem')) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			global $wp_filesystem;
			WP_Filesystem();
			$file_content = $wp_filesystem->get_contents($file_path);
		}

		if ($file_content === false || empty($file_content)) {
			$file['error'] = __("There was an error reading the SVG file for sanitization.", 'svg-support');
			return $file;
		}

		$is_svg_content = preg_match('/<svg[^>]*xmlns="http:\/\/www\.w3\.org\/2000\/svg"/', $file_content);
	}

	// If the file is an SVG based on extension or content
	if ($is_svg_extension || $is_svg_content) {
		// Get the roles that do not require SVG sanitization
		$sanitize_on_upload_roles_array = (array) $bodhi_svgs_options['sanitize_on_upload_roles'];
		$user = wp_get_current_user();
		$current_user_roles = (array) $user->roles;

		// Check if the current user's roles intersect with the roles that do not need sanitization
		$no_sanitize_needed = array_intersect($sanitize_on_upload_roles_array, $current_user_roles);

		// Check if the user has the capability to upload SVGs
		$can_upload_files = current_user_can('upload_files');

		// Force sanitize unless user is in roles that bypass sanitization
		if ($can_upload_files && empty($no_sanitize_needed)) {
			if (!bodhi_svgs_sanitize($file_path)) {
				$file['error'] = __("Sorry, this file couldn't be sanitized for security reasons and wasn't uploaded.", 'svg-support');
				return $file;
			}
		}

		return $file;
	}

	return $file;
}
// Add filter to handle upload pre-filtering for sanitization
add_filter('wp_handle_upload_prefilter', 'bodhi_svgs_sanitize_svg');

/**
 * Fix for image widget PHP warnings related to metadata.
 *
 * @param array $data The attachment metadata.
 *
 * @return array|false The modified metadata or false if invalid.
 */
function bodhi_svgs_get_attachment_metadata( $data ) {

	$res = $data;

	if ( !isset( $data['width'] ) || !isset( $data['height'] ) ) {
		$res = false;
	}

	return $res;

}
// add_filter( 'wp_get_attachment_metadata' , 'bodhi_svgs_get_attachment_metadata' );
// Commented this out 20200307 because it was stripping metadata from other attachments as well. Need to make this target only SVG attachments.

/**
 * Remove srcset attribute for SVG images.
 *
 * @param array $sources The sources array for the image.
 *
 * @return array The modified sources array.
 */
function bodhi_svgs_disable_srcset( $sources ) {

	$first_element = reset($sources);
	if ( isset($first_element) && !empty($first_element['url']) ) {

		$ext = pathinfo(reset($sources)['url'], PATHINFO_EXTENSION);

		if ( $ext == 'svg' ) {

			// return empty array
			$sources = array();

			return $sources;

		} else {

			return $sources;

		}

	} else {

		return $sources;

	}

}
add_filter( 'wp_calculate_image_srcset', 'bodhi_svgs_disable_srcset' );

/**
 * Fix for division by zero error for SVGs. (Proposed by @starsis)
 *
 * This function ensures that SVGs do not cause division by zero errors by providing default
 * dimensions if they are missing.
 *
 * @param array  $image         The image data.
 * @param int    $attachment_id The attachment ID.
 * @param string $size          The requested image size.
 * @param bool   $icon          Whether the image is an icon.
 *
 * @return array The modified image data.
 */
function bodhi_svgs_dimension_fallback( $image, $attachment_id, $size, $icon ) {

	// only manipulate for svgs
	if ( get_post_mime_type($attachment_id) == 'image/svg+xml' ) {

		if ( isset($image[1]) && $image[1] === 0 ) {
			$image[1] = 1;
		}
		if ( isset($image[2]) && $image[2] === 0 ) {
			$image[2] = 1;
		}

	}

	return $image;

}
add_filter( 'wp_get_attachment_image_src', 'bodhi_svgs_dimension_fallback', 10, 4 );