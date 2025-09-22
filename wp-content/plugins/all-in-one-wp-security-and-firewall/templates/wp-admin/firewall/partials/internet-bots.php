<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="internet-bots">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Internet bot settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<?php
			$info_msg = '';
			$wiki_link = '<a href="http://en.wikipedia.org/wiki/Internet_bot" target="_blank">'.esc_html__('What is an Internet Bot', 'all-in-one-wp-security-and-firewall').'</a>';
			/* translators: s%: Wiki URL. */
			$info_msg .= '<p><strong>'.sprintf(__('%s?', 'all-in-one-wp-security-and-firewall'), $wiki_link).'</strong></p>';

			$info_msg .= '<p>'. esc_html__('A bot is a piece of software which runs on the Internet and performs automatic tasks.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('For example when Google indexes your pages it uses bots to achieve this task.', 'all-in-one-wp-security-and-firewall').'</p>';
			$info_msg .= '<p>'. esc_html__('A lot of bots are legitimate and non-malicious but not all bots are good and often you will find some which try to impersonate legitimate bots such as "Googlebot" but in reality they have nohing to do with Google at all.', 'all-in-one-wp-security-and-firewall').'</p>';
			$info_msg .= '<p>'. esc_html__('Although most of the bots out there are relatively harmless sometimes website owners want to have more control over which bots they allow into their site.', 'all-in-one-wp-security-and-firewall').'</p>';
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Variable already escaped.
			echo $info_msg;
			?>
		</div>

		<?php $aio_wp_security->include_template('wp-admin/firewall/partials/fake-googlebots.php'); ?>
		<?php $aio_wp_security->include_template('wp-admin/firewall/partials/blank-ref-and-useragent.php'); ?>
	</div>
</div>
