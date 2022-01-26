<!-- Remove WP Json -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove WP JSON link', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wp_json">
		<h3><?php esc_attr_e('Remove WP JSON link', $this->plugin_name);?></h3>
		<p>WP JSON could potentially open your website to a new front of DDoS attacks. If you do not need it, disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wp_json" name="<?php echo $this->plugin_name;?>[remove_wp_json]" value="1" <?php checked($remove_wp_json, 1);?>/>
</div>
</div>