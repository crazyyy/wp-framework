<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Tools_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * Tools menu slug
	 *
	 * @var string
	 */
	protected $menu_page_slug = AIOWPSEC_TOOLS_MENU_SLUG;

	/**
	 * Constructor adds menu for Tools
	 */
	public function __construct() {
		parent::__construct(__('Tools', 'all-in-one-wp-security-and-firewall'));
	}


	/**
	 * This function will setup the menus tabs by setting the array $menu_tabs
	 *
	 * @return void
	 */
	protected function setup_menu_tabs() {
		$menu_tabs = array(
			'password-tool' => array(
				'title' => __('Password tool', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_password_tool'),
			),
			'whois-lookup' => array(
				'title' => __('WHOIS lookup', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_whois_lookup_tab'),
			),
			'custom-rules' => array(
				'title' => __('Custom .htaccess rules', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_custom_rules'),
				'display_condition_callback' => array('AIOWPSecurity_Utility_Permissions', 'is_main_site_and_super_admin'),
			),
			'visitor-lockout' => array(
				'title' => __('Visitor lockout', 'all-in-one-wp-security-and-firewall'),
				'render_callback' => array($this, 'render_visitor_lockout'),
			),
		);
		
		$this->menu_tabs = array_filter($menu_tabs, array($this, 'should_display_tab'));
	}

	/**
	 * Render the 'Custom (htaccess) rules' tab
	 *
	 * @return void
	 */
	protected function render_custom_rules() {
		global $aio_wp_security;

		if (isset($_POST['aiowps_save_custom_rules_settings'])) { // Do form submission tasks
		
			if (is_wp_error(AIOWPSecurity_Utility_Permissions::check_nonce_and_user_cap($_POST['_wpnonce'], 'aiowpsec-save-custom-rules-settings-nonce'))) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed for save custom rules settings.", 4);
				die('Nonce check failed for save custom rules settings.');
			}

			//Save settings
			if (isset($_POST["aiowps_enable_custom_rules"]) && empty($_POST['aiowps_custom_rules'])) {
				$this->show_msg_error(__('You must enter some .htaccess directives code in the text box below', 'all-in-one-wp-security-and-firewall'));
			} else {
				if (!empty($_POST['aiowps_custom_rules'])) {
					// Undo magic quotes that are automatically added to `$_GET`,
					// `$_POST`, `$_COOKIE`, and `$_SERVER` by WordPress as
					// they corrupt any custom rule with backslash in it...
					$aio_wp_security->configs->set_value('aiowps_custom_rules', stripslashes($_POST['aiowps_custom_rules']));
				} else {
					$aio_wp_security->configs->set_value('aiowps_custom_rules', ''); //Clear the custom rules config value
				}

				$aio_wp_security->configs->set_value('aiowps_enable_custom_rules', isset($_POST["aiowps_enable_custom_rules"]) ? '1' : '');
				$aio_wp_security->configs->set_value('aiowps_place_custom_rules_at_top', isset($_POST["aiowps_place_custom_rules_at_top"]) ? '1' : '');
				$aio_wp_security->configs->save_config(); //Save the configuration

				$this->show_msg_settings_updated();

				$write_result = AIOWPSecurity_Utility_Htaccess::write_to_htaccess(); //now let's write to the .htaccess file
				if (!$write_result) {
					$this->show_msg_error(__('The plugin was unable to write to the .htaccess file, please edit file manually.', 'all-in-one-wp-security-and-firewall'));
					$aio_wp_security->debug_logger->log_debug("Custom Rules feature - The plugin was unable to write to the .htaccess file.");
				}
			}
		}

		$aio_wp_security->include_template('wp-admin/tools/custom-htaccess.php');
	}

	/**
	 * Renders the submenu's password tool tab
	 *
	 * @return Void
	 */
	protected function render_password_tool() {
		global $aio_wp_security;

		wp_enqueue_script('aiowpsec-pw-tool-js');
		$aio_wp_security->include_template('wp-admin/tools/password-tool.php');
	}

	/**
	 * Does a WHOIS lookup on an IP address or domain name and then returns the result.
	 *
	 * @param String  $search  - IP address or domain name to do a WHOIS lookup on
	 * @param Integer $timeout - connection timeout for fsockopen
	 *
	 * @return String|WP_Error - returns preformatted WHOIS lookup result or WP_Error
	 */
	public function whois_lookup($search, $timeout = 10) {
		$fp = @fsockopen('whois.iana.org', 43, $errno, $errstr, $timeout);

		if (!$fp) {
			return new WP_Error('whois_lookup_failed', 'whois.iana.org: Socket Error '.$errno.' - '.$errstr);
		}

		$queries = sprintf(__('Querying %s: %s', 'all-in-one-wp-security-and-firewall'), 'whois.iana.org', $search)."\n";

		fputs($fp, $search."\r\n");
		$out = '';
		while (!feof($fp)) {
			$line = fgets($fp);
			if (preg_match('/refer: +(\S+)/', $line, $matches)) {
				$referral_server = $matches[1];
				$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
				break;
			}
			$out .= $line;
		}
		fclose($fp);

		if (!isset($referral_server) && filter_var($search, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) && preg_match('/whois: +(\S+)/', $out, $matches)) {
			$referral_server = $matches[1];
			$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
		}

		$referrals = array();

		while (isset($referral_server)) {
			$referrals[] = $referral_server;

			$fp = @fsockopen($referral_server, 43, $errno, $errstr, $timeout);

			if (!$fp) {
				return new WP_Error('whois_lookup_failed', $referral_server.': Socket Error '.$errno.' - '.$errstr);
			}

			if ('whois.arin.net' == $referral_server) {
				$formatted_search = 'n + '.$search;
			} elseif ('whois.denic.de' == $referral_server) {
				$formatted_search = '-T dn,ace '.$search;
			} elseif ('whois.dk-hostmaster.dk' == $referral_server) {
				$formatted_search = '--charset=utf-8 --show-handles '.$search;
			} elseif ('whois.nic.ad.jp' == $referral_server || 'whois.jprs.jp' == $referral_server) {
				$formatted_search = $search.'/e';
			} else {
				$formatted_search = $search;
			}

			$queries .= sprintf(__('Querying %s: %s', 'all-in-one-wp-security-and-firewall'), $referral_server, $formatted_search)."\n";

			$referral_server = null;

			fputs($fp, $formatted_search."\r\n");
			$out = '';
			while (!feof($fp)) {
				$line = fgets($fp);
				if (preg_match('/Registrar WHOIS Server: +(\S+)/', $line, $matches)
					|| preg_match('/% referto: +whois -h (\S+)/', $line, $matches)
					|| preg_match('/% referto: +(\S+)/', $line, $matches)
					|| preg_match('/ReferralServer: +rwhois:\/\/(\S+)/', $line, $matches)
					|| preg_match('/ReferralServer: +whois:\/\/(\S+)/', $line, $matches)
				) {
					if (!in_array($matches[1], $referrals)) {
						$referral_server = $matches[1];
						$queries .= sprintf(__('Redirected to %s', 'all-in-one-wp-security-and-firewall'), $referral_server)."\n";
						break;
					}
				}
				$out .= $line;
			}
			fclose($fp);
		}

		return $queries."\n".$out;
	}

	/**
	 * Renders the submenu's whois-lookup tab body.
	 *
	 * @return Void
	 */
	protected function render_whois_lookup_tab() {
		global $aio_wp_security;
		
		$lookup = false;
		$ip_or_domain = '';
		
		if (isset($_POST['aiowps_whois_ip_or_domain'])) {
			$nonce = $_POST['_wpnonce'];

			if (!wp_verify_nonce($nonce, 'aiowpsec-whois-lookup')) {
				$aio_wp_security->debug_logger->log_debug('Nonce check failed on WHOIS lookup.', 4);
				die('Nonce check failed on WHOIS lookup.');
			}
			$lookup = true;
			$ip_or_domain = stripslashes($_POST['aiowps_whois_ip_or_domain']);
		}

		$aio_wp_security->include_template('wp-admin/tools/whois-lookup.php', false, array('AIOWPSecurity_Tools_Menu' => $this, 'lookup' => $lookup, 'ip_or_domain' => $ip_or_domain));
	}

	/**
	 * Renders the submenu's visitor lockout tab
	 *
	 * @return void
	 */
	protected function render_visitor_lockout() {
		global $aio_wp_security;
		$maint_msg = '';
		if (isset($_POST['aiowpsec_save_site_lockout'])) {
			$nonce = $_REQUEST['_wpnonce'];
			if (!wp_verify_nonce($nonce, 'aiowpsec-site-lockout')) {
				$aio_wp_security->debug_logger->log_debug("Nonce check failed on site lockout feature settings save.", 4);
				die("Nonce check failed on site lockout feature settings save.");
			}

			// Save settings
			$aio_wp_security->configs->set_value('aiowps_site_lockout', isset($_POST["aiowps_site_lockout"]) ? '1' : '');
			$maint_msg = htmlentities(stripslashes($_POST['aiowps_site_lockout_msg']), ENT_COMPAT, "UTF-8");
			$aio_wp_security->configs->set_value('aiowps_site_lockout_msg', $maint_msg); // Text area/msg box
			$aio_wp_security->configs->save_config();

			$this->show_msg_updated(__('Site lockout feature settings saved.', 'all-in-one-wp-security-and-firewall'));

			do_action('aiowps_site_lockout_settings_saved'); // Trigger action hook.

		}

		$aio_wp_security->include_template('wp-admin/tools/visitor-lockout.php', false, array());
	}

} // End of class
