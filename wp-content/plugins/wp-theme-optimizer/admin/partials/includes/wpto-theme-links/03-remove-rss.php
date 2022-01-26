<!-- Remove RSS Feeds -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove RSS feeds', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_rss_feed">
		<h3><?php esc_attr_e('Remove RSS feeds', $this->plugin_name);?></h3>
		<p>Are you using RSS feeds? If not, you can turn them off here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_rss_feed" name="<?php echo $this->plugin_name;?>[remove_rss_feed]" value="1" <?php checked($remove_rss_feed, 1);?>/>
</div>
</div>