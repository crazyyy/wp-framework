<?php
/**
 * The boot file is needed to connect backend files, as well as register hooks.
 * Some hooks are so small that it does not make sense to put them into a file
 * or put them into a specific group of code.
 *
 * I usually register administrator notifications, create handlers before saving
 * plugin settings or after, register options in the Clearfy plugin.
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright Webcraftic
 * @version 1.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Выводит кнопку настроек Clearfy в шапке интерфейса плагина
 */
add_action( 'wbcr/factory/pages/impressive/header', function ( $plugin_name ) {
	if ( $plugin_name != WCL_Plugin::app()->getPluginName() ) {
		return;
	}
	?>
    <a href="<?= WCL_Plugin::app()->getPluginPageUrl( 'clearfy_settings' ) ?>" class="wbcr-factory-button wbcr-factory-type-settings">
		<?= apply_filters( 'wbcr/clearfy/settings_button_title', __( 'Clearfy settings', 'clearfy' ) ); ?>
    </a>
	<?php
} );

/**
 * Этот код обманывает Wordpress, убеждая его, что плагин имеет новую версию,
 * из-за чего Wordpress создает уведомление об обновлении плагина. Все это необходимо
 * для обновления пакета компонентов
 *
 * @param mixed $transient - value of site transient.
 */
add_filter( 'site_transient_update_plugins', function ( $transient ) {
	if ( empty( $transient->checked ) ) {
		return $transient;
	}
	
	$package_plugin = WCL_Package::instance();
	
	if ( ! $package_plugin->isActive() ) {
		return $transient;
	}
	
	$need_update_package = $package_plugin->isNeedUpdate();
	$need_update_addons  = $package_plugin->isNeedUpdateAddons();
	$info                = $package_plugin->info();
	
	if ( $need_update_package and $need_update_addons ) {
		$update_data                                 = new stdClass();
		$update_data->slug                           = $info['plugin_slug'];
		$update_data->plugin                         = $info['plugin_basename'];
		$update_data->new_version                    = '1.1';
		$update_data->package                        = $package_plugin->downloadUrl();
		$transient->response[ $update_data->plugin ] = $update_data;
	}
	
	return $transient;
} );

/**
 * Выводит уведомление внутри интерфейса Clearfy, на всех страницах плагина.
 * Это необходимо, чтоб напомнить пользователю обновить конфигурацию компонентов плагина,
 * иначе вновь активированные компоненты не будет зайдествованы в работе плагина.
 *
 * @param Wbcr_Factory409_Plugin $plugin
 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
 *
 * @return bool
 */
add_action( 'wbcr/factory/pages/impressive/print_all_notices', function ( $plugin, $obj ) {
	// выводим уведомление везде, кроме страницы компонентов. Там выводится отдельно.
	if ( ( WCL_Plugin::app()->getPluginName() != $plugin->getPluginName() ) || ( $obj->id == 'components' ) ) {
		return false;
	}
	$package_plugin        = WCL_Package::instance();
	$package_update_notice = $package_plugin->getUpdateNotice();
	
	if ( $package_update_notice ) {
		$obj->printWarningNotice( $package_update_notice );
	}
}, 10, 2 );

/**
 * Выводит уведомление в строке плагина Clearfy (на странице плагинов),
 * что нужно обновить пакет компонентов.
 *
 * @see WP_Plugins_List_Table
 *
 * @param string $plugin_file
 * @param array $plugin_data
 * @param string $status
 *
 * @return bool
 */
add_action( 'after_plugin_row_clearfy/clearfy.php', function ( $plugin_file, $plugin_data, $status ) {
	$package_plugin      = WCL_Package::instance();
	$need_update_package = $package_plugin->isNeedUpdate();
	
	if ( $need_update_package ) {
		if ( $package_plugin->isNeedUpdateAddons() ) {
			$update_link = ' <a href="#" data-wpnonce="' . wp_create_nonce( 'package' ) . '" data-loading="' . __( 'Update in progress...', 'clearfy' ) . '" data-ok="' . __( 'Components have been successfully updated!', 'clearfy' ) . '" class="wbcr-clr-plugin-update-link">' . __( 'update now', 'clearfy' ) . '</a>';
			?>
            <tr class="plugin-update-tr active update">
                <td colspan="3" class="plugin-update colspanchange">
                    <div class="update-message notice inline notice-warning notice-alt" style="background-color:#f5e9f5;border-color: #dab9da;">
                        <p><?= __( 'Updates are available for one of the components.', 'clearfy' ) . $update_link; ?></p>
                    </div>
                </td>
            </tr>
			<?php
		}
	}
}, 100, 3 );

/**
 * @param $form
 * @param Wbcr_Factory409_Plugin $plugin
 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
 */
