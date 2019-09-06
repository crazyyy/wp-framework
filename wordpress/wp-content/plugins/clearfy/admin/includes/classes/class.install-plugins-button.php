<?php

	/**
	 * This file groups the settings for quick setup
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 16.09.2017, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WCL_InstallPluginsButton {

		protected $type;
		protected $plugin_slug;
		protected $classes = array(
			'button',
			'wbcr-clr-proccess-button',
			'wbcr-clr-update-component-button'
		);
		protected $data = array();
		protected $base_path;

		protected $action;
		
		protected $url;

		/**
		 * @param string $group_name
		 * @throws Exception
		 */
		public function __construct($type, $plugin_slug)
		{
			if( empty($type) || !is_string($plugin_slug) ) {
				throw new Exception('Empty type or plugin_slug attribute.');
			}
			$this->type = $type;
			$this->plugin_slug = $plugin_slug;

			if( $this->type == 'wordpress' ) {
				if( strpos(rtrim(trim($this->plugin_slug)), '/') !== false ) {
					$this->base_path = $this->plugin_slug;
					$base_path_parts = explode('/', $this->base_path);
					if( sizeof($base_path_parts) === 2 ) {
						$this->plugin_slug = $base_path_parts[0];
					}
				} else {
					$this->base_path = $this->getPluginBasePathBySlug($this->plugin_slug);
				}

				$this->buildWordpress();
			} else if( $this->type == 'internal' ) {
				$this->buildInternal();
			} else if( $this->type == 'freemius' ) {
				$this->buildFreemius();
			} else {
				throw new Exception('Invalid button type.');
			}

			// Set default data
			$this->addData('storage', $this->type);
			$this->addData('i18n', WCL_Helper::getEscapeJson($this->getI18n()));
			$this->addData('wpnonce', wp_create_nonce('updates'));
		}

		/**
		 * @return bool
		 */
		public function isPluginActivate()
		{
			if( $this->type == 'wordpress' && $this->isPluginInstall() ) {
				require_once ABSPATH . '/wp-admin/includes/plugin.php';
				return is_plugin_active($this->base_path);
			} elseif( $this->type == 'internal' ) {
				$preinsatall_components = WCL_Plugin::app()->getPopulateOption('deactive_preinstall_components', array());

				return !in_array($this->plugin_slug, $preinsatall_components);
			} elseif( $this->type == 'freemius' ) {
				$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
				return in_array( $this->plugin_slug, $freemius_activated_addons );
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public function isPluginInstall()
		{
			if( $this->type == 'wordpress' ) {
				if( empty($this->base_path) ) {
					return false;
				}

				// Check if the function get_plugins() is registered. It is necessary for the front-end
				// usually get_plugins() only works in the admin panel.
				if( !function_exists('get_plugins') ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$plugins = get_plugins();

				if( isset($plugins[$this->base_path]) ) {
					return true;
				}
			} else if( $this->type == 'internal' ) {
				return true;
			} else if( $this->type == 'freemius' ) {
				$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
				return in_array( $this->plugin_slug, $freemius_activated_addons );
			}

			return false;
		}

		/**
		 * @param $class
		 * @throws Exception
		 */
		public function addClass($class)
		{
			if( !is_string($class) ) {
				throw new Exception('Attribute class must be a string.');
			}
			$this->classes[] = $class;
		}

		/**
		 * @param $class
		 * @return bool
		 * @throws Exception
		 */
		public function removeClass($class)
		{
			if( !is_string($class) ) {
				throw new Exception('Attribute class must be a string.');
			}
			$key = array_search($class, $this->classes);
			if( isset($this->classes[$key]) ) {
				unset($this->classes[$key]);

				return true;
			}

			return false;
		}

		/**
		 * @param $name
		 * @param $value
		 * @throws Exception
		 */
		public function addData($name, $value)
		{
			if( !is_string($name) || !is_string($value) ) {
				throw new Exception('Attributes name and value must be a string.');
			}

			$this->data[$name] = $value;
		}

		/**
		 * @param $name
		 * @return bool
		 * @throws Exception
		 */
		public function removeData($name)
		{
			if( !is_string($name) ) {
				throw new Exception('Attribute name must be a string.');
			}

			if( isset($this->data[$name]) ) {
				unset($this->data[$name]);

				return true;
			}

			return false;
		}

		/**
		 * @return string
		 */
		public function getButton()
		{
			$i18n = $this->getI18n();
			
			if( $this->type == 'freemius' ) {
				if ( $this->action == 'read' and isset( $this->url ) ) {
					$button = '<a target="_blank" href="' .esc_attr( $this->url ) . '" class="button button-default install-now">' . $i18n[$this->action] . '</a>';
					return $button;
				}
			}

			$button = '<a href="#" class="' . implode(' ', $this->getClasses()) . '" ' . implode(' ', $this->getData()) . '>' . $i18n[$this->action] . '</a>';

			return $button;
		}

		/**
		 * @return string
		 * @throws Exception
		 */
		public function getLink()
		{
			$this->removeClass('button');
			$this->removeClass('button-default');
			$this->removeClass('button-primary');

			//$this->addClass('link');
			$this->addClass('button-link');

			return $this->getButton();
		}

		/**
		 * Print install button
		 */
		public function renderButton()
		{
			echo $this->getButton();
		}

		/**
		 * Print install link
		 */
		public function renderLink()
		{
			echo $this->getLink();
		}

		/**
		 * @return array
		 */
		protected function getData()
		{
			$data_to_print = array();

			foreach((array)$this->data as $key => $value) {
				$data_to_print[$key] = 'data-' . esc_attr($key) . '="' . esc_attr($value) . '"';
			}

			return $data_to_print;
		}

		/**
		 * @return array
		 */
		protected function getClasses()
		{
			return array_map('esc_attr', $this->classes);
		}

		protected function buildWordpress()
		{
			if( $this->type != 'wordpress' || empty($this->base_path) ) {
				return;
			}

			$this->action = 'install';

			if( $this->isPluginInstall() ) {
				$this->action = 'deactivate';
				if( !$this->isPluginActivate() ) {
					$this->action = 'activate';
				}
			}

			$this->addData('plugin-action', $this->action);
			$this->addData('slug', $this->plugin_slug);
			$this->addData('plugin', $this->base_path);

			if( $this->action == 'activate' ) {
				$this->addClass('button-primary');
			} else {
				$this->addClass('button-default');
			}
		}

		protected function buildInternal()
		{
			if( $this->type != 'internal' ) {
				return;
			}

			$this->action = 'activate';

			if( $this->isPluginActivate() ) {
				$this->action = 'deactivate';
			}

			$this->addData('plugin-action', $this->action);
			$this->addData('plugin', $this->plugin_slug);

			if( $this->action == 'activate' ) {
				$this->addClass('button-primary');
			} else {
				$this->addClass('button-default');
			}
		}

		protected function buildFreemius()
		{
			if( $this->type != 'freemius' ) {
				return;
			}

			$this->action = 'activate';

			$licensing = WCL_Licensing::instance();
			
			$component = $licensing->getAddonData( $this->plugin_slug );

			if ( $component['is_free'] ) {
				// если аддон бесплатный
				if ( $component['is_actived'] ) {
					$this->action = 'deactivate';
				}
			} else {
				// если аддон НЕ бесплатный
				if ( $licensing->isLicenseValid() ) {
					// если лицензия валидна, то аддон можно установить
					if ( $component['is_actived'] ) {
						$this->action = 'deactivate';
					}
				} else {
					if ( $component['is_actived'] ) {
						// если лицензия не валидна, но аддон уже был активирован
						$this->action = 'deactivate';
					} else {
						// если лицензия не валидна, то показываем ссылку на страницу аддона
						$this->action = 'read';
						$this->url = $component['url'];
					}
				}
			}

			$this->addData('plugin-action', $this->action);
			$this->addData('plugin', $this->plugin_slug);

			if( $this->action == 'activate' ) {
				$this->addClass('button-primary');
			} else {
				$this->addClass('button-default');
			}
		}

		protected function getI18n()
		{
			return array(
				'activate' => __('Activate', 'clearfy'),
				'install' => __('Install', 'clearfy'),
				'deactivate' => __('Deactivate', 'clearfy'),
				'delete' => __('Delete', 'clearfy'),
				'loading' => __('Please wait...', 'clearfy'),
				'preparation' => __('Preparation...', 'clearfy'),
				'read' => __('Read more', 'clearfy')
			);
		}


		/**
		 * Allows you to get the base path to the plugin in the directory wp-content/plugins/
		 *
		 * @param $slug - slug for example "clearfy", "hide-login-page"
		 * @return int|null|string - "clearfy/clearfy.php"
		 */
		protected function getPluginBasePathBySlug($slug)
		{
			// Check if the function get_plugins() is registered. It is necessary for the front-end
			// usually get_plugins() only works in the admin panel.
			if( !function_exists('get_plugins') ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugins = get_plugins();

			foreach($plugins as $base_path => $plugin) {
				if( strpos($base_path, rtrim(trim($slug))) !== false ) {
					return $base_path;
				}
			}

			return null;
		}
	}

