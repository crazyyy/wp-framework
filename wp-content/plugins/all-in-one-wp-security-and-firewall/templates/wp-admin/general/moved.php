<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<?php

$info = array(
	'6g' => array(
		'title' => __('6G firewall rules', 'all-in-one-wp-security-and-firewall'),
		'uri' => 'aiowpsec_firewall&tab=php-rules&subtab=ng'
	),
	'internet-bots' => array(
		'title' => __('Internet bots', 'all-in-one-wp-security-and-firewall'),
		'uri' => 'aiowpsec_firewall&tab=php-rules&subtab=internet-bots'
	),
);

if (empty($info)) return;
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php echo esc_html($info[$key]['title']); ?></label></h3>
	<div class="inside">
		<?php
			$new_location_link = '<a href="admin.php?page=' . esc_html($info[$key]['uri']) . '">' . esc_html__('here', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_orange_box"><p>';
			/* translators: 1: Old location 2: New location */
			echo sprintf(esc_html__('The %1$s feature is now located %2$s.', 'all-in-one-wp-security-and-firewall'), esc_html($info[$key]['title']), $new_location_link) . ' ' . esc_html__('This page will be removed in a future release.', 'all-in-one-wp-security-and-firewall'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Link already escaped.
			echo '</p></div>';
		?>
	</div>
</div>