function wbcr_clearfy_multisite_before_save( $form, $plugin, $obj ) {
	
	if ( $plugin->isNetworkActive() ) {
		$licensing = WCL_Licensing::instance();
		if ( ! $licensing->isLicenseValid() && WCL_Plugin::app()->isNetworkActive() && $plugin->getPluginName() == WCL_Plugin::app()->getPluginName() ) {
			$obj->redirectToAction( 'multisite-pro' );
		}
	}
}

add_action( 'wbcr/factory/pages/impressive/before_form_save', 'wbcr_clearfy_multisite_before_save', 10, 3 );

/**
 * Устанавливает логотип Webcraftic и сборку плагина для Clearfy и всех его компонентов
 *
 * @param string $title
 *
 * @since 1.4.0
 */
function wbcr_clearfy_branding( $title ) {
	$licensing = WCL_Licensing::instance();
	
	return 'Webcraftic Clearfy ' . ( $licensing->isLicenseValid() ? '<span class="wbcr-clr-logo-label wbcr-clr-premium-label-logo">' . __( 'Business', 'clearfy' ) . '</span>' : '<span class="wbcr-clr-logo-label wbcr-clr-free-label-logo">Free</span>' ) . ' ver';
}

add_action( 'wbcr/factory/pages/impressive/plugin_title', 'wbcr_clearfy_branding' );

/**
 * Подключаем скрипты отвественные за обновления пакетов для Clearfy
 * Скрипты подключа.тся на каждой странице Clearfy и его компонентов
 *
 * @param string $page_id
 * @param Wbcr_Factory409_ScriptList $scripts
 * @param Wbcr_Factory409_StyleList $styles
 *
 * @since 1.4.0
 */
function wbcr_clearfy_enqueue_global_scripts( $page_id, $scripts, $styles ) {
	$scripts->add( WCL_PLUGIN_URL . '/admin/assets/js/update-package.js', array(
		'jquery',
		'wbcr-factory-clearfy-206-global'
	) );
}

add_action( 'wbcr/clearfy/page_assets', 'wbcr_clearfy_enqueue_global_scripts', 10, 3 );

/**
 * Подключаем скрипты для установки компонентов Clearfy
 * на все страницы админпанели
 */
add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style( 'wbcr-clearfy-install-components', WCL_PLUGIN_URL . '/admin/assets/css/install-addons.css', array(), WCL_Plugin::app()->getPluginVersion() );
	wp_enqueue_script( 'wbcr-clearfy-install-components', WCL_PLUGIN_URL . '/admin/assets/js/install-addons.js', array(
		'jquery',
		'wbcr-factory-clearfy-206-global'
	), WCL_Plugin::app()->getPluginVersion() );
} );

/**
 * Выводит уведомление, что нужно сбросить постоянные ссылки.
 * Уведомление будет показано на всех страницах Clearfy и его компонентах.
 *
 * @param WCL_Plugin $plugin
 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
 *
 * @return bool
 */
function wbcr_clearfy_print_notice_rewrite_rules( $plugin, $obj ) {
	if ( WCL_Plugin::app()->getPopulateOption( 'need_rewrite_rules' ) ) {
		$obj->printWarningNotice( sprintf( '<span class="wbcr-clr-need-rewrite-rules-message">' . __( 'When you deactivate some components, permanent links may work incorrectly. If this happens, please, <a href="%s">update the permalinks</a>, so you could complete the deactivation.', 'clearfy' ), admin_url( 'options-permalink.php' ) ) . '</span>' );
	}
}

add_action( 'wbcr/factory/pages/impressive/print_all_notices', 'wbcr_clearfy_print_notice_rewrite_rules', 10, 2 );

/**
 * Удалем уведомление Clearfy о том, что нужно перезаписать постоянные ссылоки.s
 */
function wbcr_clearfy_flush_rewrite_rules() {
	WCL_Plugin::app()->deletePopulateOption( 'need_rewrite_rules', 1 );
}

add_action( 'flush_rewrite_rules_hard', 'wbcr_clearfy_flush_rewrite_rules' );

/**
 * Обновить постоынные ссылки, после выполнения быстрых настроек
 *
 * @param WHM_Plugin $plugin
 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
 */
function wbcr_clearfy_after_form_save( $plugin, $obj ) {
	if ( ! WCL_Plugin::app()->currentUserCan() ) {
		return;
	}
	$is_clearfy = WCL_Plugin::app()->getPluginName() == $plugin->getPluginName();
	
	if ( $is_clearfy && $obj->id == 'quick_start' && isset( $_GET['action'] ) && $_GET['action'] == 'flush-cache-and-rules' ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		flush_rewrite_rules( true );
	}
}

add_action( 'wbcr/factory/pages/impressive/after_form_save', 'wbcr_clearfy_after_form_save', 10, 2 );

/**
 * Fake stubs for the Clearfy plugin board
 */
