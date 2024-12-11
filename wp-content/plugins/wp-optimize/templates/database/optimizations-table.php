<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>

<table id="optimizations_list" class="wp-list-table widefat striped">
	<thead>
		<tr>
			<td class="check-column"><input id="select_all_optimizations" type="checkbox"></td>
			<th><?php esc_html_e('Optimization', 'wp-optimize'); ?></th>
			<th></th>
	<!--		<th></th>-->
		</tr>
	</thead>
	<tbody>
	<?php
	$optimizations = $optimizer->sort_optimizations($optimizer->get_optimizations());

	foreach ($optimizations as $id => $optimization) {
		if ('optimizetables' == $id && false === $does_server_allows_table_optimization) continue;
		// If we don't want to show optimization on the first tab.
		if (false === $optimization->display_in_optimizations_list()) continue;
		// This is an array, with attributes dom_id, activated, settings_label, info; all values are strings.
		$html = $optimization->get_settings_html();
		$disable_optimization_button = false;

		// Check if the DOM is optimize-db to generate a list of tables.
		if ('optimize-db' == $html['dom_id']) {
			$table_list = $optimizer->get_table_information();

			// Make sure that optimization_table_inno_db is set.
			if ($table_list['inno_db_tables'] > 0 && 0 == $table_list['is_optimizable'] && 0 == $table_list['non_inno_db_tables']) {
				$disable_optimization_button = true;
				$html['activated'] = '';
			}
		}

		$sensitive_items = array(
			'clean-transient',
			'clean-pingbacks',
			'clean-trackbacks',
			'clean-postmeta',
			'clean-orphandata',
			'clean-commentmeta',
			'clean-usermeta',
		);

		?>
		<tr class="wp-optimize-settings wp-optimize-settings-<?php echo esc_attr($html['dom_id']); ?><?php echo (in_array($html['dom_id'], $sensitive_items)) ? ' wp-optimize-setting-is-sensitive' : ''; ?>" id="wp-optimize-settings-<?php echo esc_attr($html['dom_id']); ?>" data-optimization_id="<?php echo esc_attr($id); ?>" data-optimization_run_sort_order="<?php echo esc_attr($optimization->get_run_sort_order()); ?>" >
		<?php
		if (!empty($html['settings_label'])) {
			?>

			<th class="wp-optimize-settings-optimization-checkbox check-column">
				<input name="<?php echo esc_attr($html['dom_id']); ?>" id="optimization_checkbox_<?php echo esc_attr($id); ?>" class="optimization_checkbox" type="checkbox" value="true" <?php echo ($html['activated']) ? 'checked="checked"' : ''; ?> <?php echo $disable_optimization_button ? 'data-disabled="1" disabled' : ''; ?> >

				<img id="optimization_spinner_<?php echo esc_attr($id); ?>" class="optimization_spinner display-none" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>" alt="...">
			</th>


			<td>
				<label for="optimization_checkbox_<?php echo esc_attr($id); ?>"><?php echo esc_html($html['settings_label']); ?></label>
				<div class="wp-optimize-settings-optimization-info" id="optimization_info_<?php echo esc_attr($id); ?>">
				<?php echo join('<br>', $html['info']); ?>
				</div>
			</td>

			<td class="wp-optimize-settings-optimization-run">
				<button id="optimization_button_<?php echo esc_attr($id); ?>_big" class="button button-secondary wp-optimize-settings-optimization-run-button show_on_default_sizes optimization_button_<?php echo esc_attr($id); ?>" type="button" <?php echo $disable_optimization_button ? 'data-disabled="1" disabled' : ''; ?> ><?php esc_html_e('Run optimization', 'wp-optimize'); ?></button>

				<button id="optimization_button_<?php echo esc_attr($id); ?>_small" class="button button-secondary wp-optimize-settings-optimization-run-button show_on_mobile_sizes optimization_button_<?php echo esc_attr($id); ?>" type="button" <?php echo $disable_optimization_button ? 'data-disabled="1" disabled' : ''; ?> ><?php esc_html_e('Go', 'wp-optimize'); ?></button>
			</td>

		<?php } ?>
		</tr>
	<?php } ?>
	</tbody>
