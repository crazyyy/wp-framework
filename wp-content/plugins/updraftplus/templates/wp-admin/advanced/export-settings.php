<?php
	if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed');
?>
<div class="advanced_tools export_settings">
	<h3><?php esc_html_e('Export / import settings', 'updraftplus');?></h3>
	<p>
		<?php echo wp_kses(sprintf(__('Here, you can export your UpdraftPlus settings (%s), either for using on another site, or to keep as a backup.', 'updraftplus'), '<strong>'.__('including any passwords', 'updraftplus').'</strong>'), array('strong' => array())).' '.esc_html__('This tool will export what is currently in the settings tab.', 'updraftplus');?>
	</p>
	<button type="button" style="clear:left;" class="button-primary" id="updraftplus-settings-export"><?php esc_html_e('Export settings', 'updraftplus');?></button>
	
	<p>
		<?php echo esc_html(__('You can also import previously-exported settings.', 'updraftplus').' '.__('This tool will replace all your saved settings.', 'updraftplus')); ?>
	</p>
	
	<button type="button" style="clear:left;" class="button-primary" id="updraftplus-settings-import"><?php esc_html_e('Import settings', 'updraftplus');?></button>
	<input type="file" name="settings_file" id="import_settings">
</div>