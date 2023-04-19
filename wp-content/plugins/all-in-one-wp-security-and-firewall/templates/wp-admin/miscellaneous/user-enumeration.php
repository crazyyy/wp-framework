<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Prevent users enumeration', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-users-enumeration'); ?>
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to prevent external users/bots from fetching the user info with urls like "/?author=1".', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.__('When enabled, this feature will print a "forbidden" error rather than the user information.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Disable users enumeration', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_prevent_users_enumeration" name="aiowps_prevent_users_enumeration" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_prevent_users_enumeration')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_prevent_users_enumeration" class="description"><?php _e('Check this if you want to stop users enumeration.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_users_enumeration" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>