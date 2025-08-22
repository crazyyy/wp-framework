<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Admin user security', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.esc_html__('Depending on  how you installed WordPress, you could have a default administrator with the username "admin".', 'all-in-one-wp-security-and-firewall').'
	<br />'.esc_html__('Hackers can try to take advantage of this information by attempting "Brute force login attacks" where they repeatedly try to guess the password by using "admin" for username.', 'all-in-one-wp-security-and-firewall').'
	<br />'.esc_html__('From a security perspective, changing the username "admin" is one of the first and smartest things you should do on your site.', 'all-in-one-wp-security-and-firewall').'
	<br /><br />'.esc_html__('This feature will allow you to change your "admin" username to a more secure name of your choosing.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<?php
// display a list of all administrator accounts for this site
$postbox_title = esc_html__('List of administrator accounts', 'all-in-one-wp-security-and-firewall');
$AIOWPSecurity_User_Security_Menu->postbox($postbox_title, $user_accounts);

if (!is_super_admin()) {
	// Hide config settings if multisite and not super admin.
	AIOWPSecurity_Utility::display_multisite_super_admin_message();
} else {
?>
<div class="postbox">
<h3 class="hndle"><label for="title"><?php esc_html_e('Change admin username', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="user-accounts-change-admin-user-badge">
			<?php
			$aiowps_feature_mgr->output_feature_details_badge("user-accounts-change-admin-user");
			?>
		</div>
		<div id="change-admin-username-content">
			<?php
			$aio_wp_security->include_template('wp-admin/user-security/partials/wp-username-content.php', false);
			?>
		</div>
	</div>
</div>
<?php
} // End if statements
