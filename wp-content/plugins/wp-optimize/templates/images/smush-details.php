<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<a class="wpo-collapsible"><?php esc_html_e('More', 'wp-optimize'); ?></a>
<div class="wpo-collapsible-content">
	<table class="smush-details">
		<thead>
			<tr>
				<th><?php esc_html_e('Size name', 'wp-optimize'); ?></th>
				<th><?php esc_html_e('Original', 'wp-optimize'); ?></th>
				<th><?php esc_html_e('Compressed', 'wp-optimize'); ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sizes_info as $size => $info) {
				$saved = round((($info['original'] - $info['compressed']) / $info['original'] * 100), 2);
			?>
				<tr>
					<td><?php echo esc_html($size); ?></td>
					<td><?php echo esc_html(WP_Optimize()->format_size($info['original'], 1)); ?></td>
					<td><?php echo esc_html(WP_Optimize()->format_size($info['compressed'], 1)); ?></td>
					<td><?php echo esc_html($saved); ?>%</td>
				</tr>    
			<?php } ?>
		</tbody>
	</table>
</div>
