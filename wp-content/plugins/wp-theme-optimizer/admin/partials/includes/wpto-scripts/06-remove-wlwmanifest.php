<!-- Remove wlwmanifest.xml -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wlwmanifest.xml', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wlwmanifest">
		<h3><?php esc_attr_e('Remove wlwmanifest.xml', $this->plugin_name);?></h3>
		<p>If you are not using Windows Live Writer Manifest Link then disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wlwmanifest" name="<?php echo $this->plugin_name;?>[remove_wlwmanifest]" value="1" <?php checked($remove_wlwmanifest, 1);?>/>
</div>
</div>