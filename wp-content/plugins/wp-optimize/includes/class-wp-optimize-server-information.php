<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Server_Information')) :

class WP_Optimize_Server_Information {

	/**
	 * Use WordPress core debug data helper
	 *
	 * @return array
	 */
	public function get_wp_debug_data() {
		if (!class_exists('WP_Debug_Data')) {
			if (!is_readable(ABSPATH.'wp-admin/includes/class-wp-debug-data.php')) {
				return array(
					'data' => array(
						'label' => esc_html__('Please note that WordPress health information, including details about installed plugins and installation data, is only available from version 5.2 onwards.', 'wp-optimize'). ' ' . esc_html__('We recommend updating your WordPress version.', 'wp-optimize')
					)
				);
			}
			
			require_once(ABSPATH.'wp-admin/includes/class-wp-debug-data.php');
		}

		return WP_Debug_Data::debug_data();
	}

	/**
	 * Retrieve WPO cache size
	 *
	 * @return array
	 */
	public function get_cache_size() {
		return WP_Optimize()->get_page_cache()->get_cache_size();
	}

	/**
	 * Retrieve WPO generated minify files and size
	 *
	 * @return string
	 */
	public function get_minify_size() {
		$wpo_minify_options = wp_optimize_minify_config()->get();
		if (!$wpo_minify_options['enabled']) return '';

		$cache_path = WP_Optimize_Minify_Cache_Functions::cache_path();
		return WP_Optimize_Minify_Cache_Functions::get_cachestats($cache_path['cachedir']);
	}

	/**
	 * Get logs and their sizes
	 *
	 * @return array
	 */
	public function get_logs_summary() {
		$sizes = $this->get_logs(true);

		$result = array();
		foreach ($sizes as $filename => $filesize) {
			$result[] = $filename . ': ' . size_format($filesize);
		}

		return $result;
	}

	/**
	 * Look around for WPO logs and fetch the content
	 *
	 * @param bool $paths_only Don't include the file contents in the response, just the file size
	 * @return array
	 */
	public function get_logs($paths_only = false) {
		$upload_base = WP_Optimize_Utils::get_log_folder_path();
		
		$cache_path = WP_Optimize_Minify_Cache_Functions::cache_path();

		$log_file_patterns = array(
			$upload_base => array(
				'.*\.log$'
			),
			$cache_path['cachedir'] => array(
				'.*\.json$'
			)
		);
		
		$log_data = array();

		foreach ($log_file_patterns as $path => $patterns) {
			$files = $this->scandir($path);
			foreach ($files as $file_full_path) {
				foreach ($patterns as $pattern) {
					$file = basename($file_full_path);
					if (preg_match('|' . $pattern . '|', $file) && is_file($file_full_path)) {
						$log_data[$file] = (true === $paths_only) ? filesize($file_full_path) : file_get_contents($file_full_path);
					}
				}
			}
		}

		return $log_data;
	}

	/**
	 * Retrieve WPO cache configuration
	 *
	 * @return array
	 */
	public function get_cache_config() {
		return WPO_Cache_Config::instance()->get();
	}

	/**
	 * Read main .htaccess file
	 *
	 * @return string
	 */
	public function get_webroot_htaccess() {
		$file = trailingslashit(ABSPATH) . '.htaccess';
		if (!is_readable($file)) return '';

		return trim(file_get_contents($file));
	}

	/**
	 * Read uploads dir .htaccess file
	 *
	 * @return string
	 */
	public function get_upload_dir_htaccess() {
		$uploads_dir = wp_get_upload_dir();
		$file = trailingslashit($uploads_dir['basedir']) . '.htaccess';

		if (!is_readable($file)) return '';
		
		return trim(file_get_contents($file));
	}

	/**
	 * Iterate on uploads dir and read directories permissions
	 *
	 * @return array
	 */
	public function get_uploads_dir_permissions() {
		$uploads_dir = wp_get_upload_dir();
		if (!isset($uploads_dir['basedir']) || !is_dir($uploads_dir['basedir'])) {
			return array();
		}

		$return = array(
			'uploads' => decoct(fileperms($uploads_dir['basedir']) & 0777)
		);

		$uploads_content = $this->scandir($uploads_dir['basedir']);
		
		foreach ($uploads_content as $element) {
			if (is_dir($element)) {
				$return['uploads/' . basename($element)] = decoct(fileperms($element) & 0777);
			}
		}

		return $return;
	}

	/**
	 * Inspect directory with opendir, since glob might not be available in some systems
	 *
	 * @param string $path The actual path to scan
	 * @return array
	 */
	private function scandir($path) {
		$content = array();

		clearstatcache();
		if (is_dir($path.'/') && ($handle = @opendir($path.'/'))) { // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress PHP warning in case of failure
			while (false !== ($file = readdir($handle))) {
				if ("." === $file || ".." === $file) continue;

				$content[] = trailingslashit($path) . $file;
			}
			closedir($handle);
		}
		
		return $content;
	}
	
	/**
	 * Retrieve status of WebP redirection
	 *
	 * @return bool|null
	 */
	public function webp_redirection_status() {
		$webp = WP_Optimize_WebP::get_instance();
		$enabled = $webp->is_webp_enabled();
		if (!$enabled) return false;

		$is_possible = $webp->is_webp_redirection_possible();
		
		return $is_possible ? true : null;
	}
}

endif;
