<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<div class="aiowps_ad_container error">
	<div class="aiowps_notice_container">
		<div class="aiowps_advert_content_right">
			<h3 class="aiowps_advert_heading">
				<?php echo esc_html($title); ?>
				<div class="aiowps_advert_dismiss">
				<?php if (!empty($dismiss_time)) { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>'}});"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } else { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp();"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } ?>
				</div>
			</h3>
			<p>
				<?php echo wp_kses_post($text); ?>
			</p>
			<?php
			if (!empty($button_link) && !empty($button_meta)) {
			?>
			<p>
				<a class="aiowps_notice_link button button-secondary" href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', turn_it_back_on: '1'}});">
					<?php echo esc_html($action_button_text); //Turn it back on ?>
				</a>
				<a class="aiowps_notice_link button button-secondary" style="margin-left: 8px;" href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '1'}});">
					<?php echo esc_html($dismiss_text); // Keep it off ?>
				</a>
				<a style="margin-left: 8px;" class="aiowps_notice_link button button-secondary" href="javascript:void(0);" onclick="jQuery(this).prop('disabled', true ).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '1'}}, function(resp) {
					window.location.href = '<?php echo esc_js($button_link); ?>';
					return false;
				}).done(function() { jQuery(this).prop('disabled', false); });">
					<?php echo esc_js($button_meta); // Edit the settings ?>
				</a>
			</p>
			<?php
			}
			?>

		</div>
	</div>
	<div class="clear"></div>
</div>