function wbcr_clearfy_fake_boards() {
	if ( ! defined( 'WIO_PLUGIN_ACTIVE' ) ) {
		?>
        <div class="wio-image-optimize-board wbcr-clearfy-board">
            <h4 class="wio-text-left"><?php _e( 'Images optimization', 'clearfy' ); ?></h4>
            <div class="wio-columns wio-widget">
                <div class="wio-col col-chart">
                    <div class="wio-chart-container wio-overview-chart-container">
                        <canvas id="wio-main-chart" width="110" height="110" data-unoptimized="1400" data-optimized="0" data-errors="0" style="display: block;"></canvas>
                        <div id="wio-overview-chart-percent" class="wio-chart-percent">0<span>%</span></div>
                    </div>
                    <div id="wio-overview-chart-legend">
                        <ul class="wio-doughnut-legend">
                            <li>
                                <span style="background-color:#d6d6d6"></span><?php _e( 'Unoptimized', 'clearfy' ); ?>
                                -
                                <span class="wio-num" id="wio-unoptimized-num">1400</span>
                            </li>
                            <li>
                                <span style="background-color:#8bc34a"></span><?php _e( 'Optimized', 'clearfy' ); ?>
                                -
                                <span class="wio-num" id="wio-optimized-num">0</span>
                            </li>
                            <li>
                                <span style="background-color:#f1b1b6"></span><?php _e( 'Error', 'clearfy' ); ?>
                                -
                                <span class="wio-num" id="wio-error-num">0</span>
                            </li>
                        </ul>
                    </div>
                    <div class="wio-bars">
                        <p><?php _e( 'Original size', 'clearfy' ); ?></p>
                        <div class="wio-bar-negative base-transparent wio-right-outside-number">
                            <div id="wio-original-bar" class="wio-progress" style="width: 100%">
                                <span class="wio-barnb" id="wio-original-size">75 MB</span>
                            </div>
                        </div>
                        <p><?php _e( 'Optimized size', 'clearfy' ); ?></p>
                        <div class="wio-bar-primary base-transparent wio-right-outside-number">
                            <div id="wio-optimized-bar" class="wio-progress" style="width: 100%;">
                                <span class="wio-barnb" id="wio-optimized-size">75 MB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="wio-widget-bottom">
                    <li>
                        <p>
                            <a type="button" id="wio-start-optimization" href="<?= WCL_Plugin::app()->getPluginPageUrl( 'clrf_image_optimization' ) ?>" class="wio-optimize-button"><?php echo __( 'Bulk optimize', 'clearfy' ); ?></a>
                        </p>
                    </li>
                    <li>
                        <div class="factory-dropdown factory-from-control-dropdown factory-buttons-way" data-way="buttons">
                            <div id="wio-level-buttons" class="btn-group factory-buttons-group">
                                <button type="button" data-level="normal" class="btn btn-default btn-small active"><?php _e( 'Normal', 'clearfy' ); ?></button>
                                <button type="button" data-level="aggresive" class="btn btn-default btn-small"><?php _e( 'Medium', 'clearfy' ); ?></button>
                                <button type="button" data-level="ultra" class="btn btn-default btn-small"><?php _e( 'High', 'clearfy' ); ?></button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
		<?php
	}
}

add_action( 'wbcr_clearfy_quick_boards', 'wbcr_clearfy_fake_boards' );

/**
 * Widget with the offer to buy Clearfy Business
 *
 * @param array $widgets
 * @param string $position
 * @param Wbcr_Factory409_Plugin $plugin
 */

add_filter( 'wbcr/factory/pages/impressive/widgets', function ( $widgets, $position, $plugin ) {
	if ( $plugin->getPluginName() == WCL_Plugin::app()->getPluginName() ) {
		
		require_once WCL_PLUGIN_DIR . '/admin/includes/sidebar-widgets.php';
		
		$licensing = WCL_Licensing::instance();
		
		if ( $licensing->isLicenseValid() ) {
			unset( $widgets['donate_widget'] );
			
			if ( $position == 'right' ) {
				unset( $widgets['businnes_suggetion'] );
				unset( $widgets['rating_widget'] );
				unset( $widgets['info_widget'] );
			}
			
			if ( $position == 'bottom' ) {
				$widgets['support'] = wbcr_clearfy_get_sidebar_support_widget();
			}
			
			return $widgets;
		} else {
			if ( $position == 'right' ) {
				unset( $widgets['info_widget'] );
				unset( $widgets['rating_widget'] );
				$widgets['support'] = wbcr_clearfy_get_sidebar_support_widget();
			}
		}
		
		if ( $position == 'bottom' ) {
			$widgets['donate_widget'] = wbcr_clearfy_get_sidebar_premium_widget();
		}
	}
	
	return $widgets;
}, 10, 3 );




