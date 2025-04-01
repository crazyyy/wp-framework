<?php
if ('1' == $aio_wp_security->configs->get_value('aiowps_enable_rename_login_page')) {
	?>
<div class="aio_yellow_box">
	<p><?php _e('Your WordPress login page URL has been renamed.', 'all-in-one-wp-security-and-firewall'); ?></p>
	<p><?php _e('Your current login URL is:', 'all-in-one-wp-security-and-firewall'); ?></p>
	<p><strong><?php echo esc_url($home_url) . esc_html($aio_wp_security->configs->get_value('aiowps_login_page_slug')); ?></strong></p>
</div>
<?php
}