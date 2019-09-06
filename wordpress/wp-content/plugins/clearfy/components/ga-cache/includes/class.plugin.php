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

	if( !class_exists('WGA_Plugin') ) {
		
		if( !class_exists('WGA_PluginFactory') ) {
			if( defined('LOADING_CYRLITERA_AS_ADDON') ) {
				class WGA_PluginFactory {
					
				}
			} else {
				class WGA_PluginFactory extends Wbcr_Factory409_Plugin {
					
				}
			}
		}
		
		class WGA_Plugin extends WGA_PluginFactory {
			
			/**
			 * @var Wbcr_Factory409_Plugin
			 */
			private static $app;
			
			/**
			 * @var bool
			 */
			private $as_addon;
			
			private $network_active;
			
			/**
			 * @param string $plugin_path
			 * @param array $data
			 * @throws Exception
			 */
			public function __construct($plugin_path, $data)
			{
				$this->as_addon = isset($data['as_addon']);
				
				$this->network_active = (is_multisite() && array_key_exists(WGA_PLUGIN_BASE, (array)get_site_option('active_sitewide_plugins')));
				
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
					$this->initActivation();
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
				self::app()->setTextDomain('simple-google-analytics', WGA_PLUGIN_DIR);
			}

			protected function setModules()
			{
				if( !$this->as_addon ) {
					self::app()->load(array(
						array('libs/factory/bootstrap', 'factory_bootstrap_409', 'admin'),
						array('libs/factory/forms', 'factory_forms_410', 'admin'),
						array('libs/factory/pages', 'factory_pages_410', 'admin'),
						array('libs/factory/notices', 'factory_notices_407', 'admin'),
						array('libs/factory/clearfy', 'factory_clearfy_206', 'all')

					));
				}
			}
			
			public function isNetworkActive()
			{
				if( $this->network_active ) {
					return true;
				}

				return false;
			}

			protected function initActivation()
			{
				require_once(WGA_PLUGIN_DIR . '/admin/activation.php');
				self::app()->registerActivation('WGA_Activation');
			}

			private function registerPages()
			{
				if( $this->as_addon ) {
					return;
				}
				
				if( $this->isNetworkActive() and !is_network_admin() ) {
					return;
				}
				self::app()->registerPage('WGA_CachePage', WGA_PLUGIN_DIR . '/admin/pages/ga_cache.php');
				self::app()->registerPage('WGA_MoreFeaturesPage', WGA_PLUGIN_DIR . '/admin/pages/more-features.php');
			}
			
			private function adminScripts()
			{
				require(WGA_PLUGIN_DIR . '/admin/options.php');
				require(WGA_PLUGIN_DIR . '/admin/boot.php');

				$this->registerPages();
			}
			
			private function globalScripts()
			{
				require(WGA_PLUGIN_DIR . '/includes/classes/class.configurate-ga.php');
				new WGA_ConfigGACache(self::$app);
			}
		}
	}
