<?php
/**
 * Displays affiliate notices.
 *
 * @package SWPTLS
 */

// If direct access than exit the file.
defined( 'ABSPATH' ) || exit;

$pink_diamond = WP_NOTIFIER_TO_SLACK_DIR_URL . 'assets/top-banner/upgr.png';
?>

<div class="wpnts-upgrade-banner">
	<span class="wpnts-upgrade-close"></span>
	<div class="banner-content">
		<div class="image-icon">
			<img class="wpnts-image-icon" src="<?php echo esc_url($pink_diamond); ?>" alt="">
		</div>
		
		<div class="content">
			<h3><?php esc_html_e('Advance Security settings, Emengency Shutdown, User activity and many more premium features are available in ', 'wpnts'); ?> <span><?php esc_html_e('WP Notifier To Slack Pro', 'wpnts'); ?></span> <?php esc_html_e('plugin 😍', 'wpnts'); ?></h3>

			<p class="review-notice"><?php esc_html_e( "You have the opportunity to unlock extra discounts beyond our official offer by participating in engaging 'click to win' games. Win discounts of up to 100% off and enjoy attractive savings!😍 ", 'wpnts' ); ?></p>

			<div class="bottom-fields">
				<div class="upgrade-btn-wrapper">
					<a href="<?php echo esc_url('https://wpxperties.com/pricing/'); ?>" target="_blank" class="upgrade-button"><?php esc_html_e('Upgrade Now', 'wpnts'); ?> <span></span></a>
				</div>

				<a href="https://wpxperties.com/luck/" target="_blank" class="coupon-offer" ><?php esc_html_e('Win Coupon', 'wpnts'); ?></a>
			</div>

		</div>
		
	</div>
	
</div>

<script>
jQuery(document).ready(function($) {
	$(document).on('click', '.wpnts-upgrade-close', (e) => {
		console.log("Click")
		e.preventDefault();

		let target = $(e.currentTarget);
		let dataValue = 'hide_notice';

		$.ajax({
			type: "POST",
			url: "<?php echo esc_url(admin_url( 'admin-ajax.php' )); ?>", // phpcs:ignore
			data: {
				action: 'gswpts_notice_action',
				nonce: '<?php echo esc_attr( wp_create_nonce( 'notifier_notices_nonce' ) ); ?>',
				info: {
					type: 'hide_notice',
					value: dataValue
				},
				actionType: 'upgrade_notice'
			},
			success: response => {
				if (response.data.response_type === 'success') {
					$('.wpnts-upgrade-banner').slideUp();
				}
			}
		});
	})
});
</script>
