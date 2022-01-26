<?php // WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_add_payment_method' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_lost_password' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_price_slider' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_single_product' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_add_to_cart' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_cart_fragments' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_credit_card_form' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_checkout' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_add_to_cart_variation' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_single_product' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_cart' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_wc_chosen' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_woocommerce' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_prettyPhoto' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_prettyPhoto_init' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_jquery_blockui' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_jquery_placeholder' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_jquery_payment' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_fancybox' );
  $this->loader->add_action( 'after_setup_theme', $plugin_public, 'wpto_jqueryui' );
}
 ?>
