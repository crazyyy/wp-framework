<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('WordPress files', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
		$info_msg = sprintf(__('This feature allows you to prevent access to files such as %s, %s and %s which are delivered with all WP installations.', 'all-in-one-wp-security-and-firewall'), 'readme.html', 'license.txt', 'wp-config-sample.php');
		echo '<p>'.$info_msg.'</p>'.'<p>'.__('By preventing access to these files you are hiding some key pieces of information (such as WordPress version info) from potential hackers.', 'all-in-one-wp-security-and-firewall').'</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Prevent access to default WP files', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("block-wp-files-access");
		?>
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-prevent-default-wp-file-access-nonce'); ?>            
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Prevent access to WP default install files', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
					<input id="aiowps_prevent_default_wp_file_access" name="aiowps_prevent_default_wp_file_access" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_prevent_default_wp_file_access')) echo ' checked="checked"'; ?> value="1"/>
					<label for="aiowps_prevent_default_wp_file_access" class="description"><?php _e('Check this if you want to prevent access to readme.html, license.txt and wp-config-sample.php.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_save_wp_file_access_settings" value="<?php _e('Save setting', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>