<!-- Remove next/previous links -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove Next/Previous post links', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wp_post_links">
		<h3><?php esc_attr_e('Remove Next/Previous post links', $this->plugin_name);?></h3>
		<p>If you do not need them, you can remove next and previous post links from the themes header by disabling them here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wp_post_links" name="<?php echo $this->plugin_name;?>[remove_wp_post_links]" value="1" <?php checked($remove_wp_post_links, 1);?>/>
</div>
</div>