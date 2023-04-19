<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('An effective Brute Force prevention technique is to change the default WordPress login page URL.', 'all-in-one-wp-security-and-firewall').'</p>'.'<p>'.__('Normally if you wanted to login to WordPress you would type your site\'s home URL followed by wp-login.php.', 'all-in-one-wp-security-and-firewall').'</p>'.'<p>'.__('This feature allows you to change the login URL by setting your own slug and renaming the last portion of the login URL which contains the <strong>wp-login.php</strong> to any string that you like.', 'all-in-one-wp-security-and-firewall').'</p>'.'<p>'.__('By doing this, malicious bots and hackers will not be able to access your login page because they will not know the correct login page URL.', 'all-in-one-wp-security-and-firewall') . '</p>';
		if (!is_multisite() || 1 == get_current_blog_id()) {
			$cookie_based_feature_url = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=cookie-based-brute-force-prevention" target="_blank">'.__('Cookie based brute force prevention', 'all-in-one-wp-security-and-firewall').'</a>';
			$white_list_feature_url = '<a href="admin.php?page='.AIOWPSEC_BRUTE_FORCE_MENU_SLUG.'&tab=login-whitelist" target="_blank">'.__('Login page white list', 'all-in-one-wp-security-and-firewall').'</a>';
		
			echo '<div class="aio_section_separator_1"></div><p>' . __('You may also be interested in the following alternative brute force prevention features:', 'all-in-one-wp-security-and-firewall') . '</p><p>' . $cookie_based_feature_url . '</p><p>' . $white_list_feature_url . '</p>';
		}
	?>
</div>
<?php
	// Show the user the new login URL if this feature is active
	if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_rename_login_page')) {
?>
		<div class="aio_yellow_box">
			<p><?php _e('Your WordPress login page URL has been renamed.', 'all-in-one-wp-security-and-firewall'); ?></p>
			<p><?php _e('Your current login URL is:', 'all-in-one-wp-security-and-firewall'); ?></p>
			<p><strong><?php echo $home_url.$aio_wp_security->configs->get_value('aiowps_login_page_slug'); ?></strong></p>
		</div>
<?php
	}
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Rename login page settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("bf-rename-login-page");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-rename-login-page-nonce'); ?>
			<div class="aio_orange_box">
				<?php
				echo sprintf(__('This feature can lock you out of admin if it doesn\'t work correctly on your site. Before activating this feature you must read the following %s.', 'all-in-one-wp-security-and-firewall'), '<a href="https://aiosplugin.com/important-note-on-intermediate-and-advanced-features" target="_blank">'.__('message', 'all-in-one-wp-security-and-firewall').'</a>');
				echo '<p>' . __("NOTE: If you are hosting your site on WPEngine or a provider which performs server caching, you will need to ask the host support people to NOT cache your renamed login page.", "all-in-one-wp-security-and-firewall") . '</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable rename login page feature', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_enable_rename_login_page" name="aiowps_enable_rename_login_page" type="checkbox"<?php checked($aio_wp_security->configs->get_value('aiowps_enable_rename_login_page'), '1'); ?> value="1"/>
					<label for="aiowps_enable_rename_login_page" class="description"><?php _e('Check this if you want to enable the rename login page feature', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_login_page_slug"><?php _e('Login page URL', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><code><?php echo $home_url; ?></code><input id="aiowps_login_page_slug" type="text" size="15" name="aiowps_login_page_slug" value="<?php echo $aio_wp_security->configs->get_value('aiowps_login_page_slug'); ?>">
					<span class="description"><?php _e('Enter a string which will represent your secure login page slug. You are encouraged to choose something which is hard to guess and only you will remember.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_rename_login_page_settings');?>
		</form>
	</div>
</div>
