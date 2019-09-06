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

	if( !class_exists('WCM_Plugin') ) {
		
		if( !class_exists('WCM_PluginFactory') ) {
			if( defined('LOADING_COMMENTS_PLUS_AS_ADDON') ) {
				class WCM_PluginFactory {
					
				}
			} else {
				class WCM_PluginFactory extends Wbcr_Factory409_Plugin {
					
				}
			}
		}
		
		class WCM_Plugin extends WCM_PluginFactory {
			
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
				self::app()->setTextDomain('comments-plus', WCM_PLUGIN_DIR);

				if( is_admin() ) {
					$this->registerPages();
				}
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
				$admin_path = WCM_PLUGIN_DIR . '/admin/pages';

				self::app()->registerPage('WbcrCmp_CommentsPage', $admin_path . '/comments.php');
				self::app()->registerPage('WbcrCmp_DeleteCommentsPage', $admin_path . '/delete-comments.php');

				if( !$this->as_addon ) {
					self::app()->registerPage('WbcrCmp_MoreFeaturesPage', $admin_path . '/more-features.php');
				}
			}
			
			private function adminScripts()
			{
				require(WCM_PLUGIN_DIR . '/admin/boot.php');
			}
			
			private function globalScripts()
			{
				require(WCM_PLUGIN_DIR . '/includes/boot.php');
				require(WCM_PLUGIN_DIR . '/includes/classes/class.configurate-comments.php');
				new WbcrCmp_ConfigComments(self::$app);
			}
		}
	}
