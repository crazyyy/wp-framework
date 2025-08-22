<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php esc_html_e('Change database prefix', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		echo '<p>'.esc_html__('Your WordPress database is the most important asset of your website because it contains a lot of your site\'s precious information.', 'all-in-one-wp-security-and-firewall').'<br />'.esc_html__('The database is also a target for hackers via methods such as SQL injections and malicious and automated code which targets certain tables.', 'all-in-one-wp-security-and-firewall').'<br />'.esc_html__('One way to add a layer of protection for your DB is to change the default WordPress table prefix from "wp_" to something else which will be difficult for hackers to guess.', 'all-in-one-wp-security-and-firewall').'<br />'.esc_html__('This feature allows you to easily change the prefix to a value of your choice or to a random value set by this plugin.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Database prefix options', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("db-security-db-prefix");
		?>
		<div class="aio_red_box">
			<p>
				<strong>
					<?php
					$backup_tab_link = '<a href="admin.php?page=' . AIOWPSEC_DB_SEC_MENU_SLUG . '&tab=database-backup">' . esc_html__('database backup', 'all-in-one-wp-security-and-firewall') . '</a>';
					/* translators: %s: Backup link. */
					printf(esc_html__('It is recommended that you perform a %s before using this feature', 'all-in-one-wp-security-and-firewall'), $backup_tab_link); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- URL already escaped.
					?>
				</strong>
			</p>
		</div>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-db-prefix-change-nonce'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Current database table prefix', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<span class="aiowpsec_field_value"><strong><?php echo esc_html($wpdb->prefix); ?></strong></span>
						<?php
						// now let's display a warning notification if default prefix is used
						if ('wp_' == $old_db_prefix) {
							echo '&nbsp;&nbsp;&nbsp;<span class="aio_error_with_icon">'.esc_html__('Your site is currently using the default WordPress database prefix value of "wp_".', 'all-in-one-wp-security-and-firewall').' '.esc_html__('To increase your site\'s security you should consider changing the database prefix value to another value.', 'all-in-one-wp-security-and-firewall').'</span>';
						}
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="aiowps_new_manual_db_prefix"><?php esc_html_e('Generate new database table prefix', 'all-in-one-wp-security-and-firewall'); ?>:</label>
					</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(esc_html__('Enable this if you want the plugin to generate a random 6 character string for the table prefix', 'all-in-one-wp-security-and-firewall'), 'aiowps_enable_random_prefix', '1' == $aio_wp_security->configs->get_value('aiowps_enable_random_prefix')); ?>
							<br><?php esc_html_e('OR', 'all-in-one-wp-security-and-firewall'); ?>
							<br><input type="text" size="10" id="aiowps_new_manual_db_prefix" name="aiowps_new_manual_db_prefix" value="" />
							<label for="aiowps_new_manual_db_prefix" class="description"><?php esc_html_e('Choose your own database prefix by specifying a string which contains letters and/or numbers and/or underscores, example: xyz_', 'all-in-one-wp-security-and-firewall'); ?></label>
						</div>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_db_prefix_change" value="<?php esc_html_e('Change database prefix', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>