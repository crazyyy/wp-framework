<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Allow list', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<p>
				<?php esc_html_e('This option allows you to add IP addresses to your allow list.', 'all-in-one-wp-security-and-firewall'); ?><br>
				<?php esc_html_e('All IPs in your allow list will no longer be affected by the firewall\'s rules.', 'all-in-one-wp-security-and-firewall'); ?><br>
			</p>
		</div>
			<form action="" method='post' id="aios-firewall-allowlist-form">
			<table class="form-table">
				<tr valign="top">
					<?php AIOWPSecurity_Utility_UI::ip_input_textarea(__('Enter IP addresses:', 'all-in-one-wp-security-and-firewall'), 'aios_firewall_allowlist', $allowlist,  __('Enter one or more IP addresses or IP ranges.', 'all-in-one-wp-security-and-firewall')); ?>
				</tr>
			</table>
			<?php submit_button(esc_html__('Save allow list', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_firewall_allowlist');?>
		</form>
	</div>			
</div>