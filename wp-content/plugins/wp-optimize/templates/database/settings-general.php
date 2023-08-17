<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<h3 class="wpo-first-child"><?php esc_html_e('General settings', 'wp-optimize'); ?></h3>
<div class="wpo-fieldgroup">
	<p>
		<?php esc_html_e('Whether manually or on a schedule, these settings apply whenever a relevant optimization is run.', 'wp-optimize'); ?>
	</p>
	<p>
		<input name="enable-retention" id="enable-retention" type="checkbox" value ="true" <?php echo ($options->get_option('retention-enabled') == 'true') ? 'checked="checked"' : ''; ?>>
		<?php
		$retention_period = max((int) $options->get_option('retention-period', '2'), 1);

		echo '<label for="enable-retention">';
		printf(
			esc_html__('Keep last %s weeks data', 'wp-optimize'),
			'</label><input id="retention-period" name="retention-period" type="number" step="1" min="2" max="99" value="'.esc_attr($retention_period).'"><label for="enable-retention">'
		);
		echo '</label>';
		?>
		<br>
		<small><?php echo esc_html__('This option will, where relevant, retain data from the chosen period, and remove any garbage data before that period.', 'wp-optimize').' '.esc_html__('If the option is not active, then all garbage data will be removed.', 'wp-optimize').' '.esc_html__('This will also affect Auto Clean-up process', 'wp-optimize'); ?></small>
	</p>
	<p>
		<input name="enable-revisions-retention" id="enable-revisions-retention" type="checkbox" value ="true" <?php echo ('true' == $options->get_option('revisions-retention-enabled')) ? 'checked="checked"' : ''; ?>>
		<?php
		$revisions_retention_count = (int) $options->get_option('revisions-retention-count', '2');

		echo '<label for="enable-revisions-retention">';
		printf(
			esc_html__('Always keep %s post revisions', 'wp-optimize'),
			'</label><input id="revisions-retention-count" name="revisions-retention-count" type="number" step="1" min="2" max="99" value="'.esc_attr($revisions_retention_count).'"><label for="revisions-retention-count">'
		);
		echo '</label>';
		?>
		<br>
		<small><?php echo esc_html__('This option will retain specified number of post revisions, and remove other revisions.', 'wp-optimize').' '.esc_html__('If the option is not active, then all garbage data will be removed.', 'wp-optimize').' '.esc_html__('This will also affect Auto Clean-up process', 'wp-optimize'); ?></small>
	</p>
	<?php WP_Optimize()->include_template('take-a-backup.php', false, array('label' => __('Take a backup with UpdraftPlus before running scheduled optimizations', 'wp-optimize'), 'checkbox_name' => 'enable-auto-backup-scheduled')); ?>
</div>
