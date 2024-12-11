<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<?php

$info = array(
	'wp-rest-api' => array(
		'title' => __('WP REST API', 'all-in-one-wp-security-and-firewall'),
		'uri' => 'aiowpsec_firewall&tab=php-rules&subtab=wp-rest-api'
	)

);

if (empty($info)) return;
?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php echo $info[$key]['title']; ?></label></h3>
	<div class="inside">
		<?php
			$new_location_link = '<a href="admin.php?page='.$info[$key]['uri'].'">' . __('here', 'all-in-one-wp-security-and-firewall') . '</a>';
			echo '<div class="aio_orange_box"><p>';
			echo sprintf(__('The %s feature is now located %s.', 'all-in-one-wp-security-and-firewall'), $info[$key]['title'], $new_location_link) . ' ' . __('This page will be removed in a future release.', 'all-in-one-wp-security-and-firewall');
			echo '</p></div>';
		?>
	</div>
</div>
