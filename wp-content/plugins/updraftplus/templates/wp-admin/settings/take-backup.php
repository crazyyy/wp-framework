<?php if (!defined('UPDRAFTPLUS_DIR')) die('No direct access.'); ?>
<div class="updraft_backup_content">
	<div id="updraft-insert-admin-warning"></div>
	<noscript>
		<div>
			<?php esc_html_e('JavaScript warning', 'updraftplus').': ';?><span style="color:red"><?php echo esc_html(__('This admin interface uses JavaScript heavily.', 'updraftplus').' '.__('You either need to activate it within your browser, or to use a JavaScript-capable browser.', 'updraftplus'));?></span>
		</div>
	</noscript>
	
	<?php
	if ($backup_disabled) {
		$this->show_admin_warning(
			htmlspecialchars(__("The 'Backup Now' button is disabled as your backup directory is not writable (go to the 'Settings' tab and find the relevant option).", 'updraftplus')),
			'error'
		);
	}
	?>
	
	<h3 class="updraft_next_scheduled_backups_heading"><?php esc_html_e('Next scheduled backups', 'updraftplus');?>:</h3>
	<div class="updraft_next_scheduled_backups_wrapper postbox">
		<div class="schedule">
			<div class="updraft_next_scheduled_entity">
				<div class="updraft_next_scheduled_heading">
					<strong><?php echo esc_html__('Files', 'updraftplus').':';?></strong>
				</div>
				<div id="updraft-next-files-backup-inner">
					<?php
					$updraftplus_admin->next_scheduled_files_backups_output();
					?>
				</div>
			</div>
			<div class="updraft_next_scheduled_entity">
				<div class="updraft_next_scheduled_heading">
					<strong><?php echo esc_html__('Database', 'updraftplus').':';?></strong>
				</div>
				<div id="updraft-next-database-backup-inner">
					<?php
						$updraftplus_admin->next_scheduled_database_backups_output();
					?>
				</div>
			</div>
			<div class="updraft_time_now_wrapper">
				<?php
				// wp_date() is WP 5.3+, but performs translation into the site locale
				$current_time = function_exists('wp_date') ? wp_date('D, F j, Y H:i') : get_date_from_gmt(gmdate('Y-m-d H:i:s'), 'D, F j, Y H:i');
				?>
				<span class="updraft_time_now_label"><?php echo esc_html__('Time now', 'updraftplus').': ';?></span>
				<span class="updraft_time_now"><?php echo esc_html($current_time);?></span>
			</div>
		</div>
		<div class="updraft_backup_btn_wrapper">
			<button id="updraft-backupnow-button" type="button" <?php disabled((bool) $backup_disabled); ?> class="button button-primary button-large button-hero" <?php if ($backup_disabled) echo 'title="'.esc_attr(__('This button is disabled because your backup directory is not writable (see the settings).', 'updraftplus')).'" ';?> onclick="updraft_backup_dialog_open(); return false;"><?php echo esc_html(str_ireplace('Back Up', 'Backup', __('Backup Now', 'updraftplus')));?></button>
			<?php
				if (!$backup_disabled) {
					$link = '<p><a href="#" id="updraftplus_incremental_backup_link" onclick="updraft_backup_dialog_open(\'incremental\'); return false;" data-incremental="0">'.esc_html__('Add changed files (incremental backup) ...', 'updraftplus') . '</a></p>';
					echo wp_kses(apply_filters('updraftplus_incremental_backup_link', $link), $updraftplus_admin->kses_allow_tags());
				}
			?>
		</div>
		<div id="updraft_activejobs_table">
			<?php
			$active_jobs = $this->print_active_jobs();
			?>
			<div id="updraft_activejobsrow">
				<?php
					echo $active_jobs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- it's ignored because the value of the variable contains HTML elements
				?>
			</div>
		</div>
	</div>

	
	<div id="updraft_lastlogmessagerow">
		<h3><?php esc_html_e('Last log message', 'updraftplus');?>:</h3>
		<?php $this->most_recently_modified_log_link(); ?>
		<div class="postbox">
			<span id="updraft_lastlogcontainer"><?php echo wp_kses_post(UpdraftPlus_Options::get_updraft_lastmessage()); ?></span>			
		</div>
	</div>
	
	<div id="updraft-iframe-modal">
		<div id="updraft-iframe-modal-innards">
		</div>
	</div>
	
	<div id="updraft-authenticate-modal" style="display:none;" title="<?php esc_attr_e('Remote storage authentication', 'updraftplus');?>">
		<p><?php esc_html_e('You have selected a remote storage option which has an authorization step to complete:', 'updraftplus'); ?></p>
		<div id="updraft-authenticate-modal-innards">
		</div>
	</div>
	
	<div id="updraft-backupnow-modal" title="UpdraftPlus - <?php esc_html_e('Perform a backup', 'updraftplus'); ?>">
		<?php
			echo $updraftplus_admin->backupnow_modal_contents(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- it's ignored because the call to the method returns a value that contains HTML elements
		?>
	</div>
	
	<?php if (is_multisite() && !file_exists(UPDRAFTPLUS_DIR.'/addons/multisite.php')) { ?>
		<h2>UpdraftPlus <?php esc_html_e('Multisite', 'updraftplus');?></h2>
		<table>
			<tr>
				<td>
					<p class="multisite-advert-width"><?php echo esc_html__('Do you need WordPress Multisite support?', 'updraftplus').' <a href="'.esc_url($updraftplus->get_url('premium')).'" target="_blank">'. esc_html__('Please check out UpdraftPlus Premium.', 'updraftplus');?></a>.</p>
				</td>
			</tr>
		</table>
	<?php } ?>
</div>
