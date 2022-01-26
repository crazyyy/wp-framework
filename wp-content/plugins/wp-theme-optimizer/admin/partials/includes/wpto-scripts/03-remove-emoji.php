<!-- Remove emoji-release -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove emoji-release.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_emoji_release">
		<h3><?php esc_attr_e('Remove emoji-release.js', $this->plugin_name);?></h3>
		<p>Are you using Emoji's on your website? If not, you can disable them here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_emoji_release" name="<?php echo $this->plugin_name;?>[remove_emoji_release]" value="1" <?php checked($remove_emoji_release, 1);?>/>
</div>
</div>