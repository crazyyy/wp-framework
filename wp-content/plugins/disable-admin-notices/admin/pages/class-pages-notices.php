<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница со списком скрытых нотисов.
 *
 * @author        Artem Prihodko <webtemyk@yandex.ru>
 * @copyright (c) 2020 Webraftic Ltd
 * @version       1.0
 */
class WDAN_Notices extends WDN_Page {

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $id = "wdan-notices";

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $type = "page";

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $page_menu_dashicon = 'dashicons-hidden';

	/**
	 * {@inheritDoc}
	 *
	 * @since   2.0.5 - добавлен
	 * @var bool
	 */
	public $show_right_sidebar_in_options = false;


	/**
	 * @param WDN_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->menu_title                  = __( 'Hidden notices', 'disable-admin-notices' );
		$this->page_menu_short_description = __( 'Manage hidden notices', 'disable-admin-notices' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;
	}

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
		parent::assets( $scripts, $styles );

		$this->styles->add( WDN_PLUGIN_URL . '/admin/assets/css/settings.css' );
	}

	public function showPageContent() {
		?>
		<div class="wrdan-premium-fake-content">
			<div class="wdan-premium-info">
				<h3>Hidden notices PRO</h3>
				<p>This function allows you to disable annoying menu items in the admin bar. Some plugins take up space
					in
					the admin bar to insert their ads. Just get rid of this ad with the premium features of our
					plugin.</p>
				<a class="wdan-button wdan-button-default wdan-button-go-pro" target="_blank"
				   href="https://clearfy.pro/disable-admin-notices/">Go
					Pro</a>
			</div>
		</div>
		<?php
	}
}
