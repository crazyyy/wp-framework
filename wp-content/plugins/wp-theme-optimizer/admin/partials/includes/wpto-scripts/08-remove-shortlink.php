<!-- Remove WP Shortlink -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove WP Shortlink', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wp_shortlink">
		<h3><?php esc_attr_e('Remove WP Shortlink', $this->plugin_name);?></h3>
		<p>The shortlink is a shortened version of a web page’s URL. If you do not need it, you can disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wp_shortlink" name="<?php echo $this->plugin_name;?>[remove_wp_shortlink]" value="1" <?php checked($remove_wp_shortlink, 1);?>/>
</div>
</div>