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
		<h3 class="hndle"><label for="title"><?php _e('Block spambot comments', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('A large portion of WordPress blog comment spam is mainly produced by automated bots and not necessarily by humans.', 'all-in-one-wp-security-and-firewall').'<br>'.__('This feature will greatly minimize the useless and unecessary traffic and load on your server resulting from spam comments by blocking all comment requests which do not originate from your domain.', 'all-in-one-wp-security-and-firewall').'<br>'.__('In other words, if the comment was not submitted by a human who physically submitted the comment on your site, the request will be blocked.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<?php
				$aio_wp_security->include_template('partials/non-apache-feature-notice.php');
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("block-spambots");
				$blog_id = get_current_blog_id();
				if (is_multisite() && !is_main_site($blog_id)) {
					//Hide config settings if MS and not main site
					AIOWPSecurity_Utility::display_multisite_message();
				} else {
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Block spambots from posting comments', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_enable_spambot_blocking" name="aiowps_enable_spambot_blocking" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_spambot_blocking')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_enable_spambot_blocking" class="description"><?php _e('Check this if you want to apply a firewall rule which will block comments originating from spambots.', 'all-in-one-wp-security-and-firewall'); ?></label>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.__('This feature will implement a firewall rule to block all comment attempts which do not originate from your domain.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('A legitimate comment is one which is submitted by a human who physically fills out the comment form and presses the submit button. For such events, the HTTP_REFERRER is always set to your own domain.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('A comment submitted by a spambot is done by directly calling the comments.php file, which usually means that the HTTP_REFERRER value is not your domain and often times empty.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('This feature will check and block comment requests which are not referred by your domain thus greatly reducing your overall blog spam and PHP requests done by the server to process these comments.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
						</div>
					</td>
				</tr>
			</table>
			<?php
				} //End if statement
			?>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Comment processing', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_trash_spam_comments_after_days"><?php _e('Trash spam comments', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<input name="aiowps_enable_trash_spam_comments" id="aiowps_enable_trash_spam_comments" type="checkbox" <?php checked($aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments'), 1); ?> value="1"/>
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