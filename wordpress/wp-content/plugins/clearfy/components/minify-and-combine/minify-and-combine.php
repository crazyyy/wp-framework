<?php
/**
 * Plugin Name: Мinify And Combine
 * Plugin URI: https://clearfy.pro/minify-and-combine/
 * Description: Optimizes your website, concatenating the CSS and JavaScript code, and compressing it.
 * Author: Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 1.0.1
 * Text Domain: minify-and-combine
 * Domain Path: /languages/
 * Author URI: https://clearfy.pro
 * Framework Version: FACTORY_409_VERSION
 */

/*
 * #### CREDITS ####
 * This plugin is based on the plugin Autoptimize by the author Frank Goossens, we have finalized this code for our project and our goals.
 * Many thanks to Frank Goossens for the quality solution for optimizing scripts in Wordpress.
 *
 * Public License is a GPLv2 compatible license allowing you to change and use this version of the plugin for free.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WMAC_PLUGIN_VERSION' ) ) {
	define( 'WMAC_PLUGIN_VERSION', '1.0.1' );
}

// Fix for ithemes sync. When the ithemes sync plugin accepts the request, set the WP_ADMIN constant,
// after which the plugin Clearfy begins to create errors, and how the logic of its work is broken.
// Solution to simply terminate the plugin if there is a request from ithemes sync
// --------------------------------------
if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'ithemes_sync_request' ) {
	return;
}

if ( isset( $_GET['ithemes-sync-request'] ) && ! empty( $_GET['ithemes-sync-request'] ) ) {
	return;
}
// ----------------------------------------

if ( ! defined( 'WMAC_PLUGIN_DIR' ) ) {
	// Директория плагина
	define( 'WMAC_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'WMAC_PLUGIN_BASE' ) ) {
	// Относительный путь к плагину
	define( 'WMAC_PLUGIN_BASE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'WMAC_PLUGIN_URL' ) ) {
	// Ссылка к директории плагина
	define( 'WMAC_PLUGIN_URL', plugins_url( null, __FILE__ ) );
}



if ( ! defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ) ) {
	require_once( WMAC_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php' );
	require_once( WMAC_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php' );
}

$plugin_info = array(
	'prefix'         => 'wbcr_mac_', // префикс для базы данных и полей формы
	'plugin_name'    => 'wbcr_minify_and_combine', // имя плагина, как уникальный идентификатор
	'plugin_title'   => __( 'Webcraftic minify and combine', 'minify-and-combine' ), // заголовок плагина
	'plugin_version' => WMAC_PLUGIN_VERSION, // текущая версия плагина
	'plugin_build'   => 'free', // сборка плагина
	//'updates' => WMAC_PLUGIN_DIR . '/updates/' в этой папке хранятся миграции для разных версий плагина
);

/**
 * Проверяет совместимость с Wordpress, php и другими плагинами.
 */

$compatibility = new Wbcr_FactoryClearfy_Compatibility( array_merge( $plugin_info, array(
	'factory_version'                  => 'FACTORY_409_VERSION',
	'plugin_already_activate'          => defined( 'WMAC_PLUGIN_ACTIVE' ),
	'plugin_as_component'              => defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ),
	'plugin_dir'                       => WMAC_PLUGIN_DIR,
	'plugin_base'                      => WMAC_PLUGIN_BASE,
	'plugin_url'                       => WMAC_PLUGIN_URL,
	'required_php_version'             => '5.4',
	'required_wp_version'              => '4.2.0',
	'required_clearfy_check_component' => true
) ) );

/**
 * Если плагин совместим, то он продолжит свою работу, иначе будет остановлен,
 * а пользователь получит предупреждение.
 */
if ( ! $compatibility->check() ) {
	return;
}

// Устанавливаем контстанту, что плагин уже используется
define( 'WMAC_PLUGIN_ACTIVE', true );

// Этот плагин может быть аддоном плагина Clearfy, если он загружен, как аддон, то мы не подключаем фреймворк,
// а наследуем функции фреймворка от плагина Clearfy. Если плагин скомпилирован, как отдельный плагин, то он использует собственный фреймворк для работы.
// Константа LOADING_MINIFY_AND_COMBINE_AS_ADDON утсанавливается в классе libs/factory/core/includes/Wbcr_Factory409_Plugin

if ( ! defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ) ) {
	// Фреймворк - отвечает за интерфейс, содержит общие функции для серии плагинов и готовые шаблоны для быстрого развертывания плагина.
	require_once( WMAC_PLUGIN_DIR . '/libs/factory/core/boot.php' );
}

// Основной класс плагина
require_once( WMAC_PLUGIN_DIR . '/includes/class.plugin.php' );

// Класс WMAC_Plugin создается только, если этот плагин работает, как самостоятельный плагин.
// Если плагин работает, как аддон, то класс создается родительским плагином.

if ( ! defined( 'LOADING_MINIFY_AND_COMBINE_AS_ADDON' ) ) {
	new WMAC_Plugin( __FILE__, $plugin_info );
}

