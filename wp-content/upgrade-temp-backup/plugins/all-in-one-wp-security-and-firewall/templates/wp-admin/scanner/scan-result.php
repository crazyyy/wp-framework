<?php if (!defined('ABSPATH')) die('No direct access.'); ?>
<div>
	<h3 class="hndle"><label for="title"><?php esc_html_e('Latest file change scan results', 'all-in-one-wp-security-and-firewall'); ?></label></h3>
	<div class="inside">
		<?php
			$last_scan_results = $fcd_data['last_scan_result'];
			$file_change_types = array(
				'files_added' => esc_html__('The following files were added to your website.', 'all-in-one-wp-security-and-firewall'),
				'files_removed' => esc_html__('The following files were removed from your website.', 'all-in-one-wp-security-and-firewall'),
				'files_changed' => esc_html__('The following files were changed on your website.', 'all-in-one-wp-security-and-firewall')
			);

			foreach ($file_change_types as $type => $description) {
				if (empty($last_scan_results[$type])) continue;
				echo '<div class="aio_info_with_icon aio_spacer_10_tb">' . esc_html($description) . '</div>';
				$output = '<div class="aiowps_table_container">';
				$output .= '<table class="widefat aiowps_scan_result_table">';
				$output .= '<thead class="aiowps_scan_result_table_header">';
				$output .= '<tr>';
				$output .= '<th>' . esc_html__('File', 'all-in-one-wp-security-and-firewall') . '</th>';
				$output .= '<th>' . esc_html__('File size', 'all-in-one-wp-security-and-firewall') . '</th>';
				$output .= '<th>' . esc_html__('File modified', 'all-in-one-wp-security-and-firewall') . '</th>';
				$output .= '</tr>';
				$output .= '</thead>';
				foreach ($last_scan_results[$type] as $key => $value) {
					$output .= '<tr>';
					$output .= '<td>' . esc_html($key) . '</td>';
					$file_size = AIOWPSecurity_Utility::convert_numeric_size_to_text($value['filesize']);
					$output .= '<td>' . esc_html($file_size) . '</td>';
					$last_modified = AIOWPSecurity_Utility::convert_timestamp($value['last_modified']);
					$output .= '<td>' . esc_html($last_modified) . '</td>';
					$output .= '</tr>';
				}
				$output .= '</table>';
				$output .= '</div>';
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Variables escaped early inside HTML.
				echo $output;
				echo '<div class="aio_spacer_15"></div>';
			}
		?>
	</div>
</div>
