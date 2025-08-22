<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Upgrade unsafe HTTP calls', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="upgrade-unsafe-http-calls-badge">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge('upgrade-unsafe-http-calls');
			?>
		</div>
		<form action="" id="aios-upgrade-unsafe-http-calls-settings-form">
			<div class="aio_blue_box">
				<?php
					/* translators: 1: Bold unsafe function name, 2: Bold safe function name. */
					echo '<p>' . sprintf(esc_html__('This feature allows you to upgrade all unsafe HTTP calls on your site using %1$s to %2$s.', 'all-in-one-wp-security-and-firewall'), '<strong>wp_remote_*</strong>', '<strong>wp_safe_remote_*</strong>') . '</p>';
					/* translators: %s Bold unsafe function name. */
					echo '<p>' . sprintf(esc_html__('You can also specify a list of URLs that are allowed to be contacted with the unsafe %s calls.', 'all-in-one-wp-security-and-firewall'), '<strong>wp_remote_*</strong>') . '</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox('', 'aiowps_upgrade_unsafe_http_calls', '1' == $aio_wp_security->configs->get_value('aiowps_upgrade_unsafe_http_calls')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_upgrade_unsafe_http_calls_url_exceptions"><?php esc_html_e('URL exceptions', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<textarea id="aiowps_upgrade_unsafe_http_calls_url_exceptions" name="aiowps_upgrade_unsafe_http_calls_url_exceptions" rows="5" cols="50"><?php echo esc_textarea($aio_wp_security->configs->get_value('aiowps_upgrade_unsafe_http_calls_url_exceptions')); ?></textarea>
						<br>
						<span class="description"><?php esc_html_e('Enter URL exceptions.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More Info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">' . esc_html__('Each URL must be on a new line.', 'all-in-one-wp-security-and-firewall') . '</p>';
								echo '<p class="description">' . esc_html__('All localhost URLs are already an exception.', 'all-in-one-wp-security-and-firewall') . '</p>';
							?>
						</div>
					</td>
				</tr>
			</table>
			<input type="submit" class="button-primary" value="<?php esc_html_e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
		</form>
	</div>
</div>