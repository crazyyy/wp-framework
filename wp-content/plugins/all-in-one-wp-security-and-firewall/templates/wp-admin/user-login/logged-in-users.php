<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Refresh logged in user data', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<form action="" method="POST">
			<?php wp_nonce_field('aiowpsec-logged-in-users-nonce'); ?>
			<input type="submit" name="aiowps_refresh_logged_in_user_list" value="<?php _e('Refresh data', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary" />
		</form>
	</div>
</div>
<div class="aio_blue_box">
	<?php
	echo '<p>'.__('This tab displays all users who are currently logged into your site.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('If you suspect there is a user or users who are logged in which should not be, you can block them by inspecting the IP addresses from the data below and adding them to your blacklist.', 'all-in-one-wp-security-and-firewall').'
		<br />'.__('You can also instantly log them out by pressing on the "Force logout" link when you hover over the row in the user id column.', 'all-in-one-wp-security-and-firewall').'
	</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Currently logged in users', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			// Fetch, prepare, sort, and filter our data...
			$user_list->prepare_items();
			// echo "put table of locked entries here";
		?>
		<form id="tables-filter" method="get">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($page); ?>" />
			<input type="hidden" name="tab" value="<?php echo esc_attr($tab); ?>" />
			<!-- Now we can render the completed list table -->
			<?php $user_list->display(); ?>
		</form>
	</div>
</div>