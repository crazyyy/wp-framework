<?php

if (!defined('ABSPATH')) die('Access denied.');

if (!class_exists('WPO_Image_Utils')) :

class WPO_Image_Utils {

	/**
	 * Get image paths to resized attachment images.
	 *
	 * @param int $attachment_id
	 * @return array
	 */
	public static function get_attachment_files($attachment_id) {
		$attachment_images = array();
		$upload_dir = wp_get_upload_dir();

		// get sizes info from attachment meta data.
		$meta = wp_get_attachment_metadata($attachment_id);
		if (!is_array($meta) || !array_key_exists('sizes', $meta)) return $attachment_images;

		$image_sizes = array_keys($meta['sizes']);

		// build list of resized images.
		foreach ($image_sizes as $size) {
			$image = image_get_intermediate_size($attachment_id, $size);

			if (is_array($image)) {
				$file = trailingslashit($upload_dir['basedir']) . $image['path'];
				if (is_file($file) && !in_array($file, $attachment_images)) {
					$attachment_images[$size] = $file;
				}
			}
		}

		return $attachment_images;
	}

	/**
	 * Returns an array of allowed extensions
	 *
	 * @return array
	 */
	public static function get_allowed_extensions() {
		return array('gif', 'jpeg', 'jpg', 'png');
	}

	/**
	 * Returns given file extension
	 *
	 * @param string $file
	 *
	 * @return mixed
	 */
	public static function get_extension($file) {
		$file_type = wp_check_filetype($file);
		return $file_type['ext'];
	}

	/**
	 * Tests if given extension is present in allowed extensions array
	 *
	 * @param string $ext                Extension to check
	 * @param array $allowed_extensions Array of allowed extensions
	 *
	 * @return bool
	 */
	public static function is_supported_extension($ext, $allowed_extensions) {
		return in_array($ext, $allowed_extensions);
	}
}

endif;
