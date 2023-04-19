<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<p><?php echo __('The WHOIS lookup feature gives you a way to look up who owns an IP address or domain name.', 'all-in-one-wp-security-and-firewall').' '.__('You can use this to investigate users engaging in malicious activity on your site.', 'all-in-one-wp-security-and-firewall'); ?></p>
</div>
<div class="postbox">
	<h3 class="hndle"><?php _e('WHOIS lookup on IP or domain', 'all-in-one-wp-security-and-firewall'); ?></h3>
	<div class="inside">
		<form method="post" action="">
			<?php wp_nonce_field('aiowpsec-whois-lookup'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_whois_ip_or_domain"><?php _e('IP address or domain name:', 'all-in-one-wp-security-and-firewall'); ?></label>
					</th>
					<td>
						<input id="aiowps_whois_ip_or_domain" type="text" name="aiowps_whois_ip_or_domain" value="" size="80">
					</td>
				</tr>
			</table>
			<input class="button-primary" type="submit" value="<?php _e('Look up IP or domain', 'all-in-one-wp-security-and-firewall'); ?>">
		</form>
	</div>
</div>
<?php
if ($lookup) {
?>
<div class="postbox">
	<h3 class="hndle">
		<table>
			<tr valign="top">
				<th scope="row">WHOIS: </th>
				<td><?php echo htmlspecialchars($ip_or_domain); ?></td>
			</tr>
		</table>
	</h3>
	<div class="inside">
		<pre>
			<?php
				$invalid_domain = false;
				if (empty($ip_or_domain)) {
					$invalid_domain = true;
				} elseif (version_compare(phpversion(), '5.6', '>')) {
					if (!(filter_var($ip_or_domain, FILTER_VALIDATE_IP) || filter_var($ip_or_domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME))) $invalid_domain = true; // phpcs:ignore PHPCompatibility.Constants.NewConstants.filter_validate_domainFound
				}
				if ($invalid_domain) {
					$AIOWPSecurity_Tools_Menu->show_msg_error(__('Please enter a valid IP address or domain name to look up.', 'all-in-one-wp-security-and-firewall'));
					_e('Nothing to show.', 'all-in-one-wp-security-and-firewall');
				} else {
					$result = $AIOWPSecurity_Tools_Menu->whois_lookup($ip_or_domain);

					if (is_wp_error($result)) {
						$AIOWPSecurity_Tools_Menu->show_msg_error(htmlspecialchars($result->get_error_message()));
						_e('Nothing to show.', 'all-in-one-wp-security-and-firewall');
					} else {
						echo htmlspecialchars($result);
					}
				}
			?>
		</pre>
	</div>
</div>
<?php
}