<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div class="inside">
	<div class="postbox">
		<h3 class="hndle"><label for="title"><?php _e('Debug log options', 'all-in-one-wp-security-and-firewall');?></label></h3>
		<div class="inside">
			<form action ="" method="POST">
				<?php wp_nonce_field('aiowpsec_clear_debug_logs'); ?>
				<input name="aiowpsec_clear_logs" type="submit" value="<?php _e('Clear logs', 'all-in-one-wp-security-and-firewall'); ?>" class="button-primary">
			</form>
		</div>
	</div>
</div>
<div class="postbox">
	<h3 class="hndle"><label for="title"><?php _e('Debug logs', 'all-in-one-wp-security-and-firewall');?></label></h3>
	<div class="inside">
		<?php
			$debug_log_list->prepare_items();
			$debug_log_list->display();
		?>
	</div>
</div>