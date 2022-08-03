<?php
/**
 * Plugin Name: Disable Admin Notices Individually
 * Plugin URI: https://clearfy.pro/disable-admin-notices
 * Description: Disable admin notices plugin gives you the option to hide updates warnings and inline notices in the admin panel.
 * Author: Creative Motion <info@cm-wp.com>
 * Version: 1.3.0
 * Text Domain: disable-admin-notices
 * Domain Path: /languages/
 * Author URI: https://webcraftic.com
 * Framework Version: FACTORY_456_VERSION
 */

/**
 * Developers who contributions in the development plugin:
 *
 * Alexander Kovalev
 * ---------------------------------------------------------------------------------
 * Full plugin development.
 *
 * Email:         alex.kovalevv@gmail.com
 * Personal card: https://alexkovalevv.github.io
 * Personal repo: https://github.com/alexkovalevv
 * ---------------------------------------------------------------------------------
 *
 * Artem Prihodko
 * ---------------------------------------------------------------------------------
 * Updates and fixes
 *
 * Email:  webtemyk@yandex.ru
 * GitHub: https://github.com/temyk
 * ---------------------------------------------------------------------------------
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * -----------------------------------------------------------------------------
 * CHECK REQUIREMENTS
 * Check compatibility with php and wp version of the user's site. As well as checking
 * compatibility with other plugins from Webcraftic.
 * -----------------------------------------------------------------------------
 */

require_once( dirname( __FILE__ ) . '/libs/factory/core/includes/class-factory-requirements.php' );

// @formatter:off
$wdan_plugin_info = array(
	'prefix'               => 'wbcr_dan_',
	'plugin_name'          => 'wbcr_dan',
	'plugin_title'         => __( 'Webcraftic disable admin notices', 'disable-admin-notices' ),

	// PLUGIN SUPPORT
	'support_details'      => array(
		'url'       => 'https://clearfy.pro/',
		'pages_map' => array(
			'support' => 'support', // {site}/support
			'docs'    => 'docs',     // {site}/docs,
			'pricing' => 'disable-admin-notices'
		)
	),
	// PLUGIN PREMIUM SETTINGS
	'has_premium'          => true,
	'license_settings'     => array(
		'provider'         => 'freemius',
		'slug'             => 'disable-admin-notices-premium',
		'plugin_id'        => '6456',
		'public_key'       => 'pk_0570ec3c1b4100b9c9a0cbfe80f9f',
		'price'            => 29,
		'has_updates'      => true,
		'updates_settings' => array(
			'maybe_rollback'    => true,
			'rollback_settings' => array(
				'prev_stable_version' => '0.0.0'
			)
		)
	),

	// PLUGIN SUBSCRIBE FORM
	'subscribe_widget'     => true,
	'subscribe_settings'   => [ 'group_id' => '105407140' ],

	// PLUGIN ADVERTS
	'render_adverts'       => true,
	'adverts_settings'     => array(
		'dashboard_widget' => false, // show dashboard widget (default: false)
		'right_sidebar'    => true, // show adverts sidebar (default: false)
		'notice'           => false, // show notice message (default: false)
	),

	// FRAMEWORK MODULES
	'load_factory_modules' => array(
		array( 'libs/factory/bootstrap', 'factory_bootstrap_457', 'admin' ),
		array( 'libs/factory/forms', 'factory_forms_453', 'admin' ),
		array( 'libs/factory/pages', 'factory_pages_455', 'admin' ),
		array( 'libs/factory/templates', 'factory_templates_108', 'all' ),
		array( 'libs/factory/freemius', 'factory_freemius_143', 'all' ),
		array( 'libs/factory/adverts', 'factory_adverts_133', 'admin' ),
		//array('libs/factory/logger', 'factory_logger_121', 'all')
	)
);

$wdan_compatibility = new Wbcr_Factory456_Requirements( __FILE__, array_merge( $wdan_plugin_info, array(
	'plugin_already_activate'          => defined( 'WDN_PLUGIN_ACTIVE' ),
	'required_php_version'             => '7.0',
	'required_wp_version'              => '4.8.0',
	'required_clearfy_check_component' => false
) ) );



/**
 * If the plugin is compatible, then it will continue its work, otherwise it will be stopped,
 * and the user will throw a warning.
 */
if ( ! $wdan_compatibility->check() ) {
	return;
}

/**
 * -----------------------------------------------------------------------------
 * CONSTANTS
 * Install frequently used constants and constants for debugging, which will be
 * removed after compiling the plugin.
 * -----------------------------------------------------------------------------
 */

// This plugin is activated
define( 'WDN_PLUGIN_ACTIVE', true );
define( 'WDN_PLUGIN_VERSION', $wdan_compatibility->get_plugin_version() );
define( 'WDN_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'WDN_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'WDN_PLUGIN_URL', plugins_url( null, __FILE__ ) );



/**
 * -----------------------------------------------------------------------------
 * PLUGIN INIT
 * -----------------------------------------------------------------------------
 */

require_once( WDN_PLUGIN_DIR . '/libs/factory/core/boot.php' );
require_once( WDN_PLUGIN_DIR . '/includes/functions.php' );
require_once( WDN_PLUGIN_DIR . '/includes/class-plugin.php' );

try {
	new WDN_Plugin( __FILE__, array_merge( $wdan_plugin_info, array(
		'plugin_version'     => WDN_PLUGIN_VERSION,
		'plugin_text_domain' => $wdan_compatibility->get_text_domain(),
	) ) );
} catch ( Exception $e ) {
	// Plugin wasn't initialized due to an error
	define( 'WDN_PLUGIN_THROW_ERROR', true );

	$wdan_plugin_error_func = function () use ( $e ) {
		$error = sprintf( "The %s plugin has stopped. <b>Error:</b> %s Code: %s", 'Disable Admin Notices', $e->getMessage(), $e->getCode() );
		echo '<div class="notice notice-error"><p>' . $error . '</p></div>';
	};

	add_action( 'admin_notices', $wdan_plugin_error_func );
	add_action( 'network_admin_notices', $wdan_plugin_error_func );
}
// @formatter:on