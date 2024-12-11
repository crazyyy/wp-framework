<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<div class="health-check-body health-check-status-tab hide-if-no-js">
	<h1><?php echo esc_html__('Issues impacting your site performance', 'wp-optimize'); ?></h1>
	<div class="site-status-has-issues">
		<?php echo $alerts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Already escaped ?>
	</div>
</div>
