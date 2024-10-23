<?php if (!defined('WPO_VERSION')) die('No direct access.'); ?>
<div style="<?php echo esc_attr($smush_info_display); ?>">
	<p><?php echo esc_html($smush_info); ?></p>
	<?php echo $smush_details; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped ?>
</div>

<?php if ($compressed_by_another_plugin && !$smush_marked) { ?>
	<p><b><?php esc_html_e('Note: This image is already compressed by another plugin', 'wp-optimize'); ?></b></p>
<?php } ?>

<a class="wpo-smush-compress-popup-btn" href="#" data-blog="<?php echo esc_attr($blog_id); ?>" data-id="<?php echo esc_attr($post_id); ?>" id="smush_compress_<?php echo esc_attr($post_id); ?>" style="<?php echo esc_attr($smush_display); ?>"><?php esc_html_e('Compress', 'wp-optimize'); ?></a>

<div class='wpo_restore_single_image restore_possible wpo-fieldgroup' style="<?php echo esc_attr($restore_action); ?>">
	<a href="#" id="wpo_restore_single_image_<?php echo esc_attr($post_id); ?>" data-blog="<?php echo esc_attr(get_current_blog_id()); ?>" data-id="<?php echo esc_attr($post_id); ?>"><?php esc_html_e('Restore original image', 'wp-optimize');?></a>
	<span tabindex="0" data-tooltip="<?php echo esc_attr($restore_tooltip);?>"><span class="dashicons dashicons-editor-help"></span> </span>
</div>

<?php echo $before_smush_sep; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped ?>

<div class="wpo_smush_mark_single_image action_button" style="<?php echo esc_attr($smush_mark); ?>">
	<a href="#" data-blog="<?php echo esc_attr(get_current_blog_id()); ?>" data-id="<?php echo esc_attr($post_id); ?>" id="smush_mark_<?php echo esc_attr($post_id); ?>"><?php esc_html_e('Mark as already compressed', 'wp-optimize'); ?></a>
</div>

<div class="wpo_smush_unmark_single_image action_button" style="<?php echo esc_attr($smush_unmark); ?>" >
	<a href="#" data-blog="<?php echo esc_attr(get_current_blog_id()); ?>" data-id="<?php echo esc_attr($post_id); ?>" id="smush_unmark_<?php echo esc_attr($post_id); ?>"><?php esc_html_e('Mark as uncompressed', 'wp-optimize'); ?></a>
</div>
