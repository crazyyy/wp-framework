<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Audit logs', 'all-in-one-wp-security-and-firewall');?></label></h3>
	<div class="inside">
		<?php $audit_log_list->prepare_items(); ?>
		<form id="tables-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']); ?>" />
			<?php
				if (isset($_REQUEST["tab"])) {
					echo '<input type="hidden" name="tab" value="'.esc_attr($_REQUEST["tab"]).'" />';
				}
				$audit_log_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_audit_events');
				$audit_log_list->display();
			?>
		</form>
	</div>
</div>