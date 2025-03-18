<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<h3><?php esc_html_e('Support and feedback', 'wp-optimize'); ?></h3>
<div class="wpo-fieldgroup">
	<?php WP_Optimize()->include_template('settings/system-status.php'); ?>
	<ul>
		<li><?php $wp_optimize->wp_optimize_url('https://getwpo.com/faqs/', __('Read our FAQ here', 'wp-optimize')); ?></li>
		<li><?php $wp_optimize->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', __('Support is available here.', 'wp-optimize')); ?></li>
		<li>
			<?php
				$message = esc_html__('If you like WP-Optimize,', 'wp-optimize');
				$message .= ' ';
				$message .= $wp_optimize->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/reviews/?rate=5#new-post', esc_html__('please give us a positive review, here.', 'wp-optimize'), '', '', true);
				$message .= ' ';
				$message .= esc_html__('Or, if you did not like it,', 'wp-optimize');
				$message .= ' ';
				$message .= $wp_optimize->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', esc_html__('please tell us why at this link.', 'wp-optimize'), '', '', true);
				echo $message; // phpcs:ignore WordPress.Security.EscapeOutput -- Output is already escaped
			?>
		</li>
	</ul>
</div>