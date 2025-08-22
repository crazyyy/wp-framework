<?php if (!defined('AIO_WP_SECURITY_PATH')) die('No direct access allowed'); ?>

<?php if (!empty($button_meta) && 'review' == $button_meta) : ?>

	<div class="aiowps_ad_container updated">
	<div class="aiowps_notice_container aiowps_review_notice_container">
		<div class="aiowps_advert_content_left_extra">
			<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- PCP error. Image hard coded. Cannot be enqueued. ?>
			<img src="<?php echo esc_url(AIO_WP_SECURITY_URL) . '/images/' . esc_attr($image);?>" width="100" alt="<?php esc_html_e('notice image', 'all-in-one-wp-security-and-firewall');?>" />
		</div>
		<div class="aiowps_advert_content_right">
			<p>
				<?php echo wp_kses_post($text); ?>
			</p>
					
			<?php if (!empty($button_link)) { ?>
				<div class="aiowps_advert_button_container">
					<a class="button button-primary" href="<?php echo esc_url($button_link);?>" target="_blank" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '1'}});">
						<?php esc_html_e('Review', 'all-in-one-wp-security-and-firewall'); ?>
					</a>
					<div class="dashicons dashicons-calendar"></div>
					<a class="aiowps_notice_link" href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '0'}});">
						<?php esc_html_e('Maybe later', 'all-in-one-wp-security-and-firewall'); ?>
					</a>
					<div class="dashicons dashicons-no-alt"></div>
					<a class="aiowps_notice_link" href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>', dismiss_forever: '1'}});">
						<?php esc_html_e('Never', 'all-in-one-wp-security-and-firewall'); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php else : ?>

<div class="aiowps_ad_container updated">
	<div class="aiowps_notice_container">
		<div class="aiowps_advert_content_left">
			<?php // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- PCP error. Image hard coded. Cannot be enqueued. ?>
			<img src="<?php echo esc_url(AIO_WP_SECURITY_URL) . '/images/' . esc_attr($image);?>" width="60" height="60" alt="<?php esc_html_e('notice image', 'all-in-one-wp-security-and-firewall');?>" />
		</div>
		<div class="aiowps_advert_content_right">
			<h3 class="aiowps_advert_heading">
				<?php
					if (!empty($prefix)) echo esc_html($prefix) . ' ';
					echo wp_kses_post($title);
				?>
				<div class="aiowps_advert_dismiss">
				<?php if (!empty($dismiss_time)) { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp(); jQuery.post(ajaxurl, {action: 'aios_ajax', subaction: 'dismiss_notice', nonce: '<?php echo esc_js(wp_create_nonce('wp-security-ajax-nonce')); ?>', data: { notice: '<?php echo esc_js($dismiss_time);?>'}});"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } else { ?>
					<a href="#" onclick="jQuery(this).closest('.aiowps_ad_container').slideUp();"><?php esc_html_e('Dismiss', 'all-in-one-wp-security-and-firewall'); ?></a>
				<?php } ?>
				</div>
			</h3>
			<p>
				<?php
					echo wp_kses_post($text);

					if ('inline' == $button_meta) {
						?>
						<br>
						<a href="<?php echo esc_attr(apply_filters('updraftplus_com_link', $button_link));?>"><strong><?php echo esc_html($button_text); ?></strong></a>
						<?php
						echo wp_kses_post($text2);
					}

					if (isset($discount_code)) echo ' <b>' . esc_html($discount_code) . '</b>';

					if (!empty($button_link) && !empty($button_meta) && 'inline' != $button_meta) {
				?>
				<a class="aiowps_notice_link" href="<?php echo esc_url($button_link);?>"><?php
						if ('updraftcentral' == $button_meta) {
							esc_html_e('Get UpdraftCentral', 'all-in-one-wp-security-and-firewall');
						} elseif ('updraftplus' == $button_meta) {
							esc_html_e('Get UpdraftPlus', 'all-in-one-wp-security-and-firewall');
						} elseif ('wp-optimize' == $button_meta) {
							esc_html_e('Get WP-Optimize', 'all-in-one-wp-security-and-firewall');
						} elseif ('all-in-one-wp-security-and-firewall' == $button_meta) {
							esc_html_e('Get Premium.', 'all-in-one-wp-security-and-firewall');
						} elseif ('signup' == $button_meta) {
							esc_html_e('Sign up', 'all-in-one-wp-security-and-firewall');
						} elseif ('go_there' == $button_meta) {
							esc_html_e('Go there', 'all-in-one-wp-security-and-firewall');
						} elseif ('learn_more' == $button_meta) {
							esc_html_e('Learn more', 'all-in-one-wp-security-and-firewall');
						} else {
							esc_html_e('Read more', 'all-in-one-wp-security-and-firewall');
						}
					?></a>
				<?php
					}
				?>
			</p>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php

endif;