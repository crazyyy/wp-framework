<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');

// $options is passed in
$default_options = array(
	'include_uploader' => true,
	'include_opera_warning' => false,
	'will_immediately_calculate_disk_space' => true,
	'include_whitespace_warning' => true,
	'include_header' => false,
);

foreach ($default_options as $k => $v) {
	if (!isset($options[$k])) $options[$k] = $v;
}

// $backup_history is passed in
if (false === $backup_history) $backup_history = UpdraftPlus_Backup_History::get_history();

if (!empty($options['include_header'])) echo '<h2>'.esc_html(__('Existing backups', 'updraftplus').' ('.count($backup_history).')').'</h2>';

?>
<div class="download-backups form-table">
	<?php if (!empty($options['include_whitespace_warning'])) { ?>
		<p class="ud-whitespace-warning updraft-hidden" style="display:none;">
			<?php echo '<strong>'.esc_html__('Warning', 'updraftplus').':</strong> '.esc_html(__('Your WordPress installation has a problem with outputting extra whitespace.', 'updraftplus').' '.__('This can corrupt backups that you download from here.', 'updraftplus')).' <a href="'.esc_url(apply_filters('updraftplus_com_link', "https://teamupdraft.com/documentation/updraftplus/topics/general/troubleshooting/problems-with-extra-white-space/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=unknown&utm_creative_format=unknown")).'" target="_blank">'.esc_html__('Follow this link for more information', 'updraftplus').'</a>';?>
		</p>
	<?php }
	$bom_warning = $updraftplus_admin->get_bom_warning_text();
	if (!empty($bom_warning)) {
	?>
	<p class="ud-bom-warning">
	<?php
	echo wp_kses_post($bom_warning);
	?>
	</p>
	<?php
	}
	$updraftplus_admin->take_backup_content();
	?>
	
	<div class="updraft_existing_backups_wrapper">
		<h3 id="updraft-existing-backups-heading"><?php esc_html_e('Existing backups', 'updraftplus');?> <span class="updraft_existing_backups_count"><?php echo esc_html(count($backup_history));?></span></h3>
		<ul class="updraft-disk-space-actions">
			<?php
				echo wp_kses_post(UpdraftPlus_Filesystem_Functions::web_server_disk_space($options['will_immediately_calculate_disk_space']));
			?>
	
			<li class="updraft-server-scan">
				<strong><?php esc_html_e('More tasks:', 'updraftplus');?></strong>
				<?php
					if (!empty($options['include_uploader'])) {
					?>
					<a class="updraft_uploader_toggle" href="<?php echo esc_url(UpdraftPlus::get_current_clean_url());?>"><?php esc_html_e('Upload backup files', 'updraftplus'); ?></a> |
					<?php
					}
				?>
				<a href="<?php echo esc_url(UpdraftPlus::get_current_clean_url());?>" class="updraft_rescan_local" title="<?php echo esc_attr(__('Press here to look inside your UpdraftPlus directory (in your web hosting space) for any new backup sets that you have uploaded.', 'updraftplus').' '.__('The location of this directory is set in the expert settings, in the Settings tab.', 'updraftplus')); ?>"><?php esc_html_e('Rescan local folder for new backup sets', 'updraftplus');?></a>
				| <a href="<?php echo esc_url(UpdraftPlus::get_current_clean_url());?>" class="updraft_rescan_remote" title="<?php esc_attr_e('Press here to look inside your remote storage methods for any existing backup sets (from any site, if they are stored in the same folder).', 'updraftplus'); ?>"><?php esc_html_e('Rescan remote storage', 'updraftplus');?></a>
			</li>
			<?php if (!empty($options['include_opera_warning'])) { ?>
				<li class="updraft-opera-warning"><strong><?php esc_html_e('Opera web browser', 'updraftplus');?>:</strong> <?php esc_html_e('If you are using this, then turn Turbo/Road mode off.', 'updraftplus');?></li>
			<?php } ?>
		</ul>
		<?php
			if (!empty($options['include_uploader'])) {
			?>
		
			<div id="updraft-plupload-modal" style="display:none;" title="<?php esc_attr_e('UpdraftPlus - Upload backup files', 'updraftplus'); ?>">
			<p class="upload"><em><?php echo esc_html(__("Upload files into UpdraftPlus.", 'updraftplus').' '.__('Or, you can place them manually into your UpdraftPlus directory (usually wp-content/updraft), e.g. via FTP, and then use the "rescan" link above.', 'updraftplus'));?></em></p>
			<?php
			if (version_compare($updraftplus->get_wordpress_version(), '3.3', '<')) {
				echo '<em>'.esc_html(
					sprintf(
						/* translators: %1$s: WordPress  %2$s: version number */
						__('This feature requires %1$s version %2$s or later', 'updraftplus'),
						'WordPress',
						'3.3'
					)
				).'</em>';
			} else {
				?>
				<div id="plupload-upload-ui">
				<div id="drag-drop-area">
					<div class="drag-drop-inside">
					<p class="drag-drop-info"><?php esc_html_e('Drop your backup files', 'updraftplus'); ?></p>
					<p><?php echo esc_html_x('or', 'Uploader: Drop your backup files - or - Select Files'); ?></p>
					<p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
					</div>
				</div>
				<div id="filelist">
				</div>
				</div>
				<?php
			}
			?>
			</div>
		<?php
			}
		?>		
		<div class="ud_downloadstatus"></div>
		<div class="updraft_existing_backups">
			<?php
			echo UpdraftPlus_Backup_History::existing_backup_table($backup_history);// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML has an onclick attribute, but otherwise is already sanitised
			?>
		</div>
	</div>
</div>
