<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Comment spam settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div id="aios-spam-prevention-container">
	<form action="" id="aios-spam-prevention-form" method="POST">
		<div class="postbox">
			<h3 class="hndle"><label for="title"><?php esc_html_e('Spam comment detect', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
			<div class="inside">
				<div class="aio_blue_box">
					<?php
					echo '<p>'.esc_html__('A large portion of WordPress blog comment spam is produced by automated bots rather than by humans.', 'all-in-one-wp-security-and-firewall').'<br>'.esc_html__('This feature will reduce the useless and unnecessary traffic and load on your server resulting from spam comments.', 'all-in-one-wp-security-and-firewall').'<br>'.esc_html__('In other words, if the comment was not submitted by a human, the request will be discarded or marked as spam.', 'all-in-one-wp-security-and-firewall').'<br>'.esc_html__('This feature uses cookies and JavaScript.', 'all-in-one-wp-security-and-firewall').' '.esc_html__('If your visitors have either cookies or JavaScript disabled, their comments will automatically be discarded or marked as spam.', 'all-in-one-wp-security-and-firewall') . '</p>';
				?>
			</div>
				<div id="detect-spambots-badge">
				<?php
					// Display security info badge
					$aiowps_feature_mgr->output_feature_details_badge("detect-spambots");
				?>
				</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Detect spambots posting comments', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want to detect comments originating from spambots.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_spambot_detecting', $aio_wp_security->configs->get_value('aiowps_enable_spambot_detecting')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
									<?php
									echo '<p class="description">'.esc_html__('This feature will detect comment attempts which originate from spambots.', 'all-in-one-wp-security-and-firewall').'</p>';
									echo '<p class="description">'.esc_html__('A legitimate comment is one which is submitted by a human who physically fills out the comment form and presses the submit button.', 'all-in-one-wp-security-and-firewall').'</p>';
									echo '<p class="description">'.esc_html__('A comment submitted by a spambot is done by directly calling the wp-comments-post.php file.', 'all-in-one-wp-security-and-firewall').'</p>';
									echo '<p class="description">'.esc_html__('This feature will detect these comments and either discard them completely or mark them as spam.', 'all-in-one-wp-security-and-firewall').'</p>';
									?>
								</div>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Use cookies to detect comment spam', 'all-in-one-wp-security-and-firewall'); ?></th>
						<td>
							<div class="aiowps_switch_container">
								<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Using cookies may prevent caches from caching pages containing comment forms.', 'all-in-one-wp-security-and-firewall'), 'aiowps_spambot_detect_usecookies', $aio_wp_security->configs->get_value('aiowps_spambot_detect_usecookies')); ?>
								<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
								<div class="aiowps_more_info_body">
									<?php
									echo '<p class="description">'.esc_html__('This feature uses cookies.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('Unless your cache (e.g. Cloudflare) is configured to ignore these cookies, it may decide to not cache any of these pages.', 'all-in-one-wp-security-and-firewall').'</p>';
									echo '<p class="description">'.esc_html__('Cloudflare detects that the set-cookie header is set and will not cache the page by default.', 'all-in-one-wp-security-and-firewall').'</p>';
									?>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<h3 class="hndle"><label for="title"><?php esc_html_e('Comment processing', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
			<div class="inside">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="aiowps_spam_comments_should"><?php esc_html_e('Spam comments detected should be', 'all-in-one-wp-security-and-firewall'); ?>:</label>
						</th>
						<td>
							<select id="aiowps_spam_comments_should" name="aiowps_spam_comments_should">
								<option value="0" <?php selected($aio_wp_security->configs->get_value('aiowps_spam_comments_should'), '0'); ?>><?php esc_html_e('Discarded', 'all-in-one-wp-security-and-firewall'); ?></option>
								<option value="1" <?php selected($aio_wp_security->configs->get_value('aiowps_spam_comments_should'), '1'); ?>><?php esc_html_e('Marked as spam', 'all-in-one-wp-security-and-firewall'); ?></option>
							</select>
							<span class="description"><?php esc_html_e('Select the value for how you would like a comment detected as spam to be processed', 'all-in-one-wp-security-and-firewall'); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="aiowps_trash_spam_comments_after_days"><?php esc_html_e('Trash spam comments', 'all-in-one-wp-security-and-firewall'); ?>:</label>
						</th>
						<td>
							<?php AIOWPSecurity_Utility_UI::setting_checkbox('', 'aiowps_enable_trash_spam_comments', '1' == $aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments')); ?>
							<?php
							$disabled = '';
							if (!$aio_wp_security->configs->get_value('aiowps_enable_trash_spam_comments')) $disabled = "disabled";
							echo '<label for="aiowps_enable_trash_spam_comments" class="description">';
							printf(
								/* translators: %s: Spam comments day threshold. */
								esc_html__('Move spam comments to trash after %s days.', 'all-in-one-wp-security-and-firewall'),
								'</label><input type="number" min="1" max="99" id="aiowps_trash_spam_comments_after_days" name="aiowps_trash_spam_comments_after_days" value="' . esc_attr($aio_wp_security->configs->get_value('aiowps_trash_spam_comments_after_days')) . '" ' . esc_attr($disabled) . '><label for="aiowps_enable_trash_spam_comments">'
							);
							echo '</label>';
							?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php esc_html_e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<?php
								echo '<p class="description">'.esc_html__('Enable this feature in order to move the spam comments to trash after given number of days.', 'all-in-one-wp-security-and-firewall').'</p>';
								?>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<input type="submit" name="aiowps_apply_comment_spam_prevention_settings" value="<?php esc_html_e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
	</form>
</div>
