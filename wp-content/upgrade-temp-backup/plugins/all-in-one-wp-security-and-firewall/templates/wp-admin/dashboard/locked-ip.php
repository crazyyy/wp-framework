<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
	$login_lockout_feature_url = '<a href="admin.php?page=' . esc_attr(AIOWPSEC_USER_SECURITY_MENU_SLUG) . '&tab=login-lockout" target="_blank">' . esc_html__('Login lockout', 'all-in-one-wp-security-and-firewall').'</a>';
	echo '<p>' . esc_html__('This tab displays the list of all IP addresses which are currently temporarily locked out.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Currently locked out IP addresses and ranges', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside" id="locked-ip-list-table">
		<?php
		// Fetch, prepare, sort, and filter our data...
		$locked_ip_list->prepare_items();
		// echo "put table of locked entries here";
		?>
		<form id="tables-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($page); ?>"/>
			<?php
			if (!empty($tab)) {
				echo '<input type="hidden" name="tab" value="' . esc_attr($tab) . '" />';
			}
			?>
			<!-- Now we can render the completed list table -->
			<?php $locked_ip_list->display(); ?>
		</form>
	</div>
</div>