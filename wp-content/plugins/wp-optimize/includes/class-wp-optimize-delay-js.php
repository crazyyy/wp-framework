<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_Delay_JS')) :
/**
 * Class WP_Optimize_Delay_JS
 */
class WP_Optimize_Delay_JS {

	/**
	 * @var array $options Options or settings related to delaying JavaScript execution.
	 */
	private $options;

	/**
	 * Constructor method.
	 *
	 * @return void
	 */
	private function __construct() {
		$this->options = wp_optimize_minify_config()->get();
		if ($this->should_process()) {
			$this->process();
		}
	}

	/**
	 * Returns singleton instance object
	 *
	 * @return WP_Optimize_Delay_JS
	 */
	public static function instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}
	
	/**
	 * If JavaScript optimizations are enabled and delay or preload JavaScript is enabled, process the output.
	 *
	 * @return bool
	 */
	private function should_process(): bool {
		return $this->options['enabled'] && $this->options['enable_js'] && ($this->is_delay_js_enabled() || $this->is_preload_js_enabled()) && !$this->is_edit_mode();
	}

	/**
	 * Main processing function to manage JavaScript optimizations.
	 *
	 * @return void
	 */
	private function process() {
		add_action('template_redirect', array($this, 'start_buffering'));
		if ($this->is_delay_js_enabled()) {
			$this->register_callback_to_output_delay_js_script();
		}
	}
	
	/**
	 * Start output buffering with callback to optimize the content for delaying JavaScript execution.
	 *
	 * @return void
	 */
	public function start_buffering() {
		static $registered = false;
		
		if (!$registered) {
			ob_start(array($this, 'optimize_buffered_content_for_delaying_js_execution'));
			$registered = true;
		}
	}
	
	/**
	 * A callback function that replaces script tags to make them delayable when the Delay JS option is enabled,
	 * and generates a list of tags to preload scripts when the Preload JavaScript Files option is enabled.
	 *
	 * @param string $content The content to be processed.
	 * @return string The modified content.
	 */
	private function optimize_buffered_content_for_delaying_js_execution($content) {
		$content = $this->maybe_preload_js($content);
		return $this->maybe_delay_js($content);
	}
	
	/**
	 * Adds actions to preload JavaScript if the feature is enabled.
	 *
	 * @param string $content
	 * @return string
	 */
	private function maybe_preload_js($content) {
		if ($this->is_preload_js_enabled()) {
			$content = $this->preload_js($content);
		}
		return $content;
	}
	
	/**
	 * Check if Preload JS is enabled.
	 *
	 * @return bool
	 */
	private function is_preload_js_enabled() {
		return $this->options['enable_preload_js'];
	}
	
	/**
	 * Updates the content to add preload tags.
	 *
	 * @param string $content
	 * @return string
	 */
	private function preload_js($content) {
		$pattern = $this->get_scripts_pattern();
		$scripts = array();
		preg_match_all($pattern, $content, $matches);
		foreach ($matches[1] as $attributes_string) {
			$attributes = WP_Optimize_Utils::parse_attributes($attributes_string);
			if (!empty($attributes['src']) && !$this->is_excluded_script($attributes['src'])) {
				$scripts[] = $attributes['src'];
			}
		}
		
		$updated_content = preg_replace('/\<(head)\>/i', "<$1>\n".$this->generate_preload_scripts_tags($scripts), $content, 1);
		if (!is_null($updated_content)) {
			$content = $updated_content;
		}
		return $content;
	}
	
	/**
	 * Adds actions to delay JavaScript execution if the feature is enabled.
	 *
	 * @param string $content
	 * @return string
	 */
	private function maybe_delay_js($content) {
		
		if ($this->is_delay_js_enabled()) {
			$content = $this->delay_js($content);
		}

		return $content;
	}
	
	/**
	 * Check if Delay JS is enabled.
	 *
	 * @return bool
	 */
	private function is_delay_js_enabled() {
		return $this->options['enable_delay_js'];
	}
	
	/**
	 * Updates the content to delay JavaScript execution.
	 *
	 * @param string $content
	 * @return string
	 */
	private function delay_js($content) {
		$pattern = $this->get_scripts_pattern();
		$updated_content = preg_replace_callback($pattern, array($this, 'update_script_tags_callback'), $content);
		if (!is_null($updated_content)) {
			$content = $updated_content;
		}

		return $content;
	}



	/**
	 * Output the Delay JS Script.
	 *
	 * @return void
	 */
	public function output_delay_js_script() {
		$min_or_not_internal = WP_Optimize()->get_min_or_not_internal_string();
		echo '<script data-no-delay-js>';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- we don't need to escape inline scripts
		echo file_get_contents(WPO_PLUGIN_MAIN_PATH . 'js/delay-js' . $min_or_not_internal . '.js');
		echo '</script>';
	}

	/**
	 * Retrieve the list of excluded scripts from the options.
	 *
	 * @return array
	 */
	private function get_excluded_scripts() {
		static $exceptions;

		if (!is_null($exceptions)) return $exceptions;

		$exceptions = $this->options['exclude_delay_js'];
		$exceptions = is_array($exceptions) ? $exceptions : preg_split('#(\n|\r)#', $exceptions);
		$exceptions = $exceptions ? array_filter(array_map('trim', $exceptions)) : array();

		foreach ($exceptions as &$exception) {
			$exception = str_replace('*', '.*', $exception);
		}

		return $exceptions;
	}

	/**
	 * Checks if minification is enabled for JavaScript files.
	 *
	 * @return boolean
	 */
	private function is_minification_enabled_for_js() {
		return isset($this->options['enable_js_minification']) && $this->options['enable_js_minification'];
	}

	/**
	 * Verify whether the script is included in the excluded scripts list.
	 *
	 * @param string $script - script url
	 * @return bool
	 */
	private function is_excluded_script($script) {
		$excluded_scripts = $this->get_excluded_scripts();

		if (empty($excluded_scripts)) return false;

		if ($this->is_minification_enabled_for_js()) {
			$minified_scripts_to_exclude = $this->get_minified_scripts_to_exclude();
		
			foreach ($minified_scripts_to_exclude as $minified_script) {
				if (preg_match('#'.$minified_script.'#i', $script)) return true;
			}
		}

		foreach ($excluded_scripts as $exception) {
			if (preg_match('#'.$exception.'#i', $script)) return true;
		}

		return false;
	}

	/**
	 * Returns the list of minified JavaScript scripts to exclude from processing.
	 *
	 * @return array
	 */
	private function get_minified_scripts_to_exclude() {
		static $scripts_to_exclude = null;
		static $minified_files = null;

		if (!is_null($scripts_to_exclude)) {
			return $scripts_to_exclude;
		}

		$scripts_to_exclude = array();

		// Get the list of excluded scripts from options.
		$excluded_scripts = $this->get_excluded_scripts();

		if ($this->is_minification_enabled_for_js()) {
			if (is_null($minified_files)) {
				$minified_files = WP_Optimize_Minify_Cache_Functions::get_cached_files(0, false);
			}
		} else {
			$minified_files = array();
		}

		if (!empty($minified_files['js'])) {
			foreach ($minified_files['js'] as $file_info) {
				if (isset($file_info['log']->files)) {
					$files = get_object_vars($file_info['log']->files);

					// Loop through each file and match it with the exclusion patterns.
					foreach ($files as $file) {
						foreach ($excluded_scripts as $exception) {
							if (preg_match('#' . $exception . '#i', $file->url)) {
								// Store minified filename into result
								$scripts_to_exclude[] = $file_info['filename'];
								break(2);
							}
						}
					}
				}
			}
		}

		return $scripts_to_exclude;
	}

	/**
	 * Generate HTML code with tags to preload JavaScript files.
	 *
	 * @param array $scripts array with urls to scripts
	 * @return string
	 */
	private function generate_preload_scripts_tags($scripts) {
		$tags = array();

		if (!empty($scripts)) {
			foreach ($scripts as $script) {
				if ($this->is_excluded_script($script)) continue;
				$tags[] = '<link rel="preload" href="'.esc_url($script).'" as="script" />';
			}
		}

		return implode("\n", $tags);
	}

	/**
	 * Callback function that updates the script tag if necessary, or keeps it as is when the script is in the excluded list.
	 *
	 * @param array $tag
	 * @return string
	 */
	private function update_script_tags_callback($tag) {
		$attributes = WP_Optimize_Utils::parse_attributes($tag[1]);
		// When the inline script content is not empty, we will change the script type to 'text/plain'.
		$change_type = '' !== trim($tag[2]);
		
		if (!empty($attributes['src']) && $this->is_excluded_script($attributes['src'])) {
			return $tag[0];
		} else {
			return $this->build_delay_js_tag($attributes, $change_type, $tag[2]);
		}
	}

	/**
	 * Updates tag attributes by changing src="value" to data-src="value". If $change_type is true,
	 * it also adds data-type="value" with the original type attribute value, and sets the original
	 * type value to 'text/plain'.
	 *
	 * @param array  $attributes
	 * @param bool   $change_type
	 * @param string $inline_script Inline script content
	 * @return string
	 */
	private function build_delay_js_tag($attributes, $change_type, $inline_script) {

		if (!isset($attributes['data-no-delay-js'])) {
			// Change 'src' attribute to 'data-src' attr for external scripts
			if (!empty($attributes['src'])) {
				$attributes['data-src'] = $attributes['src'];
				unset($attributes['src']);
			}

			// Add data-type="value" with the original type attribute value and set type value to 'text/plain' for inline scripts
			if ($change_type && (empty($attributes['type']) || $this->is_supported_type($attributes['type']))) {
				$attributes['data-type'] = empty($attributes['type']) ? 'text/javascript' : $attributes['type'];
				$attributes['type'] = 'text/plain';
			}
		}

		return '<script '.WP_Optimize_Utils::build_attributes($attributes).'>'.$inline_script.'</script>';
	}

	/**
	 * Checks if the script type is in the supported list of types.
	 *
	 * @param string $type
	 * @return bool
	 */
	private function is_supported_type($type) {
		$supported_types = array(
			'text/javascript',
			'module',
			'application/javascript',
			'application/ecmascript',
			'application/x-ecmascript',
			'application/x-javascript',
			'text/x-ecmascript',
			'text/x-javascript',
			'text/javascript1.0',
			'text/javascript1.1',
			'text/javascript1.2',
			'text/javascript1.3',
			'text/javascript1.4',
			'text/javascript1.5',
			'text/jscript',
			'text/livescript',
			'text/ecmascript',
		);

		$type = strtolower($type);

		return in_array($type, $supported_types);
	}
	
	/**
	 * Regular expression to get scripts.
	 *
	 * @return string
	 */
	private function get_scripts_pattern() {
		return '/<script(.*)>(.*)<\/script>/Uis';
	}
	
	/**
	 * Regiters callback to output Delay JS script.
	 *
	 * @return void
	 */
	private function register_callback_to_output_delay_js_script() {
		add_action('wp_footer', array($this, 'output_delay_js_script'));
	}
	
	/**
	 * Determines whether the page is in edit mode using page builders
	 * Beaver Builder, Divi Theme, Elementor, and Oxygen Builder
	 *
	 * @return bool
	 */
	private function is_edit_mode(): bool {
		return isset($_GET['fl_builder']) || isset($_GET['et_fb']) || isset($_GET['elementor-preview']) || isset($_GET['oxygen']) || isset($_GET['ct_builder']);
	}
}

endif;
