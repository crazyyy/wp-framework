<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Prevent user enumeration', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="disable-users-enumeration-badge">
			<?php
			//Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("disable-users-enumeration");
			?>
		</div>
		<form action="" method="POST" id="aios-users-enumeration-form">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.sprintf(__('This feature allows you to prevent external users/bots from fetching the user info with URLs like "%s", "%s", oEmbed request.', 'all-in-one-wp-security-and-firewall'), '/?author=1', '/'.rest_get_url_prefix().'/wp/v2/users').'</p>';
					echo '<p>'.__('When enabled, this feature will print a "forbidden" error rather than the user information.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Disable user enumeration', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to stop user enumeration.', 'all-in-one-wp-security-and-firewall'), 'aiowps_prevent_users_enumeration', '1' == $aio_wp_security->configs->get_value('aiowps_prevent_users_enumeration')); ?>
						</div>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_users_enumeration" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>