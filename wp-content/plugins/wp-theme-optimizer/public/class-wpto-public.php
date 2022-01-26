<?php

/**
* @link              https://www.designsbytouch.co.uk
* @since             1.0.0
* @package           Wp_Theme_Optimizer
*/
class wpto_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wpto_options = get_option($this->plugin_name);


	}


	// Remove  CSS and JS query strings versions
	public function wpto_remove_cssjs_ver( ) {
		if(!empty($this->wpto_options['css_js_versions'])){
			function wpto_remove_cssjs_ver_filter($src ){
				 if( strpos( $src, '?ver=' ) ) $src = remove_query_arg( 'ver', $src );
				 return $src;
			}
			add_filter( 'style_loader_src', 'wpto_remove_cssjs_ver_filter', 10, 2 );
			add_filter( 'script_loader_src', 'wpto_remove_cssjs_ver_filter', 10, 2 );
		}
	}

	// Remove WP version number
	public function wpto_remove_wp_version_number( ) {
		if(!empty($this->wpto_options['wp_version_number'])){
			function remove_version_generator() {
	 	 return '';
	 	 }
	 	 add_filter('the_generator', 'remove_version_generator');

		}
	}

	// Remove OEmbed
	public function wpto_remove_oembed( ) {
		if(!empty($this->wpto_options['remove_oembed'])){
			function disable_embeds_init() {
				remove_action('rest_api_init', 'wp_oembed_register_route');
				remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
				remove_action('wp_head', 'wp_oembed_add_discovery_links');
				remove_action('wp_head', 'wp_oembed_add_host_js');
			}
			add_action('init', 'disable_embeds_init', 9999);
		}
	}

	// Remove jQuery Migrate
	public function wpto_remove_jquery_migrate( ) {
		if(!empty($this->wpto_options['remove_jquery_migrate'])){
			add_filter( 'wp_default_scripts', 'remove_jquery_migrate_script' );
			function remove_jquery_migrate_script(&$scripts){
			 if(!is_admin()){
			  $scripts->remove('jquery');
			  $scripts->add('jquery', false, array('jquery-core'));
			 }
			}
		}
	}

	// Remove emoji-release
	public function wpto_remove_emoji_release( ) {
		if(!empty($this->wpto_options['remove_emoji_release'])){
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
		}
	}

	// Remove recent comments
		public function wpto_remove_recent_comments_css( ) {
		if(!empty($this->wpto_options['remove_recent_comments_css'])){
function remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'remove_recent_comments_style' );

		}
	}


	// Remove RSD Link
	public function wpto_remove_rsd_link( ) {
		if(!empty($this->wpto_options['remove_rsd_link'])){
			remove_action ('wp_head', 'rsd_link');
		}
	}

	// Remove RSS Feed
	public function wpto_remove_rss_feed( ) {
		if(!empty($this->wpto_options['remove_rss_feed'])){
			function wpto_disable_feed() {
				wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
				}
				remove_action( 'wp_head', 'feed_links_extra', 3 );
				remove_action( 'wp_head', 'feed_links', 2 );
			}
	}

	// Remove wlwmanifest
	public function wpto_remove_wlwmanifest( ) {
		if(!empty($this->wpto_options['remove_wlwmanifest'])){
			remove_action('wp_head', 'wlwmanifest_link');
		}
	}

	// Remove post links
	public function wpto_remove_wp_json( ) {
		if(!empty($this->wpto_options['remove_wp_json'])){
			remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

		}
	}

	// Remove WP Shortlink
	public function wpto_remove_wp_shortlink( ) {
		if(!empty($this->wpto_options['remove_wp_shortlink'])){
			remove_action('wp_head', 'wp_shortlink_wp_head');
		}
	}

	// Remove post links
	public function wpto_remove_wp_post_links( ) {
		if(!empty($this->wpto_options['remove_wp_post_links'])){
			remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
		}
	}

	// Remove post links
	public function wpto_remove_pingback( ) {
		if(!empty($this->wpto_options['remove_pingback'])){
			if (!is_admin()) {
    function link_rel_buffer_callback($buffer) {
        $buffer = preg_replace('/(<link.*?rel=("|\')pingback("|\').*?href=("|\')(.*?)("|\')(.*?)?\/?>|<link.*?href=("|\')(.*?)("|\').*?rel=("|\')pingback("|\')(.*?)?\/?>)/i', '', $buffer);
                return $buffer;
    }
    function link_rel_buffer_start() {
        ob_start("link_rel_buffer_callback");
    }
    function link_rel_buffer_end() {
        ob_flush();
    }
    add_action('template_redirect', 'link_rel_buffer_start', -1);
    add_action('get_header', 'link_rel_buffer_start');
    add_action('wp_head', 'link_rel_buffer_end', 999);
		}
		}
	}


	// Remove Yoast Information
	public function wpto_remove_yoast_information( ) {
		if(!empty($this->wpto_options['remove_yoast_information'])){
			if (defined('WPSEO_VERSION')){
			    $instance = WPSEO_Frontend::get_instance();
			    remove_action( 'wpseo_head', array( $instance, 'debug_marker' ), 2 );
			    remove_action( 'wp_head', array( $instance, 'head' ), 1 );
			    add_action( 'wp_head', 'custom_yoast_head', 1 );
			    function custom_yoast_head() {
			        global $wp_query;
			        $old_wp_query = null;
			        if ( ! $wp_query->is_main_query() ) {
			            $old_wp_query = $wp_query;
			            wp_reset_query();
			        }
			        do_action( 'wpseo_head' );
			        if ( ! empty( $old_wp_query ) ) {
			            $GLOBALS['wp_query'] = $old_wp_query;
			            unset( $old_wp_query );
			        }
			        return;
			    }
			}
		}
	}

	// Remove DNS Prefetch
	public function wpto_remove_dns_prefetch( ) {
		if(!empty($this->wpto_options['remove_dns_prefetch'])){
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		}
	}


	


