<!-- Remove RSD Link -->
<div class="options-box remove_rsd_link">
	<legend class="screen-reader-text"><span><?php _e('Remove RSD Link', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_rsd_link">
		<h3><?php esc_attr_e('Remove RSD Link', $this->plugin_name);?></h3>
		<p>Are you editing your WordPress blog using your browser? Then you are not using a blog client and this link can probably be removed by disabling it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_rsd_link" name="<?php echo $this->plugin_name;?>[remove_rsd_link]" value="1" <?php checked($remove_rsd_link, 1);?>/>
</div>
</div>