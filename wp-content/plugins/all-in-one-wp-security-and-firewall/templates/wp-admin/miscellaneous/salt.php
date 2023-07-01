<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Add salt postfix', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aios-salt-postfix-settings'); ?>
			<div class="aio_blue_box">
				<?php
				echo '<p>'.htmlspecialchars(__('WordPress "salts" are secret phrases which are combined with user passwords when those passwords are stored, with the end result that they become much harder for an attacker to crack even if he managed to steal the database of your website.', 'all-in-one-wp-security-and-firewall')).' <a href="https://aiosplugin.com/wordpress-salts-adding-extra-security/" target="_blank">'.__('For more information about WordPress salts, follow this link.', 'all-in-one-wp-security-and-firewall').'</a></p>';
				?>
			</div>
			<div class="aio_orange_box">
				<p>
					<?php
					_e('When you enable this feature, you and all other logged-in users will be logged out so that AIOS can append the additional code (the salt) to all users’ login information.', 'all-in-one-wp-security-and-firewall');
					?>
				</p>
			</div>

			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label>
							<?php _e('Enable salt postfix', 'all-in-one-wp-security-and-firewall'); ?>:
						</label>
					</th>
					<td>
						<input id="aiowps_enable_salt_postfix" name="aiowps_enable_salt_postfix" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_salt_postfix'), '1'); ?> value="1"/>
						<label for="aiowps_enable_salt_postfix" class="description"><?php _e('Check this if you want to enable the salt postfix feature.', 'all-in-one-wp-security-and-firewall'); ?><?php _e('These salt postfixes are changed every week by a scheduled job.', 'all-in-one-wp-security-and-firewall'); ?></label>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
							echo '<p class="description">'.__('This setting will suffix the salt with an additional 64 characters.', 'all-in-one-wp-security-and-firewall').' '.__("It improves your WordPress site's cryptographic mechanism.", 'all-in-one-wp-security-and-firewall').'</p>';
							?>
						</div>
					</td>
				</tr>

			</table>

			<div class="submit">
				<input type="submit" class="button-primary" name="aios_save_salt_postfix_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>
