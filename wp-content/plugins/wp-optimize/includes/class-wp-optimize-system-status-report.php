<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_System_Status_Report')) :

class WP_Optimize_System_Status_Report {
	
	/**
	 * @var WP_Optimize_Server_Information
	 */
	private $server_info_util;

	/**
	 * @var array
	 */
	private $replaceable_md_tags = array();
	
	/**
	 * Constructor
	 */
	private function __construct() {
		$this->server_info_util = new WP_Optimize_Server_Information();
	}
	
	/**
	 * Returns singleton instance
	 *
	 * @return WP_Optimize_System_Status_Report
	 */
	public static function get_instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}
	
	/**
	 * Fill the report with actual data
	 *
	 * @return array
	 */
	private function generate_wpo_report() {
		$report_format = $this->get_report_format();
		$report_data = array();
		foreach ($report_format as $block) {
			$piece = array(
				'title' => $block['title'],
				'items' => array()
			);

			foreach ($block['items'] as $part_index => $part) {
				$piece['items'][$part_index]['title'] = $part['title'];
				$piece['items'][$part_index]['value'] = isset($part['value']) ? $part['value'] : '';

				if (isset($part['markdown_value'])) {
					$piece['items'][$part_index]['markdown_value'] = $part['markdown_value'];
				}
			}

			$report_data[] = $piece;
		}
		
		return $report_data;
	}

	/**
	 * Define the report format
	 *
	 * @return array
	 */
	private function get_report_format() {
		$report = array(
			array(
				'title' => esc_html__('WP-Optimize information', 'wp-optimize'),
				'items' => array(
					array(
						'title' => esc_html__('Report generation time', 'wp-optimize'),
						'value' => esc_html($this->generation_time())
					),
					array(
						'title' => esc_html__('Cache size', 'wp-optimize'),
						'value' => $this->cache_size(),
					),
					array(
						'title' => esc_html__('Minify size', 'wp-optimize'),
						'value' => $this->minify_size(),
					),
					array(
						'title' => esc_html__('Logs', 'wp-optimize'),
						'value' => $this->logs(),
						'markdown_value' => $this->plain_log_debug()
					),
					array(
						'title' => esc_html__('WebP redirection rules', 'wp-optimize'),
						'value' => $this->webp_redirect_status(),
					),
					array(
						'title' => esc_html__('Plugin settings', 'wp-optimize'),
						'value' => $this->settings_container(),
						'markdown_value' => '{{[wpo-general-settings]}}'
					),
					array(
						'title' => esc_html__('Cache settings', 'wp-optimize'),
						'value' => $this->cache_settings(),
						'markdown_value' => $this->cache_settings(false)
					),
					array(
						'title' => esc_html__('Webroot .htaccess', 'wp-optimize'),
						'value' => $this->webroot_htaccess(),
						'markdown_value' => $this->webroot_htaccess(false),
					),
					array(
						'title' => esc_html__('Uploads .htaccess', 'wp-optimize'),
						'value' => $this->uploads_htaccess(),
						'markdown_value' => $this->uploads_htaccess(false),
					),
					array(
						'title' => esc_html__('Folder permissions', 'wp-optimize'),
						'value' => $this->path_perms(),
						'markdown_value' => $this->path_perms(false),
					),
				)
			),
		);

		return $report;
	}
	
	/**
	 * Some WordPress Core Health report fields are loaded via AJAX after page render (ex: directory sizes), these field names are used as tags in JS to replace inside the plaintext report.
	 * This function is a getter for the list that has been set while parsing WP core health report
	 *
	 * @return array
	 */
	public function get_replaceable_md_tags() {
		return $this->replaceable_md_tags;
	}
	
	/**
	 * Generate WPO report and merge with WP code report
	 *
	 * @return array
	 */
	public function generate_report() {
		return array_merge($this->generate_wpo_report(), $this->get_wp_health_report());
	}

	/**
	 * Get debug information from WordPress core
	 *
	 * @return array
	 */
	private function get_wp_health_report() {
		$report = array();
		$core_data = $this->server_info_util->get_wp_debug_data();
		foreach ($core_data as $data_idx => $data) {
			$block = array(
				'title' => $data['label'],
				'items' => array()
			);

			if (!isset($data['fields'])) {
				$report[] = $block;
				continue;
			}

			foreach ($data['fields'] as $fieldname => $info) {
				$path_size_field_id = 'wp-paths-sizes' === $data_idx ? $data_idx . '-' . $fieldname : null;

				$row = array();

				$ajax_field_class = null;
				if (isset($info['debug']) && ('loading...' === $info['debug']) && !is_null($path_size_field_id)) {
					$replaceable_tag = '{{[' . $path_size_field_id . ']}}';

					// Collect the tags that will need to be replaced after page render via Ajax requests to WP api
					$this->replaceable_md_tags[$fieldname] = $replaceable_tag;

					$row['markdown_value'] = $replaceable_tag;
					$ajax_field_class = $data_idx;
				}
				
				$row['title'] = $this->fix_title_case($info['label']);
				$row['value'] = $this->ajax_value_container($info['value'], $path_size_field_id, $ajax_field_class);

				$block['items'][] = $row;
			}

			$report[] = $block;
		}

		return $report;
	}

	/**
	 * Hard fix title issue
	 *
	 * @param string $title Original title
	 * @return string
	 */
	private function fix_title_case($title) {
		return str_replace('Site Language', 'Site language', $title);
	}

	/**
	 * Give format to cache size information
	 *
	 * @return string
	 */
	private function cache_size() {
		$data = $this->server_info_util->get_cache_size();
		$size = size_format($data['size']);
		if (false === $size) {
			return esc_html__('Not available', 'wp-optimize');
		}
		// translators: %d represents the number of files.
		return esc_html($size) . ' ' . sprintf(esc_html__('(%d files)', 'wp-optimize'), $data['file_count']);
	}

	/**
	 * Grab minify size from information object
	 *
	 * @return string
	 */
	private function minify_size() {
		$data = $this->server_info_util->get_minify_size();
		if (empty($data)) {
			return esc_html__('Not available', 'wp-optimize');
		}
		return esc_html($data);
	}

	/**
	 * Give link for user to download logs in a zip file
	 *
	 * @return string
	 */
	private function logs() {
		$data = $this->server_info_util->get_logs_summary();
		if (0 === count($data)) {
			return esc_html__('No log files found', 'wp-optimize');
		}
		return '<button id="wpo-download-logs" class="button-primary">' . esc_html__('Download logs', 'wp-optimize') . '</button><span id="wpo-generate-zip-file-text"></span>' . $this->pre_container(implode("\n", $data));
	}

	/**
	 * Just show log data, no button
	 *
	 * @return string
	 */
	private function plain_log_debug() {
		$data = $this->server_info_util->get_logs_summary();

		if (0 < count($data)) {
			return "\n" . '    - ' . implode("\n    - ", $data);
		}
		return esc_html__('No log files found', 'wp-optimize');
	}

	/**
	 * Empty placeholder for plugin settings, that will be filled using `WP_Optimize().build_settings()`
	 *
	 * @return string
	 */
	private function settings_container() {
		return $this->pre_container('', 'wpo-general-settings');
	}

	/**
	 * Cache settings into preformatted HTML container
	 *
	 * @param bool $preformat_container Enclose the value inside a <pre> tag
	 * @return string
	 */
	private function cache_settings($preformat_container = true) {
		$config = $this->server_info_util->get_cache_config();

		if (isset($config['wp_salt_auth'])) {
			$config['wp_salt_auth'] = '*****';
		}
		if (isset($config['wp_salt_logged_in'])) {
			$config['wp_salt_logged_in'] = '*****';
		}

		$json = json_encode($config, JSON_PRETTY_PRINT);
		return $preformat_container ? $this->pre_container($json) : $json;
	}

	/**
	 * Grab .htaccess contents in webroot
	 *
	 * @param bool $preformat_container Enclose the value inside a <pre> tag
	 * @return string
	 */
	private function webroot_htaccess($preformat_container = true) {
		$content = $this->server_info_util->get_webroot_htaccess();
		if ('' !== $content) {
			return $preformat_container ? $this->pre_container($content) : $content;
		}
		return esc_html__('Not found or not readable', 'wp-optimize');
	}

	/**
	 * Grab .htaccess contents in uploads folder
	 *
	 * @param bool $preformat_container Enclose the value inside a <pre> tag
	 * @return string
	 */
	private function uploads_htaccess($preformat_container = true) {
		$content = $this->server_info_util->get_upload_dir_htaccess();
		if ('' !== $content) {
			return $preformat_container ? $this->pre_container($content) : $content;
		}
		return esc_html__('Not found or not readable', 'wp-optimize');
	}

	/**
	 * Helper to generate a preformatted HTML tag with contents and optional id
	 *
	 * @param string $content The innerHTML for the tag
	 * @param string $id      Optional DOM id attribute
	 * @return string
	 */
	private function pre_container($content, $id = '') {
		return '<div class="wpo-settings-debug"><pre' . ('' !== $id ? ' id="' . esc_attr($id) .'"' : '') . '>' . esc_html($content) . '</pre></div>';
	}

	/**
	 * Show information about directories permissions
	 *
	 * @param bool $preformat_container Enclose the value inside a <pre> tag
	 * @return string
	 */
	private function path_perms($preformat_container = true) {
		$json = json_encode($this->server_info_util->get_uploads_dir_permissions(), JSON_PRETTY_PRINT);
		return $preformat_container ? $this->pre_container($json) : $json;
	}

	/**
	 * Information about WebP image redirection status
	 *
	 * @return string
	 */
	private function webp_redirect_status() {
		$result = $this->server_info_util->webp_redirection_status();

		if (null === $result) {
			return esc_html__('Redirection is not available', 'wp-optimize');
		} elseif (false === $result) {
			return esc_html__('Redirection is disabled', 'wp-optimize');
		}
		return esc_html__('Redirection is enabled', 'wp-optimize');
	}

	/**
	 * Prepare complex item (asynx loading) as a label HTML tag that will be replaced with JS code (ex. directories sizes from core-site-health API call)
	 *
	 * @param string|array $value              If array, it will be JSON encoded inside a preformatted HTML tag
	 * @param string|null  $id                 If not null, it is used as the label id property. If null, there will be no label, just value
	 * @param string|null  $dynamic_field_type If not null, a css class is used to be able to catch these fields when the call is done
	 * @return string
	 */
	private function ajax_value_container($value, $id, $dynamic_field_type) {
		if (is_array($value)) {
			$value = '<pre>' . json_encode($value, JSON_PRETTY_PRINT) . '</pre>';
		} else {
			$value = esc_html($value);
		}

		if (is_null($id)) {
			return $value;
		}

		$css_class = null !== $dynamic_field_type ? 'wpo-ajax-field-' . esc_attr($dynamic_field_type) : '';
		return '<label class="' . $css_class . '" id="' . esc_attr('wpo-value-' . $id) . '">' . esc_html($value) . '</label>';
	}

	/**
	 * Add timestamp to report information
	 *
	 * @return string
	 */
	private function generation_time() {
		$timezone = wp_timezone_string();

		return date_i18n('Y-m-d H:i:s', current_datetime()->getTimestamp()) . ('' !== $timezone ? ' (' . $timezone . ')' : '');
	}
}

endif;
