<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<?php
$route_namespaces = AIOWPSecurity_Utility::get_rest_namespaces();
$user_roles = AIOWPSecurity_Utility_Permissions::get_user_roles();
?>
<div class="postbox aio_hidden" data-template="wp-rest-api">
	<h3 class="hndle"><label for="title"><?php esc_html_e('WP REST API settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div>
			<div id="disallow-unauthorised-requests-badge">
				<?php
				//Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("disallow-unauthorised-requests");
				?>
			</div>
				<div class="aio_blue_box">
					<?php
					echo '<p>'.esc_html__('This feature allows you to block WordPress REST API access for unauthorized requests.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.esc_html__('When enabled this feature will only allow REST requests to be processed if the user is logged in.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.esc_html__('Only REST requests made by logged-in users with a role permitted below will succeed, unless the REST API endpoint has been white-listed for others to also use.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.esc_html__('You can whitelist REST routes by selecting from the list of all registered rest routes for all users, including those who are not logged in.', 'all-in-one-wp-security-and-firewall').'</p>';
					?>
				</div>
				<?php if (empty($route_namespaces)) { ?>
				<div class="aio_red_box">
					<p>
						<?php
						echo esc_html__('You do not have any registered REST API routes to block unauthorized access.', 'all-in-one-wp-security-and-firewall');
						?>
					</p>
				</div>
				<?php } ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e('Disallow unauthorized REST requests', 'all-in-one-wp-security-and-firewall'); ?>:</th>
						<td>
							<div class="aiowps_switch_container">
								<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this to stop REST API access for non-logged in requests.', 'all-in-one-wp-security-and-firewall'), 'aiowps_disallow_unauthorized_rest_requests', '1' == $aio_wp_security->configs->get_value('aiowps_disallow_unauthorized_rest_requests')); ?>
							</div>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('User roles allowed access when logged in', 'all-in-one-wp-security-and-firewall'); ?>:</th>
						<td>
							<?php foreach ($user_roles as $id => $name) { ?>
							<div class="aiowps_switch_container">
								<?php AIOWPSecurity_Utility_UI::setting_checkbox($name, 'aios_allowed_roles_rest_requests_'.$id, !in_array($id, $aio_wp_security->configs->get_value('aios_roles_disallowed_rest_requests'))); // Default all roles are allowed, only disallowed roles considered ?>
							</div>
							<br>
							<?php } ?>
						</td>
					</tr>
				</table>
			<div class="aios-rest-white-list-options-panel<?php echo ('1' == $aio_wp_security->configs->get_value('aiowps_disallow_unauthorized_rest_requests')) ? "" : " hidden";?>">
				<?php $aio_wp_security->include_template('wp-admin/firewall/partials/rest-route-whitelist.php', false, compact('route_namespaces')); ?>
			</div>
		</div>
	</div>
</div>
