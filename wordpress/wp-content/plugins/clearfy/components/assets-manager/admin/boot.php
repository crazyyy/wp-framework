<?php
/**
 * Admin boot
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright Webcraftic 25.05.2017
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'LOADING_ASSETS_MANAGER_AS_ADDON' ) ) {
	
	/**
	 * Уведомление, которое сообщает о возможности импорта опций из плагина Assets manager в Clearfy
	 *
	 * @param array $notices
	 */
	add_filter( 'wbcr_factory_notices_407_list', function ( $notices ) {
		
		if ( is_multisite() && is_network_admin() ) {
			$am_options = get_site_option( 'wbcr_gnz_assets_manager_options' );
		} else {
			$am_options = get_option( 'wbcr_gnz_assets_manager_options' );
		}
		
		if ( $am_options ) {
			$notice_text = '<p><b>Clearfy:</b> ' . __( 'We detected that you used the Assets manager plugin. Do you want to import settings from this plugin to the Clearfy plugin?', 'gonzales' ) . '</p>';
			$notice_text .= '<p><a href="' . admin_url( '?wbcr_assets_manager_transfer' ) . '" class="button button-default">' . __( 'Import options', 'gonzales' ) . '</a></p>';
			
			$notices[] = array(
				'id'              => 'gnz_plugin_import_options',
				'type'            => 'warning',
				'dismissible'     => true,
				'dismiss_expires' => 0,
				'text'            => $notice_text
			);
		}
		
		if ( isset( $_GET['wbcr_assets_manager_transfer_completed'] ) ) {
			$notices[] = array(
				'id'              => 'gnz_plugin_transfer_options_completed',
				'type'            => 'success',
				'dismissible'     => false,
				'dismiss_expires' => 0,
				'text'            => '<p><b>Clearfy:</b> ' . __( 'Settings has been successfully imported!', 'gonzales' )
			);
		}
		
		return $notices;
	}, 10, 2 );
	
	/**
	 * Импорт опций из плагина Assets manager в плагин Clearfy.
	 * При попытке использовать премиум версию, у многих пользователей уже настроен бесплатный плагин и
	 * на ручной перенос настроек уходит очень много времени. Этот кусок кода решает проблему переноса настроек между плагинами.
	 */
	add_action( 'admin_init', function () {
		if ( isset( $_GET['wbcr_assets_manager_transfer'] ) ) {
			global $wpdb;
			
			if ( is_multisite() && is_network_admin() ) {
				$am_options = get_site_option( 'wbcr_gnz_assets_manager_options' );
			} else {
				$am_options = get_option( 'wbcr_gnz_assets_manager_options' );
			}
			
			if ( ! $am_options || ! class_exists( 'WCL_Plugin' ) ) {
				return;
			}
			
			$am_prefix = 'wbcr_gnz_';
			
			if ( is_multisite() && is_network_admin() ) {
				$request = $wpdb->get_results( "SELECT meta_key, meta_value
						FROM {$wpdb->sitemeta}
						WHERE option_name LIKE '{$am_prefix}_%'" );
			} else {
				$request = $wpdb->get_results( "SELECT option_name, option_value
						FROM {$wpdb->options}
						WHERE option_name LIKE '{$am_prefix}_%'" );
			}
			
			if ( $request ) {
				foreach ( (array) $request as $option ) {
					if ( is_multisite() && is_network_admin() ) {
						$new_option_name = str_replace( $am_prefix, WCL_Plugin::app()->getPrefix(), $option->meta_key );
						update_site_option( $new_option_name, $option->meta_value );
						delete_site_option( $option->meta_key );
					} else {
						$new_option_name = str_replace( $am_prefix, WCL_Plugin::app()->getPrefix(), $option->option_name );
						update_option( $new_option_name, $option->option_value );
						delete_option( $option->option_name );
					}
				}
				
				wp_redirect( admin_url( '?wbcr_assets_manager_transfer_completed' ) );
				die();
			}
		}
	} );
	
	/**
	 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
	 *
	 * @param string $component_name
	 */
	add_action( 'wbcr/clearfy/activated_component', function ( $component_name ) {
		if ( $component_name == 'assets_manager' ) {
			if ( class_exists( 'WCL_Plugin' ) ) {
				$license = WCL_Plugin::app()->getLicense();
				if ( ( $license->isLicenseValid() || ( defined( 'WCL_PLUGIN_DEBUG' ) && WCL_PLUGIN_DEBUG ) ) && ! WCL_Plugin::app()->isActivateComponent( 'assets-manager-premium' ) ) {
					WCL_Plugin::app()->activateComponent( 'assets-manager-premium' );
				}
			}
		}
	} );
	
	/**
	 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
	 *
	 * @param string $component_name
	 */
	add_action( 'wbcr_clearfy_deactivated_component', function ( $component_name ) {
		if ( $component_name == 'assets_manager' ) {
			if ( class_exists( 'WCL_Plugin' ) ) {
				$license = WCL_Plugin::app()->getLicense();
				if ( ( $license->isLicenseValid() || ( defined( 'WCL_PLUGIN_DEBUG' ) && WCL_PLUGIN_DEBUG ) ) && WCL_Plugin::app()->isActivateComponent( 'assets-manager-premium' ) ) {
					WCL_Plugin::app()->deactivateComponent( 'assets-manager-premium' );
				}
			}
		}
	} );
	
	function wbcr_gnz_group_options( $options ) {
		$options[] = array(
			'name'   => 'disable_assets_manager',
			'title'  => __( 'Disable assets manager', 'gonzales' ),
			'tags'   => array(),
			'values' => array()
		);
		
		$options[] = array(
			'name'  => 'disable_assets_manager_panel',
			'title' => __( 'Disable assets manager panel', 'gonzales' ),
			'tags'  => array()
		);
		
		$options[] = array(
			'name'  => 'disable_assets_manager_on_front',
			'title' => __( 'Disable assets manager on front', 'gonzales' ),
			'tags'  => array()
		);
		
		$options[] = array(
			'name'  => 'disable_assets_manager_on_backend',
			'title' => __( 'Disable assets manager on back-end', 'gonzales' ),
			'tags'  => array()
		);
		
		$options[] = array(
			'name'  => 'manager_options',
			'title' => __( 'Assets manager options', 'gonzales' ),
			'tags'  => array()
		);
		
		return $options;
	}
	
	add_filter( "wbcr_clearfy_group_options", 'wbcr_gnz_group_options' );
} else {
	
	/**
	 * Удаляем лишние виджеты в левом сайдбаре
	 *
	 * @param array $widgets
	 * @param string $position
	 * @param Wbcr_Factory409_Plugin $plugin
	 */
	add_filter( 'wbcr/factory/pages/impressive/widgets', function ( $widgets, $position, $plugin ) {
		if ( $plugin->getPluginName() == WGZ_Plugin::app()->getPluginName() ) {
			if ( $position == 'right' ) {
				unset( $widgets['donate_widget'] );
				unset( $widgets['rating_widget'] );
				unset( $widgets['info_widget'] );
			}
		}
		
		return $widgets;
	}, 20, 3 );
	
	/**
	 * Заменяем премиум возможности в бизнес виджете
	 *
	 * @param array $features
	 * @param string $page_id
	 * @param string $plugin
	 */
	add_filter( 'wbcr/clearfy/page_bussines_suggetion_features', function ( $features, $plugin_name, $page_id ) {
		
		if ( ! empty( $plugin_name ) && ( $plugin_name == WGZ_Plugin::app()->getPluginName() ) ) {
			$upgrade_feature   = array();
			$upgrade_feature[] = __( 'Disable plugins (groups of scripts)', 'gonzales' );
			$upgrade_feature[] = __( 'Conditions by the link template', 'gonzales' );
			$upgrade_feature[] = __( 'Conditions by the regular expression', 'gonzales' );
			$upgrade_feature[] = __( 'Safe mode', 'gonzales' );
			$upgrade_feature[] = __( 'Statistics and optimization results', 'gonzales' );
			
			return $upgrade_feature;
		}
		
		return $features;
	}, 20, 3 );
	
	function wbcr_gnz_set_plugin_meta( $links, $file ) {
		if ( $file == WGZ_PLUGIN_BASE ) {
			$url     = WbcrFactoryClearfy206_Helpers::getWebcrafticSitePageUrl( WGZ_Plugin::app()->getPluginName(), 'assets-manager', 'plugin_row' );
			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __( 'Get premium', 'gonzales' ) . '</a>';
		}
		
		return $links;
	}
	
	add_filter( 'plugin_row_meta', 'wbcr_gnz_set_plugin_meta', 10, 2 );
	
	function wbcr_gnz_rating_widget_url( $page_url, $plugin_name ) {
		if ( ! defined( 'LOADING_ASSETS_MANAGER_AS_ADDON' ) && ( $plugin_name == WGZ_Plugin::app()->getPluginName() ) ) {
			return 'https://goo.gl/zyNV6z';
		}
		
		return $page_url;
	}
	
	add_filter( 'wbcr_factory_pages_410_imppage_rating_widget_url', 'wbcr_gnz_rating_widget_url', 10, 2 );
}