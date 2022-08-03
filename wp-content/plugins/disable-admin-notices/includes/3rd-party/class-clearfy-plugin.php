<?php
/**
 * Disable admin notices core class
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

class WDN_Plugin {

	/**
	 * @var WCL_Plugin
	 */
	private static $app;

	/**
	 * Конструктор
	 * Вы
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @throws \Exception
	 */
	public function __construct() {
		if ( ! class_exists( 'WCL_Plugin' ) ) {
			throw new Exception( 'Plugin Clearfy is not installed!' );
		}

		self::$app = WCL_Plugin::app();

		$this->globalScripts();

		if ( is_admin() ) {
			$this->adminScripts();
		}
	}

	/**
	 * @return WCL_Plugin
	 */
	public static function app() {
		return self::$app;
	}

	/**
	 * Выполняет сценарии, которые должны быть запущены только в бекенде
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	private function adminScripts() {
		require( WDN_PLUGIN_DIR . '/admin/options.php' );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			require( WDN_PLUGIN_DIR . '/admin/ajax/hide-notice.php' );
			require( WDN_PLUGIN_DIR . '/admin/ajax/restore-notice.php' );
		}

		require( WDN_PLUGIN_DIR . '/admin/boot.php' );
	}

	/**
	 * Выполняет сценрии, которые должны быть запущены глобально
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 */
	private function globalScripts() {
		require( WDN_PLUGIN_DIR . '/includes/classes/class-configurate-notices.php' );
		new WDN_ConfigHideNotices( self::$app );
	}
}