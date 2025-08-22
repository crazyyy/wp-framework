<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>' . esc_html__('An effective Brute Force prevention technique is to change the default WordPress login page URL.', 'all-in-one-wp-security-and-firewall') . '</p>' . '<p>' . esc_html__('Normally if you wanted to login to WordPress you would type your site\'s home URL followed by wp-login.php.', 'all-in-one-wp-security-and-firewall') . '</p>' . '<p>' . esc_html__('This feature allows you to change the login URL by setting your own slug and renaming the last portion of the login URL which contains the <strong>wp-login.php</strong> to any string that you like.', 'all-in-one-wp-security-and-firewall') . '</p>' . '<p>' . esc_html__('By doing this, malicious bots and hackers will not be able to access your login page because they will not know the correct login page URL.', 'all-in-one-wp-security-and-firewall') . '</p>';
		if (!is_multisite() || 1 == get_current_blog_id()) {
			$cookie_based_feature_url = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=cookie-based-brute-force-prevention" target="_blank">' . esc_html__('Cookie based brute force prevention', 'all-in-one-wp-security-and-firewall').'</a>';
			$white_list_feature_url = '<a href="admin.php?page=' . AIOWPSEC_BRUTE_FORCE_MENU_SLUG . '&tab=login-whitelist" target="_blank">' . esc_html__('Login page white list', 'all-in-one-wp-security-and-firewall').'</a>';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- URLs escaped above.
			echo '<div class="aio_section_separator_1"></div><p>' . esc_html__('You may also be interested in the following alternative brute force prevention features:', 'all-in-one-wp-security-and-firewall') . '</p><p>' . $cookie_based_feature_url . '</p><p>' . $white_list_feature_url . '</p>';
		}
	?>
</div>
<div id="aios-rename-login-notice">
<?php
$aio_wp_security->include_template('wp-admin/brute-force/partials/rename-login-notice.php', false, array('home_url' => $home_url));
?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Rename login page settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="bf-rename-login-page-badge">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("bf-rename-login-page");
			?>
		</div>
		<form action="" id="aios-rename-login-page-form">
			<div class="aio_orange_box">
				<?php
				/* translators: %s: Notes URL.  */
				echo '<p>' . esc_html__('This feature can lock you out of admin if it doesn\'t work correctly on your site.', 'all-in-one-wp-security-and-firewall') . ' '. sprintf(esc_html__('Before activating this feature, you must read the following %s.', 'all-in-one-wp-security-and-firewall'), '<a href="https://teamupdraft.com/documentation/all-in-one-security/faqs/important-note-on-intermediate-and-advanced-features/?utm_source=aios-plugin&utm_medium=referral&utm_campaign=paac&utm_content=you-must-read-this-to-activate-rename-login-feature&utm_creative_format=text" target="_blank">' . esc_html__('message', 'all-in-one-wp-security-and-firewall').'</a>') . '</p>';
				echo '<p>' . esc_html__("NOTE: If you are hosting your site on WPEngine or a provider which performs server caching, you will need to ask the host support people to NOT cache your renamed login page.", 'all-in-one-wp-security-and-firewall') . '</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Enable rename login page feature', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want the rename login page feature', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_rename_login_page', '1' == $aio_wp_security->configs->get_value('aiowps_enable_rename_login_page')); ?>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_login_page_slug"><?php esc_html_e('Login page URL', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><code><?php echo esc_url($home_url); ?></code><input id="aiowps_login_page_slug" type="text" size="15" name="aiowps_login_page_slug" value="<?php echo esc_attr($aio_wp_security->configs->get_value('aiowps_login_page_slug')); ?>">
					<span class="description"><?php echo esc_html__('Enter a string which will represent your secure login page slug.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('You are encouraged to choose something which is hard to guess and only you will remember.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
			</table>
			<?php submit_button(esc_html__('Save settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_rename_login_page_settings');?>
		</form>
	</div>
</div>
