<?php

/**
* @link              https://www.designsbytouch.co.uk
* @since             1.0.0
* @package           Wp_Theme_Optimiser
*/
?>

<div id="wc" class="wrap metabox-holder columns-4 wpto-metaboxes hidden">

	<h2><?php esc_attr_e( 'WooCommerce', $this->plugin_name ); ?></h2>
        <p><?php _e('Here you can disable a number of scripts that ships with WooCommerce. Please check to make sure everything works after disabling scripts as some are required. Even scripts that are disabled will reappear on WooCommerce pages.', $this->plugin_name);?></p>
				<input type="checkbox" class="all"/>
				<h3 class="activate-label"><?php esc_attr_e('Activate/Deactivate All', $this->plugin_name);?></h3>



<!-- Remove wc-add-payment-method.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-add-payment-method.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_add_payment_method">
		<h3><?php esc_attr_e('Remove wc-add-payment-method.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_add_payment_method" name="<?php echo $this->plugin_name;?>[wc_add_payment_method]" value="1" <?php checked($wc_add_payment_method, 1);?>/>
</div>
</div>


<!-- Remove wc-lost-password.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-lost-password.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_lost_password">
		<h3><?php esc_attr_e('Remove wc-lost-password.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_lost_password" name="<?php echo $this->plugin_name;?>[wc_lost_password]" value="1" <?php checked($wc_lost_password, 1);?>/>
</div>
</div>

<!-- Remove wc_price_slider.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc_price_slider.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_price_slider">
		<h3><?php esc_attr_e('Remove wc_price_slider.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_price_slider" name="<?php echo $this->plugin_name;?>[wc_price_slider]" value="1" <?php checked($wc_price_slider, 1);?>/>
</div>
</div>

<!-- Remove wc-single-product.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-single-product.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_single_product">
		<h3><?php esc_attr_e('Remove wc-single-product.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_single_product" name="<?php echo $this->plugin_name;?>[wc_single_product]" value="1" <?php checked($wc_single_product, 1);?>/>
</div>
</div>

<!-- Remove wc-add-to-cart.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-add-to-cart.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_add_to_cart">
		<h3><?php esc_attr_e('Remove wc-add-to-cart.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_add_to_cart" name="<?php echo $this->plugin_name;?>[wc_add_to_cart]" value="1" <?php checked($wc_add_to_cart, 1);?>/>
</div>
</div>

<!-- Remove wc-cart-fragments.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-cart-fragments.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_cart_fragments">
		<h3><?php esc_attr_e('Remove wc-cart-fragments.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_cart_fragments" name="<?php echo $this->plugin_name;?>[wc_cart_fragments]" value="1" <?php checked($wc_cart_fragments, 1);?>/>
</div>
</div>


<!-- Remove wc_credit_card_form.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc_credit_card_form.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_credit_card_form">
		<h3><?php esc_attr_e('Remove wc_credit_card_form.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_credit_card_form" name="<?php echo $this->plugin_name;?>[wc_credit_card_form]" value="1" <?php checked($wc_credit_card_form, 1);?>/>
</div>
</div>

<!-- Remove wc_checkout.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-wc_checkout.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_checkout">
		<h3><?php esc_attr_e('Remove wc-wc_checkout.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_checkout" name="<?php echo $this->plugin_name;?>[wc_checkout]" value="1" <?php checked($wc_checkout, 1);?>/>
</div>
</div>

<!-- Remove wc-add-to-cart-variation.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-add-to-cart-variation.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_add_to_cart_variation">
		<h3><?php esc_attr_e('Remove wc-add-to-cart-variation.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_add_to_cart_variation" name="<?php echo $this->plugin_name;?>[wc_add_to_cart_variation]" value="1" <?php checked($wc_add_to_cart_variation, 1);?>/>
</div>
</div>


<!-- Remove wc-single-product.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-single-product.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_single_product">
		<h3><?php esc_attr_e('Remove wc-single-product.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_single_product" name="<?php echo $this->plugin_name;?>[wc_single_product]" value="1" <?php checked($wc_single_product, 1);?>/>
</div>
</div>

<!-- Remove wc-cart.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-cart.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_cart">
		<h3><?php esc_attr_e('Remove wc-cart.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_cart" name="<?php echo $this->plugin_name;?>[wc_cart]" value="1" <?php checked($wc_cart, 1);?>/>
</div>
</div>

<!-- Remove wc-chosen.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove wc-chosen.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-wc_chosen">
		<h3><?php esc_attr_e('Remove wc-chosen.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-wc_chosen" name="<?php echo $this->plugin_name;?>[wc_chosen]" value="1" <?php checked($wc_chosen, 1);?>/>
</div>
</div>

<!-- Remove woocommerce.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove woocommerce.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-woocommerce">
		<h3><?php esc_attr_e('Remove woocommerce.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-woocommerce" name="<?php echo $this->plugin_name;?>[woocommerce]" value="1" <?php checked($woocommerce, 1);?>/>
</div>
</div>

<!-- Remove prettyPhoto.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove prettyPhoto.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-prettyPhoto">
		<h3><?php esc_attr_e('Remove prettyPhoto.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-prettyPhoto" name="<?php echo $this->plugin_name;?>[prettyPhoto]" value="1" <?php checked($prettyPhoto, 1);?>/>
</div>
</div>

<!-- Remove prettyPhoto-init.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove prettyPhoto-init.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-prettyPhoto_init">
		<h3><?php esc_attr_e('Remove prettyPhoto-init.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-prettyPhoto_init" name="<?php echo $this->plugin_name;?>[prettyPhoto_init]" value="1" <?php checked($prettyPhoto_init, 1);?>/>
</div>
</div>

<!-- Remove jquery-blockui.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove jquery-blockui.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-jquery_blockui">
		<h3><?php esc_attr_e('Remove jquery-blockui.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-jquery_blockui" name="<?php echo $this->plugin_name;?>[jquery_blockui]" value="1" <?php checked($jquery_blockui, 1);?>/>
</div>
</div>

<!-- Remove jquery_placeholder.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove jquery-placeholder.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-jquery_placeholder">
		<h3><?php esc_attr_e('Remove jquery-placeholder.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-jquery_placeholder" name="<?php echo $this->plugin_name;?>[jquery_placeholder]" value="1" <?php checked($jquery_placeholder, 1);?>/>
</div>
</div>

<!-- Remove jquery-payment.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove jquery-payment.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-jquery_payment">
		<h3><?php esc_attr_e('Remove jquery-payment.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-jquery_payment" name="<?php echo $this->plugin_name;?>[jquery_payment]" value="1" <?php checked($jquery_payment, 1);?>/>
</div>
</div>


<!-- Remove fancybox.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove fancybox.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-fancybox">
		<h3><?php esc_attr_e('Remove fancybox.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-fancybox" name="<?php echo $this->plugin_name;?>[fancybox]" value="1" <?php checked($fancybox, 1);?>/>
</div>
</div>

<!-- Remove jqueryui.js -->
<div class="options-box">
	<legend class="screen-reader-text"><span><?php _e('Remove jqueryui.js', $this->plugin_name);?></span></legend>
	<label for="<?php echo $this->plugin_name;?>-jqueryui">
		<h3><?php esc_attr_e('Remove jqueryui.js', $this->plugin_name);?></h3>
	</label>
	<div class="options-checkbox">
	<input type="checkbox" id="<?php echo $this->plugin_name;?>-jqueryui" name="<?php echo $this->plugin_name;?>[jqueryui]" value="1" <?php checked($jqueryui, 1);?>/>
</div>
</div>

</div>
