<?php

if (!defined('ABSPATH')) die('Access denied.');

?><div id="simba-tfa-admin-wrapper" class="wrap">

	<div>
		<h1><?php echo esc_html(empty($settings_page_heading) ? __('Two Factor Authentication - Admin Settings', 'all-in-one-wp-security-and-firewall') : $settings_page_heading); ?></h1>
		<?php
		if (!empty($admin_settings_links) && is_array($admin_settings_links)) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaping down in return value.
			echo implode(' | ', array_map(function($val) {
				return '<a href="'.esc_url($val['url']).'">' . esc_html($val['title']) . '</a>';
			}, $admin_settings_links));
			echo '<br>';
		}
		?>
	</div>

	<?php $encryption_enabled = $simba_tfa->get_option('tfa_encrypt_secrets'); ?>

	<?php if (defined('TWO_FACTOR_DISABLE') && TWO_FACTOR_DISABLE) { ?>
	<div class="error">
		<h3><?php esc_html_e('Two Factor Authentication currently disabled', 'all-in-one-wp-security-and-firewall');?></h3>
		<p>
			<?php esc_html_e('Two factor authentication is currently disabled via the TWO_FACTOR_DISABLE constant (which is mostly likely to be defined in your wp-config.php)', 'all-in-one-wp-security-and-firewall'); ?>
		</p>
	</div>
	<?php } ?>

	<div style="max-width:800px;">

	<?php
		if (is_multisite()) {
			if (is_super_admin()) {
				?>
				<p style="font-size: 120%; font-weight: bold;">
				<?php esc_html_e('N.B. These two-factor settings apply to your entire WordPress network. (i.e. They are not localised to one particular site).', 'all-in-one-wp-security-and-firewall');?>
				</p>
				<?php
			} else {
				// Should not be possible to reach this; but an extra check does not hurt.
				die('Security check');
			}
		}
	?>

	<form method="post" action="options.php" style="margin-top: 12px">
		<?php settings_fields('tfa_user_roles_group'); ?>
		<h2><?php esc_html_e('Make two factor authentication available', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<?php esc_html_e('Choose which user roles will have two factor authentication available.', 'all-in-one-wp-security-and-firewall'); ?>
		<p>
			<?php $simba_tfa->list_user_roles_checkboxes(); ?>
		</p>
		<?php submit_button(); ?>
	</form>
	
	<hr>

	<div class="tfa-premium">
		<h2><?php esc_html_e('Make two factor authentication compulsory', 'all-in-one-wp-security-and-firewall'); ?></h2>

		<?php

			$output = '<p><a href="' . esc_url($simba_tfa->get_premium_version_url()) . '">' . esc_html__('Requiring users to use two-factor authentication is a feature of the Premium version of this plugin.', 'all-in-one-wp-security-and-firewall').'</a><p>';
			echo apply_filters('simba_tfa_after_user_roles', $output); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped (and not suitable for kses since non-wordpress.org add-on adds HTML lists)

		?>

		<hr>
		<h2><?php esc_html_e('Trusted devices', 'all-in-one-wp-security-and-firewall'); ?></h2>

			<form method="post" action="options.php" style="margin-top: 12px">
				<?php settings_fields('tfa_user_roles_trusted_group'); ?>
				<?php esc_html_e('Choose which user roles are permitted to mark devices they login on as trusted. This feature requires browser cookies and an https (i.e. SSL) connection to the website to work.', 'all-in-one-wp-security-and-firewall'); ?>

				<?php
					$output = '<p><a href="' . esc_url($simba_tfa->get_premium_version_url()) . '">' . esc_html__('Allowing users to mark a device as trusted so that a two-factor code is only needed once in a specified number of days (instead of every login) is a feature of the Premium version of this plugin.', 'all-in-one-wp-security-and-firewall').'</a><p>';
					echo apply_filters('simba_tfa_trusted_devices_config', $output); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Contains checkboxes, and content is already escaped during construction.
					
				?>
			</form>
		</div>
	</form>	
	
	<div>
		<hr>
		<form method="post" action="options.php" style="margin-top: 40px">
		<?php
			settings_fields('tfa_xmlrpc_status_group');
		?>
			<h2><?php esc_html_e('XMLRPC requests', 'all-in-one-wp-security-and-firewall'); ?></h2>
			<?php 

			echo '<p>';
			echo esc_html__("XMLRPC is a feature within WordPress allowing other computers to talk to your WordPress install. For example, it could be used by an app on your tablet that allows you to blog directly from the app (instead of needing the WordPress dashboard).", 'all-in-one-wp-security-and-firewall');
			echo '</p><p>';

			echo esc_html__("Unfortunately, XMLRPC also provides a way for attackers to perform actions on your WordPress site, using only a password (i.e. without a two-factor password). More unfortunately, authors of legitimate programmes using XMLRPC have not yet added two-factor support to their code.", 'all-in-one-wp-security-and-firewall');
			echo '</p><p>';

			echo esc_html__("i.e. XMLRPC requests coming in to WordPress (whether from a legitimate app, or from an attacker) can only be verified using the password - not with a two-factor code. As a result, there not be an ideal option to pick below. You may have to choose between the convenience of using your apps, or the security of two factor authentication.", 'all-in-one-wp-security-and-firewall');
			echo '</p>';
			
			?>
			<p>
			<?php $simba_tfa->tfa_list_xmlrpc_status_radios(); ?>
			</p>
			<?php submit_button(); ?>
		</form>
	</div>
	
	<div id="simba-tfa-admin-settings-algorithm">
		<hr>
		<form method="post" action="options.php" style="margin-top: 40px">
			<?php settings_fields('simba_tfa_default_hmac_group'); ?>
			<h2><?php esc_html_e('Default algorithm for codes generated by user devices', 'all-in-one-wp-security-and-firewall'); ?></h2>
			<?php esc_html_e('Your users can change this in their own settings if they want.', 'all-in-one-wp-security-and-firewall'); ?>
			<p>
			<?php
			$totp_controller->print_default_hmac_radios();
			?></p>
			<?php submit_button(); ?>
		</form>
	</div>

	<div id="simba-tfa-admin-settings-encryption">
		<hr>
		<?php if ($encryption_enabled) { ?>
		<h2><?php esc_html_e('Encrypt keys in database', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<p>
		<strong><?php echo esc_html__('Encryption of keys in the database has been enabled.', 'all-in-one-wp-security-and-firewall') . ' ' . esc_html__('This feature cannot be turned off.', 'all-in-one-wp-security-and-firewall'); ?></strong>
		</p>
		<?php } else { ?>
		<form method="post" action="options.php" style="margin-top: 40px">
			<?php settings_fields('simba_tfa_encrypt_secrets_group'); ?>
			<input type="hidden" name="tfa_encrypt_secrets" value="1">
			<h2><?php esc_html_e('Encrypt keys in database', 'all-in-one-wp-security-and-firewall'); ?></h2>
			<p>
			<b><?php esc_html_e('Once turned on, this feature cannot be turned off (but there is no technical reason why this should discourage you from using it).', 'all-in-one-wp-security-and-firewall'); ?></b>
			</p>
			<p>
			<?php esc_html_e('This feature will encrypt all two factor authentication secret keys stored in the database, using an encryption key that is stored on your disk.', 'all-in-one-wp-security-and-firewall'); ?>
			<?php esc_html_e("This means that in the event your database is compromised there's an additional layer of security (the attacker would need to compromise your on-disk data as well) protecting your two factor authentication secret keys.", 'all-in-one-wp-security-and-firewall'); ?>
			</p>
			<?php submit_button(__('Enable encryption of database keys', 'all-in-one-wp-security-and-firewall')); ?>
		</form>
		<?php } ?>
	</div>
	
	<hr>
	
	<?php
	if (function_exists('WC')) {
		
		?>
		<br><br>
		<h2><?php esc_html_e("WooCommerce integration", 'all-in-one-wp-security-and-firewall'); ?></h2>
		<p>
			<?php echo apply_filters('simba_tfa_settings_woocommerce', '<a href="' . esc_url($simba_tfa->get_premium_version_url()) . '">' . esc_html__('The Premium version of this plugin allows you to add a configuration tab for users in the WooCommerce "My account" area, and anti-bot protection on the WooCommerce login form.', 'all-in-one-wp-security-and-firewall').'</a>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped, and contains checkboxes ?>
		</p>
		<hr>
	<?php } ?>
	
	<br>

	<div class="tfa-premium">
		<br>
		<h2><?php esc_html_e("Users' settings", 'all-in-one-wp-security-and-firewall'); ?></h2>
		<p>

			<?php
				if (!class_exists('Simba_Two_Factor_Authentication_Premium')) { ?>

					<a href="<?php echo esc_url($simba_tfa->get_premium_version_url()); ?>"><?php esc_html_e("The Premium version of this plugin allows you to see and reset the TFA settings of other users.", 'all-in-one-wp-security-and-firewall'); ?></a>

					<a href="https://wordpress.org/plugins/user-switching/"><?php esc_html_e('Another way to do that is by using a user-switching plugin like this one.', 'all-in-one-wp-security-and-firewall'); ?></a>

				<?php } ?>

			<?php do_action('simba_tfa_users_settings'); ?>

		<hr>
		<?php if (!class_exists('Simba_Two_Factor_Authentication_Premium')) { ?>
		<h2><?php esc_html_e('Premium version', 'all-in-one-wp-security-and-firewall'); ?></h2>
		<p>
			<a href="<?php echo esc_url($simba_tfa->get_premium_version_url()); ?>"><?php esc_html_e("If you want to say 'thank you' or help this plugin's development, or get extra features, then please take a look at the premium version of this plugin.", 'all-in-one-wp-security-and-firewall'); ?></a> <?php esc_html_e('It comes with these extra features:', 'all-in-one-wp-security-and-firewall');?><br>
		</p>
		<p>
			<ul style="list-style: disc inside;">
				<li><strong><?php esc_html_e('Emergency codes', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('provide your users with one-time codes to use in case they lose their device.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Make TFA compulsory', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('require your users to set up TFA to be able to log in, after an optional grace period.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Trusted devices', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('allow privileged (or all) users to mark a device as trusted and thereby only needing to supply a TFA code upon login every so-many days (e.g. every 30 days) instead of on each login.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Manage all users centrally', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('enable, disable or see TFA codes for all your users from one central location.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('More shortcodes', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('flexible shortcodes allowing you to design your front-end settings page for your users exactly as you wish.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('More WooCommerce features', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('automatically add TFA settings in the WooCommerce account settings, and WooCommerce login form bot protection.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Elementor support', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('adds support for Elementor login forms.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Any-form support', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('adds support for any login form from any plugin via appending your TFA code onto the end of your password.', 'all-in-one-wp-security-and-firewall');?></li>
				<li><strong><?php esc_html_e('Personal support', 'all-in-one-wp-security-and-firewall');?></strong> - <?php esc_html_e('access to our personal support desk for 12 months.', 'all-in-one-wp-security-and-firewall');?></li>
			</ul>
		</p>
		<hr>
		<?php } ?>
	</div>

	<h2><?php esc_html_e('Translations', 'all-in-one-wp-security-and-firewall'); ?></h2>
	<p>
		<?php /* translators: %s: Plugin translation URL. */ ?>
		<?php echo sprintf(esc_html__("If you want to translate this plugin, please go to %s", 'all-in-one-wp-security-and-firewall'), '<a href="' . esc_url($simba_tfa->get_plugin_translate_url()) . '">' . esc_html__('the wordpress.org translation website.', 'all-in-one-wp-security-and-firewall').'</a>') . ' ' . esc_html__("Don't send us the translation file directly - plugin authors do not have access to the wordpress.org translation system (local language teams do).", 'all-in-one-wp-security-and-firewall'); ?>
		<br>
	</p>

</div>
</div>
