<?php if (!defined('ABSPATH')) die('No direct access.');

$aio_wp_security->include_template('wp-admin/user-security/partials/wp-username.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr, 'user_accounts' => $user_accounts, 'AIOWPSecurity_User_Security_Menu' => $AIOWPSecurity_User_Security_Menu));

$aio_wp_security->include_template('wp-admin/user-security/partials/display-name.php', false, array('aiowps_feature_mgr' => $aiowps_feature_mgr));
?>
<form action="" id="aios-user-accounts-settings-form">
	<?php
		$aio_wp_security->include_template('wp-admin/user-security/partials/user-enumeration.php');

		$aio_wp_security->include_template('wp-admin/user-security/partials/enforce-strong-password.php');
	?>
	<div class="submit">
		<input type="submit" class="button-primary" name="aiowpsec_save_user_account_settings" value="<?php esc_html_e('Save settings', 'all-in-one-wp-security-and-firewall'); ?>">
	</div>
</form>
