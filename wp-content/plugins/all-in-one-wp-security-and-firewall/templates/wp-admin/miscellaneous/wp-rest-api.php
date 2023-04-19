<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-rest-settings'); ?>
			<div class="aio_blue_box">
				<?php
					echo '<p>'.__('This feature allows you to block WordPress REST API access for unauthorized requests.', 'all-in-one-wp-security-and-firewall').'</p>';
					echo '<p>'.__('When enabled this feature will only allow REST requests to be processed if the user is logged in.', 'all-in-one-wp-security-and-firewall').'</p>';
				?>
			</div>
			<div class="aio_orange_box">
				<p>
					<?php
						echo __('Beware that if you are using other plugins which have registered REST endpoints (eg, Contact Form 7), then this feature will also block REST requests used by these plugins if the user is not logged in.', 'all-in-one-wp-security-and-firewall').' '.__('It is recommended that you leave this feature disabled if you want uninterrupted functionality for such plugins.', 'all-in-one-wp-security-and-firewall');
					?>
				</p>
			</div>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Disallow unauthorized REST requests', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<input id="aiowps_disallow_unauthorized_rest_requests" name="aiowps_disallow_unauthorized_rest_requests" type="checkbox"<?php if ('1' == $aio_wp_security->configs->get_value('aiowps_disallow_unauthorized_rest_requests')) echo ' checked="checked"'; ?> value="1"/>
						<label for="aiowps_disallow_unauthorized_rest_requests" class="description"><?php _e('Check this if you want to stop REST API access for non-logged in requests.', 'all-in-one-wp-security-and-firewall'); ?></label>
					</td>
				</tr>
			</table>
			<div class="submit">
				<input type="submit" class="button-primary" name="aiowpsec_save_rest_settings" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
			</div>
		</form>
	</div>
</div>
