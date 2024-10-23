<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="inside">
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Debug log options', 'all-in-one-wp-security-and-firewall');?></label></h3>
		<div class="inside">
			<form action="" id="aios-clear-debug-logs" method="POST">
				<input name="aiowpsec_clear_logs" type="submit" value="<?php _e('Clear logs', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary aios-clear-debug-logs" data-message="<?php echo esc_js(__('Are you sure you want to clear all the debug logs?', 'all-in-one-wp-security-and-firewall')); ?>">
			</form>
		</div>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Debug logs', 'all-in-one-wp-security-and-firewall');?></label></h3>
	<div class="inside" id="debug-list-table">
		<?php
			$debug_log_list->prepare_items();
			$debug_log_list->display();
		?>
	</div>
</div>
