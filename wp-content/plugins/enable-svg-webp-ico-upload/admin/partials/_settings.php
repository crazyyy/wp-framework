<?php 
$settings_slug = esc_attr($this->get_settings());
$settings =  $this->get_option();
?>

<form action="options.php" method="post" class="options_form">
	<?php settings_errors( $settings_slug."_option_group" );?>
	<?php settings_fields( $settings_slug ."_option_group" );?>
	<div class="itc_bg itc_width_xs margin-t30">
		<table class="form-table itc_table">
		<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo $settings_slug;?>[svg]">
							<span><?php _e( 'Enable SVG Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo $settings_slug;?>[svg]" name="<?php echo $settings_slug;?>[svg]" value="1" <?php checked( 1, isset( $settings['svg'] ) && $settings['svg'] ===1); ?>/>
						<i></i>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo $settings_slug;?>[webp]">
							<span><?php _e( 'Enable WebP Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo $settings_slug;?>[webp]" name="<?php echo $settings_slug;?>[webp]" value="1" <?php checked( 1, isset( $settings['webp'] ) && $settings['webp'] ===1); ?>/>
						<i></i>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scop="row" class="menu_tbl_heading">
						<label for="<?php echo $settings_slug;?>[ico]">
							<span><?php _e( 'Enable ICO Upload' ); ?></span>
						</label>
				</th>
				<td>
					<label class="form-switch">
						<input class="checkbox" type="checkbox" id="<?php echo $settings_slug;?>[ico]" name="<?php echo $settings_slug;?>[ico]" value="1" <?php checked( 1, isset( $settings['ico'] ) && $settings['ico'] ===1); ?>/>
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
