<?php if (is_plugin_active('wordpress-seo/wp-seo.php')) { ?>
<!-- Remove Yoast SEO comments -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove Yoast Information', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_yoast_information">
		<h3><?php esc_attr_e('Remove Yoast Information', $this->plugin_name);?></h3>
		<p>Remove the comments and version number left by Yoast SEO in your front-end HTMl.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_yoast_information" name="<?php echo $this->plugin_name;?>[remove_yoast_information]" value="1" <?php checked($remove_yoast_information, 1);?>/>
</div>
</div>
<?php } ?>