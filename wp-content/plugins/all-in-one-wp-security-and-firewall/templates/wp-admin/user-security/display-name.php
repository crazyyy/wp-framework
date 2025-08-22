<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Display name security', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.esc_html__('When you submit a post or answer a comment, WordPress will usually display your "nickname".', 'all-in-one-wp-security-and-firewall');
	echo '<br />'.esc_html__('By default the nickname is set to the login (or user) name of your account.', 'all-in-one-wp-security-and-firewall');
	echo '<br />'.esc_html__('From a security perspective, leaving your nickname the same as your user name is bad practice because it gives a hacker at least half of your account\'s login credentials.', 'all-in-one-wp-security-and-firewall');
	/* translators: 1. Open strong tag, 2. Close strong tag. */
	echo '<br /><br />'.sprintf(esc_html__('Therefore to further tighten your site\'s security you are advised to change your %1$snickname%2$s and  %1$sDisplay name%2$s to be different from your %1$sUsername%2$s.', 'all-in-one-wp-security-and-firewall'), '<strong>', '</strong>');
	echo '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Modify accounts with identical login name and display name', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$aiowps_feature_mgr->output_feature_details_badge("user-accounts-display-name");

			// now let's find any accounts which have login name same as display name
			$login_nick_name_accounts = AIOWPSecurity_Utility::check_identical_login_and_nick_names();
			if ($login_nick_name_accounts) {
				echo '<div class="aio_red_box"><p>'.esc_html__('Your site currently has the following accounts with identical login and display names.', 'all-in-one-wp-security-and-firewall').'<span class="description">('.esc_html__('Follow the link to edit the user profile of that particular user account, change Nickname, choose a different Display name compared to Username, and press the "Update Profile" button.', 'all-in-one-wp-security-and-firewall').')</span></p></div>';
		?>
		<table class="form-table">
			<?php
				$edit_user_page = network_site_url('wp-admin/user-edit.php?user_id=');
				foreach ($login_nick_name_accounts as $usr) {
					echo '<tr valign="top">';
					// echo '<th scope="row"><label for="UserID'.$usr['ID'].'"> Login Name: </label></th>';
					echo '<td><a href="' . esc_url($edit_user_page) . esc_attr($usr['ID']) . '" target="_blank">' . esc_html($usr['user_login']) . '</a></td>';
					echo '</tr>';
				}
			?>
		</table>
		<?php
			} else {
				echo '<div id="aios_message" class="aio_green_box"><p><strong>'.esc_html__('No action required.', 'all-in-one-wp-security-and-firewall').'</strong><br/>'.esc_html__('Your site does not have a user account where the display name is identical to the username.', 'all-in-one-wp-security-and-firewall').'</p></div>';
			}
		?>
	</div>
</div>