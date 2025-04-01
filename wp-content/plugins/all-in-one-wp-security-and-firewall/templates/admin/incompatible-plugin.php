<?php if (!defined('ABSPATH')) die('Access denied.'); ?>

<div class="wrap">

	<div>
		<h1><?php esc_html_e('Two Factor Authentication', 'all-in-one-wp-security-and-firewall'); ?></h1>
	</div>

	<div class="error">
		<h3><?php esc_html_e('Two Factor Authentication currently disabled', 'all-in-one-wp-security-and-firewall');?></h3>
		<p>
			<?php /* translators: %s: Incompatible plugin name. */ ?>
			<?php printf(esc_html__('Two factor authentication in All In One WP Security is currently disabled because the incompatible plugin %s is active.', 'all-in-one-wp-security-and-firewall'), esc_html($incompatible_plugin)); ?>
		</p>
	</div>

	<?php /* translators: %s: Incompatible plugin name. */ ?>
	<div><?php printf(esc_html__('Two factor authentication in All In One WP Security is currently disabled because the incompatible plugin %s is active.', 'all-in-one-wp-security-and-firewall'), esc_html($incompatible_plugin)); ?></div>

</div>
