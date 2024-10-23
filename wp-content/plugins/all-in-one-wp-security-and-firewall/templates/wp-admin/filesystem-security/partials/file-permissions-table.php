<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<table class="wp-list-table widefat file_permission_table">
	<thead>
	<tr>
		<th><?php _e('Name', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('File/Folder', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Current permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Recommended permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Recommended action', 'all-in-one-wp-security-and-firewall'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($files_dirs_to_check as $file_or_dir) {
		$file_utility->show_wp_filesystem_permission_status($file_or_dir['name'], $file_or_dir['path'], $file_or_dir['permissions']);
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<th  class="column-primary"><?php _e('Name', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('File/Folder', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Current permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Recommended permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
		<th><?php _e('Recommended action', 'all-in-one-wp-security-and-firewall'); ?></th>
	</tfoot>
</table>