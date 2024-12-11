<?php if (!defined('WPO_VERSION')) die('No direct access allowed');

?>
<div class="notice notice-warning">
	<p><?php esc_html_e('You can download and attach this system status information to your ticket when contacting support', 'wp-optimize'); ?></p>
	<p>
		<button id="wpo-show-status-report-btn" class="button-secondary"><?php esc_html_e('Show', 'wp-optimize'); ?></button>
		<button id="wpo-copy-status-report-btn" class="button-secondary"><?php esc_html_e('Copy', 'wp-optimize'); ?></button>
		<button id="wpo-download-status-report-btn" class="button-secondary"><?php esc_html_e('Download report', 'wp-optimize'); ?></button><div id="wpo-copy-action-result"></div>
	</p>
	<div id="report_container"></div>
</div>
<div id="wpo-server-info">
<?php
$markdown_report = '';
foreach ($report_data as $block) :
	$main_title = $block['title'];
	$markdown_report .= "### $main_title ###\n\n";
?>
	<h2><?php echo esc_html($main_title); ?></h2>
	<table class="wp-list-table widefat fixed striped table-view-list wp-optimize_page_wpo_settings">
	<?php
	foreach ($block['items'] as $info) :
		$title = strip_tags($info['title']);
		$value = $info['value'];
		$markdown_value = isset($info['markdown_value']) ? $info['markdown_value'] : $value;
		?>
		<tr>
			<td><?php echo esc_html($title); ?></td>
			<td><?php echo $value; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output already escaped ?></td>
		</tr>
	<?php
		$markdown_report .= $title . ': ' . esc_html(strip_tags($markdown_value)) . "\n";
	endforeach;
	$markdown_report .= "\n";
	?>
	</table>
<?php
endforeach;

?>
	<textarea name="server_info_report" id="wpo-server-info-report" cols="30" rows="10"><?php
	echo $markdown_report; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Output already escaped
?></textarea>
</div>
