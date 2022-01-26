<!-- Remove jQuery Migrate -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove jQuery Migrate', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_jquery_migrate">
		<h3><?php esc_attr_e('Remove jQuery Migrate', $this->plugin_name);?></h3>
		<p>The jQuery migrate file was introduced to load any deprecated APIs and functions that were removed in jQuery 1.9. If you do not need jQuery migrate, disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_jquery_migrate" name="<?php echo $this->plugin_name;?>[remove_jquery_migrate]" value="1" <?php checked($remove_jquery_migrate, 1);?>/>
</div>
</div>