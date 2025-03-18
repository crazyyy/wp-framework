<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<?php if (0 < count($tabs)) : ?>

<h2 id="wp-optimize-nav-tab-wrapper__<?php echo esc_attr($page); ?>" class="nav-tab-wrapper">

	<a id="wp-optimize-nav-tab-menu" href="#" class="nav-tab" role="toggle-menu">
		<span><?php esc_html_e('Menu', 'wp-optimize'); ?></span>
	</a>

<?php
	foreach ($tabs as $tab_id => $tab) {
		$tab_icon = '';
		if (is_array($tab)) {
			$tab_title = $tab['title'];
			$tab_icon = isset($tab['icon']) ? $tab['icon'] : '';
		} else {
			$tab_title = $tab;
		}
	?>
	<a id="wp-optimize-nav-tab-<?php echo esc_attr($page.'-'.$tab_id); ?>" data-tab="<?php echo esc_attr($tab_id); ?>" data-page="<?php echo esc_attr($page); ?>" href="<?php echo esc_url($options->admin_page_url($page) . '&amp;tab=wp_optimize_' . $tab_id); ?>" class="nav-tab <?php if ($active_tab == $tab_id) echo 'nav-tab-active'; ?>">
		<?php if ($tab_icon) : ?>
			<span class="dashicons dashicons-<?php echo esc_attr($tab_icon); ?>"></span>
		<?php endif; ?>
		<span><?php echo wp_kses_post($tab_title); ?></span>
	</a>

	<?php } ?>

	<span class="wpo-feedback">
		<a href="#" class="nav-tab">
			<span class="dashicons dashicons-admin-comments"></span>
			<span><?php esc_html_e('Feedback', 'wp-optimize'); ?></span>
		</a>
		<div class="wpo-feedback-box">
			<a href="<?php echo esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/feature-request/?utm_source=wp-optimize&utm_medium=quick_feedback&utm_campaign=feature_request')); ?>" target="_blank"><?php esc_html_e('I have an idea to improve WP-Optimize', 'wp-optimize'); ?></a>
			<?php if ($wpo_is_premium) : ?>
				<a href="<?php echo esc_url(WP_Optimize()->maybe_add_affiliate_params('https://getwpo.com/premium-support/?utm_source=wp-optimize&utm_medium=quick_feedback&utm_campaign=help_or_bug_report')); ?>" target="_blank"><?php esc_html_e('I need help / something is not working', 'wp-optimize'); ?></a>
			<?php else : ?>
				<?php $wp_optimize->wp_optimize_url('https://wordpress.org/support/plugin/wp-optimize/', __('I need help / something is not working', 'wp-optimize')); ?>
			<?php endif; ?>
		</div>
	</span>
</h2>

<?php endif;
