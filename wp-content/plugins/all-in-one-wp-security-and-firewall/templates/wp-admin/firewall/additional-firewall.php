<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<?php global $aio_wp_security; ?>
<h2><?php _e('Additional firewall protection', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<div class="aio_blue_box">
			<?php
			$backup_tab_link = '<a href="admin.php?page='.AIOWPSEC_SETTINGS_MENU_SLUG.'&tab=tab2" target="_blank">backup</a>';
			$info_msg = sprintf(__('Due to the nature of the code being inserted to the .htaccess file, this feature may break some functionality for certain plugins and you are therefore advised to take a %s of .htaccess before applying this configuration.', 'all-in-one-wp-security-and-firewall'), $backup_tab_link);

			echo '<p>'.__('This feature allows you to activate more advanced firewall settings to your site.', 'all-in-one-wp-security-and-firewall').
			'<br />'.__('The advanced firewall rules are applied via the insertion of special code to your currently active .htaccess file.', 'all-in-one-wp-security-and-firewall').
			'<br />'.$info_msg.'</p>';
			?>
		</div>

		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-enable-additional-firewall-nonce'); ?>

		<?php
			$aio_wp_security->include_template('wp-admin/firewall/partials/listing-directory-contents.php');
			$aio_wp_security->include_template('wp-admin/firewall/partials/disable-trace.php');
			$aio_wp_security->include_template('wp-admin/firewall/partials/proxy-comment.php');
			$aio_wp_security->include_template('wp-admin/firewall/partials/bad-query-strings.php');
			$aio_wp_security->include_template('wp-admin/firewall/partials/advanced-character-filter.php');
		?>

		<input type="submit" name="aiowps_apply_additional_firewall_settings" value="<?php _e('Save additional firewall settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
