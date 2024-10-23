<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Allow list', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div class="aio_blue_box">
			<p>
				<?php _e('This option allows you to add IP addresses to your allow list.', 'all-in-one-wp-security-and-firewall'); ?><br>
				<?php _e('All IPs in your allow list will no longer be affected by the firewall\'s rules.', 'all-in-one-wp-security-and-firewall'); ?><br>
			</p>
		</div>
			<form action="" method='post' id="aios-firewall-allowlist-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="aios_firewall_allowlist"><?php _e('Enter IP addresses:', 'all-in-one-wp-security-and-firewall'); ?></label></th>
					<td>
						<textarea id="aios_firewall_allowlist" name="aios_firewall_allowlist" rows="5" cols="50"><?php echo esc_textarea($allowlist); ?></textarea>
						<br />
						<span class="description"><?php _e('Enter one or more IP addresses or IP ranges.', 'all-in-one-wp-security-and-firewall');?></span>
						<?php $aio_wp_security->include_template('info/ip-address-ip-range-info.php');?>
					</td>
				</tr>
			</table>
			<?php submit_button(__('Save allow list', 'all-in-one-wp-security-and-firewall'), 'primary', 'aiowps_save_firewall_allowlist');?>
		</form>
	</div>			
</div>