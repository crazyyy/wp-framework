<?php

	if (!defined('WPO_VERSION')) die('No direct access allowed');

	$retention_enabled = $options->get_option('retention-enabled', 'false');
	$retention_period = $options->get_option('retention-period', '2');
	$admin_page_url = $options->admin_page_url();

	$revisions_retention_enabled = $options->get_option('revisions-retention-enabled', 'false');
	$revisions_retention_count = $options->get_option('revisions-retention-count', '2');

?>

<h3 class="wpo-first-child"><?php esc_html_e('Status', 'wp-optimize'); ?></h3>

<div class="wpo-fieldgroup" id="wp_optimize_status_box">
	<p>
	<?php
	$lastopt = $options->get_option('last-optimized', 'Never');
	if ('Never' !== $lastopt) {
		// check if last optimized value is integer.
		if (is_numeric($lastopt)) {
			$lastopt = date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $lastopt + ( get_option('gmt_offset') * HOUR_IN_SECONDS ));
		}
		printf(esc_html__('Last scheduled optimization was at %s', 'wp-optimize'), '<span style="color: #004600; font-weight:bold;">' . esc_html($lastopt) . '</span>');
	} else {
		echo esc_html__('There was no scheduled optimization', 'wp-optimize');
	}
	?>
		<br>

	<?php

	$scheduled_optimizations_enabled = false;

	if (WP_Optimize::is_premium()) {
		$scheduled_optimizations = WP_Optimize_Premium()->get_scheduled_optimizations();

		if (!empty($scheduled_optimizations)) {
			foreach ($scheduled_optimizations as $optimization) {
				if (isset($optimization['status']) && 1 == $optimization['status']) {
					$scheduled_optimizations_enabled = true;
					break;
				}
			}
		}
	} else {
		$scheduled_optimizations_enabled = $options->get_option('schedule', 'false') == 'true';
	}

	if ($scheduled_optimizations_enabled) {
		printf(
			esc_html__('%sScheduled cleaning %senabled%s%s', 'wp-optimize'),
			'<strong>',
			'<span style="color: #009B24;">',
			'</span>',
			'</strong> '
		);
		
		$timestamp = apply_filters('wpo_cron_next_event', wp_next_scheduled('wpo_cron_event2'));
		
		if ($timestamp) {
			
			$timestamp = $timestamp + 60 * 60 * get_option('gmt_offset');
			
			$wp_optimize->cron_activate();

			$date = new DateTime("@".$timestamp);
			esc_html_e('Next schedule:', 'wp-optimize');
			echo ' ';
			echo '<span style="font-color: #004600">';
			echo esc_html(gmdate(get_option('date_format') . ' ' . get_option('time_format'), $timestamp));
			echo '</span>';
			echo ' - <a id="wp_optimize_status_box_refresh" href="'.esc_url($admin_page_url).'">'.esc_html__('Refresh', 'wp-optimize').'</a>';
		}
	} else {
		printf(
			esc_html__('%sScheduled cleaning disabled%s', 'wp-optimize'),
			'<strong>',
			'</strong>'
		);
	}
	echo '<br>';

	if ('true' == $retention_enabled) {
		echo '<strong><span style="font-color: #0000FF;">';
		printf(esc_html__('Keeping last %s weeks data', 'wp-optimize'), esc_html($retention_period));
		echo '</span></strong>';
	} else {
		echo '<strong>'.esc_html__('Not keeping recent data', 'wp-optimize').'</strong>';
	}
	
	echo '<br>';

	if ('true' == $revisions_retention_enabled) {
		echo '<strong><span style="font-color: #0000FF;">';
		printf(esc_html__('Keeping last %s revisions', 'wp-optimize'), esc_html($revisions_retention_count));
		echo '</span></strong>';
	} else {
		echo '<strong>'.esc_html__('Not keeping any revisions', 'wp-optimize').'</strong>';
	}
	?>
	</p>

	<p>
	<?php
		$total_cleaned = $options->get_option('total-cleaned');
		$total_cleaned_num = floatval($total_cleaned);

		if ($total_cleaned_num > 0) {
			printf(
				esc_html__('%sTotal clean up overall: %s %s', 'wp-optimize'),
				'<h5>',
				'<span style="color: #004600;">' . esc_html($wp_optimize->format_size($total_cleaned)) . '</span>',
				'</h5>'
			);
		}
	?>
	</p>

	<?php
	$corrupted_tables_count = $options->get_option('corrupted-tables-count', 0);

	if ($corrupted_tables_count > 0) {
	?>
	<p>
		<span style="color: #E07575;"><?php echo esc_html(sprintf(_n('Your database has %s corrupted table.', 'Your database has %s corrupted tables.', $corrupted_tables_count, 'wp-optimize'), $corrupted_tables_count)); ?></span><br>
		<a href="<?php echo esc_url($admin_page_url); ?>&tab=wp_optimize_tables" onclick="jQuery('.wpo-pages-menu > a').first().trigger('click'); jQuery('#wp-optimize-nav-tab-wpo_database-tables').trigger('click'); return false;"><?php esc_html_e('Repair corrupted tables here.', 'wp-optimize'); ?></a>
	</p>
	<?php } ?>
</div>
