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
	
	class WHTM_SettingsPage extends Wbcr_FactoryClearfy206_PageBase {
		
		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see Wbcr_FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "html_minify"; // Уникальный идентификатор страницы
		public $page_menu_dashicon = 'dashicons-testimonial'; // Иконка для закладки страницы, дашикон
		public $page_parent_page = "performance"; // Уникальный идентификатор родительской страницы
		/**
		 * Доступена для мультисайтов
		 * @var bool
		 */
		public $available_for_multisite = true;

		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			// Заголовок страницы
			$this->menu_title = __('HTML Minify', 'html-minify');

			// Если плагин загружен, как самостоятельный, то мы меняем настройки страницы и делаем ее внешней,
			// а не внутренней страницей родительского плагина. Внешнии страницы добавляются в Wordpress меню "Общие"

			if( !defined('LOADING_HTML_MINIFY_AS_ADDON') ) {
				// true - внутреняя, false- внешняя страница
				$this->internal = false;
				// меню к которому, нужно прикрепить ссылку на страницу
				$this->menu_target = 'options-general.php';
				// Если true, добавляет ссылку "Настройки", рядом с действиями активации, деактивации плагина, на странице плагинов.
				$this->add_link_to_plugin_actions = true;

				$this->page_parent_page = null;
			}

			parent::__construct($plugin);
		}

		// Метод позволяет менять заголовок меню, в зависимости от сборки плагина.
		public function getMenuTitle()
		{
			return defined('LOADING_HTML_MINIFY_AS_ADDON')
				? __('HTML Minify', 'html-minify')
				: __('General', 'html-minify');
		}

		/**
		 * Метод должен передать массив опций для создания формы с полями.
		 * Созданием страницы и формы занимается фреймворк
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getPageOptions()
		{
			$options = wbcr_htm_settings_form_options();

			$formOptions = array();
			
			$formOptions[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);
			
			return apply_filters('wbcr_htm_settings_form_options', $formOptions);
		}
	}