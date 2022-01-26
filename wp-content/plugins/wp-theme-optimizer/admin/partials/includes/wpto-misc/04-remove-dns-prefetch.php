<!-- Remove DNS Prefetch -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove DNS Prefetch', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_dns_prefetch">
		<h3><?php esc_attr_e('Remove DNS Prefetch', $this->plugin_name);?></h3>
		<p>Tidy up your front-end header by removing DNS prefetch.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_dns_prefetch" name="<?php echo $this->plugin_name;?>[remove_dns_prefetch]" value="1" <?php checked($remove_dns_prefetch, 1);?>/>
</div>
</div>