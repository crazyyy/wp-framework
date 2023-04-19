<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="aio_blue_box">
	<?php
	echo '<p>' . __('This tab displays the list of all permanently blocked IP addresses.', 'all-in-one-wp-security-and-firewall') . '</p>' . '<p>' . __('NOTE: This feature does NOT use the .htaccess file to permanently block the IP addresses so it should be compatible with all web servers running WordPress.', 'all-in-one-wp-security-and-firewall') . '</p>';
	?>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Permanently blocked IP addresses', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
		// Fetch, prepare, sort, and filter our data...
		$blocked_ip_list->prepare_items();
		?>
		<form id="tables-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>"/>
			<?php
			$blocked_ip_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_permanent_block');
			if (isset($_REQUEST["tab"])) {
				echo '<input type="hidden" name="tab" value="' . esc_attr($_REQUEST["tab"]) . '" />';
			}
			?>
			<!-- Now we can render the completed list table -->
			<?php $blocked_ip_list->display(); ?>
		</form>
	</div>
</div>