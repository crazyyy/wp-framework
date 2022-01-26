<!-- Remove oEmbed -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove OEmbed Links', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_oembed">
		<h3><?php esc_attr_e('Remove OEmbed Links', $this->plugin_name);?></h3>
		<p>OEmbed provides an easy way to embed content from one site to another. If you do not need it, disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_oembed" name="<?php echo $this->plugin_name;?>[remove_oembed]" value="1" <?php checked($remove_oembed, 1);?>/>
</div>
</div>