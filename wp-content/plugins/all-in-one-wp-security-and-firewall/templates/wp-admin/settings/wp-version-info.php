<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<h2><?php _e('WP generator meta tag and version info', 'all-in-one-wp-security-and-firewall'); ?></h2>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('WordPress generator automatically adds some meta information inside the "head" tags of every page on your site\'s front end, below is an example of this:', 'all-in-one-wp-security-and-firewall');
	echo '<br /><strong>&lt;meta name="generator" content="WordPress 3.5.1" /&gt;</strong>';
	echo '<br />'.__('The above meta information shows which version of WordPress your site is currently running and thus can help hackers or crawlers scan your site to see if you have an older version of WordPress or one with a known exploit.', 'all-in-one-wp-security-and-firewall').'
	<br /><br />'.__('There are also other ways Wordpress reveals version info such as during style and script loading, an example of this is:', 'all-in-one-wp-security-and-firewall').'
	<br /><strong>&lt;link rel="stylesheet" id="jquery-ui-style-css"  href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css?ver=4.5.2" type="text/css" media="all" /&gt;</strong>
	<br /><br />'.__('This feature will allow you to remove the WP generator meta info and other version info from your site\'s pages.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('WP generator meta info', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<div id="wp-generator-meta-tag-badge">
		<?php
			// Display security info badge
			$aiowps_feature_mgr->output_feature_details_badge("wp-generator-meta-tag");
		?>
		</div>
		<form action="" method="POST" id="aiowpsec-remove-wp-meta-info-form">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Remove WP generator meta info', 'all-in-one-wp-security-and-firewall'); ?>:</th>
					<td>
						<div class="aiowps_switch_container">
							<?php AIOWPSecurity_Utility_UI::setting_checkbox(__('Enable this if you want to remove the version and meta info produced by WP from all pages', 'all-in-one-wp-security-and-firewall'), 'aiowps_remove_wp_generator_meta_info', '1' == $aio_wp_security->configs->get_value('aiowps_remove_wp_generator_meta_info')); ?>
						</div>
					</td>
				</tr>
			</table>
			<input type="submit" name="aiowps_save_remove_wp_meta_info" value="<?php _e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
		</form>
	</div>
</div>