<?php if (!defined('ABSPATH')) die('No direct access.');
if ($last_50_entries) { ?>
<table class="widefat file_permission_table">
	<thead>
	<tr>
		<th><?php echo sprintf(__('Showing latest entries for file: %s', 'all-in-one-wp-security-and-firewall'), '<strong>'.$filepath.'</strong>'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($last_50_entries as $entry) { ?>
		<tr>
			<td><?php echo esc_html($entry); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } else {
	echo '<div class="aio_red_box"><p>'.sprintf(__('The file %s could not be read', 'all-in-one-wp-security-and-firewall'), '<strong>'.$filepath.'</strong>') .'</p></div>';
}