<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница общих настроек для этого плагина.
 *
 * Не поддерживает режим работы с мультисаймами.
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 * @copyright (c) 2019 Webraftic Ltd
 * @version       1.0
 */
class WDAN_Block_Ad_Redirects extends WDN_Page {

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $id = "wdanp-edit-redirects";

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
	public $page_menu_dashicon = 'dashicons dashicons-undo';

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
		$this->menu_title                  = __( 'Block ad redirects', 'disable-admin-notices' );
		$this->page_menu_short_description = __( 'Break advertising redirects', 'disable-admin-notices' );

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

	public function get_break_redirects() {
		return [];
	}

	public function showPageContent() {
		$redirects = $this->get_break_redirects();
		?>

		<div class="wrdan-premium-fake-content">
			<div class="wdan-premium-info">
				<h3>Block Ad redirects PRO</h3>
				<p>This feature will be useful to you to break advertising redirects. Some plugins, when updating or
					during
					installation, may redirect you to their page with advertisements or news. If plugins do this too
					often,
					it can be a headache for you. Break these redirects with our premium features.</p>
				<a class="wdan-button wdan-button-default wdan-button-go-pro" target="_blank"
				   href="https://clearfy.pro/disable-admin-notices/">
					Go Pro
				</a>
			</div>
			<div class="wdan-premium-layer"></div>

			<h4>Block ad redirects</h4>
			<form method="post">
				<label for="wdnpro-redirect-url">Enter url for block:</label><br>
				<input id="wdnpro-redirect-url" style="width:400px;" type="text" name="wdnpro_redirect_url">
				<input type="submit" name="wdnpro_add_block" class="button" value="Add block">
			</form>
			<br>
			<table class="wp-list-table widefat fixed striped">
				<tr>
					<th>Url</th>
					<th style="width:200px;">Action</th>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
				<tr>
					<td>
						https://site.com/wp-admin/?page=plugin-name&ads=redirect
					</td>
					<td>
						<a style="color:#428bca;" href="#">Unblock</a>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}

}
