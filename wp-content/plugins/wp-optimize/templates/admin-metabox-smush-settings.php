<?php if (!defined('WPO_VERSION')) die('No direct access.'); ?>
<div class='wpo_smush_single_image compression_level' style="<?php echo esc_attr($smush_display); ?>">
	<label for="enable_lossy_compression">
		<input type="radio" id="enable_lossy_compression" name="compression_level" class="smush-options compression_level" <?php checked($smush_options['image_quality'], 60); ?>> 
		<?php esc_html_e('Prioritize maximum compression', 'wp-optimize');?>
		<span tabindex="0" data-tooltip="<?php esc_attr_e('Potentially uses lossy compression to ensure maximum savings per image, the resulting images are of a slightly lower quality', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
	</label>
	<label for="enable_lossless_compression">
		<input type="radio" id="enable_lossless_compression" name="compression_level" class="smush-options compression_level" <?php checked($smush_options['image_quality'], 92); ?>>
		<?php esc_html_e('Prioritize retention of detail', 'wp-optimize');?>
		<span tabindex="0" data-tooltip="<?php esc_attr_e('Uses lossless compression, which results in much better image quality but lower filesize savings per image', 'wp-optimize');?>"><span class="dashicons dashicons-editor-help"></span> </span>
	</label>
	<label for="enable_custom_compression">
		<input id="enable_custom_compression" type="radio" name="compression_level" class="smush-options compression_level" <?php checked($custom); ?>> 
		<?php esc_html_e('Custom', 'wp-optimize');?>
	</label>
	<div class="smush-options custom_compression" <?php if (!$custom) echo 'style="display:none;"';?>>
		<span class="alignleft"><?php esc_html_e('Maximum compression', 'wp-optimize');?></span>
		<input id="custom_compression_slider" class="compression_level" data-max="<?php esc_attr_e('Maximum Compression', 'wp-optimize'); ?>"  type="range" step="5" value="<?php echo intval($smush_options['image_quality']); ?>" min="65" max="90" list="number" />
		<datalist id="number">
			<option value="65"/>
			<option value="70"/>
			<option value="75"/>
			<option value="80"/>
			<option value="85"/>
			<option value="90"/>
		</datalist>
		<span class="alignright"><?php esc_html_e('Best image quality', 'wp-optimize');?></span>
	</div>
</div>
<a href="#" class="wpo-toggle-advanced-options wpo_smush_single_image" style="<?php echo esc_attr($smush_display); ?>"><?php esc_html_e('Show advanced options', 'wp-optimize');?></a>
<div class='smush-advanced wpo-advanced-options'>
	<h4><?php esc_html_e('Service provider', 'wp-optimize');?></h4>
	<fieldset class="compression_server">
		<label for="resmushit"> 
			<input type="radio" id="resmushit" name="compression_server_<?php echo esc_attr($post_id); ?>" value="resmushit" <?php checked($smush_options['compression_server'], 'resmushit'); ?>>
			<a href="http://resmush.it" target="_blank"><?php esc_html_e('reSmush.it', 'wp-optimize');?></a>
		</label>
	</fieldset>
	<h4><?php esc_html_e('Other options', 'wp-optimize');?></h4>			
	<fieldset class="other_options">
		<label for='smush_backup_<?php echo esc_attr($post_id); ?>'>
			<input type='checkbox' name='smush_backup_<?php echo esc_attr($post_id); ?>' id='smush_backup_<?php echo esc_attr($post_id); ?>' <?php checked($smush_options['back_up_original']); ?>>
			<span><?php esc_html_e('Backup original', 'wp-optimize'); ?></span>
		</label>
		<label for='smush_exif_<?php echo esc_attr($post_id); ?>'>
			<input type='checkbox' name='smush_exif_<?php echo esc_attr($post_id); ?>' id='smush_exif_<?php echo esc_attr($post_id); ?>' class="preserve_exif" <?php checked($smush_options['preserve_exif']); ?>>
			<span><?php esc_html_e('Keep EXIF data', 'wp-optimize'); ?></span>
		</label>
	</fieldset>
</div>