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
				<input type="checkbox" id="<?php echo esc_attr($option);?>" name="<?php echo esc_attr($option);?>" <?php if ($is_active) echo ' checked="checked"'; ?> <?php echo $other_attributes;?> value="1">
				<span class="slider round"></span>
			</label>
			<label for="<?php echo esc_attr($option);?>" class="description"><?php echo esc_html($label); ?></label>
		<?php
	}
}