<?php
	/**
	 * Admin page class
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-core
	 * @since 1.0.0
	 */
	
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	if( !class_exists('Wbcr_FactoryPages410_AdminPage') ) {
		
		class Wbcr_FactoryPages410_AdminPage extends Wbcr_FactoryPages410_Page {
			
			/**
			 * Visible page title.
			 * For example: 'License Manager'
			 * @var string
			 */
			public $page_title;
			
			/**
			 * Visible title in menu.
			 * For example: 'License Manager'
			 * @var string
			 */
			public $menu_title = null;
			
			/**
			 * If set, an extra sub menu will be created with another title.
			 * @var string
			 */
			public $menu_sub_title = null;
			
			/**
			 * Menu icon (only if a page is placed as a main menu).
			 * For example: '~/assets/img/menu-icon.png'
			 * For example dashicons: '\f321'
			 * @var string
			 */
			public $menu_icon = null;
			
			/**
			 * Menu position (only if a page is placed as a main menu).
			 * @link http://codex.wordpress.org/Function_Reference/add_menu_page
			 * @var string
			 */
			public $menu_position = null;
			
			/**
			 * Menu type. Set it to add the page to the specified type menu.
			 * For example: 'post'
			 * @var string
			 */
			public $menu_post_type = null;
			
			/**
			 * if specified the page will be added to the given menu target as a submenu.
			 * For example: 'edit.php?post_type=custom-post-type'
			 * @var string
			 */
			public $menu_target = null;
			
			/**
			 * if true, then admin.php is used as a base url.
			 * @var bool
			 */
			public $custom_target = false;
			
			/**
			 * Capabilities for roles that have access to work with this page.
			 * Leave it empty to use inherited capabilities for custom post type menu.
			 * @link http://codex.wordpress.org/Roles_and_Capabilities
			 * @var array An array of the capabilities.
			 */
			public $capabilitiy = null;
			
			/**
			 * If true, the page will not added to the admin menu.
			 * @var bool
			 */
			public $internal = false;

			/**
			 * If true, the page is for network
			 * @var bool
			 */
			public $network = false;
			
			/**
			 * If true, the page will not be cretaed.
			 *
			 * @since 3.0.6
			 * @var bool
			 */
			public $hidden = false;
			
			/**
			 * Link title for plugin action menu
			 *
			 * @var string/null
			 */
			public $title_plugin_action_link = null;
			
			/**
			 * If true, add settings link in plugins list
			 * https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
			 * @var bool
			 */
			public $add_link_to_plugin_actions = false;
			
			public function __construct(Wbcr_Factory409_Plugin $plugin)
			{
				parent::__construct($plugin);
				$this->configure();
				
				$this->id = empty($this->id) ? str_replace('adminpage', '', strtolower(get_class($this))) : $this->id;
				
				if( $this->add_link_to_plugin_actions ) {
					$plugin_path_info = $this->plugin->getPluginPathInfo();

					if( $plugin->isNetworkActive() ) {
						// plugin settings link
						add_filter("network_admin_plugin_action_links_" . $plugin_path_info->relative_path, array(
							$this,
							'addLinkToPluginActions'
						));
					} else {
						// plugin settings link
						add_filter("plugin_action_links_" . $plugin_path_info->relative_path, array(
							$this,
							'addLinkToPluginActions'
						));
					}
				}
			}
			
			/**
			 * May be used to configure the page before uts usage.
			 */
			public function configure()
			{
			}
			
			/**
			 * Includes the Factory Bootstrap assets for a current page.
			 *
			 * @param string $hook
			 * @return void
			 */
			public function actionAdminBootstrapScripts($hook)
			{
				$this->scripts->connect('bootstrap');
				$this->styles->connect('bootstrap');
			}
			
			/**
			 * Includes the assets for a current page (all assets except Factory Bootstrap assets).
			 *
			 * @param string $hook
			 * @return void
			 */
			public function actionAdminScripts($hook)
			{
				$this->scripts->connect();
				$this->styles->connect();
			}

			/**
			 * @return string
			 */
			public function getMenuScope()
			{
				return $this->plugin->getPluginName();
			}


			/**
			 * @return string
			 */
			public function getMenuTitle()
			{
				$menu_title = !$this->menu_title ? $this->page_title : $this->menu_title;

				/**
				 * @since 4.0.9 - добавлен
				 */
				return apply_filters('wbcr/factory/pages/impressive/menu_title', $menu_title, $this->plugin->getPluginName(), $this->id);
			}

			/**
			 * @return string
			 */
			public function getPageTitle()
			{

				$page_title = !$this->page_title ? $this->getMenuTitle() : $this->page_title;

				/**
				 * @since 4.0.9 - добавлен
				 */
				return apply_filters('wbcr/factory/pages/impressive/page_title', $page_title, $this->plugin->getPluginName(), $this->id);
			}
			
			/**
			 * @param null $id
			 * @return mixed|string
			 */
			public function getResultId($id = null)
			{
				$id = !empty($id) ? $id : $this->id;
				
				if( $this->plugin ) {
					return $id . '-' . $this->getMenuScope();
				}
				
				return $id;
			}
			
			/**
			 * Registers admin page for the admin menu.
			 */
			public function connect()
			{
				$result_id = $this->getResultId();
				
				$this->hidden = apply_filters('wbcr_factory_409_page_is_hidden_' . $result_id, $this->hidden);

				if( $this->hidden ) {
					return;
				}
				
				$this->internal = apply_filters('wbcr_factory_409_page_is_internal_' . $result_id, $this->internal);

				if( $this->internal ) {
					$this->menu_target = null;
					$this->menu_post_type = null;
				}
				
				// makes redirect to the page
				$controller = $this->request->get('fy_page', null, true);

				if( $controller && $controller == $this->id ) {
					$plugin = $this->request->get('fy_plugin', null, true);

					if( $this->plugin->getPluginName() == $plugin ) {
						
						$action = $this->request->get('fy_action', 'index', true);
						$is_ajax = $this->request->get('fy_ajax', false);
						
						if( $is_ajax ) {
							$this->executeByName($action);
							exit;
						} else {
							
							$params = (array)$this->request->getAll(true);
							
							unset($params['fy_page']);
							unset($params['fy_plugin']);
							unset($params['fy_action']);
							
							$this->redirectToAction($action, $params);
						}
					}
				}

				// calls scripts and styles, adds pages to menu
				if( $this->request->get('page', 'none') == $result_id ) {
					$this->assets($this->scripts, $this->styles);
					
					if( !$this->scripts->isEmpty('bootstrap') || !$this->styles->isEmpty('bootstrap') ) {
						add_action('wbcr_factory_409_bootstrap_enqueue_scripts_' . $this->plugin->getPluginName(), array(
							$this,
							'actionAdminBootstrapScripts'
						));
					}
					
					// includes styles and scripts
					if( !$this->scripts->isEmpty() || !$this->styles->isEmpty() ) {
						add_action('admin_enqueue_scripts', array($this, 'actionAdminScripts'));
					}
				}
				
				// if this page for a custom menu page
				if( $this->menu_post_type ) {
					$this->menu_target = 'edit.php?post_type=' . $this->menu_post_type;

					if( empty($this->capabilitiy) ) {
						$this->capabilitiy = 'edit_' . $this->menu_post_type;
					}
				}
				
				// sets default capabilities
				if( empty($this->capabilitiy) ) {
					$this->capabilitiy = 'manage_options';
				}

				// submenu
				if( $this->menu_target ) {
					add_submenu_page($this->menu_target, $this->getPageTitle(), $this->getMenuTitle(), $this->capabilitiy, $result_id, array(
						$this,
						'show'
					));
					// global menu
				} else {
					add_menu_page($this->getPageTitle(), $this->getMenuTitle(), $this->capabilitiy, $result_id, array(
						$this,
						'show'
					), null, $this->menu_position);
					
					if( !empty($this->menu_sub_title) ) {
						
						add_submenu_page($result_id, $this->menu_sub_title, $this->menu_sub_title, $this->capabilitiy, $result_id, array(
							$this,
							'show'
						));
					}
					
					add_action('admin_head', array($this, 'actionAdminHead'));
				}

				// executes an action
				if( $this->current() ) {
					ob_start();
					$action = $this->request->get('action', 'index', true);
					$this->executeByName($action);
					$this->result = ob_get_contents();
					ob_end_clean();
				}
			}
			
			protected function current()
			{
				$result_id = $this->getResultId();
				
				if( $result_id == $this->request->get('page', 'none') ) {
					return true;
				}
				
				return false;
			}
			
			/**
			 * @param string $action
			 * @param array $query_args
			 */
			public function redirectToAction($action, $query_args = array())
			{
				
				wp_safe_redirect($this->getActionUrl($action, $query_args));
				exit;
			}
			
			/**
			 * @param string $action
			 * @param array $query_args
			 */
			public function actionUrl($action = null, $query_args = array())
			{
				echo $this->getActionUrl($action, $query_args);
			}
			
			/**
			 * @param null $action
			 * @param array $query_args
			 * @return string
			 */
			public function getActionUrl($action = null, $query_args = array())
			{
				$url = $this->getBaseUrl(null, $query_args);

				if( !empty($action) ) {
					$url = add_query_arg('action', $action, $url);
				}

				return $url;
			}

			/**
			 * @return string
			 */
			public function getBaseUrl($id = null, $query_args = array())
			{
				$result_id = $this->getResultId($id);

				if( $this->menu_target ) {
					$url = $this->network ? network_admin_url($this->menu_target) : admin_url($this->menu_target);

					return add_query_arg(array_merge(array('page' => $result_id), $query_args), $url);
				} else {
					$url = $this->network ? network_admin_url('admin.php') : admin_url('admin.php');

					return add_query_arg(array_merge(array('page' => $result_id, $query_args)), $url);
				}
			}
			
			public function actionAdminHead()
			{
				$result_id = $this->getResultId();
				
				if( !empty($this->menu_icon) ) {
					
					if( preg_match('/\\\f\d{3}/', $this->menu_icon) ) {
						$icon_code = $this->menu_icon;
					} else {
						$plugin_path_info = $this->plugin->getPluginPathInfo();
						$icon_url = str_replace('~/', $plugin_path_info->plugin_url . '/', $this->menu_icon);
					}
				}
				
				global $wp_version;
				
				if( version_compare($wp_version, '3.7.3', '>') ) {
					?>
					<style type="text/css" media="screen">
						<?php if ( !empty($icon_url) ) { ?>
						
						a.toplevel_page_<?php echo $result_id ?> .wp-menu-image {
							background: url('<?php echo $icon_url ?>') no-repeat 10px -30px !important;
						}
						
						<?php } ?>
						
						a.toplevel_page_<?php echo $result_id ?> .wp-menu-image:before {
							content: "<?php echo !empty($icon_code) ? $icon_code : ''; ?>" !important;
						}
						
						a.toplevel_page_<?php echo $result_id ?>:hover .wp-menu-image,
						a.toplevel_page_<?php echo $result_id ?>.wp-has-current-submenu .wp-menu-image,
						a.toplevel_page_<?php echo $result_id ?>.current .wp-menu-image {
							background-position: 10px 2px !important;
						}
					</style>
				<?php } else { ?>
					<style type="text/css" media="screen">
						a.toplevel_page_<?php echo $result_id ?> .wp-menu-image {
							background: url('<?php echo $icon_url ?>') no-repeat 6px -33px !important;
						}
						
						a.toplevel_page_<?php echo $result_id ?>:hover .wp-menu-image,
						a.toplevel_page_<?php echo $result_id ?>.current .wp-menu-image {
							background-position: 6px -1px !important;
						}
					</style>
				<?php
				}
				
				if( $this->internal ) {
					?>
					<style type="text/css" media="screen">
						li.toplevel_page_<?php echo $result_id ?> {
							display: none;
						}
					</style>
				<?php
				}
			}
			
			
			/**
			 * Add settings link in plugins list
			 *
			 * @param $links
			 * @return mixed
			 */
			function addLinkToPluginActions($links)
			{
				$link_title = !empty($this->title_plugin_action_link) ? $this->title_plugin_action_link : $this->getMenuTitle();
				
				$settings_link = '<a href="' . $this->getBaseUrl() . '">' . $link_title . '</a>';
				array_unshift($links, $settings_link);
				
				return $links;
			}
		}
	}