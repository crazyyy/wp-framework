<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Admin user security', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('Depending on  how you installed WordPress, you could have a default administrator with the username "admin".', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('Hackers can try to take advantage of this information by attempting "Brute force login attacks" where they repeatedly try to guess the password by using "admin" for username.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('From a security perspective, changing the username "admin" is one of the first and smartest things you should do on your site.', 'all-in-one-wp-security-and-firewall').'
	<br /><br />'.__('This feature will allow you to change your "admin" username to a more secure name of your choosing.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<?php
// display a list of all administrator accounts for this site
$postbox_title = __('List of administrator accounts', 'all-in-one-wp-security-and-firewall');
$AIOWPSecurity_User_Accounts_Menu->postbox($postbox_title, $user_accounts);

if (!is_super_admin()) {
	// Hide config settings if multisite and not super admin.
	AIOWPSecurity_Utility::display_multisite_super_admin_message();
} else {
?>
<div class="postbox">
<h3 class="hndle"><label for="title"><?php _e('Change admin username', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$aiowps_feature_mgr->output_feature_details_badge("user-accounts-change-admin-user");

			if (AIOWPSecurity_Utility::check_user_exists('admin') || AIOWPSecurity_Utility::check_user_exists('Admin')) {
				echo '<div class="aio_red_box"><p>'.__('Your site currently has an account which uses the "admin" username. It is highly recommended that you change this name to something else. Use the following field to change the admin username.', 'all-in-one-wp-security-and-firewall').'</p></div>';
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-change-admin-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_new_user_name"><?php _e('New admin username', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input type="text" size="16" id="aiowps_new_user_name" name="aiowps_new_user_name" />
					<p class="description"><?php _e('Choose a new username for admin.', 'all-in-one-wp-security-and-firewall'); ?></p>
					</td> 
				</tr>
			</table>
			<input type="submit" name="aiowps_change_admin_username" value="<?php _e('Change username', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
			<div class="aio_spacer_15"></div>
			<p class="description"><?php _e('NOTE: If you are currently logged in as "admin" you will be automatically logged out after changing your username and will be required to log back in.', 'all-in-one-wp-security-and-firewall'); ?></p>
		</form>
		<?php
			} else {
				echo '<div id="aios_message" class="aio_green_box"><p><strong>';
				_e('No action required! ', 'all-in-one-wp-security-and-firewall');
				echo '</strong><br />';
				_e('Your site does not have any account which uses the "admin" username. ', 'all-in-one-wp-security-and-firewall');
				_e('This is good security practice.', 'all-in-one-wp-security-and-firewall');
				echo '</p></div>';
			}
		?>
	</div>
</div>
<?php
} // End if statements
