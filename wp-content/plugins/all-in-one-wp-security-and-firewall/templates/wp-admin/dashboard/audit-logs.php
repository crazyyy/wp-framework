<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php esc_html_e('Audit logs', 'all-in-one-wp-security-and-firewall');?></label></h3>
	<div class="inside" id="audit-log-list-table">
		<?php $audit_log_list->prepare_items(); ?>
		<form id="tables-filter" method="post">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
			<input type="hidden" name="page" value="<?php echo esc_attr($page); ?>" />
			<?php
				if (!empty($tab)) {
					echo '<input type="hidden" name="tab" value="'.esc_attr($tab).'" />';
				}
				$audit_log_list->search_box(__('Search', 'all-in-one-wp-security-and-firewall'), 'search_audit_events');
				$audit_log_list->display();
			?>
		</form>
	</div>
</div>