// 	// HTML Minify
public function wpto_html_minify( ) {
if(!empty($this->wpto_options['html_minify']) && !is_admin()){

function minify_output($buffer) {
$search = array(
'/\>[^\S ]+/s',
'/[^\S ]+\</s',
'/(\s)+/s'
);
$replace = array(
'>',
'<',
'\\1'
);
if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
$buffer = preg_replace($search, $replace, $buffer);
}
return $buffer;

}
ob_start("minify_output");
}

}




// WOOCOMMERCE
// Remove wc_add_payment_method
public function wpto_wc_add_payment_method( ) {
	if(!empty($this->wpto_options['wc_add_payment_method'])){
		function remove_wc_scripts_1() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-add-payment-method' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_1', 99 );
	}
}

// Remove wp-lost-password
public function wpto_wc_lost_password( ) {
	if(!empty($this->wpto_options['wc_lost_password'])){
		function remove_wc_scripts_2() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-lost-password' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_2', 99 );
	}
}

// Remove wc_price_slider
public function wpto_wc_price_slider( ) {
	if(!empty($this->wpto_options['wc_price_slider'])){
		function remove_wc_scripts_3() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc_price_slider' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_3', 99 );
	}
}

// Remove wc-single-product
public function wpto_wc_single_product( ) {
	if(!empty($this->wpto_options['wc_single_product'])){
		function remove_wc_scripts_4() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-single-product' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_4', 99 );
	}
}

// Remove wc_add_to_cart
public function wpto_wc_add_to_cart( ) {
	if(!empty($this->wpto_options['wc_add_to_cart'])){
		function remove_wc_scripts_5() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-add-to-cart' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_5', 99 );
	}
}

// Remove wc-single-product
public function wpto_wc_cart_fragments( ) {
	if(!empty($this->wpto_options['wc_cart_fragments'])){
		function remove_wc_scripts_6() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-cart-fragments' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_6', 99 );
	}
}

// Remove wc_credit_card_form
public function wpto_wc_credit_card_form( ) {
	if(!empty($this->wpto_options['wc_credit_card_form'])){
		function remove_wc_scripts_7() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-credit-card-form' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_7', 99 );
	}
}


// Remove wc_checkout
public function wpto_wc_checkout( ) {
	if(!empty($this->wpto_options['wc_checkout'])){
		function remove_wc_scripts_8() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-checkout' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_8', 99 );
	}
}

// Remove wc-add-to-cart-variation
public function wpto_wc_add_to_cart_variation( ) {
	if(!empty($this->wpto_options['wc_add_to_cart_variation'])){
		function remove_wc_scripts_9() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-add-to-cart-variation' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_9', 99 );
	}
}

// Remove wc-cart
public function wpto_wc_cart( ) {
	if(!empty($this->wpto_options['wc_cart'])){
		function remove_wc_scripts_10() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-cart' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_10', 99 );
	}
}

// Remove wc-chosen
public function wpto_wc_chosen( ) {
	if(!empty($this->wpto_options['wc_chosen'])){
		function remove_wc_scripts_11() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'wc-chosen' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_11', 99 );
	}
}

// Remove woocommerce
public function wpto_woocommerce( ) {
	if(!empty($this->wpto_options['woocommerce'])){
		function remove_wc_scripts_12() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'woocommerce' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_12', 99 );
	}
}

// Remove prettyPhoto
public function wpto_prettyPhoto( ) {
	if(!empty($this->wpto_options['prettyPhoto'])){
		function remove_wc_scripts_13() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'prettyPhoto' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_13', 99 );
	}
}

// Remove prettyPhoto_init
public function wpto_prettyPhoto_init( ) {
	if(!empty($this->wpto_options['prettyPhoto_init'])){
		function remove_wc_scripts_14() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'prettyPhoto-init' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_14', 99 );
	}
}

// Remove jquery_blockui
public function wpto_jquery_blockui( ) {
	if(!empty($this->wpto_options['jquery_blockui'])){
		function remove_wc_scripts_15() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'jquery-blockui' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_15', 99 );
	}
}

// Remove jquery_placeholder
public function wpto_jquery_placeholder( ) {
	if(!empty($this->wpto_options['jquery_placeholder'])){
		function remove_wc_scripts_16() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'jquery-placeholder' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_16', 99 );
	}
}

// Remove jquery_payment
public function wpto_jquery_payment( ) {
	if(!empty($this->wpto_options['jquery_payment'])){
		function remove_wc_scripts_17() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'jquery-payment' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_17', 99 );
	}
}

// Remove fancybox
public function wpto_fancybox( ) {
	if(!empty($this->wpto_options['fancybox'])){
		function remove_wc_scripts_18() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'fancybox' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_18', 99 );
	}
}

// Remove fancybox
public function wpto_jqueryui( ) {
	if(!empty($this->wpto_options['jqueryui'])){
		function remove_wc_scripts_19() {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_script( 'jqueryui' );
			}
		}
		add_action( 'wp_enqueue_scripts', 'remove_wc_scripts_19', 99 );
	}
}

}
