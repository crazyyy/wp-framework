<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
	echo '<p>' . esc_html__('This tab displays the list of all permanently blocked IP addresses.', 'all-in-one-wp-security-and-firewall') . '</p>' . '<p>' . esc_html__('NOTE: This feature does NOT use the .htaccess file to permanently block the IP addresses so it should be compatible with all web servers running WordPress.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Permanently blocked IP addresses', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside" id="permanent-ip-list-table">
		<?php
		// Fetch, prepare, sort, and filter our data...
		$blocked_ip_list->prepare_items();
		?>
		<form id="tables-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($page); ?>"/>
			<?php
			$blocked_ip_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_permanent_block');
			if (!empty($tab)) {
				echo '<input type="hidden" name="tab" value="' . esc_attr($tab) . '" />';
			}
			?>
			<!-- Now we can render the completed list table -->
			<?php $blocked_ip_list->display(); ?>
		</form>
	</div>
</div>