<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable the ability to copy text', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside" id="aios-copy-protection-settings">
		<div id="enable-copy-protection-badge">
			<?php
			//Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("enable-copy-protection");
			?>
		</div>
		<form action="" id="aios-copy-protection-settings-form" method="POST">
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
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this to disable the "Right click", "Text selection" and "Copy" options on the front end of your site.', 'all-in-one-wp-security-and-firewall'), 'aiowps_copy_protection', '1' == $aio_wp_security->configs->get_value('aiowps_copy_protection')); ?>
						</div>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_copy_protection" value="<?php _e('Save copy protection settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>