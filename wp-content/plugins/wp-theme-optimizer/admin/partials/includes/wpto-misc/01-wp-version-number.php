<!-- Remove WP Generator tag -->
	<div class="options-box">
		<legend class="screen-reader-text"><span><?php _e('Remove WP Generator tag', $this->plugin_name);?></span></legend>
		<label for="<?php echo $this->plugin_name;?>-wp_version_number">
			<h3><?php esc_attr_e('Remove WP Generator tag', $this->plugin_name);?></h3>
			<p>It can be considered a security risk to make your wordpress version visible and public you should hide it.</p>
		</label>
		<div class="options-checkbox">
		<input type="checkbox" id="<?php echo $this->plugin_name;?>-wp_version_number" name="<?php echo $this->plugin_name;?>[wp_version_number]" value="1" <?php checked($wp_version_number, 1);?>/>
	</div>
</div>