<?php

if (!defined('ABSPATH')) die('No direct access allowed');
/**
 * Install or update notice
 * Manages the notice shown when the user activates or updates WPO
 *
 * The class is included during `admin_init`
 */
class WP_Optimize_Install_Or_Update_Notice {

	/**
	 * Notice Version.
	 * If we need to later show a similar notice with a different content,
	 * We can reuse this by changing the version number and updating the content in the template file.
	 *
	 * @var string
	 */
	private $version = '1.0';

	public function __construct() {
		$this->options = WP_Optimize()->get_options();

		if ($this->show_current_notice()) {
			add_action('wpo_admin_after_header', array($this, 'output_notice'), 20);
		}

	}

	/**
	 * Determines if the current notice was shown
	 *
	 * @return boolean
	 */
	private function show_current_notice() {
		$latest_saved_notice = $this->options->get_option('install-or-update-notice-version', false);
		if ($latest_saved_notice && version_compare($latest_saved_notice, $this->version, '>=')) {
			return false;
		}
		return true;
	}

	/**
	 * Outputs the notice
	 *
	 * @return void
	 */
	public function output_notice() {
		WP_Optimize()->include_template('notices/install-or-update-notice.php', false, array(
			'is_new_install' => $this->is_new_install(),
			'is_premium' => WP_Optimize()->is_premium(),
			'is_updraftplus_installed' => $this->is_updraftplus_installed()
		));
	}

	/**
	 * Attempts to find out if WPO was newly installed or updated
	 *
	 * @return boolean
	 */
	private function is_new_install() {
		if ($this->options->get_option('newly-activated', false)) {
			return true;
		}

		return false;
	}

	/**
	 * Dismiss the notice
	 *
	 * @return boolean
	 */
	public function dismiss() {

		if ($this->is_new_install()) {
			$this->options->delete_option('newly-activated');
		}

		if (!$this->options->update_option('install-or-update-notice-version', $this->version)) {
			return false;
		}

		return true;
	}

	/**
	 * Check if updraftplus is installed.
	 *
	 * @return bool
	 */
	private function is_updraftplus_installed() {
		$status = WP_Optimize()->get_db_info()->get_plugin_status('updraftplus');

		return $status['installed'];
	}
}

return new WP_Optimize_Install_Or_Update_Notice();
