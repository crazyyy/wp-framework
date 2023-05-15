<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Failed login records', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$audit_log_link = '<a href="admin.php?page='.AIOWPSEC_MAIN_MENU_SLUG.'&tab=audit-logs">' . __('here', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_orange_box"><p>';
			echo sprintf(__('Failed login records are now recorded in the audit log found %s. This page will be removed in a future release.', 'all-in-one-wp-security-and-firewall'), $audit_log_link);
			echo '</p></div>';
		?>
	</div>
</div>
