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

class WDN_Settings_Page extends WDN_Page {

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $id = "wdan_settings";

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-admin-generic';

	/**
	 * {@inheritDoc}
	 *
	 * @var bool
	 */
	public $available_for_multisite = true;

	/**
	 * {@inheritDoc}
	 *
	 * @since  1.1.0
	 * @var bool
	 */
	public $show_right_sidebar_in_options = true;

	/**
	 * {@inheritDoc}
	 *
	 * @since  1.1.3 - Added
	 * @var bool - true show, false hide
	 */
	public $show_search_options_form = false;

	/**
	 * {@inheritDoc}
	 * @var int
	 */
	public $page_menu_position = 100;


	/**
	 * @param Wbcr_Factory456_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory456_Plugin $plugin ) {
		$this->menu_title                  = __( 'Hide admin notices', 'disable-admin-notices' );
		$this->page_menu_short_description = __( 'General settings', 'disable-admin-notices' );

		$this->internal                   = false;
		$this->menu_target                = 'options-general.php';
		$this->add_link_to_plugin_actions = true;

		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

	public function getPageTitle() {
		return __( 'Settings', 'disable-admin-notices' );
	}

	/**
	 * Requests assets (js and css) for the page.
	 *
	 * @param Wbcr_Factory456_ScriptList $scripts
	 * @param Wbcr_Factory456_StyleList $styles
	 *
	 * @return void
	 * @see Wbcr_FactoryPages455_AdminPage
	 *
	 */
	public function assets( $scripts, $styles ) {
		parent::assets( $scripts, $styles );

		$this->styles->add( WDN_PLUGIN_URL . '/admin/assets/css/settings.css' );
		$this->scripts->add( WDN_PLUGIN_URL . '/admin/assets/js/settings.js' );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array
	 */
	public function actionsNotice( $notices ) {
		$notices[] = [
			'conditions' => [
				'wbcr_dan_reseted_notices' => 1
			],
			'type'       => 'success',
			'message'    => __( 'Hidden notices are successfully reset, now you can see them again!', 'disable-admin-notices' )
		];

		/*$notices[] = array(
			'conditions' => array(
				'wbcr_dan_clear_comments_error' => 1,
				'wbcr_dan_code' => 'interal_error'
			),
			'type' => 'danger',
			'message' => __('An error occurred while trying to delete comments. Internal error occured. Please try again later.', 'factory_pages_455')
		);*/

		return $notices;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return array
	 */
	public function getPageOptions() {
		$options = wbcr_dan_get_plugin_options();

		$formOptions = [];

		$formOptions[] = [
			'type'  => 'form-group',
			'items' => $options,
			//'cssClass' => 'postbox'
		];

		return apply_filters( 'wbcr_dan_notices_form_options', $formOptions, $this );
	}
}