<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('System logs', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>'.__('Sometimes your hosting platform will produce error or warning logs in a file called "error_log".', 'all-in-one-wp-security-and-firewall').'<br />'.__('Depending on the nature and cause of the error or warning, your hosting server can create multiple instances of this file in numerous directory locations of your WordPress installation.', 'all-in-one-wp-security-and-firewall').'<br />'.__('By occasionally viewing the contents of these logs files you can keep informed of any underlying problems on your system which you might need to address.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('View system logs', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<p><?php _e('Please press the button below to view the latest system logs', 'all-in-one-wp-security-and-firewall'); ?>:</p>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-view-system-logs-nonce'); ?>
			<div>
				<label for="aiowps_system_log_file"><?php _e('Enter System Log File Name', 'all-in-one-wp-security-and-firewall'); ?>:</label>
				<input id="aiowps_system_log_file" type="text" size="25" name="aiowps_system_log_file" value="<?php echo esc_html($sys_log_file); ?>" />
				<span class="description"><?php _e('Enter your system log file name. (Defaults to error_log)', 'all-in-one-wp-security-and-firewall'); ?></span>
			</div>
			<div class="aio_spacer_15"></div>
			<input type="submit" name="aiowps_search_error_files" value="<?php _e('View latest system logs', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary search-error-files">
			<span class="aiowps_loading_1">
				<img src="<?php echo AIO_WP_SECURITY_URL.'/images/loading.gif'; ?>" alt="<?php __('Loading...', 'all-in-one-wp-security-and-firewall'); ?>" />
			</span>
		</form>
	</div>
</div>