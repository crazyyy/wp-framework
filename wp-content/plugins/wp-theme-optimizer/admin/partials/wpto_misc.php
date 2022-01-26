<?php
/**
* @link              https://www.designsbytouch.co.uk
* @since             1.0.0
* @package           Wp_Theme_Optimiser
*/
?>

<div id="misc" class="wrap metabox-holder columns-4 wpto-metaboxes hidden">
	<h1><?php esc_attr_e( 'Miscellaneous', $this->plugin_name ); ?></h1>
	<p><?php _e('Welcome to the WP Theme Optimizer plugin. Use this page to activate or deactivate various settings which can clean up your WordPress code, made it faster by reducing scripts loaded and more secure by removing some information about your WordPress installation.', $this->plugin_name);?></p>

	<input type="checkbox" class="all"/>
	<h3 class="activate-label"><?php esc_attr_e('Activate/Deactivate All', $this->plugin_name);?></h3>
	
	<?php	
		foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/wpto-misc/*.php' ) as $file ) {
			include_once $file;
		}
	?>
</div>
