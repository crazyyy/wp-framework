<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

if (!class_exists('Updraft_Notices_1_2')) updraft_try_include_file('vendor/team-updraft/common-libs/src/updraft-notices/updraft-notices.php', 'require_once');

class UpdraftPlus_Notices extends Updraft_Notices_1_2 {

	protected static $_instance = null;

	private $initialized = false;

	protected $notices_content = array();
	
	protected $self_affiliate_id = 212;

	public static function instance() {
		if (empty(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	protected function populate_notices_content() {
		
		$parent_notice_content = parent::populate_notices_content();

		$sale_description = sprintf(__('%s, %s and %s with %s.', 'updraftplus'), '<b>'.__('Backup', 'updraftplus').'</b>', '<b>'.__('migrate', 'updraftplus').'</b>', '<b>'.__('restore', 'updraftplus').'</b>', '<b>'.__('Premium', 'updraftplus').'</b>');
		$sale_description .= ' '.sprintf(__('Backup incremental changes, instead of full backups (saving server resources), %s, get more remote storage locations, %s and more.', 'updraftplus'), '<b>'.__('clone or migrate your site with ease', 'updraftplus').'</b>', '<b>'.__('premium support', 'updraftplus').'</b>');
		
		// Not used in 2024
		// $checkout_html = '<a class="updraft_notice_link" href="https://updraftplus.com/shop/updraftplus-premium/">'.__('checkout', 'updraftplus').'</a>';

		$child_notice_content = array(
			1 => array(
				'prefix' => '',
				'title' => __("Need help? We've got your back", 'updraftplus'),
				'text' => __('Get direct support from the developers with Premium.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/support/premium-support/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=needhelp&utm_creative_format=advert',
				'campaign' => 'support',
				'button_text' => __('Premium Support', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
			),
			2 => array(
				'prefix' => '',
				'title' => __('Store your backups with us', 'updraftplus'),
				'text' => __('UpdraftVault is the secure and convenient place to store your backups.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/updraftvault/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftvault&utm_creative_format=advert',
				'campaign' => 'vault',
				'button_text' => __('More about UpdraftVault', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
			),
			'googledrive' => array(
				'prefix' => '',
				'title' => __('Backing up to Google Drive?', 'updraftplus'),
				'text' => __('Organise backups with subfolders.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/features/back-up-to-subfolders/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=google-drive&utm_creative_format=advert',
				'campaign' => 'morestorage',
				'button_text' => __('Google Drive enhancement', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_googledrive_in_use',
			),
			'dropbox' => array(
				'prefix' => '',
				'title' => __('Backing up to Dropbox?', 'updraftplus'),
				'text' => __('Organise backups with subfolders.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/features/back-up-to-subfolders/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=dropbox&utm_creative_format=advert',
				'campaign' => 'morestorage',
				'button_text' => __('Dropbox enhancement', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_dropbox_in_use',
			),
			's3' => array(
				'prefix' => '',
				'title' => __('Backing up to Amazon S3?', 'updraftplus'),
				'text' => __('Save money - back up to the infrequent storage class with Premium.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/features/amazon-s3-enhanced/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=amazons3&utm_creative_format=advert',
				'campaign' => 'morestorage',
				'button_text' => __('Amazon S3 enhancement', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
				'validity_function' => 'is_s3_in_use',
			),
			5 => array(
				'prefix' => '',
				'title' => __('Secure your backups', 'updraftplus'),
				'text' => __('Encrypt the database, lock UpdraftPlus settings to other admins and anonymise backups.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/features?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=securebackups3&utm_creative_format=advert',
				'campaign' => 'lockadmin',
				'button_text' => __('See premium features', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
			),
			6 => array(
				'prefix' => '',
				'title' => __('Easily migrate or clone your site in minutes', 'updraftplus'),
				'text' => __('Copy your site to another domain directly.', 'updraftplus').' '.__('Includes find-and-replace tool for database references.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/wordpress-migration-plugin/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=migrate&utm_creative_format=advert',
				'campaign' => 'migrator',
				'button_text' => __('Migration', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
			),
			7 => array(
				'prefix' => '',
				'title' => __('Introducing UpdraftCentral', 'updraftplus'),
				'text' => __('UpdraftCentral is a highly efficient way to manage, update and backup multiple websites from one place.', 'updraftplus'),
				'image' => 'notices/updraftcentral_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftcentral?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftcentral1&utm_creative_format=advert',
				'button_text' => __('UpdraftCentral', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->dashboard_top_or_report,
			),
			8 => array(
				'prefix' => '',
				'title' => __('Do you use UpdraftPlus on multiple sites?', 'updraftplus'),
				'text' => __('Control all your WordPress installations from one place using UpdraftCentral remote site management!', 'updraftplus'),
				'image' => 'notices/updraftcentral_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftcentral?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=updraftcentral2&utm_creative_format=advert',
				'button_text' => __('UpdraftCentral', 'updraftplus'),
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
			),
			'rate' => array(
				'text' => __('Hey - We noticed UpdraftPlus has kept your site safe for a while.', 'updraftplus').' '.__('If you like us, please consider leaving a positive review to spread the word.', 'updraftplus').' '.__('Or if you have any issues or questions please leave us a support message', 'updraftplus').' <a href="https://wordpress.org/support/plugin/updraftplus/" target="_blank">'.__('here', 'updraftplus').'.</a><br>'.__('Thank you so much!', 'updraftplus').'<br><br> - <b>'.__('Team Updraft', 'updraftplus').'</b><br>',
				'image' => 'notices/ud_smile.png',
				'button_link' => 'https://wordpress.org/support/plugin/updraftplus/reviews/?rate=5#new-post',
				'button_meta' => 'review',
				'dismiss_time' => 'dismiss_review_notice',
				'supported_positions' => $this->dashboard_top,
				'validity_function' => 'show_rate_notice'
			),
			'translation_needed' => array(
				'prefix' => '',
				'title' => __('Can you translate?', 'updraftplus'),
				'text' => __('Want to improve UpdraftPlus for speakers of your language?', 'updraftplus').' '.__('Go here for instructions', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/translate-for-us?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=translate&utm_creative_format=advert',
				'button_text' => __('Translate', 'updraftplus'),
				'dismiss_time' => false,
				'supported_positions' => $this->anywhere,
				'validity_function' => 'translation_needed',
			),
			'social_media' => array(
				'prefix' => '',
				'title' => __('Follow TeamUpdraft', 'updraftplus'),
				'text' => $this->url_start(true, 'facebook.com/TeamUpdraftWP/', true).__('Facebook', 'updraftplus').$this->url_end(true, 'facebook.com/TeamUpdraftWP/', true).' - '.
					$this->url_start(true, 'x.com/TeamUpdraftWP/', true).__('Twitter/X', 'updraftplus').$this->url_end(true, 'x.com/TeamUpdraftWP/', true).' - '.
					$this->url_start(true, 'linkedin.com/company/teamupdraft', true).__('LinkedIn', 'updraftplus').$this->url_end(true, 'linkedin.com/company/teamupdraft', true).' - '.
					$this->url_start(true, 'youtube.com/@TeamUpdraftWP', true).__('YouTube', 'updraftplus').$this->url_end(true, 'youtube.com/@TeamUpdraftWP', true),
				'image' => 'notices/teamupdraft_logo.png',
				'dismiss_time' => false,
				'supported_positions' => $this->anywhere,
			),
			'autobackup' => array(
				'prefix' => '',
				'title' => __('Automatically back up before updates', 'updraftplus'),
				'text' => __('With UpdraftPlus Premium, your site is backed up before every update.', 'updraftplus').' '.__('Simple, safe, and hassle-free.', 'updraftplus'),
				'image' => 'notices/updraft_logo.png',
				'button_link' => 'https://teamupdraft.com/updraftplus/features/wordpress-automatic-backup-before-updates?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=automatic_backup&utm_creative_format=advert',
				'campaign' => 'autobackup',
				'button_text' => __('Back up before updates', 'updraftplus'),
				'dismiss_time' => 'dismissautobackup',
				'supported_positions' => $this->autobackup_bottom_or_report,
			),
			'aios' => array(
				'prefix' => '',
				'title' => 'Secure your site',
				'text' => __("The 'All-In-One' Security plugin from TeamUpdraft.", "updraftplus"),
				'image' => 'notices/aios_logo.png',
				'button_link' => 'https://teamupdraft.com/all-in-one-security/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=aios&utm_creative_format=advert',
				'button_text' => 'AIOS',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
			),
			'wp-optimize' => array(
				'prefix' => '',
				'title' => 'WP-Optimize',
				'text' => __("After you've backed up your database, we recommend you install our WP-Optimize plugin to streamline it for better website performance.", "updraftplus"),
				'image' => 'notices/wp_optimize_logo.png',
				'button_link' => 'https://wordpress.org/plugins/wp-optimize/',
				'button_text' => 'WP-Optimize',
				'dismiss_time' => 'dismiss_notice',
				'supported_positions' => $this->anywhere,
				'validity_function' => 'wp_optimize_installed',
			),
			
			// The sale adverts content starts here
			'blackfriday' => array(
				'prefix' => '',
				'title' => __('20% off - Black Friday Sale', 'updraftplus'),
				'text' => $sale_description,
				'text2' => __('at checkout.', 'updraftplus').' <b>'.__('Hurry, offer ends 2 December.', 'updraftplus').'</b>',
				'image' => 'notices/sale_20_25.png',
				'button_text' => sprintf(__('Save 20%% with code %s', 'updraftplus'), 'blackfridaysale2025'),
				'button_link' => 'https://teamupdraft.com/updraftplus/pricing/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=bf25-udp-plugin-banner&utm_content=bf-sale&utm_creative_format=advert',
				'campaign' => 'blackfriday',
				'button_meta' => 'inline',
				'dismiss_time' => 'dismiss_season',
				'valid_from' => '2025-11-14 00:00:00',
				'valid_to' => '2025-12-02 23:59:59',
				'supported_positions' => $this->dashboard_top_or_report,
			)
		);

		return array_merge($parent_notice_content, $child_notice_content);
	}
	
	/**
	 * Call this method to setup the notices
	 */
	public function notices_init() {
		if ($this->initialized) return;
		$this->initialized = true;
		// parent::notices_init();
		$this->notices_content = (defined('UPDRAFTPLUS_NOADS_B') && UPDRAFTPLUS_NOADS_B) ? array() : $this->populate_notices_content();
		global $updraftplus;
		$enqueue_version = $updraftplus->use_unminified_scripts() ? $updraftplus->version.'.'.time() : $updraftplus->version;
		$updraft_min_or_not = $updraftplus->get_updraftplus_file_version();

		wp_enqueue_style('updraftplus-notices-css',  UPDRAFTPLUS_URL.'/css/updraftplus-notices'.$updraft_min_or_not.'.css', array(), $enqueue_version);
	}

	protected function translation_needed($plugin_base_dir = null, $product_name = null) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable, Generic.CodeAnalysis.UnusedFunctionParameter.Found -- Filter use
		return parent::translation_needed(UPDRAFTPLUS_DIR, 'updraftplus');
	}

	/**
	 * This function will check if we should display the rate notice or not
	 *
	 * @return boolean - to indicate if we should show the notice or not
	 */
	protected function show_rate_notice() {
		global $updraftplus;

		$backup_history = UpdraftPlus_Backup_History::get_history();
		
		$backup_dir = $updraftplus->backups_dir_location();
		// N.B. Not an exact proxy for the installed time; they may have tweaked the expert option to move the directory
		$installed = @filemtime($backup_dir.'/index.html');// phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- Silenced to suppress errors that may arise because of the function.
		$installed_for = time() - $installed;

		if (!empty($backup_history) && $installed && $installed_for > 28*86400) {
			return true;
		}

		return false;
	}
	
	protected function wp_optimize_installed($plugin_base_dir = null, $product_name = null) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- Filter use
		if (!function_exists('get_plugins')) include_once(ABSPATH.'wp-admin/includes/plugin.php');
		$plugins = get_plugins();

		foreach ($plugins as $value) {
			if ('wp-optimize' == $value['TextDomain']) {
				return false;
			}
		}
		return true;
	}
	
	protected function url_start($html_allowed, $url, $https = false, $website_home = 'updraftplus.com') {
		return parent::url_start($html_allowed, $url, $https, $website_home);
	}

	protected function skip_seasonal_notices($notice_data) {
		global $updraftplus;

		$time_now = defined('UPDRAFTPLUS_NOTICES_FORCE_TIME') ? UPDRAFTPLUS_NOTICES_FORCE_TIME : time();
		// Do not show seasonal notices to people with an updraftplus.com version and no-addons yet
		if (!file_exists(UPDRAFTPLUS_DIR.'/udaddons') || $updraftplus->have_addons) {
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
	
	protected function check_notice_dismissed($dismiss_time) {

		$time_now = defined('UPDRAFTPLUS_NOTICES_FORCE_TIME') ? UPDRAFTPLUS_NOTICES_FORCE_TIME : time();
	
		$notice_dismiss = ($time_now < UpdraftPlus_Options::get_updraft_option('dismissed_general_notices_until', 0));
		$review_dismiss = ($time_now < UpdraftPlus_Options::get_updraft_option('dismissed_review_notice', 0));
		$seasonal_dismiss = ($time_now < UpdraftPlus_Options::get_updraft_option('dismissed_season_notices_until', 0));
		$autobackup_dismiss = ($time_now < UpdraftPlus_Options::get_updraft_option('updraftplus_dismissedautobackup', 0));

		$dismiss = false;

		if ('dismiss_notice' == $dismiss_time) $dismiss = $notice_dismiss;
		if ('dismiss_review_notice' == $dismiss_time) $dismiss = $review_dismiss;
		if ('dismiss_season' == $dismiss_time) $dismiss = $seasonal_dismiss;
		if ('dismissautobackup' == $dismiss_time) $dismiss = $autobackup_dismiss;

		return $dismiss;
	}

	protected function render_specified_notice($advert_information, $return_instead_of_echo = false, $position = 'top') {
	
		if ('bottom' == $position) {
			$template_file = 'bottom-notice.php';
		} elseif ('report' == $position) {
			$template_file = 'report.php';
		} elseif ('report-plain' == $position) {
			$template_file = 'report-plain.php';
		} elseif ('autobackup' == $position) {
			$template_file = 'autobackup-notice.php';
		} else {
			$template_file = 'horizontal-notice.php';
		}
		
		/*
			Check to see if the updraftplus_com_link filter is being used, if it's not then add our tracking to the link.
		*/
	
		if (!has_filter('updraftplus_com_link') && isset($advert_information['button_link']) && false !== strpos($advert_information['button_link'], '//updraftplus.com')) {
			$advert_information['button_link'] = trailingslashit($advert_information['button_link']).'?afref='.$this->self_affiliate_id;
			if (isset($advert_information['campaign'])) $advert_information['button_link'] .= '&utm_source=updraftplus&utm_medium=banner&utm_campaign='.$advert_information['campaign'];
		}

		updraft_try_include_file('admin.php', 'include_once');
		global $updraftplus_admin;
		return $updraftplus_admin->include_template('wp-admin/notices/'.$template_file, $return_instead_of_echo, $advert_information);
	}

	/**
	 * Checks if Google Drive is the currently selected remote storage service.
	 *
	 * @return bool True if Google Drive is selected, false otherwise.
	 */
	public function is_googledrive_in_use() {
		return in_array('googledrive', (array) UpdraftPlus_Options::get_updraft_option('updraft_service'));
	}

	/**
	 * Checks if Dropbox is the currently selected remote storage service.
	 *
	 * @return bool True if Dropbox is selected, false otherwise.
	 */
	public function is_dropbox_in_use() {
		return in_array('dropbox', (array) UpdraftPlus_Options::get_updraft_option('updraft_service'));
	}

	/**
	 * Checks if Amazon S3 is the currently selected remote storage service.
	 *
	 * @return bool True if Amazon S3 is selected, false otherwise.
	 */
	public function is_s3_in_use() {
		return in_array('s3', (array) UpdraftPlus_Options::get_updraft_option('updraft_service'));
	}
}

$GLOBALS['updraftplus_notices'] = UpdraftPlus_Notices::instance();
