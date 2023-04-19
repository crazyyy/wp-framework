<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('File permissions scan', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('Your WordPress file and folder permission settings govern the accessability and read/write privileges of the files and folders which make up your WP installation.', 'all-in-one-wp-security-and-firewall').'<br />'.__('Your WP installation already comes with reasonably secure file permission settings for the filesystem.', 'all-in-one-wp-security-and-firewall').'<br />'.__('However, sometimes people or other plugins modify the various permission settings of certain core WP folders or files such that they end up making their site less secure because they chose the wrong permission values.', 'all-in-one-wp-security-and-firewall').'<br />'.__('This feature will scan the critical WP core folders and files and will highlight any permission settings which are insecure.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<?php
	$detected_os = strtoupper(PHP_OS);
	if (false !== strpos($detected_os, "WIN") && "DARWIN" != $detected_os) {
		echo '<div class="aio_yellow_box">';
		echo '<p>'.__('This plugin has detected that your site is running on a Windows server.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('This feature is not applicable for Windows server installations.', 'all-in-one-wp-security-and-firewall').'
		</p>';
		echo '</div>';
	} else {
?>
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('WP directory and file permissions scan results', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
			<?php
				// Display security info badge
				$aiowps_feature_mgr->output_feature_details_badge("filesystem-file-permissions");
			?>
			<form action="" method="POST">
				<?php wp_nonce_field('aiowpsec-fix-permissions-nonce'); ?>
				<input type="hidden" name="aiowps_permission_chg_file" id="aiowps_permission_chg_file" value="">
				<input type="hidden" name="aiowps_recommended_permissions" id="aiowps_recommended_permissions" value="">
				<table class="widefat file_permission_table">
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
								$filesystem_menu->show_wp_filesystem_permission_status($file_or_dir['name'], $file_or_dir['path'], $file_or_dir['permissions']);
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th><?php _e('Name', 'all-in-one-wp-security-and-firewall'); ?></th>
							<th><?php _e('File/Folder', 'all-in-one-wp-security-and-firewall'); ?></th>
							<th><?php _e('Current permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
							<th><?php _e('Recommended permissions', 'all-in-one-wp-security-and-firewall'); ?></th>
							<th><?php _e('Recommended action', 'all-in-one-wp-security-and-firewall'); ?></th>
					</tfoot>
				</table>
			</form>
		</div>
	</div>
	<?php
	}