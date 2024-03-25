<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<h3><?php esc_html_e('Export / import settings', 'wp-optimize'); ?></h3>

<div id="wp-optimize-export-import-settings" class="wpo-fieldgroup">
	<p>
		<?php esc_html_e('Here, you can export your WP-Optimize settings, either for use on another site, or to keep as a backup.', 'wp-optimize');?>
	</p>
	<button type="button" style="clear:left;" class="button-primary" id="wpo-settings-export"><?php esc_html_e('Export settings', 'wp-optimize');?></button>

	<p>
		<?php echo esc_html__('You can also import previously-exported settings.', 'wp-optimize').' '.esc_html__('This tool will replace all your saved settings.', 'wp-optimize'); ?>
	</p>

	<button type="button" style="clear:left;" class="button-primary" id="wpo-settings-import"><?php esc_html_e('Import settings', 'wp-optimize');?></button>
	<input type="file" name="settings_file" id="import_settings">
</div>
