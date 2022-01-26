<?php

/**
* @link              https://www.designsbytouch.co.uk
* @since             1.0.0
* @package           Wp_Theme_Optimiser
*/
?>

<div id="options" class="wrap metabox-holder columns-4 wpto-metaboxes ">
	<h1><?php esc_attr_e( 'Theme Options', $this->plugin_name ); ?></h1>
        <p><?php _e('Welcome to the WP Theme Optimizer plugin. Use this page to activate or deactivate various settings which can clean up your WordPress code, made it faster by reducing scripts loaded and more secure by removing some information about your WordPress installation.', $this->plugin_name);?></p>


<h2>Theme Links</h2>

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




<h2>Theme Scripts</h2>

<!-- remove css and js query string versions -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove CSS and JS files query strings', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-css_js_versions">
		<h3><?php esc_attr_e('Remove CSS and JS versions', $this->plugin_name);?></h3>
		<p>Resources with a “?” or “&amp;” in the URL can not always be cached correctly. Removing these query strings can improve the performance of your WordPress site.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-css_js_versions" name="<?php echo $this->plugin_name;?>[css_js_versions]" value="1" <?php checked($css_js_versions, 1);?>/>
</div>
</div>

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


<!-- Remove WP Json -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove WP JSON link', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wp_json">
		<h3><?php esc_attr_e('Remove WP JSON link', $this->plugin_name);?></h3>
		<p>WP JSON could potentially open your website to a new front of DDoS attacks. If you do not need it, disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wp_json" name="<?php echo $this->plugin_name;?>[remove_wp_json]" value="1" <?php checked($remove_wp_json, 1);?>/>
</div>
</div>

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

<!-- Remove WP Shortlink -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove WP Shortlink', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_wp_shortlink">
		<h3><?php esc_attr_e('Remove WP Shortlink', $this->plugin_name);?></h3>
		<p>The shortlink is a shortened version of a web page’s URL. If you do not need it, you can disable it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_wp_shortlink" name="<?php echo $this->plugin_name;?>[remove_wp_shortlink]" value="1" <?php checked($remove_wp_shortlink, 1);?>/>
</div>
</div>

<!-- Remove Pingbacks globally
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove Pingbacks globally', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-remove_pingback">
		<h3><?php esc_attr_e('Remove Pingbacks globally', $this->plugin_name);?></h3>
		<p>Help avoid Pingback spam by disabling it here.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-remove_pingback" name="<?php echo $this->plugin_name;?>[remove_pingback]" value="1" <?php checked($remove_pingback, 1);?>/>
</div>
</div>-->


<h2>Miscellaneous</h2>

<!-- Remove WP Generator tag -->
	<div class="options-box">
		<legend class="screen-reader-text"><span><?php _e('Remove WP Generator tag', $this->plugin_name);?></span></legend>
		<label for="<?php echo $this->plugin_name;?>-wp_version_number">
			<h3><?php esc_attr_e('Remove WP Generator tag', $this->plugin_name);?></h3>
			<p>It can be considered a security risk to make your wordpress version visible and public you should hide it.</p>
		</label>
		<div class="options-checkbox">
		<input type="checkbox" id="<?php echo $this->plugin_name;?>-wp_version_number" name="<?php echo $this->plugin_name;?>[wp_version_number]" value="1" <?php checked($wp_version_number, 1);?>/>
	</div>
</div>

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

<!-- Minify HTML -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Minify HTML', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-html_minify">
		<h3><?php esc_attr_e('Minify HTML', $this->plugin_name);?></h3>
		<p>Improve your site performance by Minifying the HTMl.</p>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-html_minify" name="<?php echo $this->plugin_name;?>[html_minify]" value="1" <?php checked($html_minify, 1);?>/>
</div>
</div>


</div>
