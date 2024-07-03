<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('Brute force prevention firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		// TODO - need to fix the following message
		echo '<p>' . __('A Brute Force Attack is when a hacker tries many combinations of usernames and passwords until they succeed in guessing the right combination.', 'all-in-one-wp-security-and-firewall').'<br>' . __('Due to the fact that at any one time there may be many concurrent login attempts occurring on your site via malicious automated robots, this also has a negative impact on your server\'s memory and performance.', 'all-in-one-wp-security-and-firewall').'<br>' . __('The features in this tab will stop the majority of brute force login attacks thus providing even better protection for your WP login page.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="aio_yellow_box">
	<?php
		$tutorial_link = '<a href="https://aiosplugin.com/how-to-use-cookie-based-brute-force-login-attack-prevention-feature/" target="_blank">' . __('tutorial', 'all-in-one-wp-security-and-firewall') . '</a>';
		$info_msg = sprintf(__('To learn more about how to use this feature, please read the following %s.', 'all-in-one-wp-security-and-firewall'), $tutorial_link);
		echo '<p>' . $info_msg . '</p>';
	?>
</div>
<?php
	if (defined('AIOS_DISABLE_COOKIE_BRUTE_FORCE_PREVENTION') && AIOS_DISABLE_COOKIE_BRUTE_FORCE_PREVENTION) {
		$aio_wp_security->include_template('notices/cookie-based-brute-force-prevention-disabled.php');
	}
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Cookie based brute force login prevention', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("firewall-enable-brute-force-attack-prevention");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-enable-cookie-based-brute-force-prevention'); ?>
			<div class="aio_orange_box">
				<p>
				<?php echo __('This feature can lock you out of admin if it doesn\'t work correctly on your site.', 'all-in-one-wp-security-and-firewall').' ' . sprintf(__('Before activating this feature you must read the following %s.', 'all-in-one-wp-security-and-firewall'), '<a href="https://aiosplugin.com/important-note-on-intermediate-and-advanced-features" target="_blank">'.__('message', 'all-in-one-wp-security-and-firewall').'</a>'); ?>
				</p>
			</div>
			<?php
				$cookie_test_value = $aio_wp_security->configs->get_value('aiowps_cookie_test_success');

				$disable_brute_force_feature_input = true;
				// If the cookie test is successful or if the feature is already enabled then go ahead as normal
				if ('1' == $cookie_test_value || '1' == $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention')) {
					if (!empty($aiowps_cookie_test)) { // Cookie test was just performed and the test succeeded
						echo '<div class="aio_green_box"><p>';
						_e('The cookie test was successful, you can now enable this feature.', 'all-in-one-wp-security-and-firewall');
						echo '</p></div>';
					}
					$disable_brute_force_feature_input = false;
				} else {
					// Cookie test needs to be performed
					if (!empty($aiowps_cookie_test) && '1' != $cookie_test_value) { // Test failed
						echo '<div class="aio_red_box"><p>';
						echo __('The cookie test failed on this server.', 'all-in-one-wp-security-and-firewall') .' '. __('Consequently, this feature cannot be used on this site.', 'all-in-one-wp-security-and-firewall');
						echo '</p></div>';
					}
			?>
			<div class="aio_yellow_box">
				<p>
					<?php
					_e('Before using this feature, you must perform a cookie test first.', 'all-in-one-wp-security-and-firewall');
					echo ' ';
					echo htmlspecialchars(__("This ensures that your browser cookie is working correctly and that you won't lock yourself out.", 'all-in-one-wp-security-and-firewall'));
					?>
				</p>
			</div>
			<?php
					submit_button(__('Perform cookie test', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_do_cookie_test_for_bfla');
				}
				$disable_brute_force_sub_fields = !$aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention');
			?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable brute force attack prevention', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to protect your login page from a brute force attack.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_brute_force_attack_prevention', $aio_wp_security->configs->get_value('aiowps_enable_brute_force_attack_prevention')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<p class="description">
									<?php
									_e('This feature will deny access to your WordPress login page for all people except those who have a special cookie in their browser.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('To use this feature do the following:', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('1) Enable the checkbox.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									echo __('2) Enter a secret word consisting of alphanumeric characters which will be difficult to guess.', 'all-in-one-wp-security-and-firewall') . ' ' . __('This secret word will be useful whenever you need to know the special URL which you will use to access the login page (see point below).', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									echo __('3) You will then be provided with a special login URL.', 'all-in-one-wp-security-and-firewall') . ' ' . __('You will need to use this URL to login to your WordPress site instead of the usual login URL.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('NOTE: The system will deposit a special cookie in your browser which will allow you access to the WordPress administration login page.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('Any person trying to access your login page who does not have the special cookie in their browser will be automatically blocked.', 'all-in-one-wp-security-and-firewall');
									?>
								</p>
							</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_brute_force_secret_word"><?php _e('Secret word', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_brute_force_secret_word" type="text" size="40" name="aiowps_brute_force_secret_word" value="<?php echo $aio_wp_security->configs->get_value('aiowps_brute_force_secret_word'); ?>"<?php disabled($disable_brute_force_sub_fields); ?>>
					<span class="description"><?php echo __('Choose a secret word consisting of alphanumeric characters which you can use to access your special URL.', 'all-in-one-wp-security-and-firewall') . ' ' . __('You are highly encouraged to choose a word which will be difficult to guess.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_cookie_based_brute_force_redirect_url"><?php _e('Re-direct URL', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_cookie_based_brute_force_redirect_url" type="text" size="40" name="aiowps_cookie_based_brute_force_redirect_url" value="<?php echo $aio_wp_security->configs->get_value('aiowps_cookie_based_brute_force_redirect_url'); ?>" <?php disabled($disable_brute_force_sub_fields); ?> />
					<span class="description">
						<?php
						_e('Specify a URL to redirect a hacker to when they try to access your WordPress login page.', 'all-in-one-wp-security-and-firewall');
						?>
					</span>
					<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
					<div class="aiowps_more_info_body">
						<p class="description">
							<?php
						_e('The URL specified here can be any site\'s URL and does not have to be your own.', 'all-in-one-wp-security-and-firewall');
						echo '<br>';
						_e('This field will default to: http://127.0.0.1 if you do not enter a value.', 'all-in-one-wp-security-and-firewall');
						echo '<br>';
						_e('Useful Tip:', 'all-in-one-wp-security-and-firewall');
						echo '<br>';
						_e('It\'s a good idea to not redirect attempted brute force login attempts to your site because it increases the load on your server.', 'all-in-one-wp-security-and-firewall');
						echo '<br>';
						_e('Redirecting a hacker or malicious bot back to "http://127.0.0.1" is ideal because it deflects them back to their own local host and puts the load on their server instead of yours.', 'all-in-one-wp-security-and-firewall');
							?>
						</p>
					</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('My site has posts or pages which are password protected', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you are using the native WordPress password protection feature for some or all of your blog posts or pages.', 'all-in-one-wp-security-and-firewall'), 'aiowps_brute_force_attack_prevention_pw_protected_exception', '1' == $aio_wp_security->configs->get_value('aiowps_brute_force_attack_prevention_pw_protected_exception')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<p class="description">
									<?php
									_e('In the cases where you are protecting some of your posts or pages using the in-built WordPress password protection feature, a few extra lines of directives and exceptions need to be added so that people trying to access pages are not automatically blocked.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('By enabling this checkbox, the plugin will add the necessary rules and exceptions so that people trying to access these pages are not automatically blocked.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									echo "<strong>".__('Helpful Tip:', 'all-in-one-wp-security-and-firewall')."</strong>";
									echo '<br>';
									_e('If you do not use the WordPress password protection feature for your posts or pages then it is highly recommended that you leave this checkbox disabled.', 'all-in-one-wp-security-and-firewall');
									?>
								</p>
							</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e('My site has a theme or plugins which use AJAX', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if your site uses AJAX functionality.', 'all-in-one-wp-security-and-firewall'), 'aiowps_brute_force_attack_prevention_ajax_exception', '1' == $aio_wp_security->configs->get_value('aiowps_brute_force_attack_prevention_ajax_exception')); ?>
							<span class="aiowps_more_info_anchor"><span class="aiowps_more_info_toggle_char">+</span><span class="aiowps_more_info_toggle_text"><?php _e('More info', 'all-in-one-wp-security-and-firewall'); ?></span></span>
							<div class="aiowps_more_info_body">
								<p class="description">
									<?php
									_e('In the cases where your WordPress installation has a theme or plugin that uses AJAX, a few extra lines of directives and exceptions need to be added to prevent AJAX requests from being automatically blocked by the brute force prevention feature.', 'all-in-one-wp-security-and-firewall');
									echo '<br>';
									_e('By enabling this checkbox, the plugin will add the necessary rules and exceptions so that AJAX operations will work as expected.', 'all-in-one-wp-security-and-firewall');
									?>
								</p>
							</div>
						</div>
					</td>
				</tr>
			</table>
			<?php
				$other_attributes = $disable_brute_force_feature_input ? array('disabled' => 'disabled') : array();
				submit_button(__('Save feature settings', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_apply_cookie_based_bruteforce_firewall', false, $other_attributes);
			?>
		</form>
	</div>
</div>