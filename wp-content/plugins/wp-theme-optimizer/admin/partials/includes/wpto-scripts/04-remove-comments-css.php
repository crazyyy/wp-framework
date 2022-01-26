<!-- Remove recent comments CSS -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove WordPress Recent Comments inline styling CSS', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_recent_comments_css">
		<h3><?php esc_attr_e('Remove WordPress Recent Comments inline styling CSS', $this->plugin_name);?></h3>
		<p>WordPress automatically adds an inline CSS style for recent comments. If you do not need this, remove it here..</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_recent_comments_css" name="<?php echo $this->plugin_name;?>[remove_recent_comments_css]" value="1" <?php checked($remove_recent_comments_css, 1);?>/>
</div>
</div>