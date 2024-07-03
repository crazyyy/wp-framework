<?php

if (!defined('WPO_VERSION')) die('No direct access allowed');

if (!class_exists('WP_Optimize_WebP')) :

class WP_Optimize_WebP {

	private $_htaccess = null;

	/**
	 * Set to true when webp is enabled and vice-versa
	 *
	 * @var boolean
	 */
	private $_should_use_webp = false;

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->_should_use_webp = (bool) WP_Optimize()->get_options()->get_option('webp_conversion');

		if ($this->_should_use_webp && $this->get_webp_conversion_test_result()) {
			if (!is_admin()) {

				// Allow filters added in theme files to run
				add_action('after_setup_theme', array($this, 'maybe_decide_webp_serve_method'));
			}
		}

		add_action('wpo_reset_webp_conversion_test_result', array($this, 'reset_webp_serving_method'));
	}

	/**
	 * Returns singleton instance
	 *
	 * @return WP_Optimize_WebP
	 */
	public static function get_instance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new WP_Optimize_WebP();
		}
		return $instance;
	}

	/**
	 * Test Run and find converter status
	 */
	private function set_converter_status() {
		$converter_status = WPO_WebP_Test_Run::get_converter_status();
		if ($this->is_webp_conversion_successful()) {
			WP_Optimize()->get_options()->update_option('webp_conversion_test', true);
			WP_Optimize()->get_options()->update_option('webp_converters', $converter_status['working_converters']);
		}
	}

	/**
	 * If .htaccess redirection is not possible, attempts to use the alter_html method
	 */
	public function maybe_decide_webp_serve_method() {
		if (!$this->is_webp_redirection_possible()) {
			$this->maybe_use_alter_html();
		}
	}

	/**
	 * If alter html method is possible, then use it
	 */
	private function maybe_use_alter_html() {
		if ($this->is_alter_html_possible()) {
			$this->empty_htaccess_file();
			$this->use_alter_html();
		}
	}

	/**
	 * Even if server support .htaccess rewrite, sometimes it is not possible
	 * to serve webp images. So, find it webp redirection is possible or not
	 * Also applies `wpo_force_webp_serve_using_altered_html` filter for users to be able to
	 * force Altered HTML method
	 *
	 * @return bool
	 */
	public function is_webp_redirection_possible() {
		if (apply_filters('wpo_force_webp_serve_using_altered_html', false)) {
			return false;
		}
		$redirection_possible = WP_Optimize()->get_options()->get_option('redirection_possible');
		if (!empty($redirection_possible)) return 'true' === $redirection_possible;
		return $this->run_webp_serving_self_test();
	}

	/**
	 * Decide whether the browser requesting the URL can accept webp images or not
	 *
	 * @return bool
	 */
	private function is_browser_accepting_webp() {
		return (isset($_SERVER['HTTP_ACCEPT']) && false !== strpos($_SERVER['HTTP_ACCEPT'], 'image/webp'));
	}
	
	/**
	 * Detect whether using alter HTML method is possible or not
	 *
	 * @return bool
	 */
	private function is_alter_html_possible() {
		if ($this->is_browser_accepting_webp()) {
			return true;
		}
		return false;
	}

	/**
	 * Setup alter html method
	 */
	private function use_alter_html() {
		WPO_WebP_Alter_HTML::get_instance();
	}

	/**
	 * Initialize .htaccess
	 */
	private function setup_htaccess_file() {
		if (null !== $this->_htaccess) return;
		$wp_uploads = wp_get_upload_dir();
		$htaccess_file = $wp_uploads['basedir'] . '/.htaccess';
		if (!file_exists($htaccess_file)) {
			file_put_contents($htaccess_file, '');
		}
		$this->_htaccess = new WP_Optimize_Htaccess($htaccess_file);
	}
	
	/**
	 * Save .htaccess rules
	 *
	 * @return void
	 */
	public function save_htaccess_rules() {
		$this->setup_htaccess_file();
		$this->add_webp_mime_type();
		$htaccess_comment_section = 'WP-Optimize WebP Rules';
		if ($this->_htaccess->is_commented_section_exists($htaccess_comment_section)) return;
		$this->_htaccess->update_commented_section($this->prepare_webp_htaccess_rules(), $htaccess_comment_section);
		$this->_htaccess->write_file();
		WP_Optimize()->get_options()->update_option('htaccess_has_webp_rules', true);
	}

	/**
	 * Empty .htaccess file
	 */
	public function empty_htaccess_file() {
		// Setting default to true, so on initial run (when option is not yet present in the DB) we don't break the function here
		if (!WP_Optimize()->get_options()->get_option('htaccess_has_webp_rules', true)) return;
		$this->setup_htaccess_file();
		$htaccess_comment_sections = array(
			'WP-Optimize WebP Rules',
			'Register webp mime type',
		);
		foreach ($htaccess_comment_sections as $htaccess_comment_section) {
			if (!$this->_htaccess->is_commented_section_exists($htaccess_comment_section)) continue;
			$this->_htaccess->remove_commented_section($htaccess_comment_section);
			$this->_htaccess->write_file();
		}
		WP_Optimize()->get_options()->update_option('htaccess_has_webp_rules', false);
	}

	/**
	 * Prepare array of htaccess rules to use webp images.
	 *
	 * @return array
	 */
	private function prepare_webp_htaccess_rules() {
		return array(
			array(
				'<IfModule mod_rewrite.c>',
				'RewriteEngine On',
				'',
				'# Redirect to existing converted image in same dir (if browser supports webp)',
				'RewriteCond %{HTTP_ACCEPT} image/webp',
				'RewriteCond %{REQUEST_FILENAME} (?i)(.*)(\.jpe?g|\.png)$',
				'RewriteCond %1%2\.webp -f',
				'RewriteRule (?i)(.*)(\.jpe?g|\.png)$ %1%2\.webp [T=image/webp,E=EXISTING:1,E=ADDVARY:1,L]',
				'',
				'# Make sure that browsers which does not support webp also gets the Vary:Accept header',
				'# when requesting images that would be redirected to webp on browsers that does.',
				array(
					'<IfModule mod_headers.c>',
					array(
						'<FilesMatch "(?i)\.(jpe?g|png)$">',
						'Header append "Vary" "Accept"',
						'</FilesMatch>',
					),
					'</IfModule>',
				),
				'',
				'</IfModule>',
				'',
			),
			array(
				'# Rules for handling requests for webp images',
				'# ---------------------------------------------',
				'',
				'# Set Vary:Accept header if we came here by way of our redirect, which set the ADDVARY environment variable',
				'# The purpose is to make proxies and CDNs aware that the response varies with the Accept header',
				'<IfModule mod_headers.c>',
				array(
					'<IfModule mod_setenvif.c>',
					'# Apache appends "REDIRECT_" in front of the environment variables defined in mod_rewrite, but LiteSpeed does not',
					'# So, the next lines are for Apache, in order to set environment variables without "REDIRECT_"',
					'SetEnvIf REDIRECT_EXISTING 1 EXISTING=1',
					'SetEnvIf REDIRECT_ADDVARY 1 ADDVARY=1',
					'',
					'Header append "Vary" "Accept" env=ADDVARY',
					'',
					'# Set X-WPO-WebP header for diagnose purposes',
					'Header set "X-WPO-WebP" "Redirected directly to existing webp" env=EXISTING',
					'</IfModule>',
				),
				'</IfModule>',
			),
		);
	}

	/**
	 * Add webp mime type to htaccess rules.
	 */
	private function add_webp_mime_type() {
		$htaccess_comment_section = 'Register webp mime type';
		if ($this->_htaccess->is_exists() && !$this->_htaccess->is_commented_section_exists($htaccess_comment_section)) {
			$webp_mime_type = array(
				array(
					'<IfModule mod_mime.c>',
					'AddType image/webp .webp',
					'</IfModule>',
				),
			);
			$this->_htaccess->update_commented_section($webp_mime_type, $htaccess_comment_section);
			$this->_htaccess->write_file();
		}
	}

	/**
	 * Checks whether webp conversion test is successful or not
	 *
	 * @return bool
	 */
	public function is_webp_conversion_successful() {
		$upload_dir = wp_upload_dir();
		$destination =  $upload_dir['basedir']. '/wpo/images/wpo_logo_small.png.webp';
		return file_exists($destination);
	}

	/**
	 * Checks whether sample webp conversion test should be run or not
	 *
	 * @return bool Returns true if sample test should be run, false otherwise
	 */
	public function should_run_webp_conversion_test() {
		$webp_conversion_test = $this->get_webp_conversion_test_result();
		return (true !== $webp_conversion_test);
	}

	/**
	 * Returns webp conversion test result
	 *
	 * @return boolean Returns the value of the webp_conversion_test saved in the options table
	 */
	private function get_webp_conversion_test_result() {
		return (bool) WP_Optimize()->get_options()->get_option('webp_conversion_test');
	}

	/**
	 * Checks whether the webp redirection is possible or not and sets flag
	 *
	 * @return bool Returns true if webp is served successfully, false otherwise
	 */
	private function run_webp_serving_self_test() {
		$self_test = WPO_WebP_Self_Test::get_instance();

		if ($self_test->is_webp_served()) {
			WP_Optimize()->get_options()->update_option('redirection_possible', 'true');
			return true;
		}
		WP_Optimize()->get_options()->update_option('redirection_possible', 'false');
		$this->empty_htaccess_file();
		return false;
	}

	/**
	 * Resets webp serving method by running self test, if needed purges cache and empties `uploads/.htaccess` file
	 */
	public function reset_webp_serving_method() {
		if (self::is_shell_functions_available() && $this->_should_use_webp) {
			$this->reset_webp_options();
			$this->run_self_test();
			list($old_redirection_possible, $new_redirection_possible) = $this->get_old_and_new_redirection_possibility();
			$this->maybe_purge_cache($old_redirection_possible, $new_redirection_possible);
			$this->maybe_empty_htaccess_file($new_redirection_possible);
		} else {
			$this->disable_webp_conversion();
		}
	}
	
	/**
	 * Resets WebP related options
	 */
	private function reset_webp_options() {
		$options = WP_Optimize()->get_options();
		$options->update_option('old_redirection_possible', $options->get_option('redirection_possible'));
		$options->update_option('webp_conversion_test', false);
		$options->update_option('webp_converters', false);
		$options->update_option('redirection_possible', false);
		$this->remove_webp_test_image_file();
	}
	
	/**
	 * Running self test to find available converters and possibility of serving webp using redirection method
	 */
	private function run_self_test() {
		$this->set_converter_status();
		if ($this->get_webp_conversion_test_result()) {
			$this->save_htaccess_rules();
			$this->run_webp_serving_self_test();
		} else {
			$this->disable_webp_conversion();
		}
	}
	
	/**
	 * Gets old and new redirection possibility values
	 *
	 * @return array
	 */
	private function get_old_and_new_redirection_possibility() {
		$options = WP_Optimize()->get_options();
		return array(
			$options->get_option('old_redirection_possible'),
			$options->get_option('redirection_possible'),
		);
	}
	
	/**
	 * Cache is cleared when there is a change in the potential for serving WebP using redirection.
	 *
	 * @param string $old_redirection_possible
	 * @param string $new_redirection_possible
	 */
	private function maybe_purge_cache($old_redirection_possible, $new_redirection_possible) {
		if ($old_redirection_possible !== $new_redirection_possible) {
			WP_Optimize()->get_page_cache()->purge();
		}
	}
	
	/**
	 * Remove redirection rules from `uploads/.htaccess` file if redirection is not possible
	 *
	 * @param string $new_redirection_possible
	 */
	private function maybe_empty_htaccess_file($new_redirection_possible) {
		if ('false' === $new_redirection_possible) {
			$this->empty_htaccess_file();
		}
	}

	/**
	 * Initialize cron scheduler
	 */
	public function init_webp_cron_scheduler() {
		if (!wp_next_scheduled('wpo_reset_webp_conversion_test_result')) {
			wp_schedule_event(time(), 'wpo_daily', 'wpo_reset_webp_conversion_test_result');
		}
	}

	/**
	 * Remove all cron schedules
	 */
	public function remove_webp_cron_schedules() {
		wp_clear_scheduled_hook('wpo_reset_webp_conversion_test_result');
	}

	/**
	 * Return the true if webp conversion is enabled and vice-versa
	 *
	 * @return bool
	 */
	public function is_webp_conversion_enabled() {
		return $this->_should_use_webp;
	}

	/**
	 * Set the webp_conversion option value to false and remove webp cron schedules
	 */
	public function disable_webp_conversion() {
		$this->empty_htaccess_file();
		WP_Optimize()->get_options()->update_option("webp_conversion", false);
		$this->remove_webp_cron_schedules();
	}

	/**
	 * Remove webp converted test image file
	 */
	private function remove_webp_test_image_file() {
		$upload_dir = wp_upload_dir();
		$destination =  $upload_dir['basedir']. '/wpo/images/wpo_logo_small.png.webp';
		if (@file_exists($destination)) { // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress PHP warning in case of failure
			@unlink($destination); // phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- suppress PHP warning in case of failure
		}
	}

	/**
	 * Run during plugin deactivation
	 */
	public function plugin_deactivate() {
		$this->empty_htaccess_file();
		$this->remove_webp_test_image_file();
	}

	/**
	 * Determines whether the php shell functions are available or not
	 *
	 * @return bool
	 */
	public static function is_shell_functions_available() {
		$shell_functions = self::get_shell_functions();
		foreach ($shell_functions as $shell_function) {
			if (!function_exists($shell_function)) return false;
		}
		return true;
	}

	/**
	 * List of php shell function names
	 *
	 * @return string[]
	 */
	private static function get_shell_functions() {
		return array(
			'escapeshellarg',
			'escapeshellcmd',
			'exec',
			'passthru',
			'proc_close',
			'proc_get_status',
			'proc_nice',
			'proc_open',
			'proc_terminate',
			'shell_exec',
			'system',
		);
	}
}

endif;
