<?php

	/**
	 * Класс позволяет получить информацию о плагине Clearfy и его совместимость с другими плагинами.
	 * Наследует класс Wbcr_Factory_Compatibility, который отвечает за проверку базовой совместимости сайта.
	 *
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 26.09.2018, Webcraftic
	 * @version 1.0.0
	 * @since 2.0.5
	 */
	if( !class_exists('Wbcr_FactoryClearfy_Compatibility') ) {

		class Wbcr_FactoryClearfy_Compatibility extends Wbcr_Factory_Compatibility {

			protected $factory_version;

			/**
			 * @var bool
			 */
			protected $plugin_as_component;

			/**
			 * @var bool
			 */
			protected $plugin_already_activate;

			/**
			 * @var bool
			 */
			protected $plugin_dir;

			/**
			 * @var bool
			 */
			protected $plugin_base;

			/**
			 * @var bool
			 */
			protected $plugin_url;

			/**
			 * С какой версией Clearfy может работать этот плагин
			 *
			 * @var string
			 */
			protected $required_clearfy_version = '1.4.2';

			/**
			 * Нужно ли требовать активацию Clearfy для работы этого плагина
			 * Если true, то нужно
			 *
			 * @var bool по умолчанию false
			 */
			protected $required_clearfy_active = false;


			/**
			 * Нужно ли проверять активирован ли этот плагин, как компонент в плагине Clearfy
			 * Если true, то нужно
			 *
			 * @var bool по умолчанию false
			 */
			protected $required_clearfy_check_component = false;

			/**
			 * Нужно ли проверять совместимость фреймворка для работы с плагином Clearfy
			 * Если true, то нужно
			 *
			 * @var bool по умолчанию false
			 */
			protected $required_clearfy_framework_compatibility = false;


			/**
			 * Нужно ли проверять совместимость этого плагин с версией Clearfy
			 * Если true, то нужно
			 *
			 * @var bool по умолчанию false
			 */
			protected $required_clearfy_version_compatibility = false;


			function __construct(array $plugin_info)
			{
				parent::__construct($plugin_info);
			}

			/**
			 * Это статистический метод. Вовзращает директорию плагина Clearfy
			 *
			 * @return string
			 */
			public static function getClearfyDir()
			{
				$folder_name = 'clearfy';
				
				return WP_PLUGIN_DIR . '/' . $folder_name;
			}

			/**
			 * Это статистический метод. Вовзращает базовый путь к плагину Clearfy
			 * Пример: clearfy/clearfy.php
			 *
			 * @return string
			 */
			public static function getClearfyBasePath()
			{
				return plugin_basename(self::getClearfyPluginFile());
			}

			/**
			 * Это статистический метод. Вовзращает aбсолютный путь к основному файлу плагина Clearfy         *
			 * Пример: www/wp-content/plugins/clearfy/clearfy.php
			 *
			 * @return string
			 */
			public static function getClearfyPluginFile()
			{
				return self::getClearfyDir() . '/clearfy.php';
			}

			/**
			 * Это статистический метод. Возвращает версию плагина Clearfy         *
			 * Пример: 1.3.0
			 *
			 * @return string
			 */
			public static function getClearfyVersion()
			{
				require_once ABSPATH . '/wp-admin/includes/plugin.php';

				$plugin_data = get_plugin_data(self::getClearfyPluginFile());

				return !empty($plugin_data['Version']) ? $plugin_data['Version'] : null;
			}

			public function registerNotices()
			{
				if( current_user_can('activate_plugins') && current_user_can('edit_plugins') && current_user_can('install_plugins') ) {
					if( is_plugin_active_for_network(self::getClearfyBasePath()) ) {
						add_action('network_admin_notices', array($this, 'showNotice'));
					} else {
						add_action('admin_notices', array($this, 'showNotice'));
					}
				}
			}


			/**
			 * Проверяем, активирован ли плагин Clearfy
			 *
			 * @return bool
			 */
			public static function isClearfyActivate()
			{
				require_once ABSPATH . '/wp-admin/includes/plugin.php';

				return is_plugin_active(self::getClearfyBasePath());
			}

			/**
			 * Проверяем, активирован ли плагин, как компонент в Clearfy
			 *
			 * @return bool
			 */
			public function isPluginActiveAsComponent()
			{
				return self::isClearfyActivate() && !$this->plugin_as_component;
			}

			/**
			 * Проверяем совместимость с версией фреймворка, который использует плагина Clearfy
			 *
			 * @return bool
			 */
			public function checkClearfyFrameworkCompatibility()
			{
				if( !defined('WBCR_CLEARFY_FRAMEWORK_VER') || empty($this->factory_version) ) {
					return false;
				}

				return WBCR_CLEARFY_FRAMEWORK_VER == $this->factory_version;
			}

			/**
			 * Проверяем совместимость этого плагина с версией Clearfy
			 *
			 * @return bool
			 */
			public function checkClearfyVersionCompatibility()
			{
				$plugin_version = self::getClearfyVersion();

				if( !empty($plugin_version) ) {
					if( !version_compare($plugin_version, $this->required_clearfy_version, '>=') ) {
						return false;
					}
				}

				return true;
			}

			/**
			 * Совместимость с плагином Clearfy, проверяется только в премиум компонентах,
			 * так как компоненты компилируются с Clearfy на одной версии фреймворка
			 *
			 * @return bool|mixed
			 */
			public function check()
			{
				if( $this->plugin_already_activate ) {
					return false;
				}

				if( $this->required_clearfy_check_component && $this->isPluginActiveAsComponent() ) {
					return false;
				}

				if( !parent::check() ) {
					return false;
				}

				if( !self::checkClearfyFrameworkCompatibility() && $this->required_clearfy_framework_compatibility ) {
					return false;
				}

				if( $this->required_clearfy_active ) {
					if( self::isClearfyActivate() ) {
						if( $this->required_clearfy_version_compatibility ) {
							$plugin_version = self::getClearfyVersion();

							if( !empty($plugin_version) ) {
								if( !version_compare($plugin_version, $this->required_clearfy_version, '>=') ) {
									return false;
								}
							}
						}
					} else {
						return false;
					}
				}

				return true;
			}

			/**
			 * Метод возвращает текст уведомления
			 *
			 * @return string
			 */
			public function getNoticeText()
			{
				if( !self::isClearfyActivate() && !$this->required_clearfy_active ) {
					return parent::getNoticeText();
				}

				$notice_text = $notice_default_text = '';

				if( self::isClearfyActivate() ) {
					$notice_default_text .= '<b>' . __('Clearfy warning', 'wbcr_factory_clearfy_206') . ':</b>' . '<br>';
					$phrase = sprintf(__('The %s component', 'wbcr_factory_clearfy_206'), $this->plugin_title);
				} else {
					$notice_default_text .= '<b>' . $this->plugin_title . ' ' . __('warning', 'wbcr_factory_clearfy_206') . ':</b>' . '<br>';
					$phrase = sprintf(__('The %s plugin', 'wbcr_factory_clearfy_206'), $this->plugin_title);
				}

				$notice_default_text .= $phrase . ' ' . __('has stopped.', 'wbcr_factory_clearfy_206');
				$notice_default_text .= __('Possible reasons:', 'wbcr_factory_clearfy_206') . ' <br>';

				$has_one = false;

				if( !$this->isPhpCompatibility() ) {
					$has_one = true;
					$notice_text .= '- ' . sprintf(__('You need to update the PHP version to %s or higher!', 'wbcr_factory_clearfy_206'), $this->required_php_version) . '<br>';
				}

				if( !$this->isWpCompatibility() ) {
					$has_one = true;
					$notice_text .= '- ' . sprintf(__('You need to update WordPress to %s or higher!', 'wbcr_factory_clearfy_206'), $this->required_wp_version) . '<br>';
				}

				if( $this->required_clearfy_version_compatibility && !$this->checkClearfyVersionCompatibility() ) {
					$has_one = true;
					$notice_text .= '- ' . sprintf(__('You need to update the Clearfy plugin version to %s or higher!', 'wbcr_factory_clearfy_206'), $this->required_clearfy_version) . '<br>';
				}

				if( $this->plugin_already_activate ) {
					$has_one = true;
					$notice_text = '- ' . sprintf(__('This plugin is already activated, you are trying to activate it again.', 'wbcr_factory_clearfy_206'), $this->required_php_version) . '<br>';
				}

				if( $this->required_clearfy_check_component && $this->isPluginActiveAsComponent() ) {
					$has_one = true;
					$notice_text = '- ' . sprintf(__('Clearfy has the features of the %s plugin. Please, deactivate %s to avoid conflicts of plugins!', 'wbcr_factory_clearfy_206'), $this->plugin_title, $this->plugin_title) . '<br>';
				}

				if( $has_one ) {
					$notice_text = $notice_default_text . $notice_text;
				}

				return $notice_text;
			}
		}
	}