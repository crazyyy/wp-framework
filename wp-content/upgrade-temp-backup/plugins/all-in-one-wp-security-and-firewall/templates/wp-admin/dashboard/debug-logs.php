<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="inside">
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php esc_html_e('Debug log options', 'all-in-one-wp-security-and-firewall');?></label></h3>
		<div class="inside">
			<form action="" id="aios-clear-debug-logs" method="POST">
				<input name="aiowpsec_clear_logs" type="submit" value="<?php esc_attr_e('Clear logs', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary aios-clear-debug-logs" data-message="<?php echo esc_js(__('Are you sure you want to clear all the debug logs?', 'all-in-one-wp-security-and-firewall')); ?>">
			</form>
		</div>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Debug logs', 'all-in-one-wp-security-and-firewall');?></label></h3>
	<div class="inside" id="debug-list-table">
		<?php
			$debug_log_list->prepare_items();
			$debug_log_list->display();
		?>
	</div>
</div>

<div class="aio_blue_box">
	<?php
	echo '<p>' . __('This section displays information valuable for diagnosing conflicts, configuration discrepancies, or compatibility concerns with other plugins, themes, or the hosting environment.', 'all-in-one-wp-security-and-firewall') . '</p>'
		.'<p>' . __('You can use this information to help troubleshoot issues you may be experiencing with your WordPress site or send a report to the AIOS team.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<?php
	do_action('aiowp_security_before_report_sections');

	echo $aio_wp_security->debug_obj->generate_report();

	do_action('aiowp_security_after_report_sections');
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Copy/send report', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside" id="report-actions">
		<?php
		echo $aio_wp_security->debug_obj->generate_report_textarea(esc_html__('All-In-One Security diagnostics report', 'all-in-one-wp-security-and-firewall'));
		echo '<div><button class="button" id="copy-report">' . __('Copy to clipboard', 'all-in-one-wp-security-and-firewall') . '</button></div>';
		do_action('aiowp_security_additional_report_actions');
		?>
	</div>
</div>