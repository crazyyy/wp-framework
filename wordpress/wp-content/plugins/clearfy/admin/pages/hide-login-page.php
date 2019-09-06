<?php

	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	class WCL_HideLoginPage extends Wbcr_FactoryClearfy206_PageBase {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "clrf_hide_login";

		/**
		 * @var string
		 */
		public $page_parent_page = 'defence';

		/**
		 * Тип страницы
		 * options - предназначена для создании страниц с набором опций и настроек.
		 * page - произвольный контент, любой html код
		 *
		 * @var string
		 */
		public $type = 'page';

		/**
		 * Позиция закладки в меню плагина.
		 * 0 - в самом конце, 100 - в самом начале
		 *
		 * @var int
		 */
		public $page_menu_position = 30;

		/**
		 * @var string
		 */
		public $page_menu_dashicon = 'dashicons-images-alt2';

		/**
		 * @var bool
		 */
		public $available_for_multisite = true;

		/**
		 * @param WCL_Plugin $plugin
		 */
		public function __construct(WCL_Plugin $plugin)
		{
			$this->menu_title = __('Hide login page', 'clearfy');
			parent::__construct($plugin);

			$this->plugin = $plugin;
		}

		/**
		 * Содержание страницы
		 */
		public function showPageContent()
		{
			require_once WCL_PLUGIN_DIR . '/admin/includes/classes/class.install-plugins-button.php';
			$install_button = new WCL_InstallPluginsButton('wordpress', 'hide-login-page/hide-login-page.php');
			$install_button->addClass('wbcr-factory-purchase-premium');
			?>
			<script>
				jQuery(document).ready(function($) {
					$.wbcr_factory_clearfy_206.hooks.add('clearfy/components/updated', function(button, component_name) {
						if( component_name.plugin_action == 'install' ) {
							button.removeClass('wbcr-factory-purchase-premium');
							button.addClass('wbcr-factory-activate-premium');
						}

						if( component_name.plugin_action == 'activate' ) {
							button.remove();
							window.location.href = '<?= $this->getBaseUrl('hlp_hide_login'); ?>';
						}
					});
				});
			</script>
			<div class="wbcr-factory-clearfy-206-multisite-suggetion">
				<div class="wbcr-factory-inner-contanier">
					<h3><?php _e('Install Hide login page component', 'clearfy') ?></h3>

					<p><?php _e('To start protect login page, you need to install the additional component Hide login page!', 'clearfy') ?></p>

					<p><?php _e('Installing the component will not take you long, just click the install button, then activate.', 'clearfy') ?></p>

					<p style="margin-top:20px">
						<?php $install_button->renderLink(); ?>
					</p>
				</div>
			</div>
		<?php
		}
	}
