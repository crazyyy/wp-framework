<?php
/**
 * Add SVG mime types to WordPress
 *
 * Allows you to upload SVG files to the media library like any other image.
 * Additionally provides a fix for WP 4.7.1 - 4.7.2 upload issues and for Avada theme.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Add Mime Types
 */
function bodhi_svgs_upload_mimes( $mimes = array() ) {
    global $bodhi_svgs_options;

    // Ensure the option is set
    if ( !isset($bodhi_svgs_options['restrict']) ) {
        return $mimes;
    }

    // Get the allowed roles from settings
    $allowed_roles_array = (array) $bodhi_svgs_options['restrict'];
    
    // Get the current user and their roles
    $user = wp_get_current_user();
    $current_user_roles = ( array ) $user->roles;

    // Check if the user has the capability or the role
    $is_role_allowed = array_intersect($allowed_roles_array, $current_user_roles);
    if ( empty($is_role_allowed) || !current_user_can('upload_files') ) {
        return $mimes;
    }

    // Allow SVG file upload
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'bodhi_svgs_upload_mimes', 99 );

/**
 * Check Mime Types
 */
function bodhi_svgs_upload_check( $checked, $file, $filename, $mimes ) {

    if ( ! $checked['type'] ) {

        $check_filetype = wp_check_filetype( $filename, $mimes );
        $ext = $check_filetype['ext'];
        $type = $check_filetype['type'];
        $proper_filename = $filename;

        // Check if the file is an SVG or SVGZ
        if ( ( $ext === 'svg' || $ext === 'svgz' ) && $type === 'image/svg+xml' ) {
            $checked = compact( 'ext', 'type', 'proper_filename' );
        }
    }

    return $checked;
}
add_filter( 'wp_check_filetype_and_ext', 'bodhi_svgs_upload_check', 10, 4 );


/**
 * Mime Check fix for WP 4.7.1 / 4.7.2
 *
 * Fixes uploads for these 2 versions of WordPress.
 * Issue was fixed in 4.7.3 core.
 */
function bodhi_svgs_allow_svg_upload( $data, $file, $filename, $mimes ) {

	global $wp_version;
	// Corrected the version check condition
	if ( version_compare($wp_version, '4.7.1', '>=') && version_compare($wp_version, '4.7.3', '<') ) {
		$filetype = wp_check_filetype( $filename, $mimes );

		// Check if the file is an SVG or SVGZ
		if ( ( $filetype['ext'] === 'svg' || $filetype['ext'] === 'svgz' ) && $filetype['type'] === 'image/svg+xml' ) {
			return [
				'ext'             => $filetype['ext'],
				'type'            => $filetype['type'],
				'proper_filename' => $data['proper_filename']
			];
		}
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'bodhi_svgs_allow_svg_upload', 10, 4 );