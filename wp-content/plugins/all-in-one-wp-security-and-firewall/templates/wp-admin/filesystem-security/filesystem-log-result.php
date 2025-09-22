<?php if (!defined('ABSPATH')) die('No direct access.');
if ($last_50_entries) { ?>
<table class="widefat file_permission_table">
	<thead>
	<tr>
		<?php /* translators: %s: File path. */ ?>
		<th><?php echo sprintf(esc_html__('Showing latest entries for file: %s', 'all-in-one-wp-security-and-firewall'), '<strong>' . esc_html($filepath) . '</strong>'); ?></th>
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
	/* translators: %s: File path. */
	echo '<div class="aio_red_box"><p>'.sprintf(esc_html__('The file %s could not be read', 'all-in-one-wp-security-and-firewall'), '<strong>' . esc_html($filepath) . '</strong>') . '</p></div>';
}