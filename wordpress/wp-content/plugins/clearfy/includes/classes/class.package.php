<?php

class WCL_Package {
	
	private static $instance = null;
	private $packages = array();
	
	private $is_need_update_addons = false;
	
	private $plugin_slug = 'clearfy-package';
	
	private $plugin_dir = 'clearfy_package';
	
	private $plugin_basename = ''; // заполняется в конструкторе
	
	private $builder_url = 'https://clearfy.pro/package/';
	
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	private function __clone() {
	}
	
	private function __construct() {
		$this->plugin_basename = $this->plugin_dir . '/' . $this->plugin_slug . '.php';
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}
	}
	
	public function info() {
		return array(
			'plugin_basename' => $this->plugin_basename,
			'plugin_slug'     => $this->plugin_basename,
		);
	}
	
	public function add( $packages = array() ) {
		if ( ! $packages ) {
			return false;
		}
		foreach ( $packages as $package ) {
			$key                    = $package['slug'];
			$this->packages[ $key ] = $package;
		}
	}
	
	public function getAll() {
		return $this->packages;
	}
	
	public function getSlugs() {
		$slugs = array();
		if ( $this->packages ) {
			foreach ( $this->packages as $package ) {
				$slugs[] = $package['slug'];
			}
		}
		
		return $slugs;
	}
	
	public function getAddon( $slug ) {
		if ( isset( $this->packages[ $slug ] ) ) {
			return $this->packages[ $slug ];
		}
		
		return false;
	}
	
	public function isActive() {
		return is_plugin_active( $this->plugin_basename );
	}
	
	public function isInstalled() {
		if ( file_exists( WP_PLUGIN_DIR . '/' . $this->plugin_basename ) ) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Метод проверяет, нужно ли обновлять сами аддоны
	 *
	 * @return bool
	 */
	public function isNeedUpdateAddons() {
		return $this->is_need_update_addons;
	}
	
	/**
	 * Метод проверяет, нужно ли обновлять весь пакет в целом.
	 * Пакет может быть обновлен по двум причинам:
	 * 1) Активирован аддон, которого ещё нет в пакете(или пакет не установлен)
	 * 2) Для аддонов проявились новые версии
	 *
	 * @return bool
	 */
	public function isNeedUpdate() {
		$need_update_package       = false;
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		
		if ( $this->isActive() ) {
			// если плагин clearfy-package установлен, то проверяем в нём наличие фримиус аддонов
			$addons               = $this->getAll();
			$licensing            = WCL_Licensing::instance();
			$freemius_addons_data = $licensing->getAddons();
			foreach ( $freemius_activated_addons as $freemius_active_addon ) {
				if ( isset( $addons[ $freemius_active_addon ] ) ) {
					// проверяем, актуальна ли версия аддона
					foreach ( $freemius_addons_data->plugins as $freemius_addon ) {
						if ( $freemius_addon->slug != $freemius_active_addon ) {
							continue;
						}
						// если во фримиусе не указана версия, то делаем её равной текущей версии аддона. Для того, чтобы уведомление об обновлении вечно не висело.
						$actual_version = isset( $freemius_addon->info ) ? $freemius_addon->info->selling_point_0 : '';
						if ( ! $actual_version ) {
							$actual_version = $addons[ $freemius_active_addon ]['current_version'];
						}
						if ( version_compare( $actual_version, $addons[ $freemius_active_addon ]['current_version'], '>' ) ) {
							$this->is_need_update_addons = true;
							$need_update_package         = true;
						}
					}
				} else {
					$need_update_package = true;
				}
			}
		} else {
			// если плагин clearfy-package НЕ установлен, то любая активация фримиус аддона требует обновления пакета
			if ( count( $freemius_activated_addons ) ) {
				$need_update_package = true;
			}
		}
		
		return $need_update_package;
	}
	
	public function active() {
		// если плагин установлен и не активирован, то активируем
		if ( $this->isInstalled() and ! $this->isActive() ) {
			if ( WCL_Plugin::app()->isNetworkActive() ) {
				activate_plugin( $this->plugin_basename, '', true );
			} else {
				activate_plugin( $this->plugin_basename );
			}
		}
	}
	
	public function deactive() {
		// если плагин установлен и не активирован, то активируем
		if ( $this->isInstalled() and $this->isActive() ) {
			if ( WCL_Plugin::app()->isNetworkActive() ) {
				deactivate_plugins( $this->plugin_basename, false, true );
			} else {
				deactivate_plugins( $this->plugin_basename );
			}
		}
	}
	
	public function downloadUrl() {
		$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
		$licensing                 = WCL_Licensing::instance();
		$package_slugs             = array();
		
		if ( $this->isActive() ) {
			$package_slugs = $this->getSlugs();
			foreach ( $freemius_activated_addons as $freemius_addon ) {
				if ( ! in_array( $freemius_addon, $package_slugs ) ) {
					$package_slugs[] = $freemius_addon;
				}
			}
		}
		if ( ! $package_slugs ) {
			$package_slugs = $freemius_activated_addons;
		}
		//$package_slugs[] = 'test-addon'; // для тестирования ошибки. Сборщик не отдаст архив
		$url = $this->builder_url . 'assembly-package.php?addons=' . join( ',', $package_slugs );
		if ( $licensing->isLicenseValid() ) {
			$storage     = $licensing->getStorage();
			$license     = $storage->getLicense();
			$site        = $storage->getSite();
			$license_id  = isset( $license->id ) ? $license->id : '';
			$license_key = isset( $license->secret_key ) ? $license->secret_key : '';
			$install_id  = isset( $site->site_id ) ? $site->site_id : '';
			$url         .= '&license_id=' . $license_id . '&license_key=' . urlencode( $license_key ) . '&install_id=' . $install_id;
		}
		
		return $url;
	}
	
	/**
	 * @return array|bool|false|WP_Error
	 * @throws Exception
	 */
	public function update() {
		global $wp_filesystem;
		
		if ( ! WCL_Plugin::app()->currentUserCan() ) {
			return new WP_Error( 'addon_install_error', __( 'Sorry, you are not allowed to install plugins on this site.' ) );
		}
		
		$url = $this->downloadUrl();
		
		if ( ! $wp_filesystem ) {
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			WP_Filesystem();
		}
		
		if ( ! WP_Filesystem( false, WP_PLUGIN_DIR ) ) {
			throw new Exception( 'You are not allowed to edt folders/files on this site' );
		} else {
			ob_start();
			
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/misc.php' );
			require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
			require_once( WCL_PLUGIN_DIR . '/admin/includes/classes/class.upgrader-skin.php' );
			require_once( WCL_PLUGIN_DIR . '/admin/includes/classes/class.upgrader.php' );
			
			add_filter( 'async_update_translation', '__return_false', 1 );
			
			$upgrader = new WCL_Plugin_Upgrader( new WCL_Upgrader_Skin );
			
			if ( $this->isInstalled() ) {
				$result = $upgrader->run( array(
					'package'           => $url,
					'destination'       => WP_PLUGIN_DIR,
					'clear_destination' => true,
					'clear_working'     => true,
					'hook_extra'        => array(
						'plugin' => $this->plugin_basename,
						'type'   => 'plugin',
						'action' => 'update',
					),
				) );
			} else {
				$result = $upgrader->install( $url );
			}
			
			if ( is_wp_error( $result ) ) {
				return $result;
			}
			
			$this->active();
			
			ob_end_clean();
			
			if ( null === $result ) {
				return new WP_Error( 'addon_install_error', 'An unknown error occurred during the delivery of the component package. Please report this problem to our support team <b>wordpress.webraftic@gmail.com</b>' ); // пока думаю как получать сообщение об ошибке с сервера
			}
			
			return $result;
		}
	}
	
	public function getUpdateNotice() {
		$need_update_package = $this->isNeedUpdate();
		$message             = '';
		if ( $need_update_package ) {
			if ( $this->isNeedUpdateAddons() ) {
				// доступны обновления компонентов
				$message = __( 'Updates are available for one of the components. Please, update your current package of components to the newest version.', 'clearfy' );
			} else {
				// нужно обновить весь пакет
				$message = __( 'You’ve changed the component configuration. For the further work, please, update the current package of components!', 'clearfy' );
			}
			//$message .= ' <a href="'.admin_url('admin-ajax.php?action=wbcr-clearfy-update-package&_wpnonce=' . wp_create_nonce( 'package' )).'">' . __( 'Update', 'clearfy' ) . '</a>';
			
			$message .= ' <button class="wbcr-clr-update-package button button-default" type="button" data-wpnonce="' . wp_create_nonce( 'package' ) . '" data-loading="' . __( 'Update in progress...', 'clearfy' ) . '">' . __( 'Update now', 'clearfy' ) . '</button>';
			
			return $message;
		}
		
		return false;
	}
	
	public function getActivedAddons() {
		$addons = array();
		if ( $this->isInstalled() ) {
			$package_dir    = WP_PLUGIN_DIR . '/' . $this->plugin_dir;
			$package_config = $package_dir . '/config.php';
			if ( file_exists( $package_config ) ) {
				$packages = require( $package_config );
				$this->add( $packages );
			}
			if ( $this->packages ) {
				$freemius_activated_addons = WCL_Plugin::app()->getPopulateOption( 'freemius_activated_addons', array() );
				foreach ( $this->packages as $addon ) {
					if ( in_array( $addon['slug'], $freemius_activated_addons ) ) {
						$addons[ $addon['slug'] ] = array(
							$addon['class_name'],
							$package_dir . '/components/' . $addon['base_dir']
						);
					}
				}
			}
		}
		
		return $addons;
	}
}
