<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('User registration settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Manually approve new registrations', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<?php
			echo '<p>'.__('If your site allows people to create their own accounts via the WordPress registration form, then you can minimize spam or bogus registrations by manually approving each registration.', 'all-in-one-wp-security-and-firewall').
			'<br>'.__('This feature will automatically set a newly registered account to "pending" until the administrator activates it.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Therefore undesirable registrants will be unable to log in without your express approval.', 'all-in-one-wp-security-and-firewall').
			'<br>'.__('You can view all accounts which have been newly registered via the handy table below and you can also perform bulk activation/deactivation/deletion tasks on each account.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
		</div>
		<div id="manually-approve-registrations-badge">
			<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("manually-approve-registrations");
			?>
		</div>
		<form action="" method="POST" id="aios-manually-approve-registrations-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable manual approval of new registrations', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to automatically disable all newly registered accounts so that you can approve them manually.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_manual_registration_approval', '1' == $aio_wp_security->configs->get_value('aiowps_enable_manual_registration_approval')); ?>
						</div>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_save_user_registration_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Refresh manual approval data', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST" id="aios-refresh-manual-approval-list-form">
			<input type="submit" name="aiowps_refresh_manual_approval_list" value="<?php _e('Refresh data', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" />
		</form>
	</div>
</div>
<div class="postbox" id="aios-manual-approval-table">
	<h3 class="hndle"><label for="title"><?php _e('Approve registered users', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
		// Fetch, prepare, sort, and filter our data...
		$user_list->prepare_items();
		?>
		<form id="tables-filter" method="post">
			<?php
			$user_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_user_registration');
			?>
			<!-- Now we can render the completed list table -->
			<?php $user_list->display(); ?>
		</form>
	</div>
</div>