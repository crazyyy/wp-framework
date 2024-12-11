<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="other-plugins">
	<h3 class="hndle"><label for="title"><?php _e('Other forms CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<?php if (AIOWPSecurity_Utility::is_buddypress_plugin_active()) { ?>
	<div class="inside">
		<?php
		// Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("bp-register-captcha");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable CAPTCHA on BuddyPress registration form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on the %s registration forms.', 'all-in-one-wp-security-and-firewall'), 'BuddyPress'), 'aiowps_enable_bp_register_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_bp_register_captcha')); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<?php } ?>
	<?php if (AIOWPSecurity_Utility::is_bbpress_plugin_active()) { ?>
		<div class="inside">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("bbp-new-topic-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on bbPress new topic form', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on the %s new topic forms.', 'all-in-one-wp-security-and-firewall'), 'bbPress'), 'aiowps_enable_bbp_new_topic_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_bbp_new_topic_captcha')); ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	<?php } ?>
	<?php if (AIOWPSecurity_Utility::is_contact_form_7_plugin_active()) { ?>
		<div class="inside">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("contact-form-7-captcha");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo sprintf(__('Enable CAPTCHA on %s', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'); ?>:</label></th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA field on %s forms.', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7'), 'aiowps_enable_contact_form_7_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_contact_form_7_captcha')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'. sprintf(__('%s will automatically try to insert a CAPTCHA field before the form\'s submit button', 'all-in-one-wp-security-and-firewall'), 'AIOS') .'</p>';
								echo '<p class="description">'. sprintf(__('For the exact placement of the CAPTCHA you can use the following shortcode in your %s template', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7') .'</p>';
								echo '<pre>[' . AIOWPSEC_CAPTCHA_SHORTCODE .']</pre>';
								echo '<p class="description">'. sprintf(__('This feature requires %s version %s or greater', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7', '5.0') .'</p>';
								echo '<p class="description">'. sprintf(__('The validation message will be displayed only when using %s version %s or greater', 'all-in-one-wp-security-and-firewall'), 'Contact Form 7', '5.6') .'</p>';
								?>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	<?php } ?>
</div>
