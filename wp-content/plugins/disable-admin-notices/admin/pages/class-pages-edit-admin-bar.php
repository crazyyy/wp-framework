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
class WDAN_Edit_Admin_Bar extends WDN_Page {

	/**
	 * {@inheritDoc}
	 *
	 * @var string
	 */
	public $id = "wdanp-edit-admin-bar";

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
	public $page_menu_dashicon = 'dashicons-menu';

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
		$this->menu_title                  = __( 'Hide adminbar items', 'disable-admin-notices' );
		$this->page_menu_short_description = __( 'You can hide an annoying adminbar menu', 'disable-admin-notices' );

		parent::__construct( $plugin );

		$this->plugin = $plugin;

		add_action( 'wp_before_admin_bar_render', [ $this, 'remove_from_admin_bar' ], 999 );
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
	}

	public function remove_from_admin_bar() {
		global $wp_admin_bar;

		if ( empty( $wp_admin_bar ) ) {
			return;
		}

		$hidden_items = $this->plugin->getPopulateOption( 'hidden_adminbar_items', [] );

		$nodes = [];
		foreach ( $wp_admin_bar->get_nodes() as $node ) {
			if ( false === $node->parent && ! empty( $node->title ) ) {
				if ( "updates" === $node->id ) {
					$node->title = "Updates";
				}
				if ( "comments" === $node->id ) {
					$node->title = "Comments";
				}
				$nodes[ $node->id ] = strip_tags( $node->title );
			}
		}

		$this->plugin->updatePopulateOption( 'adminbar_items', $nodes );
	}

	public function showPageContent() {
		$all_items    = $this->plugin->getPopulateOption( 'adminbar_items', [] );
		$hidden_items = $this->plugin->getPopulateOption( 'hidden_adminbar_items', [] );

		?>

		<div class="wrdan-premium-fake-content">
			<div class="wdan-premium-info">
				<h3>Hide admin bar items (menu) PRO</h3>
				<p>This function allows you to disable annoying menu items in the admin bar. Some plugins take up space
					in
					the admin bar to insert their ads. Just get rid of this ad with the premium features of our
					plugin.</p>
				<a class="wdan-button wdan-button-default wdan-button-go-pro" target="_blank" href="https://clearfy.pro/disable-admin-notices/">Go
					Pro</a>
			</div>
			<div class="wdan-premium-layer"></div>

			<h4>Disable adminbar items</h4>
			<table class="wp-list-table widefat fixed striped">
				<tr>
					<th><strong>Menu title</strong></th>
					<th style="width:100px;"><strong>Action</strong></th>
				</tr>
				<?php foreach ( (array) $all_items as $ID => $title ): ?>

					<tr>
						<td><?php echo $title; ?></td>
						<td>
							<?php if ( ! isset( $hidden_items[ $ID ] ) ): ?>
								<a style="color:#e66113;" href="<?php echo wp_nonce_url( $this->getActionUrl( 'disable-adminbar-item', [ 'id' => $ID ] ), 'disable_adminbar_item_' . $ID ); ?>">Disable</a>
							<?php else: ?>
								<a style="color:#428bca;" href="<?php echo wp_nonce_url( $this->getActionUrl( 'enable-adminbar-item', [ 'id' => $ID ] ), 'enable_adminbar_item_' . $ID ); ?>">Enable</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

		<?php
	}

}
