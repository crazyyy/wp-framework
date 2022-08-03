<?php
/**
 * Файл использует для реализации коротких сниппетов. Обычно сниппеты относятся к интеграции
 * или каким мелким исправлениям и фиксам в интерфейсе этого плагина.
 *
 * Github: https://github.com/alexkovalevv
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON' ) ) {
	add_filter( 'plugin_row_meta', function ( $links, $file ) {
		if ( $file == WDN_PLUGIN_BASE ) {
			$url     = 'https://clearfy.pro/disable-admin-notices/';
			$url     .= '?utm_source=wordpress.org&utm_campaign=' . WDN_Plugin::app()->getPluginName();
			$links[] = '<a href="' . $url . '" style="color: #FF5722;font-weight: bold;" target="_blank">' . __( 'Get premium plugin', 'disable-admin-notices' ) . '</a>';
		}

		return $links;
	}, 10, 2 );

	/**
	 * Изменяем ссылку по умолчанию на собственную в виджете "Голосу за нас".
	 *
	 * Ссылка ведет на страницу рейтинга в репозитории Wordpress.org
	 * https://wordpress.org/support/plugin/disable-admin-notices/reviews/
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 *
	 * @return string
	 * @since  1.0
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 */
	add_filter( 'wbcr_factory_pages_455_imppage_rating_widget_url', function ( $page_url, $plugin_name ) {
		if ( $plugin_name == WDN_Plugin::app()->getPluginName() ) {
			return 'https://goo.gl/68ucHp';
		}

		return $page_url;
	}, 10, 2 );

	/**
	 * Удаляем лишние виджеты из правого сайдбара в интерфейсе плагина
	 *
	 * - Виджет с премиум рекламой
	 * - Виджет с рейтингом
	 * - Виджет с маркерами информации
	 */
	add_filter( 'wbcr/factory/pages/impressive/widgets', function ( $widgets, $position, $plugin ) {
		if ( WDN_Plugin::app()->getPluginName() == $plugin->getPluginName() && 'right' == $position ) {
			unset( $widgets['business_suggetion'] );
			unset( $widgets['rating_widget'] );
			unset( $widgets['info_widget'] );
		}

		return $widgets;
	}, 20, 3 );
} else {
	/**
	 * Регистрируем опции плагина в Clearfy, чтобы тот мог совершать манипуляции с опциями этого плагина.
	 * Обычно такие манипуляции относятся к быстрым настройкам, сбросу настроек.
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0
	 */
	add_filter( "wbcr_clearfy_group_options", function ( $options ) {
		$options[] = [
			'name'   => 'hide_admin_notices',
			'title'  => __( 'Hide admin notices', 'disable-admin-notices' ),
			'tags'   => [],
			'values' => [ 'hide_admin_notices' => 'only_selected' ]
		];
		$options[] = [
			'name'  => 'show_notices_in_adminbar',
			'title' => __( 'Enable hidden notices in adminbar', 'disable-admin-notices' ),
			'tags'  => []
		];

		return $options;
	} );
}

/**
 * Print admin notice: "Would you like to send them for spam checking?"
 *
 * If user clicked button "Yes, do it", plugin will exec action,
 * that put all unapproved comments to spam check queue.
 */
add_action( 'wbcr/factory/admin_notices', function ( $notices, $plugin_name ) {
	if ( $plugin_name != WDN_Plugin::app()->getPluginName() || 'wbcr_clearfy' === $plugin_name ) {
		return $notices;
	}

	$page_url = 'https://clearfy.pro/disable-admin-notices/';

	$notice_text = sprintf( __( 'Thanks for using the Disable admin notices plugin! If you need support or all the features of the plugin, please buy the pro version <a class="button" href="%s">Get PRO</a>' ), $page_url );

	$notices[] = [
		'id'              => 'wdan_get_premium',
		'type'            => 'success',
		'dismissible'     => true,
		'dismiss_expires' => 0,
		'text'            => '<p><strong>Disable Admin Notices Individually:</strong><br>' . $notice_text . '</p>'
	];

	return $notices;
}, 10, 2 );