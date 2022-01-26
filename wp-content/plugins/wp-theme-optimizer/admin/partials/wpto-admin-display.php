<?php

/**
* @link              https://www.designsbytouch.co.uk
* @since             1.0.0
* @package           Wp_Theme_Optimiser
*/
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<h2 class="nav-tab-wrapper">
		<a href="#theme_scripts" class="nav-tab nav-tab-active"><?php _e('Theme Scripts', $this->plugin_name);?></a>
		<a href="#theme_links" class="nav-tab"><?php _e('Theme Links', $this->plugin_name);?></a>
		<a href="#misc" class="nav-tab"><?php _e('Misc Settings', $this->plugin_name);?></a>
<?php if ( class_exists( 'WooCommerce' ) ) { ?>
		<a href="#wc" class="nav-tab"><?php _e('WooCommerce', $this->plugin_name);?></a>
<?php  } ?>
	</h2>




	<form method="post" name="options" action="options.php">
		<?php
			// /*
			// * Grab all value if already set
			// *
			// */
			$options = get_option($this->plugin_name);

      global $menu;

			$css_js_versions = $options['css_js_versions'];
			$wp_version_number = $options['wp_version_number'];
			$remove_oembed = $options['remove_oembed'];
			$remove_jquery_migrate = $options['remove_jquery_migrate'];
			$remove_emoji_release = $options['remove_emoji_release'];
			$remove_recent_comments_css = $options['remove_recent_comments_css'];
			$remove_rsd_link = $options['remove_rsd_link'];
			$remove_rss_feed = $options['remove_rss_feed'];
			$remove_wlwmanifest = $options['remove_wlwmanifest'];
			$remove_wp_json = $options['remove_wp_json'];
			$remove_wp_shortlink = $options['remove_wp_shortlink'];
			$remove_wp_post_links = $options['remove_wp_post_links'];
			$remove_pingback = $options['remove_pingback'];
			$remove_dns_prefetch = $options['remove_dns_prefetch'];


		// Yoast Optimisations
		$remove_yoast_information = $options['remove_yoast_information'];

		//WooCommerce
		$wc_add_payment_method = $options['wc_add_payment_method'];
		$wc_lost_password = $options['wc_lost_password'];
		$wc_price_slider = $options['wc_price_slider'];
		$wc_single_product = $options['wc_single_product'];
		$wc_add_to_cart = $options['wc_add_to_cart'];
		$wc_cart_fragments = $options['wc_cart_fragments'];
		$wc_credit_card_form = $options['wc_credit_card_form'];
		$wc_checkout = $options['wc_checkout'];
		$wc_add_to_cart_variation = $options['wc_add_to_cart_variation'];
		$wc_single_product = $options['wc_single_product'];
		$wc_cart = $options['wc_cart'];
		$wc_chosen = $options['wc_chosen'];
		$woocommerce = $options['woocommerce'];
		$prettyPhoto = $options['prettyPhoto'];
		$prettyPhoto_init = $options['prettyPhoto_init'];
		$jquery_blockui = $options['jquery_blockui'];
		$jquery_placeholder = $options['jquery_placeholder'];
		$jquery_payment = $options['jquery_payment'];
		$fancybox = $options['fancybox'];
		$jqueryui = $options['jqueryui'];

		// HTML Minify
		$html_minify = $options['html_minify'];

			/*
			* Set up hidden fields
			*
			*/
			settings_fields($this->plugin_name);
			do_settings_sections($this->plugin_name);

?>
<div class="tab-content">
		<?php
		 // Include tabs partials
		 include_once( plugin_dir_path( __FILE__ ) . 'wpto_theme_scripts.php' );
		 include_once( plugin_dir_path( __FILE__ ) . 'wpto_theme_links.php' );
		 include_once( plugin_dir_path( __FILE__ ) . 'wpto_misc.php' );

			if ( class_exists( 'WooCommerce' ) ) {
				include_once( plugin_dir_path( __FILE__ ) . 'wpto_wc.php' );
			}
		?>
		<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

</div>

    </form>

</div>
