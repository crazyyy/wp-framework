<?php
if (!defined('ABSPATH')) {
	exit;//Exit if accessed directly
}

if (class_exists('AIOWPSecurity_Utility_UI')) return;

class AIOWPSecurity_Utility_UI {


	/**
	 * This function will output the checkbox and label HTML
	 *
	 * @param string $label      - The label text to display next to the checkbox.
	 * @param string $option     - The name of the setting option
	 * @param bool   $is_active  - Determines if the checkbox should be checked or not
	 * @param array  $attributes - Other attributes like disabled
	 * @return void
	 */
	public static function setting_checkbox($label, $option, $is_active, $attributes = '') {
		$other_attributes = '';
		if (is_array($attributes) && !empty($attributes)) {
			foreach ($attributes as $attribute => $value) {
				$other_attributes .= $attribute . '="' . esc_attr($value) . '" ';
			}
		}
		?>
			<label class="aiowps_switch">
                <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $other_attributes is already escaped ?>
				<input type="checkbox" id="<?php echo esc_attr($option);?>" name="<?php echo esc_attr($option);?>" <?php if ($is_active) echo ' checked="checked"'; ?> <?php echo $other_attributes;?> value="1">
				<span class="slider round"></span>
			</label>
			<label for="<?php echo esc_attr($option);?>" class="description"><?php echo esc_html($label); ?></label>
		<?php
	}

	/**
	 * Render a textarea for IP input in a settings form.
	 *
	 * This method generates a table row with a label and a textarea for entering IP addresses or IP ranges,
	 * along with a description and an additional informational template.
	 *
	 * @param string $label       The label text for the textarea.
	 * @param string $name        The name and ID attribute value for the textarea element.
	 * @param string $value       The default value to populate in the textarea.
	 * @param string $description The description text displayed below the textarea.
	 *
	 * @return void
	 */
	public static function ip_input_textarea($label, $name, $value, $description) {
		global $aio_wp_security;
		?>
			<th scope="row"><label for="<?php echo esc_attr($name);?>"><?php echo esc_html($label); ?></label></th>
			<td>
				<textarea id="<?php echo esc_attr($name);?>" name="<?php echo esc_attr($name);?>" rows="5" cols="50"><?php echo esc_textarea($value); ?></textarea>
				<br>
				<span class="description"><?php echo esc_html($description); ?></span>
				<?php $aio_wp_security->include_template('info/ip-address-ip-range-info.php'); ?>
			</td>
		<?php
	}

	/**
	 * Format data into a table for the email message
	 *
	 * @param array $data Data to be formatted
	 *
	 * @return string Formatted data as a table
	 */
	public static function format_data_as_table($data) {
		$table_html = '<table class="aios-data-table">';

		// Check if an array is multidimensional
		$is_multi_dimensional = function($array) {
			if (!is_array($array)) {
				return false;
			}
			foreach ($array as $item) {
				if (is_array($item)) {
					return true;
				}
			}
			return false;
		};

		// Check if the input data is a multidimensional array
		if ($is_multi_dimensional($data)) {
			// Add table headers based on the keys of the first array element
			$table_html .= '<tr>';
			foreach (array_keys($data[0]) as $header) {
				$table_html .= '<th>' . esc_html($header) . '</th>';
			}
			$table_html .= '</tr>';

			// Recursively format the multidimensional array
			$table_html .= self::format_data_recursive($data);
		} else {
			// If the input data is not a multidimensional array, treat it as a single key-value pair
			$table_html .= self::format_data_recursive(array($data));
		}

		$table_html .= '</table>';

		return $table_html;
	}

	/**
	 * Recursively format data as a table
	 *
	 * @param array $data Data to be formatted
	 *
	 * @return string Formatted data as a table
	 */
	private static function format_data_recursive($data) {
		$html = '';
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				// If the value is an array, recursively format it
				$html .= self::format_data_recursive($value);
			} else {
				// If the value is not an array, format it as a table row
				$escaped_key = esc_html($key);
				$escaped_value = esc_html($value);
				$html .= '<tr><td><b>' . $escaped_key . '</b></td><td>' . $escaped_value . '</td></tr>';
			}
		}
		return $html;
	}
}
