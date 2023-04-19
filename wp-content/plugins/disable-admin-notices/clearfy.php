<?php
/**
 * Этот файл инициализирует этот плагин, как аддон для плагина Clearfy.
 *
 * Файл будет подключен только в плагине Clearfy, используя особый вариант загрузки. Это более простое решение
 * пришло на смену встроенной системы подключения аддонов в фреймворке.
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

if ( ! defined( 'WDN_PLUGIN_ACTIVE' ) ) {
	define( 'WDN_PLUGIN_VERSION', '1.3.0' );
	define( 'WDN_TEXT_DOMAIN', 'disable-admin-notices' );
	define( 'WDN_PLUGIN_ACTIVE', true );

	// Этот плагин загружен, как аддон для плагина Clearfy
	define( 'LOADING_DISABLE_ADMIN_NOTICES_AS_ADDON', true );

	if ( ! defined( 'WDN_PLUGIN_DIR' ) ) {
		define( 'WDN_PLUGIN_DIR', dirname( __FILE__ ) );
	}

	if ( ! defined( 'WDN_PLUGIN_BASE' ) ) {
		define( 'WDN_PLUGIN_BASE', plugin_basename( __FILE__ ) );
	}

	if ( ! defined( 'WDN_PLUGIN_URL' ) ) {
		define( 'WDN_PLUGIN_URL', plugins_url( null, __FILE__ ) );
	}

	try {
		// Global scripts
		require_once( WDN_PLUGIN_DIR . '/includes/functions.php' );
		require_once( WDN_PLUGIN_DIR . '/includes/3rd-party/class-clearfy-plugin.php' );
		new WDN_Plugin();
	} catch ( Exception $e ) {
		$wdan_plugin_error_func = function () use ( $e ) {
			$error = sprintf( "The %s plugin has stopped. <b>Error:</b> %s Code: %s", 'Webcraftic Disable Admin Notices', $e->getMessage(), $e->getCode() );
			echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
		};

		add_action( 'admin_notices', $wdan_plugin_error_func );
		add_action( 'network_admin_notices', $wdan_plugin_error_func );
	}
}


