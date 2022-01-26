<!-- remove css and js query string versions -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove CSS and JS files query strings', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-css_js_versions">
		<h3><?php esc_attr_e('Remove CSS and JS versions', $this->plugin_name);?></h3>
		<p>Resources with a “?” or “&amp;” in the URL can not always be cached correctly. Removing these query strings can improve the performance of your WordPress site.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-css_js_versions" name="<?php echo $this->plugin_name;?>[css_js_versions]" value="1" <?php checked($css_js_versions, 1);?>/>
</div>
</div>