<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('404 detection configuration', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('A 404 or Not Found error occurs when somebody tries to access a non-existent page on your website.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('Typically, most 404 errors happen quite innocently when people have mis-typed a URL or used an old link to page which doesn\'t exist anymore.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('However, in some cases you may find many repeated 404 errors which occur in a relatively short space of time and from the same IP address which are all attempting to access a variety of non-existent page URLs.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('Such behaviour can mean that a hacker might be trying to find a particular page or URL for sinister reasons.', 'all-in-one-wp-security-and-firewall');
	?>
</div>
<?php
if (!defined('AIOWPSECURITY_NOADS_B') || !AIOWPSECURITY_NOADS_B) {
?>
	<div class="aio_grey_box">
		<?php
		$premium_plugin_link = '<strong><a href="https://aiosplugin.com/" target="_blank">'.htmlspecialchars(__('All In One WP Security & Firewall Premium', 'all-in-one-wp-security-and-firewall')).'</a></strong>';
		$info_msg = sprintf(__('You may also be interested in %s.', 'all-in-one-wp-security-and-firewall'), $premium_plugin_link);
		$info_msg2 = sprintf(__('This plugin adds a number of extra features including %s and %s.', 'all-in-one-wp-security-and-firewall'), '<strong>'.__('smart 404 blocking', 'all-in-one-wp-security-and-firewall').'</strong>', '<strong>'.__('country IP blocking', 'all-in-one-wp-security-and-firewall').'</strong>');

		echo '<p>'. $info_msg . '<br />' . $info_msg2 . '</p>';
		?>
	</div>
<?php
}
?>

<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('404 detection options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
		// Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("firewall-enable-404-blocking");
		?>

		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-404-detection-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable 404 IP detection and lockout', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want the lockout of selected IP addresses.', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_404_IP_lockout', '1' == $aio_wp_security->configs->get_value('aiowps_enable_404_IP_lockout')); ?>
						</div>
					</td>
				</tr>
				<!-- currently this option is automatically set when the aiowps_enable_404_IP_lockout feature is turned on
				<tr valign="top">
					<th scope="row"><?php _e('Enable 404 event logging', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input name="aiowps_enable_404_logging" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_404_logging')=='1') echo ' checked="checked"'; ?> value="1"/>
					<span class="description"><?php _e('Check this if you want to enable the logging of 404 events', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				-->
				<tr valign="top">
					<th scope="row"><label for="aiowps_404_lockout_time_length"><?php _e('Time length of 404 lockout (minutes)', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_404_lockout_time_length" type="text" size="5" name="aiowps_404_lockout_time_length" value="<?php echo $aio_wp_security->configs->get_value('aiowps_404_lockout_time_length'); ?>" />
					<span class="description"><?php _e('Set the length of time for which a blocked IP address will be prevented from visiting your site', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="aiowps_404_lock_redirect_url"><?php _e('404 lockout redirect URL', 'all-in-one-wp-security-and-firewall'); ?>:</label></th>
					<td><input id="aiowps_404_lock_redirect_url" type="text" size="50" name="aiowps_404_lock_redirect_url" value="<?php echo esc_url($aio_wp_security->configs->get_value('aiowps_404_lock_redirect_url'), array('http', 'https')); ?>" />
					<span class="description"><?php _e('A blocked visitor will be automatically redirected to this URL.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_save_404_detect_options" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>
<div class="404-detection-container <?php if ('1' !== $aio_wp_security->configs->get_value('aiowps_enable_404_IP_lockout')) echo 'aio_hidden'; ?>">
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('404 event logs', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
			echo '<p>'.__('This list displays the 404 event logs when somebody tries to access a non-existent page on your website.', 'all-in-one-wp-security-and-firewall').'<br/><strong>'.sprintf(__('404 event logs that are older than %1$d days are purged automatically.', 'all-in-one-wp-security-and-firewall'), apply_filters('aios_purge_events_records_after_days', AIOS_PURGE_EVENTS_RECORDS_AFTER_DAYS)).'</strong></p>';

			// Fetch, prepare, sort, and filter our data...
			$event_list_404->prepare_items();
			// echo "put table of locked entries here";
			?>
			<form id="tables-filter" method="post">
				<!-- For plugins, we also need to ensure that the form posts back to our current page -->
				<input type="hidden" name="page" value="<?php echo esc_attr($page); ?>" />
				<?php $event_list_404->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_404_events'); ?>
				<?php
				if (isset($tab)) {
					echo '<input type="hidden" name="tab" value="'.esc_attr($tab).'" />';
				}
				?>
				<!-- Now we can render the completed list table -->
				<?php $event_list_404->display(); ?>
			</form>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<form action="" method="POST">
				<?php wp_nonce_field('aiowpsec-export-404-event-logs-to-csv-nonce'); ?>
				<table class="form-table">
					<tr valign="top">
					<span class="description"><?php _e('Press this button if you wish to download this log in CSV format.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</tr>
				</table>
				<input type="submit" name="aiowps_export_404_event_logs_to_csv" value="<?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary"/>
			</form>
		</div>
	</div>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Delete all 404 event logs', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<form action="" method="POST">
				<?php wp_nonce_field('aiowpsec-delete-404-event-records-nonce'); ?>
				<table class="form-table">
					<tr valign="top">
					<span class="description"><?php _e('Press this button if you wish to purge all 404 event logs from the DB.', 'all-in-one-wp-security-and-firewall'); ?></span>
					</tr>
				</table>
				<input type="submit" name="aiowps_delete_404_event_records" value="<?php _e('Delete all 404 event logs', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" onclick="return confirm('<?php echo esc_js(__('Are you sure you want to delete all records?', 'all-in-one-wp-security-and-firewall'));?>')">
			</form>
		</div>
	</div>
</div>