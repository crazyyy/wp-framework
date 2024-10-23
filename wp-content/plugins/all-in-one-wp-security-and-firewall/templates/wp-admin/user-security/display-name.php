<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Display name security', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('When you submit a post or answer a comment, WordPress will usually display your "nickname".', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('By default the nickname is set to the login (or user) name of your account.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('From a security perspective, leaving your nickname the same as your user name is bad practice because it gives a hacker at least half of your account\'s login credentials.', 'all-in-one-wp-security-and-firewall').'
	<br /><br />'.__('Therefore to further tighten your site\'s security you are advised to change your <strong>nickname</strong> and <strong>Display name</strong> to be different from your <strong>Username</strong>.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Modify accounts with identical login name and display name', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$aiowps_feature_mgr->output_feature_details_badge("user-accounts-display-name");

			// now let's find any accounts which have login name same as display name
			$login_nick_name_accounts = AIOWPSecurity_Utility::check_identical_login_and_nick_names();
			if ($login_nick_name_accounts) {
				echo '<div class="aio_red_box"><p>'.__('Your site currently has the following accounts with identical login and display names.', 'all-in-one-wp-security-and-firewall').'<span class="description">('.__('Follow the link to edit the user profile of that particular user account, change Nickname, choose a different Display name compared to Username, and press the "Update Profile" button.', 'all-in-one-wp-security-and-firewall').')</span></p></div>';
		?>
		<table class="form-table">
			<?php
				$edit_user_page = network_site_url().'/wp-admin/user-edit.php?user_id=';
				foreach ($login_nick_name_accounts as $usr) {
					echo '<tr valign="top">';
					// echo '<th scope="row"><label for="UserID'.$usr['ID'].'"> Login Name: </label></th>';
					echo '<td><a href="'.$edit_user_page.$usr['ID'].'" target="_blank">'.$usr['user_login'].'</a></td>';
					echo '</tr>';
				}
			?>
		</table>
		<?php
			} else {
				echo '<div id="aios_message" class="aio_green_box"><p><strong>'.__('No action required.', 'all-in-one-wp-security-and-firewall').'</strong><br/>'.__('Your site does not have a user account where the display name is identical to the username.', 'all-in-one-wp-security-and-firewall').'</p></div>';
			}
		?>
	</div>
</div>