<?php 
$settings_slug_sanitized = $this->get_settings();
$settings =  $this->get_option();
?>

<form action="options.php" method="post" class="options_form">
	<?php settings_errors( esc_attr($settings_slug_sanitized)."_option_group" );?>
	<?php settings_fields( esc_attr($settings_slug_sanitized) ."_option_group" );?>
	<div class="itc_bg itc_width_xs margin-t30">
		<table class="form-table itc_table">
		<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo esc_attr($settings_slug_sanitized);?>[svg]">
							<span><?php _e( 'Enable SVG Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo esc_attr($settings_slug_sanitized);?>[svg]" name="<?php echo esc_attr($settings_slug_sanitized);?>[svg]" value="1" <?php checked( 1, isset( $settings['svg'] ) && $settings['svg'] ===1); ?>/>
						<i></i>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo esc_attr($settings_slug_sanitized);?>[webp]">
							<span><?php _e( 'Enable WebP Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo esc_attr($settings_slug_sanitized);?>[webp]" name="<?php echo esc_attr($settings_slug_sanitized);?>[webp]" value="1" <?php checked( 1, isset( $settings['webp'] ) && $settings['webp'] ===1); ?>/>
						<i></i>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo esc_attr($settings_slug_sanitized);?>[ico]">
							<span><?php _e( 'Enable ICO Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo esc_attr($settings_slug_sanitized);?>[ico]" name="<?php echo esc_attr($settings_slug_sanitized);?>[ico]" value="1" <?php checked( 1, isset( $settings['ico'] ) && $settings['ico'] ===1); ?>/>
						<i></i>
					</label>
				</td>
			</tr>
		</table>
	</div>
	<?php 
	submit_button ( 'Save Changes', 'primary itc_btn_sm');
	?>
</form>
