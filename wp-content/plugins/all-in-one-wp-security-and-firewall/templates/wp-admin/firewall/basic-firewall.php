<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<?php global $aio_wp_security; ?>
<h2><?php _e('Firewall settings', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-enable-basic-firewall-nonce'); ?>

		<div class="aio_blue_box">
			<?php
			$backup_tab_link = '<a href="admin.php?page='.AIOWPSEC_SETTINGS_MENU_SLUG.'&tab=htaccess-file-operations" target="_blank">backup</a>';
			$info_msg = sprintf(__('This should not have any impact on your site\'s general functionality but if you wish you can take a %s of your .htaccess file before proceeding.', 'all-in-one-wp-security-and-firewall'), $backup_tab_link);
			echo '<p>'.__('The features in this tab allow you to activate some basic firewall security protection rules for your site.', 'all-in-one-wp-security-and-firewall').
			'<br />'.__('The firewall functionality is achieved via the insertion of special code into your currently active .htaccess file.', 'all-in-one-wp-security-and-firewall').
			'<br />'.$info_msg.'</p>';
			?>
		</div>
		
		<?php $aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-warning-notice.php'); ?>

	   <?php
		$aio_wp_security->include_template('wp-admin/firewall/partials/basic-firewall-settings.php');
		$aio_wp_security->include_template('wp-admin/firewall/partials/xmlrpc-pingback-protection.php');
		$aio_wp_security->include_template('wp-admin/firewall/partials/disable-rss-atom.php');
		$aio_wp_security->include_template('wp-admin/firewall/partials/block-debug-log.php');
	   ?>

		<input type="submit" name="aiowps_apply_basic_firewall_settings" value="<?php _e('Save basic firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
