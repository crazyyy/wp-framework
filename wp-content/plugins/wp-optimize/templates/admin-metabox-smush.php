<?php if (!defined('WPO_VERSION')) die('No direct access.'); ?>
<div id='smush-metabox-inside-wrapper'>
	<div class='wpo_restore_single_image' style="<?php echo esc_attr($restore_display); ?>">
		<div class='restore_possible' style="<?php echo esc_attr($restore_action); ?>">
			<div class="alignleft restore-icon">
				<label>
					<span>  <?php esc_html_e('Restore original', 'wp-optimize'); ?></span>

					<span tabindex="0" data-tooltip="<?php echo esc_attr($restore_tooltip);?>"><span class="dashicons dashicons-editor-help"></span> </span>
				</label>
			</div>

			<div class='alignright'>
				<input type='button' id='wpo_restore_single_image_<?php echo esc_attr($post_id); ?>' data-blog='<?php echo esc_attr(get_current_blog_id()); ?>' data-id="<?php echo esc_attr($post_id); ?>" class='button-primary button' value="<?php esc_attr_e('Restore', 'wp-optimize');?>">
			</div>
		</div>
		<p id='smush_info'><?php echo esc_html($smush_info); ?></p>
		<div id="wpo_smush_details"><?php echo $smush_details; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped ?></div>
	</div>

	<?php echo $smush_settings_form; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped ?>

	<?php if ($compressed_by_another_plugin && !$smush_marked) { ?>
		<p><b><?php esc_html_e('Note: This image is already compressed by another plugin', 'wp-optimize'); ?></b></p>
	<?php } ?>

	<div class='wpo_smush_single_image action_button' style="<?php echo esc_attr($smush_display); ?>" >
		<input type='button' data-blog='<?php echo esc_attr(get_current_blog_id()); ?>' data-id="<?php echo esc_attr($post_id); ?>" id='smush_compress_<?php echo esc_attr($post_id); ?>' class='button-primary button' value='<?php esc_attr_e('Compress', 'wp-optimize'); ?>'/>
   </div>

	<div class='wpo_smush_mark_single_image action_button' style="<?php echo esc_attr($smush_mark); ?>" >
		<input type='button' data-blog='<?php echo esc_attr(get_current_blog_id()); ?>' data-id="<?php echo esc_attr($post_id); ?>" id='smush_mark_<?php echo esc_attr($post_id); ?>' class='button' value='<?php esc_attr_e('Mark as already compressed', 'wp-optimize'); ?>'/>
	</div>

	<div class='wpo_smush_unmark_single_image action_button' style="<?php echo esc_attr($smush_unmark); ?>" >
		<input type='button' data-blog='<?php echo esc_attr(get_current_blog_id()); ?>' data-id="<?php echo esc_attr($post_id); ?>" id='smush_unmark_<?php echo esc_attr($post_id); ?>' class='button' value='<?php esc_attr_e('Mark as uncompressed', 'wp-optimize'); ?>'/>
	</div>

	<?php

	$menu_page_url = menu_page_url('wpo_images', false);

	if ('' === $menu_page_url && !is_multisite()) {
		$menu_page_url = admin_url('admin.php?page=wpo_images');
	}

	if (is_multisite()) {
		$menu_page_url = network_admin_url('admin.php?page=wpo_images');
	}
	?>
	<div class="smush-metabox-dashboard-link">
		<a href="<?php echo esc_url($menu_page_url); ?>"><?php esc_html_e('WP-Optimize image settings', 'wp-optimize'); ?></a>
	</div>
</div>

<div id="smush-information-modal" class="wp-core-ui" style="display:none;">
	<div class="smush-information"></div>
	<input type="button" class="wpo_primary_small button-primary information-modal-close" value="<?php esc_attr_e('Close', 'wp-optimize'); ?>" />
</div>

<div id="smush-information-modal-cancel-btn" style="display:none;">
	<div class="smush-information"></div>
	<input type="button" class="wpo_primary_small button-primary" value="<?php esc_attr_e('Cancel', 'wp-optimize'); ?>" />
</div>

<script type="text/javascript">jQuery(document).trigger('admin-metabox-smush-loaded');</script>
