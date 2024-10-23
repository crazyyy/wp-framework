<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<p><?php echo __('The WHOIS lookup feature gives you a way to look up who owns an IP address or domain name.', 'all-in-one-wp-security-and-firewall').' '.__('You can use this to investigate users engaging in malicious activity on your site.', 'all-in-one-wp-security-and-firewall'); ?></p>
</div>
<div class="postbox">
	<h3 class="hndle"><?php _e('WHOIS lookup on IP or domain', 'all-in-one-wp-security-and-firewall'); ?></h3>
	<div class="inside">
		<form method="post" action="" id="aiowpsec-whois-lookup-form">
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
<div id="aios-who-is-lookup-result-container">
</div>
