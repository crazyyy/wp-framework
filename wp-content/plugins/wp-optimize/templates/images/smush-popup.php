<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div id="wpo_smush_images_information_container" style="display:none;">
	<div id="wpo_smush_images_information_wrapper">
		<h3 id="wpo_smush_images_information_heading"><?php esc_html_e('Compressing images', 'wp-optimize');?></h3>
		<h4 id="wpo_smush_images_information_server"></h4>
		<div class="progress-bar orange stripes">
			<span style="width: 100%"></span>
		</div>
		<p><?php esc_html_e('The selected images are being processed; please do not close the browser', 'wp-optimize');?></p>
		<table id="smush_stats" class="smush_stats_table">
			<tbody>
			<tr class="smush_stats_row">
				<td> <?php esc_html_e('Images pending', 'wp-optimize');?></td>
				<td id="smush_stats_pending_images">&nbsp;...</td>
			</tr>
			<tr class="smush_stats_row">
				<td> <?php esc_html_e('Images completed', 'wp-optimize');?></td>
				<td id="smush_stats_completed_images">&nbsp;...</td>
			</tr>
			<tr class="smush_stats_row">
				<td> <?php esc_html_e('Size savings', 'wp-optimize');?></td>
				<td id="smush_stats_bytes_saved">&nbsp;...</td>
			</tr>
			<tr class="smush_stats_row">
				<td> <?php esc_html_e('Average savings per image', 'wp-optimize');?></td>
				<td id="smush_stats_percent_saved">&nbsp;...</td>
			</tr>
			<tr class="smush_stats_row">
				<td> <?php esc_html_e('Time elapsed', 'wp-optimize');?></td>
				<td id="smush_stats_timer">&nbsp;</td>
			</tr>
			</tbody>
		</table>
	</div>
	<input type="button" id="wpo_smush_images_pending_tasks_cancel_button" class="wpo_primary_small button-primary" value="<?php esc_attr_e('Cancel', 'wp-optimize'); ?>">
</div>

<div id="smush-complete-summary" class="complete-animation" style="display:none;">
	<span class="dashicons dashicons-no-alt close"></span>
	<div class="animation">
		<div class="checkmark-circle">
			<div class="background"></div>
			<div class="checkmark draw"></div>
		</div>
	</div>
	<div id="summary-message"></div>
	<input type="button" id="wpo_smush_get_logs" class="wpo_smush_get_logs wpo_primary_small button-primary" value="<?php esc_attr_e('View logs', 'wp-optimize'); ?>">
	<input type="button" id="wpo_smush_clear_stats_btn" class="wpo_primary_small button-primary align-right" value="<?php esc_attr_e('Clear compression statistics', 'wp-optimize'); ?>">
	<img id="wpo_smush_images_clear_stats_spinner" class="display-none align-right" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">
	<span id="wpo_smush_images_clear_stats_done" class="dashicons dashicons-yes display-none save-done align-right"></span>
	<span class="clearfix"></span>
	<input type="button" class="wpo_primary_small button-primary wpo_smush_stats_cta_btn" value="<?php esc_attr_e('Close', 'wp-optimize'); ?>">
</div>

<div id="smush-log-modal" class="complete-animation" style="display:none;">
	<div id="log-panel"></div>
	<a href="#" class="wpo_primary_small button-primary"> <?php esc_html_e('Download log file', 'wp-optimize'); ?></a>
	<input type="button" class="wpo_primary_small button-primary close" value="<?php esc_attr_e('Close', 'wp-optimize'); ?>">
</div>

<div id="smush-information-modal" style="display:none;">
	<div class="smush-information"></div>
	<input type="button" class="wpo_primary_small button-primary information-modal-close" value="<?php esc_attr_e('Close', 'wp-optimize'); ?>">
</div>

<div id="smush-information-modal-cancel-btn" style="display:none;">
	<div class="smush-information"></div>
	<input type="button" class="wpo_primary_small button-primary" value="<?php esc_attr_e('Cancel', 'wp-optimize'); ?>">
</div>
