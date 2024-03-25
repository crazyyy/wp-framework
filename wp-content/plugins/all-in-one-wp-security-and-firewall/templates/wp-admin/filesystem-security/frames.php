<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Prevent your site from being displayed in a frame', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("enable-frame-protection");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-prevent-display-frame'); ?>
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to prevent other sites from displaying any of your content via a frame or iframe.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.__('When enabled, this feature will set the "X-Frame-Options" parameter to "sameorigin" in the HTTP header.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable iFrame protection', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Check this if you want to stop other sites from displaying your content in a frame or iframe.', 'all-in-one-wp-security-and-firewall'), 'aiowps_prevent_site_display_inside_frame', '1' == $aio_wp_security->configs->get_value('aiowps_prevent_site_display_inside_frame')); ?>
						</div>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_frame_display_prevent" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>