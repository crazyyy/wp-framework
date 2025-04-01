<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>
<div class="aiowps_feature_status_container">
	<?php if (!empty($widget_data['title'])) { ?>
	<p><?php echo esc_html($widget_data['title']); ?></p>
	<?php } ?>
	<table class="widefat aiowps_dashboard_table">
	<?php if (is_array($widget_data['columns'])) { ?>
		<thead>
			<tr>
			<?php foreach ($widget_data['columns'] as $column) { ?>
				<th><?php echo esc_html($column); ?></th>
			<?php } ?>
			</tr>
		</thead>
	<?php } ?>
	<?php if (is_array($widget_data['data'])) { ?>
		<?php foreach ($widget_data['data'] as $row) { ?>
			<tr>
			<?php if (is_array($row)) { ?>
				<?php foreach ($row as $entry) { ?>
				<td><?php echo esc_html($entry); ?></td>
				<?php } ?>
			<?php } ?>
			</tr>
		<?php } ?>
	<?php } ?>
	</table>
	<div class="aio_clear_float"></div>
</div>
