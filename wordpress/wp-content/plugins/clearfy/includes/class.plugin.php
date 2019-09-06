<?php
/**
 * Clearfy core class
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 19.02.2018, Webcraftic
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCL_Plugin extends Wbcr_Factory409_Plugin {
	
	/**
	 * @var WCL_Plugin
	 */
	private static $app;
	
	public function __construct( $plugin_path, $data ) {
		self::$app = $this;
		
		parent::__construct( $plugin_path, $data );
		
		// Freemius
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/class.storage.php' );
		
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/entities/class.wcl-fs-entity.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/entities/class.wcl-fs-scope-entity.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/entities/class.wcl-fs-user.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/entities/class.wcl-fs-site.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/entities/class.wcl-fs-plugin-license.php' );
		
		require_once( WCL_PLUGIN_DIR . '/includes/freemius/sdk/FreemiusWordPress.php' );
		
		require_once( WCL_PLUGIN_DIR . '/includes/classes/exceptions/class.license-exception.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.licensing.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.package.php' );
		
		if ( is_admin() ) {
			require_once( WCL_PLUGIN_DIR . '/admin/includes/classes/class.option.php' );
			require_once( WCL_PLUGIN_DIR . '/admin/includes/classes/class.group.php' );
			
			require_once( WCL_PLUGIN_DIR . '/admin/activation.php' );
			
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				require( WCL_PLUGIN_DIR . '/admin/ajax/configurate.php' );
				require( WCL_PLUGIN_DIR . '/admin/ajax/import-settings.php' );
				require( WCL_PLUGIN_DIR . '/admin/ajax/install-addons.php' );
				require( WCL_PLUGIN_DIR . '/admin/ajax/update-package.php' );
				require( WCL_PLUGIN_DIR . '/admin/ajax/check-license.php' );
			}
			
			require_once( WCL_PLUGIN_DIR . '/admin/includes/compatibility.php' );
			require_once( WCL_PLUGIN_DIR . '/admin/boot.php' );
		}
		
		$this->setModules();
		
		if ( is_admin() ) {
			$this->initActivation();
		}
		
		$this->setAddons();
		
		$this->globalScripts();
		
		add_action( 'plugins_loaded', array( $this, 'pluginsLoaded' ) );
	}
	
	public static function app() {
		return self::$app;
	}
	
	protected function initActivation() {
		include_once( WCL_PLUGIN_DIR . '/admin/activation.php' );
		$this->registerActivation( 'WCL_Activation' );
	}
	
	protected function setModules() {
		$this->load( array(
			array( 'libs/factory/bootstrap', 'factory_bootstrap_409', 'admin' ),
			array( 'libs/factory/forms', 'factory_forms_410', 'admin' ),
			array( 'libs/factory/pages', 'factory_pages_410', 'admin' ),
			array( 'libs/factory/notices', 'factory_notices_407', 'admin' ),
			array( 'libs/factory/clearfy', 'factory_clearfy_206', 'all' )
		) );
	}
	
	public function setAddons() {
		$addons = array();
		
		if ( $this->isActivateComponent( 'html_minify' ) && ! defined( 'WHTM_PLUGIN_ACTIVE' ) ) {
			$addons['html_minify'] = array(
				'WHTM_Plugin',
				WCL_PLUGIN_DIR . '/components/html-minify/html-minify.php'
			);
		}
		
		if ( $this->isActivateComponent( 'minify_and_combine' ) && ! defined( 'WMAC_PLUGIN_ACTIVE' ) ) {
			$addons['minify_and_combine'] = array(
				'WMAC_Plugin',
				WCL_PLUGIN_DIR . '/components/minify-and-combine/minify-and-combine.php'
			);
		}
		
		// This module is for Cyrillic users only, for other users it should be disabled
		if ( $this->isActivateComponent( 'cyrlitera' ) && ! defined( 'WCTR_PLUGIN_ACTIVE' ) ) {
			$addons['cyrlitera'] = array(
				'WCTR_Plugin',
				WCL_PLUGIN_DIR . '/components/cyrlitera/cyrlitera.php'
			);
		}
		
		if ( $this->isActivateComponent( 'disable_notices' ) && ! defined( 'WDN_PLUGIN_ACTIVE' ) ) {
			$addons['disable_admin_notices'] = array(
				'WDN_Plugin',
				WCL_PLUGIN_DIR . '/components/disable-admin-notices/disable-admin-notices.php'
			);
		}
		
		if ( $this->isActivateComponent( 'updates_manager' ) && ! defined( 'WUPM_PLUGIN_ACTIVE' ) ) {
			$addons['updates_manager'] = array(
				'WUPM_Plugin',
				WCL_PLUGIN_DIR . '/components/updates-manager/webcraftic-updates-manager.php'
			);
		}
		
		if ( $this->isActivateComponent( 'comments_tools' ) && ! defined( 'WCM_PLUGIN_ACTIVE' ) ) {
			$addons['comments_plus'] = array(
				'WCM_Plugin',
				WCL_PLUGIN_DIR . '/components/comments-plus/comments-plus.php'
			);
		}
		
		if ( $this->isActivateComponent( 'assets_manager' ) && ! defined( 'WGZ_PLUGIN_ACTIVE' ) ) {
			$addons['assets_manager'] = array(
				'WGZ_Plugin',
				WCL_PLUGIN_DIR . '/components/assets-manager/gonzales.php'
			);
		}
		
		if ( $this->isActivateComponent( 'ga_cache' ) && ! defined( 'WGA_PLUGIN_ACTIVE' ) ) {
			$addons['ga_cache'] = array(
				'WGA_Plugin',
				WCL_PLUGIN_DIR . '/components/ga-cache/simple_google_analytics.php'
			);
		}
		
		/**
		 * Include plugin components
		 */
		
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.package.php' );
		
		if ( ! defined( 'WCL_PLUGIN_DEBUG' ) || ! WCL_PLUGIN_DEBUG ) {
			
			$package        = WCL_Package::instance();
			$package_addons = $package->getActivedAddons();
			
			if ( ! empty( $package_addons ) ) {
				$incompatible_addons = array();
				
				foreach ( $package_addons as $addon_slug => $addon ) {
					$base_dir = $addon[1];
					
					if ( ! empty( $base_dir ) && file_exists( $base_dir ) ) {
						$addon_info = get_file_data( $base_dir, array(
							'Name'             => 'Plugin Name',
							//'Version' => 'Version',
							'FrameworkVersion' => 'Framework Version',
						), 'plugin' );
						
						if ( ! isset( $addon_info['FrameworkVersion'] ) || ( rtrim( trim( $addon_info['FrameworkVersion'] ) ) != 'FACTORY_409_VERSION' ) ) {
							$incompatible_addons[ $addon_slug ] = array(
								'title' => $addon_info['Name']
							);
						} else {
							$addons[ $addon_slug ] = $addon;
						}
					}
				}
				if ( ! empty( $incompatible_addons ) ) {
					add_filter( 'wbcr_factory_notices_407_list', function ( $notices, $plugin_name ) use ( $incompatible_addons ) {
						if ( $plugin_name != WCL_Plugin::app()->getPluginName() ) {
							return $notices;
						}
						
						$notice_text = '<p>' . __( 'Some components of Clearfy were suspended', 'clearfy' ) . ':</p><ul style="padding-left:30px; list-style: circle">';
						foreach ( $incompatible_addons as $addon ) {
							$notice_text .= '<li>' . sprintf( __( 'Component %s is not compatible with the current version of the plugin Clearfy, you must update the component to the latest version.', 'clearfy' ), $addon['title'] ) . '</li>';
						}
						$update_components_url = wp_nonce_url( $this->getPluginPageUrl( 'components', array( 'action' => 'force-update-components' ) ), 'force_update_componetns' );
						$notice_text           .= '</ul><p><a href="' . $update_components_url . '" class="button">' . __( 'Click here to update the components', 'clearfy' ) . '</a></p>';
						
						$notices[] = array(
							'id'              => 'clearfy_component_is_not_compatibility',
							'type'            => 'error',
							'dismissible'     => false,
							'dismiss_expires' => 0,
							'text'            => $notice_text
						);
						
						return apply_filters( 'wbcr_clearfy_admin_notices', $notices );
					}, 10, 2 );
				}
			}
			//$addons = array_merge($addons, $package_addons);
		}
		
		$this->loadAddons( $addons );
	}
	
	/**
	 * Register pages for wp admin
	 *
	 * @throws Exception
	 */
	private function registerPages() {
		try {
			$this->registerPage( 'WCL_QuickStartPage', WCL_PLUGIN_DIR . '/admin/pages/quick-start.php' );
			$this->registerPage( 'WCL_AdvancedPage', WCL_PLUGIN_DIR . '/admin/pages/advanced.php' );
			$this->registerPage( 'WCL_PerformancePage', WCL_PLUGIN_DIR . '/admin/pages/performance.php' );
			$this->registerPage( 'WCL_PerformanceGooglePage', WCL_PLUGIN_DIR . '/admin/pages/performance-google.php' );
			$this->registerPage( 'WCL_ComponentsPage', WCL_PLUGIN_DIR . '/admin/pages/components.php' );
			$this->registerPage( 'WCL_SeoPage', WCL_PLUGIN_DIR . '/admin/pages/seo.php' );
			$this->registerPage( 'WCL_DoublePagesPage', WCL_PLUGIN_DIR . '/admin/pages/seo-double-pages.php' );
			$this->registerPage( 'WCL_DefencePage', WCL_PLUGIN_DIR . '/admin/pages/defence.php' );
			$this->registerPage( 'WCL_LicensePage', WCL_PLUGIN_DIR . '/admin/pages/license.php' );
			
			if ( $this->isActivateComponent( 'widget_tools' ) ) {
				$this->registerPage( 'WCL_WidgetsPage', WCL_PLUGIN_DIR . '/admin/pages/widgets.php' );
			}
			
			$this->registerPage( 'WCL_ClearfySettingsPage', WCL_PLUGIN_DIR . '/admin/pages/clearfy-settings.php' );
			
			if ( ! defined( 'WIO_PLUGIN_ACTIVE' ) ) {
				$this->registerPage( 'WCL_ImageOptimizationPage', WCL_PLUGIN_DIR . '/admin/pages/image-optimization.php' );
			}
			
			if ( ! defined( 'WHLP_PLUGIN_ACTIVE' ) ) {
				$this->registerPage( 'WCL_HideLoginPage', WCL_PLUGIN_DIR . '/admin/pages/hide-login-page.php' );
			}
		} catch( Exception $e ) {
			throw new Exception( $e->getMessage() );
		}
	}
	
	private function globalScripts() {
		
		require_once( WCL_PLUGIN_DIR . '/includes/boot.php' );
		
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-performance.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-google-performance.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-privacy.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-security.php' );
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-seo.php' );
		
		new WCL_ConfigPerformance( $this );
		new WCL_ConfigGooglePerformance( $this );
		new WCL_ConfigPrivacy( $this );
		new WCL_ConfigSecurity( $this );
		new WCL_ConfigSeo( $this );
	}
	
	public function pluginsLoaded() {
		$this->setTextDomain( 'clearfy', WCL_PLUGIN_DIR );
		
		if ( is_admin() ) {
			$this->registerPages();
		}
		
		require_once( WCL_PLUGIN_DIR . '/includes/classes/class.configurate-advanced.php' );
		new WCL_ConfigAdvanced( $this );
	}
	
	/**
	 * @return bool
	 */
	public function currentUserCan() {
		$permission = $this->isNetworkActive() ? 'manage_network' : 'manage_options';
		
		return current_user_can( $permission );
	}
	
	/**
	 * @param string $component_name
	 *
	 * @return bool
	 */
	public function isActivateComponent( $component_name ) {
		if ( ! is_string( $component_name ) ) {
			return false;
		}
		
		$deactivate_components = $this->getPopulateOption( 'deactive_preinstall_components', array() );
		
		if ( ! is_array( $deactivate_components ) ) {
			$deactivate_components = array();
		}
		
		if ( $deactivate_components && in_array( $component_name, $deactivate_components ) ) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @param string $component_name
	 *
	 * @return bool
	 */
	public function deactivateComponent( $component_name ) {
		if ( ! $this->isActivateComponent( $component_name ) ) {
			return true;
		}
		
		do_action( 'wbcr_clearfy_pre_deactivate_component', $component_name );
		
		$deactivate_components = $this->getPopulateOption( 'deactive_preinstall_components', array() );
		
		if ( ! empty( $deactivate_components ) && is_array( $deactivate_components ) ) {
			$deactivate_components[] = $component_name;
		} else {
			$deactivate_components   = array();
			$deactivate_components[] = $component_name;
		}
		
		$this->updatePopulateOption( 'deactive_preinstall_components', $deactivate_components );
		
		do_action( 'wbcr_clearfy_deactivated_component', $component_name );
		
		return true;
	}
	
	/**
	 * @param string $component_name
	 *
	 * @return bool
	 */
	public function activateComponent( $component_name ) {
		if ( $this->isActivateComponent( $component_name ) ) {
			return true;
		}
		
		do_action( 'wbcr_clearfy_pre_activate_component', $component_name );
		
		$deactivate_components = $this->getPopulateOption( 'deactive_preinstall_components', array() );
		
		if ( ! empty( $deactivate_components ) && is_array( $deactivate_components ) ) {
			$index = array_search( $component_name, $deactivate_components );
			unset( $deactivate_components[ $index ] );
		}
		
		if ( empty( $deactivate_components ) ) {
			$this->deletePopulateOption( 'deactive_preinstall_components' );
		} else {
			$this->updatePopulateOption( 'deactive_preinstall_components', $deactivate_components );
		}
		
		//do_action('wbcr/clearfy/activated_component', $component_name);
		
		return true;
	}
	
	/**
	 * Allows you to get a button to install the plugin component
	 *
	 * @param $component_type
	 * @param $slug
	 *
	 * @return WCL_InstallPluginsButton
	 */
	public function getInstallComponentsButton( $component_type, $slug ) {
		require_once WCL_PLUGIN_DIR . '/admin/includes/classes/class.install-plugins-button.php';
		
		return new WCL_InstallPluginsButton( $component_type, $slug );
	}
	
	/**
	 * Allows you to get a button to delete the plugin component
	 *
	 * @param $component_type
	 * @param $slug
	 *
	 * @return WCL_InstallPluginsButton
	 */
	public function getDeleteComponentsButton( $component_type, $slug ) {
		require_once WCL_PLUGIN_DIR . '/admin/includes/classes/class.install-plugins-button.php';
		require_once WCL_PLUGIN_DIR . '/admin/includes/classes/class.delete-plugins-button.php';
		
		return new WCL_DeletePluginsButton( $component_type, $slug );
	}
	
	/**
	 * Возвращает класс для работы с лицензией
	 *
	 * @return WCL_Licensing
	 */
	public function getLicense() {
		return WCL_Licensing::instance();
	}
}
