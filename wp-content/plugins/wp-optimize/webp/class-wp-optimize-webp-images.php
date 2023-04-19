<?php
if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_WebP_Images')) :

class WP_Optimize_WebP_Images {

	private $directory = '';

	private $filename = '';

	private $original_extension = '';

	private $webp_extension = '.webp';

	private $meta = false;

	private $sizes = array();

	private $images = array();

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action('delete_attachment', array($this, 'delete_related_images'), 10, 1);
	}

	/**
	 * Returns singleton instance
	 *
	 * @return WP_Optimize_WebP_Images
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new WP_Optimize_WebP_Images();
		}
		return $instance;
	}

	/**
	 * Deletes related image sizes and alternate webp format images
	 *
	 * @param int $attachment_id
	 * @return void
	 */
	public function delete_related_images($attachment_id) {
		$this->set_meta($attachment_id);
		$this->set_file_info_properties($attachment_id);
		$this->set_sizes();
		$this->set_images();
		$this->delete_images();
		$this->reset();
	}

	/**
	 * Sets meta property with attachment metadata
	 *
	 * @param int $attachment_id
	 * @return void
	 */
	private function set_meta($attachment_id) {
		$this->meta = wp_get_attachment_metadata($attachment_id);
	}

	/**
	 * Sets file information properties
	 *
	 * @param int $attachment_id
	 * @return void
	 */
	private function set_file_info_properties($attachment_id) {
		$file_path = get_attached_file($attachment_id);
		$file_path_info = pathinfo($file_path);
		$this->filename = $file_path_info['filename'];
		$this->original_extension = '.' . $file_path_info['extension'];

		$file = isset($this->meta['file']) ? $this->meta['file'] : '';
		$basename = $file_path_info['basename'];
		$sub_directory = '';
		if (!empty($file)) {
			$sub_directory = str_replace($basename, '', $file);
		}

		$uploads = wp_get_upload_dir();
		$this->directory = $uploads['basedir'] . '/' . $sub_directory;
	}

	/**
	 * Returns all available image sizes for the given attachment id
	 */
	private function set_sizes() {
		if (false !== $this->meta) {
			$this->sizes = isset($this->meta['sizes']) ? $this->meta['sizes'] : array();
		}
	}

	/**
	 * Sets images property
	 *
	 * @return void
	 */
	private function set_images() {
		$webp_format = $this->directory . $this->filename . $this->original_extension . $this->webp_extension;
		$this->images[] = $webp_format;

		foreach ($this->sizes as $size) {
			$original_format = $this->directory . $this->filename . '-' . $size['width'] . 'x' . $size['height'] . $this->original_extension;
			$this->images[] = $original_format;
			$webp_format = $this->directory . preg_replace('/-scaled$/', '', $this->filename) . '-' . $size['width'] . 'x' . $size['height'] . $this->original_extension . $this->webp_extension;
			$this->images[] = $webp_format;
		}

	}

	/**
	 * Delete related images
	 *
	 * @return void
	 */
	private function delete_images() {
		foreach ($this->images as $image) {
			wp_delete_file($image);
		}
	}

	/**
	 * Reset class property values
	 */
	private function reset() {
		$this->directory = '';
		$this->filename = '';
		$this->original_extension = '';
		$this->meta = false;
		$this->sizes = array();
		$this->images = array();
	}
}

endif;
