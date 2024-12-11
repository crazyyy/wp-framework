<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<div class="postbox aio_hidden" data-template="woo-captcha">
	<h3 class="hndle"><label for="title"><?php _e('WooCommerce forms CAPTCHA settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
		//Display security info badge
		global $aiowps_feature_mgr;
		$aiowps_feature_mgr->output_feature_details_badge("woo-login-captcha");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce login form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s login form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_login_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_login_captcha')); ?>
					</div>
				</td>
			</tr>
		</table>
		<hr>
		<?php
		$aiowps_feature_mgr->output_feature_details_badge("woo-lostpassword-captcha");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce lost password form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s lost password form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_lostpassword_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_lostpassword_captcha')); ?>
					</div>
				</td>
			</tr>
		</table>
		<hr>
		<?php
		$aiowps_feature_mgr->output_feature_details_badge("woo-register-captcha");
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable CAPTCHA on WooCommerce registration form', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert CAPTCHA on a %s registration form.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_register_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_register_captcha')); ?>
					</div>
				</td>
			</tr>
		</table>
		<hr>
		<?php
		$aiowps_feature_mgr->output_feature_details_badge("woo-checkout-captcha");
		?>
		<table class="form-table">
			<?php $is_enanled_guest_checkout = ('yes' == get_option('woocommerce_enable_guest_checkout')) ? 1 : 0; ?>
			<div class="<?php echo $is_enanled_guest_checkout ? "aio_blue_box" : "aio_red_box"; ?>">
				<p>
					<?php
					if (!$is_enanled_guest_checkout) {
						echo __('Guest checkout is not enabled in your WooCommerce settings.', 'all-in-one-wp-security-and-firewall') . ' ' . __('Therefore, the setting below is not relevant.', 'all-in-one-wp-security-and-firewall');
						$checkout_checkbox_attributes = array('disabled' => 'disabled');
					} else {
						echo __('Guest checkout allows a customer to place an order without an account or being logged in.', 'all-in-one-wp-security-and-firewall');
						$checkout_checkbox_attributes = array();
					}
					?>
				</p>
			</div>
			<tr valign="top">
				<th scope="row"><?php _e('Enable CAPTCHA on the WooCommerce checkout page', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
					<div class="aiowps_switch_container">
						<?php AIOWPSecurity_Utility_UI::setting_checkbox(sprintf(__('Enable this if you want to insert a CAPTCHA on the %s checkout page when a guest places an order.', 'all-in-one-wp-security-and-firewall'), 'WooCommerce'), 'aiowps_enable_woo_checkout_captcha', '1' == $aio_wp_security->configs->get_value('aiowps_enable_woo_checkout_captcha'), $checkout_checkbox_attributes); ?>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>