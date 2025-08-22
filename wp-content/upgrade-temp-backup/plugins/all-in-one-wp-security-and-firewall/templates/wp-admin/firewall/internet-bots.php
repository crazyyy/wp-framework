<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Internet bot settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	$info_msg = '';
	$wiki_link = '<a href="http://en.wikipedia.org/wiki/Internet_bot" target="_blank">'.__('What is an Internet Bot', 'all-in-one-wp-security-and-firewall').'</a>';
	$info_msg .= '<p><strong>'.sprintf(__('%s?', 'all-in-one-wp-security-and-firewall'), $wiki_link).'</strong></p>';

	$info_msg .= '<p>'. __('A bot is a piece of software which runs on the Internet and performs automatic tasks.', 'all-in-one-wp-security-and-firewall') . ' ' . __('For example when Google indexes your pages it uses bots to achieve this task.', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'. __('A lot of bots are legitimate and non-malicious but not all bots are good and often you will find some which try to impersonate legitimate bots such as "Googlebot" but in reality they have nohing to do with Google at all.', 'all-in-one-wp-security-and-firewall').'</p>';
	$info_msg .= '<p>'. __('Although most of the bots out there are relatively harmless sometimes website owners want to have more control over which bots they allow into their site.', 'all-in-one-wp-security-and-firewall').'</p>';
	echo $info_msg;
	?>
</div>
<form action=""  id="aios-internet-bots-settings-form">

	<?php $aio_wp_security->include_template('wp-admin/firewall/partials/fake-googlebots.php'); ?>
	<?php $aio_wp_security->include_template('wp-admin/firewall/partials/blank-ref-and-useragent.php'); ?>
	<input type="submit" name="aiowps_save_internet_bot_settings" value="<?php _e('Save internet bot settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>
