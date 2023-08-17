<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_grey_box">
	<p><?php _e('For information, updates and documentation, please visit the', 'all-in-one-wp-security-and-firewall'); ?> <a href="https://aiosplugin.com" target="_blank"><?php echo htmlspecialchars('All In One WP Security & Firewall Plugin'); ?></a> <?php _e('Page', 'all-in-one-wp-security-and-firewall'); ?>.</p>
</div>
<?php
if (!is_super_admin()) {
	// Hide config settings if multisite and not super admin.
	AIOWPSecurity_Utility::display_multisite_super_admin_message();
} else {
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('WP Security plugin', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<p>
			<?php
			_e('Thank you for using the AIOS security plugin.', 'all-in-one-wp-security-and-firewall');
			?>
			&nbsp;
			<?php
			_e('There are a lot of security features in this plugin.', 'all-in-one-wp-security-and-firewall');
			?>
		</p>
		<p>
			<?php
			_e('To start, go through each security option and enable the "basic" options.', 'all-in-one-wp-security-and-firewall');
			?>
			&nbsp;
			<?php
			_e('The more features you enable, the more security points you will achieve.', 'all-in-one-wp-security-and-firewall');
			?>
		</p>
		<p><?php _e('Before doing anything we advise taking a backup of your .htaccess file, database and wp-config.php.', 'all-in-one-wp-security-and-firewall'); ?></p>
		<p>
		<ul class="aiowps_admin_ul_grp1">
			<li><a href="admin.php?page=aiowpsec_database&tab=database-backup" target="_blank"><?php _e('Backup your database', 'all-in-one-wp-security-and-firewall'); ?></a></li>
			<li><a href="admin.php?page=aiowpsec_settings&tab=htaccess-file-operations" target="_blank"><?php _e('Backup .htaccess file', 'all-in-one-wp-security-and-firewall'); ?></a></li>
			<li><a href="admin.php?page=aiowpsec_settings&tab=wp-config-file-operations" target="_blank"><?php _e('Backup wp-config.php file', 'all-in-one-wp-security-and-firewall'); ?></a></li>
		</ul>
		</p>
	</div>
</div> <!-- end postbox-->
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable security features', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form method="post" action="">
			<?php wp_nonce_field('aiowpsec-disable-all-features'); ?>
			<div class="aio_blue_box">
				<?php
				echo '<p>'.__('If you think that some plugin functionality on your site is broken due to a security feature you enabled in this plugin, then use the following option to turn off all the security features of this plugin.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<div class="submit">
				<input type="submit" class="button" name="aiowpsec_disable_all_features" value="<?php _e('Disable all security features', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div> <!-- end postbox-->
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Disable all firewall rules', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form method="post" action="">
			<?php wp_nonce_field('aiowpsec-disable-all-firewall-rules'); ?>
			<div class="aio_blue_box">
				<?php
				echo '<p>'.__('This feature will disable all firewall rules which are currently active in this plugin and it will also delete these rules from your .htacess file. Use it if you think one of the firewall rules is causing an issue on your site.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<div class="submit">
				<input type="submit" class="button" name="aiowpsec_disable_all_firewall_rules" value="<?php _e('Disable all firewall rules', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div> <!-- end postbox-->
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Reset settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form method="post" action="">
			<div class="aio_blue_box">
				<?php
				echo '<p>'.htmlspecialchars(__('This feature will delete all of your settings related to the All In One WP Security & Firewall Plugin.', 'all-in-one-wp-security-and-firewall')).'</p>';
				echo '<p>'.__('This feature will reset/empty all the database tables of the security plugin also.', 'all-in-one-wp-security-and-firewall').'</p>';
				echo '<p>'.htmlspecialchars(__('Use this feature if you were locked out by the All In One WP Security & Firewall Plugin and/or you are having issues logging in when that plugin is activated.', 'all-in-one-wp-security-and-firewall')).'</p>';
				echo '<p>'.htmlspecialchars(__('In addition to the settings it will also delete any directives which were added to the .htaccess file by the All In One WP Security & Firewall Plugin.', 'all-in-one-wp-security-and-firewall')).'</p>';
				echo '<p>'.sprintf(htmlspecialchars(__('%1$sNOTE: %2$sAfter deleting the settings you will need to re-configure the All In One WP Security & Firewall Plugin.', 'all-in-one-wp-security-and-firewall')), '<strong>', '</strong>').'</p>';
				?>
			</div>
			<div class="submit">
				<input type="submit" name="aiowps_reset_settings" value="<?php _e('Reset settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button">
			</div>
			<?php wp_nonce_field('aiowps-reset-settings-nonce'); ?>
		</form>
	</div>
</div> <!-- end postbox-->
<?php
} // End if statements
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Debug settings', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form method="post" action="">
			<?php wp_nonce_field('aiowpsec-save-debug-settings'); ?>
			<div class="aio_blue_box">
				<?php
				echo '<p>'.__('This setting allows you to enable/disable debug for this plugin.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Enable debug', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_enable_debug" name="aiowps_enable_debug" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_enable_debug')=='1') echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_enable_debug" class="description"><?php _e('Check this if you want to enable debug. You should keep this option disabled after you have finished debugging the issue.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_save_debug_settings" value="<?php _e('Save debug settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button">
		</form>
	</div>
</div> <!-- end postbox-->