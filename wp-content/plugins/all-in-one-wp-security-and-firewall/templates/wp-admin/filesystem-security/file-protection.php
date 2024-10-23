<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('File protection', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		$info_msg = __('These features allow you to protect your files and assets.', 'all-in-one-wp-security-and-firewall');
		echo '<p>'.$info_msg.' '.__('By protecting your files and assets, you can help prevent nefarious users gain key information and protect your server\'s resources.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div id="aios-file-protection-settings-message" ></div>
<form action="" method="POST" id="aios-file-protection-settings-form">
	<?php
		$aio_wp_security->include_template('wp-admin/filesystem-security/partials/wp-file-access.php');
		$aio_wp_security->include_template('wp-admin/filesystem-security/partials/prevent-hotlinks.php');
		$aio_wp_security->include_template('wp-admin/filesystem-security/partials/php-file-editing.php', false, array('show_disallow_file_edit_warning' => $show_disallow_file_edit_warning));
	?>
	<input type="submit" name="aiowps_save_file_protection" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
</form>

