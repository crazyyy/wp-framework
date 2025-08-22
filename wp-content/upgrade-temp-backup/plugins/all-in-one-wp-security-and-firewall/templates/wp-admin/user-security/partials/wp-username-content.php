<?php
if (AIOWPSecurity_Utility::check_user_exists('admin') || AIOWPSecurity_Utility::check_user_exists('Admin')) {
	echo '<div class="aio_red_box"><p>' . esc_html__('Your site currently has an account which uses the "admin" username.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('It is highly recommended that you change this name to something else.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Use the following field to change the admin username.', 'all-in-one-wp-security-and-firewall').'</p></div>';
	?>
	<form action="" method="POST" id="aios-change-admin-username-form">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="aiowps_new_user_name"><?php esc_html_e('New admin username', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
				<td><input type="text" size="16" id="aiowps_new_user_name" name="aiowps_new_user_name" />
					<p class="description"><?php esc_html_e('Choose a new username for admin.', 'all-in-one-wp-security-and-firewall'); ?></p>
				</td>
			</tr>
		</table>
		<input type="submit" name="aiowps_change_admin_username" value="<?php esc_html_e('Change username', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		<div class="aio_spacer_15"></div>
		<p class="description"><?php esc_html_e('NOTE: If you are currently logged in as "admin" you will be automatically logged out after changing your username and will be required to log back in.', 'all-in-one-wp-security-and-firewall'); ?></p>
	</form>
	<?php
} else {
	echo '<div id="aios_message" class="aio_green_box"><p><strong>';
	esc_html_e('No action required.', 'all-in-one-wp-security-and-firewall');
	echo '</strong><br />';
	echo esc_html__('Your site does not have any account which uses the "admin" username.', 'all-in-one-wp-security-and-firewall');
	esc_html_e('This is good security practice.', 'all-in-one-wp-security-and-firewall');
	echo '</p></div>';
}