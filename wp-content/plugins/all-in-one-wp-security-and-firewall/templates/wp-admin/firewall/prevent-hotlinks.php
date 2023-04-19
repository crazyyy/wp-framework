<?php if (!defined('ABSPATH')) die('Access denied.'); ?>
<h2><?php _e('Prevent image hotlinking', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<div class="aio_blue_box">
			<?php
			echo '<p>'.__('A Hotlink is where someone displays an image on their site which is actually located on your site by using a direct link to the source of the image on your server.', 'all-in-one-wp-security-and-firewall');
			echo '<br />'.__('Due to the fact that the image being displayed on the other person\'s site is coming from your server, this can cause leaking of bandwidth and resources for you because your server has to present this image for the people viewing it on someone elses\'s site.', 'all-in-one-wp-security-and-firewall');
			echo '<br />'.__('This feature will prevent people from directly hotlinking images from your site\'s pages by writing some directives in your .htaccess file.', 'all-in-one-wp-security-and-firewall').'</p>';
			?>
		</div>

		<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Prevent hotlinking', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
		<div class="inside">
		<?php
		//Display security info badge
		$aiowps_feature_mgr->output_feature_details_badge("prevent-hotlinking");
		?>

		<form action="" method="POST">
		<?php wp_nonce_field('aiowpsec-prevent-hotlinking-nonce'); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Prevent image hotlinking', 'all-in-one-wp-security-and-firewall'); ?>:</th>
				<td>
				<input id="aiowps_prevent_hotlinking" name="aiowps_prevent_hotlinking" type="checkbox"<?php if ($aio_wp_security->configs->get_value('aiowps_prevent_hotlinking')=='1') echo ' checked="checked"'; ?> value="1"/>
				<label for="aiowps_prevent_hotlinking" class="description"><?php _e('Check this if you want to prevent hotlinking to images on your site.', 'all-in-one-wp-security-and-firewall'); ?></label>
				</td>
			</tr>
		</table>
		<input type="submit" name="aiowps_save_prevent_hotlinking" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
		</div></div>
