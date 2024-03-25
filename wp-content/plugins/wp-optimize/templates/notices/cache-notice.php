<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="wpo_info below-h2">

	<?php if ($message) : ?>
		<h3><?php esc_html_e('Page caching issue.', 'wp-optimize'); ?></h3>
		<p><?php echo esc_html($message); ?></p>
	<?php endif; ?>

</div>
