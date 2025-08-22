<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div class="aiowps_ad_container error">
	<div class="aiowps_notice_container">
		<div class="aiowps_advert_content_right">
			<h3 class="aiowps_advert_heading">
				<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- PCP error. Escaping done in wp-security-notices.php ?>
				<?php echo $title; ?>
				<div class="aiowps_advert_dismiss">
				<?php if (!empty($dismiss_time)) { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>'}});"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } else { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp();"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } ?>
				</div>
			</h3>
			<p>
				<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- PCP errpr. Escaping done in wp-security-notices.php ?>
				<?php echo $text; ?>
			</p>
			<?php
			if (!empty($button_link) && !empty($button_meta)) {
			?>
			<p>
				<a class="aiowps_notice_link button button-primary" href="<?php esc_url($button_link);?>">
					<?php echo esc_html($button_meta); ?>
				</a>
				<a class="aiowps_notice_link button button-secondary" style="margin-left: 8px;" href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '1'}});">
					<?php esc_html_e('No', 'all-in-one-wp-security-and-firewall'); ?>
				</a>
			</p>
			<?php
			}
			?>

		</div>
	</div>
	<div class="clear"></div>
</div>