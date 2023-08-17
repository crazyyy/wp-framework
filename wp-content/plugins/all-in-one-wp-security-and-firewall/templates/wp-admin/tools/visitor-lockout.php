<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('General visitor lockout', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-site-lockout'); ?>
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to put your site into "maintenance mode" by locking down the front-end to all visitors except logged in users with super admin privileges.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.__('Locking your site down to general visitors can be useful if you are investigating some issues on your site or perhaps you might be doing some maintenance and wish to keep out all traffic for security reasons.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable front-end lockout', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_site_lockout" name="aiowps_site_lockout" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_site_lockout')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_site_lockout" class="description"><?php _e('Check this if you want all visitors except those who are logged in as administrator to be locked out of the front-end of your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_site_lockout_msg_editor_content"><?php _e('Enter a message:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<?php
							$aiowps_site_lockout_msg_raw = $aio_wp_security->configs->get_value('aiowps_site_lockout_msg');
							if (empty($aiowps_site_lockout_msg_raw)) {
								$aiowps_site_lockout_msg_raw = 'This site is currently not available. Please try again later.';
							}
							$aiowps_site_lockout_msg = html_entity_decode($aiowps_site_lockout_msg_raw, ENT_COMPAT, "UTF-8");
							$aiowps_site_lockout_msg_settings = array('textarea_name' => 'aiowps_site_lockout_msg');
							wp_editor($aiowps_site_lockout_msg, "aiowps_site_lockout_msg_editor_content", $aiowps_site_lockout_msg_settings);
						?>
						<br/>
						<span class="description"><?php _e('Enter a message you wish to display to visitors when your site is in maintenance mode.', 'all-in-one-wp-security-and-firewall');?></span>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_site_lockout" value="<?php _e('Save site lockout settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>