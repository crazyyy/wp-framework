<?php if (!defined('WPO_VERSION')) die('No direct access allowed'); ?>
<div class="wpo_shade hidden">
	<div class="wpo_shade_inner">
			<span class="dashicons dashicons-update-alt wpo-rotate"></span>
		<h4><?php esc_html_e('Loading data...', 'wp-optimize'); ?></h4>
	</div>
</div>

<?php
// This next bit belongs somewhere else, I think.
?>
<?php if ($optimize_db) { ?>
	<p><?php esc_html_e('Optimized all the tables found in the database.', 'wp-optimize'); ?></p>
<?php } ?>
<?php

// used for output premium functionality
do_action('wpo_tables_list_before');

?>

<?php $wp_optimize->include_template('take-a-backup.php', false, array('label' => __('Take a backup with UpdraftPlus before any actions upon tables (recommended).', 'wp-optimize'), 'default_checkbox_value' => 'true', 'checkbox_name' => 'enable-auto-backup-1')); ?>

<p class="wpo-table-list-filter"><strong><?php echo esc_html__('Database name:', 'wp-optimize')." '".esc_html(DB_NAME)."'"; ?><a id="wp_optimize_table_list_refresh" href="#" class="wpo-refresh-button"><span class="dashicons dashicons-image-rotate"></span><?php esc_html_e('Refresh data', 'wp-optimize'); ?></a></strong> <input id="wpoptimize_table_list_filter" class="search" type="search" value="" placeholder="<?php esc_attr_e('Search for table', 'wp-optimize'); ?>" data-column="1"></p>

<?php
$optimizer = WP_Optimize()->get_optimizer();
$table_prefix = $optimizer->get_table_prefix();
if (!$table_prefix) {
?>
<p class="wpo-table-list-filter"><span style="color: #0073aa;"><span class="dashicons dashicons-info"></span> <?php echo esc_html__('Note:', 'wp-optimize').'</span> '.esc_html__('Your WordPress install does not use a database prefix, so WP-Optimize was not able to differentiate which tables belong to WordPress so all tables are listed below.', 'wp-optimize'); ?></p>
<?php
}
?>

<table id="wpoptimize_table_list" class="wp-list-table widefat striped tablesorter wp-list-table-mobile-labels">
	<thead>
		<tr>
			<th><?php esc_html_e('No.', 'wp-optimize'); ?></th>
			<th class="column-primary"><?php esc_html_e('Table', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Records', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Data Size', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Index Size', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Type', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Overhead', 'wp-optimize'); ?></th>
			<th><?php esc_html_e('Actions', 'wp-optimize'); ?></th>
		</tr>
	</thead>
	<?php
	if ($load_data) {
		WP_Optimize()->include_template('database/tables-body.php', false, array('optimize_db' => $optimize_db));
	} else {
	?>
		<tbody>
			<tr>
				<td></td>
				<td class="loading" align="center" colspan="6"><img class="wpo-ajax-template-loader" width="16" height="16" src="<?php echo esc_url(admin_url('images/spinner-2x.gif')); ?>"> <?php esc_html_e('Loading tables list...', 'wp-optimize'); ?></td>
				<td></td>
			</tr>
		</tbody>
	<?php } ?>
</table>


<div id="wpoptimize_table_list_tables_not_found"><?php esc_html_e('Tables not found.', 'wp-optimize'); ?></div>

<?php

WP_Optimize()->include_template('database/tables-list-after.php', false, array('optimize_db' => $optimize_db, 'load_data' => $load_data));
