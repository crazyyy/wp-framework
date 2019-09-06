<?php
/**
 * The page License page class.
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_LicensePage extends Wbcr_FactoryClearfy206_PageBase {
	
	/**
	 * The id of the page in the admin menu.
	 *
	 * Mainly used to navigate between pages.
	 * @see Wbcr_FactoryPages410_AdminPage
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $id = "license";
	
	/**
	 * Тип страницы - произвольный контент
	 * @var string
	 */
	public $type = "page";
	
	/**
	 * Иконка страницы
	 * Полный список иконок смотреть тут:
	 * https://developer.wordpress.org/resource/dashicons/#admin-network
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-admin-network';
	
	/**
	 * Показывать правый сайдбар?
	 * Сайдбар будет показан на внутренних страницах шаблона.
	 *
	 * @var bool
	 */
	public $show_right_sidebar_in_options = false;
	
	/**
	 * Позиция закладки в меню плагина.
	 * 0 - в самом конце, 100 - в самом начале
	 * @var int
	 */
	public $page_menu_position = 0;
	
	public $available_for_multisite = true;
	
	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( WCL_Plugin $plugin ) {
		$this->menu_title                  = __( 'License', 'clearfy' );
		$this->page_menu_short_description = __( 'Product activation', 'clearfy' );
		
		parent::__construct( $plugin );
		
		$this->plugin = $plugin;
	}
	
	/**
	 * [MAGIC] Magic method that configures assets for a page.
	 */
	public function assets( $scripts, $styles ) {
		parent::assets( $scripts, $styles );
		
		$this->styles->add( WCL_PLUGIN_URL . '/admin/assets/css/license-manager.css' );
		$this->scripts->add( WCL_PLUGIN_URL . '/admin/assets/js/license-manager.js' );
	}
	
	/**
	 * Метод печатает html содержимое страницы
	 * @return void
	 */
	public function showPageContent() {
		?>
		<?php wp_nonce_field( 'license' ); ?>
        <div id="wcl-license-wrapper" data-loader="<?php echo WCL_PLUGIN_URL . '/admin/assets/img/loader.gif'; ?>">
			<?php $this->showLicenseForm(); ?>
        </div>
		<?php
	}
	
	public function showLicenseForm() {
		
		$licensing = WCL_Licensing::instance();
		$storage   = $licensing->getStorage();
		$license   = $storage->getLicense();
		
		$license_type = 'free';
		$license_key  = '';
		$plan         = 'free';
		$premium      = false;
		$has_key      = false;
		
		$remained  = 999;
		$subscribe = false;
		
		if ( isset( $license->id ) ) {
			$subscribe    = true;
			$license_type = 'paid';
			$activated    = $license->activated;
			$quota        = $license->quota;
			$license_key  = substr_replace( $license->secret_key, '******', 15, 6 );
			$plan         = $license->plan_title;
			$premium      = true;
			$has_key      = true;
			
			$remained = $license->remainingDays();
			
			if ( 1 == $license->billing_cycle ) {
				$billing = 'month';
			}
			
			if ( 12 == $license->billing_cycle ) {
				$billing = 'year';
			}
			
			if ( 0 == $license->billing_cycle ) {
				$billing = 'lifetime';
			}
			
			if ( $license->is_lifetime() ) {
				$billing      = 'lifetime';
				$license_type = 'gift';
				$quota        = 999;
			}
			
			if ( is_null( $license->billing_cycle ) ) {
				$billing   = 'month';
				$subscribe = false;
			}
		}
		
		if ( $remained < 1 ) {
			$license_type = 'trial';
		}
		
		?>
        <div class="factory-bootstrap-409 onp-page-wrap <?= $license_type ?>-license-manager-content" id="license-manager">
            <div>
                <h3><?php _e( 'Activation Clearfy Business', 'clearfy' ) ?></h3>
                <p style="font-size: 16px;"><?php _e( '<b>Clearfy Business</b> is a paid package of components for the popular free WordPress plugin named Clearfy. You get access to all paid components at one price.', 'clearfy' ) ?></p>
                <p style="font-size: 16px;"><?php _e( 'Paid license guarantees that you can download and update existing and future paid components of the plugin.', 'clearfy' ) ?></p>
            </div>
            <br>
            <div class="onp-container">
                <div class="license-details">
					<?php if ( $license_type == 'free' ): ?>
                        <a href="<?= WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl( WCL_Plugin::app()->getPluginName(), 'pricing', 'license_page' ) ?>" class="purchase-premium" target="_blank" rel="noopener">
                            <span class="btn btn-gold btn-inner-wrap">
                            <i class="fa fa-star"></i> <?php printf( __( 'Upgrade to Premium for $%s', 'clearfy' ), WbcrFactoryClearfy206_Helpers::getClearfyBusinessPrice() ) ?>
	                            <i class="fa fa-star"></i>
                            </span>
                        </a>
                        <p><?php printf( __( 'Your current license for %1$s:', 'clearfy' ), $this->plugin->getPluginTitle() ) ?></p>
					<?php endif; ?>
                    <div class="license-details-block <?= $license_type ?>-details-block">
						<?php if ( $has_key ) { ?>
                            <a data-action="deactivate" href="#" class="btn btn-default btn-small license-delete-button wcl-control-btn"><i class="icon-remove-sign"></i> <?php _e( 'Delete Key', 'clearfy' ) ?>
                            </a>
                            <a data-action="sync" href="#" class="btn btn-default btn-small license-synchronization-button wcl-control-btn"><i class="icon-remove-sign"></i> <?php _e( 'Synchronization', 'clearfy' ) ?>
                            </a>
						<?php } ?>
                        <h3>
							<?= ucfirst( $plan ); ?>
							<?php if ( $premium and $subscribe ) { ?>
                                <span style="font-size: 15px;"><?php printf( __( '(Automatic renewal, every %s', '' ), esc_attr( $billing ) ); ?>
										)</span>
							<?php } ?>
                        </h3>
						<?php if ( $has_key ) { ?>
                            <div class="license-key-identity"><code><?= esc_attr( $license_key ) ?></code></div>
						<?php } ?>
                        <div class="license-key-description">
                            <p><?php _e( 'Public License is a GPLv2 compatible license allowing you to change and use this version of the plugin for free. Please keep in mind this license covers only free edition of the plugin. Premium versions are distributed with other type of a license.', 'clearfy' ) ?>
                            </p>
							<?php if ( $premium and $subscribe and $license->billing_cycle ) { ?>
                                <p class="activate-trial-hint">
									<?php _e( 'You use a paid subscription for the plugin updates. In case you don’t want to receive paid updates, please, click <a data-action="unsubscribe" class="wcl-control-btn" href="#">cancel subscription</a>', 'clearfy' ) ?>
                                </p>
							<?php } ?>
							<?php if ( $remained < 1 ) { ?>
                                <p class="activate-error-hint">
									<?php printf( __( 'Your license has expired, please extend the license to get updates and support.', 'clearfy' ), '' ) ?>
                                </p>
							<?php } ?>
                        </div>
                        <table class="license-params" colspacing="0" colpadding="0">
                            <tr>
                                <!--<td class="license-param license-param-domain">
										<span class="license-value"><?php echo esc_attr( $_SERVER['SERVER_NAME'] ); ?></span>
										<span class="license-value-name"><?php _e( 'domain', 'clearfy' ) ?></span>
									</td>-->
                                <td class="license-param license-param-days">
                                    <span class="license-value"><?= $plan ?></span>
                                    <span class="license-value-name"><?php _e( 'plan', 'clearfy' ) ?></span>
                                </td>
								<?php if ( $premium ) : ?>
                                    <td class="license-param license-param-sites">
                                        <span class="license-value"><?php echo esc_attr( $activated ); ?>&nbsp;<?php _e( 'of', 'clearfy' ) ?>&nbsp;<?php echo esc_attr( $quota ); ?></span>
                                        <span class="license-value-name"><?php _e( 'active sites', 'clearfy' ) ?></span>
                                    </td>
								<?php endif; ?>
                                <td class="license-param license-param-version">
										<span class="license-value"><?= $this->plugin->getPluginVersion() ?>
											<small><?php _e( 'version', 'clearfy' ) ?></small></span>
                                    <span class="license-value-name"><span><?php _e( 'up-to-date', 'clearfy' ) ?></span></span>
                                </td>
								<?php if ( $premium ) { ?>
                                    <td class="license-param license-param-days">
										<?php if ( $remained < 1 ) { ?>
                                            <span class="license-value"><?php _e( 'EXPIRED!', 'clearfy' ) ?></span>
                                            <span class="license-value-name"><?php _e( 'please update the key', 'clearfy' ) ?></span>
										<?php } else { ?>
                                            <span class="license-value">
													<?php
													if ( $billing == 'lifetime' ) {
														$remained = 'infiniate';
													}
													?>
												<?= $remained ?>
													<small> <?php _e( 'day(s)', 'clearfy' ) ?></small>
                                             </span>
                                            <span class="license-value-name"><?php _e( 'remained', 'clearfy' ) ?></span>
										<?php } ?>
                                    </td>
								<?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="license-input">
                    <form action="" method="post">
						<?php if ( $premium ) { ?>
                    <p><?php _e( 'Have a key to activate the premium version? Paste it here:', 'clearfy' ) ?><p>
					<?php } else { ?>
                        <p><?php _e( 'Have a key to activate the plugin? Paste it here:', 'clearfy' ) ?>
                        <p>
							<?php } ?>
                            <button data-action="activate" class="btn btn-default wcl-control-btn" type="button" id="license-submit">
								<?php _e( 'Submit Key', 'clearfy' ) ?>
                            </button>
                        <div class="license-key-wrap">
                            <input type="text" id="license-key" name="licensekey" value="" class="form-control"/>
                        </div>
						<?php if ( $premium ) { ?>
                            <p style="margin-top: 10px;">
								<?php printf( __( '<a href="%s" target="_blank" rel="noopener">Lean more</a> about the premium version and get the license key to activate it now!', 'clearfy' ), WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl( WCL_Plugin::app()->getPluginName(), 'pricing', 'license_page' ) ) ?>
                            </p>
						<?php } else { ?>
                            <p style="margin-top: 10px;">
								<?php printf( __( 'Can’t find your key? Go to <a href="%s" target="_blank" rel="noopener">this page</a> and login using the e-mail address associated with your purchase.', 'clearfy' ), WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl( WCL_Plugin::app()->getPluginName(), 'contact-us', 'license_page' ) ) ?>
                            </p>
						<?php } ?>
                    </form>
                </div>
            </div>
        </div>
		<?php
	}
}
