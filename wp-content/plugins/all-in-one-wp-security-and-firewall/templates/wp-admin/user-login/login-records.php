<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('This tab displays the failed login attempts for your site.', 'all-in-one-wp-security-and-firewall').'
	<br />'.__('The information below can be handy if you need to do security investigations because it will show you the IP range, username and ID (if applicable) and the time/date of the failed login attempt.', 'all-in-one-wp-security-and-firewall').'
	<br /><strong>'.sprintf(__('Failed login records that are older than %1$d days are purged automatically.', 'all-in-one-wp-security-and-firewall'), apply_filters('aiowps_purge_failed_login_records_after_days', AIOWPSEC_PURGE_FAILED_LOGIN_RECORDS_AFTER_DAYS)).'</strong>
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Failed login records', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Fetch, prepare, sort, and filter our data...
			$failed_login_list->prepare_items();
			// echo "put table of locked entries here";
		?>
		<form id="tables-filter" method="post">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
		<?php
			$failed_login_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_failed_login');
			if (isset($_REQUEST["tab"])) {
				echo '<input type="hidden" name="tab" value="' . esc_attr($_REQUEST["tab"]) . '" />';
			}
		?>
		<!-- Now we can render the completed list table -->
		<?php $failed_login_list->display(); ?>
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-export-failed-login-records-to-csv-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
				<span class="description"><?php _e('Press this button if you wish to download this log in CSV format.', 'all-in-one-wp-security-and-firewall'); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowps_export_failed_login_records_to_csv" value="<?php _e('Export to CSV', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary"/>
		</form>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Delete all failed login records', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-delete-failed-login-records-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
				<span class="description"><?php _e('Press this button if you wish to delete all failed login records in one go.', 'all-in-one-wp-security-and-firewall'); ?></span>
				</tr>
			</table>
			<input type="submit" name="aiowps_delete_failed_login_records" value="<?php _e('Delete all failed login records', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" onclick="return confirm('Are you sure you want to delete all records?')"/>
		</form>
	</div>
</div>