</table>

<script type="text/html" id="tmpl-wpo-postmeta">
	<h3><span class="dashicons dashicons-warning"></span> <?php esc_html_e('Are you sure you want to clean post metadata?', 'wp-optimize'); ?></h3>
	<div class="notice notice-warning">
		<p><?php echo esc_html__('WARNING', 'wp-optimize') . ' - ' . esc_html__('Only clean post metadata if you are sure of what you are doing, and after taking a backup with UpdraftPlus plugin', 'wp-optimize'); ?></p>
	</div>
	<h4><?php echo esc_html__('You are about to remove posts metadata.', 'wp-optimize'); ?></h4>
	<p>
		<input type="checkbox" id="confirm_post_meta_deletion"> <label for="confirm_post_meta_deletion"><?php esc_html_e('I have taken a backup and I want to continue with this optimization.', 'wp-optimize'); ?></label>
	</p>
	<p>
		<input type="checkbox" id="ignores_post_meta_deletion_warning"> <label for="ignores_post_meta_deletion_warning"><?php esc_html_e('Do not show this warning again.', 'wp-optimize'); ?></label>
	</p>
	<button type="button" id="confirm-post-meta-delete-action" class="button button-primary delete-post-meta" disabled><?php esc_html_e('Remove posts metadata', 'wp-optimize'); ?></button>
	<button type="button" class="button cancel wpo-modal--close"><?php esc_html_e('Cancel', 'wp-optimize'); ?></button>
</script>

<script type="text/html" id="tmpl-wpo-orphandata">
	<h3><span class="dashicons dashicons-warning"></span> <?php esc_html_e('Are you sure you want to clean orphaned relationship data?', 'wp-optimize'); ?></h3>
	<div class="notice notice-warning">
		<p><?php echo esc_html__('WARNING', 'wp-optimize') . ' - ' . esc_html__('Only clean orphaned relationship data if you are sure of what you are doing, and after taking a backup with UpdraftPlus plugin', 'wp-optimize'); ?></p>
	</div>
	<h4><?php echo esc_html__('You are about to remove orphaned relationship data.', 'wp-optimize'); ?></h4>
	<p>
		<input type="checkbox" id="confirm_orphaned_relationship_data_deletion"> <label for="confirm_orphaned_relationship_data_deletion"><?php esc_html_e('I want to continue with this optimization.', 'wp-optimize'); ?></label>
	</p>
	<p>
		<input type="checkbox" id="ignores_orphaned_relationship_data_deletion_warning"> <label for="ignores_orphaned_relationship_data_deletion_warning"><?php esc_html_e('Do not show this warning again.', 'wp-optimize'); ?></label>
	</p>
	<button type="button" id="confirm-orphaned-relationship-data-delete-action" class="button button-primary delete-orphaned-relationship-data" disabled><?php esc_html_e('Remove orphaned relationship data', 'wp-optimize'); ?></button>
	<button type="button" class="button cancel wpo-modal--close"><?php esc_html_e('Cancel', 'wp-optimize'); ?></button>
</script>

<script type="text/html" id="tmpl-wpo-grouped-warnings">
	<h3><span class="dashicons dashicons-warning"></span> <?php esc_html_e('Please review these actions that are about to run', 'wp-optimize'); ?></h3>
	<div class="notice notice-warning">
		[[warning_messages]]
	</div>
	<h4><?php echo esc_html__('You are about to remove sensible data.', 'wp-optimize'); ?></h4>
	<p>
		<input type="checkbox" id="confirm_grouped_warnings_data_deletion"> <label for="confirm_grouped_warnings_data_deletion"><?php esc_html_e('I want to continue with these optimizations.', 'wp-optimize'); ?></label>
	</p>
	<button type="button" id="confirm-grouped-warnings-data-delete-action" class="button button-primary delete-grouped-warnings-data" disabled><?php esc_html_e('Apply optimization', 'wp-optimize'); ?></button>
	<button type="button" class="button cancel wpo-modal--close"><?php esc_html_e('Cancel', 'wp-optimize'); ?></button>
</script>