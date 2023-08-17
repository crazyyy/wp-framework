<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<?php

$info = array(
	'password-tool' => array(
		'title' => __('Password tool', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_TOOLS_MENU_SLUG.'&tab=password-tool',
	),
	'visitor-lockout' => array(
		'title' => __('Visitor lockout', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_TOOLS_MENU_SLUG.'&tab=visitor-lockout',
	),
	'registration-captcha' => array(
		'title' => __('Registration captcha', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=captcha-settings',
	),
	'comment-captcha' => array(
		'title' => __('Comment captcha', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=captcha-settings',
	),
	'buddypress-captcha' => array(
		'title' => __('BuddyPress captcha', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=captcha-settings',
	),
	'bbpress-captcha' => array(
		'title' => __('bbPress captcha', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=captcha-settings',
	),
	'acct_activity_list' => array(
		'title' => __('Account activity'),
		'uri' => AIOWPSEC_MAIN_MENU_SLUG.'&tab=audit-logs',
	),
	'custom-rules' => array(
		'title' => __('\'Custom .htaccess rules\'', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_TOOLS_MENU_SLUG.'&tab=custom-rules',
	),
	'prevent-hotlinks' => array(
		'title' => __('Prevent hotlinks', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_FILESYSTEM_MENU_SLUG.'&tab=file-protection',
	),
	'registration-honeypot' => array(
		'title' => __('Registration honeypot', 'all-in-one-wp-security-and-firewall'),
		'uri' => AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=honeypot',
	)
);
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php echo $info[$key]['title']; ?></label></h3>
	<div class="inside">
		<?php
			$new_location_link = '<a href="admin.php?page='.$info[$key]['uri'].'">' . __('here', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_orange_box"><p>';
			echo sprintf(__('The %s feature is now located %s.', 'all-in-one-wp-security-and-firewall'), $info[$key]['title'], $new_location_link) . ' ' . __('This page will be removed in a future release.', 'all-in-one-wp-security-and-firewall');
			echo '</p></div>';
		?>
	</div>
</div>