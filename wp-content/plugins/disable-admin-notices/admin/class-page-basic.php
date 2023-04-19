<?php
/**
 * Страница общих настроек для этого плагина.
 *
 * Может быть использована только, если этот плагин используется как отдельный плагин, а не как аддон
 * дя плагина Clearfy. Если плагин загружен, как аддон для Clearfy, эта страница не будет подключена.
 *
 * Поддерживает режим работы с мультисаймами. Вы можете увидеть эту страницу в панели настройки сети.
 *
 * Github: https://github.com/alexkovalevv
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WDN_Page extends WBCR\Factory_Templates_116\Pages\PageBase {

	/**
	 * Requests assets (js and css) for the page.
	 *
	 * @param Wbcr_Factory466_ScriptList $scripts
	 * @param Wbcr_Factory466_StyleList $styles
	 *
	 * @return void
	 * @see Wbcr_FactoryPages466_AdminPage
	 *
	 */
	public function assets( $scripts, $styles ) {
		$this->styles->add( WDN_PLUGIN_URL . '/admin/assets/css/page.css' );

		parent::assets( $scripts, $styles );
	}

	public function getPluginTitle() {
		return "<span class='wdan-plugin-header-logo'>&nbsp;</span>" . __( 'Webcraftic Disable Admin Notices', 'disable-admin-notices' );
	}
}