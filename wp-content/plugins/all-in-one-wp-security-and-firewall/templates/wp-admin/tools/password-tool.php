<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Password tool', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.esc_html__('Poor password selection is one of the most common weak points of many sites and is usually the first thing a hacker will try to exploit when attempting to break into your site.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.esc_html__('Many people fall into the trap of using a simple word or series of numbers as their password.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Such a predictable and simple password would take a competent hacker merely minutes to guess your password by using a simple script which cycles through the easy and most common combinations.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.esc_html__('The longer and more complex your password is the harder it is for hackers to "crack" because more complex passwords require much greater computing power and time.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.esc_html__('This section contains a useful password strength tool which you can use to check whether your password is sufficiently strong enough.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Password strength tool', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_grey_box"><p><?php esc_html_e('This password tool uses an algorithm which calculates how long it would take for your password to be cracked using the computing power of an off-the-shelf current model desktop PC with high end processor, graphics card and appropriate password cracking software.', 'all-in-one-wp-security-and-firewall');?></p></div>
		<div class="aiowps_password_tool_field">
			<input size="40" id="aiowps_password_test" name="aiowps_password_test" type="text" placeholder="<?php esc_html_e('Start typing a password.', 'all-in-one-wp-security-and-firewall');?>" />
			<div class="aios_password_meter">
				<div class="aios_meter_bar">
					<div id="aios_meter_fill"></div>
				</div>
			</div>
			<div id="aiowps_pw_tool_main">
				<?php $hibp_link = '<a href="admin.php?page=' . AIOWPSEC_USER_SECURITY_MENU_SLUG . '&tab=hibp" target="_blank">' . __('HIBP', 'all-in-one-wp-security-and-firewall') . '</a>'; ?>
				<span id="aiowps_password_crack_info_text"><?php printf(esc_html__('It would take a desktop PC approximately %s to crack your password!', 'all-in-one-wp-security-and-firewall'), '<span id="aiowps_password_crack_time_calculation">' . __('1 sec', 'all-in-one-wp-security-and-firewall') . '</span>'); ?></span>
				<?php /* translators: %s HIBP link. */ ?>
				<span id="aiowps_password_hibp_info_text"><?php printf(esc_html__('Pwned according to %s', 'all-in-one-wp-security-and-firewall'), $hibp_link); ?></span>
			</div>
		</div>
	</div>
</div>