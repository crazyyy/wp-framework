<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div class="wpo_section wpo_group">
	<form id="wpo-404-detector-form">
		<div class="wpo-fieldgroup wpo-show">
			<div class="switch-container">
				<label class="switch">
					<input
						name="404_detector"
						id="wpo_404_detector"
						class="wpo-save-settings"
						type="checkbox"
						value="1"
						<?php checked($is_enabled); ?>
					>
					<span class="slider round"></span>
				</label>
				<label for="wpo_404_detector">
					<?php esc_html_e('Enable 404 Detector', 'wp-optimize');?>
				</label>
			</div>
		</div>
	</form>
</div>
<div id="wpo_404_detector_results" style="display: <?php echo $is_enabled ? 'block' : 'none'; ?>">
<?php
add_thickbox();

$add_thickbox_for_urls = array();

?>
<span class="dashicons dashicons-info-outline"></span> <span style="vertical-align:middle;"><?php echo esc_html__('Here are the the most recent addresses requested that resulted in a 404 Not Found error a high number of times', 'wp-optimize') . ' (' . sprintf(esc_html__('Over %s in a single hour', 'wp-optimize'), esc_html($suspicious_threshold)) . ')'; ?></span>
<?php

if (0 == count($requests) || !$report_has_data) {
?>
<table class="wp-list-table widefat striped wpo-404-requests">
	<tr><td colspan="5"><?php echo esc_html__('Nothing to show', 'wp-optimize'); ?></td></tr>
</table>
<?php
}

foreach ($requests as $url => $url_requests) {
	?>
	<h1><?php echo esc_html($url); ?></h1>
<table class="wp-list-table widefat striped wpo-404-requests">
	<tr>
		<th class="wpo-thin-header"><?php esc_html_e('Times accessed', 'wp-optimize'); ?></th>
		<th><?php esc_html_e('Referrer', 'wp-optimize'); ?></th>
		<th class="wpo-thin-header-2"><?php esc_html_e('First access', 'wp-optimize'); ?></th>
		<th class="wpo-thin-header-2"><?php esc_html_e('Last access', 'wp-optimize'); ?></th>
	</tr>
	<?php
	
	foreach ($url_requests as $row) {
		if (1 < $row->occurrences && 'grouped' == $row->row_type) {

			if (0 == $row->non_suspicious_referrers && 1 == $row->total_referrers) {
				// There is no additional information inside the group to be shown, no thickbox
				continue;
			}

			$tb_id = md5($row->url);
			$add_thickbox_for_urls[] = $tb_id;

			$row->referrer = '<a title="' . esc_attr($row->url) . '" href="#TB_inline?width=350&height=500&inlineId=requests-detail-' .  esc_attr($tb_id) . '" class="thickbox">' . esc_html__('View all (including URLs with low 404 requests count)', 'wp-optimize') . '</a>';
		}
		?>
		<tr>
			<td class="wpo-text-center"><?php echo sprintf('grouped' == $row->row_type ? '<b>%s</b>' : '%s', esc_html($row->total_count)); ?></td>
			<td><?php echo '' != $row->referrer ? $row->referrer : ('<i>' . esc_html__('Not available', 'wp-optimize') . '</i>'); // phpcs:ignore WordPress.Security.EscapeOutput -- $row->referrer is already escaped ?></td>
			<td><?php echo esc_html(WP_Optimize()->format_date_time($row->first_access, ' ')); ?></td>
			<td><?php echo esc_html(WP_Optimize()->format_date_time($row->last_access, ' ')); ?></td>
		</tr>
	<?php
	}

	?>
</table>
<?php
}

foreach ($requests as $url => $url_requests) {
	foreach ($url_requests as $row) {
		$tb_id = md5($row->url);

		if (in_array($tb_id, $add_thickbox_for_urls) && (1 < $row->occurrences)) {
		?>
		<div id="requests-detail-<?php echo esc_attr($tb_id); ?>" style="display:none;">
			<?php
			$url_requests = $obj_404_detector->get_url_requests_by_referrer($row->url);
			$table_body = array();

			$requests_groups = array('over', 'under');

			foreach ($requests_groups as $group) {
				if ('over' == $group && empty($url_requests['over'])) {
					// There are both over and under the threshold, split it with a title
					$table_body[] = '<tr><td colspan=4><h4>' . esc_html__('No URLs with many 404 requests found', 'wp-optimize') . ' (' . sprintf(esc_html__('over %s hits in a single hour', 'wp-optimize'), $obj_404_detector->get_suspicious_request_count_threshold()) . ')</h4></td></tr>';
				}

				if ('under' == $group && (0 < count($url_requests['under']))) {
					// There are both over and under the threshold, split it with a title
					$table_body[] = '<tr><td colspan=4><h4>' . esc_html__('URLs with few 404 requests', 'wp-optimize') . ' (' . sprintf(esc_html__('under %s hits in a single hour', 'wp-optimize'), $obj_404_detector->get_suspicious_request_count_threshold()) . ')</h4></td></tr>';
				}

				foreach ($url_requests[$group] as $item) {
					$table_body[] = '<tr>
										<td>' . ('' != $item->referrer ? esc_html($item->referrer) : ('<i>' . esc_html__('Not available', 'wp-optimize') . '</i>')) . '</td>
										<td class="wpo-text-center"><b>' . $item->total_count . '</b></td>
										<td class="wpo-text-center">' . esc_html(WP_Optimize()->format_date_time($item->first_access, ' ')) . '</td>
										<td class="wpo-text-center">' . esc_html(WP_Optimize()->format_date_time($item->last_access,  ' ')) . '</td>
									</tr>';
				}
			}

			?>
			<table class="wpo_span_3_of_3">
				<tr>
					<th><?php echo esc_html__('Referrer', 'wp-optimize'); ?></th>
					<th class="wpo-text-center"><?php echo esc_html__('Hits', 'wp-optimize'); ?></th>
					<th class="wpo-text-center"><?php echo esc_html__('First access', 'wp-optimize'); ?></th>
					<th class="wpo-text-center"><?php echo esc_html__('Last access', 'wp-optimize'); ?></th>
				</tr>
			<?php
				echo implode("", $table_body); // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
					?>
			</table>
		</div>
		<?php
		}
	}
}
?>
</div>
