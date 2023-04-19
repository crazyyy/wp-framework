<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable the ability to copy text', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-copy-protection'); ?>
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to disable the ability to select and copy text from your front end.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.__('When admin user is logged in, the feature is automatically disabled for his session.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable copy protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_copy_protection" name="aiowps_copy_protection" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_copy_protection')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_copy_protection" class="description"><?php echo __('Check this if you want to disable the "Right click", "Text selection" and "Copy" option on the front end of your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_copy_protection" value="<?php _e('Save copy protection settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>