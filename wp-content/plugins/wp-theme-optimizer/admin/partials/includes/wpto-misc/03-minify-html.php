<!-- Minify HTML -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Minify HTML', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-html_minify">
		<h3><?php esc_attr_e('Minify HTML', $this->plugin_name);?></h3>
		<p>Improve your site performance by Minifying the HTMl.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-html_minify" name="<?php echo $this->plugin_name;?>[html_minify]" value="1" <?php checked($html_minify, 1);?>/>
</div>
</div>