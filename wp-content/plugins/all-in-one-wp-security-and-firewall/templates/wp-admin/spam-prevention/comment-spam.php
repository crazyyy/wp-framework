<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Comment spam settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<form action="" method="POST">
	<?php wp_nonce_field('aiowpsec-comment-spam-settings-nonce'); ?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Add CAPTCHA to comments form', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature will add a CAPTCHA field in the WordPress comments form.', 'all-in-one-wp-security-and-firewall').'<br>'.__('Adding a CAPTCHA field in the comment form is a simple way of greatly reducing spam comments from bots without using .htaccess rules.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("comment-form-captcha");
			?>
			<?php AIOWPSecurity_Captcha::warning_captcha_settings_notset(); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable CAPTCHA on comment forms', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_comment_captcha" name="aiowps_enable_comment_captcha" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_comment_captcha')) echo ' checked="checked"'; ?> value="1"/>
					<label for="aiowps_enable_comment_captcha" class="description"><?php _e('Check this if you want to insert a CAPTCHA field on the comment forms.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Spam comment detect', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('A large portion of WordPress blog comment spam is mainly produced by automated bots and not necessarily by humans.', 'all-in-one-wp-security-and-firewall').'<br>'.__('This feature will greatly minimize the useless and unnecessary traffic and load on your server resulting from spam comments.', 'all-in-one-wp-security-and-firewall').'<br>'.__('In other words, if the comment was not submitted by a human who physically submitted the comment on your site, the request will be discarded or marked as spam.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("detect-spambots");
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Detect spambots posting comments', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_enable_spambot_detecting" name="aiowps_enable_spambot_detecting" type="checkbox" <?php checked($aio_wp_security->configs->get_value('aiowps_enable_spambot_detecting'));?> value="1">
						<label for="aiowps_enable_spambot_detcting" class="description"><?php _e('Check this if you want to detect comments originating from spambots.', 'all-in-one-wp-security-and-firewall'); ?></label>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('This feature will detect comment attempts which originate from spambots.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('A legitimate comment is one which is submitted by a human who physically fills out the comment form and presses the submit button.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('A comment submitted by a spambot is done by directly calling the wp-comments-post.php file.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('This feature will detect these comments and either discard them completely or mark them as spam.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<h3 class="hndle"><label for="title"><?php _e('Comment processing', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_spam_comments_should"><?php _e('Spam comments detected should be', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<select id="aiowps_spam_comments_should" name="aiowps_spam_comments_should">
							<option value="0" <?php selected($aio_wp_security->configs->get_value('aiowps_spam_comments_should'), '0'); ?>><?php _e('Discarded', 'all-in-one-wp-security-and-firewall'); ?></option>
							<option value="1" <?php selected($aio_wp_security->configs->get_value('aiowps_spam_comments_should'), '1'); ?>><?php _e('Marked as spam', 'all-in-one-wp-security-and-firewall'); ?></option>
						</select>
						<span class="description"><?php _e('Select the value for how you would like a comment detected as spam to be processed', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>	
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_trash_spam_comments_after_days"><?php _e('Trash spam comments', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input name="aiowps_enable_trash_spam_comments" id="aiowps_enable_trash_spam_comments" type="checkbox" <?php checked($aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments'), 1); ?> value="1">
						<?php
							$disbled = '';
							if (!$aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments')) $disbled = "disabled";
							echo '<label for="aiowps_enable_trash_spam_comments" class="description">';
							printf(
								__('Move spam comments to trash after %s days.', 'all-in-one-wp-security-and-firewall'),
								'</label><input type="number" min="1" max="99" name="aiowps_trash_spam_comments_after_days" value="'.$aio_wp_security->configs->get_value('aiowps_trash_spam_comments_after_days').'" '.$disbled.'><label for="aiowps_enable_trash_spam_comments">'
							);
							echo '</label>';
						?>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">'.__('Enble this feature in order to move the spam comments to trash after given number of days.', 'all-in-one-wp-security-and-firewall').'</p>';
							?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<input type="submit" name="aiowps_apply_comment_spam_prevention_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>