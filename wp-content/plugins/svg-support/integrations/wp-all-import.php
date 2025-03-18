<?php
/**
 * Integration with WP All Import for processing SVG files.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Hook into WP All Import to process SVG files correctly.
 *
 * @param int $attachment_id The ID of the uploaded attachment.
 */
function bodhi_svgs_wpallimport_handle_svg( $attachment_id ) {
	// Get the file path of the uploaded attachment.
	$file_path = get_attached_file( $attachment_id );
	$file_mime = get_post_mime_type( $attachment_id );

	// Check if the file is an SVG.
	if ( $file_mime === 'image/svg+xml' ) {
		// Sanitize the SVG file.
		if ( ! bodhi_svgs_sanitize_svg_on_import( $file_path ) ) {
			// Log the error without deleting the attachment.
			// error_log( sprintf( 'SVG Sanitization failed for attachment ID %d during WP All Import.', $attachment_id ) );
		}

		// Generate attachment metadata for the SVG.
		$metadata = wp_generate_attachment_metadata( $attachment_id, $file_path );
		if ( ! empty( $metadata ) ) {
			if ( ! wp_update_attachment_metadata( $attachment_id, $metadata ) ) {
				// error_log( sprintf( 'Failed to update metadata for SVG attachment ID %d during WP All Import.', $attachment_id ) );
			}
		} else {
			// error_log( sprintf( 'Failed to generate metadata for SVG attachment ID %d during WP All Import.', $attachment_id ) );
		}
	}
}

/**
 * This function handles sanitization and any other processing needed for SVG files.
 *
 * @param string $file_path The file path of the SVG to be processed.
 * @return bool True if sanitization was successful, false otherwise.
 */
function bodhi_svgs_sanitize_svg_on_import( $file_path ) {
	// Check if the SVG file exists and is valid.
	if ( file_exists( $file_path ) && is_readable( $file_path ) ) {
		// Use the existing sanitize function.
		if ( bodhi_svgs_sanitize( $file_path ) ) {
			// Recalculate dimensions and regenerate metadata.
			$dimensions = bodhi_svgs_get_dimensions( $file_path );
			$metadata = array(
				'width'  => intval( $dimensions->width ),
				'height' => intval( $dimensions->height ),
				'file'   => basename( $file_path ),
			);
			return true;
		} else {
			// error_log( sprintf( 'Sanitization failed for SVG file at path %s.', $file_path ) );
			return false;
		}
	}

	// error_log( sprintf( 'SVG file at path %s is either missing or not readable.', $file_path ) );
	return false;
}

// Hook the function into WP All Import's `pmxi_attachment_uploaded`.
add_action( 'pmxi_attachment_uploaded', 'bodhi_svgs_wpallimport_handle_svg' );