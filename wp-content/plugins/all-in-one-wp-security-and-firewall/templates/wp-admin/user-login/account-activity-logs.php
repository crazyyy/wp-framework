<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('This tab displays the activity for accounts registered with your site that have logged in using the WordPress login form.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('The information below can be handy if you need to do security investigations because it will show you the last 100 recent login events by username, IP address and time/date.', 'all-in-one-wp-security-and-firewall').'
		<br /><strong>'.sprintf(__('Account activity logs that are older than %1$d days are purged automatically.', 'all-in-one-wp-security-and-firewall'), apply_filters('aios_purge_login_activity_records_after_days', AIOS_PURGE_LOGIN_ACTIVITY_RECORDS_AFTER_DAYS)).'</strong>
		</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Account activity logs', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Fetch, prepare, sort, and filter our data...
			$acct_activity_list->prepare_items();
			// echo "put table of locked entries here";
		?>
		<form id="tables-filter" method="post">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
		<?php
			$acct_activity_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_login_activity');
			if (isset($_REQUEST["tab"])) {
				echo '<input type="hidden" name="tab" value="' . esc_attr($_REQUEST["tab"]) . '" />';
			}
		?>
		<!-- Now we can render the completed list table -->
		<?php $acct_activity_list->display(); ?>
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-export-acct-activity-logs-to-csv-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
				<span class="description"><?php _e('Press this button if you wish to download this log in CSV format.', 'all-in-one-wp-security-and-firewall'); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowpsec_export_acct_activity_logs_to_csv" value="<?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary"/>
		</form>
	</div>
</div>