<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class AIOWPSecurity_Tools_Menu extends AIOWPSecurity_Admin_Menu {

	/**
	 * All tab keys, titles and render callbacks.
	 *
	 * @var Array
	 */
	protected $menu_tabs;

	/**
	 * Renders the submenu's current tab page.
	 *
	 * @return Void
	 */
	public function __construct() {
		$this->render_menu_page();
	}

	/**
	 * Populates $menu_tabs array.
	 *
	 * @return Void
	 */
	private function set_menu_tabs() {
		$this->menu_tabs = apply_filters('aiowpsecurity_tools_tabs',
			array(
				'whois-lookup' => array(
					'title' => __('WHOIS lookup', 'all-in-one-wp-security-and-firewall'),
					'render_callback' => array($this, 'render_whois_lookup_tab'),
				)
			)
		);
	}

	/**
	 * Renders the submenu's tabs as nav items.
	 *
	 * @return Void
	 */
	private function render_menu_tabs() {
		$current_tab = $this->get_current_tab();

		echo '<h2 class="nav-tab-wrapper">';
		foreach ($this->menu_tabs as $tab_key => $tab_info) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab '.$active.'" href="?page='.AIOWPSEC_TOOLS_MENU_SLUG.'&tab='.$tab_key.'">'.esc_html($tab_info['title']).'</a>';
		}
		echo '</h2>';
	}

	/**
	 * Renders the submenu's current tab page.
	 *
	 * @return Void
	 */
	private function render_menu_page() {
		echo '<div class="wrap">'; // Start of wrap
		echo '<h2>'.__('Tools', 'all-in-one-wp-security-and-firewall').'</h2>'; // Interface title
		$this->set_menu_tabs();
		$tab = $this->get_current_tab();
		$this->render_menu_tabs();

		?>
		<div id="poststuff">
			<div id="post-body">
				<?php call_user_func($this->menu_tabs[$tab]['render_callback']); ?>
			</div>
		</div>
		<?php

		echo '</div>'; // End of wrap
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
				if (preg_match('/Registrar WHOIS Server: +(\S+)/', $line, $matches) ||
					preg_match('/% referto: +whois -h (\S+)/', $line, $matches) ||
					preg_match('/% referto: +(\S+)/', $line, $matches) ||
					preg_match('/ReferralServer: +rwhois:\/\/(\S+)/', $line, $matches) ||
					preg_match('/ReferralServer: +whois:\/\/(\S+)/', $line, $matches)) {
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
	private function render_whois_lookup_tab() {
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

} // End of class
