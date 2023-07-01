<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Auto block spammer IPs', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_autoblock_spam_ip') && '1' != $aio_wp_security->configs->get_value('aiowps_enable_spambot_detecting')) {
				$comment_spam_detect_link = "<a href='".esc_url(admin_url(sanitize_url(sprintf('admin.php?page=%s&tab=%s', AIOWPSEC_SPAM_MENU_SLUG, 'comment-spam'))))."'>" . __('spam comment detection') . "</a>";
				$info_msg = sprintf(__('This feature has detected that %s is not active.', 'all-in-one-wp-security-and-firewall'), $comment_spam_detect_link) . ' ' . __('It is highly recommended that you activate to make the most of this feature.', 'all-in-one-wp-security-and-firewall');
				echo '<div class="aio_orange_box" id="message"><p><strong>'.$info_msg.'</strong></p></div>';
			}
		?>
		<form action="" method="POST">
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to automatically and permanently block IP addresses which have exceeded a certain number of spam comments.', 'all-in-one-wp-security-and-firewall').'</p>'.'<p>'.__('Comments are considered spam if the "Spam comment detection" feature is enabled or an administrator manually marks a comment as "spam" from the WordPress Comments menu.', 'all-in-one-wp-security-and-firewall').'</p>'.'<p><strong>'.__('NOTE: This feature does NOT use the .htaccess file to permanently block the IP addresses so it should be compatible with all web servers running WordPress.', 'all-in-one-wp-security-and-firewall').'</strong></p>';
				?>
			</div>
			<?php
				echo $block_comments_output;
				// Display security info badge
				// $aiowps_feature_mgr->output_feature_details_badge("auto-block-spam-ip");
			?>
			<?php wp_nonce_field('aiowpsec-auto-block-spam-ip-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable auto block of spam comment IPs', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_enable_autoblock_spam_ip" name="aiowps_enable_autoblock_spam_ip" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_autoblock_spam_ip')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_enable_autoblock_spam_ip" class="description"><?php _e('Check this box if you want this plugin to automatically block IP addresses which submit spam comments.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_spam_ip_min_comments_block"><?php _e('Minimum number of spam comments', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_spam_ip_min_comments_block" type="text" size="5" name="aiowps_spam_ip_min_comments_block" value="<?php echo $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments_block'); ?>" />
						<span class="description"><?php _e('Specify the minimum number of spam comments for an IP address before it is permanently blocked.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
							echo '<p class="description">'.__('Example 1: Setting this value to "1" will block ALL IP addresses which were used to submit at least one spam comment.', 'all-in-one-wp-security-and-firewall').'</p>';
							echo '<p class="description">'.__('Example 2: Setting this value to "5" will block only those IP addresses which were used to submit 5 spam comments or more on your site.', 'all-in-one-wp-security-and-firewall').'</p>';
							?>
						</div>
					</td>
				</tr>
				<!-- <tr valign="top"> -->
				<!-- <th scope="row"> --><?php //_e('Run now', 'all-in-one-wp-security-and-firewall'); ?><!--:</th>-->
				<!-- <td><input type="submit" name="aiowps_auto_spam_block_run" value=" --><?php //_e('Run spam IP blocking now', 'all-in-one-wp-security-and-firewall'); ?><!--" class="button-secondary" />-->
				<!-- <span class="description">--><?php //_e('This feature normally runs automatically whenever a comment is submitted but you can run it manually by clicking this button. (useful for older comments)', 'all-in-one-wp-security-and-firewall');?><!--</span>-->
				<!-- </td> -->
				<!-- </tr> -->
			</table>
			<input type="submit" name="aiowps_auto_spam_block" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('List spammer IP addresses', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<?php
				echo '<p>'.__('This section displays a list of the IP addresses of the people or bots who have left spam comments on your site.', 'all-in-one-wp-security-and-firewall').'<br>'.__('This information can be handy for identifying the most persistent IP addresses or ranges used by spammers.', 'all-in-one-wp-security-and-firewall').'<br>'.__('By inspecting the IP address data coming from spammers you will be in a better position to determine which addresses or address ranges you should block by adding them to the permanent block list.', 'all-in-one-wp-security-and-firewall').'<br>'.__('To add one or more of the IP addresses displayed in the table below to your blacklist, simply press the "Block" link for the individual row or select more than one address using the checkboxes and then choose the "block" option from the Bulk Actions dropdown list and press the "Apply" button.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
		</div>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-spammer-ip-list-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aiowps_spam_ip_min_comments"><?php _e('Minimum number of spam comments per IP', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td>
						<input id="aiowps_spam_ip_min_comments" type="text" size="5" name="aiowps_spam_ip_min_comments" value="<?php echo $aio_wp_security->configs->get_value('aiowps_spam_ip_min_comments'); ?>" />
						<span class="description"><?php _e('This field allows you to list only those IP addresses which have been used to post X or more spam comments.', 'all-in-one-wp-security-and-firewall'); ?></span>
						<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
						<div class="aiowps_more_info_body">
							<?php
								echo '<p class="description">'.__('Example 1: Setting this value to "0" or "1" will list ALL IP addresses which were used to submit spam comments.', 'all-in-one-wp-security-and-firewall').'</p>';
								echo '<p class="description">'.__('Example 2: Setting this value to "5" will list only those IP addresses which were used to submit 5 spam comments or more on your site.', 'all-in-one-wp-security-and-firewall').'</p>';
							?>
						</div>
					</td> 
				</tr>
			</table>
			<input type="submit" name="aiowps_ip_spam_comment_search" value="<?php _e('Find IP addresses', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Spammer IP address results', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			if (!is_main_site()) {
				echo '<div class="aio_yellow_box">';
				echo '<p>'.__('The plugin has detected that you are using a Multi-Site WordPress installation.', 'all-in-one-wp-security-and-firewall').'</p><p>'.__('Only the "superadmin" can block IP addresses from the main site.', 'all-in-one-wp-security-and-firewall').'</p><p>'.__('Take note of the IP addresses you want blocked and ask the superadmin to add these to the blacklist using the "Blacklist Manager" on the main site.', 'all-in-one-wp-security-and-firewall').'</p>';
				echo '</div>';
			}
			// Fetch, prepare, sort, and filter our data...
			$spammer_ip_list->prepare_items();
			// echo "put table of locked entries here";
		?>
		<form id="tables-filter" method="get">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
			<input type="hidden" name="tab" value="<?php echo esc_attr($_REQUEST['tab']); ?>" />
			<!-- Now we can render the completed list table -->
			<?php $spammer_ip_list->display(); ?>
		</form>
	</div>
</div>