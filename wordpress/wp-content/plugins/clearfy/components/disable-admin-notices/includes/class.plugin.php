<?php
	/**
	 * Hide my wp core class
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 19.02.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('WDN_Plugin') ) {
		
		if( !class_exists('WDN_PluginFactory') ) {
			if( defined('LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON') ) {
				class WDN_PluginFactory {
					
				}
			} else {
				class WDN_PluginFactory extends Wbcr_Factory409_Plugin {
					
				}
			}
		}
		
		class WDN_Plugin extends WDN_PluginFactory {
			
			/**
			 * @var Wbcr_Factory409_Plugin
			 */
			private static $app;
			
			/**
			 * @var bool
			 */
			private $as_addon;
			
			/**
			 * @param string $plugin_path
			 * @param array $data
			 * @throws Exception
			 */
			public function __construct($plugin_path, $data)
			{
				$this->as_addon = isset($data['as_addon']);
				
				if( $this->as_addon ) {
					$plugin_parent = isset($data['plugin_parent']) ? $data['plugin_parent'] : null;
					
					if( !($plugin_parent instanceof Wbcr_Factory409_Plugin) ) {
						throw new Exception('An invalid instance of the class was passed.');
					}
					
					self::$app = $plugin_parent;
				} else {
					self::$app = $this;
				}
				
				if( !$this->as_addon ) {
					parent::__construct($plugin_path, $data);
				}

				$this->setModules();
				
				$this->globalScripts();
				
				if( is_admin() ) {
					$this->adminScripts();
				}

				add_action('plugins_loaded', array($this, 'pluginsLoaded'));
			}
			
			/**
			 * @return Wbcr_Factory409_Plugin
			 */
			public static function app()
			{
				return self::$app;
			}

			public function pluginsLoaded()
			{
				self::app()->setTextDomain('disable-admin-notices', WDN_PLUGIN_DIR);
			}

			protected function setModules()
			{
				if( !$this->as_addon ) {
					self::app()->load(array(
						array('libs/factory/bootstrap', 'factory_bootstrap_409', 'admin'),
						array('libs/factory/forms', 'factory_forms_410', 'admin'),
						array('libs/factory/pages', 'factory_pages_410', 'admin'),
						array('libs/factory/clearfy', 'factory_clearfy_206', 'all')
					));
				}
			}
			
			private function registerPages()
			{
				if( $this->as_addon ) {
					return;
				}
				self::app()->registerPage('WDN_NoticesPage', WDN_PLUGIN_DIR . '/admin/pages/notices.php');
				self::app()->registerPage('WDN_MoreFeaturesPage', WDN_PLUGIN_DIR . '/admin/pages/more-features.php');
			}
			
			private function adminScripts()
			{
				require(WDN_PLUGIN_DIR . '/admin/options.php');

				if( defined('DOING_AJAX') && DOING_AJAX ) {
					require(WDN_PLUGIN_DIR . '/admin/ajax/hide-notice.php');
					require(WDN_PLUGIN_DIR . '/admin/ajax/restore-notice.php');
				}

				require(WDN_PLUGIN_DIR . '/admin/boot.php');

				$this->registerPages();
			}
			
			private function globalScripts()
			{
				require(WDN_PLUGIN_DIR . '/includes/classes/class.configurate-notices.php');
				new WDN_ConfigHideNotices(self::$app);
			}
		}
	}