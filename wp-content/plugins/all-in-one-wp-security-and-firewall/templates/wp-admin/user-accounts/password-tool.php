<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Password tool', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('Poor password selection is one of the most common weak points of many sites and is usually the first thing a hacker will try to exploit when attempting to break into your site.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.__('Many people fall into the trap of using a simple word or series of numbers as their password. Such a predictable and simple password would take a competent hacker merely minutes to guess your password by using a simple script which cycles through the easy and most common combinations.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.__('The longer and more complex your password is the harder it is for hackers to "crack" because more complex passwords require much greater computing power and time.', 'all-in-one-wp-security-and-firewall').'</p>'.
	'<p>'.__('This section contains a useful password strength tool which you can use to check whether your password is sufficiently strong enough.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Password strength tool', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_grey_box aio_half_width"><p><?php _e('This password tool uses an algorithm which calculates how long it would take for your password to be cracked using the computing power of an off-the-shelf current model desktop PC with high end processor, graphics card and appropriate password cracking software.', 'all-in-one-wp-security-and-firewall');?></p></div>
		<div class="aiowps_password_tool_field">
			<input size="40" id="aiowps_password_test" name="aiowps_password_test" type="text" />
			<div class="description"><?php _e('Start typing a password.', 'all-in-one-wp-security-and-firewall'); ?></div>
		</div>
		<div id="aiowps_pw_tool_main">
			<div class="aiowps_password_crack_info_text"><?php _e('It would take a desktop PC approximately', 'all-in-one-wp-security-and-firewall'); ?>
			<div id="aiowps_password_crack_time_calculation"><?php _e('1 sec', 'all-in-one-wp-security-and-firewall'); ?></div> <?php _e('to crack your password!', 'all-in-one-wp-security-and-firewall'); ?></div>
			<!-- The rotating arrow -->
			<div class="arrowCap"></div>
			<div class="arrow"></div>

			<p class="meterText"><?php _e('Password Strength', 'all-in-one-wp-security-and-firewall'); ?></p>
		</div>
	</div>
</div>