<?php
if (!defined('UPDRAFTPLUS_DIR')) {
	die('No direct access allowed');
}

?>
<div class="advanced_tools cron_events">
	<?php
		echo '<h3>'.esc_html__('Cron events', 'updraftplus').'</h3>';
		echo '<p>'.esc_html(__('Here, you can view the scheduled tasks set up by the UpdraftPlus plugin.', 'updraftplus').' '.__('These cron jobs are responsible for automating various backup processes at specified intervals.', 'updraftplus').' '.__('Each schedule includes details like the hook name, the interval, and the next scheduled run time.', 'updraftplus')).'</p>';
	?>

	<table class="wp-list-table widefat striped">
		<thead>
			<tr>
				<th><strong><?php esc_html_e('Hook name', 'updraftplus'); ?></strong></th>
				<th><strong><?php esc_html_e('Interval', 'updraftplus'); ?></strong></th>
				<th><strong><?php esc_html_e('Next run', 'updraftplus'); ?></strong></th>
			</tr>
		</thead>

		<tbody></tbody>
	</table>
</div>
