<?php

if (!defined('WPO_PLUGIN_MAIN_PATH')) die('No direct access allowed');

if (!class_exists('Updraft_Notices_1_2')) require_once(WPO_PLUGIN_MAIN_PATH.'vendor/team-updraft/common-libs/src/updraft-notices/updraft-notices.php');

class WP_Optimize_Notices extends Updraft_Notices_1_2 {

	private $initialized = false;

	protected $self_affiliate_id = 216;

	protected $notices_content = array();

	/**
	 * Returns singleton instance object
	 *
	 * @return WP_Optimize_Notices Returns `WP_Optimize_Notices` object
	 */
	public static function instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}

	/**
	 * This method gets any parent notices and adds its own notices to the notice array
	 *
	 * @return Array returns an array of notices
	 */
	protected function populate_notices_content() {
		
		$parent_notice_content = parent::populate_notices_content();

		// translators: %1$s are bold html tags to make some of the text bold, %2$s are closing tags
		$sale_description = sprintf(__('Make your site even %1$s faster with Premium %2$s.', 'wp-optimize'), '<b>', '</b>') . ' ';
		// translators: %1$s are bold html tags to make some of the text bold, %2$s are closing tags
		$sale_description .= sprintf(__('Identify orphaned images, load pages faster and get %1$s premium support %2$s.', 'wp-optimize'), '<b>', '</b>') . ' ';
		$sale_description .= __('Get advanced options, like the ability to optimize your site using WP-CLI.', 'wp-optimize') . ' ';
		// translators: %1$s are bold html tags to make some of the text bold, %2$s are closing tags
		$sale_description .= sprintf(__('Premium is %1$s compatible with WordPress multisite, WooCommerce and other add-ons %2$s, including multilingual and multi-currency WordPress plugins.', 'wp-optimize'), '<b>', '</b>');
		$sale_description .= '<br>';

		$bf_checkout_html = '<b><a href="https://teamupdraft.com/wp-optimize/blackfriday/?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=unknown&utm_creative_format=unknown" target="_blank">'.__('Save 20% with code blackfridaysale2025', 'wp-optimize').'</a></b>';

		$child_notice_content = array(
			'updraftplus' => array(
				'prefix' => '',
				'title' => __('Make sure you backup before you optimize your database', 'wp-optimize'),
				'text' => __("UpdraftPlus is the world's most trusted backup plugin, from the owners of WP-Optimize.", 'wp-optimize'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://wordpress.org/plugins/updraftplus/',
				'button_meta' => 'updraftplus',
				'dismiss_time' => 'dismiss_page_notice_until',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_updraftplus_installed',
			),
			'updraftcentral' => array(
				'prefix' => '',
				'title' => __('Save time and money.', 'wp-optimize') . ' ' . __('Manage multiple sites from one location.', 'wp-optimize'),
				'text' => __('Back up, update and manage multiple WordPress websites centrally.', 'wp-optimize'),
				'image' => 'notices/updraft_central_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftcentral/?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftcentral&utm_creative_format=advert',
				'button_meta' => 'updraftcentral',
				'dismiss_time' => 'dismiss_page_notice_until',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_updraftcentral_installed',
			),
			'rate_plugin' => array(
				// translators: %1$s is an anchor tag to WP-Optimize support forum, %2$s is closing tags
				'text' => __("We noticed WP-Optimize has kept your site running fast for a while.", 'wp-optimize') . ' ' . __('If you like us, please consider leaving us a positive review.', 'wp-optimize') . ' ' . sprintf(__('If you have any issues or questions please contact %1$s support. %2$s', 'wp-optimize'), '<a href="https://wordpress.org/support/plugin/wp-optimize/" target="_blank">', '</a><br>') . __('Thank you so much!', 'wp-optimize'),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://wordpress.org/support/plugin/wp-optimize/reviews/?rate=5#new-post',
				'button_meta' => 'review',
				'dismiss_time' => 'dismiss_review_notice',
				'supported_positions' => $this->dashboard_top,
				'validity_function' => 'show_rate_notice'
			),
			'translation_needed' => array(
				'prefix' => '',
				'title' => 'Can you translate?',
				'text' => __("Want to improve WP-Optimize for speakers of your language? Go here for instructions", 'wp-optimize'),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://teamupdraft.com/translate-for-us?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=translate&utm_creative_format=advert',
				'button_meta' => 'translate',
				'dismiss_time' => false,
				'supported_positions' => $this->anywhere,
				'validity_function' => 'translation_needed',
			),
			'wpo-premium' => array(
				'prefix' => '',
				'title' => __("Perform optimizations while your visitors sleep", "wp-optimize"),
				'text' => __("Schedule optimizations for set times e.g. overnight when server resources are high.", "wp-optimize"),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://teamupdraft.com/wp-optimize/features?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=while-they-sleep&utm_creative_format=advert',
				'button_meta' => 'wpo-premium',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
				'validity_function' => 'is_wpo_premium_installed',
			),
			'wpo-premium-multisite' => array(
				'prefix' => '',
				'title' => __("Manage a multisite installation?", "wp-optimize"),
				'text' => __("Optimize any site (or combination of sites) on the multisite network.", "wp-optimize") . ' ' . __("Give the right permissions to the right users.", "wp-optimize"),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://teamupdraft.com/wp-optimize/features?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=multisite&utm_creative_format=advert',
				'button_meta' => 'wpo-premium',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
				'validity_function' => 'is_wpo_premium_installed',
			),
			'wpo-premium3' => array(
				'prefix' => '',
				'title' => __("Remove unwanted images for better site performance.", "wp-optimize"),
				'text' => __("WP-Optimize Premium comes with a feature to easily remove orphaned images, or images that exceed a certain size from your website.", "wp-optimize"),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://teamupdraft.com/wp-optimize/features?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=unwanted-images&utm_creative_format=advert',
				'button_meta' => 'wpo-premium',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
				'validity_function' => 'is_wpo_premium_installed',
			),
			'aios' => array(
				'prefix' => '',
				'title' => __('Secure your site', 'wp-optimize'),
				// translators: %1$s is the name of plugin and %2$s is the name of the team
				'text' => sprintf(__('The %1$s plugin from %2$s.', 'wp-optimize'), '"All-In-One" Security', 'TeamUpdraft'),
				'image' => 'notices/aios_logo.png',
				'button_link' => 'https://teamupdraft.com/all-in-one-security/?utm_source=wpo-plugin&utm_medium=referral&utm_campaign=paac&utm_content=aios&utm_creative_format=advert',
				'button_meta' => 'aios',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
			),

			// The sale adverts content starts here
			'blackfriday' => array(
				'prefix' => '',
				'title' => __('20% off - Black Friday Sale', 'wp-optimize'),
				// translators: %s is a link to pricing/check out page
				'text' => $sale_description . '<br>' . sprintf(__('%s at checkout.', 'wp-optimize'), $bf_checkout_html) . ' <b>' . __('Hurry, offer ends 2 December.', 'wp-optimize') . '</b>',
				'image' => 'notices/wpo_sale_icon.png',
				'button_link' => 'https://teamupdraft.com/wp-optimize/blackfriday/',
				'button_meta' => 'no-button',
				'dismiss_time' => 'dismiss_season',
				// 'discount_code' => 'blackfridaysale2022',
				'valid_from' => '2025-11-14 00:00:00',
				'valid_to' => '2025-12-02 23:59:59',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_wpo_premium_installed',
			),
		);

		return array_merge($parent_notice_content, $child_notice_content);
	}
	
	/**
	 * Call this method to setup the notices
	 */
	public function notices_init() {
		if ($this->initialized) return;
		$this->initialized = true;
		$this->notices_content = (defined('WP_OPTIMIZE_NOADS_B') && WP_OPTIMIZE_NOADS_B) ? array() : $this->populate_notices_content();
	}

	/**
	 * This method will call the parent is_plugin_installed and pass in the product updraftplus to check if that plugin is installed if it is then we shouldn't display the notice
	 *
	 * @param  string  $product             the plugin slug
	 * @param  boolean $also_require_active a bool to indicate if the plugin should also be active
	 * @return boolean                      a bool to indicate if the notice should be displayed or not
	 */
	protected function is_updraftplus_installed($product = 'updraftplus', $also_require_active = false) {
		return parent::is_plugin_installed($product, $also_require_active);
	}

	/**
	 * This method will call the parent is_plugin_installed and pass in the product updraftcentral to check if that plugin is installed if it is then we shouldn't display the notice
	 *
	 * @param  string  $product             the plugin slug
	 * @param  boolean $also_require_active a bool to indicate if the plugin should also be active
	 * @return boolean                      a bool to indicate if the notice should be displayed or not
	 */
	protected function is_updraftcentral_installed($product = 'updraftcentral', $also_require_active = false) {
		return parent::is_plugin_installed($product, $also_require_active);
	}

	/**
	 * This method will call the is premium function in the WPO object to check if this install is premium and if it is we won't display the notice
	 *
	 * @return boolean a bool to indicate if we should display the notice or not
	 */
	protected function is_wpo_premium_installed() {
		if (WP_Optimize::is_premium()) {
			return false;
		}

		return true;
	}

	/**
	 * This method will check to see if a number of different backup plugins are installed and if they are we won't display the notice
	 *
	 * @param  string|null  $product             the plugin slug
	 * @param  boolean      $also_require_active a bool to indicate if the plugin should be active or not
	 * @return boolean                           a bool to indicate if the notice should be displayed or not
	 */
	public function is_backup_plugin_installed(?string $product = null, bool $also_require_active = false): bool {
		$backup_plugins = array('updraftplus' => 'UpdraftPlus', 'backwpup' => 'BackWPup', 'backupwordpress' => 'BackupWordPress', 'vaultpress' => 'VaultPress', 'wp-db-backup' => 'WP-DB-Backup', 'backupbuddy' => 'BackupBuddy');

		foreach ($backup_plugins as $slug => $title) {
			if (!parent::is_plugin_installed($slug, $also_require_active)) {
				return $title;
			}
		}

		return apply_filters('wp_optimize_is_backup_plugin_installed', false);
	}

	/**
	 * This function will check if we should display the rate notice or not
	 *
	 * @return boolean - to indicate if we should show the notice or not
	 */
	protected function show_rate_notice() {
		
		$options = WP_Optimize()->get_options();
		$installed = $options->get_option('installed-for', 0);
		$installed_for = time() - $installed;
		
		if ($installed && $installed_for > 28*86400) {
			return true;
		}

		return false;
	}

	/**
	 * This method calls the parent version and will work out if the user is using a non english language and if so returns true so that they can see the translation advert.
	 *
	 * @param  String $plugin_base_dir the plugin base directory
	 * @param  String $product_name    the name of the plugin
	 * @return Boolean                 returns true if the user is using a non english language and could translate otherwise false
	 */
	protected function translation_needed($plugin_base_dir = null, $product_name = null) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- using this because of parent class method signature
		return parent::translation_needed(WPO_PLUGIN_MAIN_PATH, 'wp-optimize');
	}
	
	/**
	 * This method is used to generate the correct URL output for the start of the URL
	 *
	 * @param  Boolean $html_allowed a boolean value to indicate if HTML can be used or not
	 * @param  String  $url          the url to use
	 * @param  Boolean $https        a boolean value to indicate if https should be used or not
	 * @param  String  $website_home a string to be displayed
	 * @return String                returns a string of the completed url
	 */
	protected function url_start($html_allowed, $url, $https = false, $website_home = 'getwpo.com') {
		return parent::url_start($html_allowed, $url, $https, $website_home);
	}

	/**
	 * This method checks to see if the notices dismiss_time parameter has been dismissed
	 *
	 * @param  String $dismiss_time a string containing the dimiss time ID
	 * @return Boolean returns true if the notice has been dismissed and shouldn't be shown otherwise display it
	 */
	protected function check_notice_dismissed($dismiss_time) {

		$time_now = (defined('WP_OPTIMIZE_NOTICES_FORCE_TIME') ? WP_OPTIMIZE_NOTICES_FORCE_TIME : time());
	
		$options = WP_Optimize()->get_options();

		$notice_dismiss = ($time_now < $options->get_option($dismiss_time, 0));

		return $notice_dismiss;
	}

	/**
	 * Check notice data for seasonal info and return true if we should display this notice.
	 *
	 * @param array $notice_data
	 * @return bool
	 */
	protected function skip_seasonal_notices($notice_data) {
		$time_now = defined('WPO_NOTICES_FORCE_TIME') ? WPO_NOTICES_FORCE_TIME : time();
		// Do not show seasonal notices in Premium version.
		if (false === WP_Optimize::is_premium()) {
			$valid_from = strtotime($notice_data['valid_from']);
			$valid_to = strtotime($notice_data['valid_to']);
			$dismiss = $this->check_notice_dismissed($notice_data['dismiss_time']);
			if (($time_now >= $valid_from && $time_now <= $valid_to) && !$dismiss) {
				// return true so that we return this notice to be displayed
				return true;
			}
		}

		return false;
	}

	/**
	 * This method will create the chosen notice and the template to use and depending on the parameters either echo it to the page or return it
	 *
	 * @param  Array   $advert_information     an array with the notice information in
	 * @param  Boolean $return_instead_of_echo a bool value to indicate if the notice should be printed to page or returned
	 * @param  String  $position               a string to indicate what template should be used
	 * @return String                          a notice to display
	 */
	protected function render_specified_notice($advert_information, $return_instead_of_echo = false, $position = 'top') {
	
		if ('bottom' == $position) {
			$template_file = 'bottom-notice.php';
		} elseif ('report' == $position) {
			$template_file = 'report.php';
		} elseif ('report-plain' == $position) {
			$template_file = 'report-plain.php';
		} else {
			$template_file = 'horizontal-notice.php';
		}
		
		$extract_variables = array_merge($advert_information, array('wp_optimize_notices' => $this));

		return WP_Optimize()->include_template('notices/'.$template_file, $return_instead_of_echo, $extract_variables);
	}
}

$GLOBALS['wp_optimize_notices'] = WP_Optimize_Notices::instance();
