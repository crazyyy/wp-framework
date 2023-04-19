<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница лицензирования плагина.
 *
 * Поддерживает режим работы с мультисаймами. Вы можете увидеть эту страницу в панели настройки сети.
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 *
 * @copyright (c) 2018 Webraftic Ltd
 */
class WDN_LicensePage extends WBCR\Factory_Templates_116\Pages\License {

	/**
	 * {@inheritdoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.6.0
	 * @var string
	 */
	public $id = 'wdn_license';

	/**
	 * {@inheritdoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.6.0
	 * @var string
	 */
	public $page_parent_page;

	/**
	 * WCL_LicensePage constructor.
	 *
	 * @param \Wbcr_Factory466_Plugin $plugin
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 *
	 */
	public function __construct( Wbcr_Factory466_Plugin $plugin ) {
		$this->menu_title                  = __( 'License', 'robin-image-optimizer' );
		$this->page_menu_short_description = __( 'Product activation', 'robin-image-optimizer' );
		$this->plan_name                   = __( 'Disable admin notices premium', 'robin-image-optimizer' );

		/*if ( defined( 'WIO_PLUGIN_ACTIVE' ) && ! wrio_is_clearfy_license_activate() ) {
			$this->page_parent_page = 'none';
		}*/

		parent::__construct( $plugin );

		/**
		 * Adds a new plugin card to license components page
		 *
		 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
		 * @since  1.6.2
		 */
		/*add_filter( 'wbcr/clearfy/license/list_components', function ( $components ) {
			$title = 'Free';
			$icon  = 'clearfy-premium-icon-256x256--lock.png';

			if ( $this->is_premium ) {
				$title = 'Premium';
				$icon  = 'clearfy-premium-icon-256x256--default.png';
			}

			$components[] = [
				'name'            => 'clearfy',
				'title'           => sprintf( __( 'Clearfy [%s]', 'clearfy' ), $title ),
				'type'            => 'internal',
				'build'           => $this->is_premium ? 'premium' : 'free',
				'key'             => $this->get_hidden_license_key(),
				'plan'            => $this->get_plan(),
				'expiration_days' => $this->get_expiration_days(),
				'quota'           => $this->is_premium ? $this->premium_license->get_count_active_sites() . ' ' . __( 'of', 'clearfy' ) . ' ' . $this->premium_license->get_sites_quota() : null,
				'subscription'    => $this->is_premium && $this->premium_has_subscription ? sprintf( __( 'Automatic renewal, every %s', '' ), esc_attr( $this->get_billing_cycle_readable() ) ) : null,
				'url'             => 'https://clearfy.pro/',
				'icon'            => WCL_PLUGIN_URL . '/admin/assets/img/' . $icon,
				'description'     => __( 'Public License is a GPLv3 compatible license allowing you to change and use this version of the plugin for free. Please keep in mind this license covers only free edition of the plugin. Premium versions are distributed with other type of a license.', 'clearfy' ),
				'license_page_id' => 'clearfy_license'
			];

			return $components;
		} );*/
	}

	/**
	 * {@inheritdoc}
	 *
	 * @return string
	 * @since  1.6.0
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 */
	/*public function get_plan_description() {
		$description = '<p style="font-size: 16px;">' . __( '<b>Clearfy Business</b> is a paid package of components for the popular free WordPress plugin named Clearfy. You get access to all paid components at one price.', 'clearfy' ) . '</p>';
		$description .= '<p style="font-size: 16px;">' . __( 'Paid license guarantees that you can download and update existing and future paid components of the plugin.', 'clearfy' ) . '</p>';

		return $description;
	}*/
}